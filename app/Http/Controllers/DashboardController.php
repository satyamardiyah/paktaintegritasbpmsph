<?php

namespace App\Http\Controllers;

use App\Models\Pengunjung;
use App\Models\Pakta;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard-user.index');
    }

    public function stats()
    {
        $totalPengunjung = Pengunjung::count();
        $totalPakta = Pakta::count();
        // Ambil data 7 hari terakhir untuk grafik tren
        $pengunjungHarian = Pengunjung::selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $paktaHarian = Pakta::selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Susun label 7 hari penuh (isi 0 kalau tidak ada data di hari itu)
        $labels = [];
        $pengunjungData = [];
        $paktaData = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggalKey = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->translatedFormat('d M');

            $p = $pengunjungHarian->firstWhere('tanggal', $tanggalKey);
            $pengunjungData[] = $p ? (int) $p->total : 0;

            $f = $paktaHarian->firstWhere('tanggal', $tanggalKey);
            $paktaData[] = $f ? (int) $f->total : 0;
        }

        $kepentinganCounts = Pakta::selectRaw('kepentingan, COUNT(*) as total')
            ->groupBy('kepentingan')
            ->pluck('total', 'kepentingan');

        return response()->json([
            'total_pengunjung' => $totalPengunjung,
            'total_pakta' => $totalPakta,
            'persentase' => $totalPengunjung > 0
                ? round(($totalPakta / $totalPengunjung) * 100, 1)
                : 0,
            'labels' => $labels,
            'pengunjung' => $pengunjungData,
            'pakta' => $paktaData,
            'kepentingan' => [
                'Pengguna Jasa Pengujian' => (int) ($kepentinganCounts['Pengguna Jasa Pengujian'] ?? 0),
                'Penyedia Barang/Jasa' => (int) ($kepentinganCounts['Penyedia Barang/Jasa'] ?? 0),
                'Magang/PKL' => (int) ($kepentinganCounts['Magang/PKL'] ?? 0),
                'Pengguna Sewa Gedung' => (int) ($kepentinganCounts['Pengguna Sewa Gedung'] ?? 0),
                'Auditor' => (int) ($kepentinganCounts['Auditor'] ?? 0),
                'Pengguna Jasa Uji Profesi' => (int) ($kepentinganCounts['Pengguna Jasa Uji Profesi'] ?? 0),
            ],
            'updated_at' => now()->format('H:i:s'),
        ]);
    }
}