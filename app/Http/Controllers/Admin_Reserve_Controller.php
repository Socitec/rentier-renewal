<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class Admin_Reserve_Controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 宿泊予約用のフォームを返す
    public function stay(){
        return view('admin_calendar_reserve_stay');
    }

    // 時間貸し予約用のフォームを返す
    public function time(){
        return view('admin_calendar_reserve_time');
    }

    // 渡された情報を元に予約を行う
    public function create(Request $request){
        // リクエストパラメータのstatusの値が宿泊か時間貸しかによって処理を変える
        if($request->status=="stay"){
            // 宿泊の処理
            // バリデーションチェック
            $rules = [
                'date' => 'required',
                'stay_people' => 'required | max:3',
                'checkin_time' => 'max:20',
            ];
            $messages = [
                'date.required' => '日付を入力してください。',
                'stay_people.required' => '宿泊人数を入力してください。',
                'stay_people.max' => '宿泊人数は3桁以内の整数を入力してください。',
                'checkin_time.max' => 'チェックイン時間は20文字以内で入力してください。',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect('/admin_reserve_stay')
                ->withErrors($validator)
                ->withInput();
            }

            // 部屋と日時で既に予約が入っていないかどうか確認、もしあったらinsert処理をせずにエラーメッセージを返す
            $check1 = \DB::table('reservation_stay')->where('room_id', $request->room)->where('date', $request->date)->where('role', 2)->exists();
            $check2 = \DB::table('reservation_time')->where('room_id', $request->room)->where('date', $request->date)->where('role', 2)->exists();
            
            if ($check1==true||$check2==true){
                $message = "既にその日には決済済みの予約があるため登録処理ができませんでした。他の日付、又は他の部屋を選択してください。";
                return view('admin_reserve_comp', ['message'=>$message]);
            }

            // insert処理(この際、role2,another_reserve_flgをtrueにする)
            \DB::table('reservation_stay')->insert([
                'room_id' => $request->room,
                'name' => $request->name,
                'email' => $request->email,
                'tel' => $request->tel,
                'checkin_time' => $request->checkin_time,
                'date' => $request->date,
                'role' => 2,
                'stay_date_num' => 1,
                'stay_people' => $request->stay_people,
                'another_reserve_flg' => 1,
            ]);

            $message = "宿泊予約が完了しました。続けて予約を行う場合や管理者側で行われた予約を取り消す場合は以下のボタンより移動をお願い致します。";

            return view('admin_reserve_comp', ['message'=>$message]);
        } elseif($request->status=="time"){
            // 時間貸しの処理
            // バリデーションチェック
            $rules = [
                'date' => 'required',
                'start_time' => 'max:20',
                'end_time' => 'max:20',
                'stay_people' => 'required | max:3',
            ];
            $messages = [
                'date.required' => '日付を入力してください。',
                'stay_people.required' => '利用人数を入力してください。',
                'stay_people.max' => '利用人数は3桁以内の整数を入力してください。',
                'start_time.max' => '利用開始時間は20文字以内で入力してください。',
                'end_time.max' => '利用終了時間は20文字以内で入力してください。',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect('/admin_reserve_time')
                ->withErrors($validator)
                ->withInput();
            }

            // 部屋と日時で既に予約が入っていないかどうか確認、もしあったらinsert処理をせずにエラーメッセージを返す
            $check1 = \DB::table('reservation_stay')->where('room_id', $request->room)->where('date', $request->date)->where('role', 2)->exists();
            $check2 = \DB::table('reservation_time')->where('room_id', $request->room)->where('date', $request->date)->where('role', 2)->exists();
                        
            if ($check1==true||$check2==true){
                $message = "既にその日には決済済みの予約があるため登録処理ができませんでした。他の日付、又は他の部屋を選択してください。";
                return view('admin_reserve_comp', ['message'=>$message]);
            }

            // insert処理(この際、role2,another_reserve_flgをtrueにする)
            \DB::table('reservation_time')->insert([
                'room_id' => $request->room,
                'name' => $request->name,
                'email' => $request->email,
                'tel' => $request->tel,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'date' => $request->date,
                'role' => 2,
                'stay_people' => $request->stay_people,
                'another_reserve_flg' => 1,
            ]);

            $message = "時間貸し予約が完了しました。続けて予約を行う場合や管理者側で行われた予約を取り消す場合は以下のボタンより移動をお願い致します。";

            return view('admin_reserve_comp', ['message'=>$message]);
        }
    }

    // 管理者側で行われた予約を取り消すためのフォームを返す
    public function delete() {
        return view('admin_calender_reserve_clear');
    }

    // 日付と部屋番号を元にして管理者側で行われた予約を取り消す
    public function destroy(Request $request){
        // バリデーションチェック
        $rules = [
            'date' => 'required',
        ];
        $messages = [
            'date.required' => '日付を入力してください。',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('/admin_reserve_clear_form')
            ->withErrors($validator)
            ->withInput();
        }

        // 入力された情報に一致し、かつrole2, another_reserve_flg1のクエリがあるかどうか
        $target1 = \DB::table('reservation_stay')->where('room_id', $request->room)
                                                ->where('date', $request->date)
                                                ->where('role', 2)
                                                ->where('another_reserve_flg', 1)
                                                ->exists();

        $target2 = \DB::table('reservation_time')->where('room_id', $request->room)
                                                ->where('date', $request->date)
                                                ->where('role', 2)
                                                ->where('another_reserve_flg', 1)
                                                ->exists();

        // 宿泊ないし時間貸しのどちらかに目的のクエリがあったらそれを消去する
        if ($target1 == true){
            \DB::table('reservation_stay')->where('room_id', $request->room)
                                        ->where('date', $request->date)
                                        ->where('role', 2)
                                        ->where('another_reserve_flg', 1)
                                        ->delete();

            $message = "該当する宿泊予約が消去されました。";
        } elseif ($target2 == true){
            \DB::table('reservation_time')->where('room_id', $request->room)
                                        ->where('date', $request->date)
                                        ->where('role', 2)
                                        ->where('another_reserve_flg', 1)
                                        ->delete();

            $message = "該当する時間貸し予約が消去されました。";
        } else {
            $message = "該当する予約情報が見つかりませんでした。日付または部屋番号を確認してください。";
        }

        return view('admin_reserve_destroy_comp', ["message"=>$message]);
    }
}
