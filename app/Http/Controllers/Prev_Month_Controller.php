<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Validator;
use App\Models\calendar_Logic;

class Prev_Month_Controller extends Controller
{
    // 予約画面の先月の情報を表示する(宿泊)
    // public function stay_preview(Request $request, $date, $room_id, $add_data_id){
    //     // バリデーションチェック
    //     $rules = [
    //         'name' => 'max:100',
    //         'email' => 'max:50',
    //         'checkin_time' => 'max:20',
    //     ];
    //     $messages = [
    //         'name.max:100' => '名前は100文字以内で入力してください',
    //         'email.max:50' => 'Eメールは50文字以内で入力してください',
    //         'checkin_time.max:20' => 'チェックイン時間は20文字以内で入力してください', 
    //     ];
    //     $validator = Validator::make($request->all(), $rules, $messages);

    //     // エラーがおきていたらリダイレクトする。
    //     if($validator->fails())
    //     {
    //         return redirect()->route('roomsreserve_stay', ['date'=>$date, 'room_id'=>$room_id, 'add_data_id'=>$add_data_id])
    //         ->withErrors($validator)
    //         ->withInput();
    //     }

    //     // 料金を計算してリアルタイムに出力するための処理
    //     $room_price = \DB::table('room')
    //                     ->where('id', $room_id)
    //                     ->value('day_price');
        
    //     // リクエストパラメータのreset_flgがtrueなら一度全てのクエリを削除する
    //     if ($request->reset_flg == 1) {
    //         $reset = \DB::table('reservation_stay')
    //                 ->where('room_id', $room_id)
    //                 ->where('name', $request->name)
    //                 ->where('email', $request->email)
    //                 ->where('role', 0)
    //                 ->delete();
    //     }

    //     // 今日よりも前の月に移動しようとしているかどうかを確認、今日よりも前の月だったら自動的に今月が表示されるようにする
    //     $today = date('Y-m-d');
    //     $differ = strtotime($date) - strtotime($today);
    //     if ($differ < 0) {
    //         $this_month = $today;
    //         $c = new calendar_Logic();
    //         $calendars = $c->reservation_calendar_get($today, $room_id);
    //         return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'room_price'=>$room_price]);
    //     } else {
    //         $this_month = $date;

    //         if ($request->reset_flg==1){
    //             $check_this_month = date('Y-m');
    //             $check_data = date('Y-m', strtotime($this_month));

    //             if ($check_this_month == $check_data){
    //                 // 今月へと移動するなら今日の日付を元にロジックを取得
    //                 $today = date('Y-m-d');
    //                 $c = new calendar_Logic();
    //                 $calendars = $c->reservation_calendar_get($today, $room_id);
    //             } else {
    //                 $flagment = $request->stradding_the_moon_flg;
    //                 if ($flagment==0){
    //                     $this_month = date('Y-m-d', strtotime($date.'+1 month'));
    //                     $prev = date('Y-m-d', strtotime('first day of'.$this_month));
    //                     $c = new calendar_Logic();
    //                     $calendars = $c->reservation_calendar_get($prev, $room_id);
    //                 } else {
    //                     $prev = date('Y-m-d', strtotime('first day of'.$this_month));
    //                     $c = new calendar_Logic();
    //                     $calendars = $c->reservation_calendar_get($prev, $room_id);
    //                 }
    //             }
    //             return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'room_price'=>$room_price]);
    //         }

    //         // key_day保存用に$dateを1カ月後に戻す
    //         $get_key_day = date('Y-m-d', strtotime($this_month.'+1 month'));

    //         // バリデーションOKかつ名前、Eメール、電話番号、日付が埋まってたら保存処理を行う
    //         if ($request->name!=null&&$request->email!=null&&$request->tel!=null&&$request->date!=null){
    //             \DB::table('reservation_stay')->insert([
    //                 'room_id' => $room_id,
    //                 'name' => $request->name,
    //                 'email' => $request->email,
    //                 'tel' => $request->tel,
    //                 'checkin_time' => $request->checkin_time,
    //                 'date' => $request->date,
    //                 'role' => 0,
    //                 'key_day' => $get_key_day,
    //                 'stay_date_num' => $request->stay_date_num,
    //                 'stradding_the_moon_flg' => $request->strading_the_moon_flg,
    //                 'serial_num' => $add_data_id,
    //             ]);

