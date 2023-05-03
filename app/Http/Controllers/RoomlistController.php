<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\room_info_Model;

class RoomlistController extends Controller
{
    //
    public function index()
    {
        // インスタンス生成
        $room_info = new room_info_Model();

        // topのsliderの情報を呼び出す
        $room_info = $room_info->room_list();


        return view('room_list')->with([
            "room_list  "=>$room_info,                     // 遷移先のhtml出力フラグ                         
        ]);
    }

    public function prefectures($prefectures)
    {
        // インスタンス生成
        $room_info = new room_info_Model();

        // topのsliderの情報を呼び出す
        $room_info = $room_info->room_list();


        return view('room_list')->with([
            "room_list  "=>$room_info,                     // 遷移先のhtml出力フラグ                         
        ]);
    }
}
