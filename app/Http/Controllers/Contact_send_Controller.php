<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Mail;
use App\Models\room_info_Model;
use App\Mail\Contact_admin_mail;
use App\Mail\Contact_customer_mail;


class Contact_send_Controller extends Controller
{
    //
    public function index(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required | max:100',
            'email' => 'email | max:50',
            'telphone' => 'required | numeric | digits_between:8,11 | max:20',
            'contact' => 'required',
            'checkbox' => 'required | max:30',

        ],
        [
            'name.required' => '名前は必須項目です。',
            'name.max' => '名前は100文字以内で入力してください。',
            'email.email'  => 'Emailには、有効なメールアドレスを指定してください。',
            'email.max' => 'Emailは、50文字以内で入力してください。',
            'telphone.required' => '電話番号には必須項目です。',
            'telphone.numeric' => '電話番号は8桁から11桁の間で指定してください',
            'telphone.max' => '電話番号は20文字以内で入力してください。',
            'contact.required' => 'お問い合わせ内容は必須項目です。',
            'checkbox.required' => 'お問い合わせ項目は必須項目です。',
            'checkbox.required' => 'お問い合わせ項目は30文字以内で入力してください。',
        ]);

        if ($validator->fails()) 
        {
            return redirect('/contact')
            ->withErrors($validator)
            ->withInput();
        }

        // insert処理
        \DB::table('contact')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'tel' => $request->telphone,
            'message' => $request->contact,
            'contact_category' => $request->checkbox,
        ]);

        //入力されたメールアドレスにメールを送信
        $Customr_to = [
            [
                'email' => $request->email,
                'name' => $request->name,
            ]
        ];
        
        $admin = \DB::table('contact_mail_config')->first();

        $Admin_to = [
            [
                'email' => $admin->from_mail,
                'name' => $admin->name,
            ]
        ];


        // 客先に送信
        $Customr = Mail::to($Customr_to)->send(new Contact_customer_mail($request->check_box, $request->contact, $admin->message));
        //$admin->message, $admin->subject, $admin->from_mail
        
        // 管理者に送信
        $Admin = Mail::to($Admin_to)->send(new Contact_admin_mail($request->user_name, $request->telphone, $request->contact, $request->checkbox, $request->email ));




        // お問い合わせ完了
        return view('contact_done');
    }


}
