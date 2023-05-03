<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Contact_Controller extends Controller
{
    // お問い合わせ作成ページへ遷移
    public function index() {
        return view('contact');
    }

    // お問い合わせ保存処理
}
