<?php

namespace App\Http\Livewire\Import;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component; 
use Storage;
use Carbon\Carbon;
use App\Constants\ExcelImport\ExcelStatus;
use App\Models\Import\ExcelImport;
use App\Jobs\CardSummaryExcel;

class View extends Component
{
    use AuthorizesRequests;
    public $file;
    public $header;
    public $successData;
    public $failedData;
    public $displayData;
    public $status;
    protected $listeners = ['uploadNow'];
   
    public function mount($id){
   
        $this->file = ExcelImport::where('id', $id)->first();
        $this->displayData =  collect();
        $this->successData =  collect();
        $this->failedData =  collect();
        $this->header =  collect();

        if($this->file->category_type == 'CardSummaryReport'){
            $this->header = \App\Constants\ExcelImport\CardSummaryHeader::HEADER;
        }
       
        if(!empty($this->file->success_path) && Storage::disk(config('excelimport.filesystem'))->exists($this->file->success_path)){
            $this->successData =  @json_decode(Storage::disk(config('excelimport.filesystem'))->get($this->file->success_path),true);
            $this->displayData =  $this->successData;
        }
        if(!empty($this->file->failed_path) && Storage::disk(config('excelimport.filesystem'))->exists($this->file->failed_path)){
            $this->failedData =  @json_decode(Storage::disk(config('excelimport.filesystem'))->get($this->file->failed_path),true);
        } 
    }

    public function render()
    {
        return view('livewire.import.view');
    }

    public function tabChange($type)
    {
        $this->status = $type;
        if($type == 'invalid'){
            $this->displayData =  $this->failedData;
           
        }
        if($type == 'valid'){
            $this->displayData =  $this->successData;
        }
     
    }


   /**
     * Write code on Method
     *
     * @return response()
     */
    public function destroyUpload()
    {
        $this->dispatchBrowserEvent('swal:confirm', [
                'action' => 'uploadNow',
                'type' => 'warning',  
                'confirmButtonText' => 'Yes, upload it!',
                'cancelButtonText' => 'No, cancel!',
                'message' => 'Are you sure?', 
                'text' => 'If upload, you will not be able to revert this data!'
            ]);
    }

 
    public function uploadNow()
    {
        $file = ExcelImport::where('id', $this->file->id)->update(['status' => ExcelStatus::ACCEPTED]);
        if($this->file->category_type == 'CardSummaryReport'){
            CardSummaryExcel::dispatch($this->file->id)->delay(Carbon::now()->addSeconds(config('excelsettings.import_dealy_time')));
        }
        return redirect(route('import-files-management'))->with('status','Data uploading start successfully.');
    }
}
