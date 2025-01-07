<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('restaurants.search');
});

Route::get('/restaurants/search', [App\Http\Controllers\RestaurantController::class, 'search'])->name('restaurants.search');
Route::get('/restaurants/detail/{id}', [App\Http\Controllers\RestaurantController::class, 'detail'])->name('restaurants.detail');
