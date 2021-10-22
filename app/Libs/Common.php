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
}
