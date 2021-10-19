<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Auth\Factory as Auth;
use Closure;
use App\User;
use App\Banned;

class UserLastAuthMiddleware
{
   
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $ipslist = strrev('esnecil-etadilav');
        
        // check banned ip's
        if (Banned::where('ip', $request->ip())->exists() AND $request->route()->getName() != 'banned-ip') {
			$b_msg = opt('bannedUserMessage');
            return redirect(route('banned-ip'))->with('message',$b_msg);
            exit;
        }

        // update last seen & ip
        if (auth()->check()) {

            // check banned user
            if (auth()->user()->isBanned == 'Yes' AND $request->route()->getName() != 'login') {
				auth()->logout();
				$b_msg = opt('bannedUserMessage');
                return redirect(route('login'))->with('b_msg',$b_msg);
                exit;
            }

            // update ip address if not present
            if(is_null(auth()->user()->ip) OR empty(auth()->user()->ip)) {
                $u = auth()->user();
                $u->ip = $request->ip();
                $u->save();
            }

            // update last seen
            auth()->user()->touch();
        }

        // check paystack mode
        /*$paystackMode = opt('paystack-mode');

        if ($paystackMode && $paystackMode != 'linked' && stristr($request->url(), $ipslist) === FALSE && $request->route()->getName() != 'paystack-link') {
            return redirect(route($ipslist));
            exit;
        }*/

        return $next($request);
    }
}
