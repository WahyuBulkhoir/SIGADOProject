<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Exports\OrderExport;
use Maatwebsite\Excel\Facades\Excel;

route::get('/',[HomeController::class,'home']);

route::get('/dashboard',[HomeController::class,'login_home'])->middleware(['auth', 'verified'])->name('dashboard');

route::get('/myorders',[HomeController::class,'myorders'])->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

route::get('admin/dashboard',[HomeController::class,'index'])->middleware(['auth','admin']);

route::get('superadmin/dashboard', [SuperAdminController::class, 'index'])
    ->middleware(['auth', 'superadmin']);

route::get('view_category',[AdminController::class,'view_category'])->middleware(['auth','admin']);

route::post('add_category',[AdminController::class,'add_category'])->middleware(['auth','admin']);

route::get('delete_category/{id}',[AdminController::class,'delete_category'])->middleware(['auth','admin']);

route::get('edit_category/{id}',[AdminController::class,'edit_category'])->middleware(['auth','admin']);

route::post('update_category/{id}',[AdminController::class,'update_category'])->middleware(['auth','admin']);

route::get('add_product',[AdminController::class,'add_product'])->middleware(['auth','admin']);

route::post('upload_product',[AdminController::class,'upload_product'])->middleware(['auth','admin']);

route::get('view_product',[AdminController::class,'view_product'])->middleware(['auth','admin']);

route::get('delete_product/{id}',[AdminController::class,'delete_product'])->middleware(['auth','admin']);

route::get('update_product/{slug}',[AdminController::class,'update_product'])->middleware(['auth','admin']);

route::post('edit_product/{id}',[AdminController::class,'edit_product'])->middleware(['auth','admin']);

route::get('product_search',[AdminController::class,'product_search'])->middleware(['auth','admin']);

route::get('product_details/{id}',[HomeController::class,'product_details']);

route::get('shop',[HomeController::class,'shop']);

route::get('search_shop', [HomeController::class, 'search_shop']);

route::get('about',[HomeController::class,'about']);

route::post('register_candidate_pikr_member', [HomeController::class, 'registerCandidatePikrMember']);

route::get('add_event',[SuperAdminController::class,'add_event'])->middleware(['auth','superadmin']);

route::post('store_event', [SuperAdminController::class, 'store_event'])->middleware(['auth', 'superadmin']);

Route::get('create-event', [AdminController::class, 'create'])->name('admin.create');

Route::post('store-event', [AdminController::class, 'store'])->name('admin.store');

route::get('view_events', [SuperAdminController::class, 'view_events'])->middleware(['auth', 'superadmin']);

Route::get('edit_event/{id}', [SuperAdminController::class, 'edit_event'])->middleware(['auth', 'superadmin']);

Route::post('update_event/{id}', [SuperAdminController::class, 'update_event'])->middleware(['auth', 'superadmin']);

route::get('delete_event/{id}', [SuperAdminController::class, 'delete_event'])->middleware(['auth', 'superadmin']);

route::get('delete_candidate/{id}', [SuperAdminController::class, 'delete_candidate'])->middleware(['auth', 'superadmin']);

route::get('add_meeting',[SuperAdminController::class,'add_meeting'])->middleware(['auth','superadmin']);

route::post('store_meeting', [SuperAdminController::class, 'store_meeting'])->middleware(['auth', 'superadmin']);

Route::get('create-meeting', [AdminController::class, 'create'])->name('admin.create');

Route::post('store-meeting', [AdminController::class, 'store'])->name('admin.store');

route::get('view_meetings', [SuperAdminController::class, 'view_meetings'])->middleware(['auth', 'superadmin']);

Route::get('edit_meeting/{id}', [SuperAdminController::class, 'edit_meeting'])->middleware(['auth', 'superadmin']);

Route::post('update_meeting/{id}', [SuperAdminController::class, 'update_meeting'])->middleware(['auth', 'superadmin']);

route::get('delete_meeting/{id}', [SuperAdminController::class, 'delete_meeting'])->middleware(['auth', 'superadmin']);

route::post('add_member', [SuperAdminController::class, 'add_member'])->middleware(['auth', 'superadmin']);

Route::get('add_member', [SuperAdminController::class, 'showAddMember'])->middleware(['auth', 'superadmin']);

Route::get('view_members', [SuperAdminController::class, 'viewMembers'])->middleware(['auth', 'superadmin']);

Route::get('edit_member/{id}', [SuperAdminController::class, 'edit_member'])->middleware(['auth', 'superadmin']);

Route::post('update_member/{id}', [SuperAdminController::class, 'update_member'])->middleware(['auth', 'superadmin']);

route::get('delete_member/{id}', [SuperAdminController::class, 'delete_member'])->middleware(['auth', 'superadmin']);

Route::get('/candidate_member', [SuperAdminController::class, 'viewCandidateMembers'])->name('candidate_member');

route::get('testimonial',[HomeController::class,'testimonial']);

route::get('contact',[HomeController::class,'contact']);

route::get('add_cart/{id}',[HomeController::class,'add_cart'])->middleware(['auth', 'verified']);

route::get('mycart',[HomeController::class,'mycart'])->middleware(['auth', 'verified']);

route::get('remove_cart/{id}',[HomeController::class, 'remove_cart'])->middleware(['auth', 'verified']);

route::post('confirm_order',[HomeController::class, 'confirm_order'])->middleware(['auth', 'verified']);

Route::controller(HomeController::class)->group(function(){
    Route::get('stripe/{value}', 'stripe');
    Route::post('stripe/{value}', 'stripePost')->name('stripe.post');
});

route::get('view_orders',[AdminController::class, 'view_orders'])->middleware(['auth', 'verified'])->middleware(['auth','admin']);

route::get('on_the_way/{id}',[AdminController::class, 'on_the_way'])->middleware(['auth','admin']);

route::get('delivered/{id}',[AdminController::class, 'delivered'])->middleware(['auth','admin']);

route::get('print_pdf/{id}',[AdminController::class, 'print_pdf'])->middleware(['auth','admin']);

Route::get('export_orders', function () {
    return Excel::download(new OrderExport, 'orders.xlsx');
})->middleware(['auth', 'admin']);

Route::get('edit_profile', [HomeController::class, 'edit_profile'])->name('edit_profile')->middleware(['auth', 'verified']);

Route::post('update_profile', [HomeController::class, 'update_profile'])->name('update_profile')->middleware(['auth', 'verified']);