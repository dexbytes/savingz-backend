<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class CreateOperationPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::where('name', 'Operation')->update(['guard_name' => 'web']);
        $role = Role::where('name', 'Operation')->first();
        $permissions = Permission::whereIn('name', $this->getPermissions())->where('guard_name', 'web')->pluck('id','id')->all();
        if($role && $permissions){
            $role->syncPermissions($permissions); 
        }
                
    }

    protected function getPermissions() {

        return [
            'dashboard', 
            'edit-profile',
            'user-management',
            'edit-user',
            'add-user',
            'view-user',
           
        ];
    }



}