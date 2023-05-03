<!-- 予約成立時に予約したユーザーに送られる確認メールの本文 -->
{{ $name }}様<br>
<br>
　この度はご予約のお申し込みをいただきありがとうございます。<br>
<br>
　以下の日程で以下のお部屋の予約が成立いたしましたことを通知いたします。<br>
<br>
・お部屋名:{{ $room_name }}<br>
・予約日:{{ $checkin_date }}<br>
・チェックイン:{{ $checkin_time }}<br>
・滞在日数:{{ $stay_days }}日間<br>
・予約番号:{{ $reserve_num }}<br>
・ご利用料金:{{ $money }}円<br>
<br>
<?php
$room_info = \DB::table('room')->find($room_id);
?>
ご利用のお部屋の住所:{{$room_info->prefectures}}{{$room_info->municipalities}}{{$room_info->addres}} {{$room_info->building_name}}<br>
<br>
決済情報<br>
決済日時:{{$pay_time}}<br>
決済に使われたクレジットカードの銘柄:{{$card_brand}}<br>
決済に使われたクレジットカードの下四桁:{{$last4}}<br>
承認番号:{{$accept_num}}<br>
<br>
　もしキャンセルがございましたら上記決済情報をお控えの上で下記リンク先よりキャンセルの手続きをお願い致します。<br>
<a href="{{url('/customercancel/stay')}}">キャンセル用のページへ移動</a><br>
<br>
　当日お越しの際はお部屋の中にあるQRコードよりチェックインのフォームに移動いただくか下記のリンク先より13桁の予約番号を入力してチェックインの手続きをお願い致します。<br>
<a href="{{url('/customercheckin')}}">{{url('/customercheckin')}}</a><br>
<br>
　ご予約されたお部屋の詳細情報:<br>
<a href="https://rentier.jp/room_detail/{{$room_id}}">詳細情報を見る</a>