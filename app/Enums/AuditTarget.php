<?php

namespace App\Enums;

enum AuditTarget: string
{
    case Entity = 'entity';
    case Box = 'box';
    case Document = 'document';
    case Borrow = 'borrow';
}
