
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
    
    <!-- Content -->
<div class="content mt-5">
    <div class="mb-3 border-bottom">
        <div class="page-nav-title">
            Tambah Pertanyaan Survei
        </div>

        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('Pertanyaan.index') }}">Pertanyaan Survei</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Pertanyaan Survei</li>
            </ol>
        </nav>
    </div>

    <div class="form-control">
        <h2 class="text-center mt-3">Tambah Pertanyaan Survei</h2>
        <form id="pertanyaan-form" action="{{ route('Pertanyaan.save') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="ksr_id">Kriteria Survei <span style="color:red">*</span></label>
                <select name="ksr_id" id="ksr_id" class="form-control @error('ksr_id') is-invalid @enderror" required>
                    <option value="" disabled selected>-- Pilih Kriteria Survei --</option>
                    @foreach($kriteria_survei->where('ksr_status', 1) as $kriteria)
                        <option value="{{ $kriteria->ksr_id }}">{{ $kriteria->ksr_nama }}</option>
                    @endforeach
                </select>
                @error('ksr_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="pty_pertanyaan">Pertanyaan <span style="color:red">*</span></label>
                <input type="text" name="pty_pertanyaan" id="pty_pertanyaan" class="form-control @error('pty_pertanyaan') is-invalid @enderror" 
                    required placeholder="Masukkan Pertanyaan">
                @error('pty_pertanyaan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="skp_id">Skala Penilaian <span style="color:red">*</span></label>
                <select name="skp_id" id="skp_id" class="form-control @error('skp_id') is-invalid @enderror" required>
                    <option value="" disabled selected>-- Pilih Skala Penilaian --</option>
                    @foreach($skala_penilaian as $skala)
                        <option value="{{ $skala['skp_id'] }}">{{ $skala['skp_deskripsi'] }}</option>
                    @endforeach
                </select>
                @error('skp_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="kry_id">Responden <span style="color:red">*</span></label>
                <select name="kry_id" id="kry_id" class="form-control @error('kry_id') is-invalid @enderror" required>
                    <option value="" disabled selected>-- Pilih Responden --</option>
                    @foreach($karyawan as $data)
                        <option value="{{ $data->kry_id }}">{{ $data->kry_role }}</option>
                    @endforeach
                </select>
                @error('kry_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 m-2">
                    <a href="{{ route('Pertanyaan.index') }}">
                        <button type="button" class="btn btn-secondary" style="width:100%">Kembali</button>
                    </a>
                </div>
                <div class="flex-grow-1 m-2">
                    <button type="submit" class="btn btn-primary" style="width:100%">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>



    
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
    
        // Konfirmasi sebelum submit form
        document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Simpan pertanyaan ini?',
                text: 'Pastikan data sudah benar sebelum menyimpan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });
        });


        
    </script>
    @if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Kesalahan Pertanyaan',
            text: '@foreach ($errors->all() as $error) {{ $error }} @endforeach',
        });
    </script>
@endif

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
        });
    </script>
@endif
<script>
    function validateMaxLength() {
        const maxLength = 255; // Batas maksimal karakter
        const inputField = document.getElementById('pty_pertanyaan');
        const charCount = inputField.value.length;

        if (charCount > maxLength) {
            Swal.fire({
                icon: 'error',
                title: 'Batas Karakter Terlampaui',
                text: `Maksimal karakter adalah ${maxLength}. Anda sudah memasukkan ${charCount} karakter.`,
            });

            // Batasi input agar tidak bisa lebih dari 255 karakter
            inputField.value = inputField.value.substring(0, maxLength);
        }
    }
</script>


</body>
</html>