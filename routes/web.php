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
Route::group(['middleware'=>['auth'],'prefix' => 'admin'],function (){
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::get('/check-pwd',[AdminController::class,'chkPassword']);
    Route::match(['get','post'],'/update-pwd',[AdminController::class,'updatePassword']);

    Route::match(['get','post'],'/add-category',[CategoryController::class,'addCategory']);
    Route::match(['get','post'],'/edit-category/{id}',[CategoryController::class,'editCategory']);
    Route::match(['get','post'],'/delete-category/{id}',[CategoryController::class,'deleteCategory']);
    Route::get('/view-categories',[CategoryController::class,'viewCategories']);

    Route::match(['get','post'],'/add-product',[ProductController::class,'addProduct']);
    Route::match(['get','post'],'/edit-product/{id}',[ProductController::class,'editProduct']);
    Route::get('/view-products',[ProductController::class,'viewProducts']);
    Route::get('/delete-product/{id}',[ProductController::class,'deleteProduct']);
    Route::get('/delete-product-image/{id}',[ProductController::class,'deleteProductImage']);

    //product attribute routes
    Route::match(['get','post'],'/add-attributes/{id}',[ProductController::class,'addAttributes']);
});

Route::get('/logout', [AdminController::class, 'logout'])->name('logout');


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'test'],function (){
    Route::get('/nishon',function (){
        return view('test.nishon');
    });
});