    //             // // DBに登録されている仮登録のレコードの数が2以上だったら最新の物以外を削除する。ただし、先月末日から連泊しようとしている場合は残す。
    //             // $q = \DB::table('reservation_stay')
    //             //     ->where('room_id', $room_id)
    //             //     ->where('name', $request->name)
    //             //     ->where('email', $request->email)
    //             //     ->count();
    //             // if ($q > 1){
    //             //     $delete = \DB::table('reservation_stay')
    //             //             ->where('room_id', $room_id)
    //             //             ->where('name', $request->name)
    //             //             ->where('email', $request->email)
    //             //             ->get();
    //             //     foreach($delete as $del){
    //             //         if ($q == 1){
    //             //             break;
    //             //         } else {
    //             //             \DB::table('reservation_stay')
    //             //             ->where('id', $del->id)
    //             //             ->delete();
    //             //         }
    //             //     }
    //             // }
    //         }

    //         // 翌月から先月への移動ができる場合は年月が今月と一致していたら今月のデータをもとにしてカレンダーロジックを取得、そうでなければ先月初日を元にしてロジックを取得
    //         // 今月へと移動するとき
    //         $check_this_month = date('Y-m');
    //         $check_data = date('Y-m', strtotime($this_month));
    //         if ($check_this_month == $check_data){
    //             // 今月へと移動するなら今日の日付を元にロジックを取得
    //             $c = new calendar_Logic();
    //             $calendars = $c->reservation_calendar_get($today, $room_id);
    //         } else {
    //             // リクエストパラメータの月またぎの判定フラグが0だったら月移動ができないようにする
    //             $flagment = $request->stradding_the_moon_flg;
    //             if ($flagment == 0){
    //                 $this_month = date('Y-m-d', strtotime($date.'+1 month'));
    //                 $prev = date('Y-m-d', strtotime('first day of'.$this_month));
    //                 $c = new calendar_Logic();
    //                 $calendars = $c->reservation_calendar_get($prev, $room_id);
    //                 // 画面遷移後もフォームに情報を表示するためにroom_idと電話番号、名前から該当するクエリを取得
    //                 $query = \DB::table('reservation_stay')
    //                         ->where('room_id', $room_id)
    //                         ->where('name', $request->name)
    //                         ->where('email', $request->email)
    //                         ->where('role', 0)
    //                         ->exists();
    //                 if ($query==true){
    //                     $get_query = \DB::table('reservation_stay')
    //                                 ->where('room_id', $room_id)
    //                                 ->where('name', $request->name)
    //                                 ->where('email', $request->email)
    //                                 ->where('role', 0)
    //                                 ->orderBy('id', 'desc')
    //                                 ->first();
    //                     $get_query2 = \DB::table('reservation_stay')
    //                                 ->where('room_id', $room_id)
    //                                 ->where('name', $request->name)
    //                                 ->where('email', $request->email)
    //                                 ->where('key_day', $date)
    //                                 ->where('role', 0)
    //                                 ->orderBy('id', 'desc')
    //                                 ->first();
    //                     $gq3_date = date('Y-m-d', strtotime($date.'+1 month'));
    //                     $get_query3 = \DB::table('reservation_stay')
    //                                 ->where('room_id', $room_id)
    //                                 ->where('name', $request->name)
    //                                 ->where('email', $request->email)
    //                                 ->where('key_day', $gq3_date)
    //                                 ->where('role', 0)
    //                                 ->orderBy('id', 'desc')
    //                                 ->first();
    //                     if ($this_month==date('Y-m-d')) {
    //                         // 2カ月先のデータがあるかどうか、あったらそれも呼び出す
    //                         $gq4_date = date('Y-m-d', strtotime($date.'+2 month'));
    //                         $gq4 = \DB::table('reservation_stay')
    //                                 ->where('room_id', $room_id)
    //                                 ->where('name', $request->name)
    //                                 ->where('email', $request->email)
    //                                 ->where('key_day', $gq4_date)
    //                                 ->where('role', 0)
    //                                 ->exists();
    //                         if ($gq4 == true) {
    //                             $get_query4 = \DB::table('reservation_stay')
    //                                         ->where('room_id', $room_id)
    //                                         ->where('name', $request->name)
    //                                         ->where('email', $request->email)
    //                                         ->where('key_day', $gq4_date)
    //                                         ->where('role', 0)
    //                                         ->orderBy('id', 'desc')
    //                                         ->first();

