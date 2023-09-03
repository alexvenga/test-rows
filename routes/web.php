<?php

use App\Http\Controllers\Rows\ViewRowsController;
use App\Http\Controllers\Rows\UploadRowsController;
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

Route::get('/', function () {
    return view('welcome');
})
    ->name('home');



Route::get('/rows', ViewRowsController::class)
    ->name('rows.index');

Route::resource('rows',UploadRowsController::class)->only(['create', 'store']);


