<?php

namespace App\Http\Livewire\Insurance\FixedDeposit;

use App\Models\Insurance\FixedDeposit\FixedDeposit;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Edit extends Component
{
    public FixedDeposit $fixedDeposite;
   
  
    use AuthorizesRequests;


    protected function rules(){

        return [
            'fixedDeposite.allotment_date' => 'required',
            'fixedDeposite.investor' => 'required',
            'fixedDeposite.entity' => 'required',
            'fixedDeposite.pan' => 'required|string',
            'fixedDeposite.fd_issuer' => 'required',
            'fixedDeposite.tenure_months' => 'required',
            'fixedDeposite.tenure_days' => 'required',
            'fixedDeposite.amount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'fixedDeposite.interest_rate' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'fixedDeposite.type' => 'required',
            'fixedDeposite.commission_in_rate' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'fixedDeposite.commission_out_rate' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'fixedDeposite.reference_number' => 'required',
            'fixedDeposite.bank_name' => 'required',
            'fixedDeposite.cheque_number' => 'required',
            'fixedDeposite.remarks' => 'required',
            'fixedDeposite.status' => 'required',

        ];
    }

    public function mount($id){

       $this->fixedDeposite = FixedDeposit::find($id);
    }

    public function updated($propertyName){

        $this->validateOnly($propertyName);
    }

    

    public function edit(){
       
        $this->validate();
        $this->fixedDeposite->update();

        return redirect(route('fixed-deposit-management'))->with('status','Fixed Deposit successfully updated.');
    }




    public function render()
    {
        return view('livewire.insurance.fixeddeposit.edit');
    }
}
