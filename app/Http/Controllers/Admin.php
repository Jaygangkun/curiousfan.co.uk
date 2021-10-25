<?php

namespace App\Http\Controllers;

use App\EmailTemplate;
use App\Navi;
use App\Page;
use App\Post;
use App\Tips;
use App\User;
use App\Banned;
use App\Report;
use App\Unlock;
use App\Invoice;
use App\Options;
use App\Profile;
use App\Category;
use App\Withdraw;
use App\ReportUser;
use App\BecomeCreatorRequest;
use Carbon\Carbon;
use App\Subscription;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use PhpOption\Option;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Rules\CheckIfFavicon;
use App\Mail\ProfileRejectedMail;
use App\Mail\ProfileVerifiedMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentRequestProcessed;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Stripe\Subscription as StripeSubscription;
use App\WebsiteMessageCenter;

use App\Notifications\ProfileApprovedNotification;
use App\Notifications\ProfileRejectedNotification;
use App\Notifications\AdminNotify;

class Admin extends Controller
{

    // GET|POST /admin/login
    public function login()
    {

        $message = '';

        if (\Request::isMethod('post')) {

            $credentials = [
                'email' => request('ausername'),
                'password' => request('apassword')
            ];


            if (\Auth::attempt($credentials)) {

                // get current user info
                $user = auth()->user();

                if ($user->isAdmin == 'Yes') {

                    return redirect('admin');
                } else {

                    $message = 'Invalid admin login.';
                }
            } else {

                $message = 'Invalid login.';
            }
        }

        return view('admin-login')->with('message', $message);
    }

    // GET /admin/logout
    public function logout()
    {
        \Session::forget('admin');
        auth()->logout();
        return redirect('/admin/login');
    }

    // GET /admin/config-logins
    public function configLogins()
    {

        return view('admin.config-logins')->with('active', 'admin-login');
    }

    // POST /admin/save-logins 
    public function saveLogins(Request $r)
    {

        $this->validate($r, [
            'admin_user' => 'required|email',
            'admin_pass' => 'required|confirmed'
        ]);

        $user = auth()->user()->id;
        $user = User::findOrFail($user);

        $user->email = $r->admin_user;
        $user->password = \Hash::make($r->admin_pass);
        $user->save();

        return back()->with('msg', 'Successfully updated admin user details.');
    }

    public function dashboard()
    {

        // get all creators
        $allCreators = Profile::where('isVerified', 'Yes')->count();

        // get total users
        $allUsers = User::orderBy('id', 'DESC')->count();

        // get total paying subscribers
        $payingFans = User::whereHas('subscriptions', function ($q) {
            return $q->where('subscription_expires', '>=', now());
        })->count();

        // get total tips
        $totalTips = Tips::where('payment_status', 'Paid')->count();

        // get start of month
        $startOfMonth = Carbon::now()->startOfMonth();

        // get subscription earnings since month start
        $subscrMonthEarnings = Invoice::whereBetween('created_at', [$startOfMonth, now()])
            ->where('payment_status', 'Paid')
            ->sum('amount');

        // get earnings from tips since month start
        $tipsMonthEarnings = Tips::whereBetween('created_at', [$startOfMonth, now()])
            ->where('payment_status', 'Paid')
            ->sum('amount');

        // sum the two
        $monthEarnings = $tipsMonthEarnings + $subscrMonthEarnings;

        // earnings past 30 days
        $date = \Carbon\Carbon::parse('31 days ago');
        $dateRange = \Carbon\CarbonPeriod::create($date, now());
        $earnings = [];
        $tips = [];

        foreach ($dateRange as $d) {
            $earnings[$d->format('Y-m-d')] = [
                'date' => $d->format('Y-m-d'),
                'fansCount' => 0,
                'total' => 0,
                'platform' => 0,
                'creators' => 0,
                'tipsCount' => 0,
                'unlocksCount' => 0
            ];
        }

        // compute subscriptions earnings
        $subscriptionEarnings = Invoice::select(array(
            \DB::raw('DATE(`created_at`) as `date`'),
            \DB::raw('COUNT(`id`) as `fansCount`'),
            \DB::raw('SUM(`amount`) as `total`')
        ))
            ->where('created_at', '>', $date)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();

        // append subscription earnings
        foreach ($subscriptionEarnings as $d) {

            $platform = (opt('payment-settings.site_fee') * $d->total) / 100;
            $creators = $d->total - $platform;

            $earnings[$d->date]['date'] = $d->date;
            $earnings[$d->date]['fansCount'] = $d->fansCount;
            $earnings[$d->date]['total'] = $d->total;
            $earnings[$d->date]['platform'] = number_format($platform, 2);
            $earnings[$d->date]['creators'] = number_format($creators, 2);

        }

        // append tips earnings
        $tipsEarnings = Tips::select(array(
            \DB::raw('DATE(`created_at`) as `date`'),
            \DB::raw('COUNT(`id`) as `tipsCount`'),
            \DB::raw('SUM(`amount`) as `total`')
        ))
            ->where('created_at', '>', $date)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();
        
        // append subscription earnings
        foreach ($tipsEarnings as $d) {

            $platform = (opt('payment-settings.site_fee') * $d->total) / 100;
            $creators = $d->total - $platform;
            $earr = $earnings[$d->date];

            $earnings[$d->date]['date'] = $d->date;
            $earnings[$d->date]['tipsCount'] = $d->tipsCount;
            $earnings[$d->date]['total'] = $earr['total'] + $d->total;
            $earnings[$d->date]['platform'] = number_format($earr['platform']+$platform, 2);
            $earnings[$d->date]['creators'] = number_format($earr['creators']+$creators, 2);

        }

        // append message unlocks earnings
        $unlocksEarnings = Unlock::select(array(
            \DB::raw('DATE(`created_at`) as `date`'),
            \DB::raw('COUNT(`id`) as `unlocksCount`'),
            \DB::raw('SUM(`amount`) as `total`')
        ))
            ->where('created_at', '>', $date)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();
        
        // append subscription earnings
        foreach ($unlocksEarnings as $d) {

            $platform = (opt('payment-settings.site_fee') * $d->total) / 100;
            $creators = $d->total - $platform;
            $earr = $earnings[$d->date];

            $earnings[$d->date]['date'] = $d->date;
            $earnings[$d->date]['unlocksCount'] = $d->unlocksCount;
            $earnings[$d->date]['total'] = $earr['total'] + $d->total;
            $earnings[$d->date]['platform'] = number_format($earr['platform']+$platform, 2);
            $earnings[$d->date]['creators'] = number_format($earr['creators']+$creators, 2);

        }

        // finally, return the view
        return view('admin.dashboard')
            ->with('active', 'dashboard')
            ->with('totalVendors', $allCreators)
            ->with('payingFans', $payingFans)
            ->with('totalTips', $totalTips)
            ->with('totalUsers', $allUsers)
            ->with('monthEarnings', $monthEarnings)
            ->with('earnings', $earnings);
    }

