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
                <div class="page-nav-title">Pertanyaan Survei</div>
        
                <!-- Breadcrumbs -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Pertanyaan Survei</li>
                    </ol>
                </nav>
            </div>
        
            <div class="d-flex align-items-center mb-3">
                <!-- Tombol Tambah Baru -->
                <a href="{{ route('Pertanyaan.create') }}" class="btn btn-primary me-2">
                    <i class="fas fa-plus"></i> Tambah Baru
                </a>
        
                <!-- Form Ekspor Pertanyaan -->
                <form method="GET" action="{{ route('pertanyaan.export') }}">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-download"></i> Ekspor Pertanyaan
                    </button>
                </form>  
            </div>
        
            <!-- Form Pencarian -->
<form action="{{ route('Pertanyaan.index') }}" method="GET">
    <div class="row mb-4">
        <div class="col-md-20">
            <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pertanyaan..." class="form-control">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Cari
                </button>

                

                <!-- Filter Dropdown -->
                <div class="dropdown ms-2">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <div class="dropdown-menu p-3" style="width: 250px;">
                        <h6 class="dropdown-header">Filter Status:</h6>
                        <select name="pty_status" class="form-select mb-3">
                            <option value="">Semua</option>
                            <option value="all" {{ request('pty_status') == 'all' ? 'selected' : '' }}>Semua Data</option>
                            <option value="1" {{ request('pty_status') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ request('pty_status') == '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>

                        <h6 class="dropdown-header">Urutkan Tanggal:</h6>
                        <select name="pty_created_date_order" class="form-select mb-3">
                            <option value="">Pilih Urutan</option>
                            <option value="asc" {{ request('pty_created_date_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                            <option value="desc" {{ request('pty_created_date_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                        </select>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-sm me-2">Apply</button>
                            <a href="{{ route('Pertanyaan.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

            
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th style="width: 800px;">Pertanyaan</th>
                        <th>Kriteria Survei</th>
                        <th>Skala Penilaian</th>
                        {{-- <th>Karyawan</th> --}}
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pertanyaan as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ e($item->pty_pertanyaan) }}</td>
                            <td>{{ optional($item->kriteria)->ksr_nama ?? 'Data Tidak Ditemukan' }}</td>
                            <td>
                                @if ($item->skala)
                                    {{ $item->skala->skp_skala }} ({{ $item->skala->skp_deskripsi }})
                                @else
                                    Data Tidak Ditemukan
                                @endif
                            </td>
                            {{-- <td>
                                @php
                                    $detail = optional($item->detailBankPertanyaan->first());
                                @endphp
                                {{ optional($detail->karyawan)->kry_nama_lengkap ?? 'Tidak Ada Karyawan' }}
                            </td> --}}
                            <td>
                                <a href="{{ route('Pertanyaan.edit', ['id' => $item->pty_id]) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> 
                                </a>
                                <form action="{{ route('Pertanyaan.delete', $item->pty_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> 
                                    </button>
                                </form>
                                <a href="{{ route('Pertanyaan.detail', ['id' => $item->pty_id]) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> 
                                </a>    
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Tidak Ada Data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <nav>
                {{ $pertanyaan->links('pagination::bootstrap-4') }}
            </nav>


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
            // Menampilkan SweetAlert untuk pesan sukses
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                });
            @endif

            // Menampilkan SweetAlert untuk pesan error jika validasi gagal
            @if($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ $errors->first() }}',
                });
            @endif
        </script>
