<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PesertaController extends Controller
{
    public function index(Request $request)
    {
        $query = Peserta::query();

        if ($request->mapel)   $query->where('mapel', $request->mapel);
        if ($request->tingkat) $query->where('tingkat', $request->tingkat);
        if ($request->cari)    $query->where('nama', 'like', '%'.$request->cari.'%');

        $peserta   = $query->orderBy('no_peserta')->paginate(30);
        $published = Peserta::where('is_published', true)->count();
        $total     = Peserta::count();

        return view('admin.peserta.index', compact('peserta', 'published', 'total'));
    }

    public function create()
    {
        return view('admin.peserta.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_peserta'   => 'required|string|max:20',
            'nama'         => 'required|string|max:255',
            'asal_sekolah' => 'required|string|max:255',
            'mapel'        => 'required|string',
            'tingkat'      => 'required|string',
        ]);

        Peserta::create($request->only([
            'no_peserta','nama','asal_sekolah','mapel','tingkat','kelas','ruang'
        ]));

        return redirect()->route('admin.peserta.index')
            ->with('success', 'Peserta berhasil ditambahkan!');
    }

    public function edit(Peserta $peserta)
    {
        return view('admin.peserta.form', compact('peserta'));
    }

    public function update(Request $request, Peserta $peserta)
    {
        $request->validate([
            'no_peserta'   => 'required|string|max:20',
            'nama'         => 'required|string|max:255',
            'asal_sekolah' => 'required|string|max:255',
            'mapel'        => 'required|string',
            'tingkat'      => 'required|string',
        ]);

        $peserta->update($request->only([
            'no_peserta','nama','asal_sekolah','mapel','tingkat','kelas','ruang'
        ]));

        return redirect()->route('admin.peserta.index')
            ->with('success', 'Data peserta diperbarui!');
    }

    public function destroy(Peserta $peserta)
    {
        $peserta->delete();
        return redirect()->route('admin.peserta.index')
            ->with('success', 'Peserta dihapus!');
    }

    // Publish/unpublish semua sekaligus
    public function publishAll()
    {
        Peserta::query()->update(['is_published' => true]);
        return redirect()->back()->with('success', 'Semua peserta berhasil dipublikasikan!');
    }

    public function unpublishAll()
    {
        Peserta::query()->update(['is_published' => false]);
        return redirect()->back()->with('success', 'Publikasi disembunyikan!');
    }

    // Import dari Excel
    public function importForm()
    {
        return view('admin.peserta.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:5120',
        ]);

        try {
            $file = $request->file('file');
            $data = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getPathname());

            $imported = 0;
            foreach ($data->getAllSheets() as $sheet) {
                $rows = $sheet->toArray();

                // Cari baris header (yang ada NO PESERTA)
                $headerRow = null;
                foreach ($rows as $i => $row) {
                    if (in_array('NO PESERTA', array_map('strtoupper', array_filter($row)))) {
                        $headerRow = $i;
                        break;
                    }
                }
                if ($headerRow === null) continue;

                $headers = array_map('strtoupper', $rows[$headerRow]);
                $noCol    = array_search('NO PESERTA', $headers);
                $namaCol  = array_search('NAMA', $headers);
                $sekolahCol = array_search('ASAL SEKOLAH', $headers);
                $mapelCol = array_search('MAPEL', $headers);
                $lvCol    = array_search('LV', $headers);
                $ruangCol = null;
                // cari RUANG di baris atas header
                foreach ($rows as $i => $row) {
                    foreach ($row as $cell) {
                        if (str_contains(strtoupper((string)$cell), 'RUANG :') || str_contains(strtoupper((string)$cell), 'RUANG:')) {
                            preg_match('/RUANG\s*:\s*(\d+)/i', (string)$cell, $m);
                            $ruangVal = isset($m[1]) ? 'Ruang ' . $m[1] : null;
                        }
                    }
                }

                for ($r = $headerRow + 1; $r < count($rows); $r++) {
                    $row = $rows[$r];
                    $noPeserta = trim($row[$noCol] ?? '');
                    $nama      = trim($row[$namaCol] ?? '');

                    if (!$noPeserta || !$nama) continue;

                    Peserta::updateOrCreate(
                        ['no_peserta' => $noPeserta],
                        [
                            'nama'         => $nama,
                            'asal_sekolah' => trim($row[$sekolahCol] ?? ''),
                            'mapel'        => trim($row[$mapelCol] ?? ''),
                            'tingkat'      => trim($row[$lvCol] ?? ''),
                            'ruang'        => $ruangVal ?? null,
                            'is_published' => false,
                        ]
                    );
                    $imported++;
                }
            }

            return redirect()->route('admin.peserta.index')
                ->with('success', "Berhasil import {$imported} peserta!");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}
