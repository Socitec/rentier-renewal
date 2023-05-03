<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reservation_insert_Model extends Model
{
    use HasFactory;

    // 宿泊者情報を追加する
    public function reservation_stay_insert($request)
    {
        $data = \DB::table('reservation_stay')->insert([
            'room_id' => $request->id,                     // 部屋_idを紐づけさせる
            'name' => $request->name,                      // メッセージの内容
            'email' =>  $request->enail,                   // eメール
            'tel' => $request->tel,                        // 電話番号
            'checkin_time' => $request->checkin_time,      // チェックイン時間
            'date' => $request->date,                      // お問い合わせの項目   
            
        ]);

    }

    // 時間貸し情報を追加する
    public function reservation_time_insert($request)
    {
        $data = \DB::table('reservation_time')->insert([
            'room_id' => $request->id,                     // 部屋_idを紐づけさせる
            'name' => $request->name,                      // メッセージの内容
            'email' =>  $request->enail,                   // eメール
            'tel' => $request->tel,                        // 電話番号
            'start_time' => $request->start_time,          // 開始時間
            'end_time' => $request->start_time,            // 終了時間
            'date' => $request->date,                      // 宿泊する日付 
        ]);
    }

}
