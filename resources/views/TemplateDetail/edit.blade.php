<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BPM Politeknik Astra</title>
    <!-- FontAwesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- CSS -->
    <style>
        /* Styling untuk breadcrumbs dan PageNavTitle */
        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin: 10px 0;
        }

        .page-nav-title {
            font-size: 24px;
            font-weight: bold;
            color: #2654A1;
            margin-bottom: 15px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #ffffff;
            color: #2654A1;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            padding-top: 60px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.3s ease;
        }

        .sidebar.hide {
            transform: translateX(-100%);
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            display: flex;
            align-items: center;
            padding: 10px 20px;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #2654A1;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar ul li i {
            margin-right: 10px;
        }

        .sidebar ul li:hover {
            color: #ffffff;
            background-color: #2654A1;
            cursor: pointer;
        }

        /* .sidebar ul li a:hover {
            color:#2654A1;
            cursor: pointer;
        } */

        /* Tombol Logout */
        .logout {
            margin-top: auto;
            padding: 10px 20px;
            text-align: left;
            background-color: #1e4690;
        }

        .logout a {
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logout:hover {
            background-color: #173b75;
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 60px;
            background-color: #2654A1;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 1000;
        }

        .header .menu-toggle {
            font-size: 24px;
            cursor: pointer;
        }

        /* Content */
        .content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
            width: 100%;
        }

        .sidebar.hide+.content {
            margin-left: 0;
        }

        th,
        td {
            text-align: center;
        }

        /* Responsif untuk layar kecil */
        @media screen and (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .content {
                margin-left: 0;
            }
        }

        a {
            text-decoration: none;
            /* Menghilangkan garis bawah */
            color: inherit;
            /* Menggunakan warna teks dari parent (bukan warna default link) */
            /*display: flex; /* Membuat ikon dan teks berjejer */
            align-items: center;
            /* Pusatkan vertikal antara ikon dan teks */
            padding: 5px
        }

        a:hover {
            color: inherit;
            /* Warna tetap sama saat di-hover */
        }
    </style>

<body>
     <!-- Header -->
     <div class="header border-bottom">
        <i class="fa fa-bars menu-toggle"></i>
        <h2>BPM Politeknik Astra</h2>
    </div>

    <!-- Sidebar -->
    <div class="sidebar border-end" id="sidebar">
        <ul>
            <a href="../index">
                <li><i class="fas fa-home"></i> Dashboard</li>
            </a>
            <a href="../KriteriaSurvei/index">
                <li><i class="fas fa-list"></i><span> Kriteria Survei</span></li>
            </a>
            <a href="../SkalaPenilaian/index">
                <li><i class="fas fa-sliders-h"></i><span> Skala Penilaian</span></li>
            </a>
            <a href="../PertanyaanSurvei/index">
                <li><i class="fas fa-question-circle"></i><span> Pertanyaan</span></li>
            </a>
            <a href="../TemplateSurvei/index">
                <li><i class="fas fa-file"></i><span> Template Survei</span></li>
            </a>
            <a href="../Survei/index">
                <li><i class="fas fa-poll"></i><span> Survei</span></li>
            </a>
            <a href="../DaftarSurvei/index">
                <li><i class="fas fa-list-alt"></i><span>Daftar Survei</span></li>
            </a>
        </ul>
        <!-- Tombol Logout -->
        <div class="logout">
            <a href="../logout"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
        </div>
    </div>
    
    <div class="content mt-5">
        <!-- PageNavTitle -->
        <div class="mb-3 border-bottom"> 
                <div class="page-nav-title">
                    Detail Template Survei
                </div>
    
                <!-- Breadcrumbs -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" ><a href="{{ route('TemplateDetail.index')}}">Template Detail</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Detail Template</li>
                    </ol>
                </nav>
            </div>
    
            <h2 class="text-center mt-3">Edit Detail Template Survei</h2>
            <form action="{{ route('TemplateDetail.update', $templateDetail->tsd_id) }}" method="POST">
            @csrf
            @method('PUT')
    
           <!-- Header Checkbox -->
            <div class="col-md-6 mb-3">
                <label for="headerYa" class="form-label fw-bold">Header</label>
                <div class="form-check">
                    <input type="checkbox" id="headerYa" name="tsd_isheader" class="form-check-input" value="1" {{ old('tsd_isheader', $templateDetail->tsd_isheader) == 1 ? 'checked' : '' }}>
                </div>
            </div>
    
        <!-- Pertanyaan Input -->
        <div class="col-md-12 mb-3">
            <label for="pertanyaan" class="form-label fw-bold">Pertanyaan</label>
            <input type="text" name="tsd_pertanyaan" id="pertanyaan" class="form-control" value="{{ old('tsd_pertanyaan', $templateDetail->tsd_pertanyaan) }}" placeholder="Masukkan Pertanyaan" required>
        </div>
    
        <!-- Jenis Input -->
        <div class="col-md-12 mb-3">
            <label for="jenis" class="form-label fw-bold">Jenis</label>
            <input type="text" name="tsd_jenis" id="jenis" class="form-control" value="{{ old('tsd_jenis', $templateDetail->tsd_jenis) }}" placeholder="Masukkan Jenis" required>
        </div>
    
        <!-- Template Survei -->
        <div class="form-group mb-3">
            <label for="tsu_id">Template Survei <span style="color:red">*</span></label>
            <select name="tsu_id" id="tsu_id" class="form-control" required>
                <option value="" disabled>-- Pilih Template Survei --</option>
                @foreach($template_survei as $template)
                    <option value="{{ $template->tsu_id }}" {{ old('tsu_id', $templateDetail->tsu_id) == $template->tsu_id ? 'selected' : '' }}>
                        {{ $template->tsu_nama }}
                    </option>
                @endforeach
            </select>
        </div>
    
        <!-- Tombol Kembali dan Simpan -->
        <div class="d-flex justify-content-between align-items-center">
            <div class="flex-grow-1 m-2">
                <a href="{{ route('TemplateDetail.index') }}">
                    <button class="btn btn-secondary" type="button" style="width:100%">Kembali</button>
                </a>
            </div>
            <div class="flex-grow-1 m-2">
                <button class="btn btn-primary" style="width:100%" type="submit">Simpan</button>
            </div>
        </div>
    </form>
    </div>
    
       <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Handle additional logic if necessary
        });
    </script>
    </div>
    </head>
    