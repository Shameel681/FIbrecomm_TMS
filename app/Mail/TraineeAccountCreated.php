<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TraineeAccountCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    public $trainee_forms;

    // Update the constructor to accept the new variable
    public function __construct(User $user, $password, $trainee_forms = null)
    {
        $this->user = $user;
        $this->password = $password;
        $this->trainee_forms = $trainee_forms; 
    }

    public function build()
    {
        return $this->subject('Your Internship Account Credentials')
                    ->view('emails.trainee_account_created');
    }
}