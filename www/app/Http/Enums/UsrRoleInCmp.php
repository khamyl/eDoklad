<?php

namespace App\Http\Enums;

class UsrRoleInCmp extends Enum {
    const BOARD_CHAIRMAN = 1;
    const BOARD_MEMBER   = 2;
    const SELF_EMPLOYEE  = 3;
    const EMPLOYEE       = 4;
    const ACCOUNTANT     = 5;
    const LAWYER         = 6;

    protected static $typeLabels = array(
        self::BOARD_CHAIRMAN => 'Board chairman',
        self::BOARD_MEMBER   => 'Board member',
        self::SELF_EMPLOYEE  => 'Self employee',
        self::EMPLOYEE       => 'Employee',
        self::ACCOUNTANT     => 'Accountant',
        self::LAWYER         => 'Lawyer',
    );      
}