<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_model extends Model
{
    public $table='products';
    public $timestamps=false;

    function parent_user(){
    	return $this->belongsTo('App\user_model','user_id');
    }

    function image_child(){
    	return $this->hasMany('App\photos_model','product_id');
    }

    function getMessage(){
    	return $this->belongsTo('App\messages_model','id','product_id');
    }

}
