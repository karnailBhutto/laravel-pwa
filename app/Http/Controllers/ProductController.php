<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
	 public function __construct()
    {
        $this->middleware('auth');

        //$this->middleware('log')->only('index');

        //$this->middleware('subscribed')->except('store');
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$categories = Category::with('Products')->select('id','category_name', DB::raw('(select count(product_sku)+1 from products where category_id = categories.id group by category_id) as total'))->get();
		
		$products =  DB::table("types")
					->join('products','products.product_type','=','types.idtypes')
					->join('brands','brands.idbrands','=','products.brand_id')
                    ->where("item_type", '=',"Basic")
					//->groupBy('idtypes')
					->get();
					
		$products1 =  DB::table("types")
					->join('products','products.product_type','=','types.idtypes')
					->join('brands','brands.idbrands','=','products.brand_id')
                    ->where("item_type", '=',"Basic")
					->where("category_id", '=',1)
					->get();
					
		$products2 =  DB::table("types")
					->join('products','products.product_type','=','types.idtypes')
					->join('brands','brands.idbrands','=','products.brand_id')
                    ->where("item_type", '=',"Basic")
					->where("category_id", '=',2)
					->get();
					
		$products3 =  DB::table("types")
					->join('products','products.product_type','=','types.idtypes')
					->join('brands','brands.idbrands','=','products.brand_id')
                    ->where("item_type", '=',"Basic")
					->where("category_id", '=',3)
					->get();
					
		$products4 =  DB::table("types")
					->join('products','products.product_type','=','types.idtypes')
					->join('brands','brands.idbrands','=','products.brand_id')
                    ->where("item_type", '=',"Basic")
					->where("category_id", '=',4)
					->get();
					
		$categories = DB::table('categories')
		->select('*')
		->get();
		
		$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			//->where('updated_by', '=', Auth::user()->id)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();
		
		return view('sales.master_product', compact('categories','products','products1','products2','products3','products4','pending'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductMaster  $productMaster
     * @return \Illuminate\Http\Response
     */
    public function show(ProductMaster $productMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductMaster  $productMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductMaster $productMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductMaster  $productMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductMaster $productMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductMaster  $productMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductMaster $productMaster)
    {
        //
    }
	
}
