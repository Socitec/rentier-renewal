<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Models\calendar_Logic;

class Next_Month_Controller extends Controller
{
    // 予約画面の翌月の情報を表示する(宿泊)
    // public function stay_next(Request $request, $date, $room_id, $add_data_id){
    //     $this_month = $date;
    //     $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

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

    //     // リクエストパラメータのreset_flgがtrueなら一度全てのクエリを削除する、そして再読み込み
    //     if ($request->reset_flg == 1) {
    //         $reset = \DB::table('reservation_stay')
    //                 ->where('room_id', $room_id)
    //                 ->where('name', $request->name)
    //                 ->where('email', $request->email)
    //                 ->where('role', 0)
    //                 ->delete();

    //         $now = date('Y-m-d');
    //         $flagment = $request->stradding_the_moon_flg;
    //         $future = date('Y-m-d', strtotime($now.'+2 month'));
    //         if (strtotime($future) - strtotime($this_month) < 0) {
    //             $this_month = date('Y-m-d', strtotime($this_month.'-1 month'));
    //             $c = new calendar_Logic();
    //             $calendars = $c->reservation_calendar_get($next, $room_id);
    //         } elseif ($flagment == 0) {
    //             $this_month = date('Y-m-d', strtotime($date.'-1 month'));
    //             $now_month = date('Y-m-d');
    //             if ($this_month == $now_month){
    //                 // 現在月の場合
    //                 $next = date('Y-m-d');
    //                 $c = new calendar_Logic();
    //                 $calendars = $c->reservation_calendar_get($next, $room_id);
    //             } else {
    //                 // それ以外の場合
    //                 $next = date('Y-m-d', strtotime('first day of'.$this_month));
    //                 $c = new calendar_Logic();
    //                 $calendars = $c->reservation_calendar_get($next, $room_id);
    //             }
    //         } else {
    //             $next = date('Y-m-d', strtotime('first day of'.$this_month));
    //             $c = new calendar_Logic();
    //             $calendars = $c->reservation_calendar_get($next, $room_id);
    //         }

    //         return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'room_price'=>$room_price]);
    //     }

    //     // 2カ月以上先に遷移しようとしている場合2カ月先の月に再設定してその月を表示する
    //     $now = date('Y-m-d');
    //     $future = date('Y-m-d', strtotime($now.'+2 month'));
    //     $future2 = date('Y-m-d', strtotime($now.'+1 month'));
    //     if (strtotime($future) - strtotime($this_month) < 0){
    //         $this_month = date('Y-m-d', strtotime($this_month.'-1 month'));

    //         // カレンダーロジックを呼び出す、この際翌月に遷移するため開始を翌月の初日とする
    //         $next = date('Y-m-d', strtotime('first day of'.$this_month));
    //         $c = new calendar_Logic();
    //         $calendars = $c->reservation_calendar_get($next, $room_id);

    //         // 画面遷移後もフォームに情報を表示するためにroom_idと電話番号、名前から該当するクエリを取得
    //         $query = \DB::table('reservation_stay')
    //         ->where('room_id', $room_id)
    //         ->where('name', $request->name)
    //         ->where('email', $request->email)
    //         ->where('role', 0)
    //         ->exists();
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
    //                         ->where('key_day', $this_month)
    //                         ->where('role', 0)
    //                         ->orderBy('id', 'desc')
    //                         ->first();
    //             $gq3_date = date('Y-m-d', strtotime($date.'-2 month'));
    //             $get_query3 = \DB::table('reservation_stay')
    //                         ->where('room_id', $room_id)
    //                         ->where('name', $request->name)
    //                         ->where('email', $request->email)
    //                         ->where('key_day', $gq3_date)
    //                         ->where('role', 0)
    //                         ->orderBy('id', 'desc')
    //                         ->first();
    //             // 2カ月先まで予約が入る場合の処理
    //             if ($this_month == $future) {
    //                 $gq4_date = date('Y-m-d', strtotime($date.'-3 month'));
    //                 $get_query4 = \DB::table('reservation_stay')
    //                             ->where('room_id', $room_id)
    //                             ->where('name', $request->name)
    //                             ->where('email', $request->email)
    //                             ->where('key_day', $gq4_date)
    //                             ->where('role', 0)
    //                             ->orderBy('id', 'desc')
    //                             ->first();
            
