<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\KriteriaSurveiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SkalaPenilaianController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\TemplateSurveiController;
use App\Http\Controllers\SurveiController;

Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'processLogin'])->name('login.process');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

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
// Route::get('/search-template-survei', [TemplateSurveiController::class, 'search'])->name('TemplateSurvei.search');
// Route::get('/export-pdf', [TemplateSurveiController::class, 'exportPdf'])->name('TemplateSurvei.exportPdf');

//survei
Route::get('/Survei/index', [SurveiController::class, 'index'])->name('Survei.index');


//Daftar Survei
Route::get('/Survei/read', [SurveiController::class, 'read'])->name('Survei.read');


