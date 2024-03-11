<?php

namespace App\Enums;

enum StatusEnum: string
{
    case ASSEMBLING = "Сборка";
    case Delivery = "Доставка";
    case Received = "Получена";
    case Cancelled = "Отменена";
}
