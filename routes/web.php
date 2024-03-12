<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('products.index');
    } else {
        return redirect()->route('login');
    }
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');

Route::get('/create',[App\Http\Controllers\ProductController::class, 'create'])->name('products.create');
Route::post('/create',[App\Http\Controllers\ProductController::class, 'store'])->name('products.store');

Route::get('/show/{id}',[App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

Route::get('/show/{id}/edit',[App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
Route::put('/show/{id}/edit',[App\Http\Controllers\ProductController::class, 'update'])->name('products.update');

Route::delete('/products',[App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('products', ProductController::class);
});
