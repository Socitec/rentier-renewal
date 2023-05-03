@extends('rooms_reserve')

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
    $url = str_replace('/roomsreserve_time', '', $url);
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
    <div id="nm"><a class="btn btn-primary float-right" href="/roomsreserve_time/{{$next}}/{{$room_id}}/{{$add_data_id}}/next">></a></div>
    <div id="pm"><a class="btn btn-primary" href="/roomsreserve_time/{{$prev}}/{{$room_id}}/{{$add_data_id}}/prev"><</a></div>
    @else
    <div id="nm"><a class="btn btn-primary float-right" href="/roomsreserve_time/{{$next}}/{{$room_id}}/{{$add_data_id}}/next">></a></div>
    <div id="pm"><a class="btn btn-primary" href="/roomsreserve_time/{{$prev}}/{{$room_id}}/{{$add_data_id}}/prev"><</a></div>
    @endif
</div>
<div class="text-center mt-3"><h2 id="currentmonth"></h2></div>
<!-- カレンダー -->
<div id="calendar"></div>
<div class="text-center mt-2">
    <div class="btn btn-primary" onclick="radioDeselection()">選択を解除</div>
</div>
<input type="hidden" name="reset_flg" id="reset_flg" value="0">
<table class="mt-4">
    <tr>
        <th><h2>ご利用時間</h2></th>
        <td><p class="contact_require">必須</p></td>
        <td><h2>料金</h2></td>
        <td><h2 id="room_price"></h2></td>
        @error('start_time')
        <th><h5 class="error_text">{{$message}}</h5></th>  
        @enderror
        @error('end_time')
        <th><h5 class="error_text">{{$message}}</h5></th>  
        @enderror
    </tr>
</table>
<table class="full_width">
    <tr>
        <th>
            <select name="start_time" id="start_time" type="time" class="form-control border_require @error('start_time') is-invalid @enderror" step="1800">
                @if(isset($get_query))
                <option value="{{$get_query->start_time}}">{{$get_query->start_time}}</option>
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
        </th>
        <td><div class="text-center">～</div></td>
        <td>
            <select name="end_time" id="end_time" type="time" class="form-control border_require @error('end_time') is-invalid @enderror">
                @if(isset($get_query))
                <option value="{{$get_query->end_time}}">{{$get_query->end_time}}</option>
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
        </td>
    </tr>
</table>
@endsection

@section('script')
<?php
if (isset($this_month)){
    $year = substr($this_month, 0, 4);
    $month = substr($this_month, 5, 2);
} else {
    $this_month = date('Y-m-d');
    $year = substr($this_month, 0, 4);
    $month = substr($this_month, 5, 2);
}
?>
<script>
var confirm = document.getElementById('confirm');
var accept = document.getElementById('accept');
var flag = false;
var flag1 = false;
var counter = 0;
var start_time = document.getElementById('start_time');
var end_time = document.getElementById('end_time');

