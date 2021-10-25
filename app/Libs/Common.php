<?php

namespace App\Libs;

class Common
{
    static function format_price($price)
    {
        if ($price == 0) {
            return __('free');
        }
        return '￥' . number_format($price);
    }

    static function hide_email($email)
    {
        $ex = explode('@', $email);
        if (strlen($ex[0]) < 4) {
            $hidden = '********';
        } else {
            $hidden = '********';
            $hidden = substr($ex[0], 0, 2) . $hidden . substr($ex[0], -2);
        }
        return $hidden . '@' . $ex[1];
    }

    static function hide_phone_number($phone_number)
    {
        if (strlen($phone_number) < 5) {
            return '***********';
        }
        $first = substr($phone_number, 0, 3);
        $last = substr($phone_number, -2);
        $hidden = '******';
        return $first . $hidden . $last;
    }

    static function is_null_or_empty($str)
    {
        if ($str === "0") {
            return false;
        }
        return empty($str);
    }
}
