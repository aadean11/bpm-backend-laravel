<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\KriteriaSurveiController;
use App\Http\Controllers\SkalaPenilaianController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\TemplateSurveiController;


// Login Route
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

// Logout Route
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


Route::get('/', function () {
    return view('login');
});

// Route::middleware(['auth'])->get('/index', function () {
//     return view('index');
// })->name('index');

Route::get('/index', function () {
    return view('index');
});


// kriteria
// Route::get('/KriteriaSurvei/index', function () {
//     return view('/KriteriaSurvei/index');
// });

//Route::resource('KriteriaSurvei', KriteriaSurveiController::class);
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

//pertanyaan
Route::get('/Pertanyaan/create', [PertanyaanController::class, 'create'])->name('Pertanyaan.create');
Route::post('/Pertanyaan/store', [PertanyaanController::class, 'store'])->name('Pertanyaan.store');

Route::post('/PertanyaanSurvei/store', [PertanyaanController::class, 'store'])->name('Pertanyaan.store');
Route::get('/PertanyaanSurvei/create', [PertanyaanController::class, 'create'])->name('Pertanyaan.create');

Route::get('PertanyaanSurvei/index', [PertanyaanController::class, 'index'])->name('Pertanyaan.index');
Route::get('Pertanyaan/index', [PertanyaanController::class, 'index'])->name('Pertanyaan.index');
Route::put('/Pertanyaan/update/{id}', [PertanyaanController::class, 'update'])->name('Pertanyaan.update');
Route::post('Pertanyaan/save', [PertanyaanController::class, 'save'])->name('Pertanyaan.save');
Route::get('PertanyaanSurvei/edit/{id}', [PertanyaanController::class, 'edit'])->name('Pertanyaan.edit');
Route::post('Pertanyaan/update/{id}', [PertanyaanController::class, 'update'])->name('Pertanyaan.update');

Route::delete('/Pertanyaan/delete/{id}', [PertanyaanController::class, 'delete'])->name('Pertanyaan.delete');

Route::get('Pertanyaan/delete/{id}', [PertanyaanController::class, 'delete'])->name('Pertanyaan.delete');
Route::get('/Pertanyaan/export', [PertanyaanController::class, 'exportPdf'])->name('Pertanyaan.export');
Route::get('/Pertanyaan/export', [PertanyaanController::class, 'exportExcel'])->name('Pertanyaan.export');
Route::get('/Pertanyaan/export-pdf', [PertanyaanController::class, 'exportPdf'])->name('Pertanyaan.exportPdf');

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
