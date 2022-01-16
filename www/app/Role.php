<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $slug
 * @property $description
 */
class Role extends Model
{
    use HasFactory;

    //protected $fillable = ['slug', 'description'];

    public $timestamps = FALSE;       

    public function permissions() {

        return $this->belongsToMany(Permission::class);
            
     }
     
     public function users() {
     
        return $this->belongsToMany(User::class);
            
     }
}
