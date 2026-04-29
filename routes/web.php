<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BkashController;
use App\Http\Controllers\BkashRefundController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\FoodController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReservationController;


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


Route::get("/", [HomeController::class, 'index']);
Route::get("/search", [HomeController::class, 'search'])->name('search');

Route::post("/register/confirm", [HomeController::class, 'register'])->name('register/confirm')->middleware('throttle:5,1');
Route::get("/verify-otp", [\App\Http\Controllers\OtpController::class, 'showVerifyForm'])->name('otp.verify');
Route::post("/verify-otp", [\App\Http\Controllers\OtpController::class, 'verify'])->name('otp.verify.submit')->middleware('throttle:5,1');
Route::get("/resend-otp", [\App\Http\Controllers\OtpController::class, 'resend'])->name('otp.resend')->middleware('throttle:3,1');

Route::get("/redirects", [HomeController::class, 'redirects']);

#Route::get("/menu",'App\Http\Controllers\MenuController@menu');
Route::get('/menu', [MenuController::class, 'menu'])->name('menu');

Route::middleware(['auth'])->group(function () {
    Route::get('/trace-my-order', [ShipmentController::class, 'trace'])->name('trace-my-order');
    Route::get('/my-order', [ShipmentController::class, 'my_order'])->name('my-order');

    Route::get("/rate/{id}", [HomeController::class, 'rate'])->name('rate');
    Route::get("edit/rate/{id}", [HomeController::class, 'edit_rate'])->name('edit/rate');
    Route::get("delete/rate", [HomeController::class, 'delete_rate'])->name('delete/rate');
    Route::get("/rate/confirm/{value}", [HomeController::class, 'store_rate'])->name('rate.confirm');

    Route::post("coupon/apply", [ShipmentController::class, 'coupon_apply'])->name('coupon/apply');

    Route::get("/cart", [CartController::class, 'index'])->name('cart');
    Route::post('/menu/{product}', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/checkout/{total}', [CartController::class, 'checkout'])->name('cart.checkout');

    Route::post('/mails/shipped/{total}', [ShipmentController::class, 'place_order'])->name('mails.shipped');
    Route::post('/confirm_place_order/{total}', [ShipmentController::class, 'send'])->name('confirm_place_order');
    Route::post('/reserve/confirm', [HomeController::class, 'reservation_confirm'])->name('reserve.confirm');
    Route::post('/trace/confirm', [ShipmentController::class, 'trace_confirm'])->name('trace.confirm');

    // Profile Routes
    Route::get('/user/profile', [HomeController::class, 'profile'])->name('user.profile');
    Route::post('/user/profile/update', [HomeController::class, 'profile_update'])->name('user.profile.update');
});

Route::get("/top/rated", [HomeController::class, 'top_rated'])->name('top/rated');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [HomeController::class, 'redirects'])->name('dashboard');

Route::get('ssl/pay', [BkashController::class, 'ssl']);
Route::get('ssl/pay2', [BkashController::class, 'ssl2']);

Route::middleware(['auth'])->group(function () {
    // Payment Routes for bKash
    Route::post('bkash/get-token', [BkashController::class, 'getToken'])->name('bkash-get-token');
    Route::post('bkash/create-payment', [BkashController::class, 'createPayment'])->name('bkash-create-payment');
    Route::post('bkash/execute-payment', [BkashController::class, 'executePayment'])->name('bkash-execute-payment');
    Route::get('bkash/query-payment', [BkashController::class, 'queryPayment'])->name('bkash-query-payment');
    Route::post('bkash/success', [BkashController::class, 'bkashSuccess'])->name('bkash-success');

    // Refund Routes for bKash
    Route::get('bkash/refund', [BkashRefundController::class, 'index'])->name('bkash-refund');
    Route::post('bkash/refund', [BkashRefundController::class, 'refund'])->name('bkash-refund');
});

// ================= DEMO PAYMENT ROUTES =================
Route::post('/pay', [SslCommerzPaymentController::class, 'index'])->name('payment.pay');
Route::get('/payment/success', [SslCommerzPaymentController::class, 'success'])->name('payment.success');

Route::get('/payment-fail', [SslCommerzPaymentController::class, 'fail'])->name('payment.fail');
Route::get('/payment-cancel', [SslCommerzPaymentController::class, 'cancel'])->name('payment.cancel');
//SSLCOMMERZ END


