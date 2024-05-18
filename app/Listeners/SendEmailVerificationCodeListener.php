<?php

namespace App\Listeners;

use App\Events\SignupEvent;
use App\Mail\VerificationEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;


class SendEmailVerificationCodeListener
{
    /**
     * Create the event listener.
     */
    public function __construct( )
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SignupEvent $event): void
    {
        $user = $event->user;
        $user->generateVerificationCode(); // generate verification email
        Mail::to($user->email)->send(new VerificationEmail($user));
        $user->code_sent_at = Carbon::now();
        $user->save();
    }
}
