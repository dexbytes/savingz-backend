<?php

namespace App\Http\Livewire\Import;

use App\Models\Import\ExcelImport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use App\Constants\ExcelImport\ExcelStatus;
use App\Models\Import\ExcelExport;
use Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CardExport;
use App\Exports\FixedDepositExport;
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
     * download original excel 
     *
     * @return excel ()
     */
    public function Export($file_name,$file)
    {
        if (!Storage::disk(config('excelimport.filesystem'))->exists($file)) {
            return  $this->dispatchBrowserEvent('alert', 
            ['type' => 'warning',  'message' => 'File not found!']);      
        }
        return Storage::disk(config('excelimport.filesystem'))->download($file);
    }

    /**
     * download success excel 
     *
     * @return excel ()
     */
    public function ExportSuccess($file_name,$file,$category)
    {     
        if (!Storage::disk(config('excelimport.filesystem'))->exists($file)) {
            return  $this->dispatchBrowserEvent('alert', 
            ['type' => 'warning',  'message' => 'File not found!']);      
        }
        $data = @json_decode(Storage::disk(config('excelimport.filesystem'))->get($file),true);
        if (count($data) == 0) {
          return  $this->dispatchBrowserEvent('alert', 
        ['type' => 'warning',  'message' => 'Record not found!']);
        }
       $file_name = 'Success - '.pathinfo($file_name,PATHINFO_FILENAME);
       return self::_moduleMethod($category,$data,$file,$file_name);
    }

    /**
     * download failed excel 
     *
     * @return excel ()
     */
    public function ExportFailed($file_name,$file,$category)
    {
        if (!Storage::disk(config('excelimport.filesystem'))->exists($file)) {
            return  $this->dispatchBrowserEvent('alert', 
            ['type' => 'warning',  'message' => 'File not found!']);      
        }
        $data = @json_decode(Storage::disk(config('excelimport.filesystem'))->get($file),true);
        if (count($data) == 0) {
          return  $this->dispatchBrowserEvent('alert', 
        ['type' => 'warning',  'message' => 'Record not found!']);
        }
       $file_name = 'Failed - '.pathinfo($file_name,PATHINFO_FILENAME);
       return self::_moduleMethod($category,$data,$file,$file_name);
    }
    
    /**
     * return excel download
     *
     * @return excel()
     */
    public static function _moduleMethod($fileModule,$data,$file,$file_name){
        
        $export = '';       
        switch ($fileModule) {
            case "CardSummaryReport":
                $export = Excel::download(new CardExport($data,$file) , $file_name.'.xls');
            break; 
            case "fixed-deposit":
                $export = Excel::download(new FixedDepositExport($data,$file) , $file_name.'.xls');
                break;           
            default:
                $export = '';
        }

        return $export;
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
