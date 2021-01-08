<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\product_model;
use App\photos_model;
use App\user_model;
use App\favorite_model;
use App\categories_model;
use App\basket_model;
use App\feedback_model;
use App\personal_messages_model;
use Session;
use Validator;

class Product extends Controller
{
    function toAddProduct(){
        $userId=Session::get('userId');
        $person=user_model::where('id',$userId)->first();
        $categories=categories_model::all();
        return view('addproduct',compact('categories','person')); 
    }

    function addProduct(Request $data){
    	$data->validate([
    		'name'=>'required|max:30',
    		'price'=>'required|numeric|min:1',
    		'count'=>'required|numeric',
    		'description'=>'required|max:200',
            'images*'=> 'mimes:jpeg,bmp,png',
            'category'=>'required',
    	]);

    	$product=new product_model;
    	$product->name=$data->name;
    	$product->price=$data->price;
    	$product->count=$data->count;
    	$product->description=$data->description;
        $product->category_id=$data->category;
    	$product->user_id=Session::get('userId');
        $product->activated=1;
    	$product->save(); 

    	$productId=$product->id;
    	if($files=$data->file('images')){
	        foreach($files as $file){
    	        $photo=new photos_model;
	            $name=uniqid().$file->getClientOriginalName();
	            $file->move('image',$name);
	            $photo->photo='image/'.$name;
                $photo->product_id=$productId;
                $photo->save();
	        }
    	}
    	return redirect('/myproducts');
    }

    function search(Request $data){
        $input=$data->input;
        $result=product_model::where('name','like','%'.$input.'%')->where('activated',2)->get();
        $results=[];
        foreach($result as $cur){
            $photos=photos_model::where('product_id',$cur->id)->first();

            if(!empty($photos)){
                $cur['photos']=$photos->photo;
                $results[]=$cur;
            }

            else{
                $results[]=$cur;
            }
        }
        return $results;
    }

    function categoryProductShow(Request $data){
        $products=product_model::where('category_id',$data->id)->get();
        return $products;
    }

    function showMyProducts(){
        $userId=Session::get('userId');
        $categories=categories_model::all();
        $person=user_model::where('id',$userId)->first();
        $products=product_model::where('user_id',$userId)->get();
        return view('my',compact('products','person','categories'));

    }

    function toMainPage(){
        return redirect('/account');
    }

    function toItemPage($productId){
        $userId=Session::get('userId');
        $categories=categories_model::all();
        $person=user_model::where('id',$userId)->first();
        $feedbacks=feedback_model::where('product_id',$productId)->get();
        $product=product_model::where('id',$productId)->first();
        return view('item',compact('product','person','categories','feedbacks'));
    }

    function sendMessage(Request $data){
        $product=product_model::where('id',$data->product_id)->first();
        $user=user_model::where('id',$data->user_id)->first();
        $message=$data->message;
        if($product->user_id==$user->id){
            $newMessage=new personal_messages_model;
            $newMessage->product_id=$data->product_id;
            $newMessage->user_id=$data->user_id;
            $newMessage->sender_id=Session::get('userId');
            $newMessage->message=$message;
            $newMessage->save();
        }
    }

    function toUserProducts($userProfileId){
        $userId=Session::get('userId');
        $person=user_model::where('id',$userId)->first();
        $products=product_model::where('user_id',$userProfileId)->get();
        return view('userproducts',compact('person','products'));
    }

    function deleteProduct(Request $aj){
        $product_id=$aj->product_id;
        product_model::where('id',$product_id)->delete();
    }

    function changeProduct(Request $form){
        $form->validate([
            'name'=>'required|max:30',
            'price'=>'required|numeric|min:1',
            'count'=>'required|numeric',
            'description'=>'max:200',            
            'images.*'=> 'mimes:jpeg,jpg,png',
        ]);

        product_model::where('id',$form->productid)->update(['name'=>$form->name,'price'=>$form->price,'count'=>$form->count,'description'=>$form->description,'activated'=>1]);

        if($files=$form->file('images')){
            foreach($files as $file){
                $photo=new photos_model;
                $name=uniqid().$file->getClientOriginalName();
                $file->move('image',$name);
                $photo->photo='image/'.$name;
                $photo->product_id=$form->productid;
                $photo->save();
            }
        }
        return $form;
    }

    function checkingForFavorite(Request $data){
        // print "<pre>";
        $arr=favorite_model::where('product_id',$data->product_id)->where('user_id',Session::get('userId'))->first();
        return $arr;
    }

    function addToFavorites(Request $data){
        favorite_model::insert(['user_id'=>Session::get('userId'),'product_id'=>$data->product_id]);
    }

    function removeFromFavorites(Request $data){
        favorite_model::where('id',$data->favorite_id)->delete();
    }

    function removeFromFavoritesItem(Request $data){
        favorite_model::where('id',$data->favorite_id)->delete();
    }

    function addToBasket(Request $data){
        $product_id=$data->product_id;
        $product_count=$data->productCount;
        $basket_count=$data->basketCount;

        $arr=basket_model::where('product_id',$product_id)->where('user_id',Session::get('userId'))->first();
        if(empty($arr)){
            basket_model::insert(['product_id'=>$product_id,'user_id'=>Session::get('userId'),'count'=>$basket_count]);
        }

        else{
            basket_model::where('product_id',$product_id)->where('user_id',Session::get('userId'))->update(['count'=>$arr->count+$basket_count]);
        }
    }

    function plusBasketCount(Request $data){
        $basket=basket_model::where('id',$data->basket_id)->first();
        $product=product_model::where('id',$basket->product_id)->first();
        if($product->count>$basket->count)
            basket_model::where('id',$data->basket_id)->increment('count');
            return  $product;
        }

    function minusBasketCount(Request $data){
        $basket=basket_model::where('id',$data->basket_id)->first();     
        $product=product_model::where('id',$basket->product_id)->first();   
        if($basket->count>1){
            basket_model::where('id',$data->basket_id)->decrement('count');
        }
            return $product;
    }

    function checkProductCount(Request $data){
        $product=product_model::where('id',$data->product_id)->first();
        return $product;
    }

    function removeFromCard(Request $data){
        $id=$data->product_id;
        $count=$data->count;
        // product_model::ux
        basket_model::where('id',$id)->delete();
    }

    function addFeedback(Request $data){
        $feedback=new feedback_model;
        $feedback->user_id=Session::get('userId');
        $feedback->product_id=$data->product_id;
        $feedback->feedback=$data->feedback;
        $feedback->save();
    }
}


$product=new Product;
