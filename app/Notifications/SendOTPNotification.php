<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOTPNotification extends Notification
{
    use Queueable;

    protected $otp;

    /**
     * Create a new notification instance.
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Kode Verifikasi (OTP) Anda')
                    ->line('Terima kasih telah mendaftar. Gunakan kode OTP di bawah ini untuk memverifikasi email Anda:')
                    ->line($this->otp)
                    ->line('Kode ini akan kedaluwarsa dalam 10 menit.')
                    ->line('Jika Anda tidak merasa mendaftar, abaikan email ini.');
    }
}
