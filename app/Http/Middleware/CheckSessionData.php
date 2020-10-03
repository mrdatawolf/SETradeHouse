<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use \Session;

class CheckSessionData
{
    public $carbonNow;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $this->carbonNow = Carbon::now();
        if(! Session::has('serverId')) {
            $this->setGeneralValues();
        }

        return $next($request);
    }


    public function setGeneralValues() {
        //these are placeholders.  It should be stored retrieved based on the players last selection
        $serverId = 1;
        $worldId = 1;
        $storeId = 1;

        Session::put('serverId', $serverId);
        Session::put('worldId', $worldId);
        Session::put('storeId', $storeId);
    }
}
