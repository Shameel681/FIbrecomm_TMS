<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SupervisorAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $trainee;
    public $supervisor;

    /**
     * Create a new message instance.
     */
    public function __construct($trainee, $supervisor)
    {
        $this->trainee = $trainee;
        $this->supervisor = $supervisor;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Action Required: New Trainee Assigned to You',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.supervisor_assigned',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}