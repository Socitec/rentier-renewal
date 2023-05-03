@extends('rooms_reserve')

@section('alert')
<!-- <p class="bold text-red">※宿泊をご利用の皆様へ</p>
<p class="bold text-red">　今月末のタイミングで今月末から月またぎで予約をしようとすると必要事項を入力した後翌月へと移動してもデータが保存されない場合がございます。その場合はお手数をおかけしますが今月末の予約を取った後で改めて翌月以降の予約申し込みをお願い致します。</p> -->
@endsection

@section('schedule')
<table class="mt-4">
    <tr>
        <th><h2>予約日</h2></th>
        <td><p class="contact_require">必須</p></td>
        @error('date')
        <th><h5 class="error_text">{{$message}}</h5></th>  
        @enderror
    </tr>
</table>
<!-- ボタンクリックで月移動 -->
<div id="next-prev-button">
    <?php $url = $_SERVER['REQUEST_URI'];
    $url = str_replace('/roomsreserve_stay', '', $url);
    if (isset($room_id)) {
    } else {
        $room_id = $_GET['room_id'];
    }
    if (isset($add_data_id)){
    } else {
        $add_data_id = $_GET['add_data_id'];
    } 

    if (isset($this_month)) {
        $key_month = date('Y-m-d', strtotime('first day of'.$this_month));
        $next = date('Y-m-d', strtotime($key_month.'+1 month'));
        $prev = date('Y-m-d', strtotime($key_month.'-1 month'));
    } else {
        $key_month = date('Y-m');
        $next = date('Y-m-d', strtotime($key_month.'-01+1 month'));
        $prev = date('Y-m-d', strtotime($key_month.'-01-1 month'));
    }
    ?>
    @if (isset($this_month))
    <div id="nm"><a class="btn btn-primary float-right" href="/roomsreserve_stay/{{$next}}/{{$room_id}}/{{$add_data_id}}/{{$name}}/{{$mail}}/0000000000/2021-01-01/0/0:00/0/0/1/next">></a></div>
    <div id="pm"><a class="btn btn-primary" href="/roomsreserve_stay/{{$prev}}/{{$room_id}}/{{$add_data_id}}/{{$name}}/{{$mail}}/0000000000/2021-01-01/0/0:00/0/0/1/prev"><</a></div>
    @else
    <div id="nm"><a class="btn btn-primary float-right" href="/roomsreserve_stay/{{$next}}/{{$room_id}}/{{$add_data_id}}/{{$name}}/{{$mail}}/0000000000/2021-01-01/0/0:00/0/0/1/next">></a></div>
    <div id="pm"><a class="btn btn-primary" href="/roomsreserve_stay/{{$prev}}/{{$room_id}}/{{$add_data_id}}/{{$name}}/{{$mail}}/0000000000/2021-01-01/0/0:00/0/0/1/prev"><</a></div>
    @endif
</div>
<div class="text-center mt-3"><h2 id="currentmonth"></h2></div>
<!-- カレンダー -->
<div id="calendar"></div>
<div class="text-center mt-2">
    <div class="btn btn-primary" onclick="radioDeselection()">選択を解除</div>
</div>
<table class="mt-4">
    <tr>
        <th><h2>宿泊日数</h2></th>
        <td><p class="contact_require">必須</p></td>
        <td><h2>料金</h2></td>
        <td><h2 id="room_price"></h2></td>
    </tr>
</table>
<table>
    <tr>
        <th><div id="minus_button"></div></th>
        @if(isset($get_query2))
        <td class="full_width"><input class="full_width" name="stay_date_num" readonly type="number" id="stay_date_num" value="{{$get_query2->stay_date_num}}"></td>
        @else
        <td class="full_width"><input class="full_width" name="stay_date_num" readonly type="number" id="stay_date_num" value="1"></td>
        @endif
        <td><div id="plus_button"></div></td>
    </tr>
</table>
<input type="hidden" name="stradding_the_moon_flg" id="stradding_the_moon_flg" value="1">
<input type="hidden" name="reset_flg" id="reset_flg" value="0">
<table class="mt-4">
    <tr>
        <th><h2>チェックイン</h2></th>
        <td><p class="contact_require">必須</p></td>
        @error('checkin_time')
        <th><h5 class="error_text">{{$message}}</h5></th>  
        @enderror
    </tr>
