<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Contact_Controller extends Controller
{
    // お問い合わせ作成ページへ遷移
    public function index(Request $post) {
        $property = [
            'type' => $post -> type,
            'name' => $post -> name
        ];
         
        return view('contact', compact('property'));
    }

    // お問い合わせ保存処理
}
