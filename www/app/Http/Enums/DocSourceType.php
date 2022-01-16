<?php

namespace App\Http\Enums;

class DocSourceType extends Enum {
    const OCR = 1;
    const USR = 2;

    protected static $typeLabels = array(
        self::OCR => 'Document acquired from OCR',
        self::USR => 'Document created by user'
    );      
}