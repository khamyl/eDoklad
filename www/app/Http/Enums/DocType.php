<?php

namespace App\Http\Enums;

class DocType extends Enum {
    const RECEIPT = 1;
    const INVOICE = 2;
    const CONTRACT= 3;

    protected static $typeLabels = array(
        self::RECEIPT => 'Receipt',
        self::INVOICE => 'Invoice',
        self::CONTRACT=> 'Contract'
    );      
}