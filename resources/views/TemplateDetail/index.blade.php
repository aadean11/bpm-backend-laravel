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
            <a href="../Survei/read">
                <li><i class="fas fa-list-alt"></i><span>Daftar Survei</span></li>
            </a>
        </ul>
        <!-- Tombol Logout -->
        <div class="logout">
            <a href="../logout"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
        </div>
    </div>

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
                    <li><i class="fas fa-list"></i> Kriteria Survei</li>
                </a>
                <a href="../SkalaPenilaian/index">
                    <li><i class="fas fa-sliders-h"></i> Skala Penilaian</li>
                </a>
                <a href="../PertanyaanSurvei/index">
                    <li><i class="fas fa-question-circle"></i> Pertanyaan</li>
                </a>
                <a href="../TemplateSurvei/index">
                    <li><i class="fas fa-file"></i> Template Survei</li>
                </a>
                <a href="../TemplateDetail/index">
                    <li><i class="fas fa-file"></i> TemplateDetail</li>
                </a>
                <a href="../Survei/index">
                    <li><i class="fas fa-poll"></i> Survei</li>
                </a>
                <a href="../DaftarSurvei/index">
                    <li><i class="fas fa-list-alt"></i> Daftar Survei</li>
                </a>
            </ul>
            <!-- Tombol Logout -->
            <div class="logout">
                <a href="../logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>

        <!-- Content -->
<div class="content mt-5">
    <div class="mb-3 border-bottom">
        <div class="page-nav-title">Template Detail Survei</div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Template Detail</li>
            </ol>
        </nav>
    </div>
    
    <div class="d-flex align-items-center mb-3">
        <button type="button" class="btn btn-primary me-2" onclick="location.href='{{ route('TemplateDetail.create') }}'">
            <i class="fas fa-plus"></i> Tambah Baru
        </button>
        <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#importModal">
            <i class="fas fa-upload"></i> Import Template
        </button>

        <!-- Modal Import Template -->
        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Template</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="importForm" method="POST" action="{{ route('TemplateDetail.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="importFile" class="form-label">Upload File</label>
                                <input type="file" class="form-control" id="importFile" name="import_file" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                        <hr>
                        <div class="mt-3">
                            <label>Silahkan unduh format template terlebih dahulu, <br />
                                <a href="{{ asset('storage/templates/Template_Kuesioner.xlsx') }}" 
                                   style="color: blue; text-decoration: underline;"
                                   target="_blank">
                                    Klik disini untuk mengunduh template
                                </a>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Export Template -->
        <form id="export-form" method="GET" action="{{ route('TemplateDetail.export') }}">
            <input type="hidden" name="search" value="{{ request('search') }}">
            <input type="hidden" name="tsd_status" value="{{ request('tsd_status') }}">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-download"></i> Export Template
            </button>
        </form>  
    </div>

    <form action="{{ route('TemplateDetail.index') }}" method="GET" id="searchFilterForm">
        <div class="row mb-4">
            <div class="col-md-10">
                <div class="input-group">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari data..." class="form-control">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <div class="dropdown ms-2">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <div class="dropdown-menu p-3" style="width: 250px;">
                            <h6 class="dropdown-header">Filter Status:</h6>
                            <select name="tsd_status" class="form-select mb-3">
                                <option value="">Pilih Status</option>
                                <option value="1" {{ request('tsd_status') == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ request('tsd_status') == '0' ? 'selected' : '' }}>Nonaktif</option>
                            </select>

                            <h6 class="dropdown-header">Urutkan Berdasarkan Tanggal:</h6>
                            <select name="tsd_created_date_order" class="form-select mb-3">
                                <option value="">Pilih Urutan</option>
                                <option value="asc" {{ request('tsd_created_date_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                <option value="desc" {{ request('tsd_created_date_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                            </select>

                            
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-sm me-2">Apply</button>
                                <a href="{{ route('TemplateDetail.index') }}" class="btn btn-secondary btn-sm">Reset</a>
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
                <th>Pertanyaan</th>
                <th>Header</th>
                <th>Jenis</th>
                <th>Status</th>
                <th>Tanggal Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($templateDetails as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->tsd_pertanyaan }}</td>
                <td>{{ $item->tsd_isheader == 1 ? 'Ya' : 'Tidak' }}</td>
                <td>{{ $item->tsd_jenis }}</td>
                <td>{{ $item->tsd_status == 1 ? 'Aktif' : 'Nonaktif' }}</td>
                <td>{{ $item->tsd_created_date }}</td>
                <td>
                    <a href="{{ route('TemplateDetail.edit', ['id' => $item->tsd_id]) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('TemplateDetail.delete', $item->tsd_id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm btn-delete">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                    <a href="{{ route('TemplateDetail.detail', ['id' => $item->tsd_id]) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye"></i> Detail
                    </a>    
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak Ada Data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $templateDetails->links() }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Menu toggle functionality
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebar = document.getElementById('sidebar');

    menuToggle?.addEventListener('click', () => {
        sidebar.classList.toggle('hide');
        sidebar.classList.toggle('show');
    });

    // Success message after save
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
        });
    @endif

    // Delete confirmation
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const form = this.closest('form');
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data ini akan dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
    </body>
</html>