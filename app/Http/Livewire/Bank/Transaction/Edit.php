<?php

namespace App\Http\Livewire\Bank\Transaction;

use App\Models\Bank\CardTransaction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

use App\Constants\CardTransactionStatus;

class Edit extends Component
{

    public CardTransaction $cardTransaction;
    public $allStatus;
  
    use AuthorizesRequests;


    protected function rules(){

        return [
            'cardTransaction.txn_date' => 'required',
            'cardTransaction.card_number' => 'required|numeric|digits:16|exists:App\Models\Bank\Card,card_number',
            'cardTransaction.txn_amount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'cardTransaction.txn_type' => 'required|string',
            'cardTransaction.txn_available_balance' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'cardTransaction.txn_ledger_balance' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'cardTransaction.status' => 'required',
        ];
    }

    public function mount($id){

        $this->cardTransaction = CardTransaction::find($id);
       
        $cardTransactionStatus = new CardTransactionStatus();
        $this->allStatus = $cardTransactionStatus->getConstants(); 
    }

    public function updated($propertyName){

        $this->validateOnly($propertyName);
    }

    

    public function edit(){
       
        $this->validate();
        $this->cardTransaction->update();

        return redirect(route('card-transaction-management'))->with('status','Transaction successfully updated.');
    }



    public function render()
    {
        return view('livewire.bank.transaction.edit');
    }
}