    //                             return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'get_query3'=>$get_query3, 'get_query4'=>$get_query4, 'room_price'=>$room_price]);
    //                         } else {
    //                             return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'get_query3'=>$get_query3, 'room_price'=>$room_price]);
    //                         }
    //                     } elseif ($date == date('Y-m-d', strtotime('+1 month'))) {
    //                         // 2カ月先のデータがあるかどうか、あったらそれも呼び出す
    //                         $gq4_date = date('Y-m-d', strtotime($date.'+1 month'));
    //                         $gq4 = \DB::table('reservation_stay')
    //                                 ->where('room_id', $room_id)
    //                                 ->where('name', $request->name)
    //                                 ->where('email', $request->email)
    //                                 ->where('key_day', $gq4_date)
    //                                 ->where('role', 0)
    //                                 ->exists();
    //                         if ($gq4 == true) {
    //                             $get_query4 = \DB::table('reservation_stay')
    //                                         ->where('room_id', $room_id)
    //                                         ->where('name', $request->name)
    //                                         ->where('email', $request->email)
    //                                         ->where('key_day', $gq4_date)
    //                                         ->where('role', 0)
    //                                         ->orderBy('id', 'desc')
    //                                         ->first();

    //                             return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'get_query3'=>$get_query3, 'get_query4'=>$get_query4, 'room_price'=>$room_price]);
    //                         } else {
    //                             return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'get_query3'=>$get_query3, 'room_price'=>$room_price]);
    //                         }
    //                     }
    //                 }
    //             }
    //             // 翌々月から翌月の移動なら投げられたデータを元に月初を取得してロジックを取得
    //             $prev = date('Y-m-d', strtotime('first day of'.$this_month));
    //             $c = new calendar_Logic();
    //             $calendars = $c->reservation_calendar_get($prev, $room_id);
    //         }

    //         // 画面遷移後もフォームに情報を表示するためにroom_idと電話番号、名前から該当するクエリを取得
    //         $query = \DB::table('reservation_stay')
    //                 ->where('room_id', $room_id)
    //                 ->where('name', $request->name)
    //                 ->where('email', $request->email)
    //                 ->where('role', 0)
    //                 ->exists();
    //         if ($query==true){
    //             $get_query = \DB::table('reservation_stay')
    //                         ->where('room_id', $room_id)
    //                         ->where('name', $request->name)
    //                         ->where('email', $request->email)
    //                         ->where('role', 0)
    //                         ->orderBy('id', 'desc')
    //                         ->first();
    //             $get_query2 = \DB::table('reservation_stay')
    //                         ->where('room_id', $room_id)
    //                         ->where('name', $request->name)
    //                         ->where('email', $request->email)
    //                         ->where('key_day', $date)
    //                         ->where('role', 0)
    //                         ->orderBy('id', 'desc')
    //                         ->first();
    //             $gq3_date = date('Y-m-d', strtotime($date.'+1 month'));
    //             $get_query3 = \DB::table('reservation_stay')
    //                         ->where('room_id', $room_id)
    //                         ->where('name', $request->name)
    //                         ->where('email', $request->email)
    //                         ->where('key_day', $gq3_date)
    //                         ->where('role', 0)
    //                         ->orderBy('id', 'desc')
    //                         ->first();
    //             if ($this_month==date('Y-m-d')) {
    //                 // 2カ月先のデータがあるかどうか、あったらそれも呼び出す
    //                 $gq4_date = date('Y-m-d');
    //                 $gq4 = \DB::table('reservation_stay')
    //                         ->where('room_id', $room_id)
    //                         ->where('name', $request->name)
    //                         ->where('email', $request->email)
    //                         ->where('key_day', $gq4_date)
    //                         ->where('role', 0)
    //                         ->exists();
    //                 if ($gq4 == true) {
    //                     $get_query4 = \DB::table('reservation_stay')
    //                                 ->where('room_id', $room_id)
    //                                 ->where('name', $request->name)
    //                                 ->where('email', $request->email)
    //                                 ->where('key_day', $gq4_date)
    //                                 ->where('role', 0)
    //                                 ->orderBy('id', 'desc')
    //                                 ->first();

