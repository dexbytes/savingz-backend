<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Edit extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public User $user;

    public $roles;
    public $county_code;
    public $email='';
    public $phone='';
    public $name =''; 
    public $role_id=''; 
    public $aadhar_number='';
    public $pan_number='';

    protected function rules(){
        return [
            'user.email' => 'required|email|unique:App\Models\User,email,'.$this->user->id,
            'user.name' =>'required',
            'user.phone' =>'required|min:8|unique:App\Models\User,phone,'.$this->user->id,            
            'role_id' => 'required|exists:Spatie\Permission\Models\Role,id',
            'user.aadhar_number' => 'nullable|numeric|digits:12|unique:App\Models\User,aadhar_number,'.$this->user->id,
            'user.pan_number'    => 'nullable|size:10|unique:App\Models\User,pan_number,'.$this->user->id,
        ];
    }

    public function mount($id) {

        $this->user = User::find($id);
        $this->roles = Role::get(['id','name']);
        $this->role_id  = Role::where('name', $this->user->getRoleNames()->implode(','))->pluck('id','id')->first() ;
        $this->county_code = '966';
    }

    public function updated($propertyName){

        $this->validateOnly($propertyName);

    } 

    public function update(){
        
        $this->validate();
        $this->user->save();

        $this->user->roles()->detach();

        if( $this->role_id) {
            $this->user->assignRole(explode(',', $this->role_id));     
        }

        return redirect(route('user-management'))->with('status', 'User successfully updated.');
    }

    public function render()
    {
       // $this->authorize('manage-users', User::class);
        
        return view('livewire.user-management.edit');
    }
}
