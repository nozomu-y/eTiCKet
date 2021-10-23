<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CollectType extends Enum
{
    const DISABLED = 0;
    const OPTIONAL = 1;
    const REQUIRED = 2;

    public static function getDescription($value): string
    {
        if ($value == self::DISABLED) {
            return __('disabled');
        }
        if ($value == self::OPTIONAL) {
            return __('optional');
        }
        if ($value == self::REQUIRED) {
            return __('required');
        }
        return parent::getDescription($value);
    }

    public static function getValue(string $key)
    {
        if ($key == __('disabled')) {
            return self::DISABLED;
        }
        if ($key == __('optional')) {
            return self::OPTIONAL;
        }
        if ($key == __('required')) {
            return self::REQUIRED;
        }
        return parent::getValue($key);
    }
}