    // transactions
    public function tx()
    {
        $active = 'tx';
        $tx = Invoice::with('subscription.creator', 'subscription.subscriber')
            ->orderByDesc('id')
            ->get();
        return view('admin.tx', compact('tx', 'active'));
    }

    // subscriptions
    public function subscriptions(Request $r)
    {

        if($r->has('delete')) {

            // get subscription info
            $subscr = Subscription::findOrFail($r->delete);

            if($subscr->gateway != 'Admin')
                return back()->with('msg', 'You can only delete subscriptions created by admin, other subscriptions must be canceled by user (or you must login as that user) because it will also remove it from the payment gateway itself, not only database.');

            // delete
            $subscr->delete();

            return back()->with('msg', 'Subscription deleted.');
        }

        $active = 'subscriptions';
        $subscriptions = Subscription::with('creator', 'subscriber')
            ->orderByDesc('id')
            ->whereDate('subscription_expires', '>=', Carbon::now())
            ->get();
        return view('admin.subscriptions', compact('subscriptions', 'active'));
    }

    // tips
    public function tips()
    {
        $active = 'tips';
        $tips = Tips::with('tipper', 'tipped')
            ->orderByDesc('id')
            ->where('payment_status', 'Paid')
            ->get();

        return view('admin.tips', compact('tips', 'active'));
    }

    // message unlocks
    public function unlocks()
    {
        $active = 'unlocks';
        $tips = Unlock::with('tipper', 'tipped')
            ->orderByDesc('id')
            ->where('payment_status', 'Paid')
            ->get();

        return view('admin.unlocks', compact('tips', 'active'));
    }

    // verification requests
    public function profileVerifications()
    {
        $vreq = Profile::where('isVerified', '!=', 'Yes')->where('user_meta', '!=', '')->whereNotNull('user_meta')->with('user')->get();
        //$vreq = Profile::whereNotNull('user_meta')->with('user')->get();
        $active  = 'profile-verifications';

        return view('admin.verification-requests', compact('vreq', 'active'));
    }

    // approve profile
    public function approveProfile(Profile $profile)
    {
        // approve 
        $profile->isVerified = 'Yes';
        $profile->save();

        // delete photo from the cloud for privacy reasons
        /*if (isset($profile->user_meta['verificationDisk'])) {
            $disk = $profile->user_meta['verificationDisk'];
        }else{
            $disk = 'public';
        }

        if (isset($profile->user_meta['id'])) {
            \Storage::disk($disk)->delete($profile->user_meta['id']);
        }*/

		$profile->user->notify(new ProfileApprovedNotification($profile->user));

        $getEmailTemplate = EmailTemplate::findorFail(7);
        $emailSubject = $getEmailTemplate->emailSubject;
        $emailBody = $getEmailTemplate->emailBody;
        $emailBody = str_replace('<a ', '<a class="button button-primary" ', $emailBody);
        $emailBody = str_replace('{APP_NAME}', env('APP_NAME'), $emailBody);
        $emailBody = str_replace('{username}', $profile->user->name, $emailBody);
        $emailBody = str_replace('{profile_link}', route('profile.show', ['username' => $profile->user->profile->username]), $emailBody);
        $emailBody = str_replace('{profile_handle}', $profile->user->profile->handle, $emailBody);

        Mail::to($profile->user)->send(new ProfileVerifiedMail($profile->user, $emailSubject, $emailBody));

        return back()->with('msg', 'Profile approved and user notified by email');
    }

