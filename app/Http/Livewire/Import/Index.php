<?php

namespace App\Http\Livewire\Import;

use App\Models\Import\ExcelImport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use App\Constants\ExcelImport\ExcelStatus;

class Index extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $perPage = '' ;
    public $deleteId;
    public $cancelId;
    public $insuranceCategoryId = '';
    protected $listeners = ['remove', 'confirm', 'cancel'];
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
                'text' => 'If deleted, you will not be able to recover this file!'
            ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove()
    {
        ExcelImport::find($this->deleteId)->delete();
        
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => 'Import File Delete Successfully!']);
    }

     /**
     * update store status
     *
     * @return response()
     */
    public function statusUpdate($insuranceCategoryId, $status)
    {        
        $status = ( $status == 1 ) ? 0 : 1;
        ExcelImport::where('id', '=' ,  $insuranceCategoryId )->update(['status' => $status]);      

   }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function cancelConfirm($id)
    {
        $this->cancelId  = $id;
        $this->dispatchBrowserEvent('swal:confirm', [
                'action' => 'cancel',
                'type' => 'warning',  
                'confirmButtonText' => 'Yes, cancel it!',
                'cancelButtonText' => 'No!',
                'message' => 'Are you sure?', 
                'text' => 'If cancelled, you will not be able to upload this file data!'
            ]);
    }

    /**
     * cancel file status
     *
     * @return response()
     */
    public function cancel()
    {        
       ExcelImport::where('id', '=' ,  $this->cancelId )->update(['status' => ExcelStatus::CANCELLED]); 
       $this->dispatchBrowserEvent('alert', 
       ['type' => 'success',  'message' => 'Import File cancelled Successfully!']);     
    }

    /**
     * view html
     *
     * @return html()
     */
    public function render()
    {
        return view('livewire.import.index', [
            'import_files' => ExcelImport::orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage)
        ]);
    }
}
