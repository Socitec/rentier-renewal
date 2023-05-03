<?php

namespace App\Http\Controllers;

use Validator;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Mail\Checkin_Comp_Notice_Mail;

class Customer_Checkin_Controller extends Controller
{
    // QRコード読み取り時に遷移する共通の関数
    public function index() {
        return view('customer_login');
    }

    // 予約番号を入力する処理
    public function set_reserve_num(Request $request) {
        // バリデーションルールを設定する
        $rules = [
            'reservation_num' => 'required | max:100',
        ];
        $message = [
            'reservation_num.required' => '予約番号は必須です。',
            'reservation_num.max:8' => '予約番号は100文字以内で入力してください。',
        ];
        $validator = Validator::make($request->all(), $rules, $message);

        // エラーがおきていたらリダイレクトする。
        if($validator->fails())
        {
            return redirect('/customercheckin')
            ->withErrors($validator)
            ->withInput();
        }

        $reserve = $request->reservation_num;

        $reserve_check = \DB::table('reservation_num')->where('num', $reserve)->exists();
        if ($reserve_check==false) {
            $err = 'その予約番号は存在しません。送られたメールに記載された予約番号を入力してください。';
            return view('customer_login', ['err'=>$err]);
        }

        $reserve_num_check = \DB::table('customer_images')->where('reservation_num', $reserve)->exists();
        if ($reserve_num_check==true) {
            return view('customer_thanks');
        }

        return view('customer_set_num', ['reserve'=>$reserve]);
    }

    // 宿泊人数を登録する処理
    public function set_user_num(Request $request, $reserve_num) {
        // バリデーションルールを設定する
        $rules = [
            'user_num' => 'max:3',
        ];
        $message = [
            'user_num.max:3'  => '利用者数は3桁を超えてはいけません。',
        ];
        $validator = Validator::make($request->all(), $rules, $message);

        // エラーがおきていたらリダイレクトする。
        if($validator->fails())
        {
            return redirect('/customercheckin/set_reserve_num')
            ->withErrors($validator)
            ->withInput();
        }

        // DBに$user_numを追加
        \DB::table('reservation_num')->where('num', $reserve_num)->update([
            'user_num' => $request->user_num,
        ]);
        $user_num = $request->user_num;
        return view('customer_upload_image', ['reserve_num'=>$reserve_num, 'user_num'=>$user_num]);
    }

    // 顔写真をアップロードする処理
    public function upload_image(Request $request, $reserve_num, $user_num) {
        // 予約番号から部屋IDを取得
        $room = \DB::table('reservation_num')->where('num', $reserve_num)->value('room_id');

        // 人数分DBにinsert
        for ($i=1; $i<$user_num+1; $i++) {
            $name = 'name_'.$i;
            $image = 'image_'.$i;
            $id_front = 'id_card_front_'.$i;
            $id_back = 'id_card_back_'.$i;
            if (isset($request->$name)&&isset($request->$image)&&isset($request->$id_front)&&isset($request->$id_back)) {
                $path = Storage::putFile('/images/checkin_user', $request->file('image_'.$i), 'public');
                $id_front_path = Storage::putFile('/images/checkin_id_front', $request->file('id_card_front_'.$i), 'public');
                $id_back_path = Storage::putFile('/images/checkin_id_back', $request->file('id_card_back_'.$i), 'public');
                \DB::table('customer_images')->insert([
                    'room_id' => $room,
                    'reservation_num' => $reserve_num,
                    'name' => $request->$name,
                    'image' => basename($path),
                    'id_front' => basename($id_front_path),
                    'id_back' => basename($id_back_path),
                ]);
            } else {
                // 一度クエリを消去
                \DB::table('customer_images')->where('room_id', $room)->where('reservation_num', $reserve_num)->delete();
                $err_message = '氏名もしくはお部屋での自撮り写真、身分証明書表面、身分証明書裏面のいずれかに登録漏れがあったため処理が中断されました。もう一度処理をやり直してください。';
                return view('customer_upload_image', ['reserve_num'=>$reserve_num, 'user_num'=>$user_num, 'err_message'=>$err_message]);
            }
        }

        // 登録後メール処理を走らせる
        // 登録されたクエリから予約番号と部屋番号が一致している最初のクエリのIDを取得
        $val = \DB::table('customer_images')->where('room_id', $room)->where('reservation_num', $reserve_num)->value('id');
        $sum = \DB::table('customer_images')->where('room_id', $room)->where('reservation_num', $reserve_num)->count();
        for ($n=$val; $n<$val+$sum; $n++) {
            $q = \DB::table('customer_images')->where('id', $n)->first();
            // 管理者にメールを送る
            $admin = \DB::table('reservation_mail_config')->first();
            $to = [
                [
                    'email' => $admin->from_mail,
                    'name' => $admin->message,
                ]
            ];
            $name = $q -> name;
            $image = $q -> image;
            $id_front = $q -> id_front;
            $id_back = $q -> id_back;
            $room_name = $q -> room_id;
            Mail::to($to)->send(new Checkin_Comp_Notice_Mail($reserve_num, $name, $room_name, $image, $id_front, $id_back));
        }

        return view('customer_thanks');
    }
}
