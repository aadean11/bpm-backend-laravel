<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Survei - BPM Politeknik Astra</title>
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
        th, td {
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
            color: inherit;
            align-items: center;
            padding: 5px;
        }
        a:hover {
            color: inherit;
        }
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

    <!-- Sidebar -->
    <div class="sidebar border-end" id="sidebar">
        <ul>
            <a href="../index"><li><i class="fas fa-home"></i> Dashboard</li></a>
            <a href="../KriteriaSurvei/index"><li><i class="fas fa-list"></i><span> Kriteria Survei</span></li></a>
            <a href="../SkalaPenilaian/index"><li><i class="fas fa-sliders-h"></i><span> Skala Penilaian</span></li></a>
            <a href="../PertanyaanSurvei/index"><li><i class="fas fa-question-circle"></i><span> Pertanyaan</span></li></a>
            <a href="../TemplateSurvei/index"><li><i class="fas fa-file"></i><span> Template Survei</span></li></a>
            <a href="../Survei/index"><li><i class="fas fa-poll"></i><span> Survei</span></li></a>
            <a href="../DaftarSurvei/index"><li><i class="fas fa-list-alt"></i><span> Daftar Survei</span></li></a>
            <a href="../Karyawan/index"><li><i class="fas fa-file"></i><span> Karyawan</span></li></a>
        </ul>
        <!-- Tombol Logout -->
        <div class="logout">
            <a href="../logout"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a>
        </div>
    </div>

    <!-- Content -->
    <div class="content mt-5">
        <div class="mb-3 border-bottom">
            <div class="page-nav-title">Detail Survei</div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('DaftarSurvei.index') }}">Daftar Survei</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Survei</li>
                </ol>
            </nav>
        </div>

      <!-- Informasi Survei Utama -->
      <div class="card mb-4">
          <div class="card-header bg-light">
              Informasi Survei
          </div>
          <div class="card-body">
              <p><strong>Nama Survei:</strong> {{ $survei->templateSurvei->tsu_nama ?? '-' }}</p>
              <p><strong>Target Karyawan:</strong> {{ $survei->karyawan->kry_role ?? '-' }}</p>
              <p><strong>Status Survei:</strong>
                  <span class="badge {{ $survei->trs_status ? 'bg-success' : 'bg-danger' }}">
                      {{ $survei->trs_status ? 'Aktif' : 'Tidak Aktif' }}
                  </span>
              </p>
              <p><strong>Tanggal Dibuat:</strong> {{ \Carbon\Carbon::parse($survei->trs_created_date)->format('d M Y H:i') }}</p>
          </div>
      </div>

      <!-- Daftar Pertanyaan, Skala, dan Jawaban -->
      <div class="card">
          <div class="card-header bg-light">
              Daftar Pertanyaan & Jawaban
          </div>
          <div class="card-body">
              @if($survei->surveyDetails && $survei->surveyDetails->count() > 0)
                  <table class="table table-bordered table-striped">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Pertanyaan</th>
                              <th>Skala</th>
                              <th>Nilai Jawaban</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($survei->surveyDetails as $index => $detail)
                              <tr>
                                  <td>{{ $index + 1 }}</td>
                                  <td>{{ $detail->pertanyaan->pty_pertanyaan ?? '-' }}</td>
                                  <td>
                                      {{-- Jika relasi skala ada, tampilkan nilai skala, jika tidak, tampilkan ID skala --}}
                                      {{ $detail->skala ? $detail->skala->skp_skala : $detail->skp_id ?? '-' }}
                                  </td>
                                  <td>{{ $detail->dtt_nilai ?? '-' }}</td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
              @else
                  <p class="text-center">Belum ada pertanyaan untuk survei ini.</p>
              @endif
          </div>
      </div>

      <!-- Tombol Kembali -->
      <div class="mt-3">
          <a href="{{ route('Survei.index') }}" class="btn btn-secondary">
              <i class="fas fa-arrow-left"></i> Kembali
          </a>
      </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
