<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\room_info_Model;

class Logout_Controller extends Controller
{
    // ログアウト用コントローラー
    public function logout(){
        if (Auth::check()) {
            // セッションを破棄してログアウト
            Auth::logout();

            $top = new room_info_Model();

            $top_sliders = $top->top_slider();
            $top_rankings = $top->room_ranking();

            return view('top')->with([
                "top_sliders"=>$top_sliders,
                "top_rankings"=>$top_rankings,     
            ]);
        }
    }
}
