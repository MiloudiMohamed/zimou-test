<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\CreatePackage;
use App\Livewire\ListPackages;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', ListPackages::class)->name('packages.index');
    Route::get('/packages/create', CreatePackage::class)->name('packages.create');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/auth/login', Login::class)->name('login');
    Route::get('/auth/register', Register::class)->name('register');
});
