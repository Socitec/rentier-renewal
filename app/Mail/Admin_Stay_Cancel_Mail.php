<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Admin_Stay_Cancel_Mail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reserve_num, $name, $room_name, $checkin_date, $checkin_time, $stay_days, $money, $room_id, $image_front, $image_back, $card_brand, $last4, $accepct_num)
    {
        $this->reserve_num = $reserve_num;
        $this->name = $name;
        $this->room_name = $room_name;
        $this->checkin_date = $checkin_date;
        $this->checkin_time = $checkin_time;
        $this->stay_days = $stay_days;
        $this->money = $money;
        $this->room_id = $room_id;
        $this->image_front = $image_front;
        $this->image_back = $image_back;

        $this->card_brand = $card_brand;
        $this->last4 = $last4;
        $this->accepct_num = $accepct_num;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $admin = \DB::table('contact_mail_config')->first();
        $front = asset('storage/images/idcard/'.$this->image_front);
        $back = asset('storage/images/idcard/'.$this->image_back);
        return $this->view('admin_mail_stay_cancel', [ 'reserve_num'=>$this->reserve_num, 
                                                       'name'=>$this->name, 
                                                       'room_name'=>$this->room_name, 
                                                       'checkin_date'=>$this->checkin_date, 
                                                       'checkin_time'=>$this->checkin_time, 
                                                       'stay_days'=>$this->stay_days, 
                                                       'money'=>$this->money, 
                                                       'room_id'=>$this->room_id, 
                                                       'front'=>$front, 
                                                       'back'=>$back,
                                                       'card_brand'=>$this->card_brand,
                                                       'last4'=>$this->last4,
                                                       'accepct_num'=>$this->accepct_num,
                                                       ])
                    ->from($admin->from_mail, $this->name. 'より')
                    ->subject('キャンセルを受け付けました');
    }
}
