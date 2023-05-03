<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Reserve_Stay_Confirm_Mail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reserve_num, $name, $room_name, $checkin_date, $checkin_time, $stay_days, $money, $room_id)
    {
        $this->reserve_num = $reserve_num;
        $this->name = $name;
        $this->room_name = $room_name;
        $this->checkin_date = $checkin_date;
        $this->checkin_time = $checkin_time;
        $this->stay_days = $stay_days;
        $this->money = $money;
        $this->room_id = $room_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $admin = \DB::table('reservation_mail_config')->first();
        return $this->view('rooms_mail_confirm_stay', ['reserve_num'=>$this->reserve_num, 'name'=>$this->name, 'room_name'=>$this->room_name, 'checkin_date'=>$this->checkin_date, 'checkin_time'=>$this->checkin_time, 'stay_days'=>$this->stay_days, 'money'=>$this->money, 'room_id'=>$this->room_id])
                    ->from($admin->from_mail, $admin->message . 'より')
                    ->subject('予約を受け付けました');
    }
}
