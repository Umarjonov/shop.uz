<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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
    return view('welcome');
});

Route::match(['get','post'],'/admin',[AdminController::class,'login']);
Route::group(['middleware'=>['auth']],function (){
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('settings');
    Route::get('/admin/check-pwd',[AdminController::class,'chkPassword']);
    Route::match(['get','post'],'/admin/update-pwd',[AdminController::class,'updatePassword']);

    Route::match(['get','post'],'/admin/add-category',[CategoryController::class,'addCategory']);
    Route::match(['get','post'],'/admin/edit-category/{id}',[CategoryController::class,'editCategory']);
    Route::match(['get','post'],'/admin/delete-category/{id}',[CategoryController::class,'deleteCategory']);
    Route::get('/admin/view-categories',[CategoryController::class,'viewCategories']);

    Route::match(['get','post'],'/admin/add-product',[ProductController::class,'addProduct']);
    Route::match(['get','post'],'/admin/edit-product/{id}',[ProductController::class,'editProduct']);
    Route::get('/admin/view-products',[ProductController::class,'viewProducts']);
    Route::get('/admin/delete-product-image/{id}',[ProductController::class,'deleteProductImage']);
});

Route::get('/logout', [AdminController::class, 'logout'])->name('logout');


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'test'],function (){
    Route::get('/nishon',function (){
        return view('test.nishon');
    });
});
