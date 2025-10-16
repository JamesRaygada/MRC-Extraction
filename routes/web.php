<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ContractController, ResultController};

Route::get('/', [ContractController::class,'index'])->name('contracts.index');
Route::get('/contracts/{publicId}', [ContractController::class,'show'])->name('contracts.show');
Route::post('/contracts', [ContractController::class,'store'])->name('contracts.store');
Route::post('/contracts/{publicId}/rerun', [ContractController::class,'rerun'])->name('contracts.rerun');
Route::post('/results/{id}/override', [ResultController::class,'override'])->name('results.override');
