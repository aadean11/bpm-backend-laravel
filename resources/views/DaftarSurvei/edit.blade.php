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
        <div class="user-info" style="color: white; font-size: 16px;">
            <strong>{{ Session::get('karyawan.nama_lengkap') }}</strong> 
            <strong>({{ Session::get('karyawan.role') }})</strong>
            <div class="last-login" style="color: white; font-size: 12px; margin-top: 5px;">
                Login terakhir: <small>{{ \Carbon\Carbon::parse(Session::get('karyawan.last_login'))->format('d M Y H:i') }}</small>
            </div>
        </div>
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
            <a href="../Karyawan/index"><li><i class="fas fa-file"></i><span>Karyawan</span></li></a>
        </ul>
        <!-- Tombol Logout -->
        <div class="logout">
            <a href="../logout"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
        </div>
    </div>

    <!-- Content -->
    <div class="content mt-5">
        <div class="mb-3 border-bottom">
            <div class="page-nav-title">
                Edit Daftar Survei
            </div>
    
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('DaftarSurvei.index') }}">Daftar Survei</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
    
        <div class="card">
            <div class="card-body">
                <h2 class="text-center mb-4">Edit Daftar Survei</h2>
    
                <form id="editForm" action="{{ route('DaftarSurvei.update', $survei_detail->id) }}" method="POST">
                    @csrf
                    @method('PUT')
    
                    <!-- Pilih Survei -->
                    <div class="mb-3">
                        <label for="trs_id" class="form-label fw-bold">Survei *</label>
                        <select id="trs_id" name="trs_id" class="form-select" required>
                            <option value="">-- Pilih Survei --</option>
                            @foreach($survei_list as $survei)
                                <option value="{{ $survei->trs_id }}"
                                    {{ $survei_detail->trs_id == $survei->trs_id ? 'selected' : '' }}>
                                    {{-- Tampilkan nama survei. Pastikan atribut ini sesuai dengan model Anda --}}
                                    {{ $survei->trs_nama ?? 'Survei '.$survei->trs_id }}
                                </option>
                            @endforeach
                        </select>
                    </div>
    
                    <!-- Pilih Pertanyaan -->
                    <div class="mb-3">
                        <label for="pty_id" class="form-label fw-bold">Pertanyaan *</label>
                        <select id="pty_id" name="pty_id" class="form-select" required>
                            <option value="">-- Pilih Pertanyaan --</option>
                            @foreach($pertanyaan_list as $pertanyaan)
                                <option value="{{ $pertanyaan->pty_id }}"
                                    {{ $survei_detail->pty_id == $pertanyaan->pty_id ? 'selected' : '' }}>
                                    {{ $pertanyaan->pty_pertanyaan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
    
                    <!-- Pilih Skala Penilaian -->
                    <div class="mb-3">
                        <label for="skp_id" class="form-label fw-bold">Skala Penilaian *</label>
                        <select id="skp_id" name="skp_id" class="form-select" required>
                            <option value="">-- Pilih Skala Penilaian --</option>
                            @foreach($skala_penilaian_list as $skala)
                                <option value="{{ $skala->skp_id }}"
                                    {{ $survei_detail->skp_id == $skala->skp_id ? 'selected' : '' }}>
                                    {{-- Tampilkan deskripsi atau informasi lain dari skala --}}
                                    {{ $skala->skp_deskripsi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
    
                    <!-- Input Nilai -->
                    <div class="mb-3">
                        <label for="dtt_nilai" class="form-label fw-bold">Nilai *</label>
                        <input type="number" id="dtt_nilai" name="dtt_nilai" class="form-control" 
                               value="{{ old('dtt_nilai', $survei_detail->dtt_nilai) }}" required>
                    </div>
    
                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1 m-2">
                            <a href="{{ route('DaftarSurvei.index') }}">
                                <button type="button" class="btn btn-secondary" style="width:100%">
                                    Kembali
                                </button>
                            </a>
                        </div>
                        <div class="flex-grow-1 m-2">
                            <button type="submit" class="btn btn-primary" style="width:100%">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Sertakan SweetAlert dan JS (misalnya Bootstrap JS) sesuai kebutuhan -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Menampilkan notifikasi sukses atau error dari session -->
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session("success") }}'
            });
        </script>
    @endif
    
    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session("error") }}'
            });
        </script>
    @endif
    
    <!-- Menampilkan notifikasi error validasi -->
    @if ($errors->any())
        <script>
            let errorMessages = '';
            @foreach ($errors->all() as $error)
                errorMessages += '{{ $error }}\n';
            @endforeach
            Swal.fire({
                icon: 'error',
                title: 'Terdapat kesalahan',
                text: errorMessages,
            });
        </script>
    @endif
    
    </body>
    </html>