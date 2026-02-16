<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminDashboard;

//admin dashboard
Route::group(['middleware'=>['adminMiddleware','auth'],'prefix'=>'admin'],function(){
    Route::get('/home',[AdminDashboard::class,'dashboard'])->name('admin#home');

    Route::group(['prefix'=>'category'], function(){
        Route::get('/list',[CategoryController::class,'list'])->name('category#list');
        Route::post('/create',[CategoryController::class,'create'])->name('category#create');
        Route::get('/delete/{id}',[CategoryController::class,'deleteCategory'])->name('category#delete');
        Route::get('/edit/{id}',[CategoryController::class,'editCategory'])->name('category#edit');
        Route::post('/update/{id}',[CategoryController::class,'updateCategory'])->name('category#update');
    });

    Route::group(['prefix'=>'product'], function(){
        Route::get('/list',[ProductController::class,'list'])->name('product#list');
        Route::get('/create',[ProductController::class,'create'])->name('product#create');
        Route::post('/create',[ProductController::class,'createProduct'])->name('product#add');
        Route::get('/delete/{id}',[ProductController::class,'deleteProduct'])->name('product#delete');
        Route::get('/edit/{id}',[ProductController::class,'editProduct'])->name('product#edit');
        Route::post('/update/{id}',[ProductController::class,'updateProduct'])->name('product#update');
        Route::get('/detail/{id}',[ProductController::class,'detailProduct'])->name('product#detail');
    });

    Route::group(['prefix'=>'payment'], function(){
        Route::get('/list',[PaymentController::class,'list'])->name('payment#list');
        Route::post('/pay',[PaymentController::class,'pay'])->name('payment#pay');
        Route::get('/delete/{id}',[PaymentController::class,'delete'])->name('payment#delete');
        Route::get('/edit/{id}',[PaymentController::class,'edit'])->name('payment#edit');
        Route::post('/update/{id}',[PaymentController::class,'update'])->name('payment#update');
    });

    Route::group(['prefix'=>'profile'],function(){
        Route::get('/detail',[AdminProfileController::class,'detail'])->name('profile#detail');
        Route::get('/edit',[AdminProfileController::class,'edit'])->name('profile#edit');
        Route::post('/update/{id}',[AdminProfileController::class,'update'])->name('profile#update');
        Route::get('/password/change',[AdminProfileController::class,'changePassword'])->name('profile#changePassword');
        Route::post('/password/change',[AdminProfileController::class,'passwordChange'])->name('profile#passwordChange');

        Route::group(['middleware'=>'superAdminMiddleware'],function(){
        Route::get('/add/admin',[AdminProfileController::class,'addAdmin'])->name('profile#addAdmin');
        Route::post('/add/admin',[AdminProfileController::class,'adminCreate'])->name('profile#adminCreate');
        Route::get('{accountType}/list',[AdminProfileController::class,'accountList'])->name('profile#accountList');
        Route::get('/delete/{id}',[AdminProfileController::class,'adminDelete'])->name('payment#adminDelete');
        Route::get('/admin/detail/{id}',[AdminProfileController::class,'adminAccDetail'])->name('profile#adminAccDetail');
        Route::get('/user/detail/{id}',[AdminProfileController::class,'userAccDetail'])->name('profile#userAccDetail');
        });
    });

    Route::group(['prefix'=>'order'], function(){
        Route::get('/list',[OrderController::class,'list'])->name('order#list');
        Route::get('/detail/{order_code}',[OrderController::class,'detail'])->name('order#detail');
        Route::get('/reject',[OrderController::class,'reject'])->name('order#reject');
        Route::get('/accept',[OrderController::class,'accept'])->name('order#accept');
        Route::get('/order/list',[OrderController::class,'orderList'])->name('order#orderList');
        Route::get('/reject/list',[OrderController::class,'rejectList'])->name('order#rejectList');
        Route::get('/sale/info',[OrderController::class,'saleInfo'])->name('order#saleInfo');
    });

    Route::group(['prefix'=>'contact'], function(){
        Route::get('/list',[ContactController::class,'listPage'])->name('contact#list');
    });

});
