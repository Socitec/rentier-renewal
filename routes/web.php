<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopController;
use App\Http\Controllers\Rooms_Controller;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// トップページ
Route::get('/', '\App\Http\Controllers\TopController@index');


// 初めての方へ, レンティアとは
Route::get('/about', function(){
    return view('about');
});

// お部屋一覧
Route::get('/rooms', '\App\Http\Controllers\Rooms_Controller@index');



// お部屋一覧(福岡か？愛知県)
Route::get('/rooms/{prefectures}', '\App\Http\Controllers\Rooms_Controller@prefectures_seach');

// レンティアとは
Route::get('/about', function() {
    return view('about');
});

// 土地一覧
Route::get('/landList', function() {
    return view('landList');
});

// 物件一覧
Route::get('/propertyList', function() {
    return view('propertyList');
});

// 物件詳細
Route::get('/propertyDetail', function() {
    return view('propertyDetail');
});

// 土地詳細
Route::get('/landDetail', function() {
    return view('landDetail');
});

// 会社概要
Route::get('/company', function() {
    return view('company');
});

// お部屋詳細
Route::get('/room_detail/{room_id}', '\App\Http\Controllers\Room_detail_Controller@index');

// お問い合わせ
Route::post('/contact', '\App\Http\Controllers\Contact_Controller@index');

// お問い合わせ送信
Route::post('/contact_send', '\App\Http\Controllers\Contact_send_Controller@index');

// 利用規約
Route::get('/terms_of_use', function() {
    return view('terms_of_use');
});

// プライバシーポリシー
Route::get('/privacy_policy', function() {
    return view('privacy_policy');
});

// 予約の流れ
// Route::get('/how_to_reserve', function() {
//     return view('how_to_reserve');
// });

// 新型コロナについて
Route::get('/covid_19', function() {
    return view('covid_19');
});


// 一泊予約に確認メール送信フォームに遷移 
Route::get('/roomsreserve_stay_mail_check/{room_id}', '\App\Http\Controllers\Reserve_mail_check_Controller@roomsreserve_stay_mail_check');

// 時間貸し確認メール送信フォームに遷移
Route::get('/roomsreserve_time_mail_check/{room_id}', '\App\Http\Controllers\Reserve_mail_check_Controller@roomsreserve_time_mail_check');

Route::post('/time_mail_check', '\App\Http\Controllers\Reserve_mail_check_Controller@time_mail_check');


Route::post('/stay_mail_check', '\App\Http\Controllers\Reserve_mail_check_Controller@stay_mail_check');




// 一泊予約に遷移 
Route::get('/roomsreserve_stay/{room_id}/{sub_id}', '\App\Http\Controllers\Rserve_Controller@stay_reseve');

// 時間貸し予約に遷移
Route::get('/roomsreserve_time/{room_id}/{sub_id}', '\App\Http\Controllers\Rserve_Controller@time_rserve');

// 一泊予約に遷移(前の月)
Route::get('/roomsreserve_stay/{date}/{room}/{add_data}/{name}/{email}/{tel}/{reserve_date}/{stay_num}/{checkin}/{stradding}/{reset}/{stay_people}/prev', '\App\Http\Controllers\Prev_Month_Controller@stay_preview');

// 時間貸し予約に遷移(前の月)
Route::get('/roomsreserve_time/{date}/{room}/{add_data}/prev', '\App\Http\Controllers\Prev_Month_Controller@time_preview');

// 一泊予約に遷移(次の月)
Route::get('/roomsreserve_stay/{date}/{room}/{add_data}/{name}/{email}/{tel}/{reserve_date}/{stay_num}/{checkin}/{stradding}/{reset}/{stay_people}/next', '\App\Http\Controllers\Next_Month_Controller@stay_next');

// 時間貸し予約に遷移(次の月)
Route::get('/roomsreserve_time/{date}/{room}/{add_data}/next', '\App\Http\Controllers\Next_Month_Controller@time_next');

// 宿泊確認画面に遷移
Route::post('/roomsreserve_stay/preview/{room}/{add_data}', '\App\Http\Controllers\Rserve_Controller@stay_reseve_send');

// 時間貸し確認画面に遷移
Route::post('/roomsreserve_time/preview/{room}/{add_data}', '\App\Http\Controllers\Rserve_Controller@time_rserve_send');

