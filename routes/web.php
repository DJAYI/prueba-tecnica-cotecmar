<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\PieceController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect('/admin');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('admin.index');

    Route::prefix('projects')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/', [ProjectController::class, 'store'])->name('projects.store');
        Route::get('/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('/{id}', [ProjectController::class, 'update'])->name('projects.update');
        Route::delete('/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    });
    Route::resource('blocks', BlockController::class);
    Route::resource('pieces', PieceController::class);
});

Route::group([
    'prefix' => 'auth',
], function () {
    Route::get('login', function () {
        return Inertia::render('Auth/Login');
    })->name('login');

    Route::post('login', [AuthenticationController::class, 'login'])->name('login');
    Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
});
