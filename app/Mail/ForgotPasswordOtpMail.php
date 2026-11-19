<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordOtpMail extends Mailable
{
    use Queueable, SerializesModels;


    public $otp;


    public function __construct($otp)
    {
        $this->otp = $otp;
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mã OTP khôi phục mật khẩu ElectroTech',
        );
    }


    public function content(): Content
    {
        return new Content(
            markdown: 'mail.forgot-password-otp-mail',
        );
    }


    public function attachments(): array
    {
        return [];
    }
}