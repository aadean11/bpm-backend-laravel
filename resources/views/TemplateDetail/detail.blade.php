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


</head>

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
            <a href="../Survei/read">
                <li><i class="fas fa-list-alt"></i><span>Daftar Survei</span></li>
            </a>
        </ul>
        <!-- Tombol Logout -->
        <div class="logout">
            <a href="../logout"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
        </div>
    </div>

<body>
   <!-- Content -->
<div class="content mt-5">
    <div class="mb-3 border-bottom">
        <div class="page-nav-title">
            Detail Pertanyaan Survei
        </div>

        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('Pertanyaan.index') }}">Pertanyaan Survei</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </nav>
    </div>

    <!-- Detail Pertanyaan Survei -->
    <div class="form-control">
        <div class="row">
            <h2 class="text-center mt-3 mb-3">Detail Pertanyaan Survei</h2><hr>
            <div class="col-md-6">
                <strong>Pertanyaan</strong>
                <p>{{ $pertanyaan->pty_pertanyaan ?? '-' }}</p>
            </div>
            <div class="col-md-6">
                <strong>Header</strong>
                <p>{{ $pertanyaan->pty_isheader == 1 ? 'Ya' : 'Tidak' }}</p>
            </div>
            <div class="col-md-6">
                <strong>Pertanyaan Umum</strong>
                <p>{{ $pertanyaan->pty_isgeneral == 1 ? 'Ya' : 'Tidak' }}</p>
            </div>
            <div class="col-md-6">
                <strong>Status</strong>
                <p>{{ $pertanyaan->pty_status == 1 ? 'Aktif' : 'Tidak Aktif' }}</p>
            </div>
            <div class="col-md-6">
                <strong>Dibuat Oleh</strong>
                <p>{{ $pertanyaan->pty_created_by ?? '-' }}</p>
            </div>
            <div class="col-md-6">
                <strong>Tanggal Dibuat</strong>
                <p>{{ $pertanyaan->pty_created_date ? \Carbon\Carbon::parse($pertanyaan->pty_created_date)->format('d-m-Y H:i:s') : '-' }}</p>
            </div>
            <div class="col-md-6">
                <strong>Dimodifikasi Oleh</strong>
                <p>{{ $pertanyaan->pty_modif_by ?? '-' }}</p>
            </div>
            <div class="col-md-6">
                <strong>Tanggal Dimodifikasi</strong>
                <p>{{ $pertanyaan->pty_modif_date ? \Carbon\Carbon::parse($pertanyaan->pty_modif_date)->format('d-m-Y H:i:s') : '-' }}</p>
            </div>
            
            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 m-2">
                    <a href="{{ route('Pertanyaan.index') }}">
                        <button class="btn btn-secondary" type="button" style="width:100%">
                            Kembali
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('#sidebar');

    menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('hide');
    });
</script>
</div>
</head>
