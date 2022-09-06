<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OTPMail extends Mailable
{
    use Queueable, SerializesModels;

    public $one_time_pin;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $one_time_pin )
    {
        $this->one_time_pin = $one_time_pin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.otp_mail');
    }
}
