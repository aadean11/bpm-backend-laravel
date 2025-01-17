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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


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
            /display: flex; / Membuat ikon dan teks berjejer */
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

<>
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
            <a href="/SkalaPenilaian/index">
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

     <!-- Content -->
    <div class="content mt-5">
        <div class="mb-3 border-bottom">
            <!-- PageNavTitle -->
            <div class="page-nav-title">
                Tambah Template Survei
            </div>

            <!-- Breadcrumbs -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('TemplateSurvei.index')}}">Template Survei</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Template Survei</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Tambah Template Survei</h2>
            </div>
            <div class="card-body">
                 
            <form action="{{ route('TemplateSurvei.save') }}" method="POST" >
                @csrf
                <div class="form-group mb-3">
                    <label for="tsu_nama">Nama Template <span style="color:red">*</span></label>
                    <input type="text" name="tsu_nama" id="tsu_nama" class="form-control" required placeholder="Masukkan Nama Template">
                </div>

                <div class="form-group mb-3">
                    <label for="ksr_id">Kriteria Survei <span style="color:red">*</span></label>
                    <select name="ksr_id" id="ksr_id" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Kriteria Survei --</option>
                        @foreach($kriteria_survei as $kriteria)
                            <option value="{{ $kriteria->ksr_id }}">{{ $kriteria->ksr_nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="skp_id">Skala Penilaian <span style="color:red">*</span></label>
                    <select name="skp_id" id="skp_id" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Skala Penilaian --</option>
                        @foreach($skala_penilaian as $skala)
                            <option value="{{ $skala->skp_id }}">{{ $skala->skp_deskripsi }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1 m-2">
                        <a href="{{ route('TemplateSurvei.index')}}">
                            <button class="btn btn-secondary" type="button" style="width:100%">Kembali</button>
                        </a>
                    </div>
                    <div class="flex-grow-1 m-2">
                        <button class="btn btn-primary" type="submit" style="width:100%" id="showPertanyaan">Tambah Template</button>
                    </div>
                </div>
            </form>
            </div>
        </div>

        <div class="card mt-5" id="pertanyaan" style="display: none">
            <div class="card-header">
                <h2>Tambah Pertanyaan</h2>
            </div>
            <div class="card-body">
                <body>
                    <div class="form-container">
                        <form action="{{ route('Pertanyaan.save') }}" method="POST">
                        @csrf
        
                         <!-- Flexbox untuk sejajarkan Header, Pertanyaan, dan Jenis Pertanyaan dalam satu baris -->
                    <div class="d-flex justify-content-between" style="margin-bottom: 20px;">
                        <div class="form-check form-check-inline" style="margin-bottom: 10px;">
                            <!-- Checkbox dengan label untuk memperjelas tampilannya -->
                            <input class="form-check-input" type="checkbox" id="headerYa" name="pty_isheader" value="1">
                            <label class="form-check-label" for="headerYa">Header?</label>
                        </div>
        
                        <div class="form-group" style="margin-bottom: 10px; flex: 1; margin-right: 10px;">
                            <label for="pertanyaan">Pertanyaan <span style="color: red">*</span></label>
                            <input type="text" name="pty_pertanyaan" id="pertanyaan" class="form-control" placeholder="Masukkan Pertanyaan" required>
                        </div>
        
                        <div class="form-group" style="margin-bottom: 10px; flex: 1;">
                            <label for="pertanyaanUmum">Jenis Pertanyaan <span style="color: red">*</span></label>
                            <select name="pty_jenispertanyaan" id="pertanyaanUmum" class="form-control" required>
                                <option value="">Pilih Jenis Pertanyaan</option>
                                <option value="pilihan_ganda">Pilihan Ganda</option>
                                <option value="pilihan_singkat">Pilihan Singkat</option>
                            </select>
                        </div>
                    </div>
        
                        <!-- Tombol tambah, import, export di atas tabel -->
                        <div class="d-flex justify-content-start mb-4">
                            <button type="button" class="btn btn-primary me-2">Tambah Pertanyaan</button>
                            <button type="button" class="btn btn-success me-2">Import Pertanyaan</button>
                            <button type="button" class="btn btn-success">Export Pertanyaan</button>
                        </div>
        
                        <!-- Tabel Daftar Pertanyaan -->
                        <div class="table-container">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th>No</th>
                                <th>Header</th>
                                <th>Pertanyaan</th>
                                <th>Jenis Pertanyaan</th>
                                <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Baris ini akan tampil ketika tidak ada data -->
                                <tr>
                                <td colspan="5" class="text-center">Tidak ada data</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
        
                        <!-- Tombol Simpan dan Batal -->
                         <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1 m-2">
                                <a href="{{ route('Pertanyaan.index')}}">
                                    <button class="btn btn-secondary" type="button" style="width:100%">Kembali</button>
                                </a>
                            </div>
                            <div class="flex-grow-1 m-2">
                                <button class="btn btn-primary" type="submit" style="width:100%" id="submit-button">Simpan</button>
                            </div>
                        </div>
                        </form>
                    </div>
                    </body>
            </div>
        </div>

        <!-- <div id="additional-fields-container" style="display:none;">
            <div class="form-group mb-3">
                <label for="additional-header">Header <span style="color:red">*</span></label>
                <input type="text" name="additional-header" id="additional-header" class="form-control" placeholder="Masukkan Header">
            </div>
            <div class="form-group mb-3">
                <label for="additional-dropdown">Dropdown <span style="color:red">*</span></label>
                <select name="additional-dropdown" class="form-control">
                    <option value="" disabled selected>-- Pilih Opsi --</option>
                    <option value="1">Opsi 1</option>
                    <option value="2">Opsi 2</option>
                    <option value="3">Opsi 3</option>
                </select>
            </div>
        </div> -->
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
                title: 'Berhasil',
                text: '{{ session('success') }}',
            });
        @endif

        // // Menonaktifkan inputan Nama Template, Kriteria Survei, dan Skala Penilaian serta menampilkan elemen tambahan setelah Simpan
        // document.getElementById('submit-button').addEventListener('click', function(event) {
        //     event.preventDefault(); // Mencegah form untuk submit langsung

        //     // Menonaktifkan inputan Nama Template, Kriteria Survei, dan Skala Penilaian
        //     document.getElementById('tsu_nama').disabled = true;  // Menonaktifkan Nama Template
        //     document.querySelector('select[name="ksr_id"]').disabled = true;
        //     document.querySelector('select[name="skp_id"]').disabled = true;

        //     // Menampilkan elemen tambahan (textfield dan dropdown)
        //     document.getElementById('additional-fields-container').style.display = 'block';

        //     // Anda bisa melanjutkan dengan submit form jika ingin
        //     // document.getElementById('survey-form').submit(); // Uncomment untuk submit
        // });


        
    </script>
    {{-- <script>
        // JavaScript untuk menampilkan div
        // const inputField = document.getElementById('tsu_nama');
        // const inputField = document.getElementById('skp_id');
        // const inputField = document.getElementById('ksr_id');
        const button = document.getElementById('showPertanyaan');
        const div = document.getElementById('pertanyaan');

        // inputField.addEventListener('input', () => {
        //     if (inputField.value.trim() !== '') {
        //         inputField.disabled = false; // Aktifkan tombol
        //     } else {
        //         inputField.disabled = true; // Nonaktifkan tombol
        //     }
        // });

        button.addEventListener('click', () => {
            div.style.display = 'block'; // Menampilkan div
        });
    </script> --}}
    <script>
console.log(document.getElementById("tsu_nama").value);
console.log(document.getElementById("ksr_id").value);
console.log(document.getElementById("skp_id").value);

        // Mendapatkan elemen-elemen yang dibutuhkan
const templateNameInput = document.getElementById('tsu_nama');
const criteriaSelect = document.getElementById('ksr_id');
const scaleSelect = document.getElementById('skp_id');
const showPertanyaanButton = document.getElementById('showPertanyaan');
const pertanyaanDiv = document.getElementById('pertanyaan');

// Tambahkan event listener pada tombol "Tambah Template"
showPertanyaanButton.addEventListener('click', (e) => {
    e.preventDefault(); // Mencegah form untuk submit langsung

    // Validasi jika inputan kosong
    if (!templateNameInput.value.trim()) {
        alert('Nama Template harus diisi!');
        return;
    }
    if (!criteriaSelect.value) {
        alert('Pilih Kriteria Survei!');
        return;
    }
    if (!scaleSelect.value) {
        alert('Pilih Skala Penilaian!');
        return;
    }

    // Menampilkan div "Tambah Pertanyaan"
    pertanyaanDiv.style.display = 'block';

    // Nonaktifkan inputan setelah klik
    templateNameInput.readOnly = true;
    criteriaSelect.disabled = true;
    scaleSelect.disabled = true;

    // Nonaktifkan tombol "Tambah Template"
    showPertanyaanButton.disabled = true;
});

    </script>

</body>

</html>
