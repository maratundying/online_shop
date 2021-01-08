<?php

namespace App\Http\Middleware;

use Closure;
use App\user_model;
use App\product_model;
use Session;

class ActivatedProduct
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
        $productId=$request->route()->parameter('productId');
        $user=user_model::where('id',Session::get('userId'))->first();
        $product=product_model::where('id',$productId)->first();
        if($product->activated==0){
            return redirect('/account');
        }
        if($product->activated==1){
            if($user->status=='admin' || $product->user_id==Session::get('userId')){
                return $next($request);
                Session::flash('foradministrator','Product is not activated ! Product can see only administrators.');
            }

            else{
                Session::flash('notactivated',"Product have not been activated yet");
                return redirect('/account');
            }
        }

        if($product->activated==2){
            return $next($request);
        }
    }
}