    // reject profile
    public function rejectProfile(Profile $profile)
    {
        // reject
        $profile->isVerified = 'Rejected';
        $profile->save();

		
		//send notification
		$profile->user->notify(new ProfileRejectedNotification($profile->user));
		
        // send email
        $getEmailTemplate = EmailTemplate::findorFail(6);
        $emailSubject = $getEmailTemplate->emailSubject;
        $emailBody = $getEmailTemplate->emailBody;
        $emailBody = str_replace('<a ', '<a class="button button-primary" ', $emailBody);
        $emailBody = str_replace('{APP_NAME}', env('APP_NAME'), $emailBody);
        $emailBody = str_replace('{username}', $profile->user->name, $emailBody);
        $emailBody = str_replace('{profile_link}', route('profile.show', ['username' => $profile->user->profile->username]), $emailBody);
        $emailBody = str_replace('{profile_handle}', $profile->user->profile->handle, $emailBody);
        $emailBody = str_replace('{sending_mail}', env('SENDING_EMAIL'), $emailBody);

        Mail::to($profile->user)->send(new ProfileRejectedMail($profile->user, $emailSubject, $emailBody));

        // return
        return back()->with('msg', 'Profile rejected and user notified by email');
    }

    // users overview
    public function users(Request $r)
    {
        $active = 'users';

        if ($r->has('remove')) {

            if ($r->remove == 22) {
                return back()->with('msg', 'Do not delete the main admin user');
            }


            $user = User::where('id', $r->remove)
                ->whereHas('profile')
                ->orderByDesc('id')
                ->withCount([
                    'subscribers' => function ($q) {
                        return $q->where('subscription_expires', '>=', now());
                    },
                    'subscriptions' => function ($q) {
                        return $q->where('subscription_expires', '>=', now());
                    }
                ])
                ->firstOrFail();

            if ($user->subscribers_count > 0 or $user->subscriptions_count > 0) {
                return back()->with('msg', 'Users having paid subscribers or active subscriptions cannot be deleted.');
            }

            $user->delete();

            return back()->with('msg', 'Succesfully removed all this user data');
        }

        $users = User::whereHas('profile')->orderByDesc('id')
            ->withCount(['subscribers' => function ($q) {
                return $q->where('subscription_expires', '>=', now());
            }, 'followers'])
            ->get();

		foreach($users as $k=>$uSer){
			//checking if users have banned ip
			$ban = Banned::where('ip', $uSer->ip)->get();
		   if ($ban->count()) {
			   $users[$k]->bannedIP = 'YES';
		   }
		}
		
        return view('admin.users', compact('active', 'users'));
    }

    // set admin role
    public function setAdminRole(User $user)
    {
        // set as admin
        $user->isAdmin = 'Yes';
        $user->save();

        return back()->with('msg', 'Successfully added ' . $user->email . ' as an admin');
    }

    // remove admin role
    public function unsetAdminRole(User $user)
    {
        // find if there is any other admin remaining.
        $adminsRemaining = User::where('isAdmin', 'Yes')->where('id', '!=', $user->id)->exists();

        if ($adminsRemaining) {

            $user->isAdmin = 'No';
            $user->save();

            $msg = 'Successfully removed admin role of ' . $user->email;

        }else{

            $msg = 'At all points, there must be at least one admin user on this website.';

        }


        return back()->with('msg', $msg);
    }

    // ban user
    public function banUser(User $user)
    {
        if(auth()->id() == $user->id) {
            return back()->with('msg', 'Do not ban yourself');
        }

        $msg = 'Successfully banned ' . $user->email;

        // set as banned
        $user->isBanned = 'Yes';
        $user->save();

        // if ip is null
        /*if ($user->ip) {

            // add banned ip entry
            $ban = new Banned;
            $ban->ip = $user->ip;
            $ban->save();

            // add ip msg
            $msg .= '. Also banned ip address: ' . $user->ip;

        }*/

        return back()->with('msg', $msg);
    }
	
	public function banUserIP(User $user)
    {
        if(auth()->id() == $user->id) {
            return back()->with('msg', 'Do not ban yourself');
        }

        // set as banned
        //$user->isBanned = 'Yes';
        //$user->save();

        // if ip is null
        if ($user->ip) {
            // add banned ip entry
            $ban = new Banned;
            $ban->ip = $user->ip;
            $ban->save();

            // add ip msg
            //$msg .= '. Also banned ip address: ' . $user->ip;
			$msg = 'Successfully banned ip address: ' . $user->ip;
        }else{
			$msg = 'No IP found to ban for this user.';
		}

        return back()->with('msg', $msg);
    }

    // remove user ban
    public function unbanUser(User $user)
    {
       // set as banned
       $user->isBanned = 'No';
       $user->save();

       // removed banned ip entry
       /*$ban = Banned::where('ip', $user->ip)->get();

       if ($ban->count()) {
           foreach ($ban as $b) {
               $b->delete();
           }
       }*/

       return back()->with('msg', 'Successfully removed ban for ' . $user->email);
    }
	
	// remove user ip ban
    public function unbanUserIP(User $user)
    {
       // set as banned
       //$user->isBanned = 'No';
       //$user->save();

       // removed banned ip entry
       $ban = Banned::where('ip', $user->ip)->get();

       if ($ban->count()) {
           foreach ($ban as $b) {
               $b->delete();
           }
       }

       return back()->with('msg', 'Successfully removed ban for ip address: ' . $user->ip);
    }

    // login as vendor
    public function loginAsVendor($vendorId)
    {

        // get user
        $user = User::findOrFail($vendorId);

        // login
        \Auth::loginUsingId($user->id);

        return redirect('/my-profile');
    }

    // add plan manually
    public function addPlanManually($vendorId)
    {

        // get user
        $user = User::findOrFail($vendorId);

        // get all creators
        // initial query
        $creators = Profile::where('isVerified', 'Yes')
            ->with('category')
            ->withCount('posts', 'followers')
            ->get();

        // active 
        $active = 'vendors';

        return view('admin.add-plan-manually', compact('active', 'user', 'creators'));
    }

