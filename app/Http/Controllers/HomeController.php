<?php

namespace App\Http\Controllers;

use Session;
use App\User;
use App\EmailTemplate;
use App\Report;
use App\Profile;
use App\ReportUser;
use App\Mail\NewContentReportMail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware(['auth','verified']);
    // }

    // GET /
    public function index()
    {
        //alert()->success('Successfully validated. You can now continue using the product!');
		
        // lock homepage for guests?
        if(!auth()->check() AND opt('lock_homepage', 'No') == 'Yes')
            return redirect('login');
        
        // get a list of all creators, sorted by popularity
        $creators = Profile::where('isVerified', 'Yes')
            ->with('category')
            ->whereHas('category')
            ->orderByDesc('popularity')
            ->take((int)opt('homepage_creators_count'));

        // if hide admin from creators
        if (opt('hide_admin_creators', 'No') == 'Yes') {
            $creators->join('users', 'creator_profiles.user_id', 'users.id')
                     ->where('users.isAdmin', '!=', 'Yes');
        }

        $creators = $creators->get();

        return view('home', compact('creators'));
    }

    // GET /report-content
    public function report()
    {
        // set random numbers
        $no1 = rand(1,5);
        $no2 = rand(1,5);
        
        // get total
        $total = $no1+$no2;

        // put in session
        session(['total' => $total]);

        return view('report-content-form', compact('no1', 'no2'));
    }

    // store report in db and notify admin
    public function storeReport(Request $r)
    {
        
        // validate the form
        $this->validate($r, [
            'reporter_name' => 'required|min:2',
            'reporter_email' => 'required|email',
            'reported_url' => 'required|url',
            'reported_math' => 'required|numeric',
        ]);

        // detect bots
        if($r->the_field AND !empty($r->the_field)) {
            alert()->info(__('v14.bot-in-report-form'), __('v14.bot'));
            return back();
        }

        // check total
        if(!session('total')) {
            alert()->info(__('v14.direct-access'), __('v14.bot'));
            return back();
        }

        // check math answer
        if(  $r->reported_math != session('total') ) {
            alert()->info(__('v14.wrong-math'));
            return back()->withInput();
        }

        // finally, all seems legit - store the report
        $report = new Report;
        $report->reporter_name = $r->reporter_name;
        $report->reporter_email = $r->reporter_email;
        $report->reported_url = $r->reported_url;
        $report->report_message = $r->report_message;
        $report->reporter_ip = $r->ip();
        $report->save();

        $getEmailTemplate = EmailTemplate::findorFail(1);
        $emailSubject = $getEmailTemplate->emailSubject;
        $emailBody = $getEmailTemplate->emailBody;
        $emailBody = str_replace('<a ', '<a class="button button-primary" ', $emailBody);
        $emailBody = str_replace('{APP_NAME}', env('APP_NAME'), $emailBody);
        $emailBody = str_replace('{reporter_name}', $r->reporter_name, $emailBody);
        $emailBody = str_replace('{reported_url}', $r->reported_url, $emailBody);
        $emailBody = str_replace('{reporter_ip}', $r->ip(), $emailBody);
        $emailBody = str_replace('{view_abuse_report_link}', route('admin-moderate-content', ['contentType' => 'Image']), $emailBody);

        // notify admin of a new email report
        Mail::to(opt('admin_email'))->send(new NewContentReportMail($report, $emailSubject, $emailBody));

        alert()->info(__('v14.thanks-for-the-report'));

        return back();

    }

    // set entry popup cookie
    public function entryPopupCookie(Request $r)
    {
        //Call the withCookie() method with the response method
        return response()->json(['success' => 'cookie-set'], 200)
                        ->withCookie(cookie()->forever('entryConfirmed', now()));
    }

    // report user
	public function reportUser(Request $r)
	{
        if(!$report = ReportUser::where('user_id', $r->userId)->where('reported_by', auth()->user()->id)->first()){
            $report = new ReportUser;
            $report->user_id = $r->userId;
            $report->reported_by = auth()->user()->id;
        }

        $report->report_type = $r->reportType;
        if($r->reportType != "Block"){
            $report->report_content = $r->reportContent;
        }
        if($r->reportType != "Report"){
            auth()->user()->unfollow(User::find($r->userId));
        }
        $report->save();

		return response()->json(['reported' => true]);
	}

    public function setCurrentTimeZone(Request $r){ //To set the current timezone offset in session
        $input = $r->all();
        if(!empty($input)){
            $current_time_zone = $r->curent_zone;
            Session::put('current_time_zone',  $current_time_zone);
        }
    }

    public function getUsers(Request $r){
        // get a list of all creators
        $followList = [];

        if (auth()->check()) {
            $userAlreadyFollowing = auth()->user()->followings;

            foreach ($userAlreadyFollowing as $f) {
                $followList[] = $f->id;
            }
        }

        if (auth()->user()->isAdmin == 'Yes'){
            $users = User::with('profile')->select('id', 'name')->get();
        }else{
            $users = User::with('profile')->select('id', 'name')
                ->whereIn('id', $followList)->get();
        }

        foreach($users as $key => $user){
            $users[$key]->profile_pic_url = secure_image($user->profile->profilePic, 60, 60);
            $users[$key]->profile_url = route('profile.show', ['username' => $user->profile->username] );
        }

		return response()->json(['users' => $users]);
    }
}
