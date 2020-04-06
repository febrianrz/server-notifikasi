<?php

namespace App\Mail;

use App\Template;
use App\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GlobalMaillable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $htmlBody;
    public $notification;
    public function __construct(Notification $notification,Template $template=null,$data=null)
    {
        if($notification){
            $this->notification = $notification;
            $this->htmlBody = Notification::convert($notification->template->template,$notification->data);
        } else {
            $this->htmlBody = Notification::convert($template,$data);
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->notification){
            $markdown = $this
                ->subject($this->notification->subject)
                ->from($this->notification->from)
                ->markdown('emails.global');

            if($this->notification->attachment_storage){
                foreach($this->notification->attachment_storage as $at){
                    $markdown->attach($at);
                }
            }
            return $markdown;
        } else {
            return $this->markdown('emails.global');
        }
        
    }
}
