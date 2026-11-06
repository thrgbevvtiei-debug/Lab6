<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CarTranslationController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\StatsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('cars.index');
});

// Переклади авто (до resource, щоб не конфліктувало з cars/{car})
Route::get('cars/{car}/translations', [CarTranslationController::class, 'edit'])
    ->name('cars.translations.edit');
Route::put('cars/{car}/translations', [CarTranslationController::class, 'update'])
    ->name('cars.translations.update');

Route::resource('cars', CarController::class);
Route::resource('countries', CountryController::class);

// Довідник міток
Route::resource('filters', FilterController::class)->except(['show']);

// Блог: спеціальні маршрути ПЕРЕД resource
Route::get('/blog/admin', [BlogController::class, 'admin'])->name('blog.admin');
Route::get('/blog/{blog}/tags', [BlogController::class, 'tags'])->name('blog.tags');
Route::post('/blog/{blog}/tags', [BlogController::class, 'tagsStore'])->name('blog.tags.store');
Route::resource('blog', BlogController::class);

Route::get('/stats', [StatsController::class, 'pages'])->name('stats.pages');
Route::get('/stats/detail', [StatsController::class, 'detail'])->name('stats.detail');
Route::get('/stats/popular', [StatsController::class, 'popular'])->name('stats.popular');
