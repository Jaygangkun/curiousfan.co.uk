<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Authentication Routes
// Auth::routes();
Auth::routes(['verify' => true]);

// Maitenance page
Route::get('maintenance', 'ContactController@maintenance')->name('maintenance');

Route::group(['middleware' => 'App\Http\Middleware\CheckForMaintenance'], function () {

    // Homepage Route
    Route::get('/', function () {
        return redirect()->route('feed');
    });

    Route::post('ajax/set_current_time_zone', array('as' => 'ajaxsetcurrenttimezone','uses' => 'HomeController@setCurrentTimeZone'));

    // PWA Routes
    Route::get('manifest.json', 'PWAController@manifest')->name('pwa-manifest');
    Route::get('offline', 'PWAController@offline')->name('pwa-offline');

    // Report content route
    Route::get('report-content', 'HomeController@report')->name('report');
    Route::post('store-report', 'HomeController@storeReport')->name('storeReport');

    // Report User
    Route::post('report-user', 'HomeController@reportUser')->name('reportUser');

    //User for post user tag
    Route::get('get-users', 'HomeController@getUsers')->name('getUsers');

    Route::post('send-become-creator-request', 'HomeController@sendBecomeCreatorRequest')->name('sendBecomeCreatorRequest');

    // User Profile
    Route::get('my-profile', 'ProfileController@create')->name('startMyPage');
    Route::post('profile/update', 'ProfileController@store')->name('storeMyPage');
    Route::get('profile/set-fee', 'ProfileController@setFee')->name('profile.setFee');
    Route::Post('profile/save-fee', 'ProfileController@saveMembershipFee')->name('saveMembershipFee');
    Route::get('profile/verification', 'ProfileController@verifyProfile')->name('profile.verifyProfile');
    Route::post('profile/process-verification', 'ProfileController@processVerification')->name('processVerification');
    Route::get('profile/settings', 'ProfileController@accountSettings')->name('accountSettings');
    Route::post('profile/save-settings', 'ProfileController@saveAccountSettings')->name('saveAccountSettings');
    Route::post('profile/follow/{user}', 'ProfileController@followUser')->name('followUser');
    Route::get('profile/my-subscribers', 'ProfileController@mySubscribers')->name('mySubscribers');
    Route::get('profile/my-subscriptions', 'ProfileController@mySubscriptions')->name('mySubscriptions');
    Route::get('profile/my-blocked-users', 'ProfileController@myBlockedUsers')->name('myBlockedUsers');
    Route::get('feed/loadMore/{profile}/{lastId}', 'ProfileController@ajaxFeedForProfile')->name('loadPostsForProfile');
    Route::get('profile/my-tips', 'TipsController@myTips')->name('myTips');
    Route::get('profile/my-unlocks', 'TipsController@myUnlocks')->name('myUnlocksList');

    Route::get('profile/updateProfilePic', 'ProfileController@profilePicGet');
    Route::post('profile/profileImageUpdate', 'ProfileController@saveProfilePic');
    Route::post('profile/coverImageUpdate', 'ProfileController@saveProfilePic');


    // Billing
    Route::get('billing/history', 'BillingController@history')->name('billing.history');
    Route::get('billing/cards', 'BillingController@cards')->name('billing.cards');

    // Stripe
    Route::get('stripe/add-card', 'StripeController@addStripeCard')->name('addStripeCard');
    Route::get('stripe/capture-card', 'StripeController@captureStripeCard')->name('captureStripeCard');
    Route::post('stripe/stripeHooks', 'StripeController@stripeHooks')->name('stripeHooks');

    // Payments
    Route::get('subscribe/card/{user}', 'SubscriptionController@credit_card')->name('subscribeCreditCard');
    Route::get('subscribe/ccbill/{user}', 'SubscriptionController@ccbill')->name('subscribeCCBill');
    Route::get('subscribe/paystack/{user}', 'SubscriptionController@payStack')->name('subscribePayStack');
    Route::get('subscribe/paypal/{user}', 'SubscriptionController@paypal')->name('subscribeViaPaypal');
    Route::post('subscribe/paypal-notify/{creator}/{subscriber}', 'SubscriptionController@paypalProcessing')->name('paypalProcessing');
    Route::get('subscribe/webpayplus/{user}', 'WebpayPlusController@create_subscription')->name('subscribeWithWBPlus');
    Route::post('subscribe/process-webpayplus', 'WebpayPlusController@process_subscription')->name('wpb-process-subscription');
    Route::get('subscribe/mercadopago/{user}', 'MercadoPagoController@subscribeToUser')->name('subscribeMercadoPago');

    // Tips
    Route::post('tip/send/{post}', 'TipsController@processTip')->name('sendTip');
    Route::post('tip/paypal/ipn/{creator}/{subscriber}/{post}', 'TipsController@processPayPalTip')->name('paypalTipIPN');
    Route::any('tip/paypal/go-to-post/{post}', 'TipsController@redirectPayPalToPost')->name('paypal-post');
    Route::any('tip/ccbill', 'TipsController@process')->name('ccbill-post');
    Route::any('tip/ccbill/approval', 'CCBillController@approval')->name('ccbill-approval');
    Route::get('tip/mercadopago/return', 'TipsController@mercadoPagoTipProcess')->name('mercadoPagoTipIPN');

    // CCBill Webhooks
    Route::any('ccbill/webhooks', 'CCBillController@webhooks')->name('ccbill-hooks');

    // PayStack Webhooks
    Route::get('paystack/add-card', 'PayStackController@addPayStackCard')->name('addPayStackCard');
    Route::post('paystack/authorization', 'PayStackController@redirectToAuthorization')->name('paystack-authorization');
    Route::get('paystack/store-authorization', 'PayStackController@storeAuthorization')->name('paystack-authorization-callback');
    Route::post('paystack/webhooks', 'PayStackController@webhooks')->name('paystack-hooks');
    Route::get('paystack/link', 'PayStackController@link')->name('paystack-link');

    // MercadoPago Webhooks
    Route::post('mercadopago/store-authorization', 'MercadoPagoController@storeAuthorization')->name('mercadopago-authorization-callback');

    // TransBank GateWay - Webpay Plus
    Route::get('webpayplus/create/{post}/{creator}/{tipper}/{amount}', 'WebpayPlusController@createdTransaction')->name('wbp-process-create');
    Route::geT('webpayplus/create-unlock/{message}/{lockPrice}', 'WebpayPlusController@createUnlockTx')->name('wbp-msg-unlock');
    Route::post('webpayplus/returnUrl', 'WebpayPlusController@commitTransaction')->name('wpb-return-url');
    Route::post('webpayplus/returnUrlTx', 'WebpayPlusController@commitUnlockTransaction')->name('wpb-return-tx');

    // Withdrawals
    Route::get('withdrawals', 'WithdrawalControlller@index')->name('profile.withdrawal');

    // Notifications
    Route::get('notifications', 'NotificationsController@index')->name('notifications.index');
    Route::get('mark-read-notifications', 'NotificationsController@markAsReadNotifications')->name('markAsReadNotifications');
    Route::get('delete-notifications', 'NotificationsController@deleteNotifications')->name('deleteNotifications');
    
  //Route::get('notificationRestApi', 'NotificationsRestApiController@index')->name('notifications.index');  
    

    // Posts
    Route::get('post/{post}', 'PostsController@singlePost')->name('single-post');
    Route::get('post/edit/{post}', 'PostsController@editPost')->name('editPost');
    Route::post('post/save/{post}', 'PostsController@updatePost')->name('updatePost');
    Route::post('save-post', 'PostsController@savePost')->name('savePost');
    Route::get('delete-post/{post}', 'PostsController@deletePost')->name('deletePost');
    Route::get('post/loadById/{post}', 'PostsController@loadAjaxSingle')->name('loadPostById');
    Route::get('post/loadMore/{lastId}', 'PostsController@ajaxFeed')->name('loadMorePosts');
    Route::get('post/delete-media/{post}', 'PostsController@deleteMedia')->name('deleteMedia');
    Route::get('post/download-zip/{post}', 'PostsController@downloadZip')->name('downloadZip');
    // Route::enum('post-enum');

    // Likes
    Route::post('like/{post}', 'LikeController@like')->name('likePost');

    // Comments
    Route::get('comments/{post}/{lastId?}', 'CommentsController@loadForPost')->name('loadCommentsForPost');
    Route::post('comment/{post}', 'CommentsController@postComment')->name('postComment');
    Route::get('comment/load/{comment}/{post}', 'CommentsController@loadCommentById')->name('loadCommentById');
    Route::get('comment/delete/{comment}', 'CommentsController@deleteComment')->name('deleteComment');
    Route::get('comment/form/{comment}', 'CommentsController@editComment')->name('editComment');
    Route::post('comment/update/store', 'CommentsController@updateComment')->name('updateComment');

    // Serve image securely
    Route::get('usermedia/{path}', 'ImageController@picture')->where('path', '.*')->name('serveUserImage');

    // Dashboard
    Route::get('feed', 'PostsController@feed')->name('feed');
    Route::get('me', function () {
        return redirect()->route('feed');
    });

    //Verify
    //Route::get('verify');
    Auth::routes(['verify' => true]);
    // Browse Creators
    Route::get('browse-creators/{category?}/{category_name?}', 'BrowseCreators@browse')->name('browseCreators');

    // Messages
    Route::get('messages', 'MessagesController@inbox')->name('messages.inbox');
    Route::get('messages/{user}', 'MessagesController@conversation')->name('messages.conversation');
    Route::get('messages/download-zip/{messageMedia}', 'MessagesController@downloadZip')->name('downloadMessageZip');
    Route::get('unlock-message/{gateway}/{message}', 'MessagesController@unlockMessage')->name('unlockMessage');
    Route::post('paypal/unlock/{message}', 'MessagesController@processPayPalUnlocking')->name('paypalUnlockIpn');
    Route::get('mercadopago/unlock/return', 'MessagesController@mercadoPagoUnlockProcess')->name('mercadoPagoUnlockIPN');

    // Pages Routes
    Route::get('p/{page}', 'PageController')->name('page');

    // Entry popup
    Route::get('entry-popup', 'HomeController@entryPopupCookie')->name('entryPopupCookie');

    // Product
    Route::view('validate-license', 'validate-license')->name('validate-license');
    Route::post('validate-license', 'Controller@activate_product');

    // Contact page
    Route::get('contact-page', 'ContactController@contact_page')->name('contact-page');
    Route::post('contact-page-process', 'ContactController@contact_form_process')->name('contact-form-process');
    
// userRoutes and username This was outside the maintainence route at the bottom of the page moving into the maintainence block
// User Routes
    Route::get('toprofile/{user_id}', function ($user_id) {
    $username = App\Profile::where('user_id', $user_id)->pluck('username')->first();
    if (is_null($username)) abort(404);
    return redirect(route('profile.show', ['username' => $username]));
    })->name('profile.redirect');


//about
    Route::get('/about', 'HomeController@index')->name('home');


});

