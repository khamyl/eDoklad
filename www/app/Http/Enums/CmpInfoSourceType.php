<?php

namespace App\Http\Enums;

class CmpInfoSourceType extends Enum {
    const OCR = 1;
    const USR = 2;
    const REG = 3;

    protected static $typeLabels = array(
        self::OCR => 'Company data acquired from OCR',
        self::USR => 'Company data created by user',
        self::REG => 'Company data acquired from the online registry based on ID by user'
    );      
}
