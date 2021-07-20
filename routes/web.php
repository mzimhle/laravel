<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
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

Route::group(['domain' => 'laravel.loc'], function()
{
	// Grouping the links that need authentication.
	Route::group(['middleware' => 'auth'], function(){
		// Landing page after login.
		Route::get('/', [AuthController::class, 'index'])->name('auth.index');
		// Members
		// For pages
		Route::get('/member', [MemberController::class, 'index'])->name('member.index');
		Route::get('/member/paginate', [MemberController::class, 'paginate'])->name('member.paginate');
		Route::get('/member/{id}/show', [MemberController::class, 'show'])->name('member.show');
		Route::get('/member/create', [MemberController::class, 'create'])->name('member.create');
		Route::get('/member/{id}/edit', [MemberController::class, 'edit'])->name('member.edit');
		// For submitting
		Route::post('/member/{id}/update', [MemberController::class, 'update'])->name('member.update');
		Route::post('/member', [MemberController::class, 'store'])->name('member.store');
		Route::post('/member/{id}/destroy', [MemberController::class, 'destroy'])->name('member.destroy');
		// Address links
		Route::get('/member/{id}/address', [AddressController::class, 'address'])->name('address');
		Route::get('/member/{id}/address/paginate', [AddressController::class, 'paginate'])->name('address.paginate');
		Route::post('/member/{id}/address/store', [AddressController::class, 'store'])->name('address.store');
	});
	// Links that do not need authentication.
	Route::get('/login', [AuthController::class, 'login'])->name('login');
	Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
	Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
	Route::get('/forgot', [AuthController::class, 'forgot'])->name('auth.forgot');

	Route::post('/login', [AuthController::class, 'submitLogin'])->name('auth.submitlogin');
	Route::post('/register', [AuthController::class, 'submitRegister'])->name('auth.submitregister');
	Route::post('/forgot', [AuthController::class, 'submitForgot'])->name('auth.submitforgot');
});