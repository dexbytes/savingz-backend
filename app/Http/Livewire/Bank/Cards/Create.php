<?php

namespace App\Http\Livewire\Bank\Cards;

use App\Models\Bank\Card;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Create extends Component
{
   
    use AuthorizesRequests;
    public $card_holder_name = '';
    public $expiration_year = '';
    public $expiration_month = '';
    public $card_number = '';
    public $status= '';
 

    protected $rules=[
        'card_holder_name' => 'nullable',
        'expiration_year' => 'nullable|numeric|digits:4',
        'expiration_month' => 'nullable|numeric|digits:2|min:1|max:12',
        'card_number' => 'required|numeric|digits:16|unique:App\Models\Bank\Card,card_number',
        'status' => 'nullable|between:0,1',
    ];

    public function updated($propertyName){

        $this->validateOnly($propertyName);

    } 
 
    public function store(){

        $this->validate();

        $card = Card::create([
            'card_holder_name'  => $this->card_holder_name, 
            'expiration_year'  => $this->expiration_year,
            'expiration_month'  => $this->expiration_month, 
            'card_number'  => $this->card_number,
            'status' => $this->status ? 1:0,
       ]);
 
        return redirect(route('cards-management'))->with('status','Card successfully created.');
    }

    public function render()
    {  
        return view('livewire.bank.cards.create');
    }

}
