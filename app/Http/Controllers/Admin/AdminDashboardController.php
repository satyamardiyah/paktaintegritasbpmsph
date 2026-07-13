<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pakta;
use App\Models\Pengunjung;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index');
    }

    public function stats()
    {
        $today = Carbon::today();
        $startMonth = $today->copy()->startOfMonth();

        $totalPengunjung = Pengunjung::count();
        $totalKunjungan = Pengunjung::whereBetween('created_at', [$startMonth, $today->endOfDay()])->count();
        $hariIni = Pengunjung::whereDate('created_at', $today)->count();
        $totalPengisi = Pakta::count();

        $labels = [];
        $pengunjungData = [];
        $startDate = Carbon::today()->subDays(29);

        $pengunjungHarian = Pengunjung::selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->where('created_at', '>=', $startDate)
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get()
            ->keyBy('tanggal');

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $key = $date->format('Y-m-d');
            $labels[] = $date->translatedFormat('d M');
            $pengunjungData[] = $pengunjungHarian[$key]->total ?? 0;
        }

        $kepentinganCounts = Pakta::selectRaw('kepentingan, COUNT(*) as total')
            ->groupBy('kepentingan')
            ->pluck('total', 'kepentingan');

        // ==== DIPERBAIKI: pakai kolom asli, bukan hitung manual ====
        $latestRows = Pakta::latest()->take(8)->get()->map(function ($item) {
            return [
                'nama' => $item->nama,
                'jabatan' => $item->jabatan,
                'instansi' => $item->instansi,
                'email' => $item->email,
                'alamat' => $item->alamat,
                'kepentingan' => $item->kepentingan,
                'waktu' => $item->created_at->format('d M Y H:i'),
                'ref' => $item->ref_number,
                'status' => $item->status,
                'pdf_url' => $item->pdf_path ? route('admin.pakta.download', $item->id) : null,
            ];
        });

        // ==== TAMBAHAN: tren 6 bulan terakhir (pengunjung vs pengisi) ====
        $trendLabels = [];
        $trendPengunjung = [];
        $trendPengisi = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::today()->subMonths($i);
            $trendLabels[] = $month->translatedFormat('M Y');

            $trendPengunjung[] = Pengunjung::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $trendPengisi[] = Pakta::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        return response()->json([
            'total_kunjungan' => $totalKunjungan,
            'total_pengisi' => $totalPengisi,
            'hari_ini' => $hariIni,
            'total_pengunjung' => $totalPengunjung,
            'persentase' => $totalPengunjung > 0 ? round(($totalPengisi / $totalPengunjung) * 100, 1) : 0,
            'labels' => $labels,
            'pengunjung' => $pengunjungData,
            'kepentingan' => [
                'Pengguna Jasa Pengujian' => (int) ($kepentinganCounts['Pengguna Jasa Pengujian'] ?? 0),
                'Penyedia Barang/Jasa' => (int) ($kepentinganCounts['Penyedia Barang/Jasa'] ?? 0),
                'Magang/PKL' => (int) ($kepentinganCounts['Magang/PKL'] ?? 0),
                'Pengguna Sewa Gedung' => (int) ($kepentinganCounts['Pengguna Sewa Gedung'] ?? 0),
                'Auditor' => (int) ($kepentinganCounts['Auditor'] ?? 0),
                'Pengguna Jasa Uji Profesi' => (int) ($kepentinganCounts['Pengguna Jasa Uji Profesi'] ?? 0),
            ],
            'latest_rows' => $latestRows,
            'trend_labels' => $trendLabels,
            'trend_pengunjung' => $trendPengunjung,
            'trend_pengisi' => $trendPengisi,
            'updated_at' => now()->format('H:i:s'),
        ]);
    }

    public function pengisiPakta(Request $request)
{
    $query = Pakta::latest();

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('instansi', 'like', "%{$search}%")
              ->orWhere('ref_number', 'like', "%{$search}%");
        });
    }

    $paktas = $query->paginate(15)->withQueryString();

    return view('admin.pengisi-pakta.index', compact('paktas'));
}
}