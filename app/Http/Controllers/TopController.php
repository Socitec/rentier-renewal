<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\room_info_Model;

class TopController extends Controller
{
    //
    public function index()
    {
        // インスタンス生成
        $top = new room_info_Model();

        // topのsliderの情報を呼び出す
        $top_sliders = $top->top_slider();
        
        $top_rankings = $top->room_ranking();
        // return view('top')->with([
        //     "top_sliders"=>$top_sliders,                     // 遷移先のhtml出力フラグ                         
        // ]);
        // return view('top');
        

        return view('top')->with([
            "top_sliders"=>$top_sliders,
            "top_rankings"=>$top_rankings,     
        ]);

    }
}
