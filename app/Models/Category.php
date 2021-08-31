<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //use HasFactory;
	protected $fillable = [
        'category_name','category_icon','created_at', 'updated_at'
    ];
	
	public function products() 
	{
		return $this->hasMany('App\Models\Product')->select('*')->join('order_details','products.idproduct','=','order_details.order_sku')->join('orders','orders.id','=','order_details.order_id');
    }
}
