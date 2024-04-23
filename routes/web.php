<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PersonController;

Route::get('/', [PersonController::class, 'index'])->name('persons.index');
Route::get('/persons/create', [PersonController::class, 'create'])->name('persons.create');
Route::post('/persons', [PersonController::class, 'store'])->name('persons.store');
Route::get('/persons/{person}/edit', [PersonController::class, 'edit'])->name('persons.edit');
Route::put('/persons/{person}', [PersonController::class, 'update'])->name('persons.update');
Route::delete('/persons/{person}', [PersonController::class, 'destroy'])->name('persons.destroy');
Route::get('/export-persons', [PersonController::class, 'export'])->name('export-persons');
