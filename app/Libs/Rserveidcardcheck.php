<?php

namespace App\Libs;


class Rserveidcardcheck
{
    
    // imageの画像サイズチェックを行う
    public function image_size_check($value) 
    {
        // 40MB
        $image_size = 41943040;

        // そもそもパラメータ存在する？
        if(is_null($value))
        {
            // echo 'aaaaaaaaa';
            return true;
        }

        // 拡張子がpngかjpgか？ 40MB以下であること
        if(filesize($value) <= $image_size)
        {
            // なにもしないエラーにならない
            $bool = true;
        }else
        {
            // エラーになる
            $bool = false;
        }

        return $bool;   
    }

    // 
    public function reserve_image_category_check($value) 
    {
        // パラメータがそもそもあるか？
        if(is_null($value))
        {
            
            // なにもしないエラーにならない
            return true;
        }

        // 拡張子がpngかjpgか？
        if(strrchr($value, '.') === '.png' || strrchr($value, '.') === '.jpg' || strrchr($value, '.') === '.jpeg')
        {
            // なにもしないエラーにならない
            $bool = true;
        }else
        {
            // エラーになる
            $bool = false;
        }

        return $bool;

    }





}   
