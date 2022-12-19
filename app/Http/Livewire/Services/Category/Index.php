<?php

namespace App\Http\Livewire\Services\Category;

use App\Models\Services\serviceCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

    class Index extends Component
    {
        use AuthorizesRequests;
        use WithPagination;
        
    
        public $search = '';
        public $sortField = 'id';
        public $sortDirection = 'desc';
        public $perPage = 10;
        public $addOnOption = '';
        public $filter = [];
        public $deleteId = '';       
        public $categoyId = '';     
        protected $listeners = ['remove', 'confirm'];    
        protected $queryString = ['sortField', 'sortDirection'];
        protected $paginationTheme = 'bootstrap';
    
        public function mount() { 
            $this->perPage = config('commerce.pagination_per_page');
        }
    
        public function sortBy($field){
            if($this->sortField === $field) {
                $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                $this->sortDirection = 'asc';
            }
            $this->sortField = $field;
        }
    
    
  /**
     * Write code on Method
     *
     * @return response()
     */
    public function destroyConfirm($serviceCategoryId)
    {
        $this->deleteId  =$serviceCategoryId;
        $this->dispatchBrowserEvent('swal:confirm', [
                'action' => 'remove',
                'type' => 'warning',  
                'confirmButtonText' => 'Yes, delete it!',
                'cancelButtonText' => 'No, cancel!',
                'message' => 'Are you sure?', 
                'text' => 'If deleted, you will not be able to recover this service Category!'
            ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove()
    {
        serviceCategory::find($this->deleteId)->delete();

        $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',  
                'message' => 'service Category Delete Successfully!', 
                'text' => 'It will not list on service category table soon.'
            ]);
    }

     /**
     * update store status
     *
     * @return response()
     */
    public function statusUpdate($serviceCategoryId, $status)
    {        
        $status = ( $status == 1 ) ? 0 : 1;
        serviceCategory::where('id', '=' , $serviceCategoryId )->update(['status' => $status]);      

   }



    public function render()
    {
        return view('livewire.services.category.index',[
            'serviceCategories' => serviceCategory::searchMultipleServiceCategory(trim(strtolower($this->search)))->orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage)
        ]);
    }

    
}
