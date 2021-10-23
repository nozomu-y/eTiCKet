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
            return __('collection_disabled');
        }
        if ($value == self::OPTIONAL) {
            return __('collection_optional');
        }
        if ($value == self::REQUIRED) {
            return __('collection_required');
        }
        return parent::getDescription($value);
    }

    public static function getValue(string $key)
    {
        if ($key == __('collection_disabled')) {
            return self::DISABLED;
        }
        if ($key == __('collection_optional')) {
            return self::OPTIONAL;
        }
        if ($key == __('collection_required')) {
            return self::REQUIRED;
        }
        return parent::getValue($key);
    }
}
