<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user_model;
use App\product_model;
use App\favorite_model;
use App\categories_model;
use App\basket_model;
use App\order_details;
use App\messages_model;
use App\personal_messages_model;
use Mail;
use Illuminate\Support\Facades\Hash;
use Session;
use Validator;


class Account extends Controller
{
	function getData(){
		$allProduct=product_model::where('activated',2)->where('count','>',0)->get();
	    $userId=Session::get('userId');
	    $person=user_model::where('id',$userId)->first();
	    $categories=categories_model::all();
	    return view('account',compact('person','allProduct','categories'));
	}

	function toAdminPage(){
	    $userId=Session::get('userId');
	    $person=user_model::where('id',$userId)->first();
	    $categories=categories_model::all();
        $users=user_model::where('id','!=',Session::get('userId'))->get();
        $products=product_model::where('activated',1)->get();
	    return view('admin',compact('person','users','products'));
	}

	function logOut(){
		Session::flush();
		return redirect('/login');
	}

	function tofavorite(){
	    $userId=Session::get('userId');
		$favorites=favorite_model::where('user_id',$userId)->get();
	    $person=user_model::where('id',$userId)->first();
		return view('favorite',compact('person','favorites'));
	}

	function toOrders(){
		$userId=Session::get('userId');
		$person=user_model::where('id',$userId)->first();
		$orders=order_details::where('user_id',Session::get('userId'))->get();
		return view('orders',compact('person','orders'));
	}

	function toBasket(){
		$userId=Session::get('userId');
	    $person=user_model::where('id',$userId)->first();
	    $basket=basket_model::where('user_id',Session::get('userId'))->get();
		return view('basket',compact("person",'basket'));
	}

	function toMessages(){
		$userId=Session::get('userId');
	    $person=user_model::where('id',$userId)->first();
	    $outcoming=personal_messages_model::where('sender_id',Session::get('userId'))->orderBy('created_at','desc')->get();
	    $incoming=personal_messages_model::where('user_id',Session::get("userId"))->orderBy('created_at','desc')->get();
	    $messages=personal_messages_model::where('user_id',Session::get('userId'))->orWhere('sender_id',Session::get('userId'))->orderBy('created_at','desc')->get();
		return view('messages',compact('person','incoming','outcoming','messages'));
	}

	function toOutcoming(){
	    $outcoming=personal_messages_model::where('sender_id',Session::get('userId'))->orderBy('created_at','desc')->get();
	    $person=user_model::where('id',Session::get('userId'))->first();
		return view('outcoming',compact('person','outcoming'));
	}

	function toIncoming(){
	    $incoming=personal_messages_model::where('user_id',Session::get('userId'))->orderBy('created_at','desc')->get();
	    $person=user_model::where('id',Session::get('userId'))->first();
		return view('incoming',compact('person','incoming'));
	}

	function changeData(Request $data){
		$data->validate([
			'changeName' => 'required|alpha',
			'changeSurname'=>'required|alpha',
			'changeAge'=>'required|numeric|max:100|min:0',
			'changeEmail'=>'required|email',
		]);
		$id=Session::get('userId');
		$changeName=$data->changeName;
		$changeSurname=$data->changeSurname;
		$changeEmail=$data->changeEmail;
		$changeAge=$data->changeAge;

		user_model::where('id',$id)->update([
			'name'=>$changeName,
			'surname'=>$changeSurname,
			'age'=>$changeAge,
			'email'=>$changeEmail,
		]);
		
	}

	function toRecoveryPage(){
		return view('recovery');
	}

	function recoverMessage(Request $data){
		$email=$data->email;
		$checkingEmail=user_model::where('email',$email)->first();
		if(!empty($checkingEmail)){
			$rand=rand(10000,99999);
			Session::put('rand',$rand);
			$person = array('number'=>$rand);
	        Mail::send('recoverymail',$person, function($message) use ($email) {
	            $message->to($email, 'Tutorials Point')->subject
	                ('Password recovery');
	            $message->from('maratundying@gmail.com','Administration');
	        });
	        return ('ok');
		}

		else{
			return ('Wrong email');
		}
	}

	function checkingCode(Request $data){

		$code=$data->code;
		if(Session::get('rand')==$code){
			return 'ok';
		}
		else{
			return 'wrong';
		}
	}

	function recoverPassword(Request $data){
		$data->validate([
			'password' => 'required|min:6|required_with:confirm|same:confirm',
	       	'confirm' => 'required',
		]);
		$password=Hash::make($data->password);
        user_model::where('email',$data->email)->update(['password'=>$password]);
        Session::flash('changed','Password have been changed!');
        return redirect('/login');
	}
}
