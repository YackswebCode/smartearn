<?php
// app/Mail/WithdrawalApprovedMail.php

namespace App\Mail;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WithdrawalApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $withdrawal;

    public function __construct(Withdrawal $withdrawal)
    {
        $this->withdrawal = $withdrawal;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Withdrawal Approved – SmartEarn',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.withdrawal-approved',
        );
    }
}