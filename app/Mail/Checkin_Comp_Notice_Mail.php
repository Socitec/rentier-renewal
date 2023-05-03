<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Checkin_Comp_Notice_Mail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reserve_num, $name, $room_name, $image, $id_front, $id_back)
    {
        $this->reserve_num = $reserve_num;
        $this->name = $name;
        $this->room_name = $room_name;
        $this->image = $image;
        $this->id_front = $id_front;
        $this->id_back = $id_back;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $admin = \DB::table('reservation_mail_config')->first();
        $room = \DB::table('room')->where('id', $this->room_name)->value('stay_name');
        $asset = asset('storage/images/checkin_user/'.$this->image);
        $asset2 = asset('storage/images/checkin_id_front/'.$this->id_front);
        $asset3 = asset('storage/images/checkin_id_back/'.$this->id_back);
        return $this->view('checkin_comp_notice', ['reserve_num'=>$this->reserve_num, 'name'=>$this->name, 'room_name'=>$room, 'asset'=>$asset, 'asset2'=>$asset2, 'asset3'=>$asset3])
                    ->from($admin->from_mail, $admin->message . 'より')
                    // ->attach($asset)
                    ->subject('チェックイン完了通知');
    }
}
