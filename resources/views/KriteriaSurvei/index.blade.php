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

        /* Tambahkan di bagian CSS */
        .pagination {
            margin: 20px 0;
        }

        .page-item .page-link {
            color: #2654A1;
            border: 1px solid #dee2e6;
        }

        .page-item.active .page-link {
            background-color: #2654A1;
            border-color: #2654A1;
            color: white;
        }

        .page-item.disabled .page-link {
            color: #6c757d;
        }

        .page-link:hover {
            background-color: #e9ecef;
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
        <div class="mb-3 border-bottom"> <!-- PageNavTitle -->
            <div class="page-nav-title">
                Kriteria Survei
            </div>

            <!-- Breadcrumbs -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Kriteria Survei</li>
                </ol>
            </nav>
        </div>

        <div class="mb-3 mt-5">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i
                    class="fas fa-plus"></i> Tambah Baru</button>
        </div>
      <!-- Pencarian -->
      <form action="{{ route('KriteriaSurvei.index') }}" method="GET" id="searchFilterForm">
        <div class="row mb-4 col-md-20">
            <div class="col-md-20">
                <div class="input-group">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari Kriteria Survei..."
                        class="form-control">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <div class="col-md-20">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle ms-2" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <div class="dropdown-menu p-3" style="width: 250px;">
                                <h6 class="dropdown-header">Filter Status:</h6>
                                <select name="ksr_status" class="form-select mb-3">
                                    <option value="" disabled>-- Pilih Status --</option>
                                    <option value="all" {{ request('ksr_status') == 'all' ? 'selected' : '' }}>Semua Data</option>
                                    <option value="1" {{ request('ksr_status') == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ request('ksr_status') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
    
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-sm me-2">Apply</button>
                                    <a href="{{ route('KriteriaSurvei.index') }}"
                                        class="btn btn-secondary btn-sm">Reset</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

        <!-- Tabel Kriteria Survei -->
        <div class="col-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kriteria</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kriteria_survei as $index => $kriteria)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td hidden>{{ $kriteria->ksr_id }}</td>
                            <td>{{ $kriteria->ksr_nama }}</td>
                            <td>
                                 <!-- Tombol Detail -->
                                <form action="{{ route('KriteriaSurvei.detail', $kriteria->ksr_id) }}" method="GET" style="display:inline-block;">
                                    <button type="submit" class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </form>

                                <!-- Tombol Edit -->
                                <a href="#" class="btn btn-warning btn-edit" data-bs-toggle="modal" 
                                data-bs-target="#editModal" data-ksr-id="{{ $kriteria->ksr_id }}"
                                data-ksr-nama="{{ $kriteria->ksr_nama }}">
                                <i class="fas fa-edit"></i>
                                </a>
                                
                                <!-- Modal untuk Edit Kriteria -->
                                <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Kriteria</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('KriteriaSurvei.update', $kriteria->ksr_id) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div>
                                                        <input type="hidden" name="ksr_id" id="ksr_id" value="{{ $kriteria->ksr_id }}"
                                                            placeholder="Masukkan Nama Kriteria" class="form-control" required>
                                                        <label for="ksr_nama">Nama Kriteria<span style="color:red">*</span></label>
                                                        <input type="text" name="ksr_nama" id="ksr_nama" value="{{ $kriteria->ksr_nama }}"
                                                            placeholder="Masukkan Nama Kriteria" class="form-control" required>
                                                    </div>
                                                    <!-- Tambahkan field lain sesuai dengan yang dibutuhkan -->
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Delete -->
                                <form action="{{ route('KriteriaSurvei.delete', $kriteria->ksr_id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Tidak Ada Data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Paginasi -->
            <nav>
                {{ $kriteria_survei->links('pagination::bootstrap-4') }}
            </nav>
        </div>

        <!-- Modal untuk Tambah Kriteria -->
        <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Kriteria</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('KriteriaSurvei.save') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div>
                                <label for="ksr_nama">Nama Kriteria <span style="color:red">*</span></label>
                                <input type="text" name="ksr_nama" placeholder="Masukkan Nama Kriteria"
                                    class="form-control" required>
                            </div>
                            <!-- Tambahkan field lain sesuai dengan yang dibutuhkan -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="text-center px-3">
                                <h5 class="mb-0">Data Aktif</h5>
                                <p class="h4 text-primary mb-0">{{ $totalAktif }}</p>
                            </div>
                            <div class="border-start"></div>
                            <div class="text-center px-3">
                                <h5 class="mb-0">Data Nonaktif</h5>
                                <p class="h4 text-danger mb-0">{{ $totalNonaktif }}</p>
                            </div>
                            <div class="border-start"></div>
                            <div class="text-center px-3">
                                <h5 class="mb-0">Total Data</h5>
                                <p class="h4 text-success mb-0">{{ $totalKeseluruhan }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tampilkan alert jika ada session success
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                });
            @endif

            // Konfirmasi hapus menggunakan SweetAlert
            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    const form = button.closest('form'); // Ambil form terdekat dari tombol delete
                    
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Data ini akan dihapus!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Submit form jika konfirmasi diterima
                        }
                    });
                });
            });
        });
    </script>

        <script>
            // Add this script after your existing script
            document.addEventListener('DOMContentLoaded', function() {
                // Function to validate input length
                function validateInputLength(input, maxLength = 50) {
                    if (input.value.length > maxLength) {
                        input.value = input.value.substring(0, maxLength);
                        Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan',
                            text: `Input tidak boleh lebih dari ${maxLength} karakter!`
                        });
                        return false;
                    }
                    return true;
                }

    // Function to check for special characters
    function containsSpecialChars(str) {
        const specialChars = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
        return specialChars.test(str);
    }

    // Function to validate input on real-time
    function validateInput(input) {
        const value = input.value.trim();
        
        // Check for empty value
        if (!value) {
            return {
                isValid: false,
                message: 'Nama Kriteria harus diisi!'
            };
        }

        // Check for length
        if (value.length > 50) {
            return {
                isValid: false,
                message: 'Nama Kriteria tidak boleh lebih dari 50 karakter!'
            };
        }

        // Check for special characters
        if (containsSpecialChars(value)) {
            return {
                isValid: false,
                message: 'Nama Kriteria tidak boleh mengandung karakter khusus!'
            };
        }

        // Check for numeric only input
        if (/^\d+$/.test(value)) {
            return {
                isValid: false,
                message: 'Nama Kriteria tidak boleh hanya berisi angka!'
            };
        }

        return { isValid: true };
    }

    // Add validation for Add Modal
    const addModal = document.getElementById('addModal');
    if (addModal) {
        const addForm = addModal.querySelector('form');
        const addInput = addModal.querySelector('input[name="ksr_nama"]');

        addInput.addEventListener('input', function() {
            validateInputLength(this);
        });

        addForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const validation = validateInput(addInput);
            
            if (!validation.isValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Duplikasi Data',
                    text: validation.message
                });
                return;
            }

            // Check for duplicate value
            const existingNames = Array.from(document.querySelectorAll('table tbody tr td:nth-child(3)'))
                .map(td => td.textContent.trim().toLowerCase());
            
            if (existingNames.includes(addInput.value.trim().toLowerCase())) {
                Swal.fire({
                    icon: 'error',
                    title: 'Duplikasi Data',
                    text: 'Nama Kriteria sudah ada!'
                });
                return;
            }

            this.submit();
        });
    }

    // Add validation for Edit Modal
    const editModal = document.getElementById('editModal');
    if (editModal) {
        const editForm = editModal.querySelector('form');
        const editInput = editModal.querySelector('input[name="ksr_nama"]');
        let originalValue = '';

        // Store original value when modal opens
        editModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            originalValue = button.dataset.ksrNama;
            editInput.value = originalValue;
        });

        editInput.addEventListener('input', function() {
            validateInputLength(this);
        });

        editForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const validation = validateInput(editInput);
            
            if (!validation.isValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: validation.message
                });
                return;
            }

            // Only check for duplicates if the value has changed
            if (editInput.value.trim().toLowerCase() !== originalValue.toLowerCase()) {
                const existingNames = Array.from(document.querySelectorAll('table tbody tr td:nth-child(3)'))
                    .map(td => td.textContent.trim().toLowerCase());
                
                if (existingNames.includes(editInput.value.trim().toLowerCase())) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal',
                        text: 'Nama Kriteria sudah ada!'
                    });
                    return;
                }
            }

            this.submit();
        });
    }
});
        </script>
</body>

</html>