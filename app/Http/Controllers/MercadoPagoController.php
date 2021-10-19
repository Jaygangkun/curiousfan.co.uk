<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class MercadoPagoController extends Controller
{
    // auth middleware
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'webhooks']);
    }

    // subscribe to user
    public function subscribeToUser(User $user)
    {
        
        if (auth()->id() == $user->id) {
			alert()->info(__('general.dontSubscribeToYourself'));
			return back();
		}

        try {

            // set secret key
            $secretKey = opt('MERCADOPAGO_SECRET_KEY');

            // set mercadopago secret key
            \MercadoPago\SDK::setAccessToken($secretKey);
            
            // get site currency
            $siteCurrency = opt('payment-settings.currency_code', 'USD');
            $siteCurrency = strtoupper($siteCurrency);
            
            // set amount
            $amount = number_format($user->profile->finalPrice, 2);

            // if amount
            if($amount < 10) 
                throw new \Exception(__('v19.mercadoPagoMinSubscriptionAmount'));

            // put into session
            session(['creator' => $user]);

            // return view to obtain token
            return view('subscribe.mercadopago', compact('amount', 'siteCurrency'));

        }catch(\Exception $e) {

            alert()->error($e->getMessage());
            return back();

        }

    }

    // store token
    public function storeAuthorization(Request $r)
    {

        $this->validate($r, ['token' => 'required', 
                            'payment_method_id' => 'required', 
                            'installments' => 'required', 
                            'issuer_id' => 'required']);

        // if no creator into session
        if(!session()->has('creator')) {
            alert()->error('MGPGO: page accessed in error!');
            return redirect(route('feed'));
        }

        // set secret key
        $secretKey = opt('MERCADOPAGO_SECRET_KEY');

        // set creator
        $creator = session('creator');

        // remove creator from session
        session()->forget('creator');

        // amount
        $amount = number_format($creator->profile->finalPrice, 2);

        // get site currency
        $siteCurrency = opt('payment-settings.currency_code', 'USD');
        $siteCurrency = strtoupper($siteCurrency);

        // set & encode data
        $data = [
            'back_url' => route('profile.show', ['username' => $creator->profile->username]),
            'external_reference' => $creator->id,
            'reason' => 'Subscription ' . uniqid(),
            'card_token_id' => $r->token,
            'auto_recurring' => [
              'frequency' => 1,
              'frequency_type' => 'months',
              'transaction_amount' => $amount,
              'currency_id' => $siteCurrency,
            ]
        ];

        $data_string = json_encode($data);                                                                                                                                                          

        // create plan
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.mercadopago.com/preapproval_plan');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer ' . $secretKey;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'MercadoPago API Returned this Error:' . curl_error($ch);
            exit;
        }
        curl_close($ch);

        dd(json_decode($result));
    
    }

}
