<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Stripe;
use App\user_model;
use App\product_model;
use App\basket_model;
use App\orders;
use App\order_details;

class StripePaymentController extends Controller
{
    public function priceToSession(Request $data){
        $product=product_model::where('id',$data->product_id)->first();
        $basket_product=basket_model::where('id',$data->basket_id)->first();
        Session::put('price',$product->price);
        Session::put('product_id',$data->product_id);
        Session::put('count',$data->count);
        Session::put('basket_id',$data->basket_id);
    }

    public function stripe()
    {
        $userId=Session::get('userId');
        $person=user_model::where('id',$userId)->first();
        return view('stripe',compact('person'));
    }
  
    public function stripePost(Request $request)
    { 
        // return Session::get('count');
        Stripe\Stripe::setApiKey('sk_test_4pXHoP4mdNBJNlAALUMTWuod002nxzmehx');
        Stripe\Charge::create ([
                "amount" => Session::get('price') * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com." 
        ]);

        $order=new orders;
        $order->user_id=Session::get('userId');
        $order->total=Session::get('price');
        $order->save();

        $order_id=$order->id;

        $order_detail=new order_details;
        $order_detail->order_id=$order_id;
        $order_detail->product_id=Session::get('product_id');
        $order_detail->count=Session::get('count');
        $order_detail->user_id=Session::get('userId');
        $order_detail->save();

        product_model::where('id',Session::get('product_id'))->decrement('count',Session::get('count'));
        basket_model::where('id',Session::get('basket_id'))->delete();
        Session::flash('success', 'Payment successful!');
        return redirect('/basket');
    }
}
