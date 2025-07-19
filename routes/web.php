<?php


use Illuminate\Support\Facades\Route;

use App\Livewire\Rubin\StudentDataImporter;
use App\Livewire\Rubin\StudentManagementDashboard;
use App\Livewire\Rubin\CsvTest;


Route::view('/', 'welcome');

///----------> Rubin
Route::get('/Admin/dashboard', StudentDataImporter::class)->middleware('auth')->name('students.dashboard');
Route::get('/Admin/import', StudentManagementDashboard::class)->middleware('auth')->name('students.import');
///---------->

    Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
