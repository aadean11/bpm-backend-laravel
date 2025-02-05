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

    <!-- Content -->
    <div class="content mt-5">
        <div class="mb-3 border-bottom"> <!-- PageNavTitle -->
            <div class="page-nav-title">
                Template Survei
            </div>

            <!-- Breadcrumbs -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Template Survei</li>
                </ol>
            </nav>
        </div>

        <div class="mb-3 mt-5">
            <a href="{{ route('TemplateSurvei.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah
                Template</a>
        </div>
        <!-- Form Pencarian dan Filter -->
        <form action="{{ route('TemplateSurvei.index') }}" method="GET" id="searchFilterForm">
            <div class="row mb-4">
                <div class="col-md-20">
                    <div class="input-group">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari data..."
                            class="form-control">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        <!-- Filter Dropdown -->
                        <div class="dropdown ms-2">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <div class="dropdown-menu p-3" style="width: 250px;">
                                <h6 class="dropdown-header">Filter Status:</h6>
                                <select name="tsu_status" class="form-select mb-3">
                                    <option value="">Pilih Status</option>
                                    <option value="2" {{ request('tsu_status') == '2' ? 'selected' : '' }}>Tidak Aktif
                                    </option>
                                    <option value="1" {{ request('tsu_status') == '1' ? 'selected' : '' }}>Final</option>
                                    <option value="0" {{ request('tsu_status') == '0' ? 'selected' : '' }}>Draft</option>
                                    </option>
                                </select>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-sm me-2">Apply</button>
                                    <a href="{{ route('TemplateSurvei.index') }}"
                                        class="btn btn-secondary btn-sm">Reset</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Tabel Template Survei -->
        <div class="col-12">
            <table id="templateSurveiTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Template</th>
                        <th style="width: 800px;">Pertanyaan</th>
                        <th>Status</th>
                        <th>Tanggal Final</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($template_survei as $index => $template)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td hidden>{{ $template->tsu_id }}</td>
                            <td>{{ $template->tsu_nama }}</td>
                            <td>{{ $template->pertanyaan->pty_pertanyaan ?? 'Tidak ada pertanyaan' }}</td>

                            <td>
                                @if ($template->tsu_status == 0)
                                    Draft
                                @else
                                    Final
                                @endif
                            </td>
                            <td>{{ $template->tsu_modif_date }}</td>
                            <td>
                                @if ($template->tsu_status == 0)
                                    <!-- Tombol Detail -->
                                    <form action="{{ route('TemplateSurvei.detail', $template->tsu_id) }}" method="GET"
                                        style="display:inline-block;">
                                        <button type="submit" class="btn btn-info btn-sm" data-bs-toggle="tooltip"
                                            title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </form>
                                    <!-- Tombol Edit -->
                                    <form action="{{ route('TemplateSurvei.edit', $template->tsu_id) }}" method="GET"
                                        style="display:inline-block;">
                                        <button type="submit" class="btn btn-warning btn-sm" data-bs-toggle="tooltip"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </form>
                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('TemplateSurvei.delete', $template->tsu_id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                                            title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <!-- Tombol Final -->
                                    <form action="{{ route('TemplateSurvei.final', $template->tsu_id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-primary btn-sm" data-bs-toggle="tooltip"
                                            title="Finalisasi">
                                            <i class="fas fa-flag"></i>
                                        </button>
                                    </form>
                                @else
                                    <!-- Tombol Detail untuk Status Final -->
                                    <form action="{{ route('TemplateSurvei.detail', $template->tsu_id) }}" method="GET"
                                        style="display:inline-block;">
                                        <button type="submit" class="btn btn-info btn-sm" data-bs-toggle="tooltip"
                                            title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </form>
                                    <!-- Tombol Toggle (Hapus untuk Status Final) -->
                                    <form action="{{ route('TemplateSurvei.delete', $template->tsu_id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-primary btn-sm" data-bs-toggle="tooltip"
                                            title="Nonaktifkan">
                                            <i class="fas fa-toggle-on"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak Ada Data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Paginasi -->
            <nav>
                {{ $template_survei->links('pagination::bootstrap-4') }}
            </nav>
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
                title: 'Berhasil',
                text: '{{ session('success') }}',
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

        // SweetAlert untuk tombol Finalkan
        document.querySelectorAll('.btn-finalize').forEach(function (button) {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                Swal.fire({
                    title: 'Finalkan Template?',
                    text: "Template akan diubah menjadi final dan tidak dapat diedit!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, finalkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirim form finalisasi
                        const form = document.createElement('form');
                        form.action = "{{ route('TemplateSurvei.final', '') }}/" + id;
                        form.method = 'POST';

                        // Menambahkan CSRF token dan method PUT secara manual
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = csrfToken;
                        form.appendChild(csrfInput);

                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'PUT';
                        form.appendChild(methodInput);

                        document.body.appendChild(form);
                        form.submit();
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

        // Fungsi untuk pencarian template
        function searchTemplateSurvei() {
            // Ambil nilai dari input pencarian
            let input = document.getElementById('searchInput').value.toLowerCase();
            // Ambil tabel dan baris data
            let table = document.querySelector('table');
            let rows = table.getElementsByTagName('tr');
            let foundData = false; // Variabel untuk memeriksa apakah ada data yang ditemukan

            // Loop untuk memeriksa setiap baris tabel (selain header)
            for (let i = 1; i < rows.length; i++) {
                let cells = rows[i].getElementsByTagName('td');
                let found = false;

                // Loop untuk memeriksa setiap kolom dalam baris
                for (let j = 1; j < cells.length; j++) { // Mulai dari 1 untuk menghindari No
                    let cell = cells[j];
                    if (cell) {
                        // Cek apakah nilai cell mengandung teks pencarian
                        if (cell.innerHTML.toLowerCase().indexOf(input) > -1) {
                            found = true;
                            break; // Jika ditemukan, hentikan pencarian di baris ini
                        }
                    }
                }

                // Tampilkan atau sembunyikan baris berdasarkan pencocokan
                if (found) {
                    rows[i].style.display = '';  // Tampilkan baris
                    foundData = true; // Menandakan bahwa ada data yang ditemukan
                } else {
                    rows[i].style.display = 'none';  // Sembunyikan baris
                }
            }

            // Jika input kosong, tampilkan semua baris
            if (input === '') {
                for (let i = 1; i < rows.length; i++) {
                    rows[i].style.display = '';  // Tampilkan semua data
                }
                foundData = true; // Setiap data ditampilkan lagi
            }

            // Menampilkan pesan "Tidak Ada Data" jika tidak ada data yang ditemukan
            let noDataRow = document.getElementById('noDataRow');
            if (!foundData) {
                // Cek jika sudah ada baris 'Tidak Ada Data'
                if (!noDataRow) {
                    let emptyRow = table.insertRow(); // Tambahkan baris kosong
                    emptyRow.id = 'noDataRow';
                    let cell = emptyRow.insertCell(0);
                    cell.colSpan = table.rows[0].cells.length; // Setel jumlah kolom untuk baris ini
                    cell.classList.add('text-center');
                    cell.textContent = 'Tidak Ada Data'; // Pesan jika tidak ada data
                }
            } else {
                // Hapus baris 'Tidak Ada Data' jika ada data yang ditemukan
                if (noDataRow) {
                    noDataRow.remove();
                }
            }
        }

        // Fungsi untuk menerapkan filter berdasarkan pilihan dropdown
        function applyFilter() {
            let selectedFilter = document.getElementById('filterOptions').value;

            // Terapkan filter berdasarkan pilihan
            switch (selectedFilter) {
                case 'status-draft':
                    filterByStatus(0); // Draft
                    break;
                case 'status-final':
                    filterByStatus(1); // Final
                    break;
                case 'sort-asc':
                    sortTemplateSurvei('asc'); // Ascending
                    break;
                case 'sort-desc':
                    sortTemplateSurvei('desc'); // Descending
                    break;
                default:
                    resetFilters(); // Reset filter jika tidak ada yang dipilih
            }
        }

        // Fungsi untuk filter berdasarkan status
        function filterByStatus(status) {
            let table = document.getElementById('templateSurveiTable');
            let rows = table.getElementsByTagName('tr');
            for (let i = 1; i < rows.length; i++) {
                let statusCell = rows[i].getElementsByTagName('td')[2];
                if (statusCell) {
                    let statusText = statusCell.textContent.trim();
                    if ((status === 0 && statusText === 'Draft') || (status === 1 && statusText === 'Final')) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }
        }

        // Fungsi untuk sortir berdasarkan nama template
        function sortTemplateSurvei(order) {
            let table = document.getElementById('templateSurveiTable');
            let rows = Array.from(table.getElementsByTagName('tr')).slice(1);

            rows.sort((rowA, rowB) => {
                let nameA = rowA.getElementsByTagName('td')[1].textContent.trim();
                let nameB = rowB.getElementsByTagName('td')[1].textContent.trim();
                return order === 'asc' ? nameA.localeCompare(nameB) : nameB.localeCompare(nameA);
            });

            // Menambahkan kembali baris yang telah diurutkan
            for (let row of rows) {
                table.appendChild(row);
            }
        }

        // Fungsi untuk mereset semua filter
        function resetFilters() {
            let table = document.getElementById('templateSurveiTable');
            let rows = table.getElementsByTagName('tr');
            for (let i = 1; i < rows.length; i++) {
                rows[i].style.display = '';  // Menampilkan semua baris
            }
        }
    </script>

</body>

</html>