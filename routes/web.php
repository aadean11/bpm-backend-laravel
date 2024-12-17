<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
// Login Route
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

// Logout Route
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/', function () {
    return view('login');
});

Route::middleware(['auth'])->get('/index', function () {
    return view('index');
})->name('index');



// kriteria
Route::get('/KriteriaSurvei/index', function () {
    return view('/KriteriaSurvei/index');
});


//skala
Route::get('/SkalaPenilaian/index', function () {
    return view('/SkalaPenilaian/index');
});

//pertanyaan
Route::get('/PertanyaanSurvei/index', function () {
    return view('/PertanyaanSurvei/index');
});

//template
Route::get('/TemplateSurvei/index', function () {
    return view('/TemplateSurvei/index');
});


//survei
Route::get('/Survei/index', function () {
    return view('/Survei/index');
});

//Daftar Survei
Route::get('/DaftarSurvei/index', function () {
    return view('/DaftarSurvei/index');
});

