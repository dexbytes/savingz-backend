<?php

namespace App\Http\Livewire\Bank;

use App\Models\Bank\Bank;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Create extends Component
{


    use AuthorizesRequests;
   
    public $name='';
    public $bank_code='';
    public $status= '';
   

    protected $rules=[
        'name' => 'required|string|unique:App\Models\Bank\Bank,name',
        'bank_code' => 'required|string|unique:App\Models\Bank\Bank,bank_code',
        'status' => 'nullable|between:0,1',
       
    ];

    public function updated($propertyName){

        $this->validateOnly($propertyName);

    } 

    public function store(){

        $this->validate();

        Bank::create([
            'name'       => $this->name,
            'bank_code'  => $this->bank_code,
            'status'     => $this->status ? 1:0,
        ]);

        return redirect(route('bank-management'))->with('status','Bank successfully created.');
    }


    public function render()
    {
        return view('livewire.bank.create');
    }
}
