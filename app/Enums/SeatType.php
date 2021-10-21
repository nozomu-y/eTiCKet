<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class SeatType extends Enum
{
    const RESERVED = 0;
    const UNRESERVED = 1;

    public static function getDescription($value): string
    {
        if ($value == self::RESERVED) {
            return __('reserved');
        }
        if ($value == self::UNRESERVED) {
            return __('unreserved');
        }
        return parent::getDescription($value);
    }

    public static function getValue(string $key)
    {
        if ($key == __('reserved')) {
            return self::RESERVED;
        }
        if ($key == __('unreserved')) {
            return self::UNRESERVED;
        }
        return parent::getValue($key);
    }
}
