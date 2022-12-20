<?php

namespace App\Http\Livewire\Import;

use App\Models\Import\ExcelImport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;

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
      
        $profile_photo = $this->import_file->store('CardSummaryReport', config('excelimport.filesystem'));

        return redirect(route('import-files-management'))->with('status','File successfully uploaded.');
    }


    public function render()
    {
        return view('livewire.import.create');
    }
}
