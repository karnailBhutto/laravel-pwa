<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //use HasFactory;
	protected $fillable = [
        'product_category','product_sku','product_description','created_at', 'updated_at'
    ];
	
	public function category()
    {
        return $this->belongsTo('App\Models\Categories');//->select('id','category_name',DB::raw('select count(product_sku) as total from products group by category_id'));//->groupBy('products.product_category');
    }
}
