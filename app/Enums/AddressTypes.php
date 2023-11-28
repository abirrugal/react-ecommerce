<?php

namespace App\Enums;

enum AddressTypes: int
{
    case HOME = 0;
    case OFFICE = 1;
    case OTHER = 2;

    public function title(): string|null
    {
        return match ($this) {
            self::HOME => 'Home',
            self::OFFICE => 'Office',
            self::OTHER => 'Other',
        };
    }
}
