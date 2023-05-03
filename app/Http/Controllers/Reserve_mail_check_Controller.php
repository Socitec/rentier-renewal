<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\mail_config_Model;

use Validator;
use Mail;  //追記
use Illuminate\Support\Facades\URL;


use App\Mail\Reserve_sub_mail_send;


class Reserve_mail_check_Controller extends Controller
{

    // 時間貸確認メール
    public function roomsreserve_time_mail_check($room_id) 
    {
        
        return view('rooms_reserve_time_mail_check')->with([
            "room_id"  => $room_id,                                     
        ]);

    }


    // 宿泊確認メール
    // 部屋予約お問い合わせ作成ページへ遷移
    public function roomsreserve_stay_mail_check($room_id) 
    {
        
        return view('rooms_reserve_stay_mail_check')->with([
            "room_id"  => $room_id,                                     
        ]);

    }

    // 部屋予約お問い合わせ作成ページへ遷移
    public function time_mail_check(Request $request) 
    {
        // メールコンフィグのインスタンス生成
        $mail = new mail_config_Model();
        
        $send_flg = true;

        $reserve_state = 'time_send';

        // バリデーションルールを設定する
        $rulus = [
            'user_name' => 'required | string',
            'email' => 'email',
            'room_id' => 'required',
          ];

        // バリデーションの独自メッセージを設定する
        $message = [
            'email.email'  => 'Emailには、有効なメールアドレスを指定してください。',
            // 'email.send_miss' => 'メール送信失敗しました。<br>もう一度送るか、メールアドレスを変えて送信してください。',
            'user_name.required' => '名前は必須項目です。',
        ];

        $validator = Validator::make($request->all(), $rulus, $message);

        // エラーがおきていたらリダイレクトする。
        if($validator->fails())
        {
            return redirect("/roomsreserve_time_mail_check/{$request->input('room_id')}")
            ->withErrors($validator)
            ->withInput();
        }

        // 追加したメール情報を追加する
        $add_data_id = $mail->sub_reserve_mail_add($request);

        // サブメールの時の文言の設定を引き出しをする
        $sub_reserve_mail = $mail->sub_reserve_mail_config();

        $rulus['email'] = "email | send_miss";


        $message = array_merge($message,array('email.send_miss'=>"メール送信失敗しました。<br>もう一度送るか、メールアドレスを変えて送信してください。"));
        
        // $validator = Validator::make($request->all(), $rulus, $message);
        // 時間貸用のURLを生成する
        // $url = url("/roomsreserve_time/{$request->input('room_id')}/{$add_data_id}");

        // $url = URL::temporarySignedRoute(
        //     "/roomsreserve_time/{$request->input('room_id')}/{$add_data_id}", now()->addMinutes(30)
        // );

        $url = URL::temporarySignedRoute("roomsreserve_time",
                                                now()->addMinutes(30),['room_id' => $request->input('room_id'), 'add_data_id' => $add_data_id]);


        $Customr_to = [
            [
                'email' => $request->email,
                'name'  => $request->user_name,
            ]
        ];

        
        // try_catchで囲いしっかりメールが届いたか確認する
        try {

                // メールをDBの値を用いて送信する                           　　　　　　　　　　　　　 　　　　　　　　
                Mail::to($Customr_to)->send(new Reserve_sub_mail_send($request->input("user_name"),                 // お客様の名前
                                                                        $sub_reserve_mail->subject,                          // 件名
                                                                        $sub_reserve_mail->from_mail,                        // 誰から?メール 
                                                                        $reserve_state,                                      // 渡すカテゴリ 時間か宿泊？
                                                                        $url ));                                             // メールで表示するURL
        
        } catch (Exception $e) {

            // メールに問題があればエラーを返す
            if (count(Mail::failures()) > 0)
            {
                $send_flg = false;

                // 先ほど追加したカラムを削除する　メールの送信で失敗したからDBで取り消し
                $mail->sub_reserve_mail_delete($add_data->id);

            }
        }
        
        if($send_flg ==  false)
        {
    
            return view('roomsreserve_time_mail_check')->with([
                "mail_miss"  => true,
                "room_id"  => $request->input('room_id'),                                
            ]);
        }

        // エラーがおきていたらリダイレクトする。
        if($validator->fails())
        {
            return redirect("/roomsreserve_time_mail_check/{$request->input('room_id')}")
            ->withErrors($validator)
            ->withInput();
        }

    // -------------------------------- ここの行からはメールが成功した処理 --------------------------- //


        return view("mail_done");

    }