    public function addPlanManuallyProcess($vendorId, Request $r)
    {

        $this->validate($r, [
            'creator' => 'exists:users,id',
            'mm'      => 'required|numeric',
            'dd'      => 'required|numeric',
            'yy'      => 'required|numeric'
        ]);

        // compute plan expires
        $planExpires = mktime(0, 0, 0, $r->mm, $r->dd, $r->yy);

        // find fan
        $fan = User::findOrFail($vendorId);


        // add user plan
        $subscription = new Subscription;
        $subscription->creator_id = $r->creator;
        $subscription->subscriber_id = $vendorId;
        $subscription->subscription_id = uniqid();
        $subscription->gateway = 'Admin';
        $subscription->subscription_date = now();
        $subscription->subscription_expires = date('Y-m-d H:i:s', $planExpires);
        $subscription->status = 'Active';
        $subscription->subscription_price = 0.00;
        $subscription->creator_amount = 0.00;
        $subscription->admin_amount = 0.00;
        $subscription->save();

        return redirect('admin/users')->with('msg', $fan->name . ' plan successfully updated');
    }

    // payment requetss
    public function paymentRequests()
    {

        $active = 'payment-requests';
        $reqs = Withdraw::with('user')->where('status', 'Pending')->get();

        return view('admin.payment-requests', compact('active', 'reqs'));
    }

    // approve payment request
    public function markPaymentRequestAsPaid(Withdraw $withdraw)
    {

        // mark withdrawal as paid
        $withdraw->status = 'Paid';
        $withdraw->save();

        // subtract the balance
        $withdraw->user->balance -= $withdraw->amount;
        $withdraw->user->save();

        $getEmailTemplate = EmailTemplate::findorFail(5);
        $emailSubject = $getEmailTemplate->emailSubject;
        $emailBody = $getEmailTemplate->emailBody;
        $emailBody = str_replace('<a ', '<a class="button button-primary" ', $emailBody);
        $emailBody = str_replace('{APP_NAME}', env('APP_NAME'), $emailBody);
        $emailBody = str_replace('{withdraw_username}', $withdraw->user->name, $emailBody);
        $emailBody = str_replace('{withdraw_amount}', opt('payment-settings.currency_symbol') .  $withdraw->amount, $emailBody);
        $emailBody = str_replace('{withdraw_payout_gateway}', $withdraw->user->profile->payout_gateway, $emailBody);
        $payout_details = str_replace('\n', '<br>', nl2br(e($withdraw->user->profile->payout_details)));
        $payout_details = str_replace(':', ':<br>', $payout_details);
        $emailBody = str_replace('{withdraw_payout_details}', $payout_details, $emailBody);

        // email the happy creator
        Mail::to($withdraw->user)->send(new PaymentRequestProcessed($withdraw, $emailSubject, $emailBody));

        return back()->with('msg', 'Payment request marked as Paid and user notified by email!');
    }

    // categories
    public function categories_overview()
    {

        // if remove
        if ($removeId = \Input::get('remove')) {

            // does this category contain creators?
            $hasCreators = Profile::where('category_id', $removeId)->count();

            if ($hasCreators != 0) {
                return redirect('admin/categories')->with('msg', 'Sorry, this category contains creators. You can only remove categories that have 0 creators using it.');
            }

            // remove from db
            $d = Category::findOrFail($removeId);
            $d->delete();

            return redirect('admin/categories')->with('msg', 'Successfully removed category');
        }


        // if update
        $catname = '';
        $catID = '';
        if ($updateCat = \Input::get('update')) {

            // find category
            $c = Category::findOrFail($updateCat);
            $catname = $c->category;
            $catID = $c->id;
        }

        $categories = Category::withCount('profile')->orderBy('category')->get();

        return view('admin.categories')
            ->with('active', 'categories')
            ->with('categories', $categories)
            ->with('catname', $catname)
            ->with('catID', $catID);
    }

    // add category
    public function add_category(Request $r)
    {

        $this->validate($r, ['catname' => 'required']);

        $c = new Category;
        $c->category = $r->catname;
        $c->save();

        return redirect('admin/categories')->with('msg', 'Category successfully created.');
    }

    // update category
    public function update_category(Request $r)
    {

        $this->validate($r, ['catname' => 'required']);

        $c = Category::findOrFail($r->catID);
        $c->category = $r->catname;
        $c->save();

        return redirect('admin/categories')->with('msg', 'Category successfully updated.');
    }
    
    // notifications controller
    public function notifications(){
        
        $active = 'notifications';
        $users = User::select('id', 'name', 'email', 'isAdmin')->orderByDesc('name')->get();
        
        return view('admin.notifications', compact('active', 'users'));
    }

    // send notification
    public function send_notification(Request $r)
    {
        
        $this->validate($r, [
            'notification_title' => 'required',
            'notification_content' => 'required',
            'target_type'       => 'required'
        ],['target_type.required' => 'Please select notification user.']);
        
        if( $r->target_type == 1 ){
            // get all user list
            $users = User::select('id', 'name', 'email', 'isAdmin')->orderByDesc('name')->get();
            
            // send message to all users
            foreach( $users as $u ){
                $user = User::findOrFail($u->id);
                $adminnotifyEvent = ['user' => auth()->user()->profile->username, 'title' => $r->notification_title, 'msg' => $r->notification_content];
                $user->notify(new AdminNotify($adminnotifyEvent));
            }
        }else{
            // get user
            $user = User::findOrFail($r->user);
            
            // build admin message contents
            $adminnotifyEvent = ['user' => auth()->user()->profile->username, 'title' => $r->notification_title, 'msg' => $r->notification_content];
    
            // send notification
            $user->notify(new AdminNotify($adminnotifyEvent));
        }
        
        return redirect()->route('admin-notification')->with('msg', 'Notification Sent Successfully.'); 
    }
    

