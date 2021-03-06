<?php

use App\Http\Controllers\PostController;
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
Route::post('review/post', 'FrontendController@reviewpost')->name('review.post');
Route::get('search', 'FrontendController@search')->name('search');
Route::get('blogpage', 'FrontendController@blogpage')->name('blogpage');
Route::get('blog/details/{slug}', 'FrontendController@blogdetails');
Route::get('nextpost/{blog_id}', 'FrontendController@nextpost')->name('nextpost');

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

// CheckoutController Route
Route::get('checkout', 'CheckoutController@index');
Route::post('checkout/post', 'CheckoutController@checkoutpost')->name('checkout.post');
Route::post('get/city/list/ajax', 'CheckoutController@getcitylistajax');
// Test link
Route::get('test/sms', 'CheckoutController@testsms');

// Coupon Route
Route::resource('coupon', 'CouponController');
Route::get('coupon/delete/{coupon_id}', 'CouponController@coupondelete')->name('coupon.delete');

// WishlistController Route
Route::get('wishlist', 'WishlistController@index')->name('wishlist');
Route::get('wishlist/store/{product_id}', 'WishlistController@store')->name('wishlist.store');
Route::get('wishlist/remove/{wishlist_id}', 'WishlistController@remove')->name('wishlist.remove');

// CustomerController Route
Route::get('customer/home', 'CustomerController@home')->middleware('verified');
Route::get('customer/invoice/download/{order_id}', 'CustomerController@customerinvoicedownload')->middleware('verified');

// GithubController Route
Route::get('login/github', 'GithubController@redirectToProvider');
Route::get('login/github/callback', 'GithubController@handleProviderCallback');

// StripePaymentController Route
Route::get('stripe', 'StripePaymentController@stripe');
Route::get('stripe/let/{order_id}', 'StripePaymentController@stripelet');
Route::post('stripe', 'StripePaymentController@stripePost')->name('stripe.post');
Route::post('stripe/let/post', 'StripePaymentController@stripeLetPost')->name('stripe.let.post');

// OrderController Route
Route::resource('order', 'OrderController');
Route::get('order/cancel/{order_id}', 'OrderController@cancel')->name('order.cancel');

// SSLCOMMERZ Start
Route::get('/example1', 'SslCommerzPaymentController@exampleEasyCheckout');
Route::get('/example2', 'SslCommerzPaymentController@exampleHostedCheckout');

Route::post('/pay', 'SslCommerzPaymentController@index');
Route::post('/pay-via-ajax', 'SslCommerzPaymentController@payViaAjax');

Route::post('/success', 'SslCommerzPaymentController@success');
Route::post('/fail', 'SslCommerzPaymentController@fail');
Route::post('/cancel', 'SslCommerzPaymentController@cancel');

Route::post('/ipn', 'SslCommerzPaymentController@ipn');
//SSLCOMMERZ END


// Blog_categoryController route start
Route::get('blog/category', 'Blog_categoryController@category')->name('blog.category');
Route::post('blog/category/store', 'Blog_categoryController@categorystore')->name('blog.category.store');
Route::get('blog/category/delete/{category_id}', 'Blog_categoryController@categorydelete')->name('blog.category.delete');
Route::get('blog/category/edit/{category_id}', 'Blog_categoryController@categoryedit')->name('blog.category.edit');
Route::post('blog/category/edit/post', 'Blog_categoryController@categoryeditpost')->name('blog.category.edit.post');
// Blog_categoryController route end

// BlogController route start
Route::resource('blog', 'BlogController');
Route::get('blog/delete/{blog_id}', 'BlogController@delete')->name('blog.delete');
Route::post('blog/comment', 'BlogController@comment')->name('blog.comment');
Route::post('reply/post', 'BlogController@replypost')->name('reply.post');
// BlogController route end