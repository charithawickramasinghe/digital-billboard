<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\BillboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasswordResetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MenuCardController;

Route::get('/', function () {
    return view('login');
});

Route::get('login', function () {
    return view('login');
})->name('login');

Route::get('dashboard', function () {
    return view('dashboard');
})
->middleware('auth')
->name('dashboard');

Route::post('logout', function (Request $request) {
    Auth::guard('web')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->name('logout');

Route::get('/fabric', function () {
    return view('fabric');
});

Route::get('/designer', function () {
    return view('designer');
});

Route::get('/image-upload/{screen_id}', [ImageController::class, 'index'])->name('image.upload');
Route::post("image-upload", [ImageController::class, "store"])->name("image.upload.store");
Route::delete('/image-delete/{id}', [ImageController::class, 'destroy'])->name('image.delete');
Route::get('/billboard/{screen_id}', [BillboardController::class, 'show']);
Route::post('login', LoginController::class)->name('login.attempt');

Route::get('/menucard', [MenuCardController::class, 'index']);
Route::post('/menucard/save', [MenuCardController::class, 'save'])->name('menucard.save');

// Password Reset Routes
Route::middleware('auth')->group(function () {
    Route::get('/password-reset', [PasswordResetController::class, 'show'])->name('password-reset.show');
    Route::post('/password-reset', [PasswordResetController::class, 'update'])->name('password-reset.update');
});