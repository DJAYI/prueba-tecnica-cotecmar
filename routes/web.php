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
    Route::prefix('blocks')->group(function () {
        Route::get('/', [BlockController::class, 'index'])->name('blocks.index');
        Route::get('/create', [BlockController::class, 'create'])->name('blocks.create');
        Route::post('/', [BlockController::class, 'store'])->name('blocks.store');
        Route::get('/{id}/edit', [BlockController::class, 'edit'])->name('blocks.edit');
        Route::put('/{id}', [BlockController::class, 'update'])->name('blocks.update');
        Route::delete('/{id}', [BlockController::class, 'destroy'])->name('blocks.destroy');
    });
    Route::prefix('pieces')->group(function () {
        Route::get('/', [PieceController::class, 'index'])->name('pieces.index');
        Route::get('/create', [PieceController::class, 'create'])->name('pieces.create');
        Route::post('/', [PieceController::class, 'store'])->name('pieces.store');
        Route::get('/{id}/edit', [PieceController::class, 'edit'])->name('pieces.edit');
        Route::put('/{id}', [PieceController::class, 'update'])->name('pieces.update');
        Route::delete('/{id}', [PieceController::class, 'destroy'])->name('pieces.destroy');

        // API routes for cascading selects
        Route::get('/api/blocks/{projectId}', [PieceController::class, 'getBlocksByProject'])->name('pieces.blocks');
        Route::get('/api/pieces/{blockId}', [PieceController::class, 'getPendingPiecesByBlock'])->name('pieces.pending');
    });

    // Manufacturing Registration (separate from pieces CRUD)
    Route::prefix('manufacturing')->group(function () {
        Route::get('/', [PieceController::class, 'manufacturingIndex'])->name('manufacturing.index');
        Route::get('/{id}/register', [PieceController::class, 'manufacturingRegister'])->name('manufacturing.register');
        Route::put('/{id}/complete', [PieceController::class, 'manufacturingComplete'])->name('manufacturing.complete');
    });
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
