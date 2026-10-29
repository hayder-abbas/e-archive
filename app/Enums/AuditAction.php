<?php

namespace App\Enums;

enum AuditAction: string
{
    case Add = 'add';
    case Edit = 'edit';
    case Revoke = 'revoke';
    case Reinstate = 'reinstate';
    case Delete = 'delete';
}
