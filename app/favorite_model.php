<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class favorite_model extends Model
{
    public $table='favorites';
    public $timestamps=false;

    function parent_product(){
    	return $this->belongsTo('App\product_model','product_id');
    }

    function favorite_images(){
    	return $this->hasMany('App\photos_model','product_id','product_id');
    }
}