    //                 return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'get_query3'=>$get_query3, 'get_query4'=>$get_query4, 'room_price'=>$room_price]);
    //             } elseif ($date == $future2) {
    //                 $gq4_date = date('Y-m-d', strtotime($date.'+1 month'));
    //                 $get_query4 = \DB::table('reservation_stay')
    //                             ->where('room_id', $room_id)
    //                             ->where('name', $request->name)
    //                             ->where('email', $request->email)
    //                             ->where('key_day', $gq4_date)
    //                             ->where('role', 0)
    //                             ->orderBy('id', 'desc')
    //                             ->first();
            
    //                 return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'get_query3'=>$get_query3, 'get_query4'=>$get_query4, 'room_price'=>$room_price]);
    //             } else {
    //                 return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'get_query3'=>$get_query3, 'room_price'=>$room_price]);
    //             }
    //         } else {
    //             return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'room_price'=>$room_price]);
    //         }
    //     }

    //     // key_day保存用に$dateを1カ月前に戻す
    //     $get_key_day = date('Y-m-d', strtotime($this_month.'-1 month'));

    //     // バリデーションがOKかつリクエストパラメータ全てがnullでない状態だったらRequestパラメータに保存されている値をinsertする
    //     if ($request->name!=null&&$request->email!=null&&$request->tel!=null&&$request->date!=null){
    //         \DB::table('reservation_stay')->insert([
    //             'room_id' => $room_id,
    //             'name' => $request->name,
    //             'email' => $request->email,
    //             'tel' => $request->tel,
    //             'checkin_time' => $request->checkin_time,
    //             'date' => $request->date,
    //             'role' => 0,
    //             'key_day' => $get_key_day,
    //             'stay_date_num' => $request->stay_date_num,
    //             'stradding_the_moon_flg' => $request->stradding_the_moon_flg,
    //             'serial_num' => $add_data_id,
    //         ]);

    //         // DBに登録されている仮登録のレコードの数が2以上だったら古いものを削除する。ただし、先月末日から連泊しようとしている場合は残す。
    //         $q = \DB::table('reservation_stay')
    //             ->where('room_id', $room_id)
    //             ->where('name', $request->name)
    //             ->where('email', $request->email)
    //             ->where('key_day', $get_key_day)
    //             ->where('role', 0)
    //             ->count();
    //         if ($q > 1){
    //             $delete = \DB::table('reservation_stay')
    //                     ->where('room_id', $room_id)
    //                     ->where('name', $request->name)
    //                     ->where('email', $request->email)
    //                     ->where('role', 0)
    //                     ->first();
    //             $delete = \DB::table('reservation_stay')
    //                     ->where('id', $delete->id)
    //                     ->delete();
    //         }
    //     }

    //     // リクエストパラメータの月またぎの判定フラグが0だったら月移動ができないようにする
    //     $flagment = $request->stradding_the_moon_flg;
    //     if ($flagment==0){
    //         // フラグ0の時月またぎをさせずに表示中の月を返す
    //         $this_month = date('Y-m-d', strtotime($date.'-1 month'));
    //         // 表示中の月が現在月かそれ以外かで処理を分ける
    //         $now_month = date('Y-m-d');
    //         if ($this_month == $now_month){
    //             // 現在月の場合
    //             $next = date('Y-m-d');
    //             $c = new calendar_Logic();
    //             $calendars = $c->reservation_calendar_get($next, $room_id);
    //         } else {
    //             // それ以外の場合
    //             $next = date('Y-m-d', strtotime('first day of'.$this_month));
    //             $c = new calendar_Logic();
    //             $calendars = $c->reservation_calendar_get($next, $room_id);
    //         }
    //         // 画面遷移後もフォームに情報を表示するためにroom_idと電話番号、名前から該当するクエリを取得
    //         $query = \DB::table('reservation_stay')
    //                     ->where('room_id', $room_id)
    //                     ->where('name', $request->name)
    //                     ->where('email', $request->email)
    //                     ->where('role', 0)
    //                     ->exists();
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
    //             $gq3_date = date('Y-m-d', strtotime($date.'-1 month'));
    //             $get_query3 = \DB::table('reservation_stay')
    //                         ->where('room_id', $room_id)
    //                         ->where('name', $request->name)
    //                         ->where('email', $request->email)
    //                         ->where('key_day', $gq3_date)
    //                         ->where('role', 0)
    //                         ->orderBy('id', 'desc')
    //                         ->first();
    //             // 2カ月先まで予約が入る場合の処理
    //             if ($this_month == $future) {
    //                 $gq4_date = date('Y-m-d', strtotime($date.'-2 month'));
    //                 $get_query4 = \DB::table('reservation_stay')
    //                             ->where('room_id', $room_id)
    //                             ->where('name', $request->name)
    //                             ->where('email', $request->email)
    //                             ->where('key_day', $gq4_date)
    //                             ->where('role', 0)
    //                             ->orderBy('id', 'desc')
    //                             ->first();

