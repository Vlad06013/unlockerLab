<?php

use Illuminate\Support\Facades\Route;
use Valibool\TelegramConstruct\Http\Controllers\Orchid\AttachmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::prefix('admin/systems')->group(function () {
    Route::post('files', [AttachmentController::class, 'upload'])
        ->name('systems.files.upload');

    Route::post('media', [AttachmentController::class, 'media'])
        ->name('systems.files.media');

    Route::post('files/sort', [AttachmentController::class, 'sort'])
        ->name('systems.files.sort');

    Route::delete('files/{id}', [AttachmentController::class, 'destroy'])
        ->name('systems.files.destroy');

    Route::put('files/post/{id}', [AttachmentController::class, 'update'])
        ->name('systems.files.update');

});

//Route::prefix('admin/systems')->group(function () {
//    Route::post('files', [AttachmentController::class, 'upload'])
//        ->name('platform.systems.files.upload');
//
//    Route::post('media', [AttachmentController::class, 'media'])
//        ->name('platform.systems.files.media');
//
//    Route::post('files/sort', [AttachmentController::class, 'sort'])
//        ->name('platform.systems.files.sort');
//
//    Route::delete('files/{id}', [AttachmentController::class, 'destroy'])
//        ->name('platform.systems.files.destroy');
//
//    Route::put('files/post/{id}', [AttachmentController::class, 'update'])
//        ->name('platform.systems.files.update');
//});
