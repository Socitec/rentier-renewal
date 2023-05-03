<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Reserve_sub_mail_send extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    // コンストラクタとしてここで初期設定をする
    public function __construct( $name, $subject, $form_mail, $use_category,$url) 
    {
        $this->name = $name;
        $this->subject = $subject;
        $this->form_mail = $form_mail;
        $this->use_category = $use_category;
        $this->url = $url;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $category = '宿泊';

        // メンバ変数の値が時間貸なら？
        if($this->use_category == "time_send")
        {
            $category = "時間貸し";
        }

        $data = [
            
                'name' => $this->name,
                'usecategory' => $category,
                'url' => $this->url,
            
        ];
        

        return $this->view('mailview_mail_check')
                    ->from($this->form_mail, 'レンティア運営より')
                    ->subject('メール確認の件について')
                    ->with('data',$data);

    }
}
