<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

// Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
//     Route::get('proposal', fn (Request $request) => $request->user())->name('proposal');
// });

Route::middleware('auth:api')->group(function () {
    Route::prefix('proposal')->group(function () {
        Route::get('get-all', 'ProposalController@getAllProposals');
        Route::get('get-by-id/{id}', 'ProposalController@getProposalById');
        Route::post('create', 'ProposalController@createProposal');
        Route::get('edit/{id}', 'ProposalController@editProposal');
        Route::post('approve/{id}', 'ProposalController@approveProposal');

        Route::post('send-email', 'ProposalController@sendEmail');
        Route::post('send-sms', 'ProposalController@sendSMS');
    });
});
