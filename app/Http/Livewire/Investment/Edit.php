<?php

namespace App\Http\Livewire\Investment;

use Livewire\Component;
use App\Models\Investment\InvestmentType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Edit extends Component
{   
    use AuthorizesRequests;
    public InvestmentType $investmentType;

    protected function rules() {
        return [
            'investmentType.name'   => 'required|unique:App\Models\Investment\InvestmentType,name,'.$this->investmentType->id,
            'investmentType.status' => 'nullable|between:0,1',
        ];
    }

    public function mount($id) {

        $this->investmentType = InvestmentType::find($id);

    }

    public function updated($propertyName){

        $this->validateOnly($propertyName);
    }

    public function edit() {

        $this->validate();
        $this->investmentType->update();

        return redirect(route('investment-type-management'))->with('status', 'Investment type successfully updated.');

    }
    
    public function render()
    {
        return view('livewire.investment.edit');
    }
}
