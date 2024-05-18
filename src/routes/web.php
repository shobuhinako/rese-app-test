<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ChangeReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\AdminController;
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

Route::get('/auth/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('show.login');
Route::middleware('auth')->group(function(){
    Route::get('/', [AuthController::class, 'index'])->name('index');
    Route::get('/', [SearchController::class, 'search'])->name('search');
    Route::get('/shop_detail/{id}', [ShopController::class, 'showDetail'])->name('shop_detail');
    Route::get('/mypage', [AuthController::class, 'mypage'])->name('mypage');
    Route::get('/admin/mypage', [AuthController::class, 'adminPage'])->name('admin.mypage');
    Route::post('/shops/{shop:id}/favorite', [ShopController::class, 'favorite'])->name('favorite');
    Route::post('/done', [ShopController::class, 'reservation']);
    Route::delete('/mypage/reservation/{id}', [ShopController::class, 'remove'])->name('reservation.remove');
    Route::delete('/mypage/favorite/{shop_id}', [ShopController::class, 'destroy'])->name('favorite.destroy');
    Route::get('/reservation/{id}/edit/{shop_name}', [ChangeReservationController::class, 'edit'])->name('reservation.edit');
    Route::put('/reservation/update/{id}', [ChangeReservationController::class, 'update'])->name('reservation.update');
    Route::get('/review/{reservation_id}', [ReviewController::class, 'review'])->name('review');
    Route::post('/done/review', [ReviewController::class, 'createReview']);
    Route::post('/upload-image', [ImageUploadController::class, 'uploadImage'])->name('upload.image');
    Route::get('/upload-form', [ImageUploadController::class, 'showUploadForm'])->name('upload.form');
    Route::post('/create/admin', [AdminController::class, 'createAdmin'])->name('admin.create');
    Route::get('/create/admin', [AdminController::class, 'showAdmin'])->name('show.admin');
});
Route::post('/register', [AuthController::class, 'create'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/thanks', function () {
    return view('thanks');
});
Route::get('/email/verify', function () {
    // メールの確認ビューを返す
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::get('/email/verify/{id}/{hash}',[VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/thanks', [VerificationController::class, 'resendVerificationEmail'])->name('verification.resend');