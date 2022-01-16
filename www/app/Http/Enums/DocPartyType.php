<?php

namespace App\Http\Enums;

class DocPartyType extends Enum {
    const ISSUER = 1;
    const PARTNER = 2;

    protected static $typeLabels = array(
        self::ISSUER => 'User or company who issued the document',
        self::PARTNER => 'The partner user or company of issuer of document',
    );      
}