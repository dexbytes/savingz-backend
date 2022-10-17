<?php

namespace App\Http\Livewire\World\Country;

use App\Models\Worlds\Country;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Create extends Component
{
    use AuthorizesRequests;
 
    public $name = '';
    public $country_ios_code = '';
    public $nationality = '';
    public $is_default = '';
    public $status = '';

    protected $rules = [
        'name' => 'required|max:50|unique:App\Models\Worlds\Country,name',
        'country_ios_code' =>'required|Max:2|Min:1|nullable|unique:App\Models\Worlds\Country,country_ios_code',
        'nationality' => 'nullable|string',
        'is_default'=> 'nullable|between:0,1',
        'status' => 'nullable|between:0,1'
    ];


    public function updated($propertyName){

        $this->validateOnly($propertyName);

    } 

    public function store(){

         $this->validate();
        Country::create([
            'name'         => $this->name,
            'country_ios_code'  => $this->country_ios_code,
            'nationality'        => $this->nationality,
            'is_default'     => $this->is_default?1:0,
            'status' => $this->status?1:0,
        ]);
        

        return redirect(route('country-management'))->with('status','Country successfully created.');
    }

    public function render()
    {
        return view('livewire.world.country.create');
    }
}
