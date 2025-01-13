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
    <!-- Page Navigation Title -->
    <div class="mb-3 border-bottom">
        <div class="page-nav-title">Skala Penilaian</div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Skala Penilaian</li>
            </ol>
        </nav>
    </div>

    <!-- Button Tambah Baru -->
    <div class="mb-3 mt-5">
        <a href="{{ route('SkalaPenilaian.add') }}">
            <button type="button" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Baru
            </button>
        </a>
    </div>

    <!-- Form Pencarian dan Filter -->
    <form action="{{ route('SkalaPenilaian.index') }}" method="GET" id="searchFilterForm">
        <div class="row mb-4">
            <div class="col-md-10">
                <div class="input-group">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari data..." class="form-control">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <!-- Filter Dropdown -->
                    <div class="dropdown ms-2">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <div class="dropdown-menu p-3" style="width: 250px;">
                            <h6 class="dropdown-header">Filter Tipe Skala:</h6>
                            <select name="skp_tipe" class="form-select mb-3">
                                <option value="">Pilih Tipe Skala</option>
                                @foreach ($tipe_options as $tipe)
                                    <option value="{{ $tipe }}" {{ request('skp_tipe') == $tipe ? 'selected' : '' }}>{{ $tipe }}</option>
                                @endforeach
                            </select>
                            <h6 class="dropdown-header">Filter Status:</h6>
                            <select name="skp_status" class="form-select mb-3">
                                <option value="">Pilih Status</option>
                                <option value="1" {{ request('skp_status') == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ request('skp_status') == '0' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-sm me-2">Apply</button>
                                <a href="{{ route('SkalaPenilaian.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Tabel Data -->
    <div class="col-12">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Skala</th>
                    <th>Deskripsi</th>
                    <th>Tipe</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($skala_penilaian as $index => $skala)
                    <tr>
                        <td>{{ $skala_penilaian->firstItem() + $index }}</td>
                        <td>{{ $skala->skp_skala }}</td>
                        <td>{{ $skala->skp_deskripsi }}</td>
                        <td>{{ $skala->skp_tipe }}</td>
                        <td>
                            <!-- Tombol Detail -->
                            <form action="{{ route('SkalaPenilaian.detail', $skala->skp_id) }}" method="GET" style="display:inline-block;">
                                <button type="submit" class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </form>
                            <!-- Tombol Edit -->
                            @if ($skala->skp_status == 1)
        <form action="{{ route('SkalaPenilaian.edit', $skala->skp_id) }}" method="GET" style="display:inline-block;">
            <button type="submit" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Edit">
                <i class="fas fa-edit"></i>
            </button>
        </form>
    @endif
                           <!-- Toggle Switch -->
<div class="form-check form-switch d-inline-block align-middle ms-1">
    <input 
        class="form-check-input toggle-status" 
        type="checkbox" 
        role="switch" 
        id="toggle{{ $skala->skp_id }}"
        data-id="{{ $skala->skp_id }}"
        {{ $skala->skp_status ? 'checked' : '' }}
    >
</div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak Ada Data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        
        <!-- Pagination -->
<div class="d-flex justify-content-center">
    {{ $skala_penilaian->links('pagination::bootstrap-4') }}
</div>

    </div>
</div>

<!-- SweetAlert Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // SweetAlert untuk tombol delete
    // const deleteButtons = document.querySelectorAll('.delete-button');
    // deleteButtons.forEach(button => {
    //     button.addEventListener('click', function (event) {
    //         const form = button.closest('form'); // Ambil form terkait
    //         Swal.fire({
    //             title: 'Apakah Anda yakin?',
    //             text: 'Data ini akan dihapus!',
    //             icon: 'warning',
    //             showCancelButton: true,
    //             confirmButtonText: 'Hapus',
    //             cancelButtonText: 'Batal'
    //         }).then((result) => {
    //             if (result.isConfirmed) {
    //                 form.submit(); // Lanjutkan penghapusan jika dikonfirmasi
    //             }
    //         });
    //     });
    // });


    document.addEventListener('DOMContentLoaded', function() {
    const toggles = document.querySelectorAll('.toggle-status');
    
    toggles.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const id = this.dataset.id;
            const newStatus = this.checked;
            const row = this.closest('tr');
            const statusFilter = document.querySelector('select[name="skp_status"]').value;
            
            Swal.fire({
                title: `${newStatus ? 'Aktifkan' : 'Nonaktifkan'} data?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/SkalaPenilaian/toggle/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            // Cek apakah perlu menghilangkan row berdasarkan filter dan status baru
                            const shouldHideRow = (
                                (statusFilter === '1' && !newStatus) || // Filter aktif, dinonaktifkan
                                (statusFilter === '0' && newStatus) ||  // Filter nonaktif, diaktifkan
                                (!newStatus)  // Selalu sembunyikan jika dinonaktifkan
                            );

                            if (shouldHideRow) {
                                row.style.transition = 'opacity 0.3s';
                                row.style.opacity = '0';
                                setTimeout(() => {
                                    row.remove();
                                    updateRowNumbers();
                                }, 300);
                            }

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Status berhasil diubah',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    })
                    .catch(() => {
                        this.checked = !this.checked;
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan'
                        });
                    });
                } else {
                    this.checked = !this.checked;
                }
            });
        });
    });

    // Fungsi untuk update nomor urut
    function updateRowNumbers() {
        const rows = document.querySelectorAll('table tbody tr');
        rows.forEach((row, index) => {
            const numberCell = row.querySelector('td:first-child');
            if (numberCell) {
                const firstItemNumber = parseInt(document.querySelector('table tbody tr td:first-child').textContent);
                numberCell.textContent = firstItemNumber + index;
            }
        });
    }
});

    // SweetAlert untuk pesan sukses
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
        });
    @endif
</script>

    </div>
</body>
</html>