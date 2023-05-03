<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use App\Mail\Admin_Stay_Cancel_Mail;
use App\Mail\Admin_Time_Cancel_Mail;



class Customer_Cancel_Controller extends Controller
{
    
    // 
    public function customercancel_stay() {

        return view('customercancel_stay');
    }

    public function customercancel_cheak(Request $request, $reserve ) 
    {

        // 予約番号を検索
        $reserve_num = \DB::table('reservation_num')->where('num', $request->reservation_num)->first();

        // 予約番号はある？
        if(is_null($reserve_num))
        {
            $error_message = "予約番号が間違っているか、存在しません。";
            
            if($reserve == "time")
            {
                return view('customercancel_time', ['error_message'=>$error_message]);
            }else if($reserve == "stay")
            {
                return view('customercancel_stay', ['error_message'=>$error_message]);
            }
        }

        if($reserve == "time")
        {

            
            // 生成されたクエリを取得
            $get_query1 = \DB::table('reservation_time')->where('reservation_id', $reserve_num->id)->where('role', 2)->first();

            $room_id = $get_query1->room_id;

            $room = \DB::table('room')->where('id', $room_id)->first();

            $room_name = \DB::table('room')->where('id', $room_id)->value('title');

            // 料金算定のため時間差を出す
            $differ = (strtotime('2021-10-23 '.$get_query1->end_time.':00') - strtotime('2021-10-23 '.$get_query1->start_time.':00')) / 3600;

            // DBから対象の部屋の料金を参照する     
            $price = \DB::table('room')->where('id', $room_id)->value('h_price');

            $pay = $room->h_price * $differ;

            return view('cancel_time_check',  ['get_query1'=>$get_query1, 'pay'=>$pay, 'reserve_num'=>$reserve_num->num, 'room_name'=>$room_name]);

        }else if($reserve == "stay")
        {
            // 泊まりの予約情報を参照する
            $get_query1 = \DB::table('reservation_stay')->where('reservation_id', $reserve_num->id)->where('role', 2)->first();  

            $room_id = $get_query1->room_id;

            $room_name = \DB::table('room')->where('id', $room_id)->value('title');

            // 連泊数を数える
            $total = \DB::table('reservation_stay')->where('reservation_id', $reserve_num->id)->where('role', 2)->count();

            $price = \DB::table('room')->where('id', $room_id)->value('day_price');
            
            $pay = $price * $total;

            return view('cancel_stay_check',  ['get_query1'=>$get_query1, 'pay'=>$pay, 'total'=>$total, 'reserve_num'=>$reserve_num->num, 'room_name'=>$room_name]);
        }
        
        
    }

    public function customercancel_done_stay(Request $request) 
    {
        // 予約番号を検索
        $reserve_num = \DB::table('reservation_num')->where('num', $request->reservation_num)->first();


        // 泊まりの予約情報を参照する
        $get_query1 = \DB::table('reservation_stay')->where('reservation_id', $reserve_num->id)->where('role', 2)->first();  

        $room_id = $get_query1->room_id;

        // 連泊数を数える
        $total = \DB::table('reservation_stay')->where('reservation_id', $reserve_num->id)->where('role', 2)->count();

        $room = \DB::table('room')->where('id', $room_id)->first();
        $price = $room->day_price;
        
        $money = $price * $total;
        
        // 外部キー予約ID
        \DB::table('reservation_stay')->where('reservation_id', $request->reservation_num)
                                      ->where('role', 2)                              
                                      ->delete();  

        \DB::table('reservation_num')->where('id', $request->reservation_num)->delete();  
    
        $admin = \DB::table('contact_mail_config')->first();
        
        $admin_to = [
            [
                'email' => $admin->from_mail,
                'name' => $admin->name,
            ]
        ];



        Mail::to($admin_to)->send(new Admin_Stay_Cancel_Mail($reserve_num->num, 
                                                             $get_query1->name, 
                                                             $room->stay_name,
                                                             $get_query1->date, 
                                                             $get_query1->checkin_time,
                                                             $total, 
                                                             $money, 
                                                             $room_id, 
                                                             $get_query1->image_front,
                                                             $get_query1->image_back, 
                                                             $get_query1->card_brand, 
                                                             $get_query1->last4, 
                                                             $get_query1->accept_num));

        // reservation_stayとreservation_numのテーブルから予約番号と一致するものを削除する
        \DB::table('reservation_stay')->where('reservation_id', $reserve_num->id)->delete();
        \DB::table('reservation_num')->where('num', $request->reservation_num)->delete();

        return view('customercancel_done');
    }


    public function customercancel_done_time(Request $request) 
    {
        // 予約番号を検索
        $reserve_num = \DB::table('reservation_num')->where('num', $request->reservation_num)->first();

        // 泊まりの予約情報を参照する
        $get_query1 = \DB::table('reservation_time')->where('reservation_id', $reserve_num->id)->where('role', 2)->first(); 

        $room_id = $get_query1->room_id;
        $room = \DB::table('room')->where('id', $room_id)->first();

        $price = $room->h_price;
        $start = $get_query1->start_time;
        $end = $get_query1->end_time;

        $differ = (strtotime('2021-11-01 '.$end.':00') - strtotime('2021-11-01 '.$start.':00')) / 3600;
        
        $money = $price * $differ;

        // 外部キー予約ID
        \DB::table('reservation_time')->where('reservation_id', $request->reservation_num)
                                      ->where('role', 2)                              
                                      ->delete();  

        \DB::table('reservation_num')->where('id', $request->reservation_num)->delete();  
     
        // 管理者にも確認のメールを飛ばす
        $admin = \DB::table('contact_mail_config')->first();

        

        $admin_to = [
            [
                'email' => $admin->from_mail,
                'name' => $admin->name,
            ]
        ];
        
        Mail::to($admin_to)->send(new Admin_Time_Cancel_Mail($reserve_num->num, 
                                                            $get_query1->name, 
                                                            $room->stay_name,
                                                            $get_query1->date, 
                                                            $get_query1->start_time, 
                                                            $get_query1->end_time, 
                                                            $money, 
                                                            $room_id, 
                                                            $get_query1->image_front, 
                                                            $get_query1->image_back,
                                                            $get_query1->card_brand, 
                                                            $get_query1->last4, 
                                                            $get_query1->accept_num));

        // reservation_timeとreservation_numのテーブルから予約番号と一致するものを削除する
        \DB::table('reservation_time')->where('reservation_id', $reserve_num->id)->delete();
        \DB::table('reservation_num')->where('num', $request->reservation_num)->delete();

        return view('customercancel_done');
    }


}
