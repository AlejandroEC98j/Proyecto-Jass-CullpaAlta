<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MedidorController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\PagoController;
use Illuminate\Support\Facades\Route;

// Página principal: Redirige al login si no está autenticado
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard - Protegido por autenticación
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    // Listar pagos
    Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index');

    // Crear un nuevo pago (con factura_id)
    Route::get('/pagos/create/{factura_id}', [PagoController::class, 'create'])->name('pagos.create');

    // Almacenar el pago
    Route::post('/pagos', [PagoController::class, 'store'])->name('pagos.store');

    // Editar un pago
    Route::get('/pagos/{id}/edit', [PagoController::class, 'edit'])->name('pagos.edit');
   
    Route::get('/pagos/{id}/pdf', [PagoController::class, 'generarPDF'])->name('pagos.pdf');

    // Actualizar un pago
    Route::put('/pagos/{id}', [PagoController::class, 'update'])->name('pagos.update');

    // Eliminar un pago
    Route::delete('/pagos/{id}', [PagoController::class, 'destroy'])->name('pagos.destroy');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy'); 
});


// Rutas de gestión de entidades
Route::resources([
    'clientes'  => ClienteController::class,
    'facturas'  => FacturaController::class,
]);

// Ruta para medidores
Route::resource('medidores', MedidorController::class)->parameters([
    'medidores' => 'medidor' // Cambia 'medidore' a 'medidor'
]);

Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');


// Incluir rutas de autenticación (login, register, etc.)
require __DIR__.'/auth.php';
