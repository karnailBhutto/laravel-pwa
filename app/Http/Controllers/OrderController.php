<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Category;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
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
    public function index(Request $request)
    { //echo $request->id; exit;
		$key = $request->id;
		
        // $outlets = DB::table('outlets')
		// ->select('id','outlet_id','outlet_sname')
		// ->whereRaw('id = '.$key)
		// ->first();
		
		$outlets = DB::table('orders')
		->select('outlet_sname','outlets.id',DB::raw('date(orders.created_at) as created_at'),'order_status','orders.id as orderid','order_empty','users.username','users.name')
		->rightjoin('outlets','outlets.id','=','orders.outlet_id')
		->join('users','outlets.updated_by','=','users.id')
		->whereRaw('outlets.id = '.$key)
		->first();
		// ->toSql();
		// dd($outlets);
		
		$ada = DB::table('orders')
		->select('id')
		->whereRaw('date(created_at) = CURDATE()')
		->whereRaw('outlet_id = '.$key)
		->get();
		// ->toSql();
		// dd($outlets);
		
		$orders = DB::table('orders')
		->select('orders.id','orders.updated_at', DB::raw('SUM(order_carton) as carton'), DB::raw('SUM(order_pack) as packs'),'order_status','order_empty',DB::raw('date(orders.created_at) as date'))
		->leftjoin('order_details','orders.id','=','order_details.order_id')
		->whereRaw('outlet_id = '.$key)
		//->whereRaw('order_empty = 2')
		->groupBy('orders.id')
		->orderBy('orders.id','desc')
		->get();
		// ->toSql();
		// dd($orders);
		
		$order_details = DB::table('orders')
		->select('*')
		->join('order_details','orders.id','=','order_details.order_id')
		->whereRaw('outlet_id = '.$key)
		->whereRaw('order_empty = 2')
		//->where('order_id', '=', '2020-10-29')
		->get();
		
		if(Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 6) 
		{
			if(Auth::user()->id == 44)
			{
				$pending = DB::table('orders')
				->select(DB::raw('count(*) as pending'))
				->join('outlets','outlets.id','=','orders.outlet_id')
				->whereRaw('order_empty = 2 and outlet_region != 00 and order_status is null')
				->first();
			}
			else
			{
				$pending = DB::table('orders')
				->select(DB::raw('count(*) as pending'))
				->join('outlets','outlets.id','=','orders.outlet_id')
				//->where('outlet_region', '=', Auth::user()->current_team_id) 
				->whereRaw('order_empty = 2 and order_status is null')
				->first();
			}
		}
		elseif(Auth::user()->role == 3) 
		{
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();
		}
		elseif(Auth::user()->role == 5) 
		{
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->where('team_id', '=', Auth::user()->id)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();
		}
		else
		{
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('updated_by', '=', Auth::user()->id)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();

		}
		
        return view('sales.order_history', compact('outlets','orders','order_details','pending','ada'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        /*$key = $request->id;
		
        // $outlets = DB::table('outlets')
		// ->select('id','outlet_id','outlet_sname')
		// ->whereRaw('id = '.$key)
		// ->first();
		// ->toSql();
		// dd($outlets);
		
		$outlets = DB::table('orders')
		->select('outlet_sname','outlets.id',DB::raw('date(orders.created_at) as created_at'),'order_status','orders.id as orderid','order_empty','users.username','users.name')
		->join('outlets','outlets.id','=','orders.outlet_id')
		->join('users','outlets.updated_by','=','users.id')
		->whereRaw('orders.id = '.$key)
		->first();
		
		$order = new Order;
		$order->outlet_id = $request->outlet;
		//$order->feedback = $request->feedback;
		$order->save();
		
		// $orders = DB::table('orders')
		// ->select('orders.id','orders.updated_at', DB::raw('SUM(order_carton) as carton'), DB::raw('SUM(order_pack) as packs'))
		// ->join('order_details','orders.id','=','order_details.order_id')
		// ->whereRaw('outlet_id = '.$key)
		// ->groupBy('order_id')
		// ->get();
		// ->toSql();
		// dd($orders);
		
		$order_details = DB::table('orders')
		->select('*')
		->join('order_details','orders.id','=','order_details.order_id')
		->join('products','products.idproduct','=','order_details.order_sku')
		//->join('categories','categories.id','=','products.product_category')
		->whereRaw('outlet_id = '.$key)
		//->where('order_id', '=', '2020-10-29')
		->get();
		// ->toSql();
		// dd($order_details);
		
		//$orders = Order::with('OrderDetails')->where(['orders.id' => '1'])->get();
		//->toSql();dd($orders);
			//->toSql();
			//dd($orderitem);
		$orders = DB::table('orders')
		->select('orders.id','order_empty')
		->join('outlets','outlets.id','=','orders.outlet_id')
		->whereRaw('outlets.id = '.$key.' and date(orders.created_at) = CURDATE()')
		->first();
		
		$categories = DB::table('categories')
		->select('*')
		->join('products','products.category_id','=','categories.id')
		->whereRaw("product_country IN(1,3)")
		->groupBy('id')
		->get();
		
		$brands = DB::table('brands')
		->select('*')
		//->whereRaw('outlet_id = '.$key)
		//->where('created_at', '=', '2020-10-29')
		->get();
		
		$types = DB::table('types')
		->select('*')
		//->whereRaw('outlet_id = '.$key)
		//->where('created_at', '=', '2020-10-29')
		->get();
		
		if(Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 6) 
		{
			if(Auth::user()->id == 44)
			{
				$pending = DB::table('orders')
				->select(DB::raw('count(*) as pending'))
				->join('outlets','outlets.id','=','orders.outlet_id')
				->whereRaw('order_empty = 2 and outlet_region != 00 and order_status is null')
				->first();
			}
			else
			{
				$pending = DB::table('orders')
				->select(DB::raw('count(*) as pending'))
				->join('outlets','outlets.id','=','orders.outlet_id')
				//->where('outlet_region', '=', Auth::user()->current_team_id) 
				->whereRaw('order_empty = 2 and order_status is null')
				->first();
			}
		}
		elseif(Auth::user()->role == 3) 
		{
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();
		}
		elseif(Auth::user()->role == 5) 
		{
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->where('team_id', '=', Auth::user()->id)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();
		}
		else
		{
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('updated_by', '=', Auth::user()->id)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();

		}
		
        return view('sales.order_cart', compact('outlets','orders','categories','brands','types','order_details','pending'));*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   //dd($request->all());
	
		$sku = $request->sku;
		$carton = $request->carton;
		$pack= $request->packs;
		//$outlet= $request->outlet;
		
		if($request->order_no != 0) { 
			
			$id = $request->order_no; 
			
			// DB::table('orders')
			// ->where('id', $id)
			// ->whereRaw('date(created_at) = CURDATE()')
			// ->update(['order_empty' => $id]);
			
			foreach($sku as $key => $no)
			{
				$input['order_sku'] = $no;
				$input['order_carton'] = $carton[$key];
				$input['order_pack'] = $pack[$key];
				$input['order_id'] = $id;

				OrderDetail::create($input);
			}
			
			$remove = DB::delete('delete from order_details where order_id ='.$id.' and order_carton is null and order_pack is null');
		}
		else 
		{
			$order = new Order;
			$order->outlet_id = $request->outlet;
			$order->save();
			
			foreach($sku as $key => $no)
			{
				$id = $order->id;
				
				$input['order_sku'] = $no;
				$input['order_carton'] = $carton[$key];
				$input['order_pack'] = $pack[$key];
				$input['order_id'] = $id;

				OrderDetail::create($input);
			}
			
			$remove = DB::delete('delete from order_details where order_id ='.$id.' and order_carton is null and order_pack is null');
		}
		
		$details = DB::table('order_details')
			->select('*')
			->where('order_id', '=', $id)
			->get();
			
		$count = count($details); 
		
        // return back()
            // ->with('success',$count.' SKUs has been added to your order cart');
		return redirect()->route('orders.edit', [$id])
            ->with('success',$count.' SKUs has been added to your order cart');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
		$outlets = DB::table('orders')
		->select('outlet_sname','outlets.id',DB::raw('date(orders.created_at) as created_at'),'order_status','orders.id as orderid','order_empty','users.username','users.name')
		->join('outlets','outlets.id','=','orders.outlet_id')
		->join('users','outlets.updated_by','=','users.id')
		->whereRaw('orders.id = '.$order->id)
		->first();
		
		$orders = DB::table('orders')
		->select('*')
		->join('order_details','orders.id','=','order_details.order_id')
		->join('products','products.idproduct','=','order_details.order_sku')
		->join('categories','categories.id','=','products.category_id')
		->join('outlets','outlets.id','=','orders.outlet_id')
		->whereRaw('order_id = '.$order->id)
		->get();
		// ->toSql();
		// dd($categories);
		
		//$categories = Category::with('Products')->select('id','category_name', DB::raw('(select count(product_sku)+1 from products where category_id = categories.id group by category_id) as total'))->get();
		// ->toSql();
		// dd($categories);
		
		
		$category1 = DB::table('categories')
		->select('*')
		->join('products','products.category_id','=','categories.id')
		->join('order_details','order_details.order_sku','=','products.idproduct')
		->join('orders','orders.id','=','order_details.order_id')
		->whereRaw('order_id = '.$order->id)
		->where('categories.id', '=', '1')
		->get();
		// ->toSql();
		// dd($category1);
		
		$category2 = DB::table('categories')
		->select('*')
		->join('products','products.category_id','=','categories.id')
		->join('order_details','order_details.order_sku','=','products.idproduct')
		->join('orders','orders.id','=','order_details.order_id')
		->whereRaw('order_id = '.$order->id)
		->where('categories.id', '=', '2')
		->get();
		
		$category3 = DB::table('categories')
		->select('*')
		->join('products','products.category_id','=','categories.id')
		->join('order_details','order_details.order_sku','=','products.idproduct')
		->join('orders','orders.id','=','order_details.order_id')
		->whereRaw('order_id = '.$order->id)
		->where('categories.id', '=', '3')
		->get();
		
		$category4 = DB::table('categories')
		->select('*')
		->join('products','products.category_id','=','categories.id')
		->join('order_details','order_details.order_sku','=','products.idproduct')
		->join('orders','orders.id','=','order_details.order_id')
		->whereRaw('order_id = '.$order->id)
		->where('categories.id', '=', '4')
		->get();
		
		$categories = DB::table('categories')
		->select('*')
		->join('products','products.category_id','=','categories.id')
		->whereRaw("product_country IN(1,3)")
		->groupBy('id')
		->get();
		
		$brands = DB::table('brands')
		->select('*')
		//->whereRaw('outlet_id = '.$key)
		//->where('created_at', '=', '2020-10-29')
		->get();
		
		$types = DB::table('types')
		->select('*')
		//->whereRaw('outlet_id = '.$key)
		//->where('created_at', '=', '2020-10-29')
		->get();
		
		if(Auth::user()->role == 1 || Auth::user()->role == 2|| Auth::user()->role == 6) 
		{
			if(Auth::user()->id == 44)
			{
				$pending = DB::table('orders')
				->select(DB::raw('count(*) as pending'))
				->join('outlets','outlets.id','=','orders.outlet_id')
				->whereRaw('order_empty = 2 and outlet_region != 00 and order_status is null')
				->first();
			}
			else
			{
				$pending = DB::table('orders')
				->select(DB::raw('count(*) as pending'))
				->join('outlets','outlets.id','=','orders.outlet_id')
				//->where('outlet_region', '=', Auth::user()->current_team_id) 
				->whereRaw('order_empty = 2 and order_status is null')
				->first();
			}
		}
		elseif(Auth::user()->role == 3) 
		{
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->where('team_id', '=', Auth::user()->id)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();
		}
		elseif(Auth::user()->role == 5) 
		{
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->where('team_id', '=', Auth::user()->id)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();
		}
		else
		{
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('updated_by', '=', Auth::user()->id)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();

		}
		
        return view('sales.order_cart_show', compact('outlets','brands','types','orders','category1','category2','category3','category4','categories','pending'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
		 $outlets = DB::table('outlets')
		->select('outlets.id','orders.outlet_id','outlet_sname', 'users.name')
		->join('users','users.id','=','outlets.updated_by')
		->join('orders','orders.outlet_id','=','outlets.id')
		->whereRaw('orders.id = '.$order->id)
		->first();
		// ->toSql();
		// dd($outlets);
		
        $order1 = DB::table('orders')
		->select('*')
		->whereRaw('id = '.$order->id)
		->first();
		
		$orders = DB::table('orders')
		->select('*')
		->join('order_details','orders.id','=','order_details.order_id')
		->join('products','products.idproduct','=','order_details.order_sku')
		->join('categories','categories.id','=','products.category_id')
		->join('outlets','outlets.id','=','orders.outlet_id')
		->whereRaw('order_id = '.$order->id)
		->get();
		// ->toSql();
		// dd($categories);
		
		//$categories = Category::with('Products')->select('id','category_name', DB::raw('(select count(product_sku)+1 from products where category_id = categories.id group by category_id) as total'))->get();
		// ->toSql();
		// dd($categories);
		
		
		$category1 = DB::table('categories')
		->select('orders.id','order_carton','order_pack','order_sku','order_details.id as iddetails','product_description','category_name')
		->join('products','products.category_id','=','categories.id')
		->join('order_details','order_details.order_sku','=','products.idproduct')
		->join('orders','orders.id','=','order_details.order_id')
		->whereRaw('order_id = '.$order->id)
		->where('categories.id', '=', '1')
		->get();
		// ->toSql();
		// dd($category1);
		
		$category2 = DB::table('categories')
		->select('orders.id','order_carton','order_pack','order_sku','order_details.id as iddetails','product_description','category_name')
		->join('products','products.category_id','=','categories.id')
		->join('order_details','order_details.order_sku','=','products.idproduct')
		->join('orders','orders.id','=','order_details.order_id')
		->whereRaw('order_id = '.$order->id)
		->where('categories.id', '=', '2')
		->get();
		
		$category3 = DB::table('categories')
		->select('orders.id','order_carton','order_pack','order_sku','order_details.id as iddetails','product_description','category_name')
		->join('products','products.category_id','=','categories.id')
		->join('order_details','order_details.order_sku','=','products.idproduct')
		->join('orders','orders.id','=','order_details.order_id')
		->whereRaw('order_id = '.$order->id)
		->where('categories.id', '=', '3')
		->get();
		
		$category4 = DB::table('categories')
		->select('orders.id','order_carton','order_pack','order_sku','order_details.id as iddetails','product_description','category_name')
		->join('products','products.category_id','=','categories.id')
		->join('order_details','order_details.order_sku','=','products.idproduct')
		->join('orders','orders.id','=','order_details.order_id')
		->whereRaw('order_id = '.$order->id)
		->where('categories.id', '=', '4')
		->get();
		
		$categories = DB::table('categories')
		->select('*')
		->join('products','products.category_id','=','categories.id')
		->whereRaw("product_country IN(1,3)")
		->groupBy('id')
		->get();
		
		$brands = DB::table('brands')
		->select('*')
		//->whereRaw('outlet_id = '.$key)
		//->where('created_at', '=', '2020-10-29')
		->get();
		
		$types = DB::table('types')
		->select('*')
		//->whereRaw('outlet_id = '.$key)
		//->where('created_at', '=', '2020-10-29')
		->get();
		
		if(Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 6)  
		{
			if(Auth::user()->id == 44)
			{
				$pending = DB::table('orders')
				->select(DB::raw('count(*) as pending'))
				->join('outlets','outlets.id','=','orders.outlet_id')
				->whereRaw('order_empty = 2 and outlet_region != 00 and order_status is null')
				->first();
			}
			else
			{
				$pending = DB::table('orders')
				->select(DB::raw('count(*) as pending'))
				->join('outlets','outlets.id','=','orders.outlet_id')
				//->where('outlet_region', '=', Auth::user()->current_team_id) 
				->whereRaw('order_empty = 2 and order_status is null')
				->first();
			}
		}
		elseif(Auth::user()->role == 3) 
		{
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();
		}
		elseif(Auth::user()->role == 5) 
		{
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->where('team_id', '=', Auth::user()->id)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();
		}
		else
		{
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('updated_by', '=', Auth::user()->id)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();

		}
		
        return view('sales.order_cart_edit', compact('outlets','brands','types','orders','order1','category1','category2','category3','category4','categories','pending'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    { 
        //dd($request->all());
		if($request->has('sku1')) { //echo('lalu'); exit;
			$sku1 = $request->sku1;
			$carton1 = $request->carton1;
			$pack1 = $request->packs1;
			
			foreach($sku1 as $key => $no)
			{
				OrderDetail::where('id',$no)
				->update([
					'order_carton'=>$carton1[$key],
					'order_pack'=>$pack1[$key]
				]);
			}
		}
		
		if($request->has('sku2')) { 
			$sku2 = $request->sku2;
			$carton2 = $request->carton2;
			$pack2 = $request->packs2;
			
			foreach($sku2 as $key => $no)
			{
				OrderDetail::where('id',$no)
				->update([
					'order_carton'=>$carton2[$key],
					'order_pack'=>$pack2[$key]
				]);
			}
		}
		
		if($request->has('sku3')) { 
			$sku3 = $request->sku3;
			$carton3 = $request->carton3;
			$pack3 = $request->packs3;
			
			foreach($sku3 as $key => $no)
			{
				OrderDetail::where('id',$no)
				->update([
					'order_carton'=>$carton3[$key],
					'order_pack'=>$pack3[$key]
				]);
			}
		}
		
		if($request->has('sku4')) { 
			$sku4 = $request->sku4;
			$carton4 = $request->carton4;
			$pack4 = $request->packs4;
			
			foreach($sku4 as $key => $no)
			{
				OrderDetail::where('id',$no)
				->update([
					'order_carton'=>$carton4[$key],
					'order_pack'=>$pack4[$key]
				]);
			}
		}
			
        return back()
            ->with('success','Order cart has been updated');
		// return redirect()->route('orders.edit', [$id])
            // ->with('success',$count.' SKUs has been added to your order cart');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Order $order)
    {
		//dd($request->all());
        $orderdetail = OrderDetail::find($request->id1);
		$orderdetail->delete();
		
		return back()
            ->with('success','SKUs has been deleted');
    }
	
	 public function subbrand($id)
    {
        // $subbrand = DB::connection("sqlite")
					// ->table("brands")
					// ->select('*')
                    // ->whereRaw("brand_category= $id")
					// ->get()
                    // ->pluck("brand_image","idbrands");
        // return json_encode($subbrand);
		 $subbrand = DB::table("brands")
                    ->where("brand_category",$id)
                    ->pluck("brand_image","idbrands");
        return json_encode($subbrand);
    }
	
	public function type($id)
    {
        // $type = DB::connection("sqlite")
					// ->table("types")
					// ->select("*")
					// ->join("products","products.product_type","=","types.idtypes")
					// ->whereRaw("type_brand LIKE '%$id%'")
					// ->whereRaw("product_country IN(1,3)")
					// ->whereRaw("brand_id =$id")
					// ->groupBy("idtypes")
					// ->get()
					// ->pluck("type_description","idproduct");
					// ->toSql();
					// dd($type);
					
        // return json_encode($type);
		
		$type = DB::table("types")
					->join('products','products.product_type','=','types.idtypes')
                    //->whereIn("type_brand",$id)
					->whereRaw('FIND_IN_SET('.$id.',type_brand)')
					->whereRaw("product_country IN(1,3)")
					->where("brand_id",$id)
					->groupBy('idtypes')
                    ->pluck("type_description","idproduct");
					// ->toSql();
					// dd($type);
        return json_encode($type);
    }
	
	public function product(Request $request)
    { //dd($request->all());
		$id = $request->id; 
		
        $type = DB::table("types")
					->join('products','products.product_type','=','types.idtypes')
                    ->where("idproduct",$id)
					->whereRaw("product_country IN(1,3)")
					->groupBy('idtypes')
					->first();
					// ->toSql();
					// dd($type);
					
		$product = DB::table("products")
                    ->where("product_type",$type->idtypes)
					->whereRaw("item_type = 'Basic'")		
					->where("brand_id",$type->brand_id)
					->get()
                    ->pluck("product_description","idproduct");
					// ->toSql();
					// dd($product);
					
        return json_encode($product);
    }
	
	public function product1(Request $request, $id)
    { //dd($request->all());
		//$id = $request->id; 
		$order = $request->order;
		
		$type = DB::table("types")
					->join('products','products.product_type','=','types.idtypes')
                    ->where("idproduct",$id)
					->whereRaw("product_country IN(1,3)")
					->groupBy('idtypes')
					->first();
					
		$product = DB::table("products")
                    ->where("product_type",$type->idtypes)
					->whereRaw("item_type = 'Basic'")		
					->where("brand_id",$type->brand_id)
					->whereRaw("idproduct not in(select order_sku from order_details where order_id =".$order.") ")
                    ->pluck("product_description","idproduct");
		
        // $type = DB::connection("sqlite")
					// ->table("types")
					// ->select("*")
					// ->join("products","products.product_type","=","types.idtypes")
                    // ->whereRaw("idproduct = $id")
					// ->whereRaw("product_country IN(1,3)")
					// ->groupBy("idtypes")
					// ->first();
					// ->toSql();
					// dd($type);
					
		// $product = DB::connection("sqlite")
					// ->table("products")
					// ->select("product_description","idproduct")
                    // ->where("product_type",$type->idtypes)
					// ->whereRaw("item_type = 'Basic'")		
					// ->where("brand_id",$type->brand_id)
					// ->whereRaw("idproduct not in(select order_sku from order_details where order_id =".$order.") ")
					// ->get()
                    // ->pluck("product_description","idproduct");
					// ->toSql();
					// dd($product);
					
        return json_encode($product);
    }
	
	public function blank(Request $request)
    {
		$id = $request->id;
		$order = $request->order;
		$outlet = $request->outlet;
		
        if($order == 0)
		{
			$order = new Order;
			$order->outlet_id = $outlet;
			$order->order_empty = $id;
			$order->save();
		}
		else 
		{ 
			DB::table('orders')
			->where('id', $order)
			->whereRaw('date(created_at) = CURDATE()')
			->update(['order_empty' => $id]);
		}
		
		//return redirect()->route('orders.index', ['id' => $outlet]);
		//return view('dashboard');

    }
	
	public function confirm(Request $request, $id)
	{ 
			DB::table('orders')
			->where('id', $id)
			//->whereRaw('date(created_at) = CURDATE()')
			->update(['order_status' => 1]);
			// return back()
				// ->with('success','Order line has been confirmed');
			return redirect()->route('orders.show', [$id])
            ->with('success', 'Order line has been confirmed');
	}
	
	public function history(Request $request)
	{ 
		//dd($request->all());
		if(isset($request->start)) {$start = $request->start; } else { $start = date('d.m.Y',strtotime('first day of last month -1 month')); }
		if(isset($request->ends)) {$end = $request->ends; } else { $end = date('Y-m-d'); }
		
		if(isset($request->status)) {
			if($request->status == 1) { $status = 'order_status = 1 and order_empty = 2'; } elseif($request->status == 2) { $status = 'order_status is null and order_empty = 2'; } elseif($request->status == 3) { $status = 'order_status is null and order_empty = 1'; }
		}
		else { $status = ''; }
		
		$location1 = $request->status; 
		$start1 = $request->start;
		$end1 = $request->ends;
		
		if(Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 6)  
		{
			if(Auth::user()->id == 44)
			{
				$pending = DB::table('orders')
				->select(DB::raw('count(*) as pending'))
				->join('outlets','outlets.id','=','orders.outlet_id')
				//->where('outlet_region', '=', Auth::user()->current_team_id) 
				->whereRaw('outlet_region != 00 and order_empty = 2 and order_status is null')
				->first();
				
				$orders = DB::table('orders')
				->select('orders.id','orders.updated_at', DB::raw('SUM(order_carton) as carton'), DB::raw('SUM(order_pack) as packs'), 'order_status','order_empty','outlet_sname', DB::raw('date(orders.created_at) as date'))
				->leftjoin('order_details','orders.id','=','order_details.order_id')
				->join('outlets','outlets.id','=','orders.outlet_id')
				->whereRaw('outlet_region != 00')
				->when($status, function ($q) use ($status) {
					return $q->whereRaw($status);
				})
				->when($start, function ($q) use ($start,$end) {
					return $q->whereRaw('date(orders.created_at) between "'.date("Y-m-d",strtotime($start)).'" and "'.date("Y-m-d",strtotime($end)).'"');
				})
				->groupBy('orders.id')
				->get();
			}
			else
			{
				$pending = DB::table('orders')
				->select(DB::raw('count(*) as pending'))
				->join('outlets','outlets.id','=','orders.outlet_id')
				//->where('outlet_region', '=', Auth::user()->current_team_id) 
				->whereRaw('order_empty = 2 and order_status is null')
				->first();
				
				$orders = DB::table('orders')
				->select('orders.id','orders.updated_at', DB::raw('SUM(order_carton) as carton'), DB::raw('SUM(order_pack) as packs'), 'order_status','order_empty','outlet_sname', DB::raw('date(orders.created_at) as date'))
				->leftjoin('order_details','orders.id','=','order_details.order_id')
				->join('outlets','outlets.id','=','orders.outlet_id')
				//->where('outlet_region', '=', Auth::user()->current_team_id)
				//->where('outlets.updated_by', '=', Auth::user()->id)
				->when($status, function ($q) use ($status) {
					return $q->whereRaw($status);
				})
				->when($start, function ($q) use ($start,$end) {
					return $q->whereRaw('date(orders.created_at) between "'.date("Y-m-d",strtotime($start)).'" and "'.date("Y-m-d",strtotime($end)).'"');
				})
				->groupBy('orders.id')
				->get();
				// ->toSql();
				// dd($orders);
			}
		}
		elseif(Auth::user()->role == 3)  
		{
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();
			// ->toSql();
			// dd($pending);
			
			$orders = DB::table('orders')
			->select('orders.id','orders.updated_at', DB::raw('SUM(order_carton) as carton'), DB::raw('SUM(order_pack) as packs'),'order_status','order_empty','outlet_sname',DB::raw('date(orders.created_at) as date'))
			->leftjoin('order_details','orders.id','=','order_details.order_id')
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('outlet_region', '=', Auth::user()->usr_region)
			//->where('outlets.updated_by', '=', Auth::user()->id)
			->when($status, function ($q) use ($status) {
				return $q->whereRaw($status);
			})
			->when($start, function ($q) use ($start,$end) {
				return $q->whereRaw('date(orders.created_at) between "'.date("Y-m-d",strtotime($start)).'" and "'.date("Y-m-d",strtotime($end)).'"');
			})
			->groupBy('orders.id')
			->orderBy('orders.id','desc')
			->get();
			// ->toSql();
			// dd($orders);
		}
		elseif(Auth::user()->role == 5)  
		{
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->where('team_id', '=', Auth::user()->id)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();
			// ->toSql();
			// dd($pending);
			
			$orders = DB::table('orders')
			->select('orders.id','orders.updated_at', DB::raw('SUM(order_carton) as carton'), DB::raw('SUM(order_pack) as packs'),'order_status','order_empty','outlet_sname',DB::raw('date(orders.created_at) as date'))
			->leftjoin('order_details','orders.id','=','order_details.order_id')
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->where('team_id', '=', Auth::user()->id)
			//->where('outlets.updated_by', '=', Auth::user()->id)
			->when($status, function ($q) use ($status) {
				return $q->whereRaw($status);
			})
			->when($start, function ($q) use ($start,$end) {
				return $q->whereRaw('date(orders.created_at) between "'.date("Y-m-d",strtotime($start)).'" and "'.date("Y-m-d",strtotime($end)).'"');
			})
			->groupBy('orders.id')
			->orderBy('orders.id','desc')
			->get();
			// ->toSql();
			// dd($orders);
		}
		else
		{
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('updated_by', '=', Auth::user()->id)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();
			
			$orders = DB::table('orders')
			->select('orders.id','orders.updated_at', DB::raw('SUM(order_carton) as carton'), DB::raw('SUM(order_pack) as packs'),'order_status','order_empty','outlet_sname',DB::raw('date(orders.created_at) as date'))
			->leftjoin('order_details','orders.id','=','order_details.order_id')
			->join('outlets','outlets.id','=','orders.outlet_id')
			//->where('outlet_region', '=', Auth::user()->current_team_id)
			->where('outlets.updated_by', '=', Auth::user()->id)
			->when($status, function ($q) use ($status) {
				return $q->whereRaw($status);
			})
			->when($start, function ($q) use ($start,$end) {
				return $q->whereRaw('date(orders.created_at) between "'.date("Y-m-d",strtotime($start)).'" and "'.date("Y-m-d",strtotime($end)).'"');
			})
			->groupBy('orders.id')
			->orderBy('orders.id','desc')
			->get();
			// ->toSql();
			// dd($orders);

		}
		
        return view('sales.history_order', compact('orders','pending','location1','start1','end1'));
	}
	
	public function report(Request $request)
	{ 
		//dd($request->all());
		if(isset($request->start)) {$start = $request->start; } else { $start = date('d.m.Y',strtotime('first day of last month -1 month')); }
		if(isset($request->ends)) {$end = $request->ends; } else { $end = date('Y-m-d'); }
		
		//if($request->has('status')) {
		if($request->status == 1) { $status = 'order_status = 1 and order_empty = 2'; } elseif($request->status == 2) { $status = 'order_status is null and order_empty = 2'; } elseif($request->status == 3) { $status = 'order_status is null and order_empty = 1'; } else { $status = $request->status; }
		// }
		// else { $status = $request->status; }

		
		$region = $request->region;
		$province = $request->province;
		//$sales = $request->sales;
		
		// $cities = DB::table('provinces')
		// ->select('idprovince', 'province_name')
		//->where("province_region",$province)
		// ->get(); 
		
		if(Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 6)  
		{  
			if(Auth::user()->id == 44)
			{
				//$regions = DB::table("regions")->pluck("region_name","region_code");
				$regions = DB::table('regions')
				->select('region_code', 'region_name')
				->whereRaw('region_code != 00') 
				->get(); 
				
				$cities = DB::table("provinces")->pluck("province_name","province_code");
			
				$orders = DB::table('orders as b')
				->select('b.id', DB::raw('date(b.created_at) as tarikh'), DB::raw('SUM(order_carton) as carton'), DB::raw('SUM(order_pack) as packs'), DB::raw('(select sum(order_carton) from order_details join products on order_details.order_sku = products.idproduct where category_id = 1 and order_id = b.id) as drypers_carton'), DB::raw('(select sum(order_pack) from order_details join products on order_details.order_sku = products.idproduct where category_id = 1 and order_id = b.id) as drypers_pack'),DB::raw('(select sum(order_carton) from order_details join products on order_details.order_sku = products.idproduct where category_id = 2 and order_id = b.id) as libresse_carton'), DB::raw('(select sum(order_pack) from order_details join products on order_details.order_sku = products.idproduct where category_id = 2 and order_id = b.id) as libresse_pack'),'order_status','order_empty','outlet_sname','users.name','province_name','region_name','outlet_contact','district_name','outlet_type','orders.updated_at')
				->leftjoin('order_details as a','b.id','=','a.order_id')
				->join('outlets','outlets.id','=','b.outlet_id')
				->join('users','users.id','=','outlets.updated_by')
				->join('regions','regions.region_code','=','outlets.outlet_region')
				->join('provinces','provinces.province_code','=','outlets.outlet_province')
				->join('districts','districts.iddistricts','=','outlets.outlet_district')
				->whereRaw('outlet_region != 00') 
				->when($status, function ($q) use ($status) {
					return $q->whereRaw($status);
				})
				->when($start, function ($q) use ($start,$end) {
					return $q->whereRaw('date(b.created_at) between "'.date("Y-m-d",strtotime($start)).'" and "'.date("Y-m-d",strtotime($end)).'"');
				})
				->when($region, function ($q) use ($region) {
					return $q->whereRaw('outlet_region = '.$region);
				})
				->when($province, function ($q) use ($province) {
					return $q->whereRaw('outlet_province = '.$province);
				})
				// ->when($sales, function ($q) use ($sales) {
					// return $q->where('users.id', $sales);
				// })
				->groupBy('b.id')
				->get();
				// ->toSql();
				// dd($orders);
				
				$location1 = $request->status; 
				$start1 = $request->start;
				$end1 = $request->ends;
				$region1 = $request->region;
				$province1 = $request->province;
				
				$pending = DB::table('orders')
				->select(DB::raw('count(*) as pending'))
				->join('outlets','outlets.id','=','orders.outlet_id')
				->whereRaw('outlet_region != 00 and order_empty = 2 and order_status is null')
				->first();
			}
			else
			{
				//$regions = DB::table("regions")->pluck("region_name","region_code");
				$regions = DB::table('regions')
				->select('region_code', 'region_name')
				//->where("province_region",$province)
				->get(); 
				$cities = DB::table("provinces")->pluck("province_name","province_code");
			
				$orders = DB::table('orders as b')
				->select('b.id', DB::raw('date(b.created_at) as tarikh'), DB::raw('SUM(order_carton) as carton'), DB::raw('SUM(order_pack) as packs'), DB::raw('(select sum(order_carton) from order_details join products on order_details.order_sku = products.idproduct where category_id = 1 and order_id = b.id) as drypers_carton'), DB::raw('(select sum(order_pack) from order_details join products on order_details.order_sku = products.idproduct where category_id = 1 and order_id = b.id) as drypers_pack'),DB::raw('(select sum(order_carton) from order_details join products on order_details.order_sku = products.idproduct where category_id = 2 and order_id = b.id) as libresse_carton'), DB::raw('(select sum(order_pack) from order_details join products on order_details.order_sku = products.idproduct where category_id = 2 and order_id = b.id) as libresse_pack'),'order_status','order_empty','outlet_sname','users.name','province_name','region_name','outlet_contact','district_name','outlet_type','orders.updated_at')
				->leftjoin('order_details as a','b.id','=','a.order_id')
				->join('outlets','outlets.id','=','b.outlet_id')
				->join('users','users.id','=','outlets.updated_by')
				->join('regions','regions.region_code','=','outlets.outlet_region')
				->join('provinces','provinces.province_code','=','outlets.outlet_province')
				->join('districts','districts.iddistricts','=','outlets.outlet_district')
				->when($status, function ($q) use ($status) {
					return $q->whereRaw($status);
				})
				->when($start, function ($q) use ($start,$end) {
					return $q->whereRaw('date(b.created_at) between "'.date("Y-m-d",strtotime($start)).'" and "'.date("Y-m-d",strtotime($end)).'"');
				})
				->when($region, function ($q) use ($region) {
					return $q->whereRaw('outlet_region = '.$region);
				})
				->when($province, function ($q) use ($province) {
					return $q->whereRaw('outlet_province = '.$province);
				})
				// ->when($sales, function ($q) use ($sales) {
					// return $q->where('users.id', $sales);
				// })
				->groupBy('b.id')
				->get();
				// ->toSql();
				// dd($orders);
				
				$location1 = $request->status; 
				$start1 = $request->start;
				$end1 = $request->ends;
				$region1 = $request->region;
				$province1 = $request->province;
				
				$pending = DB::table('orders')
				->select(DB::raw('count(*) as pending'))
				->join('outlets','outlets.id','=','orders.outlet_id')
				->whereRaw('order_empty = 2 and order_status is null')
				->first();
			}
		}
		elseif(Auth::user()->role == 3)  
		{
			$regions = DB::table('regions')
			->select('region_code', 'region_name')
			->where("region_code",Auth::user()->user_region)
			->get(); 
			$cities = DB::table("provinces")->pluck("province_name","province_code");
		
			$orders = DB::table('orders as b')
			->select('b.id', DB::raw('date(b.created_at) as tarikh'), DB::raw('SUM(order_carton) as carton'), DB::raw('SUM(order_pack) as packs'), DB::raw('(select sum(order_carton) from order_details join products on order_details.order_sku = products.idproduct where category_id = 1 and order_id = b.id) as drypers_carton'), DB::raw('(select sum(order_pack) from order_details join products on order_details.order_sku = products.idproduct where category_id = 1 and order_id = b.id) as drypers_pack'),DB::raw('(select sum(order_carton) from order_details join products on order_details.order_sku = products.idproduct where category_id = 2 and order_id = b.id) as libresse_carton'), DB::raw('(select sum(order_pack) from order_details join products on order_details.order_sku = products.idproduct where category_id = 2 and order_id = b.id) as libresse_pack'),'order_status','order_empty','outlet_sname','users.name','province_name','region_name','outlet_contact','district_name','outlet_type','orders.updated_at')
			->leftjoin('order_details','b.id','=','order_details.order_id')
			->join('outlets','outlets.id','=','b.outlet_id')
			->join('users','users.id','=','outlets.updated_by')
			->join('regions','regions.region_code','=','outlets.outlet_region')
			->join('provinces','provinces.province_code','=','outlets.outlet_province')
			->join('districts','districts.iddistricts','=','outlets.outlet_district')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->when($status, function ($q) use ($status) {
				return $q->whereRaw($status);
			})
			->when($start, function ($q) use ($start,$end) {
				return $q->whereRaw('date(b.created_at) between "'.date("Y-m-d",strtotime($start)).'" and "'.date("Y-m-d",strtotime($end)).'"');
			})
			->when($region, function ($q) use ($region) {
				return $q->where('outlet_region', $region);
			})
			->when($province, function ($q) use ($province) {
				return $q->where('outlet_province', $province);
			})
			// ->when($sales, function ($q) use ($sales) {
				// return $q->where('users.id', $sales);
			// })
			->groupBy('b.id')
			->get();
			// ->toSql();
			// dd($orders);
			
			$location1 = $request->status; 
			$start1 = $request->start;
			$end1 = $request->ends;
			$region1 = $request->region;
			$province1 = $request->province;
			
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();
		}
		elseif(Auth::user()->role == 5) 
		{
			$regions = DB::table('regions')
			->select('region_code', 'region_name')
			->where("region_code",Auth::user()->user_region)
			->first(); 
			$cities = DB::table("provinces")->pluck("province_name","province_code");
		 
			$orders = DB::table('orders as b')
			->select('b.id', DB::raw('date(b.created_at) as tarikh'), DB::raw('SUM(order_carton) as carton'), DB::raw('SUM(order_pack) as packs'), DB::raw('(select sum(order_carton) from order_details join products on order_details.order_sku = products.idproduct where category_id = 1 and order_id = b.id) as drypers_carton'), DB::raw('(select sum(order_pack) from order_details join products on order_details.order_sku = products.idproduct where category_id = 1 and order_id = b.id) as drypers_pack'),DB::raw('(select sum(order_carton) from order_details join products on order_details.order_sku = products.idproduct where category_id = 2 and order_id = b.id) as libresse_carton'), DB::raw('(select sum(order_pack) from order_details join products on order_details.order_sku = products.idproduct where category_id = 2 and order_id = b.id) as libresse_pack'),'order_status','order_empty','outlet_sname','users.name','province_name','region_name','outlet_contact','district_name','outlet_type','orders.updated_at')
			->leftjoin('order_details','b.id','=','order_details.order_id')
			->join('outlets','outlets.id','=','b.outlet_id')
			->join('users','users.id','=','outlets.updated_by')
			->join('regions','regions.region_code','=','outlets.outlet_region')
			->join('provinces','provinces.province_code','=','outlets.outlet_province')
			->join('districts','districts.iddistricts','=','outlets.outlet_district')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->where('team_id', '=', Auth::user()->id)
			->when($status, function ($q) use ($status) {
				return $q->whereRaw($status);
			})
			->when($start, function ($q) use ($start,$end) {
				return $q->whereRaw('date(b.created_at) between "'.date("Y-m-d",strtotime($start)).'" and "'.date("Y-m-d",strtotime($end)).'"');
			})
			->when($region, function ($q) use ($region) {
				return $q->where('outlet_region', $region);
			})
			->when($province, function ($q) use ($province) {
				return $q->where('outlet_province', $province);
			})
			// ->when($sales, function ($q) use ($sales) {
				// return $q->where('users.id', $sales);
			// })
			->groupBy('b.id')
			->get();
			// ->toSql();
			// dd($orders);
			
			$location1 = $request->status; 
			$start1 = $request->start;
			$end1 = $request->ends;
			$region1 = $request->region;
			$province1 = $request->province;
			//$sa1es = $request->sales;
			
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->where('team_id', '=', Auth::user()->id)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();
		}	
		// else
		// {
			
		// }
		
        return view('sales.summary_report', compact('orders','pending','location1','start1','end1','regions','cities','region1','province1'));
	}
	
	public function reorder($id)
    {   //dd($request->all());
	
		$orders = DB::table('orders')
		->select('*')
		->where('id', '=', $id)
		->first();
		
		$order = new Order;
		$order->outlet_id = $orders->outlet_id;
		$order->save();
		
		$newid = $order->id;
			
		$details = DB::table('order_details')
		->select('*')
		->where('order_id', '=', $id)
		->get();
		// ->toSql();
		// dd($details);
		
		//$sku = $details->order_sku;  
		// print_r($details->order_sku); exit();
		// $carton = $details->order_carton;
		// $pack = $details->order_pack;
		
		foreach($details as $key)
			{
				$input['order_sku'] = $key->order_sku;
				$input['order_carton'] = $key->order_carton;
				$input['order_pack'] = $key->order_pack;
				$input['order_id'] = $newid;

				OrderDetail::create($input);
			}
		
		// for($i=0; $i<count($details); $i++)
		// {  
			// OrderDetail::insert([
				// 'order_sku'=>$details->order_sku[$i],
				// 'order_carton'=>$details->order_carton[$i],
				// 'order_pack'=>$details->order_pack[$i],
				// 'order_id'=>$newid
			// ]);
		// }
			
		$det = DB::table('order_details')
			->select('*')
			->where('order_id', '=', $newid)
			->get();
			
		$count = count($det); 
		
        // return back()
            // ->with('success',$count.' SKUs has been added to your order cart');
		return redirect()->route('orders.edit', [$newid])
            ->with('success',$count.' SKUs has been added to your order cart');
    }
	
	public function addnew(Request $request, Order $order)
    {
		$key = $request->id;
		
        $outlets = DB::table('outlets')
		->select('outlets.id','outlet_id','outlet_sname', 'users.name')
		->join('users','users.id','=','outlets.updated_by')
		->whereRaw('outlets.id = '.$key)
		->first();
		// ->toSql();
		// dd($outlets);
		
		// $order = new Order;
		// $order->outlet_id = $key;
		// $order->save();
		
		// $orderid = $order->id;
		
        $order1 = DB::table('orders')
		->select('*')
		->whereRaw('outlet_id = '.$key.' and date(created_at) = CURDATE()')
		->first();
		// ->toSql();
		// dd($outlets);
		
		$orders = DB::table('orders')
		->select('*')
		->leftjoin('order_details','orders.id','=','order_details.order_id')
		->leftjoin('products','products.idproduct','=','order_details.order_sku')
		->join('categories','categories.id','=','products.category_id')
		->join('outlets','outlets.id','=','orders.outlet_id')
		->whereRaw('outlets.id = '.$key.' and date(orders.created_at) = CURDATE()')
		->get();
		// ->toSql();
		// dd($categories);
		
		$category1 = DB::table('categories')
		->select('orders.id','order_carton','order_pack','order_sku','order_details.id as iddetails','product_description','category_name')
		->join('products','products.category_id','=','categories.id')
		->join('order_details','order_details.order_sku','=','products.idproduct')
		->join('orders','orders.id','=','order_details.order_id')
		->whereRaw('orders.outlet_id = '.$key.' and date(orders.created_at) = CURDATE()')
		->where('categories.id', '=', '1')
		->get();
		// ->toSql();
		// dd($category1);
		
		$category2 = DB::table('categories')
		->select('orders.id','order_carton','order_pack','order_sku','order_details.id as iddetails','product_description','category_name')
		->join('products','products.category_id','=','categories.id')
		->join('order_details','order_details.order_sku','=','products.idproduct')
		->join('orders','orders.id','=','order_details.order_id')
		->whereRaw('orders.outlet_id = '.$key.' and date(orders.created_at) = CURDATE()')
		->where('categories.id', '=', '2')
		->get();
		
		$category3 = DB::table('categories')
		->select('orders.id','order_carton','order_pack','order_sku','order_details.id as iddetails','product_description','category_name')
		->join('products','products.category_id','=','categories.id')
		->join('order_details','order_details.order_sku','=','products.idproduct')
		->join('orders','orders.id','=','order_details.order_id')
		->whereRaw('orders.outlet_id = '.$key.' and date(orders.created_at) = CURDATE()')
		->where('categories.id', '=', '3')
		->get();
		
		$category4 = DB::table('categories')
		->select('orders.id','order_carton','order_pack','order_sku','order_details.id as iddetails','product_description','category_name')
		->join('products','products.category_id','=','categories.id')
		->join('order_details','order_details.order_sku','=','products.idproduct')
		->join('orders','orders.id','=','order_details.order_id')
		->whereRaw('orders.outlet_id = '.$key.' and date(orders.created_at) = CURDATE()')
		->where('categories.id', '=', '4')
		->get();
		
		$categories = DB::table('categories')
		->select('*')
		->join('products','products.category_id','=','categories.id')
		->whereRaw("product_country IN(1,3)")
		->groupBy('id')
		->get();
		
		$brands = DB::table('brands')
		->select('*')
		//->whereRaw('outlet_id = '.$key)
		//->where('created_at', '=', '2020-10-29')
		->get();
		
		$types = DB::table('types')
		->select('*')
		//->whereRaw('outlet_id = '.$key)
		//->where('created_at', '=', '2020-10-29')
		->get();
		
		if(Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 6) 
		{
			if(Auth::user()->id == 44)
			{
				$pending = DB::table('orders')
				->select(DB::raw('count(*) as pending'))
				->join('outlets','outlets.id','=','orders.outlet_id')
				->whereRaw('order_empty = 2 and outlet_region != 00 and order_status is null')
				->first();
			}
			else
			{
				$pending = DB::table('orders')
				->select(DB::raw('count(*) as pending'))
				->join('outlets','outlets.id','=','orders.outlet_id')
				//->where('outlet_region', '=', Auth::user()->current_team_id) 
				->whereRaw('order_empty = 2 and order_status is null')
				->first();
			}
		}
		elseif(Auth::user()->role == 3) 
		{
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();
		}
		elseif(Auth::user()->role == 5) 
		{
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->where('team_id', '=', Auth::user()->id)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();
		}
		else
		{
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('updated_by', '=', Auth::user()->id)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();

		}
		
        return view('sales.order_cart_edit', compact('outlets','order1','brands','types','orders','category1','category2','category3','category4','categories','pending'));
    }
	
	public function offlines()
    {  
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
		
		$input['outlet_id'] = $data['outlet_id'];
		$input['order_status'] = $data['order_status'];
		$input['order_empty'] = $data['order_empty'];
		$input['created_at'] = $data['created_at'];

		Order::create($input);
	
		return response('success', 200)
            ->header('Content-Type', 'text/plain');
	}
	
	public function sync()
    {  
		$json = file_get_contents('php://input');
		$value = json_decode($json,true);
		 
		$order = DB::table('orders')
		->select('*')
		->whereRaw('outlet_id = '.$value["outlet_id"].' and date(created_at) = CURDATE()')
		->first();
		
		if($value['cartons'] == '' && $value['packs'] == '') 
		{ } 
		else {
			$input['order_sku'] = $value['sku'];
			$input['order_carton'] = $value['cartons'];
			$input['order_pack'] = $value['packs'];
			$input['order_id'] = $order->id;

			OrderDetail::create($input);
		}
		
		return response('success', 200)
            ->header('Content-Type', 'text/plain');
	}
}
