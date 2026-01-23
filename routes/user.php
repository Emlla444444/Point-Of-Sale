<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;

Route::group(['middleware'=>'userMiddleware','prefix' => 'user'],function(){
    Route::get('/home',[UserController::class,'userHome'])->name('user#home');
    Route::get('/profile',[UserController::class, 'profilePage'])->name('user#profile');
    Route::post('/profile/{id}',[UserController::class, 'profileUpdate'])->name('user#profileUpdate');
    Route::get('/password',[UserController::class, 'passwordPage'])->name('user#password');
    Route::post('/password',[UserController::class, 'passwordChange'])->name('user#passwordChange');
    Route::get('/product/detail/{id}',[UserController::class, 'productDetail'])-> name('user#productDetail');
    Route::post('/product/comment',[UserController::class, 'comment'])->name('user#comment');
    Route::get('/comment/delete/{id}',[UserController::class, 'delete'])->name('user#commentDelete');
    Route::post('/product/rating',[UserController::class, 'rating'])->name('user#productRating');
    Route::get('/cart/list',[UserController::class, 'cartPage'])->name('user#cartPage');
    Route::post('/cart/list',[UserController::class, 'addCart'])->name('user#addCart');
    Route::get('/delete/cart/{id}',[UserController::class, 'deleteCart'])->name('user#deleteCart');
    Route::get('/payment/list',[UserController::class, 'paymentPage'])->name('user#paymentPage');
    Route::get('/temp/cart',[UserController::class, 'tempCart'])->name('user#tempCart');
    Route::post('/payment',[UserController::class, 'payment'])->name('user#payment');
    Route::get('/order/list',[UserController::class, 'orderListPage'])->name('user#orderListPage');

    Route::get('/contact',[ContactController::class, 'contactPage'])->name('user#contactPage');
    Route::post('/contact',[ContactController::class, 'contact'])->name('user#contact');
});