    // 当該関数はメール送信時にバリデーションチェックを行う。
    public function stay_mail_check(Request $request) 
    {
        
        // メールコンフィグのインスタンス生成
        $mail = new mail_config_Model();

        $send_flg = true;

        $reserve_state = 'stay_send';

        // バリデーションルールを設定する
        $rulus = [
            'user_name' => 'required | string | max:100',
            'email' => 'email | max:100',
            'room_id' => 'required',
          ];

        // バリデーションの独自メッセージを設定する
        $message = [
            'email.email'  => 'Emailには、有効なメールアドレスを指定してください。',
            'email.max' => 'Emailは、100文字以内で入力してください。',
            // 'email.send_miss' => 'メール送信失敗しました。<br>もう一度送るか、メールアドレスを変えて送信してください。',
            'user_name.required' => '名前は必須項目です。',
            'user_name.max' => '名前は100文字以内で入力してください。',
            'room_id.required' => 'システムエラー',
        ];

        $validator = Validator::make($request->all(), $rulus, $message);
        
        // エラーがおきていたらリダイレクトする。
        if($validator->fails())
        {
            return redirect("/roomsreserve_stay_mail_check/{$request->input('room_id')}")
            ->withErrors($validator)
            ->withInput();
        }

        // 追加したメール情報を追加する
        $add_data_id = $mail->sub_reserve_mail_add($request);

        // サブメールの時の文言の設定を引き出しをする
        $sub_reserve_mail = $mail->sub_reserve_mail_config();


        // 宿泊用のURLを生成する
        // $url = url("/c/{$request->input('room_id')}/{$add_data_id}");
       
        // $url = URL::temporarySignedRoute('hello.hi', 
        //                                     now()->addSeconds(5),['from' => $add_data_id]);

         $url = URL::temporarySignedRoute("roomsreserve_stay", 
                                            now()->addMinutes(30),['room_id' => $request->input('room_id'), 'add_data_id' => $add_data_id]);


        $Customr_to = [
            [
                'email' => $request->email,
                'name'  => $request->input("user_name"),
            ]
        ];


        // try_catchで囲いしっかりメールが届いたか確認する
        try {
                // メールをDBの値を用いて送信する                           　　　　　　　　　　　　　 　　　　　　　　
                  Mail::to($Customr_to)->send(new Reserve_sub_mail_send($request->input("user_name"),   // お客様の名前
                                                                        $sub_reserve_mail->subject,     // 件名
                                                                        $sub_reserve_mail->from_mail,   // 誰から?メール 
                                                                        $reserve_state,                 // 渡すカテゴリ 時間か宿泊？
                                                                        $url ));                        // メールで表示するURL

        } catch (Exception $e) {

            // メールに問題があればエラーを返す
            if (count(Mail::failures()) > 0)
            {
                // 先ほど追加したカラムを削除する　メールの送信で失敗したからDBで取り消し
                $mail->sub_reserve_mail_delete($add_data_id);

                $send_flg = false;

            }
        
        }

    // $send_flg = false;
    if($send_flg ==  false)
    {

        return view('rooms_reserve_stay_mail_check')->with([
            "mail_miss"  => true,
            "room_id"  => $request->input('room_id'),                              
        ]);
    }
    // -------------------------------- ここの行からはメールが成功した処理 --------------------------- //
        


        return view("mail_done");
        
    }






}
