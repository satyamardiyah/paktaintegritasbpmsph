<?php

namespace App\Services;

use App\Models\Pakta;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class FonnteService
{
    public function sendPakta(Pakta $pakta): bool
    {
        $token = config('services.fonnte.token');

        if (blank($token)) {
            Log::warning('Token Fonnte belum dikonfigurasi.');
            return false;
        }

        if (blank($pakta->no_wa) || blank($pakta->pdf_path)) {
            Log::warning('Nomor WhatsApp atau path PDF kosong.', [
                'pakta_id' => $pakta->id,
            ]);
            return false;
        }

        if (! Storage::disk('public')->exists($pakta->pdf_path)) {
            Log::warning('PDF Pakta tidak ditemukan.', [
                'pakta_id' => $pakta->id,
                'path' => $pakta->pdf_path,
            ]);
            return false;
        }

        // Link PDF berlaku selama 7 hari.

if (blank($pakta->public_token)) {
    $pakta->public_token = Str::random(32);
}

$pakta->public_token_expires_at = now()->addDays(7);
$pakta->save();

$pdfUrl = route('pakta.short.pdf', [
    'token' => $pakta->public_token,
]);


        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->asForm()->timeout(30)->post(
                'https://api.fonnte.com/send',
                [
                    'target' => $this->normalizePhone($pakta->no_wa),
                    'message' => $this->message($pakta, $pdfUrl),
                ]
            );

            if (
                ! $response->successful()
                || $response->json('status') === false
            ) {
                Log::error('Pengiriman WhatsApp Pakta gagal.', [
                    'pakta_id' => $pakta->id,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return false;
            }

            Log::info('Permintaan WhatsApp Pakta berhasil diterima Fonnte.', [
                'pakta_id' => $pakta->id,
            ]);

            return true;
        } catch (\Throwable $exception) {
            Log::error('Error saat mengirim WhatsApp Pakta.', [
                'pakta_id' => $pakta->id,
                'error' => $exception->getMessage(),
            ]);

            return false;
        }
    }

    private function message(Pakta $pakta, string $pdfUrl): string
    {
        return "Halo {$pakta->nama}! 👋\n\n"
            . "Terima kasih telah mengisi Pakta Integritas BPMSPH.\n\n"
            . "Bukti Pakta Integritas Anda sudah tersedia.\n"
            . "Nomor Referensi: {$pakta->ref_number}\n\n"
            . "Silakan buka link berikut untuk mengunduh PDF:\n"
            . $pdfUrl . "\n\n"
            . "Link berlaku selama 7 hari. Mohon simpan dokumen tersebut sebagai bukti pengisian.\n\n"
            . "Terima kasih.\n"
            . "BPMSPH";
    }

    private function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\D/', '', $phone);

        if (str_starts_with($digits, '0')) {
            return '62' . substr($digits, 1);
        }

        if (str_starts_with($digits, '62')) {
            return $digits;
        }

        if (str_starts_with($digits, '8')) {
            return '62' . $digits;
        }

        return $digits;
    }
}
