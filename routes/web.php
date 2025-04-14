<?php

use App\Http\Controllers\BerandaOperatorController;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\KwitansiPembayaran;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WaliController;
use App\Http\Controllers\WaliSantriController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('coba', function () {
    return view('template.app');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->middleware(['auth', 'auth.admin'])->group( function() {
    //Route Khusus Admin

});

Route::prefix('operator')->middleware(['auth', 'auth.operator'])->group( function() {
    //Route Khusus Operator
    Route::get('beranda', [BerandaOperatorController::class, 'index'])->name('operator.beranda');
    Route::resource('user', UserController::class);
    Route::resource('wali', WaliController::class);
    Route::resource('santri', SantriController::class);
    Route::resource('walisantri', WaliSantriController::class);
    Route::resource('biaya', BiayaController::class);
    Route::resource('tagihan', TagihanController::class);
    Route::resource('pembayaran', PembayaranController::class);
    Route::get('kwitansi-pembayaran/{id}', [KwitansiPembayaran::class, 'show'])
    ->name('kwitansipembayaran.show');
});
Route::prefix('wali')->middleware(['auth', 'auth.wali'])->group( function() {
    //Route Khusus Wali
    Route::get('beranda', [BerandaOperatorController::class, 'index'])->name('wali.beranda');
});


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); 
})->name('logout');

require __DIR__.'/auth.php';