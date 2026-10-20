<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pakta;
use App\Models\Pengunjung;
use App\Models\Penilaian;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index');
    }

    public function formPenilaian(Pakta $pakta)
{
    return view('admin.penilaian', compact('pakta'));
}

public function storePenilaian(Request $request, Pakta $pakta)
{
    $validated = $request->validate([
        'kriteria' => 'required|array|min:1',
        'kriteria.*.nama' => 'required|string|max:255',
        'kriteria.*.skor' => 'required|in:Tinggi,Sedang,Rendah',
        'catatan' => 'nullable|string',
        'signature' => 'required|string',
        'nama_penilai' => 'required|string|max:255',
    ]);

    // Jumlah minimum kriteria per kepentingan.
    // Sesuaikan jika nanti jumlah kriterianya diubah.
    $minimumKriteria = match ($pakta->kepentingan) {
        'Auditor' => 5,
        default => 3,
    };

    if (count($validated['kriteria']) < $minimumKriteria) {
        return back()
            ->withInput()
            ->withErrors([
                'kriteria' => "Penilaian untuk {$pakta->kepentingan} "
                    . "minimal harus memiliki {$minimumKriteria} kriteria.",
            ]);
    }

    Penilaian::updateOrCreate(
        ['pakta_id' => $pakta->id],
        [
            'kriteria' => array_values($validated['kriteria']),
            'catatan' => $validated['catatan'] ?? null,
            'signature' => $validated['signature'],
            'nama_penilai' => $validated['nama_penilai'],
        ]
    );

    return redirect()
        ->route('admin.pengisi-pakta')
        ->with('success', 'Penilaian berhasil disimpan.');
}


public function downloadPenilaian(Penilaian $penilaian)
{
    $penilaian->load('pakta');

    $pdf = Pdf::loadView('pdf.penilaian', compact('penilaian'));

    return $pdf->download('Penilaian-' . $penilaian->pakta->nama . '.pdf');
}

public function viewPenilaian(Penilaian $penilaian)
{
    $penilaian->load('pakta');

    $pdf = Pdf::loadView('pdf.penilaian', compact('penilaian'));

    return $pdf->stream('Penilaian-' . $penilaian->pakta->nama . '.pdf');
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

        $categoryTotals = [];
        $assessments = Penilaian::query()
            ->join('paktas', 'paktas.id', '=', 'penilaians.pakta_id')
            ->select('penilaians.kriteria', 'paktas.kepentingan')
            ->get();

        foreach ($assessments as $assessment) {
            foreach ((array) $assessment->kriteria as $criterion) {
                $score = Penilaian::scoreValue($criterion['skor'] ?? null);
                if ($score === null) {
                    continue;
                }

                $category = $assessment->kepentingan;
                $categoryTotals[$category] ??= ['total' => 0, 'count' => 0];
                $categoryTotals[$category]['total'] += $score;
                $categoryTotals[$category]['count']++;
            }
        }

        $categoryScores = collect($categoryTotals)
            ->map(fn ($totals, $category) => [
                'label' => $category,
                'average' => round($totals['total'] / $totals['count'], 2),
                'count' => $totals['count'],
            ])
            ->values();
        $highestAverage = $categoryScores->max('average');
        $topRatedCategories = $highestAverage === null
            ? []
            : $categoryScores
                ->where('average', $highestAverage)
                ->pluck('label')
                ->values();

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


        // Hasil akhir setiap orang yang sudah dinilai lengkap.
        $resultCounts = [
            'Tinggi' => 0,
            'Sedang' => 0,
            'Rendah' => 0,
        ];

        $belumLengkap = 0;
        $daftarHasilPenilaian = $this->daftarHasilPenilaian();

        foreach ($daftarHasilPenilaian as $hasil) {
            if ($hasil['kategori'] === 'Belum lengkap') {
                $belumLengkap++;
                continue;
            }

            $resultCounts[$hasil['kategori']]++;
        }

        $kategoriRekap = [
            'Pengguna Jasa Pengujian',
            'Penyedia Barang/Jasa',
            'Magang/PKL',
            'Pengguna Sewa Gedung',
            'Auditor',
            'Pengguna Jasa Uji Profesi',
        ];
        $rekapTotals = array_fill_keys($kategoriRekap, [
            'total_nilai' => 0,
            'jumlah_dinilai' => 0,
        ]);

        foreach ($daftarHasilPenilaian as $hasil) {
            if (
                $hasil['nilai_akhir'] === null ||
                !isset($rekapTotals[$hasil['kepentingan']])
            ) {
                continue;
            }

            $rekapTotals[$hasil['kepentingan']]['total_nilai'] += $hasil['nilai_akhir'];
            $rekapTotals[$hasil['kepentingan']]['jumlah_dinilai']++;
        }

        $rekapPenilaian = collect($rekapTotals)
            ->map(fn ($totals, $kategori) => [
                'kategori' => $kategori,
                'jumlah_dinilai' => $totals['jumlah_dinilai'],
                'rata_rata' => $totals['jumlah_dinilai'] > 0
                    ? round($totals['total_nilai'] / $totals['jumlah_dinilai'], 2)
                    : null,
            ])
            ->values()
            ->all();

        return response()->json([

            'hasil_penilaian' => [
                'labels' => ['Tinggi', 'Sedang', 'Rendah'],
                'data' => [
                    $resultCounts['Tinggi'],
                    $resultCounts['Sedang'],
                    $resultCounts['Rendah'],
                ],
                'total_dinilai' => array_sum($resultCounts),
                'belum_lengkap' => $belumLengkap,
            ],
            'daftar_hasil_penilaian' => $daftarHasilPenilaian,
            'rekap_penilaian' => $rekapPenilaian,
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
            'category_scores' => $categoryScores,
            'top_rated_categories' => $topRatedCategories,
            'latest_rows' => $latestRows,
            'trend_labels' => $trendLabels,
            'trend_pengunjung' => $trendPengunjung,
            'trend_pengisi' => $trendPengisi,
            'updated_at' => now()->format('H:i:s'),
        ]);
    }

    private function daftarHasilPenilaian(): array
    {
        return Pakta::with('penilaian')
            ->get()
            ->map(function ($pakta) {
                $penilaian = $pakta->penilaian;
                $lengkap = $penilaian && $penilaian->isComplete();

                return [
                    'nama' => $pakta->nama,
                    'instansi' => $pakta->instansi,
                    'kepentingan' => $pakta->kepentingan,
                    'nilai_akhir' => $lengkap
                        ? $penilaian->finalScore()
                        : null,
                    'kategori' => $lengkap
                        ? $penilaian->finalCategory()
                        : 'Belum lengkap',
                ];
            })
            ->values()
            ->all();
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

    // Selalu mulai dari halaman 1 tiap kali ada kata kunci baru
    $page = $request->filled('search') ? 1 : $request->input('page', 1);

    $paktas = $query->paginate(15, ['*'], 'page', $page)->withQueryString();

    // Kalau request AJAX (dari live search), balikin partial saja
    if ($request->ajax()) {
        return response()->json([
            'rows'       => view('admin.pengisi-pakta.rows', compact('paktas'))->render(),
            'pagination' => $paktas->links('admin.pengisi-pakta.pagination')->toHtml(),
        ]);
    }

    return view('admin.pengisi-pakta.index', compact('paktas'));
}
}