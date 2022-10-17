<?php

namespace App\Http\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Edit extends Component
{
    use AuthorizesRequests;

    public Role $role;
    protected $defaultRoles = ['Admin', 'Provider', 'Driver', 'Customer', 'Unverified'];

    protected function rules(){
        return [
            'role.name' => 'required|unique:Spatie\Permission\Models\Role,name,'.$this->role->id,
            'role.content' => 'nullable|min:5',
        ];
    }

    public function mount($id) {

        $this->role = Role::find($id);
    }

    public function updated($propertyName){

        $this->validateOnly($propertyName);
    }

    public function edit(){

        $this->validate();
        $this->role->update();

        return redirect(route('role-management'))->with('status', 'Role successfully updated.');
    }


    public function render()
    {
        return view('livewire.roles.edit');
    }
}
