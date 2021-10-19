<?php
namespace App\Http\Controllers;
use Alert;
use App\EmailTemplate;
use App\User;
use App\Profile;
use App\ReportUser;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\VerificationRequestedEmail;

class ProfileController extends Controller
{
    // auth middleware
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['showProfile', 'ajaxFeedForProfile']]);
    }
    // GET /{username}
    // @route( 'profile.show' )
    public function showProfile($username)
    {
        // redirect to login if setting says No
        if(opt('allow_guest_profile_view', 'Yes') == 'No' && !auth()->check())
            return redirect(route('login'));
            
        // profile fields
        $profileFields = [
            'id', 'name', 'user_id', 'username', 'creating', 'profilePic',
            'coverPic', 'isVerified', 'isFeatured',
            'fbUrl', 'twUrl', 'ytUrl', 'twUrl', 'ytUrl', 'twitchUrl', 'instaUrl',
            'monthlyFee', 'minTip', 'discountedFee'
        ];
        // find this user profile
        $profile = Profile::where('username', $username)
            ->withCount(['fans' => function ($q) {
                $q->where('subscriptions.subscription_expires', '>=', now());
            }])
            ->firstOrFail();
        // find posts for this handle
        $feed = $profile->posts()
            ->with(['profile' => function ($q) use ($profileFields) {
                $q->select($profileFields);
            }])
            ->orderBy('posts.id', 'DESC')
            ->take(opt('feedPerPage', 10))
            ->get();
        //$currentUser = $this->isCurrentUser();

        // check if this user is blocked
        if($report = ReportUser::where('user_id', $profile->user_id)->where('reported_by', auth()->user()->id)->first()){
            alert()->error(__('profile.blockedUserProfile'))->autoclose(10000);;
            return back();
        }

        return view('profile/user-profile', compact('profile', 'feed'));
    }

    public function ajaxFeedForProfile(Profile $profile, $lastId = null)
    {

        // find posts for this handle
        $feed = $profile->posts()
            ->with('profile')
            ->orderBy('posts.id', 'DESC')
            ->take(opt('feedPerPage', 10));

        if (!is_null($lastId))
            $feed->where('id', '<', $lastId);

        $feed = $feed->get();

        if (!$feed->count()) {

            return response()->json(['view' => '', 'lastId' => 0]);
        }

        $view = view('posts.ajax-feed', compact('feed'));
        $lastId = $feed->last()->id;

        return response()->json(['view' => $view->render(), 'lastId' => $lastId]);
    }

    // GET /my-profile
    // @route( 'startMyPage' )
    public function create()
    {

        // get categories
        $category = '';

        // get this user profile if it exists
        $p = auth()->user()->profile;

        // get all categories
        $categories = [];

        // set active
        $active = 'my-profile';

        // set user category
        $userCategory = $p->category->id;

        return view('profile.create', compact('categories', 'p', 'userCategory', 'active'));
    }

    // POST /profile/update
    // @route( 'storeMyPage' )
    public function store(Request $r)
    {

        // get reserved usernames
        $reserved = implode(',', $this->reservedUsernames());

        // validate
        $this->validate($r, [
            'username' => [
                'required', 'regex:/^[\w-]*$/',
                Rule::unique('creator_profiles')->where(function ($query) use ($r) {
                    return $query->where('user_id', '!=', auth()->user()->id);
                }),
                'not_in:' . $reserved
            ],
            'name' => 'required',
            'category' => 'required|exists:categories,id'
        ]);


        // create profile if it doesn't exist
        if (!$p = \App\Profile::where('user_id', auth()->user()->id)->first())
            $p = new \App\Profile;

        // update profile
        $p->user_id = auth()->user()->id;
        $p->username = $r->username;
        $p->category_id = $r->category;
        $p->name = $r->name;
        $p->creating = $r->creates;
        $p->fbUrl = $r->fbUrl;
        $p->twUrl = $r->twUrl;
        $p->ytUrl = $r->ytUrl;
        $p->twitchUrl = $r->twitchUrl;
        $p->instaUrl = $r->instaUrl;
        $p->save();

        // update user name field
        $u = auth()->user();
        $u->name = $r->name;
        $u->save();

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

        // append alert
        alert()->success(__('profile.successfullyUpdated'));

        // redirect back
        return back();
    }

    // profile verification
    public function verifyProfile()
    {

        $active = 'verify-profile';
        $p = auth()->user()->profile;

        if ($p && $p->isVerified == 'Yes')
            return view('profile.verified', compact('active', 'p'));

        $countries = \Lang::get('country');

        return view('profile.verify', compact('active', 'p', 'countries'));
    }

    // process verification
    public function processVerification(Request $r)
    {

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
        $p = auth()->user()->profile;

        // append user meta
        $p->user_meta = $userMeta;
        $p->isVerified = 'Pending';
        $p->save();

        // notify admin by email

        $getEmailTemplate = EmailTemplate::findorFail(10);
        $emailSubject = $getEmailTemplate->emailSubject;
        $emailBody = $getEmailTemplate->emailBody;
        $emailBody = str_replace('<a ', '<a class="button button-primary" ', $emailBody);
        $emailBody = str_replace('{APP_NAME}', env('APP_NAME'), $emailBody);
        $emailBody = str_replace('{username}', auth()->user()->name, $emailBody);
        $emailBody = str_replace('{verification_requests}', route('admin-pvf'), $emailBody);

        $adminEmail = opt('admin_email');
        Mail::to($adminEmail)->send(new VerificationRequestedEmail(auth()->user(), $emailSubject, $emailBody));

        // append alert
        alert()->info(__('profile.requestSent'));

        return back();
    }

    // set fee
    public function setFee()
    {

        // active
        $active = 'set-fee';

        // get this user profile if it exists
        $p = auth()->user()->profile;

        // is this account verified?
        if (!$p or $p->isVerified != 'Yes') {
            alert()->info(__('profile.requiresVerified'));
            return redirect(route('profile.verifyProfile'));
        }

        // set fee
        return view('profile.set-fee', compact('active', 'p'));
    }

    // save membership fee
    public function saveMembershipFee(Request $r)
    {

        $minFee = opt('minMembershipFee', 1.99);
        $maxFee = opt('maxMembershipFee', 999.99);

        $minTipAmount = opt('minTipAmount', 1.99);
        $maxTipAmount = opt('maxTipAmount', 999.99);

        $this->validate($r, [
            'monthlyFee' => 'required|numeric|between:' . '£' . $minFee . ',' . '£' . $maxFee,
            'discountedFee' => 'numeric|between:' . '£' . $minFee . ',' . '£' . $maxFee,
            'minTipAmount' => 'numeric|between:' . '£' . $minTipAmount . ',' . '£' . $maxTipAmount,
        ]);

        // save details
        $p = auth()->user()->profile;

        // is verified?
        if ($p->isVerified != 'Yes') {
            alert()->info(__('profile.requiresVerified'));
            return redirect(route('profile.verifyProfile'));
        }

        $p->monthlyFee = $r->monthlyFee;
        $p->minTip = $r->minTipAmount;
        $p->payout_gateway = 'Bank Transfer';
        $p->save();

        // append alert
        alert()->info(__('profile.feeDetailsUpdated'));

        return back();
    }

    // account settings
    public function accountSettings()
    {

        $active = 'settings';
        $p = auth()->user()->profile;
        return view('profile.account-settings', compact('active', 'p'));
    }

    // save account settings
    public function saveAccountSettings(Request $r)
    {

        $user = auth()->user();
        $p = $user->profile;

        $this->validate($r, [
            'name' => 'required|min:2',
            'email' => 'required|email'
        ]);


        // update name
        $user->name = $r->name;
        $user->save();

        if ($p) {
            $p->name = $r->name;
            $p->payout_gateway = 'Bank Transfer';
            $p->payout_details = 'Bank Name:' . $r->bank_name . '\n'
                                . 'Account Name:' . $r->bank_account_name . '\n'
                                . 'Sort Code:' . $r->bank_sort_code . '\n'
                                . 'Account Number:' . $r->bank_account_number;
            $p->save();
        }

        $email = $r->email;

        // does email exist on another user?
        if ($user->email != $email) {

            // check if this email already exists
            $exists = User::where('email', $email)->where('id', '!=', $user->id)->first();

            if ($exists) {

                alert()->error(__('profile.emailExists'));
                return back();
            } else {

                $user->email = $email;
                $user->save();
            }
        } // if email is new

        // if password is changed
        if ($r->has('password') and !empty($r->password)) {

            $this->validate($r, ['password' => 'required|min:6|confirmed']);

            $user->password = \Hash::make($r->password);
            $user->save();
        }

        alert()->success(__('profile.successfullyUpdated'));

        return back();
    }

    // follow user
    public function followUser(User $user)
    {

        if (auth()->user()->id != $user->id)
            return auth()->user()->toggleFollow($user);
        else
            return response()->json(['error' => __('profile.followSelf')], 403);
    }
    // my subscribers
    public function mySubscribers()
    {

        // set active tab
        $active = 'my-subscribers';

        // get free subscribers
        $subscribers = auth()->user()->followers()->simplePaginate(opt('followListPerPage', 60));

        // get paid subscribers
        // @todo

        return view('profile.my-subscribers', compact('active', 'subscribers'));
    }

    // my subscribers
    public function mySubscriptions()
    {
        // set active tab
        $active = 'my-subscriptions';

        // get free subscriptions
        $subscriptions = auth()->user()->followings()->simplePaginate(opt('followListPerPage', 60));

        return view('profile.my-subscriptions', compact('active', 'subscriptions'));
    }

    // my blockedUsers
    public function myBlockedUsers()
    {
        // set active tab
        $active = 'my-blocked-users';

        // get blocked users
        $blockedUsers = auth()->user()->followings()->simplePaginate(opt('followListPerPage', 60));

        return view('profile.my-blocked-users', compact('active', 'blockedUsers'));
    }

    // reserved usernames
    private function reservedUsernames() {

        return [
            'admin',
            'vendor',
            'feed',
            'uploads',
            'notifications',
            'messages',
            'my-profile',
            'browse-creators',
            'logout',
            'login',
            'register',
            'report-content',
            'contact-page',
            'contact',
            'withdrawals',
            'upgrader',
            'tests',
            'svg',
            'storage',
            'routes',
            'resources',
            'public',
            'packages',
            'js',
            'images',
            'hooks',
            'helpers',
            'DOCUMENTATION',
            'database',
            'css',
            'config',
            'bootstrap',
            'app'
        ];

    }
    public function profilePicGet(){
        $user = auth()->user();
        $p = $user->profile;
        return view('profile.imageIframe', compact('user', 'p'));
    }
    public function saveProfilePic(Request $r){
        $updatedImg = "";
        // create profile if it doesn't exist
        if (!$p = \App\Profile::where('user_id', auth()->user()->id)->first())
            $p = new \App\Profile;
        // update profile
        if($p->user_id = auth()->user()->id) {
            // if cover image uploaded
            if ($r->coverPic && $r->img_type == 'cover_image') {
                // set cover pic
                $image = $r->coverPic;
                list($type, $image) = explode(';', $image);
                list(, $image) = explode(',', $image);
                $image = base64_decode($image);
                $fileN = 'coverpic-' . $p->id;
                $image_name = $fileN . '-' . time() . '.png';
                $path = public_path('uploads/coverPics/' . $image_name);

                file_put_contents($path, $image);
                // update cover pic
                $p->coverPic = 'coverPics/' . $image_name;
                $p->save();
                $updatedImg = config('app.url') . '/public/uploads/coverPics/' . $image_name;
            }
            // if profile image uploaded
            if ($r->profilePic && $r->img_type == 'profile_image') {
                $image = $r->profilePic;
                list($type, $image) = explode(';', $image);
                list(, $image) = explode(',', $image);
                $image = base64_decode($image);
                $fileN = 'profile-' . $p->id;
                $image_name = $fileN . '-' . time() . '.png';
                $path = public_path('uploads/profilePics/' . $image_name);
                //$storePic = Storage::putFile('profilePics', $image_name, 'public');

                file_put_contents($path, $image);

                // update profile pic
                $p->profilePic = 'profilePics/' . $image_name;
                $p->save();
                $updatedImg = config('app.url') . '/public/uploads/profilePics/' . $image_name;
            }
            return response()->json(['updated_pic' => $updatedImg]);
        }else{
            return response()->json(['error' => 'Unauthorized']);
        }

        // append alert
        //alert()->success(__('profile.successfullyUpdated'));
    }
    // my billing
    public function myBilling()
    {
    }
}
