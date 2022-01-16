<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    //protected $table = 'documents'; //We don't need thios as we are following the naming rules
    protected $guarded = []; //Blacklist - empty: all fields are fillable

    public function parties(){
        return $this->hasMany(Doc_party::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
}
