<?php

use Azuriom\Plugin\MusicUploader\Controllers\MusicController;
use Azuriom\Plugin\MusicUploader\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

// ПОЛЬЗОВАТЕЛЬСКИЕ МАРШРУТЫ (Сайт автоматически добавит префикс /musicuploader)
Route::middleware('web', 'auth')
	->prefix('musicuploader')
	->name('musicuploader.')
	->group(function () {
		Route::get('/', [MusicController::class, 'index'])->name('index');
		Route::post('/upload', [MusicController::class, 'upload'])->name('upload');
		Route::delete('/{track}', [MusicController::class, 'destroy'])->name('destroy');
});

// АДМИНСКИЕ МАРШРУТЫ (Явно прописываем префикс и имя для админки Azuriom)
Route::middleware('web', 'auth', 'admin-access')
    ->prefix('admin/musicuploader')
    ->name('musicuploader.admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::delete('/{track}', [AdminController::class, 'destroy'])->name('destroy');
});