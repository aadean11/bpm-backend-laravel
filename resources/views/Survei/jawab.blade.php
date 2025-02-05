<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jawab Survei - BPM Politeknik Astra</title>
    <!-- Sertakan Bootstrap dan CSS tambahan sesuai kebutuhan -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">Jawab Survei: {{ $survei->templateSurvei->tsu_nama }}</h2>
        <form action="{{ route('Survei.submitJawaban', $survei->trs_id) }}" method="POST">
            @csrf
            <!-- Loop melalui setiap detail pertanyaan -->
            @foreach($survei->surveyDetails as $detail)
                <div class="mb-3">
                    <label class="form-label"><strong>{{ $loop->iteration }}. {{ $detail->pertanyaan->pty_pertanyaan }}</strong></label>
                    <p>Skala: {{ $detail->skalaPenilaian->skp_skala ?? '-' }}</p>
                    <!-- Contoh input jawaban: bisa berupa radio button atau dropdown sesuai skala -->
                    <!-- Misalnya, input type number -->
                    <input type="number" name="answers[{{ $detail->dtt_id }}]" class="form-control" placeholder="Masukkan jawaban" required>
                </div>
            @endforeach
            <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
