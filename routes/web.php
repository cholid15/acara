<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\cekController;
use App\Http\Controllers\AcaraController;
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

// Universal dashboard route yang redirect sesuai role
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user && $user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user && $user->hasRole('user')) {
        return redirect()->route('user.dashboard');
    }

    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});





// Route khusus admin
Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->group(function () {

    Route::get('/', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/acara', [AdminController::class, 'list'])->name('admin.acara.list');

    // ACARA CRUD
    Route::get('/acara/create', [AcaraController::class, 'create'])->name('admin.acara.create');
    Route::post('/acara/store', [AcaraController::class, 'store'])->name('admin.acara.store');
    // <-- pastikan ini ada:
    Route::get('/acara/unit/{unit_id}/pegawai', [AcaraController::class, 'getPegawaiByUnit']);
    // AJAX: Ambil pegawai berdasarkan unit
    Route::get('/acara/get-pegawai-by-unit/{unitId}', [AcaraController::class, 'getPegawaiByUnit']);

    // detail acara
    Route::get('acara/detail/{id}', [\App\Http\Controllers\AcaraController::class, 'detail'])
        ->name('admin.acara.detail');
});
// Route khusus user
// Route::get('/user', [adminController::class, 'userDashboard'])
//     ->middleware(['auth', 'verified'])
//     ->name('user.dashboard');

// daftar acara
// Route::get('list', [adminController::class, 'list'])
//     ->middleware(['auth', 'verified', 'role:admin'])
//     ->name('admin.acara.list');

// Route::get('admin/acara/create', CreateAcara::class)
//     ->middleware(['auth', 'verified', 'role:admin'])
//     ->name('admin.acara.create');




Route::get('/add', [adminController::class, 'addRole'])->name('add');



require __DIR__ . '/auth.php';
