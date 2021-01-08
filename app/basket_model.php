<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class basket_model extends Model
{
 	public $table='basket';
 	public $timestamps=false;

 	function parent_product(){
    	return $this->belongsTo('App\product_model','product_id');
 	}

 	function product_images(){
 		return $this->hasMany('App\photos_model','product_id','product_id');
 	}

}