    //                     return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'get_query3'=>$get_query3, 'get_query4'=>$get_query4, 'room_price'=>$room_price]);
    //                 } else {
    //                     return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'get_query3'=>$get_query3, 'room_price'=>$room_price]);
    //                 }
    //             } elseif ($date==date('Y-m-d', strtotime('+1 month'))) {
    //                 // 今月のデータがあるかどうか、あったらそれも呼び出す
    //                 $gq4_date = date('Y-m-d');
    //                 $gq4 = \DB::table('reservation_stay')
    //                         ->where('room_id', $room_id)
    //                         ->where('name', $request->name)
    //                         ->where('email', $request->email)
    //                         ->where('key_day', $gq4_date)
    //                         ->where('role', 0)
    //                         ->exists();
    //                 if ($gq4 == true) {
    //                     $get_query4 = \DB::table('reservation_stay')
    //                                 ->where('room_id', $room_id)
    //                                 ->where('name', $request->name)
    //                                 ->where('email', $request->email)
    //                                 ->where('key_day', $gq4_date)
    //                                 ->where('role', 0)
    //                                 ->orderBy('id', 'desc')
    //                                 ->first();

    //                     return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'get_query3'=>$get_query3, 'get_query4'=>$get_query4, 'room_price'=>$room_price]);
    //                 } else {
    //                     return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'get_query3'=>$get_query3, 'room_price'=>$room_price]);
    //                 }
    //             }
    //         } else {
    //             return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'room_price'=>$room_price]);
    //         }
    //     }
    // }

    // 予約画面の先月の情報を表示する(時間貸し)
    // public function time_preview(Request $request, $date, $room_id, $add_data_id){
    //     // リクエストパラメータのreset_flgがtrueなら一度全てのクエリを削除する
    //     if ($request->reset_flg == 1) {
    //         $reset = \DB::table('reservation_time')
    //                 ->where('room_id', $room_id)
    //                 ->where('name', $request->name)
    //                 ->where('email', $request->email)
    //                 ->where('role', 0)
    //                 ->delete();
    //     }

    //     // バリデーションチェック
    //     $rules = [
    //         'name' => 'max:100',
    //         'email' => 'max:50',
    //         'checkin_time' => 'max:20',
    //     ];
    //     $messages = [
    //         'name.max:100' => '名前は100文字以内で入力してください',
    //         'email.max:50' => 'Eメールは50文字以内で入力してください',
    //         'checkin_time.max:20' => 'チェックイン時間は20文字以内で入力してください', 
    //     ];
    //     $validator = Validator::make($request->all(), $rules, $messages);

    //     // エラーがおきていたらリダイレクトする。
    //     if($validator->fails())
    //     {
    //         return redirect()->route('roomsreserve_time', ['date'=>$date, 'room_id'=>$room_id, 'add_data_id'=>$add_data_id])
    //         ->withErrors($validator)
    //         ->withInput();
    //     }

    //     // key_day保存用に$dateを1カ月後に戻す
    //     $get_key_day = date('Y-m-d', strtotime($date.'+1 month'));

    //     // 料金を計算してリアルタイムに出力するための処理
    //     $room_price = \DB::table('room')
    //                     ->where('id', $room_id)
    //                     ->value('h_price');

    //     // リクエストパラメータのreset_flgがtrueなら一度全てのクエリを削除する
    //     if ($request->reset_flg == 1) {
    //         $reset = \DB::table('reservation_time')
    //                 ->where('room_id', $room_id)
    //                 ->where('name', $request->name)
    //                 ->where('email', $request->email)
    //                 ->where('role', 0)
    //                 ->delete();
    //     }

    //     if ($request->reset_flg==1){
    //         $this_month = $date;
    //         $check_this_month = date('Y-m');
    //         $check_data = date('Y-m', strtotime($this_month));

    //         if ($check_this_month == $check_data){
    //             // 今月へと移動するなら今日の日付を元にロジックを取得
    //             $today = date('Y-m-d');
    //             $c = new calendar_Logic();
    //             $calendars = $c->reservation_calendar_get($today, $room_id);
    //         } else {
    //             $flagment = $request->stradding_the_moon_flg;
    //             if ($flagment==0){
    //                 $this_month = date('Y-m-d', strtotime($date.'+1 month'));
    //                 $prev = date('Y-m-d', strtotime('first day of'.$this_month));
    //                 $c = new calendar_Logic();
    //                 $calendars = $c->reservation_calendar_get($prev, $room_id);
    //             } else {
    //                 $prev = date('Y-m-d', strtotime('first day of'.$this_month));
    //                 $c = new calendar_Logic();
    //                 $calendars = $c->reservation_calendar_get($prev, $room_id);
    //             }
    //         }
    //         return view('rooms_reserve_time', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'room_price'=>$room_price]);
    //     }

