<?php

namespace App\Enums;

enum AuditTarget: string
{
    case Admin = 'admin';
    case User = 'user';
    case Entity = 'entity';
    case Box = 'box';
    case Document = 'document';
    case Borrow = 'borrow';
}
