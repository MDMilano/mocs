<?php

use App\Livewire\Member\KnowledgeBase;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('knowledge-base', KnowledgeBase::class)->name('knowledge-base');
});

require __DIR__ . '/settings.php';
