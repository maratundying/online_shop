<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App\user_model;
use Illuminate\Support\Facades\Auth;
class is_admin
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
        $arr=user_model::where('id',Session::get('userId'))->first();
        if($arr->status=='admin'){
            return $next($request);
        }
        else{
            Session::flash('warning','You are not Administrator');
            return redirect('/account');
        }
    }
}
