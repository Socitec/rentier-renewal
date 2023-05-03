<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class calendar_Logic extends Model
{
    public function reservation_calendar_get($data, $id)
    {
        date_default_timezone_set('Asia/Tokyo');

        // フロントに表示するカレンダーの情報
        $calendardays = [];

        // 月末までの情報を表示
        $enddate = date('Y-m-d', strtotime('last day of' . $data));

        // 起算日と月末の日付を取得
        $start = substr($data, -2);
        $ss = substr($data, 0, 8);
        $end = substr($enddate, -2);

        // 起算日が月初であるかそうでないかによって処理を分岐
        // 起算日が月初でないとき
        // 起算日までのstateを✕にして配列に入れる
        if ($start != 1)
        {
            // 起算日まで×を入れる
            for ($i = 0; $i < $start; $i++){
                array_push($calendardays, "×");
            }
            // その後起算日から月末までループで判定
            for ($i = $start; $i < $end+1; $i++){
                // カウンターを作って予約できるかどうかを判定
                $counter = 1;

                // 対象の日付について予約があるかどうかを確認(宿泊)
                $stay_reserve = \DB::table('reservation_stay')
                                ->where('room_id', $id)
                                ->where('role', 2)
                                ->where('date', $ss.$i)
                                ->exists();
    
                // 対象の日付について予約があるかどうか(時間貸し)
                $time_reserve = \DB::table('reservation_time')
                                ->where('room_id', $id)
                                ->where('role', 2)
                                ->where('date', $ss.$i)
                                ->exists();
                
                // $stay_reserveと$time_reserveのいずれかがtrueだったら$counterから1を引く
                if ($stay_reserve == true) {
                    $counter--;
                } elseif ($time_reserve == true) {
                    $counter--;
                }

                if ($counter == 0){
                    array_push($calendardays, "×");
                } else {
                    array_push($calendardays, "○");
                }
            }
        }
        // 起算日が月初の時
        else
        {
            for ($i = 0; $i < $end + 1; $i++){
                // カウンターを作って予約できるかどうかを判定
                $counter = 1;

                // 対象の日付について予約があるかどうかを確認(宿泊)
                $stay_reserve = \DB::table('reservation_stay')
                                ->where('room_id', $id)
                                ->where('role', 2)
                                ->where('date', $ss.$i)
                                ->exists();
    
                // 対象の日付について予約があるかどうか(時間貸し)
                $time_reserve = \DB::table('reservation_time')
                                ->where('room_id', $id)
                                ->where('role', 2)
                                ->where('date', $ss.$i)
                                ->exists();
                
                // $stay_reserveと$time_reserveのいずれかがtrueだったら$counterから1を引く
                if ($stay_reserve == true) {
                    $counter--;
                } elseif ($time_reserve == true) {
                    $counter--;
                }

                if ($counter == 0){
                    array_push($calendardays, "×");
                } else {
                    array_push($calendardays, "○");
                }
            }
        }
        
        return $calendardays;
    }
}
