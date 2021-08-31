<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Category;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
		$pending = DB::table('orders')
		->select(DB::raw('count(*) as pending'))
		->join('outlets','outlets.id','=','orders.outlet_id')
		//->where('updated_by', '=', Auth::user()->id)
		->whereRaw('order_empty = 2 and order_status is null')
		->first();
		// ->toSql();
		// dd($pending);
		
        return view('sales.change_password', compact('pending'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		if(Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 6) 
		{
			$pending = DB::table('orders')
			->select(DB::raw('count(*) as pending'))
			->join('outlets','outlets.id','=','orders.outlet_id')
			//->where('updated_by', '=', Auth::user()->id)
			->whereRaw('order_empty = 2 and order_status is null')
			->first();
		
			$users = DB::table('users')
			->select('users.id','username','name','role', DB::raw('date(users.updated_at) as login'),'region_name')
			->leftjoin('regions','users.usr_region','=','regions.region_code')
			->leftjoin('provinces','provinces.province_region','=','regions.region_code')
			//->where('updated_by', '=', Auth::user()->id)
			->whereRaw('role IN (3,4,5,6)')
			->groupBy('users.id')
			->get();
		}
		// elseif(Auth::user()->role == 3) 
		// {
			// $pending = DB::table('orders')
			// ->select(DB::raw('count(*) as pending'))
			// ->join('outlets','outlets.id','=','orders.outlet_id')
			// ->where('outlet_region', '=', Auth::user()->current_team_id)
			// ->whereRaw('order_empty = 2 and order_status is null')
			// ->first();
			
			// $users = DB::table('users')
			// ->select('users.id','username','name','role', DB::raw('date(users.updated_at) as login'),'region_name')
			// ->join('regions','users.current_team_id','=','regions.region_code')
			// ->join('provinces','provinces.province_region','=','regions.region_code')
			// ->where('role', '=', 4)
			// ->where('region_code', '=', Auth::user()->current_team_id)
			// ->groupBy('users.id')
			// ->get();
		// }
		
        return view('sales.user_management', compact('pending','users'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		//dd($request->all());
        DB::table('users')
			  ->where('id', $request->id)
			   ->update(['password' => Hash::make($request->password)]);
		
		//return redirect()->route('outlets.show', [$request->outletid])
		return back()
            ->with('success','Password has been saved');
// );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
	
	public function changepassword(Request $request) 
	{
		$pass = $request->password;

		//User::find($request->email)->update(['password' => Hash::make($pass)]);
		DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(['password' => Hash::make($pass)]);
		
		return back()
            ->with('success','Your password has been updated.');
	}
}
