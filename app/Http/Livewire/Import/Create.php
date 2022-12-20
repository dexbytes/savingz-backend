<?php

namespace App\Http\Livewire\Import;

use App\Models\Import\ExcelImport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;
use Storage;
use App\Constants\ExcelImport\ExcelStatus;
use App\Jobs\ExtractExcel;
use Carbon\Carbon;

class Create extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;
   
    public $import_file = '';
   
    protected $rules=[
        'import_file' => 'required|mimes:csv,txt,xls,xlsx',    
    ];

    public function updated($propertyName){

        $this->validateOnly($propertyName);

    } 

    public function store(){

        $this->validate();
      
        $import_file = $this->import_file->store('CardSummaryReport', config('excelimport.filesystem'));
        $excelImport = ExcelImport::create([
            'user_id'       => auth()->user()->id,
            'category_type' => 'CardSummaryReport',
            'size'          =>  $this->import_file->getSize() ,
            'file_name'    => $this->import_file->getClientOriginalName(),
            'path'     => $import_file,
            'url'  => Storage::disk('public')->path($import_file),
            'type' => $this->import_file->clientExtension(),
            'status' => ExcelStatus::PENDING
        ]);
 
        ExtractExcel::dispatch($excelImport)->delay(Carbon::now()->addSeconds(config('excelimport.extract_dealy_time')));
      
        return redirect(route('import-files-management'))->with('status','File successfully uploaded.');
    }


    public function render()
    {
        return view('livewire.import.create');
    }
}
