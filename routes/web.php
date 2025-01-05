<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\KriteriaSurveiController;
use App\Http\Controllers\SkalaPenilaianController;
use App\Http\Controllers\TemplateSurveiController;

// Login Route
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

// Logout Route
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Main route
Route::get('/', function () {
    return view('login');
});

// Index Route (Dashboard/Home)
Route::get('/index', function () {
    return view('index');
});

// Kriteria Survei
Route::get('/KriteriaSurvei/index', [KriteriaSurveiController::class, 'index'])->name('KriteriaSurvei.index');
Route::post('/KriteriaSurvei/save', [KriteriaSurveiController::class, 'save'])->name('KriteriaSurvei.save');
Route::get('/KriteriaSurvei/edit/{id}', [KriteriaSurveiController::class, 'edit'])->name('KriteriaSurvei.edit');
Route::put('/KriteriaSurvei/update/{id}', [KriteriaSurveiController::class, 'update'])->name('KriteriaSurvei.update');
Route::delete('/KriteriaSurvei/delete/{id}', [KriteriaSurveiController::class, 'delete'])->name('KriteriaSurvei.delete');

// Skala Penilaian
Route::get('/SkalaPenilaian/index', [SkalaPenilaianController::class, 'index'])->name('SkalaPenilaian.index');
Route::post('/SkalaPenilaian/save', [SkalaPenilaianController::class, 'save'])->name('SkalaPenilaian.save');
Route::get('/SkalaPenilaian/edit/{id}', [SkalaPenilaianController::class, 'edit'])->name('SkalaPenilaian.edit');
Route::put('/SkalaPenilaian/update/{id}', [SkalaPenilaianController::class, 'update'])->name('SkalaPenilaian.update');
Route::delete('/SkalaPenilaian/delete/{id}', [SkalaPenilaianController::class, 'delete'])->name('SkalaPenilaian.delete');

// Template Survei
Route::get('/TemplateSurvei/index', [TemplateSurveiController::class, 'index'])->name('TemplateSurvei.index');
Route::get('/TemplateSurvei/create', [TemplateSurveiController::class, 'create'])->name('TemplateSurvei.create');
Route::post('/TemplateSurvei/save', [TemplateSurveiController::class, 'save'])->name('TemplateSurvei.save');
Route::get('/TemplateSurvei/edit/{id}', [TemplateSurveiController::class, 'edit'])->name('TemplateSurvei.edit');
Route::put('/TemplateSurvei/update/{id}', [TemplateSurveiController::class, 'update'])->name('TemplateSurvei.update');
Route::delete('/TemplateSurvei/delete/{id}', [TemplateSurveiController::class, 'delete'])->name('TemplateSurvei.delete');

// Pertanyaan Survei
Route::get('/PertanyaanSurvei/index', function () {
    return view('/PertanyaanSurvei/index');
});

// Survei
Route::get('/Survei/index', function () {
    return view('/Survei/index');
});

// Daftar Survei
Route::get('/DaftarSurvei/index', function () {
    return view('/DaftarSurvei/index');
});
