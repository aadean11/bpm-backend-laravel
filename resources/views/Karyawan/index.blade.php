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
            /display: flex;/ Membuat ikon dan teks berjejer */ align-items: center;
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
            Data Karyawan
        </div>

        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Data Karyawan</li>
            </ol>
        </nav>
    </div>

    <div class="mb-3 mt-5">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-plus"></i> Tambah Karyawan
        </button>
    </div>

    <!-- Pencarian -->
    <form action="{{ route('Karyawan.index') }}" method="GET" id="searchFilterForm">
        <div class="row mb-4 col-20">
            <div class="col-md-10">
                <div class="input-group">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari Karyawan..."
                        class="form-control">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <div class="col-md-2">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle ms-2" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <div class="dropdown-menu p-3" style="width: 250px;">
                                <h6 class="dropdown-header">Filter Status:</h6>
                                <select name="kry_status_kary" class="form-select mb-3">
                                    <option value="">Semua Status</option>
                                    <option value="1" {{ request('kry_status_kary') == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ request('kry_status_kary') == '0' ? 'selected' : '' }}>Nonaktif</option>
                                </select>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-sm me-2">Apply</button>
                                    <a href="{{ route('Karyawan.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Tabel Karyawan -->
    <div class="col-12">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($karyawan as $index => $kry)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $kry->kry_username }}</td>
                        <td>{{ $kry->kry_nama_lengkap }}</td>
                        <td>{{ $kry->kry_email }}</td>
                        <td>{{ $kry->kry_role }}</td>
                        <td>{{ $kry->kry_status_kary == 1 ? 'Aktif' : 'Nonaktif' }}</td>
                        <td>
                            <a href="#" 
   class="btn btn-warning btn-edit" 
   data-bs-toggle="modal"
   data-bs-target="#editModal" 
   data-kry-id="{{ $kry->kry_id }}"
   data-kry-username="{{ $kry->kry_username }}"
   data-kry-nama="{{ $kry->kry_nama_lengkap }}"
   data-kry-email="{{ $kry->kry_email }}"
   data-kry-role="{{ $kry->kry_role }}">
   <i class="fas fa-edit"></i>
</a>

                            <!-- Form Delete -->
                            <form action="{{ route('Karyawan.delete', $kry->kry_id) }}" method="POST"
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
                        <td colspan="7" class="text-center">Tidak Ada Data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Paginasi -->
        <div class="d-flex justify-content-center">
            {{ $karyawan->links() }}
        </div>
    </div>

    <!-- Modal untuk Tambah Karyawan -->
    <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Karyawan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('Karyawan.save') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="kry_username">Username <span style="color:red">*</span></label>
                            <input type="text" name="kry_username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="kry_password">Password <span style="color:red">*</span></label>
                            <input type="password" name="kry_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="kry_nama_lengkap">Nama Lengkap <span style="color:red">*</span></label>
                            <input type="text" name="kry_nama_lengkap" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="kry_email">Email <span style="color:red">*</span></label>
                            <input type="email" name="kry_email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="kry_role">Role <span style="color:red">*</span></label>
                            <select name="kry_role" class="form-select" required>
                                <option value="">Pilih Role</option>
                                <option value="mitra">mitra</option>
                                <option value="dosen">dosen</option>
                                <option value="admin">admin</option>
                                <option value="instruktur">instruktur</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal untuk Edit Karyawan -->
<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
aria-labelledby="editModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg"> <!-- Tambahkan modal-lg di sini -->
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="editModalLabel">Edit Karyawan</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editForm" method="post" action="{{ route('Karyawan.update', ['id' => ':id']) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="kry_id" id="kry_id">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="kry_username">Username <span style="color:red">*</span></label>
                        <input type="text" name="kry_username" id="kry_username" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kry_nama_lengkap">Nama Lengkap <span style="color:red">*</span></label>
                        <input type="text" name="kry_nama_lengkap" id="kry_nama_lengkap" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kry_email">Email <span style="color:red">*</span></label>
                        <input type="email" name="kry_email" id="kry_email" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kry_role">Role <span style="color:red">*</span></label>
                        <select name="kry_role" id="kry_role" class="form-select" required>
                            <option value="">Pilih Role</option>
                            <option value="mitra">Mitra</option>
                            <option value="dosen">Dosen</option>
                            <option value="admin">Admin</option>
                            <option value="instruktur">Instruktur</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
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

        // Menampilkan SweetAlert untuk pesan sukses
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
                const form = button.closest('form');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Karyawan akan dinonaktifkan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Mengisi data edit modal
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.kryId;
                const username = this.dataset.kryUsername;
                const nama = this.dataset.kryNama;
                const email = this.dataset.kryEmail;
                const role = this.dataset.kryRole;

                const form = document.querySelector('#editForm');

                // Perbaiki action URL
                form.action = form.action.replace(':id', id);

                // Set nilai input form
                document.querySelector('#kry_id').value = id;
                document.querySelector('#kry_username').value = username;
                document.querySelector('#kry_nama_lengkap').value = nama;
                document.querySelector('#kry_email').value = email;
                document.querySelector('#kry_role').value = role;
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const sidebar = document.getElementById("sidebar");
            const menuToggle = document.querySelector(".menu-toggle");

            menuToggle.addEventListener("click", function () {
                sidebar.classList.toggle("hide");
            });

            // Event listener untuk tombol Edit di dalam modal
            document.querySelectorAll(".btn-edit").forEach(button => {
                button.addEventListener("click", function () {
                    document.getElementById("edit_kry_id").value = this.dataset.kryId;
                    document.getElementById("edit_kry_username").value = this.dataset.kryUsername;
                    document.getElementById("edit_kry_nama").value = this.dataset.kryNama;
                    document.getElementById("edit_kry_email").value = this.dataset.kryEmail;
                    document.getElementById("edit_kry_role").value = this.dataset.kryRole;
                });
            });
        });
    </script>

</body>

</html>
