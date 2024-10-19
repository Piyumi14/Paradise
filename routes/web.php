<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProposalController;



Route::prefix('proposal')->group(function () {
    Route::get('get-all', [ProposalController::class, 'getAllProposals']);
    Route::get('get-by-id/{id}', [ProposalController::class, 'getProposalById']);
    Route::post('create', [ProposalController::class, 'createProposal']);
    Route::post('edit/{id}', [ProposalController::class, 'editProposal']);
});


Route::get('{any?}', function () {
    return view('application');
})->where('any', '.*');

// Route::get('/', [ContactController::class, 'index']);
// Route::post('/addcontact', [ContactController::class, 'add']);
// Route::get('/delete/{id}', [ContactController::class, 'delete']);
// Route::get('/edit/{id}', [ContactController::class, 'edit']);
// Route::post('/edit/{id}', [ContactController::class, 'update']);
