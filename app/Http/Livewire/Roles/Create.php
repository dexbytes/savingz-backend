<?php

namespace App\Http\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Create extends Component
{
    use AuthorizesRequests;
 
    public $name = '';
    public $content = '';

    protected $rules = [
        'name' => 'required|max:255|unique:Spatie\Permission\Models\Role,name',
        'content' =>'nullable|min:5',
    ];


    public function updated($propertyName){

        $this->validateOnly($propertyName);

    } 

    public function store(){

        $validatedData = $this->validate();
        Role::create($validatedData);

        return redirect(route('role-management'))->with('status','Role successfully created.');
    }


    public function render()
    {
        return view('livewire.roles.create');
    }
}