    //                 return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'get_query3'=>$get_query3, 'get_query4'=>$get_query4, 'room_price'=>$room_price]);
    //             } elseif ($date == $future2) {
    //                 $gq4_date = date('Y-m-d', strtotime($date.'+1 month'));
    //                 $get_query4 = \DB::table('reservation_stay')
    //                             ->where('room_id', $room_id)
    //                             ->where('name', $request->name)
    //                             ->where('email', $request->email)
    //                             ->where('key_day', $gq4_date)
    //                             ->where('role', 0)
    //                             ->orderBy('id', 'desc')
    //                             ->first();

    //                 return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'get_query3'=>$get_query3, 'get_query4'=>$get_query4, 'room_price'=>$room_price]);
    //             } else {
    //                 return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'get_query3'=>$get_query3, 'room_price'=>$room_price]);
    //             }
    //         } else {
    //             return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'room_price'=>$room_price]);
    //         }
    //     }

    //     // カレンダーロジックを呼び出す、この際翌月に遷移するため開始を翌月の初日とする
    //     $next = date('Y-m-d', strtotime('first day of'.$this_month));
    //     $c = new calendar_Logic();
    //     $calendars = $c->reservation_calendar_get($next, $room_id);

    //     // 画面遷移後もフォームに情報を表示するためにroom_idと電話番号、名前から該当するクエリを取得
    //     $query = \DB::table('reservation_stay')
    //             ->where('room_id', $room_id)
    //             ->where('name', $request->name)
    //             ->where('email', $request->email)
    //             ->where('role', 0)
    //             ->exists();
    //     if ($query==true){
    //         $get_query = \DB::table('reservation_stay')
    //                     ->where('room_id', $room_id)
    //                     ->where('name', $request->name)
    //                     ->where('email', $request->email)
    //                     ->where('role', 0)
    //                     ->orderBy('id', 'desc')
    //                     ->first();
    //         $get_query2 = \DB::table('reservation_stay')
    //                     ->where('room_id', $room_id)
    //                     ->where('name', $request->name)
    //                     ->where('email', $request->email)
    //                     ->where('key_day', $date)
    //                     ->where('role', 0)
    //                     ->orderBy('id', 'desc')
    //                     ->first();
    //         $gq3_date = date('Y-m-d', strtotime($date.'-1 month'));
    //         $get_query3 = \DB::table('reservation_stay')
    //                     ->where('room_id', $room_id)
    //                     ->where('name', $request->name)
    //                     ->where('email', $request->email)
    //                     ->where('key_day', $gq3_date)
    //                     ->where('role', 0)
    //                     ->orderBy('id', 'desc')
    //                     ->first();
    //         // 2カ月先まで予約が入る場合の処理
    //         if ($this_month == $future) {
    //             $gq4_date = date('Y-m-d', strtotime($date.'-2 month'));
    //             $get_query4 = \DB::table('reservation_stay')
    //                         ->where('room_id', $room_id)
    //                         ->where('name', $request->name)
    //                         ->where('email', $request->email)
    //                         ->where('key_day', $gq4_date)
    //                         ->where('role', 0)
    //                         ->orderBy('id', 'desc')
    //                         ->first();

    //             return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'get_query3'=>$get_query3, 'get_query4'=>$get_query4, 'room_price'=>$room_price]);
    //         } elseif ($date == $future2) {
    //             $gq4_date = date('Y-m-d', strtotime($date.'+1 month'));
    //             $get_query4 = \DB::table('reservation_stay')
    //                         ->where('room_id', $room_id)
    //                         ->where('name', $request->name)
    //                         ->where('email', $request->email)
    //                         ->where('key_day', $gq4_date)
    //                         ->where('role', 0)
    //                         ->orderBy('id', 'desc')
    //                         ->first();

    //             return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'get_query3'=>$get_query3, 'get_query4'=>$get_query4, 'room_price'=>$room_price]);
    //         } else {
    //             return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'get_query3'=>$get_query3, 'room_price'=>$room_price]);
    //         }
    //     } else {
    //         return view('rooms_reserve_stay', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'room_price'=>$room_price]);
    //     }
    // }