    //     // バリデーションがOKかつリクエストパラメータ全てがnullでない状態だったらRequestパラメータに保存されている値をinsertする
    //     if ($request->name!=null&&$request->email!=null&&$request->tel!=null&&$request->date!=null){
    //         \DB::table('reservation_time')->insert([
    //             'room_id' => $room_id,
    //             'name' => $request->name,
    //             'email' => $request->email,
    //             'tel' => $request->tel,
    //             'start_time' => $request->start_time,
    //             'end_time' => $request->end_time,
    //             'date' => $request->date,
    //             'role' => 0,
    //             'key_day' => $get_key_day,
    //             'serial_num' => $add_data_id,
    //         ]);

    //         // // DBに登録されている仮登録のレコードの数が2以上だったら最新の物以外を削除する
    //         // $q = \DB::table('reservation_time')
    //         //     ->where('room_id', $room_id)
    //         //     ->where('name', $request->name)
    //         //     ->where('email', $request->email)
    //         //     ->count();
    //         // if ($q > 1){
    //         //     $delete = \DB::table('reservation_time')
    //         //             ->where('room_id', $room_id)
    //         //             ->where('name', $request->name)
    //         //             ->where('email', $request->email)
    //         //             ->get();
    //         //     foreach($delete as $del){
    //         //         if ($q == 1){
    //         //             break;
    //         //         } else {
    //         //             \DB::table('reservation_time')
    //         //             ->where('id', $del->id)
    //         //             ->delete();
    //         //         }
    //         //     }
    //         // }
    //     }

    //     // 今日よりも前の月に移動しようとしているかどうかを確認、今日よりも前の月だったら自動的に今月が表示されるようにする
    //     $today = date('Y-m-d');
    //     $differ = strtotime($date) - strtotime($today);
    //     if ($differ < 0) {
    //         $this_month = $today;
    //         $c = new calendar_Logic();
    //         $calendars = $c->reservation_calendar_get($today, $room_id);
    //         return view('rooms_reserve_time', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'room_price'=>$room_price]);
    //     } else {
    //         $this_month = $date;
    //         // 翌月から先月への移動ができる場合は年月が今月と一致していたら今月のデータをもとにしてカレンダーロジックを取得、そうでなければ先月初日を元にしてロジックを取得
    //         // 今月へと移動するとき
    //         $check_this_month = date('Y-m');
    //         $check_data = date('Y-m', strtotime($this_month));
    //         if ($check_this_month == $check_data){
    //             // 今月へと移動するなら今日の日付を元にロジックを取得
    //             $c = new calendar_Logic();
    //             $calendars = $c->reservation_calendar_get($today, $room_id);
    //         } else {
    //             // 翌々月から翌月の移動なら投げられたデータを元に月初を取得してロジックを取得
    //             $prev = date('Y-m-d', strtotime('first day of'.$this_month));
    //             $c = new calendar_Logic();
    //             $calendars = $c->reservation_calendar_get($prev, $room_id);
    //         }

    //         // 画面遷移後もフォームに情報を表示するためにroom_idと電話番号、名前から該当するクエリを取得
    //         $query = \DB::table('reservation_time')
    //                 ->where('room_id', $room_id)
    //                 ->where('name', $request->name)
    //                 ->where('email', $request->email)
    //                 ->where('role', 0)
    //                 ->exists();
    //         if ($query==true){
    //             $get_query = \DB::table('reservation_time')
    //                         ->where('room_id', $room_id)
    //                         ->where('name', $request->name)
    //                         ->where('email', $request->email)
    //                         ->where('role', 0)
    //                         ->orderBy('id', 'desc')
    //                         ->first();
    //             $get_query2 = \DB::table('reservation_time')
    //                         ->where('room_id', $room_id)
    //                         ->where('name', $request->name)
    //                         ->where('email', $request->email)
    //                         ->where('key_day', $date)
    //                         ->where('role', 0)
    //                         ->orderBy('id', 'desc')
    //                         ->first();

