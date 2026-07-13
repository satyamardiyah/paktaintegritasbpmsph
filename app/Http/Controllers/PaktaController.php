<?php

namespace App\Http\Controllers;

use App\Models\Pakta;
use App\Mail\PaktaIntegritasMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PaktaController extends Controller
{
    public function index()
    {
        return view('pakta');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'        => 'required|string|max:255',
            'jabatan'     => 'required|string|max:255',
            'instansi'    => 'required|string|max:255',
            'email'       => 'required|email',
            'kepentingan' => 'required|string',
            'alamat'      => 'required|string',
            'signature'   => 'required|string',
        ]);

        $refNumber = 'PI-' . now()->format('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        $filename = 'pakta/' . $refNumber . '.pdf';

        DB::beginTransaction();

        try {
            $pakta = Pakta::create([
                'ref_number'  => $refNumber,
                'nama'        => $validated['nama'],
                'jabatan'     => $validated['jabatan'],
                'instansi'    => $validated['instansi'],
                'email'       => $validated['email'],
                'kepentingan' => $validated['kepentingan'],
                'alamat'      => $validated['alamat'],
                'signature'   => $validated['signature'],
                'status'      => 'done',
            ]);

            $pdf = Pdf::loadView('pdf.pakta-integritas', ['pakta' => $pakta])->setPaper('a4');
            Storage::disk('public')->makeDirectory('pakta');
            Storage::disk('public')->put($filename, $pdf->output());
            $pakta->update(['pdf_path' => $filename]);

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::error('Pakta storage failed', ['error' => $exception->getMessage()]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data Pakta Integritas. Silakan coba lagi.');
        }

        try {
            Mail::to($pakta->email)->send(new PaktaIntegritasMail($pakta, $filename));
        } catch (\Throwable $exception) {
            Log::error('Pakta email failed', ['pakta_id' => $pakta->id, 'error' => $exception->getMessage()]);
            return redirect()->route('pakta')
                ->with('success', 'Pakta Integritas berhasil disimpan. Namun email belum terkirim. Silakan coba lagi nanti.');
        }

        return redirect()->route('pakta')
            ->with('success', 'Pakta Integritas berhasil dikirim. Salinan PDF telah dikirim ke email Anda.');
    }

    // Untuk admin: download PDF dari dashboard
    public function download(Pakta $pakta)
    {
        $path = Storage::disk('public')->path($pakta->pdf_path);

        return response()->download($path, $pakta->ref_number . '.pdf');
    }
}