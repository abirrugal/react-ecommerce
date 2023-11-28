<?php

namespace App\Enums;

enum PaymentStatus : int
{
    case PENDING = 0;
    case SUCCESS = 1;
    case FAILED = 2;
    case CANCELLED = 3;

    public function title(): string|null
    {
        return match($this){
            $this::PENDING => 'Pending',
            $this::SUCCESS => 'Success',
            $this::FAILED => 'Failed',
            $this::CANCELLED => 'Cancelled',
        };
    }
}
