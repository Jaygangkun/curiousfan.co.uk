<?php

namespace App\Http\Middleware;

use Closure;
use Session;


class CheckForMaintenance
{
    /**
     * The URIs that should be reachable while maintenance mode is enabled.
     *
     * @var array
     */
    public function handle($request, Closure $next)
    {
        if(opt('maintenance', 'No') == 'No')
            return $next($request);
        else
            return redirect('maintenance');
    }
}
