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
   
    public function mount($id){
        
        $this->file = ExcelImport::where('id', $id)->first();
     
        if($this->file->category_type == 'CardSummaryReport'){
            $this->header = \App\Constants\ExcelImport\CardSummaryHeader::HEADER;
        }
       
        $this->successData =  @json_decode(Storage::disk(config('excelimport.filesystem'))->get($this->file->success_path),true);
        $this->failedData =  @json_decode(Storage::disk(config('excelimport.filesystem'))->get($this->file->success_path),true);
        $this->displayData =  $this->successData;
      
   }

    public function render()
    {
        return view('livewire.import.view');
    }
 
    public function uploadNow()
    {
        $file = ExcelImport::where('id', $this->file->id)->update(['status' => ExcelStatus::ACCEPTED]);
        
        CardSummaryExcel::dispatch($this->file->id)->delay(Carbon::now()->addSeconds(config('excelsettings.import_dealy_time')));
      
        return redirect(route('import-files-management'))->with('status','Data uploading start successfully.');
    }
}
