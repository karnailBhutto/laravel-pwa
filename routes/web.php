<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GenerateQrCodeController;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
    // return view('auth/login');
// });

Route::get('/', ['middleware' => 'auth', function (){
    if(Auth::check())
    {
        return redirect('dashboard');
    }
	else 
	{ 
		return view('auth/login');
	}
}]);

//Route::get('/outlet-sync',[ApiController::class, 'offline']);

Auth::routes();

Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
Route::get('/offline', [HomeController::class, 'offline'])->name('offline');
Route::get('/search', [OutletController::class, 'url'])->name('/search');

Route::resource('outlets', OutletController::class)->only([
    'index', 'create', 'edit', 'show', 'update']);
	
Route::resource('orders', OrderController::class)->only([
    'index', 'create', 'store','edit', 'show', 'update','destroy']);
	
Route::resource('products', ProductController::class)->only([
    'index', 'create', 'store','edit', 'show', 'update','destroy']);
	
Route::resource('users', UserController::class)->only([
    'index', 'create', 'store','edit', 'show', 'update','destroy']);

Route::get('/qr-code', [GenerateQrCodeController::class, 'index'])->name('qr.code.index');
Route::post('/store', [GenerateQrCodeController::class, 'store'])->name('qr.code.store');

Route::get('/master', [OutletController::class, 'master'])->name('master');
Route::get('myform/ajax/{id}',[OutletController::class, 'province'])->name('myform.ajax');
Route::get('myform/town/{id}',[OutletController::class, 'district'])->name('myform.town');
//Route::get('outlets/{id}',[OutletController::class, 'url'])->name('outlets.url');

Route::get('myorder/ajax/{id}',[OrderController::class, 'subbrand'])->name('myorder.ajax');
Route::get('myorder/pack/{id}',[OrderController::class, 'type'])->name('myorder.pack');
Route::get('myorder/prod',[OrderController::class, 'product'])->name('myorder.prod');
Route::get('myorder/prod1/{id}',[OrderController::class, 'product1'])->name('myorder.prod1');
Route::get('myorder/order',[OrderController::class, 'blank'])->name('myorder.blank');
Route::post('status/{id}', [OrderController::class, 'confirm'])->name('orders.status');
Route::get('/history',[OrderController::class, 'history'])->name('orders.history');
Route::get('/report',[OrderController::class, 'report'])->name('orders.report');
Route::get('/reorder/{id}',[OrderController::class, 'reorder'])->name('orders.reorder');
Route::get('/addnew',[OrderController::class, 'addnew'])->name('orders.addnew');

Route::post('/change',[UserController::class, 'changepassword'])->name('users.change');

Route::get('/printCode/{id}',[GenerateQrCodeController::class, 'printCode'])->name('printCode');

Route::post('/outlet-sync',[OutletController::class, 'offline']);
Route::get('/data',[OutletController::class, 'database']);
Route::get('/visit',[OutletController::class, 'visit'])->name('outlets.visit');

Route::post('/order-sync',[OrderController::class, 'offlines']);
Route::post('/detail-sync',[OrderController::class, 'sync']);

