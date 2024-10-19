<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ContactController;

Route::get('{any?}', function () {
    return view('application');
})->where('any', '.*');

// Route::get('/', [ContactController::class, 'index']);
// Route::post('/addcontact', [ContactController::class, 'add']);
// Route::get('/delete/{id}', [ContactController::class, 'delete']);
// Route::get('/edit/{id}', [ContactController::class, 'edit']);
// Route::post('/edit/{id}', [ContactController::class, 'update']);
