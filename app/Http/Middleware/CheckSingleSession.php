<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CheckSingleSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(session()->getID() != Auth::user()->last_session){
            // Auth::logout();
            // var_dump(session()->getID());die;
            session()->put(["alert", "Someone is going to join with your credential!"]);
            return redirect('login');
         }
        return $next($request);
    }
}
