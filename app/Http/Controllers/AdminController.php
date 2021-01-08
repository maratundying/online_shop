<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\product_model;
use App\user_model;
use App\messages_model;
class AdminController extends Controller
{
	function blockUser(Request $data){
		$time=time()+$data->time*60;
		user_model::where('id',$data->id)->update(['blocked'=>$time]);
		return $time;
	}

	function confirmProduct(Request $data){
		$productId=$data->id;
		product_model::where('id',$productId)->update(['activated'=>2]);
	}

	function sendReason(Request $data){
		$user_id=$data->user_id;
		$product_id=$data->id;
		$reason=$data->reason;
		
		$message=new messages_model;
		$message->user_id=$user_id;
		$message->product_id=$product_id;
		$message->feedback=$reason;
		$message->save();
		product_model::where('id',$product_id)->update(['activated'=>0]);
	}

	function unblockUser(Request $data){
		$userId=$data->id;
		user_model::where('id',$userId)->update(['blocked'=>0]);
	}
}
