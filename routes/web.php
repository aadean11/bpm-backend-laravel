<?php

use Illuminate\Support\Facades\Route;


Route::get('/index', function () {
    return view('index');
});
Route::get('/login', function () {
    return view('login');
});

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

