<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicantRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $applicant;
    public $hrName;

    public function __construct($applicant, $hrName)
    {
        $this->applicant = $applicant;
        $this->hrName = $hrName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Update regarding your Application - Fibrecomm Network',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.rejected',
        );
    }
}