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

Route::get('/search', 'SearchController@index')->name('search');

Route::get('/cart', 'CartController@getCart')->name('cart');

Route::get('/activities/{activity}', 'PagesController@activities')->name('activity.show');


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
Route::patch('/admin/products/{product}/publish', 'BackEnd\ProductsController@publish')->name('admin.products.publish');
Route::delete('/admin/products/{product}', 'Backend\ProductsController@destroy')->name('admin.products.destroy'); 

Route::get('/admin/orders', 'BackEnd\OrdersController@index')->name('admin.orders.index');


// Activity 活動專區
Route::get('/admin/activity', 'BackEnd\ActivityController@index')->name('admin.activity.index');
Route::get('/admin/activity/create', 'BackEnd\ActivityController@create')->name('admin.activity.create');
Route::post('/admin/activity/create', 'BackEnd\ActivityController@store')->name('admin.activity.store');
Route::get('/admin/activity/{activity}/edit', 'BackEnd\ActivityController@edit')->name('admin.activity.edit');
Route::patch('/admin/activity/{activity}', 'BackEnd\ActivityController@update')->name('admin.activity.update');
Route::patch('/admin/activity/{activity}/publish', 'BackEnd\ActivityController@publish')->name('admin.activity.publish');
Route::delete('/admin/activity/{activity}', 'BackEnd\ActivityController@destroy')->name('admin.activity.destroy');



Route::get('/chathome', 'UsersController@index')->name('users.home');
Route::get('/favorites', 'UsersController@getFavorites')->name('users.favorite');
Route::get('/users/{user}', 'UsersController@show')->name('users.show');
Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
Route::get('/users/{user}/products', 'UsersController@products')->name('users.products');
Route::get('/users/{user}/orders', 'UsersController@orders')->name('users.orders');
Route::get('/users/{user}/orders_status', 'UsersController@orders_status')->name('users.orders_status');
Route::post('users/change_password', 'UsersController@edit_password');
Route::patch('/users/{user}', 'UsersController@update')->name('users.update');

Route::post('/payment_option/edit', 'PaymentOptionController@edit');

// Route::get('/users/chathome', 'UsersController@index')->name('users.home');

Route::get('/chats', 'ChatController@index');
Route::get('/chatmessages', 'ChatController@fetchAllMessages');
Route::post('/chatmessages', 'ChatController@sendMessage');

Route::get('/contacts', 'ContactsController@get');
Route::get('/conversation/{id}', 'ContactsController@getMessagesFor');
Route::post('/conversation/send', 'ContactsController@send');

Route::get('/department/{department}', 'DepartmentController@show')->name('department.show');
Route::get('/department/get/{id}', 'ProductsController@getDepartment');
Route::get('/department/products/search','DepartmentController@search');

Route::get('/products', 'ProductsController@index')->name('products.index');
Route::get('/products/create', 'ProductsController@create')->name('products.create');
Route::get('/products/search', 'ProductsController@search')->name('products.search');
Route::post('/products/create', 'ProductsController@store')->name('products.store');
Route::get('/products/{product}', 'ProductsController@show')->name('products.show');
Route::get('/products/{product}/edit', 'ProductsController@edit')->name('products.edit');
Route::patch('/products/{product}', 'ProductsController@update')->name('products.update');
Route::patch('/products/{product}/publish', 'ProductsController@publish')->name('products.publish');
Route::delete('/products/{product}', 'ProductsController@destroy')->name('products.destroy');
Route::delete('/products/product_images/{product_image}', 'ProductsController@imageremove')->name('image.destory');
Route::get('/favorite', 'ProductsController@favoriteProduct');
Route::get('/add-to-cart', 'ProductsController@addToCart')->name('products.add');
Route::delete('/unfavorite', 'ProductsController@unFavoriteProduct')->name('products.unfavorite');
Route::delete('/remove-from-cart', 'ProductsController@removeCart');

// Route::resource('comments', 'CommentsController', ['only' => ['store', 'update', 'edit', 'destroy']]);


Route::post('/comments/create', 'CommentsController@store')->name('comments.store');
Route::post('/comments/{comment}', 'CommentsController@destroy')->name('comments.destroy');
Route::post('/comments/update/{comment}', 'CommentsController@update')->name('comments.update');
Route::post('/comments/comment/get', 'CommentsController@get');


Route::post('/comments/replies/create', 'ReplysController@store')->name('replies.store');
Route::post('/comments/replies/{reply}', 'ReplysController@destroy')->name('replies.destroy');
Route::post('/comments/replies/update/{reply}', 'ReplysController@update')->name('replies.update');
Route::post('/comments/replies/get/{reply}', 'ReplysController@get_reply');


Route::get('/notifications/index', 'NotificationsController@index')->name('notifications.index');
Route::get('/notifications/reset', 'NotificationsController@reset');
Route::post('/notifications/read', 'NotificationsController@read');
Route::get('/notifications/sync', 'NotificationsController@sync');


Route::post('/direct_payment', 'CheckOutController@payment')->name('checkout.payment');
Route::get('/campus_payment','CheckOutController@getCheckOutSession')->name('checkout.session');
Route::get('/campus-payment/confirm','CheckOutController@confirm')->name('checkout.confirm');
Route::post('/checkout','CheckOutController@getCheckOut')->name('checkout.index');



Route::post('/orders/create', 'OrderController@create')->name('order.create');
Route::post('/orders/linepay', 'OrderController@linepay')->name('order.linepay');
Route::post('/orders/change_status', 'OrderController@ChangeStatus')->name('order.status');
Route::post('/orders/apply', 'OrderController@apply')->name('order.apply');
Route::post('/orders/cancel_status', 'OrderController@CancelStatus')->name('order.cancel_status');

Route::delete('/orders/{order}', 'OrderController@destroy')->name('order.destroy');


Route::post('/linepay/edit', 'LinePayController@edit')->name('linepay.edit');
Route::post('/linepay/payment', 'LinePayController@payment')->name('linepay.payment');
Route::post('/linepay/confirm', 'LinePayController@confirm')->name('linepay.confirm');
Route::post('/linepay/refund', 'LinePayController@refund')->name('linepay.refund');














