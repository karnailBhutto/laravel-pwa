<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OutletController extends Controller
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
    public function url(Request $request)
    {
		if(Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 6) 
		{
			if(Auth::user()->id == 44)
			{
				$outlets = DB::table('outlets')
				->select('id','outlet_sname')
				->whereRaw('outlet_region != 00 and outlet_id is not null') 
				->get();
				// ->toSql();
				// dd($outlets);
				
				$pending = DB::table('orders')
				->select(DB::raw('count(*) as pending'))
				->join('outlets','outlets.id','=','orders.outlet_id')
				//->where('updated_by', '=', Auth::user()->id)
				->whereRaw('outlet_region != 00 and order_empty = 2 and order_status is null')
				->first();
			}
			else
			{
				$outlets = DB::table('outlets')
				->select('id','outlet_sname')
				->whereRaw('outlet_id is not null') 
				->get();
				// ->toSql();
				// dd($outlets);
				
				$pending = DB::table('orders')
				->select(DB::raw('count(*) as pending'))
				->join('outlets','outlets.id','=','orders.outlet_id')
				//->where('updated_by', '=', Auth::user()->id)
				->whereRaw('order_empty = 2 and order_status is null')
				->first();
			}
		}
		elseif(Auth::user()->role == 3) 
		{
			$outlets = DB::table('outlets')
			->select('id','outlet_sname')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->orderBy('id', 'DESC')
			->get();
			
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();
		}
		elseif(Auth::user()->role == 5) 
		{
			$outlets = DB::table('outlets')
			->select('id','outlet_sname')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->where('team_id', '=', Auth::user()->id)
			->get();
			
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
			$outlets = DB::table('outlets')
			->select('id','outlet_sname')
			->whereRaw('updated_by = '.Auth::user()->id)
			//->whereRaw('updated_by = '.Auth::user()->id.' or updated_by is null') 
			->get();
			// ->toSql();
			// dd($outlets);
			
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('updated_by', '=', Auth::user()->id)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();
		}
        return view('sales.search_outlet', compact('outlets','pending'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sales.register_outlet');
    }
	
	public function master()
    {
		if(Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 6) 
		{
			if(Auth::user()->id == 44)
			{
				$outlets = DB::table('outlets')
				->select('id','outlet_sname')
				->whereRaw('outlet_region != 00 and outlet_id is not null') 
				->orderBy('id', 'DESC')
				->get();
				
				$pending = DB::table('orders')
				->select(DB::raw('count(*) as pending'))
				->join('outlets','outlets.id','=','orders.outlet_id')
				//->where('updated_by', '=', Auth::user()->id)
				->whereRaw('outlet_region != 00 and order_empty = 2 and order_status is null')
				->first();
			}
			else
			{
				$outlets = DB::table('outlets')
				->select('id','outlet_sname')
				->orderBy('id', 'DESC')
				->get();
				
				$pending = DB::table('orders')
				->select(DB::raw('count(*) as pending'))
				->join('outlets','outlets.id','=','orders.outlet_id')
				//->where('updated_by', '=', Auth::user()->id)
				->whereRaw('order_empty = 2 and order_status is null')
				->first();
			}
		}
		elseif(Auth::user()->role == 3) 
		{
			$outlets = DB::table('outlets')
			->select('id','outlet_sname')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->orderBy('id', 'DESC')
			->get();
			// ->toSql();
			// dd($outlets);
			
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();
		}
		elseif(Auth::user()->role == 5) 
		{
			$outlets = DB::table('outlets')
			->select('id','outlet_sname')
			->where('outlet_region', '=', Auth::user()->usr_region)
			->where('team_id', '=', Auth::user()->id)
			->orderBy('id', 'DESC')
			->get();
			
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
			$outlets = DB::table('outlets')
			->select('id','outlet_sname')
			->whereRaw('updated_by = '.Auth::user()->id) 
			->orderBy('id', 'DESC')
			->get();
			// ->toSql();
			// dd($outlets);
			
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			->where('updated_by', '=', Auth::user()->id)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();
		}
        return view('sales.master_outlet', compact('outlets','pending'));
    }
	
	public function details(Request $request)
    {   //dd($request->all());
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
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
   
	public function show(Request $request, Outlet $outlet)
    { //echo $outlet; exit;
		$key = $outlet->id;
		
        $outlets = DB::table('outlets')
		->select('*')
		->where(['id' => $key])
		//->where('id', $request->outlet)
		->first();
		// ->toSql();
		// dd($outlets);
		
		$cities = DB::table('provinces')
		->select('province_code', 'province_name', 'province_region')
		->where(['provinces.province_region' => $outlets->outlet_region])
		//->where('id', $request->outlet)
		->get(); 
		// ->toSql();
		// dd($cities);
		
		$towns = DB::table('districts')
		->select('*')
		->where(['district_province' => $outlets->outlet_province])
		//->where('id', $request->outlet)
		->get(); 
		
		$regions = DB::table("regions")->pluck("region_name","region_code");
		
		$types = DB::table("outlet_types")->pluck("type_description","type_description");
		
		if(Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 6) 
		{
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			//->where('outlet_region', '=', Auth::user()->current_team_id) 
			->whereRaw('order_empty = 2 and order_status is null')
			->first();
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
		
        return view('sales.register_outlet', compact('outlets','regions','cities', 'towns','pending','types'));
    }
	
	 public function index(Request $request, Outlet $outlet)
    { //echo $outlet; exit;
		$key = $request->id;
		
        $outlets = DB::table('outlets')
		->select('*')
		->where(['id' => $key])
		//->where('id', $request->outlet)
		->first();
		// ->toSql();
		// dd($outlets);
		
		$cities = DB::table('provinces')
		->select('province_code', 'province_name', 'province_region')
		->where(['provinces.province_region' => $outlets->outlet_region])
		//->where('id', $request->outlet)
		->get(); 
		// ->toSql();
		// dd($cities);
		
		$towns = DB::table('districts')
		->select('*')
		->where(['district_province' => $outlets->outlet_province])
		//->where('id', $request->outlet)
		->get(); 
		
		$regions = DB::table("regions")->pluck("region_name","region_code");
		
		$types = DB::table("outlet_types")->pluck("type_description","type_description");
		
		if(Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 6) 
		{
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			//->where('outlet_region', '=', Auth::user()->current_team_id) 
			->whereRaw('order_empty = 2 and order_status is null')
			->first();
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
		
        return view('sales.register_outlet', compact('outlets','regions','cities', 'towns','pending','types'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Outlet $outlet)
    {
         $outlets = DB::table('outlets')
		->select('*')
		->where(['id' => $request->outlet])
		//->where('id', $request->outlet)
		->first();
		// ->toSql();
		// dd($outlets);
		
		$cities = DB::table('provinces')
		->select('province_code', 'province_name', 'province_region')
		->where(['provinces.province_region' => $outlets->outlet_region])
		//->where('id', $request->outlet)
		->get(); 
		
		$towns = DB::table('districts')
		->select('*')
		->where(['district_province' => $outlets->outlet_province])
		//->where('id', $request->outlet)
		->get(); 
		
		$regions = DB::table("regions")->pluck("region_name","region_code");
		
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
			->groupBy('orders.id')
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
			->groupBy('orders.id')
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
		
        return view('sales.register_outlet', compact('outlets','regions','cities', 'towns','pending'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Outlet $outlet)
    {  //dd($request->all());
		
		$outlet->update($request->all());
		
		return redirect()->route('outlets.index', ['id='.$request->outletid])
            ->with('success','Outlet details has been saved');
// );
    }
	
	public function visit(Request $request)
    {  //dd($request->all());
		
		DB::table('outlets')
			->where('id', $request->id)
			->update(['updated_at' => Carbon::now()->toDateTimeString()]);
		
		//return redirect()->route('outlets.index', ['id='.$request->outletid])
            //->with('success','Outlet details has been saved');
	}
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Outlet $outlet)
    {
        //
    }


    /**
     * Get Ajax Request and restun Data
     *
     * @return \Illuminate\Http\Response
     */
    public function province($id)
    {
        $provinces = DB::table("provinces")
                    ->where("province_region",$id)
                    ->pluck("province_name","province_code");
        return json_encode($provinces);
    }
	
	 public function district($id)
    {
        $districts = DB::table("districts")
                    ->where("district_province",$id)
                    ->pluck("district_name","iddistricts");
        return json_encode($districts);
    }
	
	public function offline()
    {  
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
		
		DB::table('outlets')
			->where('id', $data['outletid'])
			->update([
				'outlet_id' =>str_pad($data['outletid'], 11, '0', STR_PAD_LEFT),
				'outlet_sname' => $data['outlet_sname'],
				'outlet_type' => $data['outlet_type'],
				'outlet_owner' => $data['outlet_owner'],
				'outlet_contact' => $data['outlet_contact'],
				'outlet_region' => $data['outlet_region'],
				'outlet_province' => $data['outlet_province'],
				'outlet_district' => $data['outlet_district'],
				'outlet_postal' => $data['outlet_postal'],
				'outlet_address' => $data['outlet_address'],
				'updated_by' => $data['updated_by'],
				'team_id'=> $data['team_id'],
				'updated_at'=> Carbon::now()
			]);
			
		//echo "ok";
		return response('success', 200)
            ->header('Content-Type', 'text/plain');
	}
}
