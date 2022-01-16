<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public function users() {
                   
    }

    public function documents(){
        
    }

    public function parties()
    {
        return $this->morphMany(Doc_party::class, 'party');
    }
}
