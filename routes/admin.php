<?php

use Illuminate\Support\Facades\Route;

// Admin Dashboard route
Route::get('dashboard', App\Livewire\Admin\Dashboard\DashboardIndex::class);
// Admin routes with prefix
Route::prefix('admin')->name('admin.')->group(function () {
    // Protected routes (authenticated)
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/', App\Livewire\Admin\Dashboard\DashboardIndex::class)->name('dashboard');
        Route::get('profile', App\Livewire\Admin\Profile\ProfileEdit::class)->name('profile.edit');
    });

    // Auth routes (authenticated admin)
    Route::middleware('auth')->group(function () {
        // User Management
        Route::get('user', App\Livewire\Admin\User\UserIndex::class)->name('user.index');
        Route::get('user/create', App\Livewire\Admin\User\UserCreate::class)->name('user.create');
        Route::get('user/{id}/show', App\Livewire\Admin\User\UserShow::class)->name('user.show');
        Route::get('user/{id}/edit', App\Livewire\Admin\User\UserEdit::class)->name('user.edit');
    });
});