// Admin Routes - Secured with auth and admin middleware
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Food & Menu
    Route::get('/food-menu', [FoodController::class, 'index'])->name('admin.food-menu');
    Route::get('/add/menu', [FoodController::class, 'create'])->name('admin.food-menu.add');
    Route::post('/menu/add/process', [FoodController::class, 'store'])->name('admin.menu.add.process');
    Route::get('/menu/edit/{id}', [FoodController::class, 'edit'])->name('admin.menu.edit');
    Route::post('/menu/edit/process/{id}', [FoodController::class, 'update'])->name('admin.menu.edit.process');
    Route::delete('/menu/delete/{id}', [FoodController::class, 'destroy'])->name('admin.menu.delete');

    // Orders
    Route::get('/orders-incomplete', [OrderController::class, 'incomplete'])->name('admin.orders-incomplete');
    Route::get('/orders-complete', [OrderController::class, 'complete'])->name('admin.orders-complete');
    Route::get('/orders/process', [OrderController::class, 'process'])->name('admin.orders.process');
    Route::get('/orders/cancel', [OrderController::class, 'cancel_list'])->name('admin.orders.cancel');
    Route::get('/invoice/details/{id}', [OrderController::class, 'details'])->name('admin.invoice.details');
    Route::post('/invoice/approve/{id}', [OrderController::class, 'approve'])->name('admin.invoice.approve');
    Route::get('/invoice/cancel-order/{id}', [OrderController::class, 'cancel'])->name('admin.invoice.cancel');
    Route::get('/invoice/complete/{id}', [OrderController::class, 'mark_complete'])->name('admin.invoice.complete');
    Route::get('/order/location', [OrderController::class, 'location'])->name('admin.order.location');
    Route::post('/invoice/location/edit', [OrderController::class, 'edit_location'])->name('admin.invoice.location.edit');

    // Staff (Chefs & Delivery Boys)
    Route::get('/chefs', [StaffController::class, 'chefs'])->name('admin.chefs');
    Route::get('/add/chef', [StaffController::class, 'add_chef'])->name('admin.chef.add');
    Route::post('/chef/add/process', [StaffController::class, 'store_chef'])->name('admin.chef.add.process');
    Route::get('/chef/edit/{id}', [StaffController::class, 'edit_chef'])->name('admin.chef.edit');
    Route::post('/edit/chef/process/{id}', [StaffController::class, 'update_chef'])->name('admin.chef.edit.process');
    Route::delete('/chef/delete/{id}', [StaffController::class, 'destroy_chef'])->name('admin.chef.delete');

    Route::get('/delivery-boy', [StaffController::class, 'delivery_boy'])->name('admin.delivery-boy');
    Route::get('/add/delivery_boy', [StaffController::class, 'add_delivery_boy'])->name('admin.delivery-boy.add');
    Route::post('/add-delivery-boy-process', [StaffController::class, 'store_delivery_boy'])->name('admin.add-delivery-boy-process');
    Route::get('/delivery_boy/edit/{id}', [StaffController::class, 'edit_delivery_boy'])->name('admin.delivery_boy.edit');
    Route::post('/edit_delivery_boy_process/{id}', [StaffController::class, 'update_delivery_boy'])->name('admin.edit_delivery_boy_process');
    Route::delete('/delivery_boy/delete/{id}', [StaffController::class, 'destroy_delivery_boy'])->name('admin.delivery_boy.delete');

    // CMS & Config
    Route::get('/banner/all', [CmsController::class, 'banners'])->name('admin.banner.all');
    Route::get('/add/banner', [CmsController::class, 'add_banner'])->name('admin.add.banner');
    Route::post('/banner/add/process', [CmsController::class, 'store_banner'])->name('admin.banner.add.process');
    Route::delete('/banner/delete/{id}', [CmsController::class, 'destroy_banner'])->name('admin.banner.delete');

    // Reservations
    Route::get('/reservations', [ReservationController::class, 'index'])->name('admin.reservations');
    Route::delete('/reservation/delete/{id}', [ReservationController::class, 'destroy'])->name('admin.reservation.delete');

    // Users & Admins
    Route::get('/users', [StaffController::class, 'user_show'])->name('admin.users');
    Route::get('/admins', [StaffController::class, 'admin_show'])->name('admin.admins');
    Route::get('/admin-add', [StaffController::class, 'admin_add'])->name('admin.admin.add');
    Route::post('/admin-add-process', [StaffController::class, 'admin_add_process'])->name('admin.admin.add.process');
    Route::get('/edit/{id}', [StaffController::class, 'admin_edit'])->name('admin.admin.edit');
    Route::post('/edit/process/{id}', [StaffController::class, 'admin_edit_process'])->name('admin.admin.edit_process');
    Route::delete('/delete/{id}', [StaffController::class, 'admin_delete'])->name('admin.admin.delete');

    // Coupons
    Route::get('/coupon', [CmsController::class, 'coupons'])->name('admin.coupon');
    Route::get('/coupon/add', [CmsController::class, 'add_coupon'])->name('admin.coupon.add');
    Route::post('/coupon-add-process', [CmsController::class, 'store_coupon'])->name('admin.coupon.add.process');
    Route::get('/coupon/edit/{id}', [CmsController::class, 'edit_coupon'])->name('admin.coupon.edit');
    Route::post('/coupon-edit-process/{id}', [CmsController::class, 'update_coupon'])->name('admin.coupon.edit.process');
    Route::get('/coupon/delete/{id}', [CmsController::class, 'destroy_coupon'])->name('admin.coupon.delete');

    // Charges
    Route::get('/charge', [CmsController::class, 'charges'])->name('admin.charge');
    Route::get('/charge/add', [CmsController::class, 'add_charge'])->name('admin.charge.add');
    Route::post('/charge-add-process', [CmsController::class, 'store_charge'])->name('admin.charge.add.process');
    Route::get('/charge/edit/{id}', [CmsController::class, 'edit_charge'])->name('admin.charge.edit');
    Route::post('/charge-edit-process/{id}', [CmsController::class, 'update_charge'])->name('admin.charge.edit.process');
    Route::get('/charge/delete/{id}', [CmsController::class, 'destroy_charge'])->name('admin.charge.delete');

    // Customization
    Route::get('/customize', [CmsController::class, 'customize'])->name('admin.customize');
    Route::get('/customize/edit', [CmsController::class, 'edit_customize'])->name('admin.customize.edit');
    Route::post('/customize/update', [CmsController::class, 'update_customize'])->name('admin.customize.update');

    Route::get('/reservation', [CmsController::class, 'reservations'])->name('admin.reservation');

    Route::get('/customer', [StaffController::class, 'user_show'])->name('admin.customer');
    Route::get('/show', [StaffController::class, 'admin_show'])->name('admin.show');

    // Admin Logout
    Route::post('/logout', [DashboardController::class, 'logout'])->name('admin.logout');
});
