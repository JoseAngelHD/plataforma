<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SchoolUserController; // Agregar el controlador si no está importado
use Illuminate\Support\Facades\Route;

// Rutas de usuarios
Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('auth');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('auth');
Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('auth');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('auth');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update')->middleware('auth');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('auth');

// Rutas de colegios
Route::get('/schools', [SchoolController::class, 'index'])->name('schools.index')->middleware('auth');
Route::get('/schools/create', [SchoolController::class, 'create'])->name('schools.create')->middleware('auth');
Route::post('/schools', [SchoolController::class, 'store'])->name('schools.store')->middleware('auth');
Route::get('/schools/{school}/edit', [SchoolController::class, 'edit'])->name('schools.edit')->middleware('auth');
Route::put('/schools/{school}', [SchoolController::class, 'update'])->name('schools.update')->middleware('auth');
Route::delete('/schools/{school}', [SchoolController::class, 'destroy'])->name('schools.destroy')->middleware('auth');

// Nueva ruta para la configuración del colegio
Route::get('/schools/{school}/configure', [SchoolController::class, 'configure'])->name('schools.configure')->middleware('auth');

// Rutas para las acciones específicas en la configuración del colegio
Route::post('/schools/{school}/create-database', [SchoolController::class, 'createDatabase'])->name('schools.createDatabase')->middleware('auth');
Route::post('/schools/{school}/create-tables', [SchoolController::class, 'createTables'])->name('schools.createTables')->middleware('auth');
Route::post('/schools/{school}/create-admin', [SchoolController::class, 'createAdmin'])->name('schools.createAdmin')->middleware('auth');

// Ruta para mostrar el formulario de creación del administrador
Route::get('/schools/{school}/users/create', [SchoolUserController::class, 'create'])->name('school.users.create')->middleware('auth');

// Ruta para el formulario de asignar administrador (ya existente)
Route::post('/schools/{school}/users', [SchoolUserController::class, 'store'])->name('school.users.store')->middleware('auth');


Route::post('/schools/{school}/create-admin', [SchoolUserController::class, 'createAdmin'])->name('schools.createAdmin');
// Ruta al dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Ruta de autenticación
require __DIR__.'/auth.php';

Route::domain('{subdomain}.bksoluciones.com')->middleware('set.school.database')->group(function () {
    Route::get('/', [SchoolController::class, 'dashboard'])->name('school.dashboard');
    // Otras rutas para colegios
});

