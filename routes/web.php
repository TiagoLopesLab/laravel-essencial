<?php

use App\Http\Controllers\EmailListController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (config('app.env') !== 'production') {
        Auth::loginUsingId(1);

        return to_route('dashboard');
    }

    return view('welcome');
});

Route::view('/dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/email-list', EmailListController::class);

    Route::get('/email-list/{emailList}/subscribers', [SubscriberController::class, 'index'])
        ->name('subscribers.index');
    Route::get('/email-list/{emailList}/subscribers/create', [SubscriberController::class, 'create'])
        ->name('subscribers.create');
});

require __DIR__.'/auth.php';
