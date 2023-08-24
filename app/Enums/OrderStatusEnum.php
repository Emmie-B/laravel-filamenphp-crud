<?php

namespace App\Enums;

enum productTypeEnum: string
{
    case PENDING = "Pending";
    case PROCESSING = "Processing";
    case COMPLETED = "Completed";
    case DECLINED = "Declined";
}
