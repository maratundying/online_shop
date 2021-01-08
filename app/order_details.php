<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order_details extends Model
{
    public $table='order_details';

    function get_data(){
    	return $this->hasMany('App\product_model','id','product_id');
    }
}
