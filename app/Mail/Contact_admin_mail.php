<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contact_admin_mail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_name, $telphone, $contact, $checkbox, $email)
    {
        $this->user_name = $user_name;
        $this->telphone = $telphone;
        $this->contact = $contact;
        $this->checkbox = $checkbox;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $admin = \DB::table('contact_mail_config')->first();
        return $this->view('contact_send_admin_mail', ['user_name'=>$this->user_name, 'telphone'=>$this->telphone, 'contact'=>$this->contact, 'checkbox'=>$this->checkbox ])
                    ->from($admin->from_mail, 'お問い合わせを受け付けました。')
                    ->subject('お客様からのお問い合わせがきています。');
    }
}
