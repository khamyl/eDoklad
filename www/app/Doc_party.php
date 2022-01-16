<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doc_party extends Model
{
    use HasFactory;

    public function party()
    {
        return $this->morphTo();
    }
}
