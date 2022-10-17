<?php

namespace App\Http\Livewire\Order;

use App\Models\Order\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\GlobalTrait;

class Index extends Component
{  
    use AuthorizesRequests;
    use WithPagination;
    use GlobalTrait;

    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $perPage = '';
    public $currency = '';
    public $filter = [];
    public $deleteId = '';
    public $orderId = '';
    public $orderStatus = '';

    protected $listeners = ['remove', 'confirm'];

    protected $queryString = ['sortField', 'sortDirection', 'orderStatus'];
    protected $paginationTheme = 'bootstrap';
    
 
    public function mount() {
        $this->perPage = config('commerce.pagination_per_page');
        $this->currency = config('commerce.price');
        $this->filter['orderStatus'] = $this->orderStatus;

        if(auth()->user()->hasRole('Provider')){
            $this->filter['is_provider'] = true;
            $this->filter['store_id'] = $this->getStoreId();
        }
        
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
    public function destroyConfirm($productId)
    {
        $this->deleteId  = $productId;
        $this->dispatchBrowserEvent('swal:confirm', [
                'action' => 'remove',
                'type' => 'warning',  
                'confirmButtonText' => 'Yes, delete it!',
                'cancelButtonText' => 'No, cancel!',
                'message' => 'Are you sure?', 
                'text' => 'If deleted, you will not be able to recover this product!'
            ]);
    }   
     /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove()
    {
        Product::find($this->deleteId)->delete();

        $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',  
                'message' => 'Order Delete Successfully!', 
                'text' => 'It will not list on order table soon.'
            ]);
    }
 
    public function render()
    {
        return view('livewire.order.index',[
             'orders' => Order::searchMultipleOrder($this->search, $this->filter)->orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage)
        ]);
    }
            
    /**
     * update store status
     *
     * @return response()
     */
    public function statusUpdate($orderId, $status)
    {        
        
    }

}
