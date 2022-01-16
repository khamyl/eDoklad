<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $slug
 * @property $description
 */
class Permission extends Model
{
    use HasFactory;

    public $timestamps = FALSE;   

    public function roles() {
        return $this->belongsToMany(Role::class);            
    }

    public function users(){
        return $this->hasManyThrough(User::class, Role::class);
    }
}
