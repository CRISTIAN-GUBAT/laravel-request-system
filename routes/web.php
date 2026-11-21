<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceRequestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Lab 8 — Health & Revision Endpoint
|--------------------------------------------------------------------------
| Used by the staging workflow health check and smoke tests.
| Returns version, environment, debug flag, and short commit SHA.
| No secrets or credentials are exposed.
*/
Route::get('/health', function () {
    return response()->json([
        'status'  => 'ok',
        'version' => config('app.version', 'unknown'),
        'env'     => config('app.env', 'unknown'),
        'debug'   => config('app.debug', false),
        'commit'  => trim(@shell_exec('git rev-parse --short HEAD 2>/dev/null') ?? 'unknown'),
        'time'    => now()->toIso8601String(),
    ]);
})->name('health');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/requests', [ServiceRequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/create', [ServiceRequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [ServiceRequestController::class, 'store'])->name('requests.store');
    Route::get('/requests/{serviceRequest}', [ServiceRequestController::class, 'show'])->name('requests.show');
    Route::patch('/requests/{serviceRequest}/status', [ServiceRequestController::class, 'updateStatus'])->name('requests.updateStatus');
});

require __DIR__.'/auth.php';