if (flag == false){
    confirm.innerHTML = '';
} else {
    confirm.innerHTML = '<input type="submit" class="btn btn-primary text-white rounded-pill bold wide90" value="決済画面へ">';
}

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
    @if(isset($get_query))
    arr2.push('{{$get_query->date}}');
    @endif

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
                // もし日曜日だったら
                if(j==0){
                    if(year == today.getFullYear()
                    && month == tm
                    && count == today.getDate()){
                        if (arr[count2]=="×"){
                            calendar += "<td class='today line sunday' id='fill_" + year + "-" + month + "-" + count + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " ×</span></td>";
                        } else {
                            if (arr2[0]==year+'-'+month+'-'+count1){
                                calendar += "<td class='today line sunday' id='fill_" + year + "-" + month + "-" + count + "'><label><input type='radio' checked name='date' id='" + year + "-" + month + "-" + count + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                            } else {
                                calendar += "<td class='today line sunday' id='fill_" + year + "-" + month + "-" + count + "'><label><input type='radio' name='date' id='" + year + "-" + month + "-" + count + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                            }
                        }
                    } else {
                        if (year == today.getFullYear()
                        && month == tm
                        && count < today.getDate()){
                            calendar += "<td class='line sunday' id='fill_" + year + "-" + month + "-" + count + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " ×</span></td>";
                        } else {
                            if (arr[count2]=="×"){
                                calendar += "<td class='line sunday' id='fill_" + year + "-" + month + "-" + count + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " ×</span></td>";
                            } else {
                                if (arr2[0]==year+'-'+month+'-'+count1){
                                    calendar += "<td class='line sunday' id='fill_" + year + "-" + month + "-" + count + "'><label><input type='radio' checked name='date' id='" + year + "-" + month + "-" + count + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                } else {
                                    calendar += "<td class='line sunday' id='fill_" + year + "-" + month + "-" + count + "'><label><input type='radio' name='date' id='" + year + "-" + month + "-" + count + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
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
                            calendar += "<td class='today line saturday' id='fill_" + year + "-" + month + "-" + count + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " ×</span></td>";
                        } else {
                            if (arr2[0]==year+'-'+month+'-'+count1){
                                calendar += "<td class='today line saturday' id='fill_" + year + "-" + month + "-" + count + "'><label><input type='radio' checked name='date' id='" + year + "-" + month + "-" + count + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                            } else {
                                calendar += "<td class='today line saturday' id='fill_" + year + "-" + month + "-" + count + "'><label><input type='radio' name='date' id='" + year + "-" + month + "-" + count + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                            }
                        }
                    } else {
                        if (year == today.getFullYear()
                        && month == tm
                        && count < today.getDate()){
                            calendar += "<td class='line saturday' id='fill_" + year + "-" + month + "-" + count + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " ×</span></td>";
                        } else {
                            if (arr[count2]=="×"){
                                calendar += "<td class='line saturday' id='fill_" + year + "-" + month + "-" + count + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " ×</span></td>";
                            } else {
                                if (arr2[0]==year+'-'+month+'-'+count1){
                                    calendar += "<td class='line saturday' id='fill_" + year + "-" + month + "-" + count + "'><label><input type='radio' checked name='date' id='" + year + "-" + month + "-" + count + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                } else {
                                    calendar += "<td class='line saturday' id='fill_" + year + "-" + month + "-" + count + "'><label><input type='radio' name='date' id='" + year + "-" + month + "-" + count + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
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
                            calendar += "<td class='today line' id='fill_" + year + "-" + month + "-" + count + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " ×</span></td>";
                        } else {
                            if (arr2[0]==year+'-'+month+'-'+count1){
                                calendar += "<td class='today line' id='fill_" + year + "-" + month + "-" + count + "'><label><input type='radio' checked name='date' id='" + year + "-" + month + "-" + count + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                            } else {
                                calendar += "<td class='today line' id='fill_" + year + "-" + month + "-" + count + "'><label><input type='radio' name='date' id='" + year + "-" + month + "-" + count + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                            }
                        }
                    } else {
                        if (year == today.getFullYear()
                        && month == tm
                        && count < today.getDate()){
                            calendar += "<td class='line' id='fill_" + year + "-" + month + "-" + count + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " ×</span></td>";
                        } else {
                            if (arr[count2]=="×"){
                                calendar += "<td class='line' id='fill_" + year + "-" + month + "-" + count + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " ×</span></td>";
                            } else {
                                if (arr2[0]==year+'-'+month+'-'+count1){
                                    calendar += "<td class='line' id='fill_" + year + "-" + month + "-" + count + "'><label><input type='radio' checked name='date' id='" + year + "-" + month + "-" + count + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
                                } else {
                                    calendar += "<td class='line' id='fill_" + year + "-" + month + "-" + count + "'><label><input type='radio' name='date' id='" + year + "-" + month + "-" + count + "' class='selector @error('date') is-invalid @enderror' value='" + year + "-" + month + "-" + count1 + "'><span class='day_select' id='data_" + year + "-" + month + "-" + count + "'>" + count1 + " " + arr[count2] + "</span></label></td>";
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
            confirm.innerHTML = '<input type="submit" formaction="/roomsreserve_time/preview/{{$room_id}}/{{$add_data_id}}" class="btn btn-primary text-white rounded-pill bold wide90" value="決済画面へ">';
        }
    });

    start_time.addEventListener("change", function(){
        if (this.value!=undefined&&end_time.value!="") {
            var data1 = new Date('2021-12-31 ' + this.value + ':00');
            var data2 = new Date('2021-12-31 ' + end_time.value + ':00');
            var diff = data2.getTime() - data1.getTime();
            var result = diff / (60 * 60 * 1000);
            var r_price = '{{$room_price}}';
            var room_price = result * r_price;
            if (room_price < 0) {
                document.getElementById('room_price').textContent = "0円";
            } else {
                document.getElementById('room_price').textContent = room_price + "円";
            }
        } else {
            document.getElementById('room_price').textContent = "0円";
        }
    });

    end_time.addEventListener("change", function(){
        if (this.value!=undefined&&start_time.value!="") {
            var data1 = new Date('2021-12-31 ' + start_time.value + ':00');
            var data2 = new Date('2021-12-31 ' + this.value + ':00');
            var diff = data2.getTime() - data1.getTime();
            var result = diff / (60 * 60 * 1000);
            var r_price = '{{$room_price}}';
            var room_price = result * r_price;
            if (room_price < 0) {
                document.getElementById('room_price').textContent = "0円";
            } else {
                document.getElementById('room_price').textContent = room_price + "円";
            }
        } else {
            document.getElementById('room_price').textContent = "0円";
        }
    });
});

function radioDeselection() {
    for (const element of document.getElementsByName('date')) {
        element.checked = false;
        // 関数実行時にフラグを1にしてバックエンドで不要なクエリを削除
        document.getElementById('reset_flg').value = 1;
        // start_timeとend_timeを空にし、料金を0にする
        document.getElementById('start_time').value = "";
        document.getElementById('end_time').value = "";
        document.getElementById('room_price').textContent = "0円";
    }
}

// 初回読み込み時は料金を0円に設定
document.getElementById('room_price').textContent = "0円";
</script>
@endsection