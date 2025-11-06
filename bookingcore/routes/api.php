<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\GuideController;
use App\Http\Controllers\API\HuntingBookingController;


Route::get('/guides', [GuideController::class, 'index']);
Route::post('/bookings', [HuntingBookingController::class, 'store']);
