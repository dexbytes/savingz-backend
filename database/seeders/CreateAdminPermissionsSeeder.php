<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class CreateAdminPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::where('name', 'Admin')->update(['guard_name' => 'web']);
        $role = Role::where('name', 'Admin')->first();
        $permissions =  $this->_permissions();// Permission::pluck('id','id')->all();
        if($permissions){
            $role->syncPermissions($permissions); 
        }
                
    }


    public function _permissions(){
        
        return [
            'dashboard',
            'register',
            'forget-password',
            'reset-password',
            'edit-profile',
            'faq-management',
            'edit-faq',
            'add-faq',
            'page-management',
            'edit-page',
            'add-page',
            'site-settings',
            'site-cache',
            'user-management',
            'edit-user',
            'add-user',
            'view-user',
            'country-management',
            'edit-country',
            'add-country',
            'state-management',
            'edit-state',
            'add-state',
            'city-management',
            'add-city',
            'edit-city'
        ];
    }
}
 