    // 予約画面の翌月の情報を表示する(時間貸し)
    // public function time_next(Request $request, $date, $room_id, $add_data_id){
    //     $this_month = $date;

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

    //     // 料金を計算してリアルタイムに出力するための処理
    //     $room_price = \DB::table('room')
    //                     ->where('id', $room_id)
    //                     ->value('h_price');

    //     // リクエストパラメータのreset_flgがtrueなら一度全てのクエリを削除する、そして再読み込み
    //     if ($request->reset_flg == 1) {
    //         $reset = \DB::table('reservation_time')
    //                 ->where('room_id', $room_id)
    //                 ->where('name', $request->name)
    //                 ->where('email', $request->email)
    //                 ->where('role', 0)
    //                 ->delete();

    //         $now = date('Y-m-d');
    //         $flagment = $request->stradding_the_moon_flg;
    //         $future = date('Y-m-d', strtotime($now.'+2 month'));
    //         if (strtotime($future) - strtotime($this_month) < 0) {
    //             $this_month = date('Y-m-d', strtotime($this_month.'-1 month'));
    //             $c = new calendar_Logic();
    //             $calendars = $c->reservation_calendar_get($next, $room_id);
    //         } elseif ($flagment == 0) {
    //             $this_month = date('Y-m-d', strtotime($date.'-1 month'));
    //             $now_month = date('Y-m-d');
    //             if ($this_month == $now_month){
    //                 // 現在月の場合
    //                 $next = date('Y-m-d');
    //                 $c = new calendar_Logic();
    //                 $calendars = $c->reservation_calendar_get($next, $room_id);
    //             } else {
    //                 // それ以外の場合
    //                 $next = date('Y-m-d', strtotime('first day of'.$this_month));
    //                 $c = new calendar_Logic();
    //                 $calendars = $c->reservation_calendar_get($next, $room_id);
    //             }
    //         } else {
    //             $next = date('Y-m-d', strtotime('first day of'.$this_month));
    //             $c = new calendar_Logic();
    //             $calendars = $c->reservation_calendar_get($next, $room_id);
    //         }

    //         return view('rooms_reserve_time', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'room_price'=>$room_price]);
    //     }

    //     // 2カ月以上先に遷移しようとしている場合2カ月先の月に再設定してその月を表示する
    //     $now = date('Y-m-d');
    //     $future = date('Y-m-d', strtotime($now.'+2 month'));
    //     if (strtotime($future) - strtotime($this_month) < 0){
    //         $this_month = date('Y-m-d', strtotime($this_month.'-1 month'));

    //         // カレンダーロジックを呼び出す、この際翌月に遷移するため開始を翌月の初日とする
    //         $next = date('Y-m-d', strtotime('first day of'.$this_month));
    //         $c = new calendar_Logic();
    //         $calendars = $c->reservation_calendar_get($next, $room_id);

    //         // 画面遷移後もフォームに情報を表示するためにroom_idと電話番号、名前から該当するクエリを取得
    //         $query = \DB::table('reservation_time')
    //         ->where('room_id', $room_id)
    //         ->where('name', $request->name)
    //         ->where('email', $request->email)
    //         ->where('role', 0)
    //         ->exists();
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
    //                         ->where('key_day', $this_month)
    //                         ->where('role', 0)
    //                         ->orderBy('id', 'desc')
    //                         ->first();

    //             return view('rooms_reserve_time', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'room_price'=>$room_price]);
    //         } else {
    //             return view('rooms_reserve_time', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'room_price'=>$room_price]);
    //         }
    //     }

    //     // key_day保存用に$dateを1カ月前に戻す
    //     $get_key_day = date('Y-m-d', strtotime($this_month.'-1 month'));

    //     // バリデーションがOKかつリクエストパラメータ全てがnullでない状態だったらRequestパラメータに保存されている値をinsertする
    //     if ($request->name!=null&&$request->email!=null&&$request->tel!=null&&$request->date!=null){
    //         \DB::table('reservation_time')->insert([
    //             'room_id' => $room_id,
    //             'name' => $request->name,
    //             'email' => $request->email,
    //             'tel' => $request->tel,
    //             'start_time' => $request->start_time,
    //             'end_time' => $request->end_time,
    //             'date' => $request->$date,
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

    //     // カレンダーロジックを呼び出す、この際翌月に遷移するため開始を翌月の初日とする
    //     $next = date('Y-m-d', strtotime('first day of'.$this_month));
    //     $c = new calendar_Logic();
    //     $calendars = $c->reservation_calendar_get($next, $room_id);