    // pages controller
    public function pages()
    {

        // get existent pages
        $pages = Page::all();

        return view('admin.pages')->with('pages', $pages)
            ->with('active', 'pages');
    }

    // create a page
    public function create_page(Request $r)
    {

        // validate form entries
        $this->validate($r, ['page_title' => 'unique:pages|required']);

        // save page
        $page = new Page;
        $page->page_title = $r->page_title;
        $page->page_slug  = str_slug($r->page_title);
        $page->page_content = $r->page_content;
        $page->save();

        return redirect()->route('admin-cms')->with('msg', 'Page successfully created');
    }

    // update page
    public function showUpdatePage($page)
    {
        $page = Page::find($page);
        return view('admin.update-page')->with('p', $page)->with('active', 'pages');
    }

    // update page processing
    public function processUpdatePage($page, Request $r)
    {
        $page = Page::find($page);
        $page->page_title = $r->page_title;
        $page->page_content = $r->page_content;
        $page->save();

        return redirect('admin/cms-edit/' . $page->id)->with('msg', 'Page successfully updated.');
    }

    // delete page
    public function deletePage($page)
    {
        $page = Page::find($page);
        $page->delete();
        return redirect()->route('admin-cms')->with('msg', 'Page successfully deleted.');
    }


    // appearance setup
    public function appearance()
    {
        return view('admin.appearance')->with('active', 'appearance');
    }

    // payments and pricing setup
    public function paymentsSetup()
    {
        return view('admin.payments-setup')->with('active', 'payments');
    }

    // payments and pricing setup
    public function paymentsSetupProcess()
    {

        $options = request()->except('_token', 'sb_settings');

        // save options
        foreach ($options as $name => $value) {
            if ($name == 'payment-settings_currency_symbol')
                $name = 'payment-settings.currency_symbol';
            elseif ($name == 'payment-settings_currency_code')
                $name = 'payment-settings.currency_code';
            elseif ($name == 'payment-settings_site_fee')
                $name = 'payment-settings.site_fee';
            else
                $name = $name;

            Options::update_option($name, $value);
        }

        return redirect('admin/payments-settings')->with('msg', 'Payments settings successfully saved!');
    }

    // general configuration
    public function configuration()
    {
        $categories = Category::withCount('profile')->orderBy('category')->get();
        return view('admin.configuration',compact('categories'))->with('active', 'config');
    }

    // process configuration changes
    public function configurationProcess(Request $r)
    {
        $options = $r->except([
            '_token',
            'sb_settings',
            'admin_current_pass',
            'admin_new_pass',
            'site_favico'
        ]);

        // save options
        foreach ($options as $name => $value) {
            Options::update_option($name, $value);
        }
        //Update hide_creator_types

        //$typesValues = json_encode()

        // homepage image updated?
        if ($r->hasFile('homepage_header_image')) {

            // validate image
            $this->validate($r, ['homepage_header_image' => 'required|image']);

            // get extension
            $ext = $r->file('homepage_header_image')->getClientOriginalExtension();

            // set destination
            $destinationPath = base_path() . '/images/';

            // compute a random file name
            $fileName = uniqid(rand()) . '.' . $ext;

            // upload
            $r->file('homepage_header_image')->move($destinationPath, $fileName);

            // update option
            Options::update_option('homepage_header_image', '/images/' . $fileName);
        }

        // site logo updated?
        if ($r->hasFile('site_logo')) {

            // validate image
            $this->validate($r, ['site_logo' => 'required|image']);

            // get extension
            $ext = $r->file('site_logo')->getClientOriginalExtension();

            // set destination
            $destinationPath = base_path() . '/images/';

            // set random file name
            $fileName = uniqid(rand()) . '.' . $ext;

            // upload the logo
            $r->file('site_logo')->move($destinationPath, $fileName);

            // update option
            Options::update_option('site_logo', '/images/' . $fileName);
        }
        // Form logo updated?
        if ($r->hasFile('form_logo')) {

            // validate image
            $this->validate($r, ['form_logo' => 'required|image']);

            // get extension
            $ext = $r->file('form_logo')->getClientOriginalExtension();

            // set destination
            $destinationPath = base_path() . '/images/';

            // set random file name
            $fileName = uniqid(rand()) . '.' . $ext;

            // upload the logo
            $r->file('form_logo')->move($destinationPath, $fileName);

            // update option
            Options::update_option('form_logo', '/images/' . $fileName);
        }

        // favico updated?
        if ($r->hasFile('site_favico')) {

            // validate favicon
            $this->validate($r, ['site_favico' => 'required|image']);

            // get extension
            $ext = $r->file('site_favico')->getClientOriginalExtension();

            // set destination
            $destinationPath = base_path() . '/images/';

            // set random file name
            $fileName = uniqid(rand()) . '.' . $ext;

            // upload the logo
            $r->file('site_favico')->move($destinationPath, $fileName);


            // update option
            Options::update_option('favicon', '/images/' . $fileName);
        }

        return redirect('admin/configuration')->with('msg', 'Configuration settings successfully saved!');
    }

