<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Swap\Builder;
use App\Http\Controllers\CurrencyOrderController;
use App\Http\Controllers\CryptoWalletController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/userdash', function () {
    return view('userdashboard.main');
})->middleware(['auth', 'verified'])->name('userdash');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile2', [ProfileController::class, 'destroy'])->name('profile.destroy');
});





require __DIR__.'/auth.php';



Route::post('/logout1', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/'); // Redirect to the homepage or login page
})->name('logout');





Route::middleware(['auth'])->group(function () {
    Route::get('/messages/{receiverId?}', [MessageController::class, 'inbox'])->name('messages.inbox');
    // Route::get('/messages/{userId}', [MessageController::class, 'showConversation'])->name('messages.chat');
    Route::post('/messages/send', [MessageController::class, 'sendMessage'])->name('messages.send');

    Route::get('/exchange/requests', [CurrencyOrderController::class, 'showExchangeRequests'])->name('exchange.requests');
    Route::post('/exchange/accept/{id}', [CurrencyOrderController::class, 'accept'])->name('exchange.accept');
    // Route::post('/exchange/reject/{id}', [CurrencyOrderController::class, 'reject'])->name('exchange.reject');
    Route::get('/my-responses', [CurrencyOrderController::class, 'myRequestsResponses'])->name('exchange.myresponses');
    Route::get('/userd',[UserController::class, 'user'])->name('userd');
    Route::get('/countries', [LanguageController::class, 'getCountries']);
   // Route::get('/userdash',[UserController::class, 'dash'])->name('userdash');
    Route::get('/usercurrency',[UserController::class, 'currency'])->name('usercur');

    Route::get('/profile1', [ProfileController::class, 'edie'])->name('profile.edit');
    Route::post('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/exchange-rate/{from}/{to}', [UserController::class, 'getExchangeRate']);
    Route::post('/currency-orders/store', [CurrencyOrderController::class, 'store'])->name('currency-orders.store');

    Route::post('/verify-wallet', [CryptoWalletController::class, 'verify'])->middleware('auth');
    Route::get('/connect-wallet', [CryptoWalletController::class, 'showWalletConnectPage'])->name('connect.wallet');
    Route::get('/messages/get/{receiverId}', [MessageController::class, 'getMessages']);
    // web.php
    Route::post('/pair-user', [MessageController::class, 'pairUser'])->name('pair.user');
    // web.php
    Route::post('/pay', [PaymentController::class, 'redirectToGateway'])->name('pay');
    Route::get('/payment/callback', [PaymentController::class, 'handleGatewayCallback']);
    Route::get('/payment/display', [PaymentController::class, 'display'])->name('display');
    Route::post('/trade/approve/{offer_id}', [MessageController::class, 'approveTrade'])->name('trade.approve');
    Route::post('/exchange/reject/{orderId}', [CurrencyOrderController::class, 'rejectByOrder'])->name('exchange.reject');









});
Route::get('/admin/login', [AdminController::class, 'showlogin'])->name('admin.login');
Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::middleware(['web', 'admin.auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});