</table>
<select name="checkin_time" id="checkin_time" type="time" class="form-control border_require @error('checkin_time') is-invalid @enderror">
    @if(isset($get_query))
    <option value="{{$get_query->checkin_time}}">{{$get_query->checkin_time}}</option>
    @else
    <option value="">時間を選択してください</option>
    @endif
    <!-- <option value="00:00">00:00</option>
    <option value="00:30">00:30</option>
    <option value="01:00">01:00</option>
    <option value="01:30">01:30</option>
    <option value="02:00">02:00</option>
    <option value="02:30">02:30</option>
    <option value="03:00">03:00</option>
    <option value="03:30">03:30</option>
    <option value="04:00">04:00</option>
    <option value="04:30">04:30</option>
    <option value="05:00">05:00</option>
    <option value="05:30">05:30</option>
    <option value="06:00">06:00</option>
    <option value="06:30">06:30</option>
    <option value="07:00">07:00</option>
    <option value="07:30">07:30</option>
    <option value="08:00">08:00</option>
    <option value="08:30">08:30</option>
    <option value="09:00">09:00</option>
    <option value="09:30">09:30</option>
    <option value="10:00">10:00</option>
    <option value="10:30">10:30</option>
    <option value="11:00">11:00</option>
    <option value="11:30">11:30</option>
    <option value="12:00">12:00</option>
    <option value="12:30">12:30</option>
    <option value="13:00">13:00</option>
    <option value="13:30">13:30</option>
    <option value="14:00">14:00</option>
    <option value="14:30">14:30</option> -->
    <option value="15:00">15:00</option>
    <option value="15:30">15:30</option>
    <option value="16:00">16:00</option>
    <option value="16:30">16:30</option>
    <option value="17:00">17:00</option>
    <option value="17:30">17:30</option>
    <option value="18:00">18:00</option>
    <option value="18:30">18:30</option>
    <option value="19:00">19:00</option>
    <option value="19:30">19:30</option>
    <option value="20:00">20:00</option>
    <option value="20:30">20:30</option>
    <option value="21:00">21:00</option>
    <option value="21:30">21:30</option>
    <option value="22:00">22:00</option>
    <option value="22:30">22:30</option>
    <option value="23:00">23:00</option>
    <option value="23:30">23:30</option>
    <!-- <option value="24:00">24:00</option> -->
</select>
<div id="countdays"></div>
@endsection

@section('script')
<?php
if (isset($this_month)){
    $now = date('Y-m-d');
    $future = date('Y-m-d', strtotime('+2 month'));
    if (strtotime($future) - strtotime($this_month) < 0) {
        $year = substr($future, 0, 4);
        $month = substr($future, 5, 2);
    } elseif (strtotime($this_month) - strtotime($now) < 0) {
        $year = substr($now, 0, 4);
        $month = substr($now, 5, 2);
    } else {
        $year = substr($this_month, 0, 4);
        $month = substr($this_month, 5, 2);
    }
} else {
    $this_month = date('Y-m-d');
    $year = substr($this_month, 0, 4);
    $month = substr($this_month, 5, 2);
}
?>
<script>
var confirm = document.getElementById('confirm');
var accept = document.getElementById('accept');
var stay_dates = document.getElementById('stay_date_num');
var flag = false;
var flag1 = false;
var counter = 0;
var customer = document.getElementById('name');
var email = document.getElementById('email');
var tel = document.getElementById('tel');
var stay_num = document.getElementById('stay_date_num');
var checkin = document.getElementById('checkin_time');
var stay_people = document.getElementById('stay_people');

if (flag == false){
    confirm.innerHTML = '';
} else {
    confirm.innerHTML = '<input type="submit" class="btn btn-primary text-white rounded-pill bold wide90" value="決済画面へ">';
}

// 料金計算のための下準備(配列内に料金とget_query2の値を突っ込む)
var calculate_pay = [];
calculate_pay.push('{{$room_price}}');
@if(isset($get_query3))
calculate_pay.push('{{$get_query3->stay_date_num}}');
@endif
@if(isset($get_query4))
calculate_pay.push('{{$get_query4->stay_date_num}}');
@endif

const week = ["日", "月", "火", "水", "木", "金", "土"];
const today = new Date();
// 月末だとずれる可能性があるため、1日固定で取得
var showDate = new Date(today.getFullYear(), today.getMonth(), 1);

// 初期表示
window.onload = function () {
    showProcess(today, calendar);
};
// 前の月表示
function prev(){
    showDate.setMonth(showDate.getMonth() - 1);
    showProcess(showDate);
}

// 次の月表示
function next(){
    showDate.setMonth(showDate.getMonth() + 1);
    showProcess(showDate);
}

// カレンダー表示
function showProcess(date) {
    var year = {{$year}}; //date.getFullYear();
    var month = {{$month}}; //date.getMonth();
    // document.querySelector('#header').innerHTML = year + "年 " + (month + 1) + "月";
    var current = document.getElementById('currentmonth');
    current.textContent = year + '年' + month + '月';

    var calendar = createProcess(year, month);
    document.querySelector('#calendar').innerHTML = calendar;
}

