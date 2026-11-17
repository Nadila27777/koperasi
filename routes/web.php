
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\AngsuranController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Halaman login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Proses login
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    return back()
        ->withErrors([
            'email' => 'Email atau password yang dimasukkan salah.',
        ])
        ->onlyInput('email');
})->name('login.post');

// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->middleware('auth')->name('logout');

// Halaman setelah login
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Data Anggota
    Route::resource('anggotas', AnggotaController::class);

    // Data Simpanan
    Route::resource('simpanans', SimpananController::class);

    // Data Pinjaman
    Route::resource('pinjaman', PinjamanController::class);

    // Data Angsuran
    Route::resource('angsurans', AngsuranController::class);

    // Khusus admin
    Route::middleware('role:admin')->group(function () {

        // Manajemen User
        Route::resource('users', UserController::class);

        // Persetujuan dan proses pinjaman
        Route::post(
            '/pinjaman/{pinjaman}/approve',
            [PinjamanController::class, 'approve']
        )->name('pinjaman.approve');

        Route::post(
            '/pinjaman/{pinjaman}/reject',
            [PinjamanController::class, 'reject']
        )->name('pinjaman.reject');

        Route::post(
            '/pinjaman/{pinjaman}/disburse',
            [PinjamanController::class, 'disburse']
        )->name('pinjaman.disburse');

        Route::post(
            '/pinjaman/{pinjaman}/paid',
            [PinjamanController::class, 'markPaid']
        )->name('pinjaman.paid');

        Route::post(
            '/pinjaman/{pinjaman}/cancel',
            [PinjamanController::class, 'cancel']
        )->name('pinjaman.cancel');
    });

});
