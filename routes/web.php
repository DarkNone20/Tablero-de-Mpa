<?php

use App\Http\Controllers\TableroController;
use Illuminate\Support\Facades\Route;

// Vista para escribir / administrar el tablero
Route::get('/tablero/escribir', [TableroController::class, 'escribir'])->name('tablero.escribir');
Route::post('/tablero/guardar', [TableroController::class, 'guardar'])->name('tablero.guardar');
Route::delete('/tablero/eliminar/{id}', [TableroController::class, 'eliminar'])->name('tablero.eliminar');

// Vista pública / pantalla que se actualiza cada 5 segundos
Route::get('/tablero/mostrar', [TableroController::class, 'mostrar'])->name('tablero.mostrar');

// Endpoint JSON para refrescar los datos sin recargar la página
Route::get('/tablero/datos', [TableroController::class, 'obtenerDatos'])->name('tablero.datos');

//Editar el Tablero
Route::put('/tablero/actualizar/{id}', [TableroController::class, 'actualizar'])->name('tablero.actualizar');