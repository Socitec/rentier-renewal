<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contact_customer_mail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $contact, $message)
    {
        $this->subject = $subject;
        $this->contact = $contact;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $admin = \DB::table('contact_mail_config')->first();
        return $this->view('contact_send_customer_mail', ['message'=>$this->message, 'subject'=>$this->subject, 'contact'=>$this->contact])
                    ->from($admin->from_mail, 'お問い合わせを受け付けました。')
                    ->subject('お問い合わせを受け付けました。');
    }
}
