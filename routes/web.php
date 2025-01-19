<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\KriteriaSurveiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SkalaPenilaianController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\TemplateSurveiController;
use App\Http\Controllers\TemplateDetailController;
use App\Http\Controllers\SurveiController;

// // V1
// Route::get('login', [LoginController::class, 'login'])->name('login');
// Route::post('login', [LoginController::class, 'processLogin'])->name('login.process');
// Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/index', function () {
    if (!Session::has('karyawan')) {
        return redirect()->route('login')->with('alert', 'Silakan login terlebih dahulu.');
    }

    return view('index', ['nama_lengkap' => Session::get('karyawan.nama_lengkap')]);
})->name('index');

// Main route
Route::get('/', function () {
    return view('login');
});

// Route::middleware(['auth'])->get('/index', function () {
//     return view('index');
// })->name('index');

// Route::get('/index', function () {
//     return view('index');
// });



Route::get('/TemplateDetail/create', [TemplateDetailController::class, 'create'])->name('TemplateDetail.create');
Route::post('/TemplateDetail/store', [TemplateDetailController::class, 'store'])->name('TemplateDetail.store');

Route::post('/TemplateDetailSurvei/store', [TemplateDetailController::class, 'store'])->name('TemplateDetail.store');
Route::get('/TemplateDetailSurvei/create', [TemplateDetailController::class, 'create'])->name('TemplateDetail.create');

Route::get('TemplateDetailSurvei/index', [TemplateDetailController::class, 'index'])->name('TemplateDetail.index');
Route::get('TemplateDetail/index', [TemplateDetailController::class, 'index'])->name('TemplateDetail.index');
Route::put('/TemplateDetail/update/{id}', [TemplateDetailController::class, 'update'])->name('TemplateDetail.update');
Route::post('TemplateDetail/save', [TemplateDetailController::class, 'save'])->name('TemplateDetail.save');
Route::get('TemplateDetailSurvei/edit/{id}', [TemplateDetailController::class, 'edit'])->name('TemplateDetail.edit');
Route::post('TemplateDetail/update/{id}', [TemplateDetailController::class, 'update'])->name('TemplateDetail.update');

Route::get('/TemplateDetail/{id}/detail', [TemplateDetailController::class, 'detail'])->name('TemplateDetail.detail');

Route::delete('/TemplateDetail/delete/{id}', [TemplateDetailController::class, 'delete'])->name('TemplateDetail.delete');

Route::get('TemplateDetail/delete/{id}', [TemplateDetailController::class, 'delete'])->name('TemplateDetail.delete');
Route::get('/TemplateDetail/export', [TemplateDetailController::class, 'exportExcel'])->name('TemplateDetail.export');
Route::get('/TemplateDetail/export', [TemplateDetailController::class, 'exportExcel'])->name('TemplateDetail.export');

Route::get('/download-template', [TemplateDetailController::class, 'downloadTemplate'])->name('templatedetail.downloadTemplate');

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
// Route::delete('/SkalaPenilaian/delete/{id}', [SkalaPenilaianController::class, 'delete'])->name('SkalaPenilaian.delete');
Route::get('/SkalaPenilaian/detail/{id}', [SkalaPenilaianController::class, 'detail'])->name('SkalaPenilaian.detail');
Route::post('/SkalaPenilaian/toggle/{id}', [SkalaPenilaianController::class, 'toggleStatus'])->name('SkalaPenilaian.toggle');

//pertanyaan
//Route::get('/Pertanyaan/create', [PertanyaanController::class, 'create'])->name('Pertanyaan.create');
Route::post('/Pertanyaan/store', [PertanyaanController::class, 'store'])->name('Pertanyaan.store');
Route::post('/PertanyaanSurvei/store', [PertanyaanController::class, 'store'])->name('Pertanyaan.store');
Route::get('/PertanyaanSurvei/create', [PertanyaanController::class, 'create'])->name('Pertanyaan.create');
Route::get('PertanyaanSurvei/index', [PertanyaanController::class, 'index'])->name('Pertanyaan.index');
Route::get('Pertanyaan/index', [PertanyaanController::class, 'index'])->name('Pertanyaan.index');
Route::put('/Pertanyaan/update/{id}', [PertanyaanController::class, 'update'])->name('Pertanyaan.update');
Route::post('Pertanyaan/save', [PertanyaanController::class, 'save'])->name('Pertanyaan.save');
Route::get('PertanyaanSurvei/edit/{id}', [PertanyaanController::class, 'edit'])->name('Pertanyaan.edit');
Route::post('Pertanyaan/update/{id}', [PertanyaanController::class, 'update'])->name('Pertanyaan.update');
Route::get('/pertanyaan/{id}/detail', [PertanyaanController::class, 'detail'])->name('Pertanyaan.detail');
Route::delete('/Pertanyaan/delete/{id}', [PertanyaanController::class, 'delete'])->name('Pertanyaan.delete');
Route::get('Pertanyaan/delete/{id}', [PertanyaanController::class, 'delete'])->name('Pertanyaan.delete');
Route::get('/Pertanyaan/export', [PertanyaanController::class, 'exportExcel'])->name('Pertanyaan.export');
Route::get('/pertanyaan/export', [PertanyaanController::class, 'exportExcel'])->name('pertanyaan.export');
Route::get('/download-template', [PertanyaanController::class, 'downloadTemplate'])->name('pertanyaan.downloadTemplate');

//template
Route::get('/TemplateSurvei/index', [TemplateSurveiController::class, 'index'])->name('TemplateSurvei.index');
Route::get('/TemplateSurvei/create', [TemplateSurveiController::class, 'create'])->name('TemplateSurvei.create');
Route::post('/TemplateSurvei/save', [TemplateSurveiController::class, 'save'])->name('TemplateSurvei.save');
Route::get('/TemplateSurvei/edit/{id}', [TemplateSurveiController::class, 'edit'])->name('TemplateSurvei.edit');
Route::put('/TemplateSurvei/update/{id}', [TemplateSurveiController::class, 'update'])->name('TemplateSurvei.update');
Route::delete('/TemplateSurvei/delete/{id}', [TemplateSurveiController::class, 'delete'])->name('TemplateSurvei.delete');
Route::put('/TemplateSurvei/final/{id}', [TemplateSurveiController::class, 'final'])->name('TemplateSurvei.final');
Route::get('/TemplateSurvei/detail/{id}', [TemplateSurveiController::class, 'detail'])->name('TemplateSurvei.detail');
Route::post('/template-survei/save', [TemplateSurveiController::class, 'ajaxStore'])->name('TemplateSurvei.ajaxSave');
// Route::get('/search-template-survei', [TemplateSurveiController::class, 'search'])->name('TemplateSurvei.search');
// Route::get('/export-pdf', [TemplateSurveiController::class, 'exportPdf'])->name('TemplateSurvei.exportPdf');



// // Route::get('/search-template-survei', [TemplateSurveiController::class, 'search'])->name('TemplateSurvei.search');
// // Route::get('/export-pdf', [TemplateSurveiController::class, 'exportPdf'])->name('TemplateSurvei.exportPdf');


//survei
Route::get('/Survei/index', [SurveiController::class, 'index'])->name('Survei.index');
Route::get('/Survei/create', [SurveiController::class, 'create'])->name('Survei.create');
Route::get('/Survei/save', [SurveiController::class, 'save'])->name('Survei.save');
Route::get('/Survei/edit', [SurveiController::class, 'edit'])->name('Survei.edit');


//Daftar Survei
Route::get('/DaftarSurvei/index', function () {
    return view('/DaftarSurvei/index');
});
