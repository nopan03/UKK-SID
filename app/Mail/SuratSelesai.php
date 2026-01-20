<?php

namespace App\Mail;

use App\Models\Surat;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment; 
use Illuminate\Queue\SerializesModels;

class SuratSelesai extends Mailable
{
    use Queueable, SerializesModels;

    public $surat;

    public function __construct(Surat $surat)
    {
        $this->surat = $surat;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Surat Anda Telah Terbit - Desa Suruh',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'admin.surat.emails.surat_selesai', 
        );
    }

    public function attachments(): array
    {
        // 🔥 PERBAIKAN DI SINI (Ubah file_surat_jadi -> file_surat) 🔥
        if ($this->surat->file_surat) {
            return [
                Attachment::fromStorageDisk('public', $this->surat->file_surat)
                    ->as('Surat-Resmi-Desa.pdf')
                    ->withMime('application/pdf'),
            ];
        }

        return [];
    }
}