    // extra CSS / JS
    public function extraCSSJS()
    {
        $active = 'cssjs';

        return view('admin.cssjs', compact('active'));
    }


    // save extra css/js
    public function saveExtraCSSJS(Request $r)
    {
        Options::update_option('admin_extra_CSS', $r->admin_extra_CSS);
        Options::update_option('admin_extra_JS', $r->admin_extra_JS);
        Options::update_option('admin_raw_JS', $r->admin_raw_JS);

        return back()->with('msg', 'Successfully updated extra CSS/JS');
    }

    // mail configuration
    public function mailconfiguration()
    {
        return view('admin/mail-configuration', ['active' => 'mailconfig']);
    }

    // update mail configuration
    public function updateMailConfiguration(Request $r)
    {

        try {

            $i = $r->except(['sb_settings', '_token']);

            foreach ($i as $k => $v) {
                $this->__setEnvironmentValue($k, $v);
            }

            $msg = 'Mail Configuration settings successfully saved!';
        } catch (\Exception $e) {

            $msg = $e->getMessage();
        }

        return redirect('admin/mailconfiguration')->with('msg', $msg);
    }

    // mail test
    public function mailtest()
    {

        try {

            $data['message'] = 'This is a test email to check your mail server configuration.';

            $data['intromessage'] = 'Mail Server Configuration';
            $data['url'] = env('APP_URL') . '/admin/mailconfiguration';
            $data['buttonText'] = 'See Mail Configuration';

            $adminEmail = Options::get_option('admin_email');


            \Mail::send('emails.test-email', ['data' => $data], function ($m) use ($adminEmail, $data) {
                $m->from(env('SENDING_EMAIL'), env('APP_NAME'));
                $m->to($adminEmail);
                $m->subject('Email Configuration Test');
            });

            return redirect('admin/mailconfiguration')->with('msg', 'Mail sent to your server, it is up to them to deliver it now.');
        } catch (\Exception $e) {
            return redirect('admin/mailconfiguration')->with('msg', $e->getMessage());
        }
    }

    // set .env values
    private function __setEnvironmentValue($envKey, $envValue)
    {

        $configFile = base_path('config.inc.php');

        if (!is_writable($configFile))
            throw new \Exception('Sorry, ' . $confiFile . ' is not writable, you will unfortunately have to add the mail server configuration using the text editor, or make file writable by CHMOD 0755.');

        $str = file_get_contents($configFile);

        $regex = "/define\('" . $envKey . "',\s?'([^']*)'\)/is";
        $str = preg_replace($regex, "define('" . $envKey . "', '" . $envValue . "')", $str);

        $fp = fopen($configFile, 'w');
        $didWrite =  fwrite($fp, $str);
        fclose($fp);

        return $didWrite;
    }


    // show cloud settings page
    public function cloudSettings()
    {
        $active = 'cloud';
        return view('admin.cloud-settings', compact('active'));
    }

    // save cloud settings 
    public function saveCloudSettings(Request $r)
    {
        $options = $r->except([
            '_token', 'sb_settings',
        ]);

        // save options
        foreach ($options as $name => $value) {
            Options::update_option($name, $value);
        }

        return back()->with('msg', 'Cloud storage settings successfully saved');
    }

    // content moderation
    public function moderateContent($content_type, Request $r)
    {

        if($r->has('delete')) {

            // get post
            $id = $r->delete;
            $post = Post::findOrFail($id);

            // delete from disk
            $mediaType = $post->media_type;
            $mediaFile = $post->media_content;

            if($post->disk != 'backblaze')
                Storage::disk($post->disk)->delete($mediaFile);

            $post->comments()->delete();
            $post->likes()->delete();
            $post->delete();

            return back()->with('msg', 'Post successfully removed!');

        }

        $active = 'moderation';
        $reports = Report::orderByDesc('id')->get();

        // get contents
        $contents = Post::where('media_type', $content_type)
                        ->orderByDesc('id')
                        ->paginate(20);

        // counts
        $imageCounts = Post::where('media_type', 'Image')->count();
        $textCounts = Post::where('media_type', 'None')->count();
        $audioCounts = Post::where('media_type', 'Audio')->count();
        $videoCounts = Post::where('media_type', 'Video')->count();
        $zipCounts = Post::where('media_type', 'ZIP')->count();

        $counts = [
                    'image' => $imageCounts, 
                    'text' => $textCounts, 
                    'audio' => $audioCounts, 
                    'video' => $videoCounts,
                    'zip' => $zipCounts
                ];

        return view('admin.content-moderation', compact('active', 'reports', 'content_type', 'counts', 'contents'));
        
    }

    // delete content report
    public function deleteContentReport($id)
    {
        Report::findOrFail($id)->delete();
        return back()->with('msg', 'Report successfully removed.');
    }

    // configure entry popup
    public function entryPopup()
    {
        $active = 'popup';
        return view('admin.entry-popup', compact('active'));
    }

    // save entry popup settings
    public function entryPopupSave(Request $r)
    {
        
        $options = request()->except('_token', 'sbPopup');
        
        // save options
        foreach ($options as $name => $value) {
            Options::update_option($name, $value);
        }

        return back()->with('msg', 'Report successfully removed.');

    }

    // manage all alert messages
    public function alertMessage()
    {
        $active = 'alert';
        return view('admin.alert-message', compact('active'));
    }

    // save all alert message
    public function alertMessageSave()
    {
        
    }

