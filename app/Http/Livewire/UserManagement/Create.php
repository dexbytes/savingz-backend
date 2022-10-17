<?php

namespace App\Http\Livewire\UserManagement;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\Worlds\Country;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Create extends Component
{

    use WithFileUploads;
    use AuthorizesRequests;


    public $roles;
    public $county_code;
    public $picture;
    public $email='';
    public $phone='';
    public $name ='';
    public $password='';
    public $role_id='';
    public $passwordConfirmation='';

    protected $rules = [
        'email' => 'required|email|unique:App\Models\User,email',
        'name' =>'required',
        'phone' =>'required|min:8|unique:App\Models\User,phone',
        'password' => 'required|same:passwordConfirmation|min:7',
        'role_id' => 'required|exists:Spatie\Permission\Models\Role,id',
    ];

    public function mount() {

        $this->roles = Role::get(['id','name']);
        $this->county_code = '966';
    }

    public function updated($propertyName){

        $this->validateOnly($propertyName);

    } 

    public function store(){

        $this->validate();

        $user = User::create([
                'email' => $this->email,
                'name' => $this->name,
                'phone' => $this->county_code.''.$this->phone,
                'county_code' => $this->county_code,
                'password' => $this->password,           
            ]);

        if( $this->role_id){
            $user->assignRole(explode(',', $this->role_id));     
        }

        return redirect(route('user-management'))->with('status','User successfully created.');
    }


    public function render()
    {
       // $this->authorize('manage-users', User::class);
        return view('livewire.user-management.create');
    }
}
