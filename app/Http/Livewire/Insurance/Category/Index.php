<?php

namespace App\Http\Livewire\Insurance\Category;

use App\Models\Insurance\InsuranceCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $perPage = '' ;
    public $deleteId;
    public $insuranceCategoryId = '';
    protected $listeners = ['remove', 'confirm'];
    protected $queryString = ['sortField' , 'sortDirection'];
    protected $paginationTheme = 'bootstrap';

    public function sortBy($field){

        if($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }
    public function mount()
    {
         $this->perPage = config("commerce.pagination_per_page");
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function destroyConfirm( $insuranceCategoryId)
    {
        $this->deleteId  = $insuranceCategoryId;
        $this->dispatchBrowserEvent('swal:confirm', [
                'action' => 'remove',
                'type' => 'warning',  
                'confirmButtonText' => 'Yes, delete it!',
                'cancelButtonText' => 'No, cancel!',
                'message' => 'Are you sure?', 
                'text' => 'If deleted, you will not be able to recover this Insurence Category!'
            ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove()
    {
        InsuranceCategory::find($this->deleteId)->delete();
        
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => 'Insurence Category Delete Successfully!']);
    }

     /**
     * update store status
     *
     * @return response()
     */
    public function statusUpdate($insuranceCategoryId, $status)
    {        
        $status = ( $status == 1 ) ? 0 : 1;
        InsuranceCategory::where('id', '=' ,  $insuranceCategoryId )->update(['status' => $status]);      

   }

    public function render()
    {
        return view('livewire.insurance.category.index', [
            'insurenceCategories' => InsuranceCategory::searchMultipleinsurenceCtegory(trim(strtolower($this->search)))->orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage)
        ]);
    }
}
