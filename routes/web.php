<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EndpointController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiteNotificationController;
use App\Http\Controllers\UpdateSiteConnectionController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
   
    
    Route::controller(SiteController::class)->group(function(){
        Route::get('/sites/{site}', 'show')->name('sites.show');
        Route::post('/sites', 'store')->name('sites.store');
        Route::delete('/sites/{site}', 'destroy')->name('sites.destroy');
    });

    Route::put('/sites/{site}', UpdateSiteConnectionController::class)->name('sites.update-connection');

    Route::controller(SiteNotificationController::class)->group(function(){
        Route::put('/sites/{site}/notification/emails', 'store')->name('notification.emails.store');
        Route::delete('/sites/{site}/notification/emails', 'destroy')->name('notification.emails.destroy');
    });

    Route::controller(EndpointController::class)->group(function(){
        Route::get('/endpoints/{endpoint}', 'index')->name('endpoints.index');
        Route::post('/sites/{site}/endpoints', 'store')->name('endpoints.store');
        Route::patch('/endpoints{endpoint}', 'update')->name('endpoints.update');
        Route::delete('/endpoints{endpoint}', 'destroy')->name('endpoints.destroy');
    });

});

require __DIR__.'/auth.php';
