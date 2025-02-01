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
            <a href="../TemplateDetail/index">
                <li><i class="fas fa-file"></i><span> Template Detail</span></li>
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

    <div class="content mt-5">
        <div class="mb-3 border-bottom">
            <div class="page-nav-title">Template Detail</div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('TemplateDetail.index') }}">Template Detail</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Template Detail</li>
                </ol>
            </nav>
        </div>
    
        <div class="container mt-5">
            <div class="form-control">
                <h2 class="text-center mt-3">Tambah Template Detail</h2>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
    
                <form action="{{ route('TemplateDetail.save') }}" method="POST" id="templateDetailForm">
                    @csrf
    
                    <!-- Template Survei Selection -->
                    <div class="col-md-6 mb-3">
                        <label for="tsu_id" class="form-label fw-bold">Template Survei</label>
                        <select name="tsu_id" id="tsu_id" class="form-select" required>
                            <option value="">Pilih Template Survei</option>
                            @foreach($template_survei as $template)
                                <option 
                                    value="{{ $template->tsu_id }}" 
                                    {{ old('tsu_id', request()->tsu_id) == $template->tsu_id ? 'selected' : '' }}>
                                    {{ $template->tsu_nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                                        
                    {{-- <div class="form-group mb-3">
                        <label for="ksr_id">Kriteria Survei <span style="color:red">*</span></label>
                        <select name="ksr_id" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Kriteria Survei --</option>
                            @foreach($kriteria_survei as $kriteria)
                                <option value="{{ $kriteria->ksr_id }}">{{ $kriteria->ksr_nama }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    <!-- Pertanyaan Input -->
                    <div class="col-md-6 mb-3">
                        <label for="tsd_pertanyaan" class="form-label fw-bold">Pertanyaan</label>
                        <input type="text" 
                               class="form-control" 
                               id="tsd_pertanyaan" 
                               name="tsd_pertanyaan" 
                               required 
                               maxlength="255"
                               value="{{ old('tsd_pertanyaan') }}">
                    </div>
    
                    <!-- Header Checkbox -->
                    <div class="col-md-6 mb-3">
                        <label for="header" class="form-label fw-bold">Header</label>
                        <div class="form-check">
                            <input type="checkbox" 
                                   id="headerYa" 
                                   name="tsd_isheader" 
                                   class="form-check-input" 
                                   value="1" 
                                   {{ old('tsd_isheader') ? 'checked' : '' }}>
                        </div>
                    </div>
    
                    <!-- Jenis Pertanyaan Radio -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Jenis Pertanyaan</label>
                        <div>
                            <div class="form-check">
                                <input type="radio" 
                                       id="jenis_pilgan" 
                                       name="tsd_jenis" 
                                       class="form-check-input" 
                                       value="Pilgan" 
                                       required 
                                       {{ old('tsd_jenis') == 'Pilgan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="jenis_pilgan">Pilihan Ganda</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" 
                                       id="jenis_singkat" 
                                       name="tsd_jenis" 
                                       class="form-check-input" 
                                       value="Singkat" 
                                       required 
                                       {{ old('tsd_jenis') == 'Singkat' ? 'checked' : '' }}>
                                <label class="form-check-label" for="jenis_singkat">Jawaban Singkat</label>
                            </div>
                        </div>
                    </div>
    
                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1 m-2">
                            <a href="{{ route('TemplateDetail.index') }}" class="btn btn-secondary w-100">Kembali</a>
                        </div>
                        <div class="flex-grow-1 m-2">
                            <button type="submit" class="btn btn-primary w-100">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('templateDetailForm');
            
            // Success message
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('TemplateDetail.index') }}";
                    }
                });
            @endif
    
            // Form validation
            form.addEventListener('submit', function(event) {
                const pertanyaan = document.getElementById('tsd_pertanyaan').value;
                const templateSurvei = document.getElementById('tsu_id').value;
                const jenisRadios = document.querySelectorAll('input[name="tsd_jenis"]:checked');
    
                if (!pertanyaan || !templateSurvei || jenisRadios.length === 0) {
                    event.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal',
                        text: 'Mohon lengkapi semua field yang wajib diisi!',
                    });
                }
            });
    
            // Header checkbox and jenis pertanyaan logic
            const headerCheckbox = document.getElementById('headerYa');
            const radioButtons = document.querySelectorAll('input[name="tsd_jenis"]');
    
            headerCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    document.getElementById('jenis_singkat').checked = true;
                }
            });
    
            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.id === 'jenis_pilgan') {
                        headerCheckbox.checked = false;
                    }
                });
            });
        });
    </script>
    </div>
</head>