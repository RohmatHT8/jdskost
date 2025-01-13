<?php

use App\Http\Controllers\ImageUploadController;
use App\Livewire\Auth\Forgot;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Reset;
use App\Livewire\Detail;
use App\Livewire\Homepage;
use App\Livewire\Users\DetailPayment;
use App\Livewire\Users\OutRoom;
use App\Livewire\Users\PayRent;
use App\Livewire\Users\Profile;
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

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/forgot', Forgot::class)->name('password.request');
    Route::get('/reset/{token}', Reset::class)->name('password.reset');
    Route::get('/register', Register::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', function () {
        auth()->logout();
        return redirect('/login');
    });
    Route::get('/', Homepage::class);
    Route::get('/detail/{param}', Detail::class);
    Route::get('/detail-payment', DetailPayment::class);
    Route::get('/pay-rent', PayRent::class);
    Route::get('/profile', Profile::class);
    Route::get('/out-room', OutRoom::class);
});

Route::get('test', function() {
    return view('templates.invoice');
});
