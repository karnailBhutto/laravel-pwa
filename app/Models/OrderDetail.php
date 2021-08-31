<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    //use HasFactory;
	protected $fillable = [
        'order_sku','order_carton','order_pack','order_id','created_at', 'updated_at'
    ];
	
	public function order() 
	{
        return $this->belongsTo('App\Models\Order');
    }
	
}
