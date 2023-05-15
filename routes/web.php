<?php

use App\Http\Controllers\BModelController;
use App\Http\Controllers\ProfileController;
use Illuminate\Routing\Controllers\Middleware;
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
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/modeler', function () {
    return view('modeler.index');
})->middleware(['auth', 'verified'])->name('modeler');

Route::get('/models', [BModelController::class, 'index'])->middleware(['auth', 'verified'])->name("models.index");
Route::get('/models/create', [BModelController::class, 'create'])->middleware(['auth', 'verified'])->name("models.create");
Route::post('/models', [BModelController::class, 'store'])->middleware(['auth', 'verified'])->name("models.store");
Route::get('/models/{id}', [BModelController::class, 'edit'])->middleware(['auth', 'verified'])->name("models.edit");
Route::delete('/models/{id}', [BModelController::class, 'destroy'])->middleware(['auth', 'verified'])->name("models.destroy");

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';