<?php

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

Route::get('/', 'PagesController@root')->name('root');
Route::get('/test', 'PagesController@test');


// 用戶身份驗證相關路由
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');


//第三方認證相關路由
Route::prefix('login/social')->name('social.')->group(function(){
    Route::get('/{provider}/redirect', 'Auth\SocialController@getSocialRedirect')->name('redirect');
    Route::get('/{provider}/callback', 'Auth\SocialController@getSocialCallback')->name('callback');
});

// 用戶註冊相關路由
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// 密碼重置相關路由
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Email認證相關路由
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');


Route::get('/admin', 'BackEnd\HomeController@landingPage')->name('backend');
Route::get('/admin/users', 'BackEnd\UsersController@IndexPage')->name('admin.users');
Route::get('/admin/users/{user}/edit', 'BackEnd\UsersController@AdminEdit')->name('admin.users.edit');
Route::patch('/admin/users/{user}', 'BackEnd\UsersController@AdminUpdate')->name('admin.users.update');
Route::patch('/admin/users/{user}/publish', 'BackEnd\UsersController@publish')->name('admin.users.publish');

Route::get('/admin/products', 'BackEnd\ProductsController@index')->name('admin.products.index');
Route::get('/admin/products/{product}/edit', 'BackEnd\ProductsController@edit')->name('admin.products.edit');
Route::patch('/admin/products/{product}', 'BackEnd\ProductsController@update')->name('admin.products.update');
Route::delete('/admin/products/{product}', 'Backend\ProductsController@destory')->name('admin.products.destory'); 




Route::get('/chathome', 'UsersController@index')->name('users.home');
Route::get('/users/{user}', 'UsersController@show')->name('users.show');
Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
Route::patch('/users/{user}', 'UsersController@update')->name('users.update');
// Route::get('/users/chathome', 'UsersController@index')->name('users.home');

Route::get('/chats', 'ChatController@index');
Route::get('/chatmessages', 'ChatController@fetchAllMessages');
Route::post('/chatmessages', 'ChatController@sendMessage');

Route::get('/contacts', 'ContactsController@get');
Route::get('/conversation/{id}', 'ContactsController@getMessagesFor');
Route::post('/conversation/send', 'ContactsController@send');


Route::get('/products/create', 'ProductsController@create')->name('products.create');
Route::post('/products/create', 'ProductsController@store')->name('products.store');
Route::get('/products/{product}', 'ProductsController@show')->name('products.show');
Route::get('/products/{product}/edit', 'ProductsController@edit')->name('products.edit');
Route::patch('/products/{product}', 'ProductsController@update')->name('products.update');
Route::delete('/products/{product}', 'ProductsController@destory')->name('products.destory'); 



