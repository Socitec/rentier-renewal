<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contact_send_mail extends Mailable
{
    use Queueable, SerializesModels;



    public function __construct( $message, $subject, $form_mail) 
    {
        $this->message = $message;
        $this->subject = $subject;
        $this->form_mail = $form_mail;    
    }



    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        // 美容院のメールアドレスをIDに応じて取得
        return $this->view('contact_send_mail', ['message'=>$this->message, 'subject'=>$this->subject])
                    ->from($this->form_mail, 'お問い合わせを受け付けました。')
                    ->subject('お問い合わせを受け付けました。');
    }
}
