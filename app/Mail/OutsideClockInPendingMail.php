<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OutsideClockInPendingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $trainee;
    public $supervisor;
    public $attendance;

    /**
     * Create a new message instance.
     */
    public function __construct($trainee, $supervisor, $attendance)
    {
        $this->trainee = $trainee;
        $this->supervisor = $supervisor;
        $this->attendance = $attendance;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Attendance approval needed: ' . $this->trainee->name . ' – outside clock-in',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.outside_clock_in_pending',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
