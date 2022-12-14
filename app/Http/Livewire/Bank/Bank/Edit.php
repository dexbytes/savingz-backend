<?php

namespace App\Http\Livewire\Bank\Bank;

use App\Models\Bank\Bank;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Edit extends Component
{

    public Bank $bank;
  
    use AuthorizesRequests;


    protected function rules(){

        return [
            'bank.name' => 'required|unique:App\Models\Bank\Bank,name,' .$this->bank->id,
            'bank.bank_code' => 'required|string|unique:App\Models\Bank\Bank,bank_code,' .$this->bank->id,
            'bank.status' => 'nullable|between:0,1',
        ];
    }

    public function mount($id){
        $this->bank = Bank::find($id);
        if(empty($this->bank)) return redirect(route('bank-management'))->with('error','Record not found.');
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
        return view('livewire.bank.bank.edit');
    }
}
