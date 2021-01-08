<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class feedback_model extends Model
{
    public $table='feedbacks';

    function get_user(){
    	return $this->belongsTo('App\user_model','user_id');
    }
}
