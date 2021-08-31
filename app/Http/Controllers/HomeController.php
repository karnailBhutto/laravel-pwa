<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {	
		$user = auth()->user();
		$user->updated_at = Carbon::now()->toDateTimeString();
		$user->save();
		
		if(Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 6) 
		{
			if(Auth::user()->id == 44)
			{
				$pending = DB::table('orders')
				->select(DB::raw('count(*) as pending'))
				->join('outlets','outlets.id','=','orders.outlet_id')
				->whereRaw('order_empty = 2 and outlet_region != 00 and order_status is null')
				->first();
			
				$outlets = DB::table('outlets')
				->select('outlets.id')
				->leftjoin('orders','outlets.id','=','orders.outlet_id')
				->whereRaw('outlet_region != 00 and updated_by is not null')
				->whereRaw('date(orders.created_at) = CURDATE()')
				->get();
				
				$orders = DB::table('orders')
				->select('orders.id','orders.updated_at')
				->join('outlets','outlets.id','=','orders.outlet_id')
				//->where('updated_by', '=', Auth::user()->id)
				->where('order_empty', '=', 2)
				->whereRaw('outlet_region != 00 and date(orders.created_at) = CURDATE()')
				->get();
				// ->toSql();
				// dd($orders);
				
				$order_lists = DB::table('outlets')
				->select('orders.id','orders.created_at', DB::raw('SUM(order_carton) as carton'), DB::raw('SUM(order_pack) as packs'),'order_status','outlet_sname','order_empty',DB::raw('date(orders.created_at) as date'))
				->leftjoin('orders','outlets.id','=','orders.outlet_id')
				->leftjoin('order_details','orders.id','=','order_details.order_id')
				//->whereRaw('outlet_id = '.$key)
				->whereRaw('outlet_region != 00 and outlets.outlet_id is not null')
				//->whereRaw('date(outlets.updated_at) = CURDATE() or date(orders.created_at) = CURDATE()')
				->whereRaw('date(orders.created_at) = CURDATE()')
				->groupBy('outlets.id','orders.id')
				->orderBy('orders.id','desc')
				->get();
				// ->toSql();
				// dd($order_lists);
			}
			else
			{
				$pending = DB::table('orders')
				->select(DB::raw('count(*) as pending'))
				->join('outlets','outlets.id','=','orders.outlet_id')
				//->where('updated_by', '=', Auth::user()->id)
				->whereRaw('order_empty = 2 and order_status is null')
				->first();
			
				$outlets = DB::table('outlets')
				->select('outlets.id')
				->leftjoin('orders','outlets.id','=','orders.outlet_id')
				->whereRaw('updated_by is not null')
				->whereRaw('date(orders.created_at) = CURDATE()')
				->get();
				
				$orders = DB::table('orders')
				->select('orders.id','orders.updated_at')
				->join('outlets','outlets.id','=','orders.outlet_id')
				//->where('updated_by', '=', Auth::user()->id)
				->where('order_empty', '=', 2)
				->whereRaw('date(orders.created_at) = CURDATE()')
				->get();
				// ->toSql();
				// dd($orders);
				
				$order_lists = DB::table('outlets')
				->select('orders.id','orders.created_at', DB::raw('SUM(order_carton) as carton'), DB::raw('SUM(order_pack) as packs'),'order_status','outlet_sname','order_empty',DB::raw('date(orders.created_at) as date'))
				->leftjoin('orders','outlets.id','=','orders.outlet_id')
				->leftjoin('order_details','orders.id','=','order_details.order_id')
				//->whereRaw('outlet_id = '.$key)
				->whereRaw('outlets.outlet_id is not null')
				//->whereRaw('date(outlets.updated_at) = CURDATE() or date(orders.created_at) = CURDATE()')
				->whereRaw('date(orders.created_at) = CURDATE()')
				->groupBy('outlets.id','orders.id')
				->orderBy('orders.id','desc')
				->get();
				// ->toSql();
			// dd($order_lists);
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
		
			$outlets = DB::table('outlets')
			->select('outlets.id')
			->leftjoin('orders','outlets.id','=','orders.outlet_id')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->whereRaw('date(orders.created_at) = CURDATE()')
			->get();
			
			$orders = DB::table('orders')
			->select('orders.id','orders.updated_at')
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->where('order_empty', '=', 2)
			->whereRaw('date(orders.created_at) = CURDATE()')
			->get();
			// ->toSql();
			// dd($orders);
			
			$order_lists = DB::table('outlets')
			->select('orders.id','orders.created_at', DB::raw('SUM(order_carton) as carton'), DB::raw('SUM(order_pack) as packs'),'order_status','outlet_sname','order_empty',DB::raw('date(orders.created_at) as date'))
			->leftjoin('orders','outlets.id','=','orders.outlet_id')
			->leftjoin('order_details','orders.id','=','order_details.order_id')
			//->whereRaw('outlet_id = '.$key)
			->whereRaw('outlets.outlet_id is not null')
			->where('outlet_region', '=', Auth::user()->usr_region)
			//->whereRaw('date(outlets.updated_at) = CURDATE() or date(orders.created_at) = CURDATE()')
			->whereRaw('date(orders.created_at) = CURDATE()')
			->groupBy('outlets.id','orders.id')
			->orderBy('orders.id','desc')
			->get();
			// ->toSql();
			// dd($order_lists);
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
		
			$outlets = DB::table('outlets')
			->select('outlets.id')
			->leftjoin('orders','outlets.id','=','orders.outlet_id')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->where('team_id', '=', Auth::user()->id)
			->whereRaw('(date(orders.created_at) = CURDATE()')
			->get();
			
			$orders = DB::table('orders')
			->select('orders.id','orders.updated_at')
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->where('team_id', '=', Auth::user()->id)
			->where('order_empty', '=', 2)
			->whereRaw('date(orders.created_at) = CURDATE()')
			->get();
			// ->toSql();
			// dd($orders);
			
			$order_lists = DB::table('outlets')
			->select('orders.id','orders.created_at', DB::raw('SUM(order_carton) as carton'), DB::raw('SUM(order_pack) as packs'),'order_status','outlet_sname','order_empty',DB::raw('date(orders.created_at) as date'))
			->leftjoin('orders','outlets.id','=','orders.outlet_id')
			->leftjoin('order_details','orders.id','=','order_details.order_id')
			//->whereRaw('outlet_id = '.$key)
			->whereRaw('outlets.outlet_id is not null')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->where('team_id', '=', Auth::user()->id)
			//->whereRaw('date(outlets.updated_at) = CURDATE() or date(orders.created_at) = CURDATE()')
			->whereRaw('date(orders.created_at) = CURDATE()')
			->groupBy('outlets.id','orders.id')
			->orderBy('orders.id','desc')
			->get();
			 //->toSql();
			 //dd($order_lists);
		}
		else 
		{
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('updated_by', '=', Auth::user()->id)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();
		
			$outlets = DB::table('outlets')
			->select('outlets.id')
			->leftjoin('orders','outlets.id','=','orders.outlet_id')
			->where('updated_by', '=', Auth::user()->id)
			->whereRaw('date(orders.created_at) = CURDATE()')
			->get();
			//->toSql();
			//dd($outlets);
			
			$orders = DB::table('orders')
			->select('orders.id','orders.updated_at')
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('updated_by', '=', Auth::user()->id)
			->where('order_empty', '=', 2)
			->whereRaw('date(orders.created_at) = CURDATE()')
			->get();
			//->toSql();
			//dd($orders);
			
			$order_lists = DB::table('outlets')
			->select('orders.id','orders.created_at', DB::raw('SUM(order_carton) as carton'), DB::raw('SUM(order_pack) as packs'),'order_status','outlet_sname','order_empty',DB::raw('date(orders.created_at) as date'))
			->leftjoin('orders','outlets.id','=','orders.outlet_id')
			->leftjoin('order_details','orders.id','=','order_details.order_id')
			//->whereRaw('outlet_id = '.$key)
			->whereRaw('outlets.outlet_id is not null')
			->whereRaw('date(orders.created_at) = CURDATE()')
			->where('outlets.updated_by', '=', Auth::user()->id)
		    	->groupBy('outlets.id','orders.id')
			->orderBy('orders.id','desc')
			->get();
			// ->toSql();
			//dd($order_lists);
		}
		
        return view('dashboard', compact('orders','order_lists','outlets','pending'));
    }
	
	 public function region()
    {
        $region = DB::table("regions")->lists("region_name","region_code");
        return view('register_outlet',compact('region'));
    }


    /**
     * Get Ajax Request and restun Data
     *
     * @return \Illuminate\Http\Response
     */
    public function province($id)
    {
        $province = DB::table("provinces")
                    ->where("province_region",$id)
                    ->lists("province_name","id");
        return json_encode($province);
    }
	
	public function offline()
    {
        $pending = DB::table('orders')
		->select(DB::raw('count(*) as pending'))
		->join('outlets','outlets.id','=','orders.outlet_id')
		->where('updated_by', '=', Auth::user()->id)
		->whereRaw('order_empty = 2 and order_status is null')
		->first();
        return view('offline',compact('pending'));
    }
}
