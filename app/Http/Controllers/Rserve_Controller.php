<?php

namespace App\Http\Controllers;

use App\Services\SquareService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Libs\Rserveidcardcheck;

use Mail;
use Validator;
use App\Models\calendar_Logic;
use App\Mail\Reserve_Stay_Confirm_Mail;
use App\Mail\Reserve_Time_Confirm_Mail;
use App\Mail\Admin_Stay_Notice_Mail;
use App\Mail\Admin_Time_Notice_Mail;


class Rserve_Controller extends Controller
{



    
    //
    // 部屋予約お問い合わせ作成ページへ遷移_宿泊
    public function stay_reseve(Request $request) 
    {
        // 日本の標準時に設定
        date_default_timezone_set('Asia/Tokyo');

        if (!$request->hasValidSignature()) {
            return view('401');
        }

        $room_id = $request->input("room_id");
        $add_data_id = $request->input("add_data_id");

        // データが作られてから本登録されずに24時間以上経過したデータを消す処理
        $now = date('Y-m-d H:i:s');
        $del = \DB::table('reservation_stay')
                ->where('room_id', $room_id)
                ->where('role', '<=', '1')
                ->get();
        foreach ($del as $d){
            if (strtotime($now)-strtotime($d->create_at)>86400){
                // 該当するレコードを削除
                \DB::table('reservation_stay')
                        ->where('id', $d->id)
                        ->delete();
            }
        }

        // role=1又はrole=2の時確認画面や確定画面へと遷移させる
        $search_name = \DB::table('sub_reserve_mail')
                    ->where('id', $add_data_id)
                    ->value('name');
        $search_mail = \DB::table('sub_reserve_mail')
                    ->where('id', $add_data_id)
                    ->value('mail');
        // role1があるかどうか
        $role1 = \DB::table('reservation_stay')
                ->where('room_id', $room_id)
                ->where('name', $search_name)
                ->where('email', $search_mail)
                ->where('serial_num', $add_data_id)
                ->where('role', 1)
                ->exists();
        // role2があるかどうか
        $role2 = \DB::table('reservation_stay')
                ->where('room_id', $room_id)
                ->where('name', $search_name)
                ->where('email', $search_mail)
                ->where('serial_num', $add_data_id)
                ->where('role', 2)
                ->exists();

        // role2があったら完了画面に遷移、role1があったら確認画面に遷移
        if ($role2 == true) {
            // 完了画面を返す
            $err_message = "既に予約は完了しております。ブラウザを閉じてメールをご確認ください。";
            return view('rooms_reservation_comp', ["err_message"=>$err_message]);
        } elseif ($role1 == true){
            // 確認画面を返す
            $get_query1 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $search_name)
                        ->where('email', $search_mail)
                        ->where('serial_num', $add_data_id)
                        ->where('role', 1)
                        ->first();
            $total = \DB::table('reservation_stay')
                    ->where('room_id', $room_id)
                    ->where('name', $search_name)
                    ->where('email', $search_mail)
                    ->where('serial_num', $add_data_id)
                    ->where('role', 1)
                    ->count();
            $room_price_stay = \DB::table('room')
                            ->where('id', $room_id)
                            ->value('day_price');
            $pay = $total * $room_price_stay;
            return view('rooms_reserve_stay_preview', ['get_query1'=>$get_query1, 'pay'=>$pay, 'total'=>$total, 'room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'name'=>$search_name, 'mail'=>$search_mail]);
        }

        $today = date('Y-m-d');
        $c = new calendar_Logic();
        $calendars = $c->reservation_calendar_get($today, $room_id);

        // 料金を計算してリアルタイムに出力するための処理
        $room_price = \DB::table('room')
                        ->where('id', $room_id)
                        ->value('day_price');

        return view('rooms_reserve_stay')->with([
            "room_id"  => $room_id,
            "sub_id"  => $add_data_id,            
            "calendars" => $calendars,
            "room_price" => $room_price,
            "name" => $search_name,
            "mail" => $search_mail,
        ]);         

    }

    // 部屋予約お問い合わせ作成ページへ遷移_時間
    public function time_rserve(Request $request)
    {
        // 日本の標準時に設定
        date_default_timezone_set('Asia/Tokyo');

        if (!$request->hasValidSignature()) {
            return view('401');
        }

        $room_id = $request->input("room_id");
        $add_data_id = $request->input("add_data_id");

        // データが作られてから本登録されずに24時間以上経過したデータを消す処理
        $now = date('Y-m-d H:i:s');
        $del = \DB::table('reservation_time')
                ->where('room_id', $room_id)
                ->where('role', '<=', '1')
                ->get();
        foreach ($del as $d){
            if (strtotime($now)-strtotime($d->create_at)>86400){
                // 該当するレコードを削除
                \DB::table('reservation_time')
                        ->where('id', $d->id)
                        ->delete();
            }
        }

        // role=1又はrole=2の時確認画面や確定画面へと遷移させる
        $search_name = \DB::table('sub_reserve_mail')
                    ->where('id', $add_data_id)
                    ->value('name');
        $search_mail = \DB::table('sub_reserve_mail')
                    ->where('id', $add_data_id)
                    ->value('mail');
        // role1があるかどうか
        $role1 = \DB::table('reservation_time')
                ->where('room_id', $room_id)
                ->where('name', $search_name)
                ->where('email', $search_mail)
                ->where('serial_num', $add_data_id)
                ->where('role', 1)
                ->exists();
        // role2があるかどうか
        $role2 = \DB::table('reservation_time')
                ->where('room_id', $room_id)
                ->where('name', $search_name)
                ->where('email', $search_mail)
                ->where('serial_num', $add_data_id)
                ->where('role', 2)
                ->exists();

        // role2があったら完了画面に遷移、role1があったら確認画面に遷移
        if ($role2 == true) {
            // 完了画面を返す
            $err_message = "既に予約は完了しております。ブラウザを閉じてメールをご確認ください。";
            return view('rooms_reservation_comp', ["err_message"=>$err_message]);
        } elseif ($role1 == true){
            // 確認画面を返す
            $get_query1 = \DB::table('reservation_time')
                        ->where('room_id', $room_id)
                        ->where('name', $search_name)
                        ->where('email', $search_mail)
                        ->where('serial_num', $add_data_id)
                        ->where('role', 1)
                        ->first();
            $start = '2021-10-18 '.$get_query1->start_time.':00';
            $end = '2021-10-18'.$get_query1->end_time.':00';
            $differ = (strtotime($end) - strtotime($start)) / 3600;
            $room_price_time = \DB::table('room')
                            ->where('id', $room_id)
                            ->value('h_price');
            $pay = $differ * $room_price_time;
            return view('rooms_reserve_time_preview', ['get_query1'=>$get_query1, 'pay'=>$pay, 'room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'name'=>$search_name, 'mail'=>$search_mail]);
        }

        $today = date('Y-m-d');
        $c = new calendar_Logic();
        $calendars = $c->reservation_calendar_get($today, $room_id);

        // 料金を計算してリアルタイムに出力するための処理
        $room_price = \DB::table('room')
                        ->where('id', $room_id)
                        ->value('h_price');

        return view('rooms_reserve_time')->with([
            "room_id"  => $room_id,
            "sub_id"  => $add_data_id,
            "calendars" => $calendars,
            "room_price" => $room_price,
            "name" => $search_name,
            "mail" => $search_mail,              
        ]);         

    }

    // 部屋予約確認ページへ遷移(宿泊)
    public function stay_reseve_send(Request $request, $room_id, $add_data_id) 
    {
        // 日本の標準時に設定
        date_default_timezone_set('Asia/Tokyo');

        // 仮予約がある場合問答無用でそちらを表示する(確認画面から戻るを押して再度確認ボタンを押された時の対策)
        $pre_save_search = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('serial_num', $add_data_id)
                        ->where('role', 1)
                        ->exists();
        if ($pre_save_search==true) {
            return view('alert');
        }

        $id_card_check = new Rserveidcardcheck();
        $date = date('Y-m-d');
    
        
        // バリデーションルールを設定する
        $rulus = [
            'name' => 'required | string | max:100',
            'email' => 'email | max:50',
            'tel' => 'required | numeric | digits_between:8,11',
            'date' => 'required',
            'checkin_time' => 'required | max:20',
            'room_id' => 'required',
          ];

        // バリデーションの独自メッセージを設定する
        $message = [
            'name.required' => '名前は必須項目です。',
            'name.max' => '名前は100文字以内で入力してください。',
            'email.email'  => 'Emailには、有効なメールアドレスを指定してください。',
            'email.max' => 'Emailは、50文字以内で入力してください。',
            'tel.required' => '電話番号は必須項目です。',
            'tel.numeric' => '電話番号は8桁から11桁の間で指定してください',
            'date.required' => '予約日は必須項目です。',
            'checkin_time.required' => 'チェックイン時間は必須項目です。',
            'checkin_time.max' => 'チェックイン時間は20文字以内で入力してください。',
            'room_id.required' => 'システムエラー',
        ];

        $validator = Validator::make($request->all(), $rulus, $message);

        // エラーがおきていたらリダイレクトする。
        if($validator->fails())
        {
            return redirect()->route('roomsreserve_stay', ['date'=>$date, 'room_id'=>$room_id, 'add_data_id'=>$add_data_id, "name"=>$request->name, "mail"=>$request->email])
            ->withErrors($validator)
            ->withInput();
        }

        // 料金を計算するための処理
        $room_price = \DB::table('room')
                        ->where('id', $room_id)
                        ->value('day_price');

        // まずはリクエストパラメータの値を元にして今月、来月、再来月の基礎情報を読み取る
        $base_month = date('Y-m-d');
        $this_month = date('Y-m-d', strtotime('first day of'.$base_month));
        $next_month = date('Y-m-d', strtotime($this_month.'+1 month'));
        $next_month2 = date('Y-m-d', strtotime($this_month.'+2 month'));
        $get_this_month = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('key_day', $this_month)
                        ->where('role', 0)
                        ->orderBy('id', 'desc')
                        ->first();
        $get_next_month = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('key_day', $next_month)
                        ->where('role', 0)
                        ->orderBy('id', 'desc')
                        ->first();
        $get_next_month2 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('key_day', $next_month2)
                        ->where('role', 0)
                        ->orderBy('id', 'desc')
                        ->first();

        // もし上記の3つのクエリが存在しない場合はリクエストパラメータを用いていきなり保存処理を行う
        if (isset($get_this_month)==false&&isset($get_next_month)==false&&isset($get_next_month2)==false) {
            // 値はリクエストパラメータで決める
            $start1 = $request->date;
            $l_start1 = strlen($start1);
            $diff1 = $l_start1 - 2;
            $num1 = $request->stay_date_num;
            $st1 = substr($start1, -2);
            $st1_1 = substr($start1, 0, $diff1);
            for($a = $st1; $a < $num1 + $st1; $a++){
                \DB::table('reservation_stay')->insert([
                    'room_id' => $room_id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'tel' => $request->tel,
                    'checkin_time' => $request->checkin_time,
                    'date' => $st1_1.$a,
                    'role' => 1,
                    'stay_date_num' => $request->stay_date_num,
                    'serial_num' => $add_data_id,
                    'stay_people' => $request->stay_people,
                ]);
            }
            $test=\DB::table('reservation_stay')
                    ->where('room_id', $room_id)
                    ->where('name', $request->name)
                    ->get();
            // roleが0となっているクエリを全て消去
            $delete = \DB::table('reservation_stay')
                    ->where('room_id', $room_id)
                    ->where('name', $request->name)
                    ->where('email', $request->email)
                    ->where('role', 0)
                    ->delete();
            // 確認画面に反映させるために先頭のクエリを取得
            $get_query1 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('role', 1)
                        ->first();
            $total = $get_query1->stay_date_num;
            $pay = $room_price * $total;
            return view('rooms_reserve_stay_preview', ['get_query1'=>$get_query1, 'pay'=>$pay, 'total'=>$total, 'room_id'=>$room_id, 'add_data_id'=>$add_data_id, "name"=>$request->name, "mail"=>$request->email]);
        }

        // それぞれのクエリについて利用開始日と宿泊日数から月末まで利用しているかどうかを確認
        $base = date('Y-m-d');
        $month1 = date('Y-m-d', strtotime('first day of'.$base));
        $month2 = date('Y-m', strtotime($month1.'+1 month'));
        $month3 = date('Y-m', strtotime($month1.'+2 month'));
        // 今月末
        if ($get_this_month != null) {
            $e1 = $get_this_month->date;
            $end_date1 = date('Y-m-d', strtotime('last day of'.$e1));
        } else {
            $end_date1 = null;
        }
        $end_date1_1 = date('Y-m-d', strtotime('last day of'.$month1));
        if ($end_date1 == $end_date1_1) {
            $judge1 = true;
        } else {
            $judge1 = false;
        }
        // 来月月初
        if ($get_next_month != null) {
            $start_date1 = $get_next_month->date;
        } else {
            $start_date1 = date('Y-m-d', strtotime('first day of'.$month2));
        }
        $start_date1_1 = date('Y-m-d', strtotime('first day of'.$month2));
        if ($start_date1 == $start_date1_1) {
            $judge2 = true;
        } else {
            $judge2 = false;
        }
        // 来月末
        if ($get_next_month != null) {
            $e2 = $get_next_month->date;
            $end_date2 = date('Y-m-d', strtotime('last day of'.$e2));
        } else {
            $end_date2 = null;
        }
        $end_date2_1 = date('Y-m-d', strtotime('last day of'.$month2));
        if ($end_date2 == $end_date2_1) {
            $judge3 = true;
        } else {
            $judge3 = false;
        }
        // 再来月月初
        if ($get_next_month2 != null) {
            $start_date2 = $get_next_month2->date;
        } else {
            $start_date2 = date('Y-m-d', strtotime('first day of'.$month3));
        }
        $start_date2_1 = date('Y-m-d', strtotime('first day of'.$month3));
        if ($start_date2 == $start_date2_1) {
            $judge4 = true;
        } else {
            $judge4 = false;
        }

        // echo('<pre>');
        // var_dump($judge1);
        // var_dump($judge2);
        // var_dump($judge3);
        // var_dump($judge4);
        // var_dump($judge1);
        // var_dump($judge2);
        // var_dump($judge3);
        // var_dump($judge4);
        // var_dump($judge1);
        // var_dump($judge2);
        // var_dump($judge3);
        // var_dump($judge4);
        // echo('</pre>');
        
        // 2カ月間月またぎをしている場合
        if ($judge1==true&&$judge2==true&&$judge3==true&&$judge4==true) {
            // それぞれの月について利用開始日から滞在日数分だけinsert
            // 今月の処理
            if (isset($get_this_month)) {
                $start1 = $get_this_month->date;
                $l_start1 = strlen($start1);
                $diff1 = $l_start1 - 2;
                $num1 = $get_this_month->stay_date_num;
                $end1 = date('Y-m-d', strtotime('last day of'.$month1));
                $end1_1 = substr($end1, -2);
                $st1 = substr($start1, -2);
                $st1_1 = substr($start1, 0, $diff1);
                for ($i = $st1; $i < $num1 + $st1; $i++) {
                    if ($i > $end1_1) {
                        break;
                    }
                    \DB::table('reservation_stay')->insert([
                        'room_id' => $room_id,
                        'name' => $request->name,
                        'email' => $request->email,
                        'tel' => $request->tel,
                        'checkin_time' => $request->checkin_time,
                        'date' => $st1_1.$i,
                        'role' => 1,
                        'key_day' => $this_month,
                        'stay_date_num' => $get_this_month->stay_date_num,
                        'serial_num' => $add_data_id,
                        'stay_people' => $request->stay_people,
                    ]);
                }
            }
            // 翌月の処理
            if (isset($get_next_month)) {
                $start2 = $get_next_month->date;
                $l_start2 = strlen($start2);
                $diff2 = $l_start2 - 2;
                $num2 = $get_next_month->stay_date_num;
                $end2 = date('Y-m-d', strtotime('last day of'.$month2));
                $end2_1 = substr($end2, -2);
                $st2 = substr($start2, -2);
                $st2_1 = substr($start2, 0, $diff2);
                for ($i = $st2; $i < $num2 + $st2; $i++) {
                    if ($i > $end2_1) {
                        break;
                    }
                    \DB::table('reservation_stay')->insert([
                        'room_id' => $room_id,
                        'name' => $request->name,
                        'email' => $request->email,
                        'tel' => $request->tel,
                        'checkin_time' => $request->checkin_time,
                        'date' => $st2_1.$i,
                        'role' => 1,
                        'key_day' => $next_month,
                        'stay_date_num' => $get_next_month->stay_date_num,
                        'serial_num' => $add_data_id,
                        'stay_people' => $request->stay_people,
                    ]);
                }
            }
            // 翌々月の処理
            if (isset($get_next_month2)) {
                $start3 = $get_next_month2->date;
                $l_start3 = strlen($start3);
                $diff3 = $l_start3 - 2;
                $num3 = $get_next_month2->stay_date_num;
                $end3 = date('Y-m-d', strtotime('last day of'.$month3));
                $end3_1 = substr($end3, -2);
                $st3 = substr($start3, -2);
                $st3_1 = substr($start3, 0, $diff3);
                for ($i = $st3; $i < $num3 + $st3; $i++) {
                    if ($i > $end3_1) {
                        break;
                    }
                    \DB::table('reservation_stay')->insert([
                        'room_id' => $room_id,
                        'name' => $request->name,
                        'email' => $request->email,
                        'tel' => $request->tel,
                        'checkin_time' => $request->checkin_time,
                        'date' => $st3_1.$i,
                        'role' => 1,
                        'key_day' => $next_month2,
                        'stay_date_num' => $get_next_month2->stay_date_num,
                        'serial_num' => $add_data_id,
                        'stay_people' => $request->stay_people,
                    ]);
                }
            } 
            // リクエストパラメータに応じた処理
            if (isset($get_this_month)==false||isset($get_next_month)==false||isset($get_next_month2)==false) {
                $start4 = $request->date;
                $l_start4 = strlen($start4);
                $diff4 = $l_start4 - 2;
                $st_month = date('Y-m', strtotime($start4));
                $st_month2 = '01';
                $st_month3 = $st_month.'-'.$st_month2;
                $num4 = $request->stay_date_num;
                $end4 = date('Y-m-d', strtotime('last day of'.$st_month));
                $end4_1 = substr($end4, -2);
                $st4 = substr($start4, -2);
                $st4_1 = substr($start4, 0, $diff4);
                for ($i = $st4; $i < $num4 + $st4; $i++) {
                    if ($i > $end4_1) {
                        break;
                    }
                    \DB::table('reservation_stay')->insert([
                        'room_id' => $room_id,
                        'name' => $request->name,
                        'email' => $request->email,
                        'tel' => $request->tel,
                        'checkin_time' => $request->checkin_time,
                        'date' => $st4_1.$i,
                        'role' => 1,
                        'key_day' => $st_month3,
                        'stay_date_num' => $request->stay_date_num,
                        'serial_num' => $add_data_id,
                        'stay_people' => $request->stay_people,
                    ]);
                }
            }
            // roleが0となっているクエリを全て消去
            $delete = \DB::table('reservation_stay')
                    ->where('room_id', $room_id)
                    ->where('name', $request->name)
                    ->where('email', $request->email)
                    ->where('role', 0)
                    ->delete();
            
            // 確認画面に反映させるために先頭のクエリを取得
            $get_query1 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('key_day', $this_month)
                        ->first();
            // 次に合計宿泊日数を計算するために各月毎のstay_date_numを出し、その合計値を求める
            $stay1 = \DB::table('reservation_stay')
                    ->where('room_id', $room_id)
                    ->where('name', $request->name)
                    ->where('email', $request->email)
                    ->where('key_day', $this_month)
                    ->value('stay_date_num');
            $stay2 = \DB::table('reservation_stay')
                    ->where('room_id', $room_id)
                    ->where('name', $request->name)
                    ->where('email', $request->email)
                    ->where('key_day', $next_month)
                    ->value('stay_date_num');
            $stay3 = \DB::table('reservation_stay')
                    ->where('room_id', $room_id)
                    ->where('name', $request->name)
                    ->where('email', $request->email)
                    ->where('key_day', $next_month2)
                    ->value('stay_date_num');
            $total = $stay1 + $stay2 + $stay3;
            $pay = $room_price * $total;
            return view('rooms_reserve_stay_preview', ['get_query1'=>$get_query1, 'pay'=>$pay, 'total'=>$total, 'room_id'=>$room_id, 'add_data_id'=>$add_data_id, "name"=>$request->name, "mail"=>$request->email]);
        }
        // 翌月と翌々月で月またぎしている場合(翌月の始め以外からスタート)
        elseif ($judge1==false&&$judge2==false&&$judge3==false&&$judge4==true) {
            // それぞれの月について利用開始日から滞在日数分だけinsert
            // 翌月の処理
            if (isset($get_next_month)) {
                $start1 = $get_next_month->date;
                $l_start1 = strlen($start1);
                $diff1 = $l_start1 - 2;
                $num1 = $get_next_month->stay_date_num;
                $end1 = date('Y-m-d', strtotime('last day of'.$month2));
                $end1_1 = substr($end1, -2);
                $st1 = substr($start1, -2);
                $st1_1 = substr($start1, 0, $diff1);
                for ($i = $st1; $i < $num1 + $st1; $i++) {
                    if ($i > $end1_1) {
                        break;
                    }
                    \DB::table('reservation_stay')->insert([
                        'room_id' => $room_id,
                        'name' => $request->name,
                        'email' => $request->email,
                        'tel' => $request->tel,
                        'checkin_time' => $request->checkin_time,
                        'date' => $st1_1.$i,
                        'role' => 1,
                        'key_day' => $next_month,
                        'stay_date_num' => $get_next_month->stay_date_num,
                        'serial_num' => $add_data_id,
                        'stay_people' => $request->stay_people,
                    ]);
                }
            }
            // 翌々月の処理
            if (isset($get_next_month2)) {
                $start2 = $get_next_month2->date;
                $l_start2 = strlen($start2);
                $diff2 = $l_start2 - 2;
                $num2 = $get_next_month2->stay_date_num;
                $end2 = date('Y-m-d', strtotime('last day of'.$month3));
                $end2_1 = substr($end2, -2);
                $st2 = substr($start2, -2);
                $st2_1 = substr($start2, 0, $diff2);
                for ($i = $st2; $i < $num2 + $st2; $i++) {
                    if ($i > $end2_1) {
                        break;
                    }
                    \DB::table('reservation_stay')->insert([
                        'room_id' => $room_id,
                        'name' => $request->name,
                        'email' => $request->email,
                        'tel' => $request->tel,
                        'checkin_time' => $request->checkin_time,
                        'date' => $st2_1.$i,
                        'role' => 1,
                        'key_day' => $next_month2,
                        'stay_date_num' => $get_next_month2->stay_date_num,
                        'serial_num' => $add_data_id,
                        'stay_people' => $request->stay_people,
                    ]);
                }
            }
            // リクエストパラメータに応じた処理
            if (isset($get_next_month)==false||isset($get_next_month2)==false) {
                $start3 = $request->date;
                $l_start3 = strlen($start3);
                $diff3 = $l_start3 - 2;
                $st_month = date('Y-m', strtotime($start3));
                $st_month2 = '01';
                $st_month3 = $st_month.'-'.$st_month2;
                $num3 = $request->stay_date_num;
                $end3 = date('Y-m-d', strtotime('last day of'.$st_month));
                $end3_1 = substr($end3, -2);
                $st3 = substr($start3, -2);
                $st3_1 = substr($start3, 0, $diff3);
                for ($i = $st3; $i < $num3 + $st3; $i++) {
                    if ($i > $end3_1) {
                        break;
                    }
                    \DB::table('reservation_stay')->insert([
                        'room_id' => $room_id,
                        'name' => $request->name,
                        'email' => $request->email,
                        'tel' => $request->tel,
                        'checkin_time' => $request->checkin_time,
                        'date' => $st3_1.$i,
                        'role' => 1,
                        'key_day' => $st_month3,
                        'stay_date_num' => $request->stay_date_num,
                        'serial_num' => $add_data_id,
                        'stay_people' => $request->stay_people,
                    ]);
                }
            }
            // roleが0となっているクエリを全て消去
            $delete = \DB::table('reservation_stay')
                    ->where('room_id', $room_id)
                    ->where('name', $request->name)
                    ->where('email', $request->email)
                    ->where('role', 0)
                    ->delete();
            
            // 確認画面に反映させるために先頭のクエリを取得(今月のものが先頭に来る)
            $get_query1 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('key_day', $next_month)
                        ->first();
            // 次に合計宿泊日数を計算するために各月毎のstay_date_numを出し、その合計値を求める
            $stay1 = \DB::table('reservation_stay')
                    ->where('room_id', $room_id)
                    ->where('name', $request->name)
                    ->where('email', $request->email)
                    ->where('key_day', $next_month)
                    ->value('stay_date_num');
            $stay2 = \DB::table('reservation_stay')
                    ->where('room_id', $room_id)
                    ->where('name', $request->name)
                    ->where('email', $request->email)
                    ->where('key_day', $next_month2)
                    ->value('stay_date_num');
            $total = $stay1 + $stay2;
            $pay = $room_price * $total;
            return view('rooms_reserve_stay_preview', ['get_query1'=>$get_query1, 'pay'=>$pay, 'total'=>$total, 'room_id'=>$room_id, 'add_data_id'=>$add_data_id, "name"=>$request->name, "mail"=>$request->email]);
        }
        // 翌月と翌々月で月またぎしている場合(翌月の始めからスタート)
        elseif ($judge1==false&&$judge2==true&&$judge3==true&&$judge4==true) {
            // それぞれの月について利用開始日から滞在日数分だけinsert
            // 翌月の処理
            if (isset($get_next_month)) {
                $start1 = $get_next_month->date;
                $l_start1 = strlen($start1);
                $diff1 = $l_start1 - 2;
                $num1 = $get_next_month->stay_date_num;
                $end1 = date('Y-m-d', strtotime('last day of'.$month1));
                $end1_1 = substr($end1, -2);
                $st1 = substr($start1, -2);
                $st1_1 = substr($start1, 0, $diff1);
                for ($i = $st1; $i < $num1 + $st1; $i++) {
                    if ($i > $end1_1) {
                        break;
                    }
                    \DB::table('reservation_stay')->insert([
                        'room_id' => $room_id,
                        'name' => $request->name,
                        'email' => $request->email,
                        'tel' => $request->tel,
                        'checkin_time' => $request->checkin_time,
                        'date' => $st1_1.$i,
                        'role' => 1,
                        'key_day' => $next_month,
                        'stay_date_num' => $get_next_month->stay_date_num,
                        'serial_num' => $add_data_id,
                        'stay_people' => $request->stay_people,
                    ]);
                }
            }
            // 翌々月の処理
            if (isset($get_next_month2)) {
                $start2 = $get_next_month2->date;
                $l_start2 = strlen($start2);
                $diff2 = $l_start2 - 2;
                $num2 = $get_next_month2->stay_date_num;
                $end2 = date('Y-m-d', strtotime('last day of'.$month2));
                $end2_1 = substr($end2, -2);
                $st2 = substr($start2, -2);
                $st2_1 = substr($start2, 0, $diff2);
                for ($i = $st2; $i < $num2 + $st2; $i++) {
                    if ($i > $end2_1) {
                        break;
                    }
                    \DB::table('reservation_stay')->insert([
                        'room_id' => $room_id,
                        'name' => $request->name,
                        'email' => $request->email,
                        'tel' => $request->tel,
                        'checkin_time' => $request->checkin_time,
                        'date' => $st2_1.$i,
                        'role' => 1,
                        'key_day' => $next_month2,
                        'stay_date_num' => $get_next_month2->stay_date_num,
                        'serial_num' => $add_data_id,
                        'stay_people' => $request->stay_people,
                    ]);
                }
            }
            // リクエストパラメータに応じた処理
            $start3 = $request->date;
            $l_start3 = strlen($start3);
            $diff3 = $l_start3 - 2;
            $st_month = date('Y-m', strtotime($start3));
            $st_month2 = '01';
            $st_month3 = $st_month.'-'.$st_month2;
            $num3 = $request->stay_date_num;
            $end3 = date('Y-m-d', strtotime('last day of'.$st_month));
            $end3_1 = substr($end3, -2);
            $st3 = substr($start3, -2);
            $st3_1 = substr($start3, 0, $diff3);
            for ($i = $st3; $i < $num3 + $st3; $i++) {
                if ($i > $end3_1) {
                    break;
                }
                \DB::table('reservation_stay')->insert([
                    'room_id' => $room_id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'tel' => $request->tel,
                    'checkin_time' => $request->checkin_time,
                    'date' => $st3_1.$i,
                    'role' => 1,
                    'key_day' => $st_month3,
                    'stay_date_num' => $request->stay_date_num,
                    'serial_num' => $add_data_id,
                    'stay_people' => $request->stay_people,
                ]);
            }
            // roleが0となっているクエリを全て消去
            $delete = \DB::table('reservation_stay')
                    ->where('room_id', $room_id)
                    ->where('name', $request->name)
                    ->where('email', $request->email)
                    ->where('role', 0)
                    ->delete();
            
            // 確認画面に反映させるために先頭のクエリを取得(今月のものが先頭に来る)
            $exists_check = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('key_day', $this_month)
                        ->exists();
            if ($exists_check==true) {
                $get_query1 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('key_day', $this_month)
                        ->first();
                // 次に合計宿泊日数を計算するために各月毎のstay_date_numを出し、その合計値を求める
                $stay1 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('key_day', $this_month)
                        ->value('stay_date_num');
                $stay2 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('key_day', $next_month)
                        ->value('stay_date_num');
                $total = $stay1 + $stay2;
                $pay = $room_price * $total;
            } else {
                $get_query1 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('key_day', $next_month)
                        ->first();
                // 次に合計宿泊日数を計算するために各月毎のstay_date_numを出し、その合計値を求める
                $stay1 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('key_day', $next_month)
                        ->value('stay_date_num');
                $stay2 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('key_day', $next_month2)
                        ->value('stay_date_num');
                $total = $stay1 + $stay2;
                $pay = $room_price * $total;
            }
            return view('rooms_reserve_stay_preview', ['get_query1'=>$get_query1, 'pay'=>$pay, 'total'=>$total, 'room_id'=>$room_id, 'add_data_id'=>$add_data_id, "name"=>$request->name, "mail"=>$request->email]);
        }
        // 翌月と翌々月で月またぎしている場合(翌月の始めからスタート)
        elseif ($judge1==false&&$judge2==false&&$judge3==true&&$judge4==true) {
            // それぞれの月について利用開始日から滞在日数分だけinsert
            // 翌月の処理
            if (isset($get_next_month)) {
                $start1 = $get_next_month->date;
                $l_start1 = strlen($start1);
                $diff1 = $l_start1 - 2;
                $num1 = $get_next_month->stay_date_num;
                $end1 = date('Y-m-d', strtotime('last day of'.$month1));
                $end1_1 = substr($end1, -2);
                $st1 = substr($start1, -2);
                $st1_1 = substr($start1, 0, $diff1);
                for ($i = $st1; $i < $num1 + $st1; $i++) {
                    if ($i > $end1_1) {
                        break;
                    }
                    \DB::table('reservation_stay')->insert([
                        'room_id' => $room_id,
                        'name' => $request->name,
                        'email' => $request->email,
                        'tel' => $request->tel,
                        'checkin_time' => $request->checkin_time,
                        'date' => $st1_1.$i,
                        'role' => 1,
                        'key_day' => $next_month,
                        'stay_date_num' => $get_next_month->stay_date_num,
                        'serial_num' => $add_data_id,
                        'stay_people' => $request->stay_people,
                    ]);
                }
            }
            // 翌々月の処理
            if (isset($get_next_month2)) {
                $start2 = $get_next_month2->date;
                $l_start2 = strlen($start2);
                $diff2 = $l_start2 - 2;
                $num2 = $get_next_month2->stay_date_num;
                $end2 = date('Y-m-d', strtotime('last day of'.$month2));
                $end2_1 = substr($end2, -2);
                $st2 = substr($start2, -2);
                $st2_1 = substr($start2, 0, $diff2);
                for ($i = $st2; $i < $num2 + $st2; $i++) {
                    if ($i > $end2_1) {
                        break;
                    }
                    \DB::table('reservation_stay')->insert([
                        'room_id' => $room_id,
                        'name' => $request->name,
                        'email' => $request->email,
                        'tel' => $request->tel,
                        'checkin_time' => $request->checkin_time,
                        'date' => $st2_1.$i,
                        'role' => 1,
                        'key_day' => $next_month2,
                        'stay_date_num' => $get_next_month2->stay_date_num,
                        'serial_num' => $add_data_id,
                        'stay_people' => $request->stay_people,
                    ]);
                }
            }
            // リクエストパラメータに応じた処理
            $start3 = $request->date;
            $l_start3 = strlen($start3);
            $diff3 = $l_start3 - 2;
            $st_month = date('Y-m', strtotime($start3));
            $st_month2 = '01';
            $st_month3 = $st_month.'-'.$st_month2;
            $num3 = $request->stay_date_num;
            $end3 = date('Y-m-d', strtotime('last day of'.$st_month));
            $end3_1 = substr($end3, -2);
            $st3 = substr($start3, -2);
            $st3_1 = substr($start3, 0, $diff3);
            for ($i = $st3; $i < $num3 + $st3; $i++) {
                if ($i > $end3_1) {
                    break;
                }
                \DB::table('reservation_stay')->insert([
                    'room_id' => $room_id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'tel' => $request->tel,
                    'checkin_time' => $request->checkin_time,
                    'date' => $st3_1.$i,
                    'role' => 1,
                    'key_day' => $st_month3,
                    'stay_date_num' => $request->stay_date_num,
                    'serial_num' => $add_data_id,
                    'stay_people' => $request->stay_people,
                ]);
            }
            // roleが0となっているクエリを全て消去
            $delete = \DB::table('reservation_stay')
                    ->where('room_id', $room_id)
                    ->where('name', $request->name)
                    ->where('email', $request->email)
                    ->where('role', 0)
                    ->delete();
            
            // 確認画面に反映させるために先頭のクエリを取得(今月のものが先頭に来る)
            $exists_check = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('key_day', $this_month)
                        ->exists();
            if ($exists_check==true) {
                $get_query1 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('key_day', $this_month)
                        ->first();
                // 次に合計宿泊日数を計算するために各月毎のstay_date_numを出し、その合計値を求める
                $stay1 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('key_day', $this_month)
                        ->value('stay_date_num');
                $stay2 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('key_day', $next_month)
                        ->value('stay_date_num');
                $total = $stay1 + $stay2;
                $pay = $room_price * $total;
            } else {
                $get_query1 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('key_day', $next_month)
                        ->first();
                // 次に合計宿泊日数を計算するために各月毎のstay_date_numを出し、その合計値を求める
                $stay1 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('key_day', $next_month)
                        ->value('stay_date_num');
                $stay2 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('key_day', $next_month2)
                        ->value('stay_date_num');
                $total = $stay1 + $stay2;
                $pay = $room_price * $total;
            }
            return view('rooms_reserve_stay_preview', ['get_query1'=>$get_query1, 'pay'=>$pay, 'total'=>$total, 'room_id'=>$room_id, 'add_data_id'=>$add_data_id, "name"=>$request->name, "mail"=>$request->email]);
        }
        // 今月のデータと翌月のリクエストパラメータがある場合
        elseif ($judge1==true&&$judge2==true&&$judge3==false&&$judge4==true) {
            // それぞれの月について利用開始日から滞在日数分だけinsert
            // 今月の処理
            if (isset($get_this_month)) {
                $start1 = $get_this_month->date;
                $l_start1 = strlen($start1);
                $diff1 = $l_start1 - 2;
                $num1 = $get_this_month->stay_date_num;
                $end1 = date('Y-m-d', strtotime('last day of'.$month1));
                $end1_1 = substr($end1, -2);
                $st1 = substr($start1, -2);
                $st1_1 = substr($start1, 0, $diff1);
                for ($i = $st1; $i < $num1 + $st1; $i++) {
                    if ($i > $end1_1) {
                        break;
                    }
                    \DB::table('reservation_stay')->insert([
                        'room_id' => $room_id,
                        'name' => $request->name,
                        'email' => $request->email,
                        'tel' => $request->tel,
                        'checkin_time' => $request->checkin_time,
                        'date' => $st1_1.$i,
                        'role' => 1,
                        'key_day' => $this_month,
                        'stay_date_num' => $get_this_month->stay_date_num,
                        'serial_num' => $add_data_id,
                        'stay_people' => $request->stay_people,
                    ]);
                }
            }
            // リクエストパラメータのdateの値に応じて処理を変える
            // dateの値が翌月月初だったら通常通りレコード作成を開始
            $next_month_first = date('Y-m-d', strtotime('first day of'.$month2));
            if ($next_month_first!=$request->date)
            {
                // リクエストパラメータのチェックインが月初出ない場合一度既に作られたクエリを消去
                \DB::table('reservation_stay')
                ->where('room_id', $room_id)
                ->where('name', $request->name)
                ->where('email', $request->email)
                ->where('role', 1)
                ->delete();
            }
            // リクエストパラメータに応じた処理
            $start3 = $request->date;
            $l_start3 = strlen($start3);
            $diff3 = $l_start3 - 2;
            $st_month = date('Y-m', strtotime($start3));
            $st_month2 = '01';
            $st_month3 = $st_month.'-'.$st_month2;
            $num3 = $request->stay_date_num;
            $end3 = date('Y-m-d', strtotime('last day of'.$st_month));
            $end3_1 = substr($end3, -2);
            $st3 = substr($start3, -2);
            $st3_1 = substr($start3, 0, $diff3);
            for ($i = $st3; $i < $num3 + $st3; $i++) {
                if ($i > $end3_1) {
                    break;
                }
                \DB::table('reservation_stay')->insert([
                    'room_id' => $room_id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'tel' => $request->tel,
                    'checkin_time' => $request->checkin_time,
                    'date' => $st3_1.$i,
                    'role' => 1,
                    'key_day' => $st_month3,
                    'stay_date_num' => $request->stay_date_num,
                    'serial_num' => $add_data_id,
                    'stay_people' => $request->stay_people,
                ]);
            }
            // roleが0となっているクエリを全て消去
            $delete = \DB::table('reservation_stay')
                    ->where('room_id', $room_id)
                    ->where('name', $request->name)
                    ->where('email', $request->email)
                    ->where('role', 0)
                    ->delete();

            // その後月またぎの予約かそうでないかで処理を分岐
            // role1の今月のクエリがあるか
            $query_exists = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('key_day', $this_month)
                        ->where('role', 1)
                        ->exists();
            
            if ($query_exists==true) {
                // 確認画面に反映させるために先頭のクエリを取得(今月のものが先頭に来る)
                $get_query1 = \DB::table('reservation_stay')
                            ->where('room_id', $room_id)
                            ->where('name', $request->name)
                            ->where('email', $request->email)
                            ->where('key_day', $this_month)
                            ->first();
                // 次に合計宿泊日数を計算するために各月毎のstay_date_numを出し、その合計値を求める
                $stay1 = \DB::table('reservation_stay')
                            ->where('room_id', $room_id)
                            ->where('name', $request->name)
                            ->where('email', $request->email)
                            ->where('key_day', $this_month)
                            ->value('stay_date_num');
                $stay2 = \DB::table('reservation_stay')
                            ->where('room_id', $room_id)
                            ->where('name', $request->name)
                            ->where('email', $request->email)
                            ->where('key_day', $next_month)
                            ->value('stay_date_num');
                $total = $stay1 + $stay2;
                $pay = $room_price * $total;
                return view('rooms_reserve_stay_preview', ['get_query1'=>$get_query1, 'pay'=>$pay, 'total'=>$total, 'room_id'=>$room_id, 'add_data_id'=>$add_data_id, "name"=>$request->name, "mail"=>$request->email]);
            } else {
                // 確認画面に反映させるために先頭のクエリを取得
                $get_query1 = \DB::table('reservation_stay')
                            ->where('room_id', $room_id)
                            ->where('name', $request->name)
                            ->where('email', $request->email)
                            ->where('role', 1)
                            ->first();
                $total = $get_query1->stay_date_num;
                $pay = $room_price * $total;
                return view('rooms_reserve_stay_preview', ['get_query1'=>$get_query1, 'pay'=>$pay, 'total'=>$total, 'room_id'=>$room_id, 'add_data_id'=>$add_data_id, "name"=>$request->name, "mail"=>$request->email]);
            }
        }
        // 翌月のデータと今月のリクエストパラメータがある場合(翌月のデータは月末まで行ってない)
        elseif ($judge1==false&&$judge2==true&&$judge3==true&&$judge4==true)
        {
            // それぞれの月について利用開始日から滞在日数分だけinsert
            // 翌月の処理
            if (isset($get_next_month)) {
                $start1 = $get_next_month->date;
                $l_start1 = strlen($start1);
                $diff1 = $l_start1 - 2;
                $num1 = $get_next_month->stay_date_num;
                $end1 = date('Y-m-d', strtotime('last day of'.$month2));
                $end1_1 = substr($end1, -2);
                $st1 = substr($start1, -2);
                $st1_1 = substr($start1, 0, $diff1);
                for ($i = $st1; $i < $num1 + $st1; $i++) {
                    if ($i > $end1_1) {
                        break;
                    }
                    \DB::table('reservation_stay')->insert([
                        'room_id' => $room_id,
                        'name' => $request->name,
                        'email' => $request->email,
                        'tel' => $request->tel,
                        'checkin_time' => $request->checkin_time,
                        'date' => $st1_1.$i,
                        'role' => 1,
                        'key_day' => $next_month,
                        'stay_date_num' => $get_next_month->stay_date_num,
                        'serial_num' => $add_data_id,
                        'stay_people' => $request->stay_people,
                    ]);
                }
            }
            // リクエストパラメータのdateの値に応じて処理を変える
            // dateの値と宿泊日数からその月にいつまで泊まるかを出し、月末だったら通常通りレコード作成を開始
            $num = $request->stay_date_num - 1;
            $last_date = date('Y-m-d', strtotime($request->date.'+'.$num.' day'));
            $this_month_last = date('Y-m-d', strtotime('last day of'.$month1));
            if ($this_month_last!=$last_date)
            {
                // リクエストパラメータが月末出ない場合一度既に作られたクエリを消去
                \DB::table('reservation_stay')
                ->where('room_id', $room_id)
                ->where('name', $request->name)
                ->where('email', $request->email)
                ->where('role', 1)
                ->delete();
            }
            // リクエストパラメータに応じた処理
            $start3 = $request->date;
            $l_start3 = strlen($start3);
            $diff3 = $l_start3 - 2;
            $st_month = date('Y-m', strtotime($start3));
            $st_month2 = '01';
            $st_month3 = $st_month.'-'.$st_month2;
            $num3 = $request->stay_date_num;
            $end3 = date('Y-m-d', strtotime('last day of'.$st_month));
            $end3_1 = substr($end3, -2);
            $st3 = substr($start3, -2);
            $st3_1 = substr($start3, 0, $diff3);
            for ($i = $st3; $i < $num3 + $st3; $i++) {
                if ($i > $end3_1) {
                    break;
                }
                \DB::table('reservation_stay')->insert([
                    'room_id' => $room_id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'tel' => $request->tel,
                    'checkin_time' => $request->checkin_time,
                    'date' => $st3_1.$i,
                    'role' => 1,
                    'key_day' => $st_month3,
                    'stay_date_num' => $request->stay_date_num,
                    'serial_num' => $add_data_id,
                    'stay_people' => $request->stay_people,
                ]);
            }
            // roleが0となっているクエリを全て消去
            $delete = \DB::table('reservation_stay')
                    ->where('room_id', $room_id)
                    ->where('name', $request->name)
                    ->where('email', $request->email)
                    ->where('role', 0)
                    ->delete();

            // その後月またぎの予約かそうでないかで処理を分岐
            // role1の翌月のクエリがあるか
            $query_exists = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('key_day', $next_month)
                        ->where('role', 1)
                        ->exists();
            
            if ($query_exists==true) {
                // 確認画面に反映させるために先頭のクエリを取得(今月のものが先頭に来る)
                $get_query1 = \DB::table('reservation_stay')
                            ->where('room_id', $room_id)
                            ->where('name', $request->name)
                            ->where('email', $request->email)
                            ->where('key_day', $this_month)
                            ->first();
                // 次に合計宿泊日数を計算するために各月毎のstay_date_numを出し、その合計値を求める
                $stay1 = \DB::table('reservation_stay')
                            ->where('room_id', $room_id)
                            ->where('name', $request->name)
                            ->where('email', $request->email)
                            ->where('key_day', $this_month)
                            ->value('stay_date_num');
                $stay2 = \DB::table('reservation_stay')
                            ->where('room_id', $room_id)
                            ->where('name', $request->name)
                            ->where('email', $request->email)
                            ->where('key_day', $next_month)
                            ->value('stay_date_num');
                $total = $stay1 + $stay2;
                $pay = $room_price * $total;
                return view('rooms_reserve_stay_preview', ['get_query1'=>$get_query1, 'pay'=>$pay, 'total'=>$total, 'room_id'=>$room_id, 'add_data_id'=>$add_data_id, "name"=>$request->name, "mail"=>$request->email]);
            } else {
                // 確認画面に反映させるために先頭のクエリを取得
                $get_query1 = \DB::table('reservation_stay')
                            ->where('room_id', $room_id)
                            ->where('name', $request->name)
                            ->where('email', $request->email)
                            ->where('role', 1)
                            ->first();
                $total = $get_query1->stay_date_num;
                $pay = $room_price * $total;
                return view('rooms_reserve_stay_preview', ['get_query1'=>$get_query1, 'pay'=>$pay, 'total'=>$total, 'room_id'=>$room_id, 'add_data_id'=>$add_data_id, "name"=>$request->name, "mail"=>$request->email]);
            }
        }
        // 翌々月のデータがあり翌月のリクエストパラメータがある
        elseif ($judge1==false&&$judge2==true&&$judge3==false&&$judge4==true)
        {
            // 翌々月の処理
            if (isset($get_next_month2)) {
                $start2 = $get_next_month2->date;
                $l_start2 = strlen($start2);
                $diff2 = $l_start2 - 2;
                $num2 = $get_next_month2->stay_date_num;
                $end2 = date('Y-m-d', strtotime('last day of'.$month3));
                $end2_1 = substr($end2, -2);
                $st2 = substr($start2, -2);
                $st2_1 = substr($start2, 0, $diff2);
                for ($i = $st2; $i < $num2 + $st2; $i++) {
                    if ($i > $end2_1) {
                        break;
                    }
                    \DB::table('reservation_stay')->insert([
                        'room_id' => $room_id,
                        'name' => $request->name,
                        'email' => $request->email,
                        'tel' => $request->tel,
                        'checkin_time' => $request->checkin_time,
                        'date' => $st2_1.$i,
                        'role' => 1,
                        'key_day' => $next_month2,
                        'stay_date_num' => $get_next_month2->stay_date_num,
                        'serial_num' => $add_data_id,
                        'stay_people' => $request->stay_people,
                    ]);
                }
            }
            // リクエストパラメータのdateの値に応じて処理を変える
            // 翌月月末のデータが算出可能だったら通常通りレコード作成を開始
            $num = $request->stay_date_num - 1;
            $last_date = date('Y-m-d', strtotime($request->date.'+'.$num.' day'));
            $next_month_last = date('Y-m-d', strtotime('last day of'.$month2));
            if ($next_month_last!=$last_date)
            {
                // リクエストパラメータのチェックインが月末出ない場合一度既に作られたクエリを消去
                \DB::table('reservation_stay')
                ->where('room_id', $room_id)
                ->where('name', $request->name)
                ->where('email', $request->email)
                ->where('role', 1)
                ->delete();
            }
            // リクエストパラメータに応じた処理
            $start3 = $request->date;
            $l_start3 = strlen($start3);
            $diff3 = $l_start3 - 2;
            $st_month = date('Y-m', strtotime($start3));
            $st_month2 = '01';
            $st_month3 = $st_month.'-'.$st_month2;
            $num3 = $request->stay_date_num;
            $end3 = date('Y-m-d', strtotime('last day of'.$st_month));
            $end3_1 = substr($end3, -2);
            $st3 = substr($start3, -2);
            $st3_1 = substr($start3, 0, $diff3);
            for ($i = $st3; $i < $num3 + $st3; $i++) {
                if ($i > $end3_1) {
                    break;
                }
                \DB::table('reservation_stay')->insert([
                    'room_id' => $room_id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'tel' => $request->tel,
                    'checkin_time' => $request->checkin_time,
                    'date' => $st3_1.$i,
                    'role' => 1,
                    'key_day' => $st_month3,
                    'stay_date_num' => $request->stay_date_num,
                    'serial_num' => $add_data_id,
                    'stay_people' => $request->stay_people,
                ]);
            }
            // roleが0となっているクエリを全て消去
            $delete = \DB::table('reservation_stay')
                    ->where('room_id', $room_id)
                    ->where('name', $request->name)
                    ->where('email', $request->email)
                    ->where('role', 0)
                    ->delete();

            // その後月またぎの予約かそうでないかで処理を分岐
            // role1の翌々月のクエリがあるか
            $query_exists = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('key_day', $next_month2)
                        ->where('role', 1)
                        ->exists();
            
            if ($query_exists==true) {
                // 確認画面に反映させるために先頭のクエリを取得(翌月のものが先頭に来る)
                $get_query1 = \DB::table('reservation_stay')
                            ->where('room_id', $room_id)
                            ->where('name', $request->name)
                            ->where('email', $request->email)
                            ->where('key_day', $next_month)
                            ->first();
                // 次に合計宿泊日数を計算するために各月毎のstay_date_numを出し、その合計値を求める
                $stay1 = \DB::table('reservation_stay')
                            ->where('room_id', $room_id)
                            ->where('name', $request->name)
                            ->where('email', $request->email)
                            ->where('key_day', $next_month)
                            ->value('stay_date_num');
                $stay2 = \DB::table('reservation_stay')
                            ->where('room_id', $room_id)
                            ->where('name', $request->name)
                            ->where('email', $request->email)
                            ->where('key_day', $next_month2)
                            ->value('stay_date_num');
                $total = $stay1 + $stay2;
                $pay = $room_price * $total;
                return view('rooms_reserve_stay_preview', ['get_query1'=>$get_query1, 'pay'=>$pay, 'total'=>$total, 'room_id'=>$room_id, 'add_data_id'=>$add_data_id, "name"=>$request->name, "mail"=>$request->email]);
            } else {
                // 確認画面に反映させるために先頭のクエリを取得
                $get_query1 = \DB::table('reservation_stay')
                            ->where('room_id', $room_id)
                            ->where('name', $request->name)
                            ->where('email', $request->email)
                            ->where('role', 1)
                            ->first();
                $total = $get_query1->stay_date_num;
                $pay = $room_price * $total;
                return view('rooms_reserve_stay_preview', ['get_query1'=>$get_query1, 'pay'=>$pay, 'total'=>$total, 'room_id'=>$room_id, 'add_data_id'=>$add_data_id, "name"=>$request->name, "mail"=>$request->email]);
            }
        }
        // 月またぎをしていない場合リクエストパラメータの値を元にデータを作成
        else {
            // 値はリクエストパラメータで決める
            $start1 = $request->date;
            $l_start1 = strlen($start1);
            $diff1 = $l_start1 - 2;
            $num1 = $request->stay_date_num;
            $st1 = substr($start1, -2);
            $st1_1 = substr($start1, 0, $diff1);
            for ($i = $st1; $i < $num1 + $st1; $i++) {
                \DB::table('reservation_stay')->insert([
                    'room_id' => $room_id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'tel' => $request->tel,
                    'checkin_time' => $request->checkin_time,
                    'date' => $st1_1.$i,
                    'role' => 1,
                    'stay_date_num' => $request->stay_date_num,
                    'serial_num' => $add_data_id,
                    'stay_people' => $request->stay_people,
                ]);
            }
            // roleが0となっているクエリを全て消去
            $delete = \DB::table('reservation_stay')
                    ->where('room_id', $room_id)
                    ->where('name', $request->name)
                    ->where('email', $request->email)
                    ->where('role', 0)
                    ->delete();
            // 確認画面に反映させるために先頭のクエリを取得
            $get_query1 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('role', 1)
                        ->first();
            $total = $get_query1->stay_date_num;
            $pay = $room_price * $total;
            return view('rooms_reserve_stay_preview', ['get_query1'=>$get_query1, 'pay'=>$pay, 'total'=>$total, 'room_id'=>$room_id, 'add_data_id'=>$add_data_id, "name"=>$request->name, "mail"=>$request->email]);
        }
    }


    // 部屋予約お問い合わせ作成ページへ遷移(時間貸し)
    public function time_rserve_send(Request $request, $room_id, $add_data_id) 
    {
        // 仮予約がある場合問答無用でそちらを表示する(確認画面から戻るを押して再度確認ボタンを押された時の対策)
        $pre_save_search = \DB::table('reservation_time')
                        ->where('room_id', $room_id)
                        ->where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('serial_num', $add_data_id)
                        ->where('role', 1)
                        ->exists();
        if ($pre_save_search==true) {
            return view('alert');
        }

        $id_card_check = new Rserveidcardcheck();

        // バリデーションルールを設定する
        $rulus = [
            'name' => 'required | max:100',
            'email' => 'email | max:50',
            'tel' => 'required | numeric | digits_between:8,11',
            'date' => 'required | date_format:"Y-m-d"',
            'start_time' => 'required | date_format:"H:i"',
            'end_time' => 'required | date_format:"H:i"',   
            'room_id' => 'required',

        ];

        // バリデーションの独自メッセージを設定する
        $message = [
            'name.required' => '名前は必須項目です。',
            'name.max' => '名前は100文字以内で入力してください。',
            'email.email'  => 'Emailには、有効なメールアドレスを指定してください。',
            'email.max' => 'Emailは、50文字以内で入力してください。',
            'tel.required' => '電話番号には必須項目です。',
            'tel.numeric' => '電話番号は8桁から11桁の間で指定してください。',
            'date.required' => '予約日は必須項目です。',
            'date.date_format:"Y-m-d"' => '決められた形式の日付にしてください。',            
            'start_time.required' => '開始時間は必須項目です。',
            'end_time.required' => '終了時間は必須項目です。',
            'start_time.date_format:"H:i"' => '決められた形式の時間にしてください。',
            'end_time.date_format:"H:i"' => '決められた形式の時間にしてください。',
        ];


        $validator = Validator::make($request->all(), $rulus, $message);


        // エラーがおきていたらリダイレクトする。
        if($validator->fails())
        {
            return redirect()->route('roomsreserve_time', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, "name"=>$request->name, "mail"=>$request->email])
            ->withErrors($validator)
            ->withInput();
        }

        // エラーがなかったらリクエストパラメータの値を参照して保存処理を行う
        \DB::table('reservation_time')->insert([
            'room_id' => $room_id,
            'name' => $request->name,
            'email' => $request->email,
            'tel' => $request->tel,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'date' => $request->date,
            'role' => 1,
            'serial_num' => $add_data_id,
            'stay_people' => $request->stay_people,
        ]);

        // 生成されたクエリを取得
        $get_query1 = \DB::table('reservation_time')
                    ->where('room_id', $room_id)
                    ->where('name', $request->name)
                    ->where('email', $request->email)
                    ->where('role', 1)
                    ->first();

        // 料金算定のため時間差を出す
        $start = date('2021-10-18 '.$request->start_time.':00');
        $end = date('2021-10-18 '.$request->end_time.':00');
        $differ = (strtotime($end) - strtotime($start)) / 3600;

        // DBから対象の部屋の料金を参照する
        $price = \DB::table('room')
                ->where('id', $room_id)
                ->value('h_price');

        $pay = $price * $differ;

        return view('rooms_reserve_time_preview', ['get_query1'=>$get_query1, 'pay'=>$pay, 'room_id'=>$room_id, 'add_data_id'=>$add_data_id, "name"=>$request->name, "mail"=>$request->email]);

        // $Admin_to = [
        //     [
        //         'email' => $admin->from_mail,
        //         'name' => $admin->name,
        //     ]
        // ];


        // 客先に送信
        // $Customr = Mail::to($Customr_to)->send(new Contact_send_admin_mail($admin->message, $admin->subject, $admin->form_mail ));
        



        // 予約メール送らさせて頂きました。下記URLにアクセスして予約してください
        // https://ito/com/reserve/1/natume@gmail.com/12

        // 管理者に送信
        // $Admin = Mail::to($Admin_to)->send(new Contact_send_customer_mail($request->user_name, $request->telphone, $request->contact, $request->checkbox, $request->email ));

        // 予約番号生成処理 

        // DBの処理をする



        // return view('rooms_reserve_stay');



    }

    // 宿泊の予約設定をやり直す
    public function stay_retly($room_id, $add_data_id, $name, $email) {
        // role1の仮予約を全て消す
        $delete = \DB::table('reservation_stay')
                ->where('room_id', $room_id)
                ->where('name', $name)
                ->where('email', $email)
                ->where('role', 1)
                ->delete();
        // 今日の日付を求めた後でリダイレクト処理
        $today = date('Y-m-d');
        $c = new calendar_Logic();
        $calendars = $c->reservation_calendar_get($today, $room_id);

        // 料金を計算してリアルタイムに出力するための処理
        $room_price = \DB::table('room')
                        ->where('id', $room_id)
                        ->value('day_price');

        return view('rooms_reserve_stay')->with([
            "room_id"  => $room_id,
            "add_data_id"  => $add_data_id,            
            "calendars" => $calendars,
            "room_price" => $room_price,
            "name"=>$name,
            "mail"=>$email
        ]);
    }

    // 時間貸しの予約設定をやり直す
    public function time_retly($room_id, $add_data_id, $name, $email) {
        // role1の仮予約を全て消す
        $delete = \DB::table('reservation_time')
                ->where('room_id', $room_id)
                ->where('name', $name)
                ->where('email', $email)
                ->where('role', 1)
                ->delete();
        // 今日の日付を求めた後でリダイレクト処理
        $today = date('Y-m-d');
        $c = new calendar_Logic();
        $calendars = $c->reservation_calendar_get($today, $room_id);

        // 料金を計算してリアルタイムに出力するための処理
        $room_price = \DB::table('room')
                        ->where('id', $room_id)
                        ->value('h_price');

        return view('rooms_reserve_time')->with([
            "room_id"  => $room_id,
            "add_data_id"  => $add_data_id,            
            "calendars" => $calendars,
            "room_price" => $room_price,
            "name"=>$name,
            "mail"=>$email
        ]);
    }

    // 予約を確定させて決済処理をするメソッド(宿泊)
    public function stay_comp(Request $request, $room_id, $add_data_id, $name, $email) {
        // 日本の標準時に設定
        date_default_timezone_set('Asia/Tokyo');

        // 決済完了後戻るを押されて再度決済されてしまった場合の対策
        $role2 = \DB::table('reservation_stay')
                ->where('room_id', $room_id)
                ->where('name', $name)
                ->where('email', $email)
                ->where('serial_num', $add_data_id)
                ->where('role', 2)
                ->exists();
        if ($role2==true) {
            $err_message = "既に決済処理は完了しております。ブラウザを閉じてメールをご確認ください。";
            return view('rooms_reserve_comp', ['err_message'=>$err_message]);
        }

        // 身分証明書登録処理
        $rules = [
            'image_front' => 'required | image |  max:10240',              // 10mB以下の画像サイズ
            'image_back' => 'required | image |  max:10240',               // 10mB以下の画像サイズ
        ];

        $messages = [
            'image_front.required' => '身分証明書「表」は必須項目です。',
            'image_back.required' => '身分証明書「裏」は必須項目です。',
            'image_front.size:max:10240' => '身分証明書表は10MB以下でお願いいたします。',
            'image_back.size:max:10240' => '身分証明書裏は10MB以下でお願いいたします。',
            'image_front.image' => '身分証明書表は拡張子はpngかjpgでお願いいたします。',
            'image_back.image' => '身分証明書裏は拡張子はpngかjpgでお願いいたします。',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        // エラーがおきていたらリダイレクトする。
        if($validator->fails())
        {
            // 確認画面に反映させるために先頭のクエリを取得
            $room_price = \DB::table('room')->where('id', $room_id)->value('day_price');
            $get_query1 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $name)
                        ->where('email', $email)
                        ->where('role', 1)
                        ->first();
            $total = $get_query1->stay_date_num;
            $pay = $room_price * $total;
            return view('rooms_reserve_stay_preview', ['get_query1'=>$get_query1, 'pay'=>$pay, 'total'=>$total, 'room_id'=>$room_id, 'add_data_id'=>$add_data_id, "name"=>$name, "mail"=>$email])
            ->withErrors($validator);
        }

        $path_f = Storage::putFile('/images/idcard', $request->file('image_front'), 'public');
        $path_b = Storage::putFile('/images/idcard', $request->file('image_back'), 'public');
        \DB::table('reservation_stay')->where('room_id', $room_id)->where('name', $name)->where('email', $email)->where('role', 1)->update([
            'image_front' => basename($path_f),
            'image_back' => basename($path_b),
        ]);

        // 決済処理
        // 決済前に合計金額を出す
        $stay = \DB::table('room')->where('id', $room_id)->value('day_price');
        $stay_days = \DB::table('reservation_stay')
            ->where('room_id', $room_id)
            ->where('name', $name)
            ->where('email', $email)
            ->where('role', 1)
            ->count();
        $money = $stay * $stay_days;
        $keyword = 'stay';
        try {
            $squareService = new SquareService();
            $squareService->createPayment($request->all(), $money, $room_id, $name, $email, $keyword);
            $pay_time = date('Y-m-d H:i:s');
        } catch (\Exception $exception) {
            // 確認画面を返す
            $get_query1 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $name)
                        ->where('email', $email)
                        ->where('role', 1)
                        ->first();
            $total = \DB::table('reservation_stay')
                    ->where('room_id', $room_id)
                    ->where('name', $name)
                    ->where('email', $email)
                    ->where('role', 1)
                    ->count();
            $room_price_stay = \DB::table('room')
                            ->where('id', $room_id)
                            ->value('day_price');
            $pay = $total * $room_price_stay;
            $error_message = '決済に失敗しました。クレジットカードの期限が有効であるか、利用限度額を超えていないかを確認の上操作のやり直しをお願い致します。また、クレジットカードの情報入力後確認用の青いボタンを押さなければ決済処理は始まりません。ご注意ください。';
            return view('rooms_reserve_stay_preview', ['get_query1'=>$get_query1, 'pay'=>$pay, 'total'=>$total, 'room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'error_message'=>$error_message, "name"=>$name, "mail"=>$email]);
        }

        // 予約番号を生成
        // $max = pow(10, 8) - 1;
        // $rand = random_int(0, $max);
        // $reserve_num = sprintf('%08d', $rand);
        $reserve_num = uniqid();

        // reservation_numテーブルに情報を登録
        \DB::table('reservation_num')->insert([
            'room_id' => $room_id,
            'num' => $reserve_num,
        ]);

        $reserve_id = \DB::table('reservation_num')->where('num', $reserve_num)->value('id');

        $confirm = \DB::table('reservation_stay')
                ->where('room_id', $room_id)
                ->where('name', $name)
                ->where('email', $email)
                ->where('role', 1)
                ->update([
                    'role'=>2,
                    'pay_time'=>$pay_time,
                    'reservation_id'=>$reserve_id,
                ]);

        // 保存後仮予約のデータを削除
        $delete = \DB::table('reservation_stay')
                ->where('room_id', $room_id)
                ->where('name', $name)
                ->where('email', $email)
                ->where('role', 1)
                ->delete();

        // 確認のメールを飛ばす
        $to = [
            [
                'email' => $email,
                'name' => $name,
            ]
        ];
        $room_name = \DB::table('room')->where('id', $room_id)->value('stay_name');
        $stay_reserve_data = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $name)
                        ->where('email', $email)
                        ->where('reservation_id', $reserve_id)
                        ->where('role', 2)
                        ->first();
        $checkin_date = $stay_reserve_data->date;
        $checkin_time = $stay_reserve_data->checkin_time;
        $stay_days = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $name)
                        ->where('email', $email)
                        ->where('reservation_id', $reserve_id)
                        ->where('role', 2)
                        ->count();
        // 身分証の表と裏の情報を取得
        $image_front = $stay_reserve_data->image_front;
        $image_back = $stay_reserve_data->image_back;
        $card_brand = $stay_reserve_data->card_brand;
        $last4 = $stay_reserve_data->last4;
        $accept_num = $stay_reserve_data->accept_num;
        Mail::to($to)->send(new Reserve_Stay_Confirm_Mail($reserve_num, $name, $room_name, $checkin_date, $checkin_time, $stay_days, $money, $room_id, $pay_time, $card_brand, $last4, $accept_num));

        // 管理者にも確認のメールを飛ばす
        $admin = \DB::table('contact_mail_config')->first();
        $admin_to = [
            [
                'email' => $admin->from_mail,
                'name' => $admin->name,
            ]
        ];
        Mail::to($admin_to)->send(new Admin_Stay_Notice_Mail($reserve_num, $name, $email, $room_name, $checkin_date, $checkin_time, $stay_days, $money, $room_id, $image_front, $image_back));

        return view('rooms_reserve_comp');
    }

    // 予約を確定させて決済処理をするメソッド(時間貸し)
    public function time_comp(Request $request, $room_id, $add_data_id, $name, $email) {
        // 日本の標準時に設定
        date_default_timezone_set('Asia/Tokyo');

        // 決済完了後戻るを押されて再度決済されてしまった場合の対策
        $role2 = \DB::table('reservation_time')
                ->where('room_id', $room_id)
                ->where('name', $name)
                ->where('email', $email)
                ->where('serial_num', $add_data_id)
                ->where('role', 2)
                ->exists();
        if ($role2==true) {
            $err_message = "既に決済処理は完了しております。ブラウザを閉じてメールをご確認ください。";
            return view('rooms_reserve_comp', ['err_message'=>$err_message]);
        }

        // 身分証明書登録処理
        $rules = [
            'image_front' => 'required | image | max:10240',              // 10mB以下の画像サイズ
            'image_back' => 'required | image | max:10240',               // 10mB以下の画像サイズ
        ];

        $messages = [
            'image_front.required' => '身分証明書「表」は必須項目です。',
            'image_back.required' => '身分証明書「裏」は必須項目です。',
            'image_front.size:max:10240' => '身分証明書表は10MB以下でお願いいたします。',
            'image_back.size:max:10240' => '身分証明書裏は10MB以下でお願いいたします。',
            'image_front.image' => '身分証明書表は拡張子はpngかjpgでお願いいたします。',
            'image_back.image' => '身分証明書裏は拡張子はpngかjpgでお願いいたします。',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        // エラーがおきていたらリダイレクトする。
        if($validator->fails())
        {
            // 確認画面に反映させるために先頭のクエリを取得
            $get_query1 = \DB::table('reservation_time')
                        ->where('room_id', $room_id)
                        ->where('name', $name)
                        ->where('email', $email)
                        ->where('role', 1)
                        ->first();
            $time = \DB::table('room')->where('id', $room_id)->value('h_price');
            $time_start = \DB::table('reservation_time')
                        ->where('room_id', $room_id)
                        ->where('name', $name)
                        ->where('email', $email)
                        ->where('role', 1)
                        ->orderBy('id', 'desc')
                        ->value('start_time');
            $time_end = \DB::table('reservation_time')
                        ->where('room_id', $room_id)
                        ->where('name', $name)
                        ->where('email', $email)
                        ->where('role', 1)
                        ->orderBy('id', 'desc')
                        ->value('end_time');
            $differ = (strtotime('2021-10-23 '.$time_end.':00') - strtotime('2021-10-23 '.$time_start.':00')) / 3600;
            $pay = $time * $differ;
            return view('rooms_reserve_time_preview', ['get_query1'=>$get_query1, 'pay'=>$pay, 'room_id'=>$room_id, 'add_data_id'=>$add_data_id, "name"=>$name, "mail"=>$email])
            ->withErrors($validator);
        }

        $path_f = Storage::putFile('/images/idcard', $request->file('image_front'), 'public');
        $path_b = Storage::putFile('/images/idcard', $request->file('image_back'), 'public');
        \DB::table('reservation_time')->where('room_id', $room_id)->where('name', $name)->where('email', $email)->where('role', 1)->update([
            'image_front' => basename($path_f),
            'image_back' => basename($path_b),
        ]);

        // 決済処理
        // 決済前に金額を出す
        $time = \DB::table('room')->where('id', $room_id)->value('h_price');
        $time_start = \DB::table('reservation_time')
                    ->where('room_id', $room_id)
                    ->where('name', $name)
                    ->where('email', $email)
                    ->where('role', 1)
                    ->orderBy('id', 'desc')
                    ->value('start_time');
        $time_end = \DB::table('reservation_time')
                    ->where('room_id', $room_id)
                    ->where('name', $name)
                    ->where('email', $email)
                    ->where('role', 1)
                    ->orderBy('id', 'desc')
                    ->value('end_time');
        $differ = (strtotime('2021-10-23 '.$time_end.':00') - strtotime('2021-10-23 '.$time_start.':00')) / 3600;
        $money = $time * $differ;
        $keyword = 'time';
        try {
            $squareService = new SquareService();
            $squareService->createPayment($request->all(), $money, $room_id, $name, $email, $keyword);
            $pay_time = date('Y-m-d H:i:s');
        } catch (\Exception $exception) {
            // 確認画面を返す
            $get_query1 = \DB::table('reservation_time')
                        ->where('room_id', $room_id)
                        ->where('name', $name)
                        ->where('email', $email)
                        ->where('role', 1)
                        ->first();
            $total = \DB::table('reservation_time')
                    ->where('room_id', $room_id)
                    ->where('name', $name)
                    ->where('email', $email)
                    ->where('role', 1)
                    ->count();
            $room_price_stay = \DB::table('room')
                            ->where('id', $room_id)
                            ->value('h_price');
            $pay = $total * $room_price_stay;
            $error_message = '決済に失敗しました。クレジットカードの期限が有効であるか、利用限度額を超えていないかを確認の上操作のやり直しをお願い致します。また、クレジットカードの情報入力後確認用の青いボタンを押さなければ決済処理は始まりません。ご注意ください。';
            return view('rooms_reserve_time_preview', ['get_query1'=>$get_query1, 'pay'=>$pay, 'total'=>$total, 'room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'error_message'=>$error_message, "name"=>$name, "mail"=>$email]);
        }

        // 8桁の予約番号を生成
        // $max = pow(10, 8) - 1;
        // $rand = random_int(0, $max);
        // $reserve_num = sprintf('%08d', $rand);
        $reserve_num = uniqid();

        // reservation_numテーブルに情報を登録
        \DB::table('reservation_num')->insert([
            'room_id' => $room_id,
            'num' => $reserve_num,
        ]);

        $reserve_id = \DB::table('reservation_num')->where('num', $reserve_num)->value('id');

        $confirm = \DB::table('reservation_time')
                ->where('room_id', $room_id)
                ->where('name', $name)
                ->where('email', $email)
                ->where('role', 1)
                ->orderBy('id', 'desc')
                ->update([
                    'role'=>2,
                    'pay_time'=>$pay_time,
                    'reservation_id'=>$reserve_id,
                ]);

        // 仮予約のデータをすべて削除
        $delete = \DB::table('reservation_time')
                ->where('room_id', $room_id)
                ->where('name', $name)
                ->where('email', $email)
                ->where('role', 1)
                ->delete();

        // 確認のメールを飛ばす
        $to = [
            [
                'email' => $email,
                'name' => $name,
            ]
        ];
        $room_name = \DB::table('room')->where('id', $room_id)->value('stay_name');
        $reserve_time_data = \DB::table('reservation_time')
                            ->where('room_id', $room_id)
                            ->where('name', $name)
                            ->where('email', $email)
                            ->where('role', 2)
                            ->orderBy('id', 'desc')
                            ->first();
        $date = $reserve_time_data->date;
        $start_time = $reserve_time_data->start_time;
        $end_time = $reserve_time_data->end_time;
        // 身分証の表と裏の情報を取得
        $image_front = $reserve_time_data->image_front;
        $image_back = $reserve_time_data->image_back;
        $card_brand = $reserve_time_data->card_brand;
        $last4 = $reserve_time_data->last4;
        $accept_num = $reserve_time_data->accept_num;
        Mail::to($to)->send(new Reserve_Time_Confirm_Mail($reserve_num, $name, $room_name, $date, $start_time, $end_time, $money, $room_id, $pay_time, $card_brand, $last4, $accept_num));

        // 管理者にも確認のメールを飛ばす
        $admin = \DB::table('contact_mail_config')->first();
        $admin_to = [
            [
                'email' => $admin->from_mail,
                'name' => $admin->name,
            ]
        ];
        Mail::to($admin_to)->send(new Admin_Stay_Notice_Mail($reserve_num, $name, $email, $room_name, $date, $start_time, $end_time, $money, $room_id, $image_front, $image_back));

        return view('rooms_reserve_comp');
    }
}   
