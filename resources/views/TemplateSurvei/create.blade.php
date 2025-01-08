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
        <div class="mb-3 border-bottom"> <!-- PageNavTitle -->
            <div class="page-nav-title">
                Tambah Template Survei
            </div>

            <!-- Breadcrumbs -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('TemplateSurvei.index')}}">Template Survei</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> Tambah Template Survei</li>
                </ol>
            </nav>
        </div>

        <div class="form-control">
            <h2 class="text-center mt-3">Tambah Template Survei</h2>
            <form id="form-template" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="tsu_nama">Nama Template <span style="color:red">*</span></label>
                    <input type="text" name="tsu_nama" id="tsu_nama" class="form-control" required
                        placeholder="Masukkan Nama Template">
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

                <div class="d-flex justify-content-between">
                    <button type="button" id="cancel-template" class="btn btn-secondary">Batal</button>
                    <button type="button" id="save-template" class="btn btn-primary">Simpan Template</button>
                </div>
            </form>
        </div>

        <div id="form-pertanyaan" class="mt-5" style="display: none;">
            <h3 class="text-center">Tambah Pertanyaan</h3>
            <form id="form-questions" method="POST">
                @csrf
                <div id="question-container">
                    <div class="form-group mb-3">
                        <label for="pertanyaan[0]">Pertanyaan <span style="color:red">*</span></label>
                        <input type="text" name="pertanyaan[]" class="form-control" placeholder="Masukkan Pertanyaan"
                            required>
                    </div>
                </div>
                <input type="hidden" name="template_id" id="template_id">
                <button type="button" class="btn btn-secondary mb-3" id="add-question">Tambah Pertanyaan</button>
                <button type="submit" class="btn btn-primary">Simpan Pertanyaan</button>
            </form>
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

            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function () {
                    const ksrId = this.dataset.ksrId;
                    const ksrNama = this.dataset.ksrNama;

                    document.querySelector('#editModal #ksr_id').value = ksrId;
                    document.querySelector('#editModal #ksr_nama').value = ksrNama;
                });
            });

            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault(); // Mencegah penghapusan langsung
                    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                        this.closest('form').submit(); // Submit form jika konfirmasi "OK"
                    }
                });
            });

            document.getElementById('save-template').addEventListener('click', function () {
                const form = document.getElementById('form-template');
                const formData = new FormData(form);

                fetch('{{ route('TemplateSurvei.ajaxSave') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    },
                    body: formData,
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);

                            // Tampilkan form pertanyaan
                            const formPertanyaan = document.getElementById('form-pertanyaan');
                            formPertanyaan.style.display = 'block';

                            // Set ID template ke input hidden di form pertanyaan
                            document.getElementById('template_id').value = data.template_id;
                        } else {
                            alert('Gagal menyimpan template.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan.');
                    });
            });

            document.getElementById('cancel-template').addEventListener('click', function () {
                if (confirm('Apakah Anda yakin ingin membatalkan pembuatan template survei?')) {
                    window.location.href = '{{ route("TemplateSurvei.index") }}'; // Arahkan ke halaman daftar template
                }
            });

            document.getElementById('add-question').addEventListener('click', function () {
                const container = document.getElementById('question-container');
                const index = container.children.length;
                const div = document.createElement('div');
                div.classList.add('form-group', 'mb-3');
                div.innerHTML = `
            <label for="pertanyaan[${index}]">Pertanyaan <span style="color:red">*</span></label>
            <input type="text" name="pertanyaan[]" class="form-control" placeholder="Masukkan Pertanyaan" required>
        `;
                container.appendChild(div);
            });
        </script>

</body>

</html>