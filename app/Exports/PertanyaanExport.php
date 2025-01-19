<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PertanyaanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $pertanyaan;

    public function __construct($pertanyaan)
    {
        $this->pertanyaan = $pertanyaan;
    }

    // Mengambil data dari collection yang diteruskan
    public function collection()
    {
        return $this->pertanyaan;
    }

    // Format setiap baris data
    public function map($pertanyaan): array
    {
        return [
            $pertanyaan->pty_id,
            $pertanyaan->pty_pertanyaan,
            $pertanyaan->pty_isheader == 1 ? 'Ya' : 'Tidak',
            $pertanyaan->pty_isgeneral == 1 ? 'Ya' : 'Tidak',
        ];
    }

    // Menentukan heading kolom
    public function headings(): array
    {
        return [
            'ID',
            'Pertanyaan',
            'Header',
            'Pertanyaan Umum',
        ];
    }
}
