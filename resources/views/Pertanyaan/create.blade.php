<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pertanyaan Survei</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Tambah Pertanyaan Survei</h2>
        <form action="{{ route('Pertanyaan.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="pty_pertanyaan" class="form-label">Pertanyaan</label>
                <input type="text" id="pty_pertanyaan" name="pty_pertanyaan" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="pty_isheader" class="form-label">Header</label>
                <select id="pty_isheader" name="pty_isheader" class="form-select" required>
                    <option value="1">Ya</option>
                    <option value="0">Tidak</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pty_isgeneral" class="form-label">Pertanyaan Umum</label>
                <select id="pty_isgeneral" name="pty_isgeneral" class="form-select" required>
                    <option value="1">Ya</option>
                    <option value="0">Tidak</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('Pertanyaan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>

</html>
