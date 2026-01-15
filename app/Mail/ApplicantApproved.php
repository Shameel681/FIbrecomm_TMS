<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicantApproved extends Mailable
{
    use Queueable, SerializesModels;

    // Define public properties so they are automatically available in your blade view
    public $applicant;
    public $hrName;

    /**
     * Create a new message instance.
     * * @param $applicant (The TraineeForm model instance)
     * @param $hrName (The name of the HR who clicked approve)
     */
    public function __construct($applicant, $hrName)
    {
        $this->applicant = $applicant;
        $this->hrName = $hrName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Internship Offer - Fibrecomm Network (M) Sdn. Bhd.',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.approved', // Ensure this matches resources/views/emails/approved.blade.php
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