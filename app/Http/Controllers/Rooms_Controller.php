<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\room_info_Model;

class Rooms_Controller extends Controller
{
    // DBに登録済みの部屋の情報を一覧表示する
    public function index() 
    {
    
        // インスタンス生成
        $room_list =  new room_info_Model();

        $room_list = $room_list->room_list();
    
        return view('rooms')->with([
            "room_list"=>$room_list->romms,
            "room_amenities"=>$room_list->amenitie_num,     
        ]);
    }

    // 部屋の詳細情報
    public function show($id)
    {
        // 詳細表示を書く
    }

    // 愛知県か？福岡県で絞り込む
    public function prefectures_seach($prefectures)
    {
        // インスタンス生成
        $prefectures_db =  new room_info_Model();

        // 都道府県検索
        $prefectures_db = $prefectures_db->room_list_prefectures($prefectures);

        return view('rooms')->with([
            "room_list"=>$prefectures_db->romms,                    
            "room_amenities"=>$prefectures_db->amenitie_num,             
        ]);
    }
}
