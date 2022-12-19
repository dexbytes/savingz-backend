<?php

namespace App\Http\Livewire\Insurance\Category;

use App\Models\Insurance\insuranceCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Create extends Component
{
   
    use AuthorizesRequests;
    public $name = '';
    public $status= '';
   
    protected $rules=[
        'name' => 'required|string|unique:App\Models\Insurance\insuranceCategory,name',
        'status' => 'nullable|between:0,1',
            
    ];

    public function updated($propertyName){

        $this->validateOnly($propertyName);

    } 

    
    public function store(){

        $this->validate();

        $faq = insuranceCategory::create([
            'name'  => $this->name,  
            'status' => $this->status ? 1:0,
       ]);
 
        return redirect(route('insurence-category-management'))->with('status','Insurence Category successfully created.');
    }

    public function render()
    {
        return view('livewire.insurance.category.create');
    }

}
