<?php

use App\Http\Controllers\Admin\SiteController;
use App\Http\Controllers\Api\ClickReceiverController;
use App\Http\Controllers\TestPageController;
use Illuminate\Support\Facades\Route;

//Клики
Route::post('/capture-click', [ClickReceiverController::class, 'store']);

//Админка
Route::get('/admin/sites', [SiteController::class, 'index'])->name('admin.sites');
Route::get('/admin/sites/create', [SiteController::class, 'create'])->name('admin.sites.create');
Route::post('/admin/sites', [SiteController::class, 'store'])->name('admin.sites.store');
Route::get('/admin/sites/{siteId}/view', [SiteController::class, 'view'])->name('admin.sites.view');

//Тестовые страницы для отслеживания кликов
Route::get('/test/{any}', [TestPageController::class, 'show'])
    ->where('any', '.*')
    ->name('test.page');
