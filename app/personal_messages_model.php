<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class personal_messages_model extends Model
{
    public $table='personal_messages';

    function incoming_user(){
    	return $this->belongsTo('App\user_model','user_id','id');
    }

    function outcoming_user(){
    	return $this->belongsTo('App\user_model','sender_id','id');
    }

    function parent_product(){
    	return $this->belongsTo('App\product_model','product_id','id');
    }

    function parent_product_images(){
        return $this->hasMany('App\photos_model','product_id','product_id');
    }
}
