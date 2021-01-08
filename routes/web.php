<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can 	register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/signup','Registration@signup');
Route::get('/toSignupPage','Registration@toSignupPage');
Route::get('/checkuser/{id}/{hash}','Registration@checkuser');
Route::get('/','Registration@login');
Route::get('/login','Registration@login');
Route::post('/signup_form','Registration@signup_form');
Route::post('/login_form','Registration@login_form');
Route::get('/account','Account@getData')->middleware('checkuser');
Route::get('/messages','Account@toMessages')->middleware('checkuser');
Route::get('/logout','Account@logOut');
Route::post('/changeData','Account@changeData')->middleware('checkuser');
Route::post('/showPseudocategories','Product@showPseudocategories')->middleware('checkuser');
Route::get('/toAddProduct','Product@toAddProduct')->middleware('checkuser');
Route::post('/addProduct','Product@addProduct')->middleware('checkuser');
Route::post('/search','Product@search')->middleware('checkuser');
Route::post('/categoryProduct','Product@categoryProductShow')->middleware('checkuser');
Route::post('/getPseudoCategories','Product@getPseudoCategories')->middleware('checkuser');
Route::get('/myproducts','Product@showMyProducts')->middleware('checkuser');
Route::get('/favorite','Account@tofavorite')->middleware('checkuser');
Route::get('/toMainPage','Product@toMainPage')->middleware('checkuser');
Route::get('/item/{productId}','Product@toItemPage')->middleware('checkuser','activatedproduct');
Route::post('/sendMessage','Product@sendMessage');
Route::get('/user/{userId}','Product@toUserProducts');
Route::post('/deleteProduct','Product@deleteProduct')->middleware('checkuser');
Route::post('/changeProductData','Product@changeProduct')->middleware('checkuser');
Route::post('/checkingForFavorite','Product@checkingForFavorite');
Route::post('/addToFavorites','Product@addToFavorites')->middleware('checkuser');
Route::post('/removeFromFavorites','Product@removeFromFavorites')->middleware('checkuser');
Route::post('/removeFromFavoritesItem','Product@removeFromFavoritesItem')->middleware('checkuser');
Route::get('/basket','Account@toBasket')->middleware('checkuser');
Route::post('/addToBasket','Product@addToBasket');
Route::post('/removeFromCard','Product@removeFromCard');
Route::get('/forgetPassword','Account@toRecoveryPage');
Route::post('/recoverMessage','Account@recoverMessage');
Route::post('/recoverPassword','Account@recoverPassword');
Route::post('/sendCode','Account@checkingCode');
Route::post('/plusBasketCount','Product@plusBasketCount');
Route::post('/minusBasketCount','Product@minusBasketCount');
Route::post('/checkProductCount','Product@checkProductCount');
Route::post('/pricetosession','StripePaymentController@priceToSession');
Route::get('/stripe', 'StripePaymentController@stripe')->middleware('checkuser');
Route::post('/stripe', 'StripePaymentController@stripePost')->name('stripe.post');
Route::get('/orders','Account@toOrders')->middleware('checkuser');
Route::post('/addFeedback','Product@addFeedback');
Route::get('/admin','Account@toAdminPage')->middleware('checkuser','isadmin');
Route::post('/block','AdminController@blockUser');
Route::post('/unblock','AdminController@unblockUser');
Route::post('/confirmProduct','AdminController@confirmProduct');
Route::post('/sendReason','AdminController@sendReason');
Route::get('/outcoming','Account@toOutcoming');
Route::get('/incoming','Account@toIncoming');
Route::get('/message/{messageId}','Messages_controller@toMessage')->middleware('checkuser');
Route::post('/sendNewMessage','Messages_controller@sendNewMessage')->middleware('checkuser');
Route::post('/sendResponce','Messages_controller@sendResponce')->middleware('checkuser');