<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mail_config_Model extends Model
{
    use HasFactory;



    public function mail_config()
    {

        $data = \DB::table('contact_mail_config')->first();
    
   
        return $data;
    }

    public function sub_reserve_mail_config()
    {

        $data = \DB::table('sub_reserve_mail_config')->first();
    
   
        return $data;
    }


    // 確認メールの情報を予約に確認をする
    public function sub_reserve_mail_add($request)
    {

        // 部屋id_情報とメール情報を追加
        $data = \DB::table('sub_reserve_mail')->insertGetId([ 
                        'mail' => $request->input('email'), 
                        'name' => $request->input('user_name'),
                        'room_id' => $request->input('room_id'), 
                    
                    ]);   
        return $data;
    }

    // 確認メールの情報を１レコード削除する
    public function sub_reserve_mail_delete($id)
    {
        // sub_reserve_mail_addで追加したカラムを当該関数で削除する
        \DB::table('sub_reserve_mail_config')->where("id", $id)->delete();
    
    }





}
