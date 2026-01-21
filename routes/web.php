<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'loginAction'])->name('loginAction');
Route::get('/login/reset', [LoginController::class, 'loginReset'])->name('loginReset');
Route::post('/login/reset', [LoginController::class, 'passwordReset'])->name('passwordReset');
Route::get('/login/register', [LoginController::class, 'register'])->name('register');
Route::post('/login/register', [LoginController::class, 'registerAction'])->name('registerAction');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::middleware(['auth'])->group(function(){
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/', [HomeController::class, 'spendsAction']);
    Route::get('/delete/{id_account}', [HomeController::class, 'deleteAccount'])->name('deleteAccount');
    Route::get('/edit/{id_account}', [HomeController::class, 'edit'])->name('edit');
    Route::post('/edit/{id_account}', [HomeController::class, 'editAction'])->name('editAction');
    Route::get('/filter', [HomeController::class, 'filter'])->name('filter');
    Route::post('/filter', [HomeController::class, 'filter'])->name('filter');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'profileAction'])->name('profileAction');
    Route::post('/profile/password/reset', [ProfileController::class, 'profilePasswordAction'])->name('profilePasswordAction');

    Route::resource('transactions', HomeController::class);
    Route::resource('trasactions', HomeController::class)->only(['store','destroy']);
    Route::get('categories', [HomeController::class, 'index'])->name('categories');
});
