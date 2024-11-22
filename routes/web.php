<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContratistaController;

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

 
Route::get('/dashboard', function () {
    return view('dashboard');})->middleware(['auth', 'verified'])->name('dashboard');


//catalogo contratista
Route::resource('/catalogoContratistas', ContratistaController::class);

//catalogo usuarios
Route::resource('/catalogoUsuarios', ContratistaController::class);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