    //     // 画面遷移後もフォームに情報を表示するためにroom_idと電話番号、名前から該当するクエリを取得
    //     $query = \DB::table('reservation_time')
    //             ->where('room_id', $room_id)
    //             ->where('name', $request->name)
    //             ->where('email', $request->email)
    //             ->where('role', 0)
    //             ->exists();
    //     if ($query==true){
    //         $get_query = \DB::table('reservation_time')
    //                     ->where('room_id', $room_id)
    //                     ->where('name', $request->name)
    //                     ->where('email', $request->email)
    //                     ->where('role', 0)
    //                     ->orderBy('id', 'desc')
    //                     ->first();
    //         $get_query2 = \DB::table('reservation_stay')
    //                     ->where('room_id', $room_id)
    //                     ->where('name', $request->name)
    //                     ->where('email', $request->email)
    //                     ->where('key_day', $date)
    //                     ->where('role', 0)
    //                     ->orderBy('id', 'desc')
    //                     ->first();

    //         return view('rooms_reserve_time', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'get_query'=>$get_query, 'room_price'=>$room_price]);
    //     } else {
    //         return view('rooms_reserve_time', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'room_price'=>$room_price]);
    //     }
    // }

    public function stay_next($date, $room_id, $add_data_id, $name, $email, $tel, $reserve_date, $stay_num, $checkin, $stradding, $reset, $stay_people) {
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
        $get_key_day = date('Y-m-d', strtotime($this_month.'-1 month'));

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
        } elseif($email=="sample@mail") {
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

        $future = date('Y-m-d', strtotime($now.'+2 month'));
        $future2 = date('Y-m-d', strtotime($now.'+1 month'));
        if (strtotime($future) - strtotime($this_month) < 0) {
            $this_month = $future;
            $next = date('Y-m-d', strtotime('first day of'.$this_month));
            $c = new calendar_Logic();
            $calendars = $c->reservation_calendar_get($next, $room_id);
        } else {
            $next = date('Y-m-d', strtotime('first day of'.$this_month));
            $c = new calendar_Logic();
            $calendars = $c->reservation_calendar_get($next, $room_id);
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
            $judge_month = date('Y-m-d', strtotime($date.'-1 month'));
            if ($now2==$judge_month) {
                $c = new calendar_Logic();
                $calendars = $c->reservation_calendar_get($now, $room_id);
                $get_query = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $name)
                        ->where('email', $email)
                        ->where('key_day', $now2)
                        ->orderBy('id', 'desc')
                        ->where('role', 0)
                        ->first();
                $get_query2 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $name)
                        ->where('email', $email)
                        ->where('key_day', $now2)
                        ->orderBy('id', 'desc')
                        ->where('role', 0)
                        ->first();
                $this_month = $now;
                $err_message = "月末までの連泊設定ではないため月移動はできません。月移動を行う場合は一度設定をリセットするか予約日に月末を含めてください。";
                return view('rooms_reserve_stay', ['room_id'=>$room_id, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'room_price'=>$room_price, 'err_message'=>$err_message, 'name'=>$name, 'mail'=>$email]);
            } else {
                $next_data = date('Y-m-d', strtotime($date.'-1 month'));
                $next = date('Y-m-d', strtotime('first day of'.$next_data));
                $c = new calendar_Logic();
                $calendars = $c->reservation_calendar_get($next, $room_id);
                $get_query = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $name)
                        ->where('email', $email)
                        ->where('key_day', $next_data)
                        ->where('role', 0)
                        ->orderBy('id', 'desc')
                        ->first();
                $get_query2 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $name)
                        ->where('email', $email)
                        ->where('key_day', $next_data)
                        ->orderBy('id', 'desc')
                        ->where('role', 0)
                        ->first();
                $this_month = date('Y-m-d', strtotime($date.'-1 month'));
                $err_message = "月末までの連泊設定ではないため月移動はできません。月移動を行う場合は一度設定をリセットするか予約日に月末を含めてください。";
                return view('rooms_reserve_stay', ['room_id'=>$room_id, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'room_price'=>$room_price, 'err_message'=>$err_message, 'name'=>$name, 'mail'=>$email]);
            }
        }

        // 月またぎでの予約がある場合に予約をした月以外には移動できなくする処理
        $stradding_check = \DB::table('reservation_stay')
                            ->where('room_id', $room_id)
                            ->where('name', $name)
                            ->where('email', $email)
                            ->where('stradding_the_moon_flg', 1)
                            ->where('role', 0)
                            ->get();
        // 月またぎを何月から何月の間にしているかをここで判定する
        // それぞれのクエリについてkey_dayからその月の日数を、dateからその月の宿泊開始日を、stay_date_numからその月の滞在日数を計算する
        $judge_array = [];
        $counter = 0;
        foreach ($stradding_check as $straddings) {
            // まず何月に月またぎが行われているか,その月の月初と月末を出す
            $target_month_start = date('Y-m-d', strtotime('first day of'.$straddings->key_day));
            $target_month_end = date('Y-m-d', strtotime('last day of'.$straddings->key_day));
            // 次にその月の予約開始日は何日か
            $checkin_date = $straddings->date;
            // 月末から予約開始日までの日数を出す
            $month_num = (strtotime($target_month_end) - strtotime($target_month_start)) / 86400;
            $date_num = ((strtotime($target_month_end) - strtotime($checkin_date)) / 86400) + 1;
            $counter++;
            // 予約開始日から月末まで宿泊している場合月またぎをしているとみなす、そうでない場合は月移動をさせない
            if ($date_num!=$straddings->stay_date_num&&$counter!=1) {
                $next_data = date('Y-m-d', strtotime($date.'-1 month'));
                $next = date('Y-m-d', strtotime('first day of'.$next_data));
                $c = new calendar_Logic();
                $calendars = $c->reservation_calendar_get($next, $room_id);
                $get_query = \DB::table('reservation_stay')
                            ->where('room_id', $room_id)
                            ->where('name', $name)
                            ->where('email', $email)
                            ->where('key_day', $next_data)
                            ->where('role', 0)
                            ->orderBy('id', 'desc')
                            ->first();
                $get_query2 = \DB::table('reservation_stay')
                            ->where('room_id', $room_id)
                            ->where('name', $name)
                            ->where('email', $email)
                            ->where('key_day', $next_data)
                            ->orderBy('id', 'desc')
                            ->where('role', 0)
                            ->first();
                $get_query3 = \DB::table('reservation_stay')
                            ->where('room_id', $room_id)
                            ->where('name', $name)
                            ->where('email', $email)
                            ->where('key_day', $now)
                            ->where('role', 0)
                            ->orderBy('id', 'desc')
                            ->first();
                $this_month = date('Y-m-d', strtotime($date.'-1 month'));
                $err_message = "翌月月末まで連泊指定がされていないため翌々月には移動できません。翌月末まで予約を入れていただくか設定をリセットすると翌々月に移動できます。";
                return view('rooms_reserve_stay', ['room_id'=>$room_id, 'get_query'=>$get_query, 'get_query2'=>$get_query2, 'get_query3'=>$get_query3, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'room_price'=>$room_price, 'err_message'=>$err_message, 'name'=>$name, 'mail'=>$email]);
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
            $gq3_date = date('Y-m-d', strtotime($date.'-1 month'));
            $get_query3 = \DB::table('reservation_stay')
                        ->where('room_id', $room_id)
                        ->where('name', $name)
                        ->where('email', $email)
                        ->where('key_day', $gq3_date)
                        ->where('role', 0)
                        ->orderBy('id', 'desc')
                        ->first();
            // 2カ月先まで予約が入る場合の処理
            if ($this_month == $future) {
                $gq4_date = date('Y-m-d', strtotime($date.'-2 month'));
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
            } elseif ($date == $future2) {
                $gq4_date = date('Y-m-d', strtotime($date.'+1 month'));
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
            } else {
                if (isset($err_message)) {
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

    public function time_next($date, $room_id, $add_data_id) {
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
        $future = date('Y-m-d', strtotime($now.'+2 month'));
        if (strtotime($future) - strtotime($this_month) < 0) {
            $this_month = $future;
            $next = date('Y-m-d', strtotime($now.'+2 month'));
            $c = new calendar_Logic();
            $calendars = $c->reservation_calendar_get($next, $room_id);
        } else {
            $next = date('Y-m-d', strtotime('first day of'.$this_month));
            $c = new calendar_Logic();
            $calendars = $c->reservation_calendar_get($next, $room_id);
        }

        return view('rooms_reserve_time', ['room_id'=>$room_id, 'add_data_id'=>$add_data_id, 'this_month'=>$this_month, 'calendars'=>$calendars, 'room_price'=>$room_price, 'name'=>$name, 'mail'=>$email]);
    }
}
