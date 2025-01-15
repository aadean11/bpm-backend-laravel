<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\KriteriaSurveiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SkalaPenilaianController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\TemplateSurveiController;
use App\Http\Controllers\SurveiController;

// Login Route
Route::post('/login', [LoginController::class, 'login'])->name('login.process');

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

//skala
Route::get('/SkalaPenilaian/index', [SkalaPenilaianController::class, 'index'])->name('SkalaPenilaian.index');
Route::post('/SkalaPenilaian/save', [SkalaPenilaianController::class, 'save'])->name('SkalaPenilaian.save');
Route::get('/SkalaPenilaian/add', [SkalaPenilaianController::class, 'add'])->name('SkalaPenilaian.add');

Route::get('/SkalaPenilaian/edit/{id}', [SkalaPenilaianController::class, 'edit'])->name('SkalaPenilaian.edit');
Route::put('/SkalaPenilaian/update/{id}', [SkalaPenilaianController::class, 'update'])->name('SkalaPenilaian.update');
Route::delete('/SkalaPenilaian/delete/{id}', [SkalaPenilaianController::class, 'delete'])->name('SkalaPenilaian.delete');
Route::get('/SkalaPenilaian/detail/{id}', [SkalaPenilaianController::class, 'detail'])->name('SkalaPenilaian.detail');

//pertanyaan
Route::get('/PertanyaanSurvei/index', [PertanyaanController::class, 'index'])->name('PertanyaanSurvei.index');

//template
Route::get('/TemplateSurvei/index', [TemplateSurveiController::class, 'index'])->name('TemplateSurvei.index');
Route::get('/TemplateSurvei/create', [TemplateSurveiController::class, 'create'])->name('TemplateSurvei.create');
Route::post('/TemplateSurvei/save', [TemplateSurveiController::class, 'save'])->name('TemplateSurvei.save');
Route::get('/TemplateSurvei/edit/{id}', [TemplateSurveiController::class, 'edit'])->name('TemplateSurvei.edit');
Route::put('/TemplateSurvei/update/{id}', [TemplateSurveiController::class, 'update'])->name('TemplateSurvei.update');
Route::delete('/TemplateSurvei/delete/{id}', [TemplateSurveiController::class, 'delete'])->name('TemplateSurvei.delete');
Route::put('/TemplateSurvei/final/{id}', [TemplateSurveiController::class, 'final'])->name('TemplateSurvei.final');
Route::get('/TemplateSurvei/detail/{id}', [TemplateSurveiController::class, 'detail'])->name('TemplateSurvei.detail');
// Route::get('/export-pdf', [TemplateSurveiController::class, 'exportPdf'])->name('TemplateSurvei.exportPdf');

//survei
Route::get('/Survei/index', [SurveiController::class, 'index'])->name('Survei.index');
Route::get('/Survei/create', [SurveiController::class, 'create'])->name('Survei.create');
Route::get('/Survei/save', [SurveiController::class, 'save'])->name('Survei.save');
Route::get('/Survei/edit', [SurveiController::class, 'edit'])->name('Survei.edit');


//Daftar Survei
Route::get('/DaftarSurvei/read', [SurveiController::class, 'read'])->name('Survei.read');
//Daftar Survei
Route::get('/DaftarSurvei/isi', [SurveiController::class, 'fill'])->name('Survei.fill');


//responden
Route::get('/DaftarSurvei/isi', [SurveiController::class, 'fill'])->name('Survei.fill');
Route::get('/DaftarSurvei/isi', [SurveiController::class, 'fill'])->name('Survei.fill');
Route::get('/DaftarSurvei/isi', [SurveiController::class, 'fill'])->name('Survei.fill');
