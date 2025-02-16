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
                Tambah Template Survei
            </div>

            <!-- Breadcrumbs -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('TemplateSurvei.index') }}">Template Survei</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Template Survei</li>
                </ol>
            </nav>
        </div>

        <div class="form-control">
            <h2 class="text-center mt-3">Tambah Template Survei</h2>
            <form id="template-form" action="{{ route('TemplateSurvei.save') }}" method="POST">
                @csrf

                <!-- Input Nama Template -->
                <div class="form-group mb-3">
                    <label for="tsu_nama">Nama Template <span style="color:red">*</span></label>
                    <input type="text" name="tsu_nama" id="tsu_nama" class="form-control @error('tsu_nama') is-invalid @enderror" required placeholder="Masukkan Nama Template">
                    @error('tsu_nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

             <!-- Input Pertanyaan -->
                <div id="pertanyaan-wrapper" class="form-group mb-3">
                    <label for="selected_pertanyaan">Pertanyaan <span style="color:red">*</span></label>
                    <div class="d-flex align-items-center">
                        <input type="text" id="selected_pertanyaan" class="form-control me-2" placeholder="Pilih pertanyaan" readonly>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pertanyaanModal">
                            Pilih Pertanyaan
                        </button>
                    </div>
                </div>
                <!-- Hidden input untuk menyimpan ID pertanyaan yang dipilih -->
                    <input type="hidden" id="selected_pty_id" name="pertanyaan_list[]">

            <!-- Modal -->
                <div class="modal fade" id="pertanyaanModal" tabindex="-1" aria-labelledby="pertanyaanModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="pertanyaanModalLabel">Pilih Pertanyaan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <ul class="list-group">
                                    @foreach($pertanyaan as $p)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <!-- Teks Pertanyaan -->
                                            <span>{{ $p->pty_pertanyaan }}</span>
                                            
                                            <!-- Checkbox di sebelah kanan -->
                                            <input type="checkbox" class="form-check-input select-question" 
                                                data-id="{{ $p->pty_id }}" 
                                                data-pertanyaan="{{ $p->pty_pertanyaan }}">
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="button" class="btn btn-primary" id="save-selected-questions">Simpan Pilihan</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tombol Kembali & Simpan -->
                <div class="d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1 m-2">
                        <a href="{{ route('TemplateSurvei.index') }}">
                            <button type="button" class="btn btn-secondary" style="width:100%">Kembali</button>
                        </a>
                    </div>
                    <div class="flex-grow-1 m-2">
                        <button type="submit" class="btn btn-primary" style="width:100%" id="simpan-btn">Simpan</button>
                    </div>
                </div>
            </form>
            <!-- Tabel untuk menampilkan pertanyaan yang dipilih -->
            <div class="form-group mt-3">
                <label for="selected_pertanyaan_table">Daftar Pertanyaan yang Dipilih</label>
                <table class="table table-bordered" id="pertanyaan-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pertanyaan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data pertanyaan yang dipilih akan ditambahkan di sini -->
                    </tbody>
                </table>
            </div>

        <script>
        document.addEventListener("DOMContentLoaded", function () {
            let selectedData = []; // Array untuk menyimpan ID pertanyaan yang dipilih

            document.querySelectorAll(".select-question").forEach((checkbox) => {
                checkbox.addEventListener("change", function () {
                    let pty_id = parseInt(this.dataset.id); // Ubah ke integer

                    if (this.checked) {
                        if (!selectedData.includes(pty_id)) {
                            selectedData.push(pty_id);
                        }
                    } else {
                        selectedData = selectedData.filter((id) => id !== pty_id);
                    }

                    // Update input hidden tanpa JSON.stringify
                    document.getElementById("selected_pty_id").value = selectedData.join(",");
                });
            });

            document.getElementById("save-selected-questions").addEventListener("click", function () {
                let selectedText = selectedData.length > 0 ? `${selectedData.length} pertanyaan dipilih` : "Pilih pertanyaan";
                document.getElementById("selected_pertanyaan").value = selectedText;
                let modal = new bootstrap.Modal(document.getElementById("pertanyaanModal"));
                modal.hide();
            });
        });

            document.getElementById('simpan-btn').addEventListener('click', function() {
        var table = document.getElementById('pertanyaan-table').getElementsByTagName('tbody')[0];
        var rows = table.getElementsByTagName('tr');
        var selectedData = [];

        // Looping melalui semua baris tabel dan ambil data
        for (var i = 0; i < rows.length; i++) {
            var pertanyaan = rows[i].cells[1].textContent; // Kolom Pertanyaan

            selectedData.push({
                pertanyaan: pertanyaan
            });
        }
        // Kirim data ke route template.Create menggunakan AJAX
       console.log("Mengirim data ke server...");

    fetch('/TemplateSurvei/save', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json', // Pastikan menerima JSON
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            pertanyaan_list: selectedData
        })
    })
    .then(response => {
        console.log("Response diterima:", response);
        return response.json();
    })
    .then(data => {
        console.log("Data dari server:", data);
        alert('Data berhasil disimpan!');
    })
    .catch(error => {
        console.error("Terjadi error:", error);
        alert('Terjadi kesalahan saat menyimpan data.');
    });

        });

    document.getElementById('save-selected-questions').addEventListener('click', function() {
        var selectedQuestions = [];
        var selectedIds = [];
        
        // Looping melalui semua checkbox yang dipilih
        document.querySelectorAll('.select-question:checked').forEach(function(checkbox) {
            var pertanyaanText = checkbox.getAttribute('data-pertanyaan');
            var pertanyaanId = checkbox.getAttribute('data-id');
            
            selectedQuestions.push(pertanyaanText);
            selectedIds.push(pertanyaanId);
            
            // Update input hidden dengan ID yang dipilih
            document.getElementById('selected_pty_id').value = selectedIds.join(',');
        });

        // Update nilai text field dengan pertanyaan yang dipilih
        document.getElementById('selected_pertanyaan').value = selectedQuestions.join(', ');

        // Menambahkan baris ke tabel dengan pertanyaan yang dipilih
        var tbody = document.getElementById('pertanyaan-table').getElementsByTagName('tbody')[0];
        selectedQuestions.forEach(function(pertanyaan, index) {
            var row = tbody.insertRow();
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            
            cell1.textContent = index + 1;
            cell2.textContent = pertanyaan;
            cell3.innerHTML = '<button type="button" class="btn btn-danger btn-sm" onclick="removeQuestion(this)">Hapus</button>';
        });

        // Tutup modal setelah menyimpan pilihan
        var modal = new bootstrap.Modal(document.getElementById('pertanyaanModal'));
        modal.hide();
    });
        // Fungsi untuk menghapus pertanyaan dari tabel
        function removeQuestion(button) {
            var row = button.parentElement.parentElement;
            var pertanyaanText = row.cells[1].textContent;

            // Mengaktifkan kembali checkbox yang dihapus dari tabel
            document.querySelectorAll('.select-question').forEach(function(checkbox) {
                if (checkbox.getAttribute('data-pertanyaan') === pertanyaanText) {
                    checkbox.disabled = false;
                    checkbox.closest('.list-group-item').style.backgroundColor = ''; // Menghapus tanda visual
                }
            });

            row.parentElement.removeChild(row); // Menghapus baris dari tabel
        }
        </script>

        <script>
              @if(session('success'))
                <script>
                    Swal.fire({
                        title: 'Sukses!',
                        text: '{{ session('success') }}',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                </script>
            @endif
        </script>
 <script>
//     document.getElementById('template-form').addEventListener('submit', function (e) {
//         e.preventDefault();

//         const formData = new FormData(this);

//         fetch(this.action, {
//             method: 'POST',
//             body: formData,
//             headers: {
//                 'X-Requested-With': 'XMLHttpRequest',
//             },
//         })
//         .then(response => {
// if (response.ok) {
//     // Jika berhasil, munculkan pesan sukses dengan SweetAlert
//     Swal.fire({
//         icon: 'success',
//         title: 'Berhasil',
//         text: 'Template survei berhasil disimpan!',
//     }).then(() => {
//         // Menampilkan form pertanyaan setelah sukses
//         document.getElementById('pertanyaan-section').style.display = 'block';
//     });
// } else {
//     console.log(formData)
//     // Jika terjadi error atau gagal
//     Swal.fire({
//         icon: 'error',
//         title: 'Gagal',
//         text: 'Gagal menyimpan template!',
//     });
// }
// })
// .catch(error => {
// console.error('Error:', error);
// Swal.fire({
//     icon: 'error',
//     title: 'Terjadi Kesalahan',
//     text: 'Silakan coba lagi!',
// });
// });

//     });

//     // Menampilkan SweetAlert untuk pesan sukses
//     @if(session('success'))
//         Swal.fire({
//             icon: 'success',
//             title: 'Berhasil',
//             text: '{{ session('success') }}',
//         });
//     @endif
//  --}}
 
    document.getElementById('add-question').addEventListener('click', function() {
    // Membuat elemen baru untuk pertanyaan
    const wrapper = document.getElementById('pertanyaan-wrapper');
    
    // Membuat elemen form group untuk pertanyaan baru
    const newQuestion = document.createElement('div');
    newQuestion.classList.add('form-group', 'mb-3');
    
    newQuestion.innerHTML = `
        <label for="pty_id">Pertanyaan <span style="color:red">*</span></label>
        <select name="pty_id[]" class="form-control" required>
            <option value="" disabled selected>-- Pilih Pertanyaan --</option>
            @foreach($pertanyaan as $p)
                <option value="{{ $p->pty_id }}">{{ $p->pty_pertanyaan }}</option>
            @endforeach
        </select>
    `;
    
    // Menambahkan elemen pertanyaan baru ke dalam wrapper
    wrapper.appendChild(newQuestion);
});

</script>

</body>

</html>
