<?php

namespace App\Enums;

enum AuditAction: string
{
    case Add = 'add';
    case Edit = 'edit';
    case Delete = 'delete';
    case ForceDelete = 'force-delete';
    case Restore = 'restore';
}
