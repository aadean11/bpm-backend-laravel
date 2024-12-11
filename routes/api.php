<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\KriteriaSurveiController;
use App\Http\Controllers\API\PertanyaanController;
use App\Http\Controllers\API\TemplateSurveiController;
use App\Http\Controllers\API\SkalaPenilaianController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Grup dengan prefix 'v1' dan middleware 'auth:sanctum'
Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function () {
    // Rute untuk Kriteria Survei
    Route::get('kriteria-survei', [KriteriaSurveiController::class, 'listKriteriaSurvei'])->name('kriteria-survei.list');
    Route::get('kriteria-survei/{id}', [KriteriaSurveiController::class, 'getKriteriaSurvei'])->name('kriteria-survei.show');
    Route::post('kriteria-survei', [KriteriaSurveiController::class, 'createKriteriaSurvei'])->name('kriteria-survei.create');
    Route::put('kriteria-survei/{id}', [KriteriaSurveiController::class, 'updateKriteriaSurvei'])->name('kriteria-survei.update');
    Route::delete('kriteria-survei/{id}', [KriteriaSurveiController::class, 'deleteKriteriaSurvei'])->name('kriteria-survei.delete');

    // Rute untuk Skala Penilaian
    Route::get('skala-penilaian', [SkalaPenilaianController::class, 'listSkalaPenilaian'])->name('skala-penilaian.list');
    Route::get('skala-penilaian/{id}', [SkalaPenilaianController::class, 'getSkalaPenilaian'])->name('skala-penilaian.show');
    Route::post('skala-penilaian', [SkalaPenilaianController::class, 'createSkalaPenilaian'])->name('skala-penilaian.create');
    Route::put('skala-penilaian/{id}', [SkalaPenilaianController::class, 'updateSkalaPenilaian'])->name('skala-penilaian.update');
    Route::delete('skala-penilaian/{id}', [SkalaPenilaianController::class, 'deleteSkalaPenilaian'])->name('skala-penilaian.delete');
    
    // Rute untuk Pertanyaan
    Route::get('pertanyaan', [PertanyaanController::class, 'listPertanyaan'])->name('pertanyaan.list');
    Route::get('pertanyaan/{id}', [PertanyaanController::class, 'getPertanyaan'])->name('pertanyaan.show');
    Route::post('pertanyaan', [PertanyaanController::class, 'createPertanyaan'])->name('pertanyaan.create');
    Route::put('pertanyaan/{id}', [PertanyaanController::class, 'updatePertanyaan'])->name('pertanyaan.update');
    Route::delete('pertanyaan/{id}', [PertanyaanController::class, 'deletePertanyaan'])->name('pertanyaan.delete');

    // Rute untuk Template Survei
    Route::get('template_survei', [TemplateSurveiController::class, 'listTemplateSurvei'])->name('template_survei.list');
    Route::get('template_survei/{id}', [TemplateSurveiController::class, 'getTemplateSurvei'])->name('template_survei.show');
    Route::post('template_survei', [TemplateSurveiController::class, 'createTemplateSurvei'])->name('template_survei.create');
    Route::put('template_survei/{id}', [TemplateSurveiController::class, 'updateTemplateSurvei'])->name('template_survei.update');
    Route::delete('template_survei/{id}', [TemplateSurveiController::class, 'deleteTemplateSurvei'])->name('template_survei.delete');

   
});
