<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PublikasiController extends Controller
{
    public function index(Request $request)
    {
        $keyword = trim($request->input('cari', ''));
        $hasil   = collect();

        if ($keyword) {
            $dariPeserta = Peserta::with('lomba')
                ->where('is_published', true)
                ->where('nama', 'like', '%' . $keyword . '%')
                ->orderBy('no_peserta')
                ->get()
                ->map(function ($p) {
                    return [
                        'sumber'       => 'peserta',
                        'no_peserta'   => $p->no_peserta,
                        'nama'         => $p->nama,
                        'asal_sekolah' => $p->asal_sekolah,
                        'mapel'        => $p->mapel,
                        'mapel_icon'   => $p->mapel_icon,
                        'tingkat'      => strtoupper($p->tingkat),
                        'kelas'        => $p->kelas,
                        'ruang'        => $p->ruang,
                        'nama_lomba'   => $p->lomba?->nama ?? ('Olimpiade ' . $p->mapel),
                        'kategori'     => $p->lomba?->kategori ?? null,
                    ];
                });

            $dariPendaftaran = Pendaftaran::with('lomba')
                ->where('status', 'diterima')
                ->where('nama_peserta', 'like', '%' . $keyword . '%')
                ->get()
                ->map(function ($d) {
                    return [
                        'sumber'       => 'pendaftaran',
                        'no_peserta'   => null,
                        'nama'         => $d->nama_peserta,
                        'asal_sekolah' => $d->asal_sekolah,
                        'mapel'        => $d->lomba?->nama ?? '-',
                        'mapel_icon'   => '🏆',
                        'tingkat'      => strtoupper($d->kelas ?? ''),
                        'kelas'        => $d->kelas,
                        'ruang'        => null,
                        'nama_lomba'   => $d->lomba?->nama ?? '-',
                        'kategori'     => $d->lomba?->kategori ?? null,
                    ];
                });

            $hasil = $dariPeserta->merge($dariPendaftaran)
                ->unique(fn($item) =>
                    strtolower($item['nama']) . '|' .
                    strtolower($item['asal_sekolah'] ?? '') . '|' .
                    strtolower($item['mapel'] ?? '') . '|' .
                    ($item['no_peserta'] ?? '')
                )
                ->values();
        }

        return view('publikasi.index', compact('keyword', 'hasil'));
    }
}
