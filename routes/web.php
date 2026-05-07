<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservaController;

Route::get('/', function () {
    return view('reservas');
});

Route::post('/api/reservar', [ReservaController::class, 'store']);
