<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use App\Permission;
use App\Role;

class PermissionController extends Controller
{
    public function getAllPermissions(){
        return PermissionResource::collection(Permission::all());
    }

    public function getRole(Role $role){
        return new RoleResource($role->load('permissions'));
    }
}
