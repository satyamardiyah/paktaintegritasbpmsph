<?php

namespace App\Mail;

use App\Models\Pakta;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaktaIntegritasMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Pakta $pakta, public string $pdfPath) {}

    public function build()
    {
        return $this->subject('Pakta Integritas BPMSPH - ' . $this->pakta->ref_number)
            ->view('emails.pakta-integritas')
            ->attachFromStorageDisk('public', $this->pdfPath, $this->pakta->ref_number . '.pdf');
    }
}