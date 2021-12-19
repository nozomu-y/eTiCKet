<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserRole extends Enum
{
    const ADMIN = 'admin';
    const MEMBER = 'member';

    public static function getDescription($value): string
    {
        if ($value == self::ADMIN) {
            return __('admin');
        }
        if ($value == self::MEMBER) {
            return __('member');
        }
        return parent::getDescription($value);
    }

    public static function getValue(string $key)
    {
        if ($key == __('admin')) {
            return self::ADMIN;
        }
        if ($key == __('member')) {
            return self::MEMBER;
        }
        return parent::getValue($key);
    }
}
