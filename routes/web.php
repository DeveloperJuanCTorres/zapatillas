<?php

use Illuminate\Support\Facades\Route;

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
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/tienda', [App\Http\Controllers\HomeController::class, 'tienda'])->name('tienda.products');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact']);
Route::get('/product-detail', [App\Http\Controllers\HomeController::class, 'detail']);
Route::get('/checkout', [App\Http\Controllers\HomeController::class, 'checkout']);

Route::post('add', [App\Http\Controllers\CartController::class, 'add'])->name('add');
Route::get('cart', [App\Http\Controllers\CartController::class, 'cart'])->name('cart');
Route::get('cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('clear');
Route::post('cart/removeitem', [App\Http\Controllers\CartController::class, 'removeItem'])->name('removeitem');
// Route::get('/cart', [App\Http\Controllers\HomeController::class, 'cart']);

Route::get('/apibrand', [App\Http\Controllers\HomeController::class, 'apiBrand'])->name('apibrand');
Route::get('/apicategory', [App\Http\Controllers\HomeController::class, 'apiCategory'])->name('apicategory');
Route::get('/apiproduct', [App\Http\Controllers\HomeController::class, 'apiProduct'])->name('apiproduct');


Route::post('/enviar_pedido', [App\Http\Controllers\HomeController::class, 'pedido'])->name('enviar_pedido');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