    // configure PWA
    public function configurePWA()
    {
        $active = 'pwa-config';
        return view('admin.pwa-config', compact('active'));
    }

    // save PWA Configuration
    public function savePWAConfiguration(Request $r)
    {

        // get all files
        $allFiles = $r->file('files');

        if ($allFiles) {
            foreach ($allFiles as $size => $file) {

                // get icon required dimensions
                $dimensions = explode("x", $size);

                // get width
                $width = $dimensions[0];

                // get height
                $height = $dimensions[1];

                // validate the sizes and "image" type
                $this->validate($r, [ 'files.' . $size => 'image|mimes:png|dimensions:width=' . $width . ',height=' . $height ]);

                // store icon
                $fn = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
                $storeIcon = 'images/icons/' . $fn;
                $file->move(base_path('images/icons'), $fn);

                // set db/cache name
                $optName = 'pwa_' . $size;
                
                // update in db
                Options::update_option($optName, $storeIcon);

                // refresh cache
                Cache::forget($optName);
            }
        }

        // update short name
        Options::update_option('laravel_short_pwa', $r->laravel_short_pwa);

        return back()->with('msg', 'Successfully updated the uploaded items.');

    }

    // earnings simulator config
    public function simulatorConfig()
    {
        
        $active = 'simulator-config';

        return view('admin.simulator-config', compact('active'));
        

    }

    // store earnings simulator configuration
    public function saveSimulatorConfig()
    {
        $options = request()->except('_token', 'sb');
        
        // save options
        foreach ($options as $name => $value) {
            Options::update_option($name, $value);
        }

        return back()->with('msg', 'Simulator Configuration Successfully Saved.');
    }
    public function websiteMessageList(){
        $listMsg = WebsiteMessageCenter::all();
        $name = '';
        $ID = '';
        $msg = '';
        $status = '';
        if ($updateMsg = \Input::get('update')) {

            // find category
            $m = WebsiteMessageCenter::findOrFail($updateMsg);
            $name = $m->name;
            $ID = $m->id;
            $status = $m->status;
            $msg = $m->msg;
        }
        return view('admin.website-messages')
            ->with('active', 'website-messages')
            ->with('messages', $listMsg)
            ->with('name', $name)
            ->with('msg', $msg)
            ->with('status', $status)
            ->with('msgID', $ID);
        //return view('admin.website-messages', compact('listMsg'));
    }
    public function addWebsiteMessages(){}
    public function updateWebsiteMessages(Request $r){
        $this->validate($r, ['name' => 'required']);
        $this->validate($r, ['msg' => 'required']);

        $c = WebsiteMessageCenter::findOrFail($r->id);
        $c->name = $r->name;
        $c->msg = $r->msg;
        $c->status = $r->status;
        $c->save();

        return redirect('admin/website-messages')->with('msg', 'Message successfully updated.');
    }
    public function newVerification(User $user){
        $countries = \Lang::get('country');
        $p = $user->profile;
        $user_meta = $p->user_meta;
        return view('admin.new-verification', compact('user', 'countries','p','user_meta'));
    }
    public function verifyByAdmin(Request $r, User $user){
        $this->validate($r, [
            'country' => 'required|min:2',
            'city' => 'required|min:2',
            'address' => 'required|min:5',
            'idUpload' => 'required|image'
        ]);

        // set id upload
        $idUpload = $r->file('idUpload');

        // store id picture
        $storePic = $idUpload->storePublicly('verification', env('DEFAULT_STORAGE'));

        // build user meta
        $userMeta['country'] = $r->country;
        $userMeta['city'] = $r->city;
        $userMeta['address'] = $r->address;
        $userMeta['id'] = $storePic;
        $userMeta['verificationDisk'] = env('DEFAULT_STORAGE');

        // fetch profile
        $p = $user->profile;

        // append user meta
        $p->user_meta = $userMeta;
        $p->isVerified = 'Yes';
        $p->save();
        return redirect('admin/users')->with('msg', 'Account Verified.');
    }
    public function verifyEmailByAdmin(User $user){
        $user->email_verified_at = NOW();
        $user->save();
        return redirect('admin/users')->with('msg', 'Email: ' . $user->email .' is Verified.');
    }
    //Admin User Functions
    public function newUserByAdmin(){
        $userEdit = false;
        return view('admin.user-action', compact('userEdit'));
        //return view('admin.add-new-user', compact('user', 'countries','p','user_meta'));
    }
    public function addUserByAdmin(Request $r){
        
        /* ADDED BY YARO START 10.7
           CHECING email exists
        */
        $user = User::where('email', $r->email_address)->first();
        if($user != null){
            $msg = 'User Email already existed!';
            return back()->with('msg', $msg);
        }

        /* END*/
        
        // get reserved usernames

        $customData['subscribers'] = $r->subscriber;
        $customData['fans'] = $r->fans;
        $customData['admin_note'] = $r->profile_note;

        $newUser = User::create([
            'name' => $r->name,
            'email' => $r->email_address,
            'isCreating' => $r->isCreating,
            'password' => Hash::make($r->password),
            'ip' => request()->ip()
        ]);
        $p = new \App\Profile;
        // update profile
        $p->user_id = $newUser->id;
        $p->username = str_replace(' ', '-', $r->name) . $newUser->id;
        $p->category_id = $r->category;
        $p->name = $r->name;
        $p->creating = $r->creates;
        $p->fbUrl = $r->fbUrl;
        $p->twUrl = $r->twUrl;
        $p->ytUrl = $r->ytUrl;
        $p->twitchUrl = $r->twitchUrl;
        $p->instaUrl = $r->instaUrl;
        $p->isVerified = 'No';
        $p->custom_data = json_encode($customData);
        $p->profilePic = 'profilePics/default-profile-pic.png';
        $p->save();

        // if cover image uploaded
        if ($r->hasFile('coverPic')) {

            // set cover pic
            $coverPic = $r->file('coverPic');

            // validate as an image
            $this->validate($r, ['coverPic' => 'required|image|dimensions:min_width=960,min_height=280']);

            // store cover pic
            $storePic = Storage::putFile('coverPics', $coverPic, 'public');

            // update cover pic
            $p->coverPic = $storePic;
            $p->save();
        }

        // if profile image uploaded
        if ($r->hasFile('profilePic')) {

            // set profile pic
            $profilePic = $r->file('profilePic');

            // validate as an image
            $this->validate($r, ['profilePic' => 'required|image|dimensions:min_width=200,min_height=200']);

            // store profile pic
            $storePic = Storage::putFile('profilePics', $profilePic, 'public');

            // update profile pic
            $p->profilePic = $storePic;
            $p->save();
        }


        $msg = 'Successfully Created.';
        return back()->with('msg', $msg);
    }
    public function viewUserByAdmin(User $user){
        $userEdit = true;
        $editUser = $user;
        $profileData = Profile::where('user_id', $user->id)
            ->withCount(['fans' => function ($q) {
                $q->where('subscriptions.subscription_expires', '>=', now());
            }])
            ->firstOrFail();
        //$custom_data = json_decode($user->profile()->custom_data);
        return view('admin.user-action', compact('editUser', 'userEdit', 'profileData'));
    }
    public function editUserByAdmin(Request $r, User $user){

        $user->name = $r->name;
        $user->email = $r->email_address;
        $user->isCreating = $r->isCreating;
        if($r->password && !empty($r->password) && $r->password == $r->password1) {
            $user->password = Hash::make($r->password);
        }
        $user->save();

        $customData['subscribers'] = $r->subscriber;
        $customData['fans'] = $r->fans;
        $customData['admin_note'] = $r->profile_note;

        if (!$p = \App\Profile::where('user_id', $r->user_id)->first())
            $p = new \App\Profile;
        $p->user_id = $r->user_id;
        $p->category_id = $r->category;
        $p->name = $r->name;
        $p->creating = $r->creates;
        $p->fbUrl = $r->fbUrl;
        $p->twUrl = $r->twUrl;
        $p->ytUrl = $r->ytUrl;
        $p->twitchUrl = $r->twitchUrl;
        $p->instaUrl = $r->instaUrl;
        $p->custom_data = json_encode($customData);
        $p->save();

        // if cover image uploaded
        if ($r->hasFile('coverPic')) {

            // set cover pic
            $coverPic = $r->file('coverPic');

            // validate as an image
            $this->validate($r, ['coverPic' => 'required|image|dimensions:min_width=960,min_height=280']);

            // store cover pic
            $storePic = Storage::putFile('coverPics', $coverPic, 'public');

            // update cover pic
            $p->coverPic = $storePic;
            $p->save();
        }

        // if profile image uploaded
        if ($r->hasFile('profilePic')) {

            // set profile pic
            $profilePic = $r->file('profilePic');

            // validate as an image
            $this->validate($r, ['profilePic' => 'required|image|dimensions:min_width=200,min_height=200']);

            // store profile pic
            $storePic = Storage::putFile('profilePics', $profilePic, 'public');

            // update profile pic
            $p->profilePic = $storePic;
            $p->save();
        }


        $msg = 'Successfully Updated User';
        return back()->with('msg', $msg);
    }