// 仮予約を削除して予約設定画面に戻る(宿泊)
Route::get('/roomsreserve_stay/retly/{room}/{add_data}/{name}/{email}', '\App\Http\Controllers\Rserve_Controller@stay_retly');

// 仮予約を削除して予約設定画面に戻る(時間貸し)
Route::get('/roomsreserve_time/retly/{room}/{add_data}/{name}/{email}', '\App\Http\Controllers\Rserve_Controller@time_retly');

// 仮予約を確定させて決済処理をする(宿泊)
Route::post('/roomsreserve_stay/confirm/{room}/{add_data}/{name}/{email}', '\App\Http\Controllers\Rserve_Controller@stay_comp');

// 仮予約を確定させて決済処理をする(時間貸し)
Route::post('/roomsreserve_time/confirm/{room}/{add_data}/{name}/{email}', '\App\Http\Controllers\Rserve_Controller@time_comp');

// テストリンク 
Route::get('/roomsreserve_stay', '\App\Http\Controllers\Rserve_Controller@stay_reseve')->name('roomsreserve_stay');


// テストリンク
Route::get('/roomsreserve_time', '\App\Http\Controllers\Rserve_Controller@time_rserve')->name('roomsreserve_time');


// 予約状況を送信_一泊予約 
Route::post('/stay_reseve_send', '\App\Http\Controllers\Rserve_Controller@stay_reseve_send');

// 予約状況を送信_時間貸
Route::post('/time_reseve_send', '\App\Http\Controllers\Rserve_Controller@time_rserve_send');


Route::get('/hello/hi', '\App\Http\Controllers\Rserve_Controller@stay_reseve_send')->name('hello.hi');


Route::post('/roomsreserve/{mail}/{sub_id}', '\App\Http\Controllers\Rserve_Controller@time_reseve_send');

// お客様がQRコード読み取り時に遷移するURL
Route::get('/customercheckin', '\App\Http\Controllers\Customer_Checkin_Controller@index');

// 遷移後予約番号を入力し次へと遷移してもらうURL
Route::post('/customercheckin/set_reserve_num', '\App\Http\Controllers\Customer_Checkin_Controller@set_reserve_num');

// 予約番号登録後宿泊人数を登録してもらうURL
Route::post('/customercheckin/{reserve_num}/set_user_num', '\App\Http\Controllers\Customer_Checkin_Controller@set_user_num');

// 宿泊人数分の顔写真をアップロードしてもらうためのURL
Route::post('/customercheckin/{reserve_num}/{user_num}/upload_image', '\App\Http\Controllers\Customer_Checkin_Controller@upload_image');

// キャンセルポリシー
Route::get('/cancel_policy', function(){
    return view('cancel_policy');
});

// 宿泊_キャンセル
Route::get('/customercancel/stay', function() {
    return view('customercancel_stay');
});

// 時間_キャンセル
Route::get('/customercancel/time', function() {
    return view('customercancel_time');
});

// お客様がキャンセルする時の確認画面
Route::post('/customercancel_cheak/{reserve_state}', '\App\Http\Controllers\Customer_Cancel_Controller@customercancel_cheak');

// お客様がキャンセル終了後の画面(宿泊)
Route::post('/customercancel_done_stay', '\App\Http\Controllers\Customer_Cancel_Controller@customercancel_done_stay');

// お客様がキャンセル終了後の画面(時間貸し)
Route::post('/customercancel_done_time', '\App\Http\Controllers\Customer_Cancel_Controller@customercancel_done_time');

// 認証
Auth::routes(['register' => false]);
// Auth::routes();

// 管理者画面トップ
Route::get('/admin_home', '\App\Http\Controllers\Admin_Controller@index');

// 管理者画面ダミー予約作成
Route::get('/admin_reserve_stay', '\App\Http\Controllers\Admin_Reserve_Controller@stay');
Route::get('/admin_reserve_time', '\App\Http\Controllers\Admin_Reserve_Controller@time');
Route::post('/admin_reserve_create', '\App\Http\Controllers\Admin_Reserve_Controller@create');

// 管理者画面ダミー予約取り消し
Route::get('/admin_reserve_clear_form', '\App\Http\Controllers\Admin_Reserve_Controller@delete');
Route::post('/admin_reserve_destroy', '\App\Http\Controllers\Admin_Reserve_Controller@destroy');

Route::post('/logout', '\App\Http\Controllers\Logout_Controller@logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
