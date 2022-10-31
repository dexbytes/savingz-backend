<?php

namespace App\Http\Livewire\Investment;

use Livewire\Component;
use App\Models\Investment\InvestmentType;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Index extends Component
{   
    use AuthorizesRequests;
    use WithPagination;

    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public $deleteId = '';
    public $investmentTypeId = '';

    protected $listeners = ['remove'];
    protected $queryString = ['sortField', 'sortDirection',];
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

    public function render()
    {
        return view('livewire.investment.index',[
            'investmentTypes' => InvestmentType::searchMultipleInvestmentType($this->search)->orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage)
        ]);
    }


     /**
     * Write code on Method
     *
     * @return response()
     */
    public function destroyConfirm($investmentTypeId)
    {
        $this->deleteId  = $investmentTypeId;
        $this->dispatchBrowserEvent('swal:confirm', [
                'action' => 'remove',
                'type' => 'warning',  
                'confirmButtonText' => 'Yes, delete it!',
                'cancelButtonText' => 'No, cancel!',
                'message' => 'Are you sure?', 
                'text' => 'If deleted, you will not be able to recover this investment type data!'
            ]);
    }

    
     /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove()
    {
        InvestmentType::find($this->deleteId)->delete();

        $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',  
                'message' => 'Investment Type Delete Successfully!', 
                'text' => 'It will not list on investment types table soon.'
            ]);
    }  


    /**
     * update investment type  status
     *
     * @return response()
     */
    public function statusUpdate($investmentTypeId, $status)
    {        
        $status = ( $status == 1 ) ? 0 : 1;
        InvestmentType::where('id', '=' , $investmentTypeId )->update(['status' => $status]);      
    }
}
