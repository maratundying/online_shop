<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\personal_messages_model;
use App\user_model;
class Messages_controller extends Controller
{
    function toMessage($data){
    	$message=personal_messages_model::where('id',$data)->first();
    	$person=user_model::where('id',Session::get('userId'))->first();
    	Session::put('sender_id',$message->sender_id);
    	Session::put('message_user_id',$message->user_id);
    	Session::put('product_id',$message->product_id);
    	return view('message',compact('person','message'));
    }

    function sendNewMessage(Request $data){
    	$message=new personal_messages_model;
    	$message->sender_id=Session::get('userId');
    	$message->user_id=Session::get('message_user_id');
    	$message->message=$data->message;
    	$message->product_id=Session::get('product_id');
    	$message->save();
    }

    function sendResponce(Request $data){
        $message=new personal_messages_model;
        $message->user_id=Session::get('userId');
        $message->sender_id=Session::get('message_user_id');
        $message->message=$data->message;
        $message->product_id=Session::get('product_id');
        $message->save();   
    }
}
