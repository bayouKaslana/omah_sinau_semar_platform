<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PendaftaranExport;
use App\Http\Controllers\Controller;
use App\Models\Lomba;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::with('lomba');

        if ($request->lomba_id) {
            $query->where('lomba_id', $request->lomba_id);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $pendaftaran = $query->latest()->paginate(20);
        $lombaList   = Lomba::orderBy('nama')->get();

        return view('admin.pendaftaran.index', compact('pendaftaran', 'lombaList'));
    }

    public function show(Pendaftaran $pendaftaran)
    {
        // Buat WA link untuk konfirmasi ke peserta
        $pesan = urlencode(
            "Halo *{$pendaftaran->nama_peserta}*! 👋\n\n" .
            "Kami dari *Mitra Prestasi* ingin menginformasikan bahwa pendaftaran Anda untuk lomba:\n" .
            "*{$pendaftaran->lomba->nama}*\n\n" .
            "Status: *{$pendaftaran->status_label}*\n\n" .
            "Terima kasih telah mendaftar! 🏆"
        );
        $waLink = "https://wa.me/{$pendaftaran->no_hp}?text={$pesan}";

        return view('admin.pendaftaran.show', compact('pendaftaran', 'waLink'));
    }

    public function updateStatus(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate(['status' => 'required|in:menunggu,diterima,ditolak']);
        $pendaftaran->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status pendaftaran diperbarui!');
    }

    public function destroy(Pendaftaran $pendaftaran)
    {
        $pendaftaran->delete();
        return redirect()->route('admin.pendaftaran.index')->with('success', 'Data pendaftaran dihapus!');
    }

    public function export(Request $request)
    {
        $lomba_id  = $request->lomba_id ?? null;
        $namaFile  = 'pendaftaran-' . now()->format('d-m-Y') . '.xlsx';
        return Excel::download(new PendaftaranExport($lomba_id), $namaFile);
    }
}
