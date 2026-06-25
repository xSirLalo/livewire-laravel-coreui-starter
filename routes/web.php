<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('home', App\Livewire\Web\Home\HomeIndex::class)->name('web.home');

require __DIR__.'/auth.php';
require __DIR__ . '/admin.php';
