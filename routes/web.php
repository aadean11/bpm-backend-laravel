<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\KriteriaSurveiController;
use App\Http\Controllers\SkalaPenilaianController;
use App\Http\Controllers\TemplateSurveiController;
use App\Http\Controllers\SurveiController;

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

//skala
Route::get('/SkalaPenilaian/index', [SkalaPenilaianController::class, 'index'])->name('SkalaPenilaian.index');
Route::get('/SkalaPenilaian/add', [SkalaPenilaianController::class, 'add'])->name('SkalaPenilaian.add');


//pertanyaan
Route::get('/PertanyaanSurvei/index', [PertanyaanController::class, 'index'])->name('PertanyaanSurvei.index');

//template
Route::get('/TemplateSurvei/index', [TemplateSurveiController::class, 'index'])->name('TemplateSurvei.index');



//survei
Route::get('/Survei/index', [SurveiController::class, 'index'])->name('Survei.index');


//Daftar Survei
Route::get('/Survei/read', [SurveiController::class, 'read'])->name('Survei.read');