// カレンダー作成
function createProcess(year, month) {
    // LaravelのDB用に月をフォーマット化
    var month1 = month - 1;
    if (month1 > 12) {
        month1 = 1;
    }
    else if (month1 < 10) {
        month1 = "0" + month1;
    }
    var month2 = month;
    if (month2 > 12) {
        month2 = 1;
    } else if (month2 < 10) {
        month2 = "0" + month2;
    }
    // このままだとtoday.getMonth()の値が一月前のものとなるためここで調整する
    var tm = today.getMonth() + 1;
    if (tm > 12) {
        tm = "01";
    } else if (tm < 10) {
        tm = "0" + tm;
    }
    // 曜日
    var calendar = "<table class='cal_table mx-auto'><tr class='dayOfWeek'>";
    for (var i = 0; i < week.length; i++) {
        calendar += "<th class='line'>" + week[i] + "</th>";
    }
    calendar += "</tr>";

    // 月またぎの予約がされようとしている際に翌月の一日しかチェックできないようにする処理(下準備)
    <?php
    if(isset($get_query3)){
        $start = $get_query3->date;
        $number = $get_query3->stay_date_num;
        $number2 = $number - 1;
        $last = date('Y-m-d', strtotime($start.'+'.$number2.' days'));
    }
    ?>
    // 月またぎがされてるかどうかの判定配列
    var comparent = [];
    @if(isset($last))
    comparent.push('{{$last}}');
    @endif

    var count = 0;
    var startDayOfWeek;
    var sentence = year + "-" + month + "-1";
    startDayOfWeek = new Date(sentence).getDay();
    var endDate = new Date(year, month2, 0).getDate();
    var lastMonthEndDate = new Date(year, month1, 0).getDate();
    var row = Math.ceil((startDayOfWeek + endDate) / week.length);
    var arr = [];
    @foreach($calendars as $calendar)
    arr.push('{{$calendar}}');
    @endforeach
    var arr2 = [];
    @if(isset($get_query2))
    arr2.push('{{$get_query2->date}}');
    @endif

    // 月またぎ判定用に先月の末日の情報を取得して配列comparentに格納
    var data_month = year + "-" + month + "-01";
    var now_month = new Date(data_month);
    var last_month = new Date(now_month.getFullYear(), now_month.getMonth(), 0);
    var ls_year = last_month.getFullYear();
    var ls_month = last_month.getMonth() + 1;
    var ls_day = last_month.getDate();
    var lm_end = ls_year + "-" + ls_month + "-" + ls_day;
    comparent.push(lm_end);

    // 1行ずつ設定
    for (var i = 0; i < row; i++) {
        calendar += "<tr>";
        // 1colum単位で設定
        for (var j = 0; j < week.length; j++) {
            if (i == 0 && j < startDayOfWeek) {
                // 1行目で1日まで先月の日付を設定
                calendar += "<td class='disabled line'>" + (lastMonthEndDate - startDayOfWeek + j + 1) + "</td>";
            } else if (count >= endDate) {
                // 最終行で最終日以降、翌月の日付を設定
                count++;
                calendar += "<td class='disabled line'>" + (count - endDate) + "</td>";
            } else {
                // 当月の日付を曜日に照らし合わせて設定
                count++;
                // LaravelのDB登録用に日付をフォーマット化
                if (count < 10){
                    var count1 = "0" + count;
                } else {
                    var count1 = count;
                }
                // ステータス表示用にcountを用意
                var count2 = count;
                // 月またぎしているかしていないかで処理を変える
                if (comparent[0]!=undefined&&comparent[1]!=undefined&&comparent[0]==comparent[1]){
                    // 月またぎしているなら初日しかチェックできないようにする、初日が×だったらそもそもチェックできないようにする
                    // もし日曜日だったら
                    if(j==0){
                        if(year == today.getFullYear()
                        && month == tm
                        && count == today.getDate()){
                            if (arr[count2]=="×"){
                                calendar += "<td class='today line sunday' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='" + year + "-" + month + "-" + count1 + "'>" + count1 + " ×</span></td>";
                            } else {
                                if (count1 == "01"){
                                    if (arr2[0]==year+'-'+month+'-'+count1){
                                        calendar += "<td class='today line sunday' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' checked name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                    } else {
                                        calendar += "<td class='today line sunday' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                    }
                                } else {
                                    if (arr2[0]==year+'-'+month+'-'+count1){
                                        calendar += "<td class='today line sunday' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></td>";
                                    } else {
                                        calendar += "<td class='today line sunday' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></td>";
                                    }
                                }
                            }
                        } else {
                            if (year == today.getFullYear()
                            && month == tm
                            && count < today.getDate()){
                                calendar += "<td class='line sunday' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " ×</span></td>";
                            } else {
                                if (arr[count2]=="×"){
                                    calendar += "<td class='line sunday' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " ×</span></td>";
                                } else {
                                    if (count1 == "01"){
                                        if (arr2[0]==year+'-'+month+'-'+count1){
                                            calendar += "<td class='line sunday' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' checked name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                        } else {
                                            calendar += "<td class='line sunday' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                        }
                                    } else {
                                        if (arr2[0]==year+'-'+month+'-'+count1){
                                            calendar += "<td class='line sunday' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></td>";
                                        } else {
                                            calendar += "<td class='line sunday' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></td>";
                                        }
                                    }
                                }
                            }
                        }
                    } else if (j==6){
                        // もし土曜日だったら
                        if(year == today.getFullYear()
                          && month == tm
                          && count == today.getDate()){
                            if (arr[count2]=="×"){
                                calendar += "<td class='today line saturday' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " ×</span></td>";
                            } else {
                                if (count1 == "01"){
                                    if (arr2[0]==year+'-'+month+'-'+count1){
                                        calendar += "<td class='today line saturday' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' checked name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                    } else {
                                        calendar += "<td class='today line saturday' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                    }
                                } else {
                                    if (arr2[0]==year+'-'+month+'-'+count1){
                                        calendar += "<td class='today line saturday' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></td>";
                                    } else {
                                        calendar += "<td class='today line saturday' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></td>";
                                    }
                                }
                            }
                        } else {
                            if (year == today.getFullYear()
                            && month == tm
                            && count < today.getDate()){
                                calendar += "<td class='line saturday' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " ×</span></td>";
                            } else {
                                if (arr[count2]=="×"){
                                    calendar += "<td class='line saturday' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " ×</span></td>";
                                } else {
                                    if (count1 == "01"){
                                        if (arr2[0]==year+'-'+month+'-'+count1){
                                            calendar += "<td class='line saturday' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' checked name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                        } else {
                                            calendar += "<td class='line saturday' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                        }
                                    } else {
                                        if (arr2[0]==year+'-'+month+'-'+count1){
                                            calendar += "<td class='line saturday' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></td>";
                                        } else {
                                            calendar += "<td class='line saturday' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></td>";
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        // それ以外
                        if(year == today.getFullYear()
                          && month == tm
                          && count == today.getDate()){
                            if (arr[count2]=="×"){
                                calendar += "<td class='today line' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " ×</span></td>";
                            } else {
                                if (count1 == "01") {
                                    if (arr2[0]==year+'-'+month+'-'+count1){
                                        calendar += "<td class='today line' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' checked name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                    } else {
                                        calendar += "<td class='today line' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                    }
                                } else {
                                    if (arr2[0]==year+'-'+month+'-'+count1){
                                        calendar += "<td class='today line' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></td>";
                                    } else {
                                        calendar += "<td class='today line' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></td>";
                                    }
                                }
                            }
                        } else {
                            if (year == today.getFullYear()
                            && month == tm
                            && count < today.getDate()){
                                calendar += "<td class='line' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " ×</span></td>";
                            } else {
                                if (arr[count2]=="×"){
                                    calendar += "<td class='line' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " ×</span></td>";
                                } else {
                                    if (count1 == "01") {
                                        if (arr2[0]==year+'-'+month+'-'+count1){
                                            calendar += "<td class='line' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' checked name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                        } else {
                                            calendar += "<td class='line' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                        }
                                    } else {
                                        if (arr2[0]==year+'-'+month+'-'+count1){
                                            calendar += "<td class='line' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></td>";
                                        } else {
                                            calendar += "<td class='line' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></td>";
                                        }
                                    }
                                }
                            }
                        }
                    }
                    calendar += "<td class='line hidden' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                } else {
                    // 月またぎしていないときの処理
                    // もし日曜日だったら
                    if(j==0){
                        if(year == today.getFullYear()
                        && month == tm
                        && count == today.getDate()){
                            if (arr[count2]=="×"){
                                calendar += "<td class='today line sunday' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='" + year + "-" + month + "-" + count1 + "'>" + count1 + " ×</span></td>";
                            } else {
                                if (arr2[0]==year+'-'+month+'-'+count1){
                                    calendar += "<td class='today line sunday' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' checked name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                } else {
                                    calendar += "<td class='today line sunday' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                }
                            }
                        } else {
                            if (year == today.getFullYear()
                            && month == tm
                            && count < today.getDate()){
                                calendar += "<td class='line sunday' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count1 + "'>" + count1 + " ×</span></td>";
                            } else {
                                if (arr[count2]=="×"){
                                    calendar += "<td class='line sunday' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count1 + "'>" + count1 + " ×</span></td>";
                                } else {
                                    if (arr2[0]==year+'-'+month+'-'+count1){
                                        calendar += "<td class='line sunday' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' checked name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                    } else {
                                        calendar += "<td class='line sunday' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                    }
                                }
                            }
                        }
                    } else if (j==6){
                        // もし土曜日だったら
                        if(year == today.getFullYear()
                          && month == tm
                          && count == today.getDate()){
                            if (arr[count2]=="×"){
                                calendar += "<td class='today line saturday' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count1 + "'>" + count1 + " ×</span></td>";
                            } else {
                                if (arr2[0]==year+'-'+month+'-'+count1){
                                    calendar += "<td class='today line saturday' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' checked name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                } else {
                                    calendar += "<td class='today line saturday' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                }
                            }
                        } else {
                            if (year == today.getFullYear()
                            && month == tm
                            && count < today.getDate()){
                                calendar += "<td class='line saturday' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count1 + "'>" + count1 + " ×</span></td>";
                            } else {
                                if (arr[count2]=="×"){
                                    calendar += "<td class='line saturday' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count1 + "'>" + count1 + " ×</span></td>";
                                } else {
                                    if (arr2[0]==year+'-'+month+'-'+count1){
                                        calendar += "<td class='line saturday' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' checked name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                    } else {
                                        calendar += "<td class='line saturday' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                    }
                                }
                            }
                        }
                    } else {
                        // それ以外
                        if(year == today.getFullYear()
                          && month == tm
                          && count == today.getDate()){
                            if (arr[count2]=="×"){
                                calendar += "<td class='today line' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count1 + "'>" + count1 + " ×</span></td>";
                            } else {
                                if (arr2[0]==year+'-'+month+'-'+count1){
                                    calendar += "<td class='today line' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' checked name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                } else {
                                    calendar += "<td class='today line' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                }
                            }
                        } else {
                            if (year == today.getFullYear()
                            && month == tm
                            && count < today.getDate()){
                                calendar += "<td class='line' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count1 + "'>" + count1 + " ×</span></td>";
                            } else {
                                if (arr[count2]=="×"){
                                    calendar += "<td class='line' id='fill_" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count1 + "'>" + count1 + " ×</span></td>";
                                } else {
                                    if (arr2[0]==year+'-'+month+'-'+count1){
                                        calendar += "<td class='line' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' checked name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                    } else {
                                        calendar += "<td class='line' id='fill_" + year + "-" + month + "-" + count1 + "'><label><input type='radio' name='date' id='" + year + "-" + month + "-" + count1 + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        calendar += "</tr>";
    }
    return calendar;
}

var save_array = [];
save_array.splice(0, 1, customer.value);
save_array.splice(1, 1, email.value);
save_array.splice(2, 1, tel.value);
save_array.splice(3, 1, checkin.value);
save_array.splice(4, 1, stay_people.value);

window.addEventListener('DOMContentLoaded', function(){
    accept.addEventListener("change",function(){
        if (accept.checked==true){
            flag = true;
        } 

        if (accept.checked==false){
            flag = false;
        }

        if (flag == false){
            confirm.innerHTML = '';
        } else {
            confirm.innerHTML = '<input type="submit" class="btn btn-primary text-white rounded-pill bold wide90" formaction="/roomsreserve_stay/preview/{{$room_id}}/{{$add_data_id}}" value="決済画面へ">';
        }
    });

    customer.addEventListener("change",function(){
        save_array.splice(0, 1, this.value);
    });

    email.addEventListener("change",function(){
        save_array.splice(1, 1, this.value);
    });

    tel.addEventListener("change",function(){
        save_array.splice(2, 1, this.value);
    });

    checkin.addEventListener("change",function(){
        save_array.splice(3, 1, this.value);
    });

    stay_people.addEventListener("change",function(){
        save_array.splice(4, 1, this.value);
    });
});

// チェックがある場合の日付を探す
function check_id(){
    @if(isset($get_query))
    var target_day = document.getElementById('{{$get_query->date}}');
    target_day.checked=true;
    @endif
}

setTimeout(check_id, 1000);

var judgement_arr = [];

// get_query2がある場合設定された日付が変更になった時点で宿泊日数をリセットする
var setting_check = [];
@if(isset($get_query2))
setting_check.push('{{$get_query2->date}}')
@endif

// 毎秒カレンダー内のチェックの場所を探す
function search_check(){
    for (var i = 0; i <= document.form1.date.length; i++){
        if (document.form1.date[i].checked) {
            flag1 = true;
            // 関数が走る最初のタイミングで一度全ての塗りつぶしをリセットする
            for (var d=0; d<3; d++){
                var targetElements = document.getElementsByClassName('fill_green');
                [].forEach.call(targetElements, function(elem) {
                    elem.classList.remove('fill_green');
                })
            }
            var attribute = document.form1.date[i].getAttribute("id");
            setting_check.push(attribute);
            if (setting_check[0]!=undefined&&setting_check[1]!=undefined){
                if (setting_check[0]==setting_check[1]){
                    setting_check.splice(1, 1);
                } else if (setting_check[0]!=setting_check[1]){
                    setting_check.shift();
                    document.getElementById('stay_date_num').value = 1;
                } else if (setting_check.length > 2) {
                    setting_check.splice(1, 1);
                }
            }
            // 関数実行時に日付の情報をjudge_arrに格納
            if (judgement_arr[0]==judgement_arr[1]) {
                // 配列内の値が同一の時先頭の値を常時消す
                judgement_arr.shift();
            } else if (judgement_arr[0]!=undefined&&judgement_arr[1]!=undefined&&judgement_arr[0]!=judgement_arr[1]) {
                // 配列内の値が異なるとき宿泊日数をリセットする
                document.getElementById('stay_date_num').value = 1;
                judgement_arr.shift();
            }
            // まずチェックが付いた箇所を塗りつぶす
            var fill_color = document.getElementById('fill_' + attribute);
            fill_color.classList.add('fill_green');
            // 取得した日付を元にして連泊日数を加算できるかどうかを判定し、できない場合は+ボタンを消す
            // 連泊する日数を取得
            var days = document.getElementById('stay_date_num').value;
            // 判定変数
            var judge = Number(days);
            // 判定変数が決まった段階で次々と塗りつぶしていく
            for (var j=0; j<judge; j++){
                // 開始日を設定
                var start = attribute + " 00:00:00";
                var start2 = new Date(start);
                var fill = start2.setDate(start2.getDate() + j);
                var fill2 = new Date(fill);
                var fillyear = fill2.getFullYear();
                var fillmonth = fill2.getMonth() + 1;
                var fillday = fill2.getDate();
                if (fillday < 10) {
                    fillday = "0" + fillday;
                }
                var fill_green_date = fillyear + "-" + fillmonth + "-" + fillday;
                var fill_color_date = document.getElementById('fill_' + fill_green_date);
                fill_color_date.classList.add('fill_green');
            }
            // チェックされた日付+連泊日数+1の結果値とチェックされた日付+1が○かどうかを判定、○がなかったら+ボタンを消す月またぎの判定もここでできるようにしていく
            var startdate = attribute + " 00:00:00";
            var startdate2 = new Date(startdate);
            var startdate3 = new Date(startdate);
            var startdate4 = new Date(startdate);
            var judgedate = startdate2.setDate(startdate2.getDate() + judge);
            // これを1泊以上の時の判定に使う
            var judgedate2 = new Date(judgedate);
            var judgedate1_1 = startdate3.setDate(startdate3.getDate() + 1);
            // 翌日のステータスの判定に使う
            var judgedate1_2 = new Date(judgedate1_1);
            // それぞれに判定用の日付を取得する
            var judgeyear1 = judgedate2.getFullYear();
            var judgemonth1 = judgedate2.getMonth() + 1;
            var judgeday1 = judgedate2.getDate();
            // 2日後の日付の取得
            var two_days_next = judgeyear1 + "-" + judgemonth1 + "-" + judgeday1;
            var judgeyear2 = judgedate1_2.getFullYear();
            var judgemonth2 = judgedate1_2.getMonth() + 1;
            var judgeday2 = judgedate1_2.getDate();
            // 翌日の日付を取得
            var one_day_next = judgeyear2 + "-" + judgemonth2 + "-" + judgeday2;
            // チェックされた日付の前日を判定
            var beforedate = startdate4.setDate(startdate4.getDate() - 1);
            // この値で前日のステータスを把握する
            var beforedate2 = new Date(beforedate);
            // それぞれに判定用の日付を取得
            var beforeyear = beforedate2.getFullYear();
            var beforemonth = beforedate2.getMonth() + 1;
            var beforeday = beforedate2.getDate();
            var one_day_before = beforeyear + "-" + beforemonth + "-" + beforeday;
            // 翌日のステータスが○かどうかを判定
            if (document.getElementById('data_' + one_day_next)!=null){
                var next_day_state = document.getElementById('data_' + one_day_next).textContent;
                var next_day_judge = next_day_state.indexOf('○');
                var next_day_judge_1 = next_day_state.indexOf('×');
                if (document.getElementById('data_' + one_day_before)!=null){
                    var before_day_state = document.getElementById('data_' + one_day_before).textContent;
                    var before_day_judge = before_day_state.indexOf('○');
                    var before_day_judge_1 = before_day_state.indexOf('×');
                } else {
                    var before_day_judge = null;
                    var before_day_judge_1 = null;
                }
            } else {
                var next_day_judge = null;
                var next_day_judge_1 = null;
                if (document.getElementById('data_' + one_day_before)!=null){
                    var before_day_state = document.getElementById('data_' + one_day_before).textContent;
                    var before_day_judge = before_day_state.indexOf('○');
                    var before_day_judge_1 = before_day_state.indexOf('×');
                } else {
                    var before_day_judge = null;
                    var before_day_judge_1 = null;
                }
            }
            // +ボタンで連泊する場合翌々日のステータスを判定する
            if (document.getElementById('data_' + two_days_next)!=null){
                var next_day_state2 = document.getElementById('data_' + two_days_next).textContent;
                var next_day_judge2 = next_day_state2.indexOf('○');
                var next_day_judge2_1 = next_day_state2.indexOf('×');
                if (document.getElementById('data_' + one_day_before)!=null){
                    var before_day_state = document.getElementById('data_' + one_day_before).textContent;
                    var before_day_judge = before_day_state.indexOf('○');
                    var before_day_judge_1 = before_day_state.indexOf('×');
                } else {
                    var before_day_judge = null;
                    var before_day_judge_1 = null;
                }
            } else {
                var next_day_judge2 = null;
                var next_day_judge2_1 = null;
                if (document.getElementById('data_' + one_day_before)!=null){
                    var before_day_state = document.getElementById('data_' + one_day_before).textContent;
                    var before_day_judge = before_day_state.indexOf('○');
                    var before_day_judge_1 = before_day_state.indexOf('×');
                } else {
                    var before_day_judge = null;
                    var before_day_judge_1 = null;
                }
            }
            // 連泊でない場合
            if (judge == 1) {
                if (next_day_judge == 3){
                    // 条件に合致するので+ボタンを出す
                    document.getElementById('plus_button').innerHTML = '<div onclick="plus()" class="btn btn-primary bold pt-1 pb-1">+</div>';
                    // 前日に○×のステータスがあるかないかで月またぎかどうかを判定する
                    if (before_day_judge == 3||before_day_judge_1 == 3){
                        // stradding_the_moon_flgを0にする(月またぎの予約ではない場合stradding_the_moon_flgを0にし月を移動できないようにする)
                        document.getElementById('stradding_the_moon_flg').value = 0;
                    } else {
                        // stradding_the_moon_flgを1にする(月またぎの予約ではない場合stradding_the_moon_flgを0にし月を移動できないようにする)
                        document.getElementById('stradding_the_moon_flg').value = 1;
                    }
                } else if (next_day_judge_1 == 3) {
                    // 条件に合致しないので+ボタンを消す
                    document.getElementById('plus_button').innerHTML = '';
                    // 前日に○×のステータスがあるかないかで月またぎかどうかを判定する
                    if (before_day_judge == 3||before_day_judge_1 == 3){
                        // stradding_the_moon_flgを0にする(月またぎの予約ではない場合stradding_the_moon_flgを0にし月を移動できないようにする)
                        document.getElementById('stradding_the_moon_flg').value = 0;
                    } else {
                        // stradding_the_moon_flgを1にする(月またぎの予約ではない場合stradding_the_moon_flgを0にし月を移動できないようにする)
                        document.getElementById('stradding_the_moon_flg').value = 1;
                    }
                } else {
                    // 条件に合致しないので+ボタンを消す,月またぎできる状態のためstradding_the_moon_flgは1にする
                    document.getElementById('plus_button').innerHTML = '';
                    document.getElementById('stradding_the_moon_flg').value = 1;
                }
                document.getElementById('minus_button').innerHTML = '';
            }
            // 連泊の場合
            else if (judge > 1){
                if (next_day_judge2 == 3){
                    // 条件に合致するので+ボタンを出す
                    document.getElementById('plus_button').innerHTML = '<div onclick="plus()" class="btn btn-primary bold pt-1 pb-1">+</div>';
                    // 前日に○×のステータスがあるかないかで月またぎかどうかを判定する
                    if (before_day_judge == 3||before_day_judge_1 == 3){
                        // stradding_the_moon_flgを0にする(月またぎの予約ではない場合stradding_the_moon_flgを0にし月を移動できないようにする)
                        document.getElementById('stradding_the_moon_flg').value = 0;
                    } else {
                        // stradding_the_moon_flgを1にする(月またぎの予約ではない場合stradding_the_moon_flgを0にし月を移動できないようにする)
                        document.getElementById('stradding_the_moon_flg').value = 1;
                    }
                } else if (next_day_judge2_1 == 3) {
                    // 条件に合致しないので+ボタンを消す
                    document.getElementById('plus_button').innerHTML = '';
                    // 前日に○×のステータスがあるかないかで月またぎかどうかを判定する
                    if (before_day_judge == 3||before_day_judge_1 == 3){
                        // stradding_the_moon_flgを0にする(月またぎの予約ではない場合stradding_the_moon_flgを0にし月を移動できないようにする)
                        document.getElementById('stradding_the_moon_flg').value = 0;
                    } else {
                        // stradding_the_moon_flgを1にする(月またぎの予約ではない場合stradding_the_moon_flgを0にし月を移動できないようにする)
                        document.getElementById('stradding_the_moon_flg').value = 1;
                    }
                } else {
                    // 条件に合致しないので+ボタン消す,月またぎできる状態のためstradding_the_moon_flgは1にする
                    document.getElementById('plus_button').innerHTML = '';
                    document.getElementById('stradding_the_moon_flg').value = 1;
                }
                document.getElementById('minus_button').innerHTML = '<div onclick="minus()" class="btn btn-primary bold pt-1 pb-1">-</div>';
            }
            // 宿泊料金を計算する処理
            var price = document.getElementById('room_price');
            var cal = Number(document.getElementById('stay_date_num').value);
            var factor1 = calculate_pay[0];
            if (calculate_pay[1]!=undefined && calculate_pay[2]!=undefined){
                var factor2 = Number(calculate_pay[1]);
                var factor3 = Number(calculate_pay[2]);
                var total_price = factor1 * (cal + factor2 + factor3);
            } else if (calculate_pay[1]!=undefined) {
                var factor2 = Number(calculate_pay[1]);
                var total_price = factor1 * (cal + factor2);
            } else {
                var total_price = factor1 * cal;
            }
            price.textContent = total_price + "円";
            // カレンダーの遷移をするボタンの操作
            if (save_array.length==5&&save_array[2]!=""&&save_array[3]!=""&&save_array[4]!="") {
                document.getElementById('nm').innerHTML = '<a class="btn btn-primary float-right" href="/roomsreserve_stay/{{$next}}/{{$room_id}}/{{$add_data_id}}/' + customer.value + '/' + email.value + '/' + tel.value + '/' + attribute + '/' + days + '/' + checkin.value + '/' + document.getElementById('stradding_the_moon_flg').value + '/' + document.getElementById('reset_flg').value + '/' + stay_people.value + '/next">></a>';
                document.getElementById('pm').innerHTML = '<a class="btn btn-primary" href="/roomsreserve_stay/{{$prev}}/{{$room_id}}/{{$add_data_id}}/' + customer.value + '/' + email.value + '/' + tel.value + '/' + attribute + '/' + days + '/' + checkin.value + '/' + document.getElementById('stradding_the_moon_flg').value + '/' + document.getElementById('reset_flg').value + '/' + stay_people.value + '/prev"><</a>';
            } else {
                document.getElementById('nm').innerHTML = '<a class="btn btn-primary float-right" href="/roomsreserve_stay/{{$next}}/{{$room_id}}/{{$add_data_id}}/{{$name}}/{{$mail}}/0000000000/2021-01-01/0/0:00/0/0/1/next">></a>';
                document.getElementById('pm').innerHTML = '<a class="btn btn-primary" href="/roomsreserve_stay/{{$prev}}/{{$room_id}}/{{$add_data_id}}/{{$name}}/{{$mail}}/0000000000/2021-01-01/0/0:00/0/0/1/prev"><</a>';
            }
        }
    }
}

setInterval(search_check, 300);

// 宿泊日数を加減算するための処理
function minus () {
    var value = document.getElementById('stay_date_num').value;
    // 宿泊日数を減らす処理;
    value--;
    document.getElementById('stay_date_num').value = value;
}

function plus () {
    var value = document.getElementById('stay_date_num').value;
    // 翌日の値が○の時だけ加算する
    value++;
    document.getElementById('stay_date_num').value = value;
}

function radioDeselection() {
    for (const element of document.getElementsByName('date')) {
        element.checked = false;
        // チェックがリセットされたら塗りつぶしを消す
        for (var d=0; d<3; d++){
            var targetElements = document.getElementsByClassName('fill_green');
                [].forEach.call(targetElements, function(elem) {
                elem.classList.remove('fill_green');
            })
        }
        // さらに連泊日数を初期状態(1)に戻す
        document.getElementById('stay_date_num').value = 1;
        // 料金も0円にする
        document.getElementById('room_price').textContent = "0円";
        // リセットフラグを1にし、バックエンドで該当クエリを削除できるようにする
        document.getElementById('reset_flg').value = 1;
        document.getElementById('nm').innerHTML = '<a class="btn btn-primary float-right" href="/roomsreserve_stay/{{$next}}/{{$room_id}}/{{$add_data_id}}/{{$name}}/{{$mail}}/0000000000/2021-01-01/0/0:00/0/0/1/next">></a>';
        document.getElementById('pm').innerHTML = '<a class="btn btn-primary" href="/roomsreserve_stay/{{$prev}}/{{$room_id}}/{{$add_data_id}}/{{$name}}/{{$mail}}/0000000000/2021-01-01/0/0:00/0/0/1/prev"><</a>';
    }
}

// 月またぎの場合の料金を表示
@if(isset($get_query4))
var two_months_stay = '{{$get_query4->stay_date_num}}';
var last_month_stay = '{{$get_query4->stay_date_num}}';
var last_month_total = two_months_stay + last_month_stay;
var last_month_price = calculate_pay[0] * last_month_total;
console.log(last_month_total);
document.getElementById('room_price').textContent = last_month_price + "円";
@elseif(isset($get_query3))
var last_month_stay = '{{$get_query3->stay_date_num}}';
var last_month_price = calculate_pay[0] * last_month_stay;
document.getElementById('room_price').textContent = last_month_price + "円";
@else
document.getElementById('room_price').textContent = "0円";
@endif
</script>
@endsection