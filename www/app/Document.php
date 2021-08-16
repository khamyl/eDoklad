<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'document';
    protected $fillable = ['id', 'owner', 'photo', 'edit_id', 'real_id','name','type'];
}
