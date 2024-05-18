<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Lang;

class VerificationEmail extends Mailable implements  ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public  User $user)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verification Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
//        return (new MailMessage)
//            ->subject(Lang::get('Verify Email Address'))
//            ->line(Lang::get('Please click the button below to verify your email address.'))
//            ->action(Lang::get('Verify Email Address'), $this->user)
//            ->line(Lang::get('If you did not create an account, no further action is required.'))
//        ;
//    }
        return new Content(
            view: 'Emails.verification',
            with: (array)$this->user,
        );
    }


    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
