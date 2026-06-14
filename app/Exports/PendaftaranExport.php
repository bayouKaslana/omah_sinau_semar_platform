<?php

namespace App\Exports;

use App\Models\Pendaftaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PendaftaranExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $lomba_id;

    public function __construct($lomba_id = null)
    {
        $this->lomba_id = $lomba_id;
    }

    public function collection()
    {
        $query = Pendaftaran::with('lomba')->latest();
        if ($this->lomba_id) {
            $query->where('lomba_id', $this->lomba_id);
        }
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Peserta',
            'Asal Sekolah',
            'Kelas',
            'Email',
            'No HP',
            'Guru Pembimbing',
            'Lomba',
            'Status',
            'Tanggal Daftar',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $row->nama_peserta,
            $row->asal_sekolah,
            $row->kelas ?? '-',
            $row->email,
            $row->no_hp,
            $row->nama_guru_pembimbing ?? '-',
            $row->lomba->nama ?? '-',
            $row->status_label,
            $row->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF2563EB']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}
