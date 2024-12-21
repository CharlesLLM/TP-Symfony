<?php

declare(strict_types=1);

namespace App\Enum;

use App\Enum\Traits\UtilsTrait;

enum CommentStatusEnum: string
{
    use UtilsTrait;

    case PENDING = 'pending';
    case VALIDATED = 'validated';
    case REJECTED = 'rejected';
}
