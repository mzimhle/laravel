<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
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

Route::get('/', function () {
    return view('welcome');
});

/* 
 * Member route.
 *
 */
// Route::resource('member', MemberController::class);
// For pages
Route::get('/member', [MemberController::class, 'index'])->name('member.index');
Route::get('/member/paginate', [MemberController::class, 'paginate'])->name('member.paginate');
Route::get('/member/{id}/show', [MemberController::class, 'show'])->name('member.show');
Route::get('/member/create', [MemberController::class, 'create'])->name('member.create');
Route::get('/member/{id}/edit', [MemberController::class, 'edit'])->name('member.edit');
Route::post('/member/{id}/update', [MemberController::class, 'update'])->name('member.update');
// For submitting
Route::post('/member', [MemberController::class, 'store'])->name('member.store');
Route::post('/member/{id}/destroy', [MemberController::class, 'destroy'])->name('member.destroy');
