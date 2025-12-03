<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\cekController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Livewire\CreateAcara;

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
    // return view('welcome');
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Route::get('/admin', function () {
//     return ('<h1>Halaman - Hanya Admin</h1>');
// })->middleware(['auth', 'verified', 'role:admin'])->name('admin');


Route::get('/admin', [adminController::class, 'admin'])
    ->middleware(['auth', 'verified', 'role:admin'])
    ->name('admin');

Route::get('/admin/acara/create', CreateAcara::class)
    ->middleware(['auth', 'verified', 'role:admin'])
    ->name('admin.acara.create');

// Route::get('/user', function () {
//     return ('<h1>Halaman - Hanya user</h1>');
// })->middleware(['auth', 'verified', 'role:user|admin'])->name('user');

// Route::get('/tulisan', function () {
//     return view('tulisan');
// })->middleware(['auth', 'verified', 'role_or_permission:event.view|admin'])->name('tulisan');


Route::get('/add', [adminController::class, 'addRole'])->name('add');

// Route::get('/cek2', [adminController::class, 'index'])->middleware(['auth', 'permission:view cek2'])->name('cek2');




require __DIR__ . '/auth.php';
