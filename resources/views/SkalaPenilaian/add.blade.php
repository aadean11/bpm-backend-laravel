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
        <div class="mb-3 border-bottom"> <!-- PageNavTitle -->
            <div class="page-nav-title">
                Skala Penialian
            </div>

            <!-- Breadcrumbs -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" ><a href="{{ route('SkalaPenilaian.index')}}">Skala Penilaian</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Skala Penilaian</li>
                </ol>
            </nav>
        </div>

        <div class="form-control">
            <h2 class="text-center mt-3">Tambah Skala Penilaian</h2>
            <form action="/path/to/backend" method="POST"> <!-- Sesuaikan path -->
                <div class="mt-5">
                    <!-- Dropdown untuk memilih tipe -->
                    <div class="mb-3">
                        <label for="skp_tipe" class="form-label fw-bold">Tipe *</label>
                        <select id="skp_tipe" name="skp_tipe" class="form-control" onchange="updatePreview()" required>
                            <option value="RadioButton">Radio Button</option>
                            <option value="CheckBox">Check Box</option>
                            <option value="TextBox">Text Box</option>
                            <option value="TextArea">Text Area</option>
                        </select>
                    </div>
        
                    <!-- Input untuk Skala -->
                    <div class="mb-3">
                        <label for="skp_skala" class="form-label fw-bold">Skala *</label>
                        <input type="number" id="skp_skala" name="skp_skala" class="form-control" value="4" min="1" onchange="updatePreview()" required>
                    </div>
        
                    <!-- Preview -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Preview</label>
                        <div id="preview" class="d-flex gap-2"></div>
                    </div>
        
                    <!-- Input untuk Deskripsi -->
                    <div class="mb-3">
                        <label for="skp_deskripsi" class="form-label fw-bold">Deskripsi Nilai (Terendah - Tertinggi) *</label>
                        <textarea id="skp_deskripsi" name="skp_deskripsi" class="form-control" rows="3" readonly required></textarea>
                    </div>
                </div>
        
                <!-- Tombol Kembali dan Simpan -->
                <div class="d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1 m-2">
                        <a href="{{ route('SkalaPenilaian.index') }}">
                            <button class="btn btn-secondary" type="button" style="width:100%">Kembali</button>
                        </a>
                    </div>
                    <div class="flex-grow-1 m-2">
                        <button class="btn btn-success" style="width:100%" type="submit">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
        
        <script>
            function updatePreview() {
                const type = document.getElementById('skp_tipe').value;
                const scale = parseInt(document.getElementById('skp_skala').value) || 1;
                const preview = document.getElementById('preview');
                const description = document.getElementById('skp_deskripsi');
        
                preview.innerHTML = ''; // Reset preview
        
                for (let i = 1; i <= scale; i++) {
                    let element;
        
                    switch (type) {
                        case 'RadioButton':
                            element = document.createElement('input');
                            element.type = 'radio';
                            element.name = 'previewRadio';
                            element.id = `radio${i}`;
                            break;
        
                        case 'CheckBox':
                            element = document.createElement('input');
                            element.type = 'checkbox';
                            element.name = 'previewCheckbox';
                            element.id = `checkbox${i}`;
                            break;
        
                            case 'TextBox':
                element = document.createElement('input');
                element.type = 'text';
                element.name = 'textbox';
                element.id = 'textbox';
                element.placeholder = 'Isi TextBox';
                element.style.width = '100%';
                element.style.padding = '10px';
                element.style.border = '1px solid #ccc';
                element.style.borderRadius = '5px';
                break;

            case 'TextArea':
                element = document.createElement('textarea');
                element.name = 'textarea';
                element.id = 'textarea';
                element.rows = 4;
                element.placeholder = 'Isi TextArea';
                element.style.width = '100%';
                element.style.padding = '10px';
                element.style.border = '1px solid #ccc';
                element.style.borderRadius = '5px';
                break;
                    }
        
                    const label = document.createElement('label');
                    label.setAttribute('for', element.id);
                    label.innerText = ` ${i} `;
                    label.style.marginLeft = '5px';
        
                    const wrapper = document.createElement('div');
                    wrapper.style.display = 'inline-flex';
                    wrapper.style.alignItems = 'center';
                    wrapper.style.marginRight = '10px';
        
                    wrapper.appendChild(element);
                    wrapper.appendChild(label);
        
                    preview.appendChild(wrapper);
                }
        
                // Perbarui deskripsi berdasarkan skala
                const descriptions = Array.from({ length: scale }, (_, index) => `Pilihan ${index + 1}`).join(', ');
                description.value = descriptions;
            }
        
            // Inisialisasi preview saat halaman dimuat
            window.onload = updatePreview;
        </script>
        
        

</body>

</html>