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
                        <label for="trs_id" class="form-label fw-bold">Pilih Survei *</label>
                        <select id="trs_id" name="trs_id" class="form-select" required>
                            <option value="">-- Pilih Survei --</option>
                            @foreach($survei_list as $survei)
                                <option value="{{ $survei->trs_id }}">
                                    {{ $survei->templateSurvei->tsu_nama }} - {{ $survei->karyawan->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Pertanyaan *</label>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#questionModal">
                            Pilih Pertanyaan
                        </button>
                    </div>

                    <!-- Selected Questions Display -->
                    <div id="selectedQuestionsContainer" class="mb-3">
                        <!-- Selected questions will be displayed here -->
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

                <!-- Question Selection Modal -->
                <div class="modal fade" id="questionModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Pilih Pertanyaan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                @foreach($pertanyaan_list as $pertanyaan)
                                    <div class="form-check mb-3">
                                        <input class="form-check-input question-checkbox" 
                                               type="checkbox" 
                                               value="{{ $pertanyaan->pty_id }}" 
                                               id="modal_pertanyaan_{{ $pertanyaan->pty_id }}"
                                               data-question="{{ $pertanyaan->pty_pertanyaan }}">
                                        <label class="form-check-label" for="modal_pertanyaan_{{ $pertanyaan->pty_id }}">
                                            {{ $pertanyaan->pty_pertanyaan }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="button" class="btn btn-primary" id="addQuestionsBtn">Tambah</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
    <script>
        // Initialize selectedQuestions as an object to store question data
        let selectedQuestions = {};
        
        // Add click handler for the add questions button
        document.getElementById('addQuestionsBtn').addEventListener('click', function() {
            addSelectedQuestions();
        });

        function addSelectedQuestions() {
            const container = document.getElementById('selectedQuestionsContainer');
            const checkedQuestions = document.querySelectorAll('.question-checkbox:checked');
            
            // Store newly selected questions
            checkedQuestions.forEach(checkbox => {
                const questionId = checkbox.value;
                if (!selectedQuestions[questionId]) {
                    selectedQuestions[questionId] = {
                        id: questionId,
                        text: checkbox.dataset.question
                    };
                }
            });
            
            // Remove questions that were unchecked
            Object.keys(selectedQuestions).forEach(questionId => {
                const checkbox = document.getElementById(`modal_pertanyaan_${questionId}`);
                if (!checkbox.checked) {
                    delete selectedQuestions[questionId];
                    const existingContainer = document.getElementById(`question_container_${questionId}`);
                    if (existingContainer) {
                        existingContainer.remove();
                    }
                }
            });
            
            // Render all selected questions
            renderSelectedQuestions();
            
            // Close modal
            const modal = document.getElementById('questionModal');
            const modalInstance = bootstrap.Modal.getInstance(modal);
            modalInstance.hide();
        }

        function renderSelectedQuestions() {
            const container = document.getElementById('selectedQuestionsContainer');
            container.innerHTML = '';
            
            Object.values(selectedQuestions).forEach(question => {
                const questionDiv = document.createElement('div');
                questionDiv.className = 'card mb-3';
                questionDiv.id = `question_container_${question.id}`;
                
                questionDiv.innerHTML = `
                    <div class="card-body">
                        <h5 class="card-title">${question.text}</h5>
                        <input type="hidden" name="pty_id[]" value="${question.id}">
                        
                        <div class="mb-3">
                            <label class="form-label">Skala Penilaian</label>
                            <select name="skp_id[${question.id}]" class="form-select skala-select" data-question-id="${question.id}" required>
                                <option value="">-- Pilih Skala Penilaian --</option>
                                @foreach($skala_penilaian_list as $skala)
                                    <option value="{{ $skala->skp_id }}" 
                                            data-type="{{ $skala->skp_tipe }}"
                                            data-descriptions="{{ $skala->skp_deskripsi }}">
                                        {{ $skala->skp_skala }} - {{ $skala->skp_deskripsi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="nilai-container" id="nilai_container_${question.id}">
                            <!-- Nilai input will be generated here -->
                        </div>
                        
                        <button type="button" class="btn btn-danger btn-sm mt-2" 
                                onclick="removeQuestion('${question.id}')">
                            Hapus Pertanyaan
                        </button>
                    </div>
                `;
                
                container.appendChild(questionDiv);
                
                // Add event listener to the new scale select
                const scaleSelect = questionDiv.querySelector('.skala-select');
                scaleSelect.addEventListener('change', function() {
                    updateNilaiInput(this.dataset.questionId);
                });
            });
        }

        function removeQuestion(questionId) {
            // Remove from selectedQuestions object
            delete selectedQuestions[questionId];
            
            // Remove from DOM
            const element = document.getElementById(`question_container_${questionId}`);
            if (element) element.remove();
            
            // Uncheck the corresponding modal checkbox
            const modalCheckbox = document.getElementById(`modal_pertanyaan_${questionId}`);
            if (modalCheckbox) {
                modalCheckbox.checked = false;
            }
        }

        function updateNilaiInput(questionId) {
            const container = document.getElementById(`nilai_container_${questionId}`);
            const select = document.querySelector(`select[name="skp_id[${questionId}]"]`);
            const selectedOption = select.options[select.selectedIndex];
            
            container.innerHTML = '';
            
            if (!selectedOption.value) return;
            
            const type = selectedOption.dataset.type;
            const descriptions = selectedOption.dataset.descriptions.split(',');
            
            switch(type) {
                case 'RadioButton':
                    descriptions.forEach((desc, index) => {
                        container.innerHTML += `
                            <div class="form-check mb-2">
                                <input type="radio" class="form-check-input" 
                                       name="dtt_nilai[${questionId}]" value="${index + 1}" 
                                       id="nilai_${questionId}_${index}" required>
                                <label class="form-check-label" for="nilai_${questionId}_${index}">
                                    ${desc.trim()}
                                </label>
                            </div>
                        `;
                    });
                    break;
                    
                case 'CheckBox':
                    descriptions.forEach((desc, index) => {
                        container.innerHTML += `
                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" 
                                       name="dtt_nilai[${questionId}][]" value="${index + 1}" 
                                       id="nilai_${questionId}_${index}">
                                <label class="form-check-label" for="nilai_${questionId}_${index}">
                                    ${desc.trim()}
                                </label>
                            </div>
                        `;
                    });
                    break;
                    
                case 'TextBox':
                    container.innerHTML = `
                        <input type="text" class="form-control" 
                               name="dtt_nilai[${questionId}]" required>
                    `;
                    break;
                    
                case 'TextArea':
                    container.innerHTML = `
                        <textarea class="form-control" 
                                 name="dtt_nilai[${questionId}]" 
                                 rows="4" required></textarea>
                    `;
                    break;
                
                default:
                    container.innerHTML = `
                        <input type="number" class="form-control" 
                               name="dtt_nilai[${questionId}]" required>
                    `;
                    break;
            }
        }

        // Form submission handler
        document.getElementById('daftarSurveiForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (Object.keys(selectedQuestions).length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: 'Minimal satu pertanyaan harus dipilih.'
                });
                return;
            }
            
            // Check if all selected questions have values
            let isValid = true;
            let firstInvalidQuestion = null;
            
            Object.keys(selectedQuestions).forEach(questionId => {
                const scaleSelect = document.querySelector(`select[name="skp_id[${questionId}]"]`);
                if (!scaleSelect.value) {
                    isValid = false;
                    if (!firstInvalidQuestion) firstInvalidQuestion = questionId;
                    return;
                }
                
                const nilaiInputs = document.querySelectorAll(`[name^="dtt_nilai[${questionId}]"]`);
                let hasValue = false;
                
                nilaiInputs.forEach(input => {
                    if (input.type === 'radio' || input.type === 'checkbox') {
                        if (input.checked) hasValue = true;
                    } else {
                        if (input.value.trim()) hasValue = true;
                    }
                });
                
                if (!hasValue) {
                    isValid = false;
                    if (!firstInvalidQuestion) firstInvalidQuestion = questionId;
                }
            });
            
            if (!isValid) {
                const questionDiv = document.getElementById(`question_container_${firstInvalidQuestion}`);
                if (questionDiv) {
                    questionDiv.scrollIntoView({ behavior: 'smooth' });
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: 'Mohon isi skala penilaian dan nilai untuk semua pertanyaan yang dipilih.'
                });
                return;
            }
            
            this.submit();
        });

        // Initialize modal checkboxes based on selected questions when modal opens
        document.getElementById('questionModal').addEventListener('show.bs.modal', function () {
            Object.keys(selectedQuestions).forEach(questionId => {
                const checkbox = document.getElementById(`modal_pertanyaan_${questionId}`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
        });
    </script>
</body>
</html>