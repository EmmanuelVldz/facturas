<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'invoice'], function () {
        Route::get('/', [InvoiceController::class, 'index']);
        Route::post('/', [InvoiceController::class, 'store']);
        Route::get('/{uid}', [InvoiceController::class, 'sendEmail'])->name('invoice.sendEmail');
        Route::post('/{uid}', [InvoiceController::class, 'cancel'])->name('invoice.cancel');
    });

    Route::group(['prefix' => 'client'], function () {
        Route::get('/', [ClientController::class, 'index']);
        Route::get('/{uid}', [ClientController::class, 'show']);
        Route::post('/', [ClientController::class, 'store']);
        Route::put('/{uid}', [ClientController::class, 'update']);
        Route::delete('/{uid}', [ClientController::class, 'destroy'])->name('client.delete');
    });
});
