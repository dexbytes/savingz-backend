<?php

namespace App\Http\Livewire\Insurance\Category;

use App\Models\Insurance\insuranceCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Edit extends Component
{
    public insuranceCategory $insurenceCategory;
  
    use AuthorizesRequests;


    protected function rules(){

        return [
            'insurenceCategory.name' => 'required|unique:App\Models\Insurance\insuranceCategory,name,'.$this->insurenceCategory->id,
            'insurenceCategory.status' => 'nullable|between:0,1',
        ];
    }

    public function mount($id){

         $this->insurenceCategory = insuranceCategory::find($id);
       
    }

    public function updated($propertyName){

        $this->validateOnly($propertyName);
    }

    

    public function edit(){
        $this->validate();
        $this->insurenceCategory->update();

        return redirect(route('insurence-category-management'))->with('status','Insurence Category successfully updated.');
    }

    public function render()
    {
        return view('livewire.insurance.category.edit');
    }
}
