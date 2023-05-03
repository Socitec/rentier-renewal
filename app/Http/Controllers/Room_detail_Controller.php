<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\room_info_Model;

class Room_detail_Controller extends Controller
{
    //
    public function index($id)
    {
        $room_detail =  new room_info_Model();

        $rooms = $room_detail->room_detail($id);

        
        $amenitie_num  = $rooms->amenitie_num;

        $room_detail  = $rooms->room_detail;

        $room_access  = $rooms->room_access;

        $room_detail_slider  = $rooms->room_detail_slider;

        $lat = \DB::table('room')->where('id', $id)->value('lat');

        $lng = \DB::table('room')->where('id', $id)->value('lng');

        return view('rooms_detail')->with([
            "room_detail"  => $room_detail,                     
            'amenitie_num' => $amenitie_num,
            'room_access' => $room_access,     
            'room_detail_slider'=> $room_detail_slider,
            'lat'=>$lat,
            'lng'=>$lng,
            'id'=>$id,               
        ]);
    }
}
