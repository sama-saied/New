<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use PharIo\Manifest\Url;
 

Route::get('/', 'Homee@show');

Route::get('/main', 'HomeController@index')->middleware('verified');

Route::view('/admin', 'admin.dashboard.index');

Route::get('/CartDisplay/{id}','Site\CarttController@getContent')->name('newcart');
Route::get('/delete/{id}/{ud}', 'Site\CarttController@delete')->name('cart.delete');
Route::get('/ClearCart/{id}', 'Site\CarttController@ClearCart')->name('cart.clear');

Route::group(['middleware' => ['auth']], function () {
  Route::post('/checkoutt/order', 'Site\CheckouttController@placeOrder')->name('checkoutt.place.order');
  Route::get('/getOrder', 'Site\CheckouttController@getOrder')->name('order.new');
 
});

Route::get('/firstproduct', 'Homee@firstproduct')->name('firstproductlink');
Route::get('/secondproduct', 'Homee@secondproduct')->name('secondproductlink');
Route::get('/adlink', 'Homee@adlink')->name('adlink');


 
require 'admin.php';

Auth::routes(['verify' => true]);

Route::get('/category/{slug}', 'Site\CategoryController@show')->name('category.show');
Route::get('/categoryy/{slug}', 'Site\CategoryController@showw')->name('category.showw');
Route::get('/brand/{slug}', 'Site\BrandController@show')->name('brand.show');


Route::get('/product/{slug}', 'Site\ProductController@show')->name('product.show');
Route::get('/products/{price}', 'ProductController@index')->name('products');
Route::group(['middleware' => ['auth']], function () {
Route::post('/product/add/cart', 'Site\ProductController@addToCart')->name('product.add.cart');
});
Route::get('/cart', 'Site\CartController@getCart')->name('checkout.cart');
Route::get('/cart/item/{id}/remove', 'Site\CartController@removeItem')->name('checkout.cart.remove');
Route::get('/cart/clear', 'Site\CartController@clearCart')->name('checkout.cart.clear');
 
Route::get('account/orders', 'Site\AccountController@getOrders')->name('account.orders');
Route::get('orderr/{id}', 'Site\AccountController@delete')->name('order.delete');


 
Route::post('rating', 'Site\RatingController@productProduct')->name('products.product');


Route::post('/product/{slug}', 'Site\ProductController@show')->name('product.show');

Route::post('/comment/{id}', 'CommentController@store')->name('comments.store');


Route::get('search-results', 'Site\SearchController@search')->name('search.result');

Route::get('profile', 'ProfileController@index');
Route::post('profile/{id}', 'ProfileController@update')->name('profile.edit');



Route::group(['middleware' => ['auth']], function () {
  Route::get('/checkout', 'Site\CheckoutController@getCheckout')->name('checkout.index');
  Route::get('/order', 'Site\CheckoutController@getOrder')->name('order.index');
  Route::post('/checkout/order', 'Site\CheckoutController@placeOrder')->name('checkout.place.order');
});

Route::group(['middleware' => ['auth:admin']], function () {



Route::get('/view_admin', 'Admin\AdminController@view')->name('admin.view');
Route::get('/add_admin', 'Admin\AdminController@add')->name('admin.add_admin.add_admin');
Route::get('/delete_admin/{id}', 'Admin\AdminController@delete')->name('admin.delete');
Route::post('/create_admin', 'Admin\AdminController@create')->name('admin.store');


Route::get('/view_comment', 'Admin\CommentControl@view')->name('comment.view');
Route::get('/delete_comment/{id}', 'Admin\CommentControl@delete')->name('comment.delete');
});