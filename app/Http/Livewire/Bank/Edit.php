<?php

namespace App\Http\Livewire\Bank;

use App\Models\Bank\bank;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Edit extends Component
{

    public bank $bank;
  
    use AuthorizesRequests;


    protected function rules(){

        return [
            'bank.name' => 'required|unique:App\Models\bank\bank,name,' .$this->bank->id,
            'bank.bank_code' => 'required|string',
            'bank.status' => 'nullable|between:0,1',
        ];
    }

    public function mount($id){

         $this->bank = bank::find($id);
       
    }

    public function updated($propertyName){

        $this->validateOnly($propertyName);
    }

    

    public function edit(){
        $this->validate();
        $this->bank->update();

        return redirect(route('bank-management'))->with('status','Bank successfully updated.');
    }




    public function render()
    {
        return view('livewire.bank.edit');
    }
}
