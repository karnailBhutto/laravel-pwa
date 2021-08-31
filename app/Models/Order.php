<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //use HasFactory;
	protected $fillable = [
        'order_status','outlet_id','created_at', 'updated_at'
    ];
	
	public function orderdetail()
    {
        // return $this->hasMany('App\Models\OrderDetail')->select('order_id','order_details.updated_at','order_sku', 'category_name', 'product_description','order_carton as carton', 'order_pack as packs')->join('products','products.idproduct','=','order_details.order_sku')->join('categories','categories.id','=','products.product_category');//->groupBy('products.product_category');
		return $this->hasMany('App\Models\OrderDetail')->select('*');
    }
}
