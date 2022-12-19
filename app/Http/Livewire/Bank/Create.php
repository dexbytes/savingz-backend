<?php

namespace App\Http\Livewire\Bank;

use App\Models\Bank\bank;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Create extends Component
{


    use AuthorizesRequests;
   
    public $name='';
    public $bank_code='';
    public $status= '';
   

    protected $rules=[
        'name' => 'required|string|unique:App\Models\bank\bank,name',
        'bank_code' => 'required|string',
        'status' => 'nullable|between:0,1',
       
    ];

    public function updated($propertyName){

        $this->validateOnly($propertyName);

    } 

    public function store(){

        $this->validate();

         bank::create([
            'name'         => $this->name,
            'bank_code'  => $this->bank_code,
            'status'        => $this->status ? 1:0,
           
        ]);

        return redirect(route('bank-management'))->with('status','Bank successfully created.');
    }


    public function render()
    {
        return view('livewire.bank.create');
    }
}
