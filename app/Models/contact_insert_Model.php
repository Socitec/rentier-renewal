<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contact_insert_Model extends Model
{
    use HasFactory;

    // サイトに関するお問い合わせの情報を追加する
    public function contact_insert($request)
    {

        $data = \DB::table('contact')->insert([
            'message' => $request->message,                        // メッセージの内容
            'email' =>  $request->enail,                           // eメール
            'tel' => $request->tel,                                // 電話番号
            'contact_category' => $request->contact_category,      // お問い合わせの項目   
        ]);

        return $data;
    }

    // 部屋に関するお問い合わせの情報を追加する
    public function room_contact_insert($data)
    {

        $data = \DB::table('room_contact')->insert([
            'room_id' => $request->id,                             // 部屋_idを紐づけさせる
            'message' => $request->message,                        // メッセージの内容
            'email' =>  $request->enail,                           // eメール
            'tel' => $request->tel,                                // 電話番号
            'contact_category' => $request->contact_category,      // お問い合わせの項目   
        ]);

        return $data;
    }

}
