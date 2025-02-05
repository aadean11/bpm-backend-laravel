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
<div class="content mt-5">
    <div class="mb-3 border-bottom"> <!-- PageNavTitle -->
        <div class="page-nav-title">
            Daftar Survei
        </div>

        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('DaftarSurvei.index')}}">Daftar Survei</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Survei</li>
            </ol>
        </nav>
    </div>

    <div class="mt-5">
        <div class="card">
            <div class="card-body">
                <h2 class="text-center mb-4">Tambah Survei</h2>
                
                <form id="daftarSurveiForm" action="{{ route('DaftarSurvei.save') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="tsu_id" class="form-label fw-bold">Template *</label>
                        <select id="tsu_id" name="trs_id" class="form-select" required>
                            <option value="">-- Pilih Survei --</option>
                            @foreach($template_list as $template)
                                <option value="{{ $template->tsu_id }}">
                                    {{ $template->tsu_nama }} - {{ $template-> tsu_nama}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="pty_id" class="form-label fw-bold">Pertanyaan *</label>
                        <select id="pty_id" name="pty_id" class="form-select" required>
                            <option value="">-- Pilih Pertanyaan --</option>
                            @foreach($pertanyaan_list as $pertanyaan)
                                <option value="{{ $pertanyaan->pty_id }}">{{ $pertanyaan->pty_pertanyaan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="skp_id" class="form-label fw-bold">Skala Penilaian *</label>
                        <select id="skp_id" name="skp_id" class="form-select" required>
                            <option value="">-- Pilih Skala Penilaian --</option>
                            @foreach($skala_penilaian_list as $skala)
                                <option value="{{ $skala->skp_id }}" data-type="{{ $skala->skp_tipe }}" 
                                        data-descriptions="{{ $skala->skp_deskripsi }}">
                                    {{ $skala->skp_skala }} - {{ $skala->skp_deskripsi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4" id="nilaiContainer">
                        <label for="dtt_nilai" class="form-label fw-bold">Nilai *</label>
                        <div id="nilaiInputArea"></div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1 m-2">
                            <a href="{{ route('DaftarSurvei.index')}}">
                                <button class="btn btn-secondary" type="button" style="width:100%">Kembali</button>
                            </a>
                        </div>
                        <div class="flex-grow-1 m-2">
                            <button class="btn btn-primary" style="width:100%" type="submit">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('skp_id').addEventListener('change', updateNilaiInput);
    document.getElementById('daftarSurveiForm').addEventListener('submit', handleSubmit);

    function updateNilaiInput() {
        const selectedOption = document.querySelector('#skp_id option:checked');
        const nilaiInputArea = document.getElementById('nilaiInputArea');
        nilaiInputArea.innerHTML = '';

        if (!selectedOption.value) return;

        const type = selectedOption.dataset.type;
        const descriptions = selectedOption.dataset.descriptions.split(',');

        switch(type) {
            case 'RadioButton':
                descriptions.forEach((desc, index) => {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'form-check mb-2';

                    const input = document.createElement('input');
                    input.type = 'radio';
                    input.className = 'form-check-input';
                    input.name = 'dtt_nilai';
                    input.value = index + 1;
                    input.id = `nilai_${index}`;
                    input.required = true;

                    const label = document.createElement('label');
                    label.className = 'form-check-label';
                    label.htmlFor = `nilai_${index}`;
                    label.textContent = desc.trim();

                    wrapper.appendChild(input);
                    wrapper.appendChild(label);
                    nilaiInputArea.appendChild(wrapper);
                });
                break;

            case 'CheckBox':
                descriptions.forEach((desc, index) => {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'form-check mb-2';

                    const input = document.createElement('input');
                    input.type = 'checkbox';
                    input.className = 'form-check-input';
                    input.name = 'dtt_nilai';
                    input.value = index + 1;
                    input.id = `nilai_${index}`;

                    const label = document.createElement('label');
                    label.className = 'form-check-label';
                    label.htmlFor = `nilai_${index}`;
                    label.textContent = desc.trim();

                    wrapper.appendChild(input);
                    wrapper.appendChild(label);
                    nilaiInputArea.appendChild(wrapper);
                });
                break;

            case 'TextBox':
                const input = document.createElement('input');
                input.type = 'text';
                input.className = 'form-control';
                input.name = 'dtt_nilai';
                input.required = true;
                nilaiInputArea.appendChild(input);
                break;

            case 'TextArea':
                const textarea = document.createElement('textarea');
                textarea.className = 'form-control';
                textarea.name = 'dtt_nilai';
                textarea.rows = 4;
                textarea.required = true;
                nilaiInputArea.appendChild(textarea);
                break;
        }
    }

    function handleSubmit(e) {
        e.preventDefault();
        
        const form = e.target;
        const formData = new FormData(form);
        
        if (!formData.get('dtt_nilai')) {
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                text: 'Mohon isi nilai survei'
            });
            return;
        }

        form.submit();
    }

    // Initialize form on page load
    window.onload = function() {
        updateNilaiInput();
    };
</script>
    </div>
</body>
</html>

