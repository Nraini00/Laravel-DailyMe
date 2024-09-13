<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ApparelController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BudgetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.app');
});

Route::middleware('auth')->group(function() {
    Route::view('/dashboard', 'main.dashboard')->name('dashboard');
    Route::view('/profile', 'main.profile')->name('profile');
    
    Route::post('/update-profile-image', [UserController::class, 'updateProfileImage'])->name('updateProfileImage');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');

    Route::get('/dashboard', [BudgetController::class, 'dashboard1'])->name('dashboard');


    Route::get('/budget', [BudgetController::class, 'index'])->name('budget.index');
    Route::post('/budget/store', [BudgetController::class, 'store'])->name('budget.store');
    Route::delete('/budget/{budget}', [BudgetController::class, 'destroy'])->name('budget.destroy');
    Route::get('/budget/{id}/edit', [BudgetController::class, 'edit'])->name('budget.edit');
    Route::put('/budget/{budget}', [BudgetController::class, 'update'])->name('budget.update');   
    
    // Define a route for viewing all transactions
    Route::get('/expenses', [BudgetController::class, 'index'])->name('expenses.index');

    
    Route::get('/apparel', [ApparelController::class, 'index'])->name('apparel.index');
    Route::post('/apparel/store', [ApparelController::class, 'store'])->name('apparel.store');
    Route::delete('/apparel/{apparel}', [ApparelController::class, 'destroy'])->name('apparel.destroy');
    Route::get('/apparel/{id}/edit', [ApparelController::class, 'edit'])->name('apparel.edit');
    Route::put('/apparel/{apparel}', [ApparelController::class, 'update'])->name('apparel.update');
    

    Route::get('/event', [EventController::class, 'index'])->name('event.index');
    Route::post('/event/store', [EventController::class, 'store'])->name('event.store');
    Route::delete('/event/{event}', [EventController::class, 'destroy'])->name('event.destroy');
    Route::get('/event/{id}/edit', [EventController::class, 'edit'])->name('event.edit');
    Route::put('/event/{event}', [EventController::class, 'update'])->name('event.update');
    
   

    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'registerPost'])
    ->name('register.post');

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'loginPost'])
    ->name('login.post');


    
