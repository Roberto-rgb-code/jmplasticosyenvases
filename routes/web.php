<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CotizacionController;

// Página de inicio
Route::get('/', [HomeController::class, 'index'])->name('inicio');

// Productos
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
Route::get('/producto/{producto}', [ProductoController::class, 'show'])->name('producto.show');

// Cotizador
Route::post('/cotizacion/add/{producto}', [CotizacionController::class, 'add'])->name('cotizacion.add');
Route::get('/cotizador', [CotizacionController::class, 'cart'])->name('cotizacion.cart');
Route::patch('/cotizacion/update/{producto}', [CotizacionController::class, 'update'])->name('cotizacion.update');
Route::delete('/cotizacion/remove/{producto}', [CotizacionController::class, 'remove'])->name('cotizacion.remove');
Route::post('/cotizacion/enviar', [CotizacionController::class, 'submit'])->name('cotizacion.submit');

// Contacto
Route::get('/contacto', function () {
    return view('contacto');
})->name('contacto');