    public function reportUsers(Request $r){
        $active = 'block-report-users';

        $reportUsers = ReportUser::with('user')->with('reported_user')->get();
        		
        return view('admin.block-report-users', compact('active', 'reportUsers'));
    }

    public function destroyReportUser($id)
    {
        $e = ReportUser::find($id);
        $e->delete();
        return redirect('admin/block-report-users')->with('msg', 'Report data deleted.');
    }

    public function becomeCreatorRequests(Request $r){
        $active = 'become-creator-requests';

        $becomeCreatorRequests = BecomeCreatorRequest::with('user')->get();
        		
        return view('admin.become-creator-requests', compact('active', 'becomeCreatorRequests'));
    }

    public function becomeCreatorRequestApprove(Request $r) {
        
        $user = User::where('id', $r->userId)->first();
        if($user) {
            $user->isCreating = 'Yes';
            $user->save();

            $becomeCreatorRequest = BecomeCreatorRequest::where('id', $r->requestId)->first();
            if ($becomeCreatorRequest) {
                $becomeCreatorRequest->update(['approved' => 'Yes']);

                return response()->json(['success' => true]);
            }
        }
        
        return response()->json(['success' => false]);
    }

    public function becomeCreatorRequestDecline(Request $r) {
        
        $user = User::where('id', $r->userId)->first();
        if($user) {
            $user->isCreating = 'No';
            $user->save();

            $becomeCreatorRequest = BecomeCreatorRequest::where('id', $r->requestId)->first();
            if ($becomeCreatorRequest) {
                $becomeCreatorRequest->update(['approved' => 'No']);

                return response()->json(['success' => true]);
            }
        }
        
        return response()->json(['success' => false]);
    }
}
