<?php
 
namespace App\Http\Controllers;

use App\Models\Outlet;
use QrCode;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class GenerateQrCodeController extends Controller
{ 
  
	public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function index()
    {
      return view('qrCode');
    }
	
	public function create()
    {
		return view('qrCode_generate');
	}
	
	public function store(Request $request)
    {   //dd($request->all());
	
		$total = $request->code;
		
		// $new = DB::table('outlets')
		// ->select('id')
		// ->orderBy('id', 'DESC')
		// ->first();
		// ->toSql();
		// dd($new);
		
		for ($i=0; $i<$total; $i++) {
			$cc = new Outlet;
			$cc->created_by = auth()->user()->id;
			$cc->save();
			
			$id = $cc->id; 
			
			QrCode::format('png')->size(200)->generate('https://sfa-kh.vindagroupsea.com/outlets/'.$id, public_path('qr_code/'.$id.'.png'));
		}
			return back()
				->with('success','Successfully added');
    }
	
	public function printCode($id)
    {
		$outlets = DB::table('outlets')
		->select('id')
		->where('id', '=', $id)
		//->orderBy('id', 'DESC')
		->first();
		// ->toSql();
		// dd($outlets);
		
        //return view('sales.master_outlet', compact('outlets','pending'));
		$pdf = \App::make('dompdf.wrapper');
		$pdf->setOptions(['isPhpEnabled' => true]);
        $pdf = PDF::loadView('sales/preview_code', ['outlets'=> $outlets])->setPaper('a5', 'potrait')->setWarnings(false);  
        return $pdf->stream();
    }
}

