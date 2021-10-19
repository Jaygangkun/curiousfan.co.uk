<?php

namespace App\Http\Controllers;

use App\Tips;
use App\User;
use App\Unlock;
use App\Message;
use App\MessageMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Notifications\UnlockedMessageNotification;

class MessagesController extends Controller
{
    // auth middleware
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['processPayPalTip']]);
    }

    public function inbox()
    {
        // get this users messages
        return view('messages.inbox');
    }

    // download zip
    public function downloadZip(MessageMedia $messageMedia)
    {
        

        if( Unlock::where('message_id', $messageMedia->message_id)->where('payment_status', 'Paid')->where('tipper_id', auth()->id())->exists() ) {

            if($messageMedia->disk == 'backblaze')
                $redirectTo = 'https://'. opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' .  $messageMedia->media_content;
            else
                $redirectTo = Storage::disk($messageMedia->disk)->url($messageMedia->media_content);

            return redirect( $redirectTo );

        }else{
            echo __('v16.accessDenied');
        }

    }

    // unlock message
    public function unlockMessage($gateway, Message $message)
    {

        // get 1st item from the locked media
        $media = $message->media()->where('lock_type', 'Paid')->firstOrFail();

        // get lock price
        $lockPrice = $media->lock_price;
        
        // check gateway and redirect accordingly
        if ($gateway == 'PayPal') {

            return $this->sendToPayPal($message, $lockPrice);

        } elseif ($gateway == 'Card') {

            if (opt('card_gateway', 'Stripe') == 'Stripe') {
                return $this->stripeUnlock($message, $lockPrice);
            }elseif(opt('card_gateway', 'Stripe') == 'CCBill' ) {
                return $this->ccBillUnlock($message, $lockPrice);
            }elseif(opt('card_gateway', 'Stripe') == 'PayStack' ) {
                return $this->payStackUnlock($message, $lockPrice);
            }elseif(opt('card_gateway', 'Stripe') == 'MercadoPago' ) {
                return $this->mercadoPagoUnlock($message, $lockPrice);
            }elseif(opt('card_gateway', 'Stripe') == 'TransBank' ) {
                return $this->transBankUnlock($message, $lockPrice);
            }

        }


    }

    // unlock via Stripe
    public function stripeUnlock(Message $message, $lockPrice)
    {
        
        \Stripe\Stripe::setApiKey(opt('STRIPE_SECRET_KEY', 123));

        // get current user
        $user = auth()->user();

        // set stripe customer
        $customer = 'fan_' . auth()->id();

        // set "tipper"
        $tipper = $user;

        // set creator
        $creator = $message->sender;

        // get "tipper" payment methods
        $pm = $user->paymentMethods()->where('is_default', 'Yes')->firstOrFail();
        $pm = $pm->p_meta;
        $pm_id = $pm['payment_method'];

        // compute price
        $price = $lockPrice;
        $amount = $lockPrice;

        // get platform fee
        $platform_fee = opt('payment-settings.site_fee');
        $fee_amount = ($price * $platform_fee) / 100;

        // compute creator amount
        $creator_amount = number_format($price - $fee_amount, 2);

        try {

            $intent = \Stripe\PaymentIntent::create([
                'amount' => $amount * 100,
                'currency' => opt('payment-settings.currency_code'),
                'customer' => $customer,
                'payment_method' => $pm_id,
                'off_session' => true,
                'confirm' => true,
            ]);

            // update creator balance
            $creator->balance += $creator_amount;
            $creator->save();

            // create unlock payment
            $tip = new Unlock;
            $tip->amount = $amount;;
            $tip->creator_amount = $creator_amount;
            $tip->admin_amount = $fee_amount;
            $tip->tipper_id = $tipper->id;
            $tip->creator_id = $creator->id;
            $tip->message_id  = $message->id;
            $tip->gateway = 'Card';
            $tip->save();

            // notify creator by email and on site
            $creator->notify(new UnlockedMessageNotification($tip));

            alert()->info(__('v19.unlockSuccess'));

        } catch (\Stripe\Exception\CardException $e) {

            $payment_intent_id = $e->getError()->payment_intent->id;
            $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);

            if ($payment_intent->status == 'requires_payment_method') {

                // setup stripe client
                $stripe = new \Stripe\StripeClient(
                    opt('STRIPE_SECRET_KEY', '123')
                );

                // confirm payment
                $confirm = $stripe->paymentIntents->confirm(
                    $payment_intent_id,
                    ['payment_method' => $pm_id],
                );

                 // create unlock payment
                $tip = new Unlock;
                $tip->amount = $amount;;
                $tip->creator_amount = $creator_amount;
                $tip->admin_amount = $fee_amount;
                $tip->tipper_id = $tipper->id;
                $tip->creator_id = $creator->id;
                $tip->message_id  = $message->id;
                $tip->gateway = 'Card';
                $tip->payment_status = 'Pending';
                $tip->intent = $payment_intent_id;
                $tip->save();


                // redirect user to confirmation
                return redirect($confirm->next_action->use_stripe_sdk->stripe_js);
            } else {

                alert()->error($e->getMessage());
            }
        }

        return redirect(route('messages.inbox'));

    }

    // paypal message unlocking
    public function sendToPayPal(Message $message, $lockPrice)
    {
        return view('messages.paypal-unlocking', compact('message', 'lockPrice'));
    }

    // process paypal unlocking
    public function processPayPalUnlocking(Message $message, Request $r)
    {

        // STEP 1: read POST data
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);

        $myPost = array();

        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }

        // read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
        $req = 'cmd=_notify-validate';

        // build req
        foreach ($myPost as $key => $value) {
            $value = urlencode($value);
            $req .= '& ' . trim(strip_tags($key)) . '=' . trim(strip_tags($value));
        }

        // STEP 2: POST IPN data back to PayPal to validate
        // $ch = curl_init('https://ipnpb.sandbox.paypal.com/cgi-bin/webscr');
        $ch = curl_init('https://ipnpb.paypal.com/cgi-bin/webscr');
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        // error?
        if (!($res = curl_exec($ch))) {
            \Log::error("Got " . curl_error($ch) . " when processing IPN data (Unlocking Message)");
            curl_close($ch);
            exit;
        } else {
            \Log::info('IPN_POSTED_SUCCESSFULLY (Unlocking Message)');
        }
        curl_close($ch);

        // \Log::info('Result: ' . $res);
        // \Log::debug($r->all());

        // STEP 3: Inspect IPN validation result and act accordingly
        if (strcmp($res, "VERIFIED") == 0) {

            // check that receiver_email is your Primary PayPal email
            $receiver_email = $r->receiver_email;

            if (opt('paypal_email', 'paypal@paypal.com') != $receiver_email) {
                \Log::info('RECEIVER_EMAIL = ' . $receiver_email);
                \Log::info('SHOULD_BE = ' . opt('paypal_email', 'paypal@paypal.com'));
                exit;
            }

            // check if payment status is completed
            if ($r->payment_status != "Completed") {
                \Log::info('Payment status is not Completed but: ' . $r->payment_status);
                exit;
            }

            // find this creator
            $creator = User::findOrFail($message->from_id);

            // find this subscriber
            $subscriber = User::findOrFail($message->to_id);

            // compute price
            $price = $r->mc_gross;

            // get platform fee
            $platform_fee = opt('payment-settings.site_fee');
            $fee_amount = ($price * $platform_fee) / 100;

            // compute creator amount
            $creator_amount = number_format($price - $fee_amount, 2);

            switch ($r->txn_type) {

                case 'web_accept':

                    // update creator balance
                    $creator->balance += $creator_amount;
                    $creator->save();

                    // create unlock
                    $tip = new Unlock;
                    $tip->amount = $price;
                    $tip->creator_amount = $creator_amount;
                    $tip->admin_amount = $fee_amount;
                    $tip->tipper_id = $subscriber->id;
                    $tip->creator_id = $creator->id;
                    $tip->message_id  = $message->id;
                    $tip->gateway = 'Card';
                    $tip->save();

                    // notify creator by email and on site
                    $creator->notify(new UnlockedMessageNotification($tip));

                    break;
            }
        } else {
            \Log::info('PayPal Not VERIFIED:' . $res);
        }

    }// ./paypal ipn


    // process PayStack Unlock
    public function payStackUnlock(Message $message, $lockPrice)
    {
        
        // make amount a decimal
        $amount = number_format($lockPrice, 2);

        try {

            // get currency
            $currencyCode = opt('payment-settings.currency_code', 'USD');

            // get user default payment method 
            $pm = auth()->user()->paymentMethods()->where('is_default', 'Yes')->firstOrFail();
            $authCode = $pm->p_meta['authorization_code'];

            // set url
            $url = "https://api.paystack.co/transaction/charge_authorization";

        
            // set fields
            $fields = [
                'email' => auth()->user()->email,
                'amount' => $amount*100,
                'currency' => $currencyCode,
                'authorization_code' => $authCode,
                'metadata' => [ 'message_id' => $message->id ]
            ];

            $fields_string = http_build_query($fields);

            //open connection
            $ch = curl_init();
            
            //set the url, number of POST vars, POST data
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_POST, true);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Authorization: Bearer " . opt('PAYSTACK_SECRET_KEY'),
                "Cache-Control: no-cache",
            ));
            
            //So that curl_exec returns the contents of the cURL; rather than echoing it
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
            
            //execute post
            $result = curl_exec($ch);

            if($e = curl_error($ch) && !empty($e) )
                throw new \Exception('PayStack cURL Error: ' . $e);

            // close the connection
            curl_close($ch);

            // decode result
            $result = json_decode($result);

            if(!$result->status)
                throw new \Exception('PayStack Returned this status: ' . $result->message);

            // sleep to have time for processing
            sleep(2);

            // add message
            alert()->info(__('v19.unlockProcessing'));

            // redirect to messages inbox
            return redirect(route('messages.inbox'));

        } catch(\Exception $e) {

            alert()->error($e->getMessage());
            return back();
        }


    }

    // process CCBill Unlock
    public function ccBillUnlock(Message $message, $lockPrice)
    {

        // make amount a decimal
        $amount = number_format($lockPrice, 2);

        // set ccbill currency codes
        $ccbillCurrencyCodes = [];
        $ccbillCurrencyCodes["USD"] = 840;
        $ccbillCurrencyCodes["EUR"] = 978;
        $ccbillCurrencyCodes["AUD"] = 036;
        $ccbillCurrencyCodes["CAD"] = 124;
        $ccbillCurrencyCodes["GBP"] = 826;
        $ccbillCurrencyCodes["JPY"] = 392;

        // get site currencies
        $siteCurrency = strtoupper(opt('payment-settings.currency_code', 'USD'));

        // do we have this site currency on CCBill as well? if not, default to USD
        if( isset($ccbillCurrencyCodes[$siteCurrency]) )
            $currencyCode = $ccbillCurrencyCodes[$siteCurrency];
        else
            $currencyCode = 840;

        // get salt
        $salt = opt('ccbill_salt');
        
        // set initial period
        $initialPeriod = 365;

        // generate hash: formPrice, formPeriod, currencyCode, salt
        $hash = md5($amount . $initialPeriod . $currencyCode . $salt);

        // redirect to CCBill payment
        $ccBillParams['clientAccnum'] = opt('ccbill_clientAccnum');
        $ccBillParams['clientSubacc'] = opt('ccbill_Subacc');
        $ccBillParams['currencyCode'] = $currencyCode;
        $ccBillParams['formDigest'] = $hash;
        $ccBillParams['initialPrice'] = $amount;
        $ccBillParams['initialPeriod'] = $initialPeriod;
        $ccBillParams['message_id'] = $message->id;

        // set form id
        $formId = opt('ccbill_flexid');

        // set base url for CCBill Gateway
        $baseURL = 'https://api.ccbill.com/wap-frontflex/flexforms/' . $formId;

        // build redirect url to CCbill Pay
        $urlParams = http_build_query($ccBillParams);
        $redirectUrl = $baseURL . '?' . $urlParams;

        return redirect($redirectUrl);

    }

    // send to TransBank unlock
    public function transBankUnlock(Message $message, $lockPrice)
    {
        return redirect(route('wbp-msg-unlock', ['message' => $message, 'lockPrice' => $lockPrice]));
    }

    // send to mercado pago
    public function mercadoPagoUnlock(Message $message, $lockPrice)
    {

        try {

            // set amount to double
            $amount = number_format($lockPrice, 2);

            // set mercadopago secret key
            \MercadoPago\SDK::setAccessToken(opt('MERCADOPAGO_SECRET_KEY'));
            
            // Create a preference object
            $preference = new \MercadoPago\Preference();

            // Create a preference item
            $item = new \MercadoPago\Item();
            $item->title = __('v19.unlockInfo') . $amount;
            $item->quantity = 1;
            $item->unit_price = $amount;
            $item->currency_id = opt('payment-settings.currency_code', 'USD');

            // append item to preference
            $preference->items = [$item];

            // add auto-return
            $preference->auto_return = 'approved';
            
            // add return url
            $preference->back_urls = [ 'success' => route('mercadoPagoUnlockIPN') ];

            // compute price
            $price = $amount;

            // get platform fee
            $platform_fee = opt('payment-settings.site_fee');
            $fee_amount = ($price * $platform_fee) / 100;

            // compute creator amount
            $creator_amount = number_format($price - $fee_amount, 2);

            // get current user
            $user = auth()->user();

            // set "tipper"
            $tipper = $user;

            // set creator
            $creator = $message->sender;
            
            // create unlock payment
            $tip = new Unlock;
            $tip->amount = $amount;;
            $tip->creator_amount = $creator_amount;
            $tip->admin_amount = $fee_amount;
            $tip->tipper_id = $tipper->id;
            $tip->creator_id = $creator->id;
            $tip->message_id  = $message->id;
            $tip->gateway = 'Card';
            $tip->payment_status = 'Pending';
            $tip->save();

            // add tip id into reference
            $preference->external_reference = $tip->id;

            // add tip id into session
            session(['mgpgoUnlockId' => $tip->id]);

            // exclude cash
            $preference->payment_methods = array(
                "excluded_payment_types" => array(
                  array("id" => "cash")
                )
            );

            // binary only
            $preference->binary_mode = true;

            // save
            $preference->save();

            // redirect to payment (live)
            return redirect($preference->init_point);

        } catch(\Exception $e) {
            dd($e->getMessage());
        }

    }

    // process MercadoPago Unlock
    public function mercadoPagoUnlockProcess(Request $r)
    {

        try {

            // if payment not approved
            if($r->status != 'approved') {
                throw new \Exception('Payment failed');
            }

            // get session tip id
            if( session()->has('mgpgoUnlockId') ) {

                // set tip id
                $tipId = session('mgpgoUnlockId');

                // delete from session
                session()->forget('mgpgoUnlockId');

            }elseif( $r->has('external_reference') ){

                // set tip id
                $tipId = $r->external_reference;

            }

            // find this tip
            $tip = Unlock::findOrFail($tipId);

            // update payment status
            $tip->payment_status = 'Paid';
            $tip->save();

            // set creator
            $creator = $tip->tipped;

            // update creator balance
            $creator->balance += $tip->creator_amount;
            $creator->save();

            // notify creator by email and on site
            $creator->notify(new UnlockedMessageNotification($tip));

            // add message
            alert()->info(__('v19.unlockProcessing'));

            // redirect to messages inbox
            return redirect(route('messages.inbox'));

        }catch(\Exception $e) {

            alert()->error($e->getMessage());
            return redirect('messages.inbox');
        }
        

    }

}
