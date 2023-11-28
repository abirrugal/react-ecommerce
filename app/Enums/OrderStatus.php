<?php

namespace App\Enums;

enum OrderStatus: int
{
    case PENDING = 0;
    case PROCESSING = 1;
    case SHIPING = 2;
    case DELIVERED = 3;
    case CANCELLED = 4;
    case RETURN = 5;

    public function title(): string|null
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::PROCESSING => 'Processing',
            self::SHIPING => 'Shiping',
            self::DELIVERED => 'Delivered',
            self::CANCELLED => 'Cancelled',
            self::RETURN => 'Return',
        };
    }

    public static function findValue($status)
    {
        return match ($status) {
            'Pending' => self::PENDING,
            'Processing' => self::PROCESSING,
            'Shiping' => self::SHIPING,
            'Delivered' => self::DELIVERED,
            'Cancelled' => self::CANCELLED,
            'Return' => self::RETURN,
        };
    }

    public static function available_statuses()
    {
        return ['Pending', 'Processing', 'Shiping', 'Delivered', 'Cancelled','Return'];
    }
}
