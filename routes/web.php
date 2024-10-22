<?php

use App\Http\Controllers\CreditController;
use App\Http\Controllers\Feature1;
use App\Http\Controllers\Feature2;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/buy-credit/webhook',[CreditController::class, 'webhook'])->name('credit.webhook');

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/feature1/index',[Feature1::class, 'index'])->name('feature1.index');
    Route::get('/feature2/index',[Feature2::class, 'index'])->name('feature2.index');
    Route::post('/feature1/calculate',[Feature2::class, 'calculate'])->name('feature1.calculate');
    Route::post('/feature2/calculate',[Feature2::class, 'calculate'])->name('feature2.calculate');
    Route::get('/buy-credit',[CreditController::class,'index'])->name('credit.index');
    Route::get('/buy-credit/success',[CreditController::class,'success'])->name('credit.success');
    Route::get('/buy-credit/cancel',[CreditController::class,'cancel'])->name('credit.cancel');
    Route::post('/buy-credit/{package}', [CreditController::class, 'buyCredits'])->name('credit.buy');
});

require __DIR__.'/auth.php';
