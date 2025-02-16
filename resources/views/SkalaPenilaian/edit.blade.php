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
        <div class="mb-3 border-bottom">
            <div class="page-nav-title">
                Edit Skala Penilaian
            </div>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('SkalaPenilaian.index') }}">Skala Penilaian</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">
                <h2 class="text-center mb-4">Edit Skala Penilaian</h2>
                
                <form id="editForm" action="{{ route('SkalaPenilaian.update', $skalaPenilaian->skp_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="skp_tipe" class="form-label fw-bold">Tipe *</label>
                        <select id="skp_tipe" name="skp_tipe" class="form-select" required>
                            <option value="">-- Pilih Tipe --</option>
                            <option value="RadioButton" {{ $skalaPenilaian->skp_tipe == 'RadioButton' ? 'selected' : '' }}>Radio Button</option>
                            <option value="CheckBox" {{ $skalaPenilaian->skp_tipe == 'CheckBox' ? 'selected' : '' }}>Check Box</option>
                            <option value="TextBox" {{ $skalaPenilaian->skp_tipe == 'TextBox' ? 'selected' : '' }}>Text Box</option>
                            <option value="TextArea" {{ $skalaPenilaian->skp_tipe == 'TextArea' ? 'selected' : '' }}>Text Area</option>
                        </select>
                    </div>

                    <div class="mb-3" id="skalaContainer">
                        <label for="skp_skala" class="form-label fw-bold">Skala *</label>
                        <input type="number" id="skp_skala" name="skp_skala" class="form-control" 
                               value="{{ $skalaPenilaian->skp_skala }}" min="1" required>
                    </div>

                    <div class="mb-3" id="deskripsiContainer">
                        <label class="form-label fw-bold">Deskripsi Nilai *</label>
                        <div id="deskripsiInputs"></div>
                    </div>

                    <div class="mb-4" id="previewContainer">
                        <label class="form-label fw-bold">Preview</label>
                        <div id="preview" class="border p-3 rounded"></div>
                    </div>

                    <input type="hidden" id="skp_deskripsi" name="skp_deskripsi">
                    <input type="hidden" name="skp_modif_by" value="retno.widiastuti">

                    

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1 m-2">
                            <a href="{{ route('SkalaPenilaian.index')}}">
                            <button
                            class="btn btn-secondary"
                            type="button"
                            style="width:100%"
                            onClick="{{ route('SkalaPenilaian.index')}}"
                             >Kembali</button>
                            </a>
                         
                        </div>
                        <div class="flex-grow-1 m-2">
                            <a href="">
                            <button
                            class="btn btn-primary"
                            style="width:100%"
                            onClick=""
                          >Simpan</button>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('skp_tipe').addEventListener('change', updateForm);
        document.getElementById('skp_skala').addEventListener('change', updateForm);
        document.getElementById('editForm').addEventListener('submit', handleSubmit);
    
        // Store the initial deskripsi value
        const initialDeskripsi = "{{ $skalaPenilaian->skp_deskripsi }}";
    
        function updateForm() {
            const type = document.getElementById('skp_tipe').value;
            const skalaInput = document.getElementById('skp_skala');
            const skalaContainer = document.getElementById('skalaContainer');
            const deskripsiInputs = document.getElementById('deskripsiInputs');
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('previewContainer');
    
            // Reset containers
            deskripsiInputs.innerHTML = '';
            preview.innerHTML = '';
    
            if (!type) return;
    
            // Handle visibility and values based on type
            if (type === 'TextBox') {
                skalaInput.value = '1';
                skalaContainer.style.display = 'none';
                previewContainer.style.display = 'none';
    
                // Single description input for TextBox
                createDeskripsiInput(1, false);
            } else if (type === 'TextArea') {
                skalaInput.value = '1';
                skalaContainer.style.display = 'none';
                previewContainer.style.display = 'none';
    
                // Single description input for TextArea with larger size
                createDeskripsiInput(1, true);
            } else {
                skalaContainer.style.display = 'block';
                previewContainer.style.display = 'block';
                const scale = parseInt(skalaInput.value) || 3;
    
                // Create description inputs and preview elements
                for (let i = 1; i <= scale; i++) {
                    createDeskripsiInput(i, false);
                    createPreviewElement(type, i, `Option ${i}`);
                }
            }
    
            // Fill in existing values if available
            if (initialDeskripsi) {
                const descriptions = initialDeskripsi.split(',');
                const inputs = document.querySelectorAll('.deskripsi-input');
                inputs.forEach((input, index) => {
                    if (descriptions[index]) {
                        input.value = descriptions[index];
                        updatePreviewLabel(index + 1, descriptions[index]);
                    }
                });
            }
    
            // Add event listeners to update preview dynamically
            document.querySelectorAll('.deskripsi-input').forEach((input, index) => {
                input.addEventListener('input', () => {
                    updatePreviewLabel(index + 1, input.value);
                });
            });
        }
    
        function createDeskripsiInput(index, isTextArea) {
            const container = document.getElementById('deskripsiInputs');
            const inputGroup = document.createElement('div');
            inputGroup.className = 'mb-2';
    
            let input;
            if (isTextArea) {
                input = document.createElement('textarea');
                input.rows = 5;
                input.className = 'form-control deskripsi-input';
            } else {
                input = document.createElement('input');
                input.type = 'text';
                input.className = 'form-control deskripsi-input';
            }
    
            input.placeholder = `Deskripsi ${index}`;
            input.required = true;
    
            inputGroup.appendChild(input);
            container.appendChild(inputGroup);
        }
    
        function createPreviewElement(type, index, labelText) {
            const preview = document.getElementById('preview');
    
            const wrapper = document.createElement('div');
            wrapper.className = 'preview-wrapper mb-2';
            wrapper.setAttribute('data-index', index);
    
            const input = document.createElement('input');
            input.type = type === 'RadioButton' ? 'radio' : 'checkbox';
            input.name = 'preview';
            input.className = 'me-2';
    
            const label = document.createElement('label');
            label.className = 'preview-label';
            label.textContent = labelText;
    
            wrapper.appendChild(input);
            wrapper.appendChild(label);
            preview.appendChild(wrapper);
        }
    
        function updatePreviewLabel(index, value) {
            const previewLabel = document.querySelector(`.preview-wrapper[data-index="${index}"] .preview-label`);
            if (previewLabel) {
                previewLabel.textContent = value || `Option ${index}`;
            }
        }
    
        function handleSubmit(e) {
    e.preventDefault();

    // Collect all descriptions
    const descriptions = [];
    document.querySelectorAll('.deskripsi-input').forEach(input => {
        if (input.value.trim()) {
            descriptions.push(input.value.trim());
        }
    });

    if (descriptions.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal',
            text: 'Mohon isi minimal satu deskripsi'
        });
        return;
    }

    // Validasi jumlah kata
    const totalWords = descriptions.join(' ').split(/\s+/).length;
    if (totalWords > 50) {
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal',
            text: 'Total kata dalam deskripsi tidak boleh lebih dari 50 kata'
        });
        return;
    }

    // Get current form data
    const type = document.getElementById('skp_tipe').value;
    const scale = document.getElementById('skp_skala').value;
    const combinedDescription = descriptions.join(',');

    // Fetch existing data (you'll need to pass this from the controller)
    const existingData = @json($existing_data);

    // Check for duplicates, excluding the current record
    const currentId = "{{ $skalaPenilaian->skp_id }}";
    const isDuplicate = existingData.some(data => 
        data.skp_id != currentId && 
        data.skp_tipe === type && 
        data.skp_skala == scale && 
        data.skp_deskripsi === combinedDescription
    );

    if (isDuplicate) {
        Swal.fire({
            icon: 'error',
            title: 'Duplikasi Data',
            text: 'Data dengan tipe, skala, dan deskripsi yang sama sudah ada dalam sistem.'
        });
        return;
    }

    Swal.fire({
            icon: 'success',
            title: 'Data Berhasil DiPerbaharui',
            text: 'Skala Penilaian berhasil disimpan.',
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            window.location.href = '{{ route("SkalaPenilaian.index") }}'; // Redirect to index page after success
        });

    // Set combined descriptions with comma delimiter
    document.getElementById('skp_deskripsi').value = combinedDescription;

    // Submit the form
    e.target.submit();
}
        // Initialize form on page load
        window.onload = function() {
            updateForm();
        };
    </script>
    
</body>
</html>