<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BPM Politeknik Astra</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .form-container {
      max-width: 800px;
      margin: 30px auto;
      background-color: #f8f9fa;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-group { 
      margin-bottom: 1rem;
    }

    .btn-container {
      display: flex;
      justify-content: space-between;
    }

    .btn-container .btn {
      width: 48%;
    }

    .table-container {
      margin-top: 30px;
    }

    .table th, .table td {
      vertical-align: middle;
    }

    .form-check-inline {
      display: flex;
      align-items: center;
    }

    .form-check-label {
      margin-left: 10px;
    }

    /* Flex container untuk sejajarkan semua elemen di satu baris */
    .flex-container {
      display: flex;
      gap: 20px; /* Menambahkan jarak antar kolom */
      justify-content: space-between;
      align-items: center;
    }

    .flex-container .form-group {
      flex: 1; /* Membuat setiap elemen mengambil ruang secara proporsional */
    }

    .form-container select {
      width: 100%; /* Membuat select dropdown mengisi lebar kolom */
    }

    /* Styling untuk tabel */
    .table th, .table td {
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="form-container">
   <form action="{{ route('Pertanyaan.save') }}" method="POST">
  @csrf

  <!-- Flexbox untuk sejajarkan Header, Pertanyaan, dan Jenis Pertanyaan dalam satu baris -->
  <div class="flex-container" style="margin-bottom: 20px;">
    <div class="form-check form-check-inline" style="margin-bottom: 10px;">
      <!-- Checkbox dengan label untuk memperjelas tampilannya -->
      <input class="form-check-input" type="checkbox" id="headerYa" name="pty_isheader" value="1">
      <label class="form-check-label" for="headerYa">Header?</label>
    </div>

    <div class="form-group" style="margin-bottom: 10px;">
      <label for="pertanyaan">Pertanyaan <span style="color: red">*</span></label>
      <input type="text" name="pty_pertanyaan" id="pertanyaan" class="form-control" placeholder="Masukkan Pertanyaan" required>
    </div>

    <div class="form-group" style="margin-bottom: 10px;">
      <label for="pertanyaanUmum">Jenis Pertanyaan <span style="color: red">*</span></label>
      <select name="pty_jenispertanyaan" id="pertanyaanUmum" class="form-control" required>
        <option value="">Pilih Jenis Pertanyaan</option>
        <option value="pilihan_ganda">Pilihan Ganda</option>
        <option value="pilihan_singkat">Pilihan Singkat</option>
      </select>
    </div>
  </div>
</form>


   <!-- Tombol tambah, import, export di atas tabel -->
    <div class="d-flex justify-content-start mb-4">
    <button type="button" class="btn btn-primary me-2">Tambah Pertanyaan</button>
    <button type="button" class="btn btn-success me-2">Import Pertanyaan</button>
    <button type="button" class="btn btn-success">Export Pertanyaan</button>
    </div>

   <!-- Tabel Daftar Pertanyaan -->
    <div class="table-container">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>No</th>
            <th>Header</th>
            <th>Pertanyaan</th>
            <th>Jenis Pertanyaan</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <!-- Baris ini akan tampil ketika tidak ada data -->
        <tr>
            <td colspan="5" class="text-center">Tidak ada data</td>
        </tr>
        </tbody>
    </table>
    </div>

    <!-- Tombol Simpan dan Batal -->
    <div class="btn-container mt-5">
      <button type="button" class="btn btn-secondary">Batal</button>
      <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
  </div>
</body>

</html>
