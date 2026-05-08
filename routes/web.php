<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservaController;

Route::get('/', function () {
    return view('reservas');
});

Route::post('/api/reservar', [ReservaController::class, 'store']);

// Definimos la ruta de cancelación. 
// El middleware 'signed' bloquea automáticamente cualquier acceso si la firma digital no es válida.
Route::get('/reservas/cancelar/{reserva}', [ReservaController::class, 'cancel'])
    ->name('reservas.cancelar')
    ->middleware('signed');
