<?php

namespace App\Http\Livewire\Services\Category;

use App\Models\Services\serviceCategory;
use App\Models\Services\serviceCategoryKeyword;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Edit extends Component
{

    use AuthorizesRequests;
    public serviceCategory $serviceCategory;
    public $keywords = [];
    public $inputTypeCode = '';
    public $serviceCategoryKeyword;
  

    protected function rules(){
        return [
            'serviceCategory.name' => 'required|max:255|unique:service_categories,name,'.$this->serviceCategory->id,
            'serviceCategory.status' => 'nullable|between:0,1',
            'keywords.*.name' => 'required',
            
        ];  
    }

    protected $messages = [
        'keywords.*.name.required' => 'This Name is required.',
        
    ];
    
    public function mount($id) {
        $this->serviceCategory = serviceCategory::find($id);
        $serviceCategoryKeyword = serviceCategoryKeyword::where('service_category_id' , $id)->get();
        foreach($serviceCategoryKeyword as $key => $value){
            $this->keywords[] = ['name' => $value->name];
        }
  
    }


    public function updated($propertyName){

        $this->validateOnly($propertyName);
    }


    public function addInput()
    {    
        $this->keywords[] = (['service_category_id '=> '','name' =>'']);
    }




    public function removeInput($index)
    {
        unset($this->keywords[$index]);
        $this->keywords = array_values($this->keywords);
        
    }



    public function edit(){

        $this->validate();
        $this->serviceCategory->update();
         serviceCategoryKeyword::whereServiceCategoryId($this->serviceCategory->id)->delete();
        foreach($this->keywords as $key => $value){
            $keywords[] = ['service_category_id'=> $this->serviceCategory->id, 'name' => $value['name'], 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()]; 
        }
        
        !empty($keywords) ? serviceCategoryKeyword::insert($keywords) : "";
        return redirect(route('service-category-management'))->with('status', 'service Category successfully updated.');
    }



    public function render()
    {
        return view('livewire.services.category.edit');
    }
}
