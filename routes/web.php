<?php

use Illuminate\Support\Facades\Route;

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

// FrontendController Route
Route::get('/', 'FrontendController@index');
Route::get('contact', 'FrontendController@contact')->name('contact');
Route::post('contact/insert', 'FrontendController@contactinsert')->name('contactinsert');
Route::get('contact/view', 'FrontendController@contactview')->name('contactview');
Route::get('product/details/{slug}', 'FrontendController@productdetails');
Route::get('about', 'FrontendController@about');
Route::get('our/service', 'FrontendController@ourservice');
Route::get('shop', 'FrontendController@shop')->name('shop');
Route::get('page/faq', 'FrontendController@faqpage')->name('faqpage');
Route::get('customer/register', 'FrontendController@customerregister');
Route::post('customer/register/post', 'FrontendController@customerregisterpost');

// ContactController Route (Admin panel)
Route::get('contact/upload/download/{contact_id}', 'ContactController@contactuploaddownload');

// TestController Route
Route::get('test', 'TestController@index');
Route::post('test_form_post', 'TestController@test_form_post');

Auth::routes(['verify' => true]);

// HomeController Route
Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::get('send/newsletter', 'HomeController@sendnewsletter');

// CategoryController Route
Route::get('add/category', 'CategoryController@addcategory')->name('addcategory');
Route::post('add/category/post', 'CategoryController@addcategorypost');
Route::get('delete/category/{category_id}', 'CategoryController@deletecategory');
Route::get('edit/category/{category_id}', 'CategoryController@editcategory');
Route::post('edit/category/post', 'CategoryController@editcategorypost');
Route::get('restore/category/{category_id}', 'CategoryController@restorecategory');
Route::post('mark/restore/category', 'CategoryController@markrestorecategory');
Route::get('forcedelete/category/{category_id}', 'CategoryController@forcedeletecategory');
Route::post('mark/delete/category', 'CategoryController@markdeletecategory');

// profileController Route
Route::get('profile', 'profileController@profile');
Route::post('edit/profile/post', 'profileController@editprofilepost');
Route::post('edit/password/post', 'profileController@editpasswordpost');
Route::post('change/profile/photo', 'profileController@changeprofilephoto');

// productController Route
Route::resource('product', 'ProductController');
Route::get('product/alert/delete/{product_id}', 'ProductController@alertdelete')->name('product_alert_delete');
Route::get('product/forcedelete/{product_id}', 'ProductController@forcedelete')->name('product_force_delete');
Route::get('restore/product/{product_id}', 'ProductController@restoreproduct')->name('restore_product');

// Testimonial Route
Route::resource('testimonial', 'TestimonialController');
Route::get('testimonial/delete/{testimonial_id}', 'TestimonialController@testimonialdelete')->name('testimonialdelete');
Route::post('markdeletetestimonial', 'TestimonialController@markdeletetestimonial')->name('markdeletetestimonial');

// Banner Route
Route::resource('banner', 'BannerController');
Route::get('banner/delete/{banner_id}', 'BannerController@bannerdelete')->name('bannerdelete');
Route::post('markdeletebanner', 'BannerController@markdeletebanner')->name('markdeletebanner');

// Faq Controller Route
Route::resource('faq', 'FaqController');
Route::get('faqdelete/{faq_id}', 'FaqController@delete')->name('faqdelete');
Route::post('markdeletefaq', 'FaqController@markdeletefaq')->name('markdeletefaq');

// CartController Route
Route::get('cart', 'CartController@index')->name('cart');
Route::get('cart/{coupon_name}', 'CartController@index')->name('cart.index');
Route::post('cart/store', 'CartController@store')->name('cart.store');
Route::get('cart.remove/{cart_id}', 'CartController@remove')->name('cart.remove');
Route::post('cart.update', 'CartController@update')->name('cart.update');

// Coupon Route
Route::resource('coupon', 'CouponController');
Route::get('coupon/delete/{coupon_id}', 'CouponController@coupondelete')->name('coupon.delete');

// WishlistController Route
Route::get('wishlist', 'WishlistController@index')->name('wishlist');
Route::get('wishlist/store/{product_id}', 'WishlistController@store')->name('wishlist.store');
Route::get('wishlist.remove/{wishlist_id}', 'WishlistController@remove')->name('wishlist.remove');