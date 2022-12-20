<?php

namespace App\Http\Livewire\Bank\Transaction;

use App\Models\Bank\CardTransaction;
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
    public $transactionId = '';
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
    public function destroyConfirm($cardId)
    {
        $this->deleteId  = $cardId;
        $this->dispatchBrowserEvent('swal:confirm', [
                'action' => 'remove',
                'type' => 'warning',  
                'confirmButtonText' => 'Yes, delete it!',
                'cancelButtonText' => 'No, cancel!',
                'message' => 'Are you sure?', 
                'text' => 'If deleted, you will not be able to recover this transaction!'
            ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove()
    {
        CardTransaction::find($this->deleteId)->delete();        
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => 'Transaction Delete Successfully!']);
    }

     /**
     * update store status
     *
     * @return response()
     */
    public function statusUpdate($cardId, $status)
    {        
        $status = ( $status == 1 ) ? 0 : 1;
        CardTransaction::where('id', '=' ,  $cardId)->update(['status' => $status]);      
   }

    public function render()
    {
        return view('livewire.bank.transaction.index', [
            'transactions' => CardTransaction::searchTransactions(trim(strtolower($this->search)))->orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage)
        ]);
    }
}