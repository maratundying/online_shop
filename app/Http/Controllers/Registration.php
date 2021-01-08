<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\user_model;
use Illuminate\Support\Facades\Hash;
use Session;
use Mail;

class Registration extends Controller
{
    function signup(){
    	return view('signup');
    }

    function login(){
        if(!Session::get('userId')){
    	   return view('login');
        }

        else{
            return redirect('/account');
        }
    }

    function toSignupPage(){
        return redirect('/signup');
    }

    function signup_form(Request $data){
    	$data->validate([
        	'name' => 'required|alpha',
        	'surname' => 'required|alpha',
        	'age' => 'required|numeric|max:100|min:0',
        	'email' => 'required|email|unique:user,email',
            'phone' => 'required|numeric|min:8',
        	'password' => 'required|min:6|required_with:confirm|same:confirm',
        	'confirm' => 'required',
    	]);

        $user=new user_model;
        $user->name=$data->name;
        $user->surname=$data->surname;
        $user->age=$data->age;
        $user->email=$data->email;
        $user->phone=$data->phone;
        $user->password=Hash::make($data->password);
        $user->save();

        $email=$data->email;

        $person = array('name'=>$data->name,'hash'=>md5($email.$user->id),'email'=>$data->email);
        Mail::send('mail',$person, function($message) use ($email) {
            $message->to($email, 'Tutorials Point')->subject
                ('Registration complectation');
            $message->from('maratundying@gmail.com','Administration');
        });
        Session::flash('activation','The registration message is sent to your email ! Turn and verify!');
        return redirect("/login");
    }

    function checkuser($hash,$email){
        $arr=user_model::where('email',$email)->first();
        if(!empty($arr) && $arr->registered==0){
            user_model::where('email',$email)->update(['registered'=>1]);
            Session::flash('registration_completed','Registration is completed successfuly');
            return redirect('/login');
        }
        else{
            return redirect('/signup');
        }

    }

    function login_form(Request $data){
        $data->validate([
            'login'=>'required',
            'password'=>'required',
        ]);

        $arr=user_model::where('email',$data->login)->first();
        if(empty($arr)){
            Session::flash('error','User not found');
            // return redirect('/login');
            return back(); // <==> return redirect('/login');
        }
        else{
            if($arr->registered==0){
                Session::flash('error','The message sent to your email is not activated');
                return back();
            }

            if($arr->blocked>time()){
                Session::flash('blocked','Your account has been blocked');
                return back();
            }
            if(!Hash::check($data->password,$arr->password)){
                Session::flash('error','Wrong password');
                return back();
            }
            else{
                Session::put('userId',$arr->id);
                if($arr->status=='admin'){
                    Session::put('adminid',Session::get('userId'));
                    return redirect('/admin');
                }
                else{
                    return redirect('/account');
                }
                
            }
        }
    }
}
