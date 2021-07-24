<?php
/**
 * Reference: https://www.codechief.org/article/user-roles-and-permissions-tutorial-in-laravel-without-packages 
 */

namespace App\Permissions;

use App\Permission;
use App\Role;

trait HasPermissionsTrait {

    public function grantRoles(... $roles) {
        $roles = $this->getAllRoles($roles);
        if($roles === null) {
            return $this;
        }        
        $this->roles()->syncWithoutDetaching($roles);
        
        return $this;
    }

    public function withdrawRoles(... $roles) {
        $roles = $this->getAllRoles($roles);
        $this->roles()->detach($roles);
        return $this;
    }

    public function regrantRoles(...$roles) {
        $this->roles()->detach();        
        return $this->grantRoles(...$roles);
    }

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    protected function getAllRoles(array $roles) {
        return Role::whereIn('slug',$roles)->get();
    }

    public function hasPermissionTo($permission) {
        foreach ($permission->roles as $role){
            if($this->roles->contains($role)) {
                return true;    
            }
        }
        return false;      
    }

    public function hasRole( ... $roles ) {
        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
            return true;
            }
        }
        return false;
    }

}