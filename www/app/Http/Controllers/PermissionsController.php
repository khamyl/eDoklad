<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Permission;
use App\Role;
use Session;


class PermissionsController extends Controller
{
    
    public function index(){
        $roles = Role::select('id', 'slug', 'description')->get();
        foreach($roles as $role){
            $permissions[$role['id']] = $role->permissions();
        }      
        return view("admin.role.index")->with(compact('roles', 'permissions'));
    }

    public function create(Role $role){
        $permissions = Permission::all();
        return view('admin.role.create', compact('permissions'));
    }

    public function store(Request $request){        

        $data = $request->validate([
            'slug' => 'required|alpha_dash'
        ]); 
        
        //Role
        $role = new Role();
        $role->slug = $request->slug;
        $role->description = $request->description;
        $role->save();

        //Permissions
        $role->permissions()->sync($request->permissions);

            
        $status = ['success' => 'Role successfully created.'];        
        Session::flash('status', $status); 
        return $status;               
        //return redirect()->route('role.index')->with('status', $status);
    }

    public function edit(Role $role){
        $permissions = Permission::all();
        $role_perms = $role->permissions;
        $checked = array();

        foreach ($permissions as $perm){
            $checked[$perm->id] = $role_perms->contains($perm);
        }

        return view('admin.role.edit', compact('role', 'permissions', 'checked'));
    }

    public function update(Request $request, $id){

        //Validate
        $data = $request->validate([
            'slug' => 'required|alpha_dash'
        ]);

        //Update
        $role = Role::find($id);        
        $role->slug = $request->slug;
        $role->description = $request->description;
        $role->save();
        $role->permissions()->sync($request->input('permissions'));          

        //Finish
        $status = ['success' => 'Role successfully updated.'];        
        Session::flash('status', $status);     
        return $status;           
        //return redirect()->route('role.index')->with('status', $status);
    }
    
    /*
     * Can be deleted
     */
    public function test(){
        $user = auth()->user(); 
        
        //$user->withdrawRoles('super_admin','company_owner','main_accountant');
        //$user->grantRoles('a', 'b', 'super_admin','company_owner');
        //$user->grantRoles('main_accountant', 'super_admin');
        //$user->grantRoles('super_admin', 'company_owner');
        //$user->withdrawRoles('super_admin');
        $user->regrantRoles('main_accountant');
      
        $perm__com_edit_user = Permission::whereSlug('com_edit_user')->first();
        $perm__com_edit_docs = Permission::whereSlug('com_edit_docs')->first();
        $perm__com_read_docs = Permission::whereSlug('com_read_docs')->first();
        $perm__acc_read_docs = Permission::whereSlug('acc_read_docs')->first();

        $role__super_admin = Role::whereSlug('super_admin')->first();
        $role__company_owner = Role::whereSlug('company_owner')->first();
        $role__main_accountant = Role::whereSlug('main_accountant')->first();


        // $role__super_admin->permissions()->attach($perm__app_edit_user);
        // $role__super_admin->permissions()->attach($perm__com_edit_user);
        // $role__super_admin->permissions()->attach($perm__com_edit_docs);
        // $role__super_admin->permissions()->attach($perm__com_read_docs);
        // $role__super_admin->permissions()->attach($perm__acc_read_docs);

        // $role__company_owner->permissions()->attach($perm__com_edit_user);
        // $role__company_owner->permissions()->attach($perm__com_edit_docs);
        // $role__company_owner->permissions()->attach($perm__com_read_docs);

        // $role__main_accountant->permissions()->attach($perm__acc_read_docs);

        //dd($user->hasPermissionTo($perm__acc_read_docs));
        dd($user->can('com_edit_docs'));

        echo "Perm test OK";
    }
}
