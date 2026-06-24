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
        // ===== PESAN 1: STATUS PENDAFTARAN =====
        $pesanStatus = urlencode(
            "Halo *{$pendaftaran->nama_peserta}*! 👋\n\n" .
            "Kami dari *Omah Sinau Semar* ingin menginformasikan bahwa pendaftaran Anda untuk lomba:\n" .
            "*{$pendaftaran->lomba->nama}*\n\n" .
            "Status: *{$pendaftaran->status_label}*\n\n" .
            "Terima kasih telah mendaftar! 🏆"
        );

        // ===== PESAN 2: PEMBAYARAN =====
        $pesanBayar = urlencode(
            "Halo *{$pendaftaran->nama_peserta}*! 👋\n\n" .
            "Terima kasih telah mendaftar di *Omah Sinau Semar* untuk lomba:\n" .
            "*{$pendaftaran->lomba->nama}*\n\n" .
            "📋 *DATA PENDAFTARAN:*\n" .
            "Nama: *{$pendaftaran->nama_peserta}*\n" .
            "Sekolah: *{$pendaftaran->asal_sekolah}*\n\n" .
            "💰 *SILAHKAN LAKUKAN PEMBAYARAN*\n" .
            "Hubungi admin untuk detail pembayaran dan nomor rekening.\n\n" .
            "Terima kasih! ❤️"
        );

        // Format nomor WA (0812... → 62812...)
        $noHp = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $pendaftaran->no_hp));

        // Generate WA links
        $waLinkStatus = "https://wa.me/{$noHp}?text={$pesanStatus}";
        $waLinkBayar = "https://wa.me/{$noHp}?text={$pesanBayar}";

        return view('admin.pendaftaran.show', compact('pendaftaran', 'waLinkStatus', 'waLinkBayar'));
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