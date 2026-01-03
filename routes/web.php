<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Redirect root to appropriate page
Route::get('/', function () {
    return Auth::check() ? redirect()->route('chat') : redirect()->route('login');
});

// Auth routes
Route::get('/login', Login::class)->name('login')->middleware('guest');
Route::get('/register', Register::class)->name('register')->middleware('guest');

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout')->middleware('auth');

// Chat route
Route::get('/chat', function () {
    return view('chat');
})->name('chat')->middleware('auth');

// Font test route
Route::get('/font-test', function () {
    return view('font-test');
})->name('font-test');