    //             return view('rooms_reserve_time', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'room_price'=>$room_price]);
    //         } else {
    //             return view('rooms_reserve_time', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'room_price'=>$room_price]);
    //         }
    //     }
    // }

    public function stay_preview($date, $room_id, $add_data_id, $name, $email, $tel, $reserve_date, $stay_num, $checkin, $stradding, $reset, $stay_people) {
        // 日本の標準時に設定
        date_default_timezone_set('Asia/Tokyo');

        $room_price = \DB::table('room')
                        ->where('id', $room_id)
                        ->value('day_price');

        // リセットフラグが1の場合名前とメールアドレスと部屋IDが一致するクエリを消去
        if ($reset==1) {
            \DB::table('reservation_stay')
            ->where('room_id', $room_id)
            ->where('name', $name)
            ->where('email', $email)
            ->where('role', 0)
            ->delete();
        }

        $this_month = date('Y-m-d', strtotime('first day of'.$date));
        $get_key_day = date('Y-m-d', strtotime($this_month.'+1 month'));

        // 既にクエリが存在する場合insertの前に作成済みのクエリを消去する
        $del_q = \DB::table('reservation_stay')
                ->where('room_id', $room_id)
                ->where('name', $name)
                ->where('email', $email)
                ->where('key_day', $get_key_day)
                ->where('role', 0)
                ->exists();

        if ($del_q==true) {
            \DB::table('reservation_stay')
                ->where('room_id', $room_id)
                ->where('name', $name)
                ->where('email', $email)
                ->where('key_day', $get_key_day)
                ->where('role', 0)
                ->delete();
        }

        // 渡されたパラメータが不正なものでないかどうか確認、不正なパラメータだったら保存処理をする前に止める
        if($email!="sample@mail"&&filter_var($email, FILTER_VALIDATE_EMAIL)) {
        } elseif($email=="sample@mail"){
        } else {
            $today = date('Y-m-d');
            $c = new calendar_Logic();
            $calendars = $c->reservation_calendar_get($today, $room_id);
            $err_message = "メールアドレスの形式が正しくありません。正しい形式のメールアドレスを入力してください。";

            return view('rooms_reserve_stay')->with([
                "room_id"  => $room_id,
                "add_data_id"  => $add_data_id,            
                "calendars" => $calendars,
                "room_price" => $room_price,
                "err_message" => $err_message,
                "name" => $name,
                "mail" => $email,
            ]);
        }
        if (strlen($name)>100||strlen($email)>50) {
            $today = date('Y-m-d');
            $c = new calendar_Logic();
            $calendars = $c->reservation_calendar_get($today, $room_id);
            $err_message = "名前もしくはメールアドレスの値が基準値を超えています。名前は100文字以内、メールアドレスは50文字以内で入力お願い致します。";

            return view('rooms_reserve_stay')->with([
                "room_id"  => $room_id,
                "add_data_id"  => $add_data_id,            
                "calendars" => $calendars,
                "room_price" => $room_price,
                "err_message" => $err_message,
                "name" => $name,
                "mail" => $email,
            ]);
        }
        if (is_numeric($tel)==false) {
            $today = date('Y-m-d');
            $c = new calendar_Logic();
            $calendars = $c->reservation_calendar_get($today, $room_id);
            $err_message = "電話番号が8~11桁の整数で入力されていません。ハイフンなし8~11桁の整数で入力お願い致します。";

            return view('rooms_reserve_stay')->with([
                "room_id"  => $room_id,
                "add_data_id"  => $add_data_id,            
                "calendars" => $calendars,
                "room_price" => $room_price,
                "err_message" => $err_message,
                "name" => $name,
                "mail" => $email,
            ]);
        }
        if (is_numeric($stay_people)==false) {
            $today = date('Y-m-d');
            $c = new calendar_Logic();
            $calendars = $c->reservation_calendar_get($today, $room_id);
            $err_message = "宿泊人数が3桁以内の整数で入力されていません。3桁以内の整数で入力お願い致します。";

            return view('rooms_reserve_stay')->with([
                "room_id"  => $room_id,
                "add_data_id"  => $add_data_id,            
                "calendars" => $calendars,
                "room_price" => $room_price,
                "err_message" => $err_message,
                "name" => $name,
                "mail" => $email,
            ]);
        }

        // 渡されたパラメータがデフォルトではないとき保存処理を行う
        if ($name!='sample'&&$email!='sample@mail'&&$reserve_date!='2021-01-01'&&$stay_num!=0&&$checkin!='0:00'){
            \DB::table('reservation_stay')->insert([
                'room_id' => $room_id,
                'name' => $name,
                'email' => $email,
                'tel' => $tel,
                'checkin_time' => $checkin,
                'date' => $reserve_date,
                'role' => 0,
                'key_day' => $get_key_day,
                'stay_date_num' => $stay_num,
                'stradding_the_moon_flg' => $stradding,
                'serial_num' => $add_data_id,
                'stay_people' => $stay_people,
            ]);
        } else {
            if($tel=="0000000000"&&$reserve_date=="2021-01-01"&&$stay_num==0&&$checkin=="0:00"){
                $err_message = "";
            } else {
                $err_message = "電話番号、予約日、チェックイン時間のいずれかが未記入またはリセット処理が行われたためデータが保存されませんでした。月またぎの予約を行う場合は必ずそれらを入力してから月移動をしてください。";
            }
        }

        $now = date('Y-m-d');
        $now2 = date('Y-m-d', strtotime('first day of'.$now));

        if (strtotime($this_month) - strtotime($now) <= 0) {
            $this_month = $now;
            $c = new calendar_Logic();
            $calendars = $c->reservation_calendar_get($this_month, $room_id);
        } else {
            $past = date('Y-m-d', strtotime('first day of'.$this_month));
            $c = new calendar_Logic();
            $calendars = $c->reservation_calendar_get($past, $room_id);
        }

        // 月またぎでない場合月の移動をできなくする
        $judge = \DB::table('reservation_stay')
                ->where('room_id', $room_id)
                ->where('name', $name)
                ->where('email', $email)
                ->where('key_day', $get_key_day)
                ->where('stradding_the_moon_flg', 0)
                ->where('role', 0)
                ->exists();

        if ($judge == true) {
            // 翌月以降の場合
            $judge_month = date('Y-m-d', strtotime($date.'+1 month'));
            if ($judge_month==$now2) {
                $c = new calendar_Logic();
                $calendars = $c->reservation_calendar_get($now, $room_id);
                $get_query = \DB::table('reservation_stay')
                            ->where('room_id', $room_id)
                            ->where('name', $name)
                            ->where('email', $email)
                            ->where('key_day', $now)
                            ->orderBy('id', 'desc')
                            ->where('role', 0)
                            ->first();
                $get_query2 = \DB::table('reservation_stay')
                            ->where('room_id', $room_id)
                            ->where('name', $name)
                            ->where('email', $email)
                            ->where('key_day', $now)
                            ->orderBy('id', 'desc')
                            ->where('role', 0)
                            ->first();
                $this_month = $now;
                $err_message = "月末までの連泊設定ではないため月移動はできません。月移動を行う場合は一度設定をリセットするか予約日に月末を含めてください。";
                return view('rooms_reserve_stay', ['room_id'=>$room_id, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'room_price'=>$room_price, 'err_message'=>$err_message, 'name'=>$name, 'mail'=>$email]);
            } else {
                $prev_data = date('Y-m-d', strtotime($date.'+1 month'));
                $prev = date('Y-m-d', strtotime('first day of'.$prev_data));
                $c = new calendar_Logic();
                $calendars = $c->reservation_calendar_get($prev, $room_id);
                $get_query = \DB::table('reservation_stay')
                            ->where('room_id', $room_id)
                            ->where('name', $name)
                            ->where('email', $email)
                            ->where('key_day', $prev_data)
                            ->where('role', 0)
                            ->orderBy('id', 'desc')
                            ->first();
                $get_query2 = \DB::table('reservation_stay')
                            ->where('room_id', $room_id)
                            ->where('name', $name)
                            ->where('email', $email)
                            ->where('key_day', $prev_data)
                            ->orderBy('id', 'desc')
                            ->where('role', 0)
                            ->first();
                $this_month = date('Y-m-d', strtotime($date.'+1 month'));
                $err_message = "月末までの連泊設定ではないため月移動はできません。月移動を行う場合は一度設定をリセットするか予約日に月末を含めてください。";
                return view('rooms_reserve_stay', ['room_id'=>$room_id, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'room_price'=>$room_price, 'err_message'=>$err_message, 'name'=>$name, 'mail'=>$email]);
            }
        }

        // 画面遷移後もフォームに情報を表示するためにroom_idと電話番号、名前から該当するクエリを取得
        $query = \DB::table('reservation_stay')
                ->where('room_id', $room_id)
                ->where('name', $name)
                ->where('email', $email)
                ->where('role', 0)
                ->exists();
        if ($query==true){
            $get_query = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $name)
                        ->where('email', $email)
                        ->where('role', 0)
                        ->orderBy('id', 'desc')
                        ->first();
            $get_query2 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $name)
                        ->where('email', $email)
                        ->where('key_day', $date)
                        ->where('role', 0)
                        ->orderBy('id', 'desc')
                        ->first();
            $gq3_date = date('Y-m-d', strtotime($date.'+1 month'));
            $get_query3 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $name)
                        ->where('email', $email)
                        ->where('key_day', $gq3_date)
                        ->where('role', 0)
                        ->orderBy('id', 'desc')
                        ->first();
            // 2カ月先まで予約が入る場合の処理
            if ($this_month == $now) {
                $gq4_date = date('Y-m-d', strtotime($date.'+2 month'));
                $get_query4 = \DB::table('reservation_stay')
                            ->where('room_id', $room_id)
                            ->where('name', $name)
                            ->where('email', $email)
                            ->where('key_day', $gq4_date)
                            ->where('role', 0)
                            ->orderBy('id', 'desc')
                            ->first();

                if (isset($err_message)) {
                    return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'get_query3'=>$get_query3, 'get_query4'=>$get_query4, 'room_price'=>$room_price, 'err_message'=>$err_message, 'name'=>$name, 'mail'=>$email]);
                } else {
                    return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'get_query3'=>$get_query3, 'get_query4'=>$get_query4, 'room_price'=>$room_price, 'name'=>$name, 'mail'=>$email]);
                }
            } elseif ($date > $now) {
                $gq4_date = date('Y-m-d', strtotime($date.'-1 month'));
                $get_query4 = \DB::table('reservation_stay')
                            ->where('room_id', $room_id)
                            ->where('name', $name)
                            ->where('email', $email)
                            ->where('key_day', $gq4_date)
                            ->where('role', 0)
                            ->orderBy('id', 'desc')
                            ->first();

                if(isset($err_message)) {
                    return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'get_query3'=>$get_query3, 'get_query4'=>$get_query4, 'room_price'=>$room_price, 'err_message'=>$err_message, 'name'=>$name, 'mail'=>$email]);
                } else {
                    return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'get_query3'=>$get_query3, 'get_query4'=>$get_query4, 'room_price'=>$room_price, 'name'=>$name, 'mail'=>$email]);
                }
            } else {
                if(isset($err_message)) {
                    return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'get_query3'=>$get_query3, 'room_price'=>$room_price, 'err_message'=>$err_message, 'name'=>$name, 'mail'=>$email]);
                } else {
                    return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'get_query3'=>$get_query3, 'room_price'=>$room_price, 'name'=>$name, 'mail'=>$email]);
                }
            }
        } else {
            if (isset($err_message)) {
                return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'room_price'=>$room_price, 'err_message'=>$err_message, 'name'=>$name, 'mail'=>$email]);
            } else {
                return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'room_price'=>$room_price, 'name'=>$name, 'mail'=>$email]);
            }
        }
    }

    public function time_preview($date, $room_id, $add_data_id) {
        $room_price = \DB::table('room')
                        ->where('id', $room_id)
                        ->value('h_price');

        $sub_mail = \DB::table('sub_reserve_mail')
                    ->where('id', $add_data_id)
                    ->first();
        $name = $sub_mail->name;
        $email = $sub_mail->mail;
        $now = date('Y-m-d');
        $this_month = $date;
        if (strtotime($this_month) - strtotime($now) < 0) {
            $this_month = $now;
            $month = date('Y-m-d');
            $c = new calendar_Logic();
            $calendars = $c->reservation_calendar_get($month, $room_id);
        } else {
            $month = date('Y-m-d', strtotime('first day of'.$this_month));
            $c = new calendar_Logic();
            $calendars = $c->reservation_calendar_get($month, $room_id);
        }

        return view('rooms_reserve_time', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'room_price'=>$room_price, 'name'=>$name, 'mail'=>$email]);
    }
}
