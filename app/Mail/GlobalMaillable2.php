<?php

namespace App\Mail;

use App\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GlobalMaillable2 extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $htmlBody;
    public $notification;
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
        $this->htmlBody     = $notification->body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->notification->subject)
            ->from($this->notification->from,config('notif')['app_name'])
            ->markdown('emails.global2');
    }
}
