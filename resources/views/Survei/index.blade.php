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

    <div class="sidebar border-end" id="sidebar">
        <ul>
        <a href="../index"> <li><i class="fas fa-home"></i>  Dashboard</li></a>
            <a href="../KriteriaSurvei/index"><li><i class="fas fa-list"></i><span>  Kriteria Survei</span></li></a>
            <a href="../SkalaPenilaian/index"><li><i class="fas fa-sliders-h"></i><span>  Skala Penilaian</span></li></a>
            <a href="../PertanyaanSurvei/index"><li><i class="fas fa-question-circle"></i><span>  Pertanyaan</span></li></a>
            <a href="../TemplateSurvei/index"><li><i class="fas fa-file"></i><span>  Template Survei</span></li></a>
            <a href="../Survei/index"><li><i class="fas fa-poll"></i><span>  Survei</span></li></a>
            <a href="../DaftarSurvei/index"> <li><i class="fas fa-list-alt"></i><span>Daftar Survei</span></li></a>
            <a href="../Karyawan/index"><li><i class="fas fa-file"></i><span>Karyawan</span></li></a>
        </ul>
        <!-- Tombol Logout -->
        <div class="logout">
            <a href="../logout"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
        </div>
    </div>

    <   <!-- Content -->
    <div class="content mt-5">
        <div class="mb-3 border-bottom">
            <div class="page-nav-title">Survei</div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Survei</li>
                </ol>
            </nav>
        </div>
        
        <div class="d-flex align-items-center mb-3">
            <button type="button" class="btn btn-primary me-2" onclick="location.href='{{ route('Survei.add') }}'">
                <i class="fas fa-plus"></i> Tambah Baru
            </button>      
        </div>
    
        <form action="{{ route('Survei.index') }}" method="GET" id="searchFilterForm">
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama karyawan atau template..." class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="tsu_id" class="form-select">
                        <option value="">Semua Template</option>
                        @foreach($template_options as $template)
                            <option value="{{ $template->tsu_id }}" {{ request('tsu_id') == $template->tsu_id ? 'selected' : '' }}>
                                {{ $template->tsu_nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="trs_status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('trs_status') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ request('trs_status') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </div>
        </form>
    
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Template Survei</th>
                    <th>Nama Karyawan</th>
                    <th>Status</th>
                    <th>Dibuat Oleh</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($survei_list as $index => $item)
                <tr>
                    <td>{{ $index + $survei_list->firstItem() }}</td>
                    <td>{{ $item->templateSurvei->tsu_nama }}</td>
                    <td>{{ $item->karyawan->nama_lengkap }}</td>
                    <td>
                        <span class="badge {{ $item->trs_status ? 'bg-success' : 'bg-danger' }}">
                            {{ $item->trs_status ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td>{{ $item->trs_created_by }}</td>
                    <td>{{ $item->trs_created_date }}</td>
                    <td>
                        <a href="{{ route('Survei.detail', ['id' => $item->trs_id]) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('Survei.edit', ['id' => $item->trs_id]) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-danger btn-sm btn-toggle-status" data-id="{{ $item->trs_id }}">
                            <i class="fas fa-power-off"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak Ada Data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <nav>
            {{ $survei_list->links('pagination::bootstrap-4') }}
        </nav>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Success message after save
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
            });
        @endif
    
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
            });
        @endif
    
        // Toggle status
        document.querySelectorAll('.btn-toggle-status').forEach(button => {
            button.addEventListener('click', function() {
                const surveiId = this.dataset.id;
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Status survei ini akan diubah!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`{{ url('survei/toggle-status') }}/${surveiId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Status berhasil diubah',
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat mengubah status',
                            });
                        });
                    }
                });
            });
        });
    
        // Auto-submit form when filters change
        document.querySelectorAll('select[name="tsu_id"], select[name="trs_status"]').forEach(select => {
            select.addEventListener('change', () => {
                document.getElementById('searchFilterForm').submit();
            });
        });
    </script>
        </body>
    </html>
    