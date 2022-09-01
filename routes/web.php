<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\CustomerRegisterController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PassResetController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;
use Illuminate\Support\Facades\Route;
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



Auth::routes();

Route::get('/welcome', [FrontendController::class, 'welcome'])->name('welcome');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/product_details/{product_id}', [FrontendController::class, 'product_details'])->name('product.details');
Route::post('/getSize', [FrontendController::class, 'getsize']);
Route::get('/profile', [FrontendController::class, 'profile'])->name('profile');
Route::post('/profile/update', [FrontendController::class, 'profile_update']);


//Admin dashboard
Route::get('/admin', [FrontendController::class, 'admin']);

// users
Route::post('/add/users', [HomeController::class, 'add_users']);

//Category
Route::get('/category', [CategoryController::class, 'category'])->middleware('mail_role');
Route::post('/category/insert', [CategoryController::class,'insert']);
Route::get('/category/delete/{category_id}', [CategoryController::class, 'delete']);
Route::get('/category/edit/{category_id}', [CategoryController::class, 'edit']);
Route::post('/category/update', [CategoryController::class, 'update']);
Route::get('/category/restore/{category_id}', [CategoryController::class, 'restore']);
Route::get('/category/permanent/delete/{category_id}', [CategoryController::class, 'p_delete']);

//Subcategory
Route::get('/subcategory',[SubcategoryController::class, 'index'])->middleware('mail_role');
Route::post('/subcategory/insert',[SubcategoryController::class, 'insert']);
Route::get('/subcategory/edit/{subcategory_id}', [SubcategoryController::class, 'edit']);
Route::post('/subcategory/update', [SubcategoryController::class, 'update']);
Route::get('/subcategory/delete/{subcategory_id}', [SubcategoryController::class, 'delete']);
Route::get('/subcategory/restore/{subcategory_id}',[SubcategoryController::class, 'restore']);
Route::get('/subcategory/permanent/delete/{subcategory_id}', [SubcategoryController::class, 'p_delete']);


//Profile Edit 
Route::get('/profile/edit', [ProfileController::class, 'profile']);
Route::post('/profile/update', [ProfileController::class, 'update']);
Route::post('/password/update', [ProfileController::class, 'pass_update']);
Route::post('/photo/change', [ProfileController::class, 'photo_change']); 

//Products
Route::get('/add/product', [ProductController::class, 'index'])->name('add.product');
Route::post('/getSubcategory', [ProductController::class, 'getSubcategory']);
Route::post('/product/insert', [ProductController::class, 'insert'])->name('product.insert');

//Color & Size
Route::get('/color/size', [ProductController::class, 'color_size'])->name('color.size');
Route::post('/color/insert', [ProductController::class, 'color_insert']);
Route::post('/size/insert', [ProductController::class,  'size_insert']);

//Inventory
Route::get('/inventory/{product_id}', [ProductController::class, 'inventory'])->name('inventory');
Route::post('/inventory/insert', [ProductController::class, 'inventory_insert']);

// cart 
Route::post('/cart/insert', [CartController::class, 'cart_insert']);
Route::get('/cart/delete/{cart_id}', [CartController::class, 'cart_delete'])->name('cart.delete');
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::post('/cart/update', [CartController::class, 'cart_update']);
Route::get('/cart/clear', [CartController::class, 'cart_clear'])->name('cart.clear');

//Customer 
Route::post('/customer/login', [CustomerLoginController::class, 'customer_login']);
Route::post('/customer/register', [CustomerRegisterController::class, 'customer_register']);
Route::get('/customer/logout', [CustomerLoginController::class, 'customer_logout'])->name('customer.logout');
Route::get('/customer/account',[CustomerController::class, 'account'])->name('customer.account');
Route::get('/customer/register/login', [CustomerRegisterController::class, 'customer_reg'])->name('login_register');

//Auth logout
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Coupon
Route::get('/coupon',[CouponController::class, 'coupon'])->name('coupon'); 
Route::post('/coupon/insert', [CouponController::class, 'coupon_insert']);


// Checkout 
Route::get('/checkout',[CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/getcity', [CheckoutController::class, 'get_city']);
Route::post('/order/insert', [CheckoutController::class, 'order_insert']);
Route::get('/order/success', [CheckoutController::class, 'order_success'])->name('order.success');


// SSLCOMMERZ Start
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

//invoice
Route::get('/invoice/download/{invoice_id}', [CustomerController::class, 'invoice_download'])->name('invoice.download');


//Password Reset
Route::get('/pass/reset',[PassResetController::class, 'pass_reset'])->name('pass.reset');
Route::post('/pass/reset/notification',[PassResetController::class, 'pass_reset_notification'])->name('pass.reset.notification');
Route::get('/pass/reset/form/{reset_token}', [PassResetController::class, 'pass_reset_form'])->name('pass.reset.form');
Route::post('/pass/reset/update', [PassResetController::class, 'pass_reset_update'])->name('pass.reset.update');


//review
Route::post('/review/insert', [FrontendController::class, 'review_insert'])->name('review.insert');

//stripe
Route::get('stripe', [StripePaymentController::class, 'stripe']);
Route::post('stripe',[StripePaymentController::class, 'stripePost'])->name('stripe.post');


// Email Verify
Route::get('/customer/email/verify/{verify_token}', [ProfileController::class, 'email_verify']);
Route::get('/verify/email/success', [ProfileController::class, 'email_verify_success']);

//github login
Route::get('/github/redirect',[GithubController::class, 'RedirectToProvider']);
Route::get('/github/callback',[GithubController::class, 'RedirectToWebsite']);

//google login
Route::get('/google/redirect', [GoogleController::class,'RedirectToProvider']);
Route::get('/google/callback', [GoogleController::class,'RedirectToWebsite']);