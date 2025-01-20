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

    <!-- Content -->
    <div class="content mt-5">
        <div class="mb-3 border-bottom"> <!-- PageNavTitle -->
            <div class="page-nav-title">
                Pertanyaan Survei
            </div>

            <!-- Breadcrumbs -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" ><a href="{{ route('Pertanyaan.index')}}">Pertanyaan Survei</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Pertanyaan Survei</li>
                </ol>   
            </nav>
        </div>

        <div class="container mt-5">
        <div class="form-control">
    <h2 class="text-center mt-3">Tambah Pertanyaan Survei</h2>
    <form action="{{ route('Pertanyaan.save') }}" method="POST">
        @csrf
        
    
        <!-- Header Checkbox -->
        <div class="col-md-6 mb-3">
            <label for="header" class="form-label fw-bold">Header</label>
            <div class="form-check">
                <input type="checkbox" id="headerYa" name="pty_isheader" class="form-check-input" value="1">
            </div>
        </div>


        <!-- Pertanyaan Umum Radio Button -->
        <div class="col-md-6 mb-3">
            <label for="pertanyaan_umum" class="form-label fw-bold">Pertanyaan Umum</label>
            <div>
                <div class="form-check">
                    <input type="radio" id="pertanyaan_umum_yes" name="pty_isgeneral" class="form-check-input" value="1" required>
                    <label class="form-check-label" for="pertanyaan_umum_yes">Ya</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="pertanyaan_umum_no" name="pty_isgeneral" class="form-check-input" value="0" required>
                    <label class="form-check-label" for="pertanyaan_umum_no">Tidak</label>
                </div>
            </div>
        </div>

        <!-- Pertanyaan Input -->
        <div class="col-md-12 mb-3">
            <label for="pertanyaan" class="form-label fw-bold">Pertanyaan <span style="color:red">*</span> </label>
            <input type="text" name="pty_pertanyaan" id="pertanyaan" class="form-control" placeholder="Masukkan Pertanyaan" required>
        </div>

       <!-- Kriteria Survei -->
        <div class="form-group mb-3">
            <label for="ksr_id" class="form-label fw-bold">Kriteria Survei <span style="color:red">*</span></label>
            <select name="ksr_id" id="ksr_id" class="form-control" required>
                <option value="" disabled selected>-- Pilih Kriteria Survei --</option>
                @foreach($kriteria_survei as $kriteria)
                    <option value="{{ $kriteria->ksr_id }}">{{ $kriteria->ksr_nama }}</option>
                @endforeach
            </select>
        </div>

        <!-- Skala Penilaian -->
        <div class="form-group mb-3">
            <label for="skp_id" class="form-label fw-bold">Skala Penilaian <span style="color:red">*</span></label>
            <select name="skp_id" id="skp_id" class="form-control" required>
                <option value="" disabled selected>-- Pilih Skala Penilaian --</option>
                @foreach($skala_penilaian as $skala)
                    <option value="{{ $skala->skp_id }}">{{ $skala->skp_deskripsi }}</option>
                @endforeach
            </select>
        </div>

       <!-- Tombol Kembali dan Simpan -->
        <div class="d-flex justify-content-between align-items-center">
            <div class="flex-grow-1 m-2">
                <a href="{{ route('Pertanyaan.save') }}">
                    <button class="btn btn-secondary" type="button" style="width:100%">Kembali</button>
                </a>
            </div>
            <div class="flex-grow-1 m-2">
                <button class="btn btn-primary" style="width:100%" type="submit">Simpan</button>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            const menuToggle = document.querySelector('.menu-toggle');
            const sidebar = document.getElementById('sidebar');

            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('hide');
                sidebar.classList.toggle('show');
            });

            // Menampilkan SweetAlert untuk pesan sukses setelah simpan
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('Pertanyaan.index') }}";
                    }
                });
            @endif

            // Konfirmasi hapus menggunakan SweetAlert
            const deleteButtons = document.querySelectorAll('.btn-danger');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    const form = button.closest('form');
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Data ini akan dihapus!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Submit form untuk menghapus data
                        }
                    });
                });
            });

            // Validasi Edit menggunakan SweetAlert
            const editForm = document.getElementById('editForm');
            if (editForm) {
                editForm.addEventListener('submit', function (event) {
                    const ksrNama = document.querySelector('input[name="ksr_nama"]').value;

                    if (!ksrNama.trim()) {
                        event.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Nama Kriteria harus diisi!',
                        });
                    }
                });
            }
        </script>  
        <script>
            
        document.addEventListener('DOMContentLoaded', function () {
            const pertanyaanUmumYes = document.getElementById('pertanyaan_umum_yes');
            const pertanyaanUmumNo = document.getElementById('pertanyaan_umum_no');
            const headerCheckbox = document.getElementById('headerYa');
            const kriteriaSurvei = document.getElementById('ksr_id');
            const skalaPenilaian = document.getElementById('skp_id');
            
            // Fungsi untuk mengatur pilihan radio button sesuai checkbox
            function syncRadioWithCheckbox() {
                // Jika Header dicentang, pilih "Yes", jika tidak, pilih "No"
                if (headerCheckbox.checked) {
                    pertanyaanUmumYes.checked = true;
                    pertanyaanUmumNo.checked = false;
                } else {
                    pertanyaanUmumYes.checked = false;
                    pertanyaanUmumNo.checked = true;
                }
            }

            // Fungsi untuk menonaktifkan/menonaktifkan dropdown Kriteria dan Skala
            function toggleFields() {
                if (pertanyaanUmumYes.checked) {
                    kriteriaSurvei.disabled = true;
                    skalaPenilaian.disabled = true;
                } else {
                    kriteriaSurvei.disabled = false;
                    skalaPenilaian.disabled = false;
                }
            }

            // Event listener untuk perubahan pada checkbox
            headerCheckbox.addEventListener('change', function () {
                syncRadioWithCheckbox();
                toggleFields(); // Update dropdown sesuai status radio button
            });

            // Event listener untuk perubahan pada radio button
            pertanyaanUmumYes.addEventListener('change', toggleFields);
            pertanyaanUmumNo.addEventListener('change', toggleFields);
        });
        </script>
</body>
</html>