// Redirect to external links
Route::get('external-redirect', 'PostsController@externalLinkRedirect')->name('external-url');

// Banned Route
Route::view('banned', 'banned')->name('banned-ip');

// Admin Routes
Route::any('admin/login', 'Admin@login')->name('adminLogin');
Route::any('admin/logout', 'Admin@logout')->name('adminlogout');

// admin panel routes
Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function () {

    Route::get('admin', 'Admin@dashboard');

    // Vendors Related
    Route::get('admin/users', 'Admin@users');
    Route::get('admin/loginAs/{vendorId}', 'Admin@loginAsVendor');
    Route::get('admin/add-plan/{vendorId}', 'Admin@addPlanManually');
    Route::post('admin/add-plan/{vendorId}', 'Admin@addPlanManuallyProcess');
    Route::get('admin/users/setadmin/{user}', 'Admin@setAdminRole');
    Route::get('admin/users/unsetadmin/{user}', 'Admin@unsetAdminRole');
    Route::get('admin/users/ban/{user}', 'Admin@banUser');
    Route::get('admin/users/unban/{user}', 'Admin@unbanUser');
	
	Route::get('admin/users/banip/{user}', 'Admin@banUserIP');
    Route::get('admin/users/unbanip/{user}', 'Admin@unbanUserIP');

    // Profile Related
    Route::get('admin/profile-verifications', 'Admin@profileVerifications')->name('admin-pvf');
    Route::get('admin/approve/{profile}', 'Admin@approveProfile');
    Route::get('admin/reject/{profile}', 'Admin@rejectProfile');

    Route::get('admin/verifications/new/{user}', 'Admin@newVerification');
    Route::post('admin/verifications/new/verify/{user}', 'Admin@verifyByAdmin');
    
    //Google Ads
    Route::get('admin/google-ads', 'GoogleAdsController@index');
    
    //Edit User
    Route::get('admin/add-user', 'Admin@newUserByAdmin');
    Route::post('admin/add-user', 'Admin@addUserByAdmin');
    Route::get('admin/view-user/{user}', 'Admin@viewUserByAdmin');
    Route::post('admin/view-user/update/{user}', 'Admin@editUserByAdmin');

    // Payment Requests Related
    Route::get('admin/payment-requests', 'Admin@paymentRequests')->name('admin.payment-requests');
    Route::get('admin/payment-requests/markAsPaid/{withdraw}', 'Admin@markPaymentRequestAsPaid');

    // Tx Related
    Route::get('admin/tx', 'Admin@tx');

    // Subscriptions related
    Route::get('admin/subscriptions', 'Admin@subscriptions');

    // Tips Related
    Route::get('admin/tips', 'Admin@tips');
    
    // Notifications
    Route::get('admin/notifications', 'Admin@notifications')->name('admin-notification');
    Route::post('admin/send_notification', 'Admin@send_notification');
    
    // Unlocks (messages)
    Route::get('admin/unlocks', 'Admin@unlocks');

    // Category Related
    Route::get('admin/categories', 'Admin@categories_overview');
    Route::post('admin/add_category', 'Admin@add_category');
    Route::post('admin/update_category', 'Admin@update_category');

    // Website Messages
    Route::get('admin/website-messages', 'Admin@websiteMessageList');
    Route::post('admin/add_website-messages', 'Admin@addWebsiteMessages');
    Route::post('admin/update_website-messages', 'Admin@updateWebsiteMessages');

    //Verify Email By Admin
    Route::get('admin/verify/email/{user}', 'Admin@verifyEmailByAdmin');

    // CMS 
    Route::get('admin/cms', 'Admin@pages')->name('admin-cms');
    Route::post('admin/cms', 'Admin@create_page');
    Route::get('admin/cms-edit/{page}', 'Admin@showUpdatePage');
    Route::post('admin/cms-edit/{page}', 'Admin@processUpdatePage');
    Route::get('admin/cms-delete/{page}', 'Admin@deletePage');

    // Payments Setup
    Route::get('admin/payments-settings', 'Admin@paymentsSetup');
    Route::post('admin/save-payments-settings', 'Admin@paymentsSetupProcess');

    // Extra CSS/JS
    Route::get('admin/cssjs', 'Admin@extraCSSJS');
    Route::post('admin/saveExtraCSSJS', 'Admin@saveExtraCSSJS');

    // Admin config logins
    Route::get('admin/config-logins', 'Admin@configLogins');
    Route::post('admin/save-logins', 'Admin@saveLogins');

    Route::get('admin/configuration', 'Admin@configuration');
    Route::post('admin/configuration', 'Admin@configurationProcess');

    // Mail Server Configuration
    Route::get('admin/mailconfiguration', 'Admin@mailConfiguration');
    Route::post('admin/mailconfiguration', 'Admin@updateMailConfiguration');
    Route::get('admin/mailtest', 'Admin@mailtest');

    // Cloud settings
    Route::get('admin/cloud', 'Admin@cloudSettings');
    Route::post('admin/save-cloud-settings', 'Admin@saveCloudSettings');

    // Content Moderation
    Route::get('admin/moderation/{contentType}', 'Admin@moderateContent')->name('admin-moderate-content');
    Route::get('admin/content-moderation/delete-report/{id}', 'Admin@deleteContentReport')->name('admin-delete-content-report');

    // Site entry popup
    Route::get('admin/entry-popup', 'Admin@entryPopup');
    Route::post('admin/save/entry-popup', 'Admin@entryPopupSave');

    // Site Alert Message Management
    Route::get('admin/alert-message', 'Admin@alertMessage');
    Route::post('admin/save/alert-message', 'Admin@alertMessageSave');
    
    // Configure PWA
    Route::get('admin/pwa-config', 'Admin@configurePWA');
    Route::post('admin/pwa-store-config', 'Admin@savePWAConfiguration');

    // Configure Homepage Simulator
    Route::get('admin/simulator-config', 'Admin@simulatorConfig');
    Route::post('admin/simulator-store-config', 'Admin@saveSimulatorConfig');

    //enable/disable Messaging features
    Route::get('admin/message/enable/{user}', 'Admin@enableMessaging');
    Route::get('admin/message/disable/{user}', 'Admin@disableMessaging');

    //Admin Email Templates Controller
    Route::resource('admin/email-templates', 'EmailTemplateController');/*
    Route::get('admin/email-templates', 'EmailTemplateController@index');
    Route::get('admin/email-templates/{id}', 'EmailTemplateController@index');
    Route::post('admin/add_email-templates', 'Admin@addWebsiteMessages');
    Route::post('admin/update_website-messages', 'Admin@updateWebsiteMessages');*/

    //Admin Ads 
    Route::get('admin/ads', 'AdsController@index');
    Route::get('admin/ads/create', 'AdsController@create');
    Route::post('admin/ads', 'AdsController@store');
    Route::get('admin/ads/{id}/edit', 'AdsController@edit');
    Route::post('admin/ads/{id}/edit', 'AdsController@update');
    Route::delete('admin/ads/{id}', 'AdsController@destroy');

    //Block and Report Users
    Route::get('admin/block-report-users', 'Admin@reportUsers');
    Route::get('admin/block-report-users/delete/{id}', 'Admin@destroyReportUser');

    //Become Creator Requests
    Route::get('admin/become-creator-requests', 'Admin@becomeCreatorRequests');
    Route::post('admin/become-creator-request-approve', 'Admin@becomeCreatorRequestApprove')->name('becomeCreatorRequestApprove');
    Route::post('admin/become-creator-request-decline', 'Admin@becomeCreatorRequestDecline')->name('becomeCreatorRequestDecline');
});


Route::group(['middleware' => 'App\Http\Middleware\CheckForMaintenance'], function () {
   // username
    Route::any('{username}', 'ProfileController@showProfile')->name('profile.show'); 
});