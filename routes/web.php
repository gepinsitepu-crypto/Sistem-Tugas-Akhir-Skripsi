<?php

use App\Http\Controllers\RuangSidangController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('ruang-sidang.index');
});

// =========================================================================
// LAPIS 1: AUTHENTICATION (LOGIN & LOGOUT)
// =========================================================================
Route::get('/login', function () {
    return '
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Login Sistem Akademik - Ruang Sidang</title>
        <style>
            body { font-family: Arial, sans-serif; background: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
            .card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 360px; }
            h2 { margin-top: 0; text-align: center; color: #2c3e50; }
            .form-group { margin-bottom: 15px; }
            label { display: block; margin-bottom: 5px; font-weight: bold; }
            input { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
            .btn { width: 100%; padding: 10px; border: none; border-radius: 4px; color: white; font-weight: bold; cursor: pointer; margin-top: 5px; display: block; text-align: center; text-decoration: none; box-sizing: border-box; }
            .btn-primary { background: #3498db; }
            .btn-dosen { background: #27ae60; margin-top: 15px; }
            .btn-mhs { background: #e67e22; }
            .error { color: red; font-size: 13px; margin-bottom: 10px; }
            hr { margin: 20px 0; border: 0; border-top: 1px solid #eee; }
        </style>
    </head>
    <body>
        <div class="card">
            <h2>Login Ruang Sidang</h2>
            ' . (session('error') ? '<div class="error">' . session('error') . '</div>' : '') . '
            <form method="POST" action="/login">
                ' . csrf_field() . '
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="dosen@kampus.ac.id" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            <hr>
            <small style="color:#666; display:block; text-align:center; margin-bottom:8px;">Login Cepat untuk Pengujian Role:</small>
            <a href="/quick-login/dosen" class="btn btn-dosen">Masuk sebagai DOSEN</a>
            <a href="/quick-login/mahasiswa" class="btn btn-mhs">Masuk sebagai MAHASISWA</a>
        </div>
    </body>
    </html>';
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('ruang-sidang.index');
    }

    return back()->with('error', 'Email atau password salah.');
});
Route::get('/quick-login/{role}', function (string $role) {
    if (!in_array($role, ['dosen', 'mahasiswa'])) {
        abort(404);
    }

    $user = User::firstOrCreate(
        ['email' => $role . '@kampus.ac.id'],
        [
            'name' => $role === 'dosen' ? 'Dr. Budi (Dosen)' : 'Gevin (Mahasiswa)',
            'password' => bcrypt('password'),
            'role' => $role,
        ]
    );
    if ($user->role !== $role) {
        $user->update(['role' => $role]);
    }

    Auth::login($user);
    return redirect()->route('ruang-sidang.index');
})->name('quick.login');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// =========================================================================
// LAPIS 2: ROLE ACCESS CONTROL (MIDDLEWARE AUTH & ROLE)
// =========================================================================
Route::middleware(['auth'])->group(function () {

    Route::get('/ruang-sidang', [RuangSidangController::class, 'index'])->name('ruang-sidang.index');

    Route::middleware(['role:dosen'])->group(function () {
        Route::get('/ruang-sidang/create', [RuangSidangController::class, 'create'])->name('ruang-sidang.create');
        Route::post('/ruang-sidang', [RuangSidangController::class, 'store'])->name('ruang-sidang.store');
        Route::get('/ruang-sidang/{ruang_sidang}/edit', [RuangSidangController::class, 'edit'])->name('ruang-sidang.edit');
        Route::put('/ruang-sidang/{ruang_sidang}', [RuangSidangController::class, 'update'])->name('ruang-sidang.update');
        Route::delete('/ruang-sidang/{ruang_sidang}', [RuangSidangController::class, 'destroy'])->name('ruang-sidang.destroy');
    });

});