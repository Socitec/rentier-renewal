<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class room_info_Model extends Model
{
    use HasFactory;

    // TOPページのスライダーを表示する為の関数
    public function top_slider()
    {
        $data = \DB::table('top_slider')->get();

        return $data;
    }

    // 今後ここは検索ロジックで取り出し方は変えるかもしれない引数とかいれて
    public function room_list()
    {
        // 部屋情報、アメニティ、リストの画像の情報を引き出す
        // 部屋数が増えた時にためにページネーションで区切る
        $amenitie_num = \DB::table('room')->join('room_amenitie', 'room.id', '=', 'room_amenitie.room_id')
                                          ->select('room.*', 'room_amenitie.*' ,'room.id as room_id')
                                          ->orderBy('amenitie_num','desc')
                                          ->where('room.role', 0)                           //0は表示フラグとする
                                          ->get();

        $romms = \DB::table('room')->paginate(10);
        
        $data = (object) [
            'amenitie_num'   => $amenitie_num,
            'romms'          => $romms,
        ];

        return $data;
    }

    // 今後ここは検索ロジックで取り出し方は変えるかもしれない引数とかいれて
    public function room_list_prefectures($prefectures)
    {
        // var_dump($prefectures);
        // 部屋情報、アメニティ、リストの画像の情報を引き出す
        // 部屋数が増えた時にためにページネーションで区切る
        $amenitie_num = \DB::table('room')->join('room_amenitie', 'room.id', '=', 'room_amenitie.room_id')
                                          ->select('room.*', 'room_amenitie.*', 'room.id as room_id')
                                          ->orderBy('amenitie_num','desc')
                                          ->where('room.prefectures', $prefectures)
                                          ->where('room.role', 0)                           //0は表示フラグとする
                                          ->get();
                                          

        $romms = \DB::table('room')->where('room.prefectures', $prefectures)
                                  ->paginate(10);

        $data = (object) [
            'amenitie_num'   => $amenitie_num,
            'romms'        => $romms,   
            ];

        return $data;
    }


    // 部屋のidから情報を引き出す
    public function room_detail($id)
    {


        // 部屋のidから部屋情報を引き出す
        $room_detail = \DB::table('room')->where('id', $id)->first();

        $room_detail_slider = \DB::table('room_detail_slider')->where('room_id', $id)->first();

        $amenitie_num = \DB::table('room_amenitie')->orderBy('amenitie_num','desc')->where('room_id', $id)->get();

        $access = \DB::table('room_detail_access')->where('room_id', $id)->get();  

        $room_access = \DB::table('room_detail_access')->where('room_id', $id)->get();

        $data = (object) [
        'amenitie_num'   => $amenitie_num,
        'room_detail'    => $room_detail,
        'room_access'    => $room_access,
        'room_detail_slider'    => $room_detail_slider,
        ];                            

        return $data;
    }


    // 部屋のidから情報を引き出す
    public function room_ranking()
    {
        // 部屋のidから部屋情報を引き出す
        $room_ranking = \DB::table('room')->join('room_ranking', 'room.id', '=', 'room_ranking.room_id')
                                            ->select('room.*', 'room_ranking.*')
                                            ->orderBy('ranking_id','asc')
                                            ->get();

        
        return $room_ranking;
    }






}      