<!-- 管理者に送られるメールの本文 -->
{{ $name }}様よりキャンセルが行われました。<br>
<br>
予約情報<br>
・お部屋名:{{ $room_name }}<br>
・予約日:{{ $checkin_date }}<br>
・チェックイン:{{ $checkin_time }}<br>
・宿泊日数:{{ $stay_days }}日間<br>
・予約番号:{{ $reserve_num }}<br>
・ご利用料金:{{ $money }}円<br>
・ご登録の身分証(表面)<br>
{{ $front }}<br>
・ご登録の身分証(裏面)<br>
{{ $back }}<br>
・承認番号<br>
{{ $accepct_num }}<br>
・カードブランド<br>
{{ $card_brand }}<br>
・下4桁<br>
{{ $last4 }}<br>
<br>
　キャンセルされたお部屋の詳細情報:<br>
<a href="https://rentier.jp/room_detail/{{$room_id}}">詳細情報を見る</a>