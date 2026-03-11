<?php
// app/Mail/WithdrawalRejectedMail.php

namespace App\Mail;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WithdrawalRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $withdrawal;
    public $note;

    public function __construct(Withdrawal $withdrawal, $note = null)
    {
        $this->withdrawal = $withdrawal;
        $this->note = $note;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Withdrawal Update – SmartEarn',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.withdrawal-rejected',
        );
    }
}