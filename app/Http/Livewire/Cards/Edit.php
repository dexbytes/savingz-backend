<?php

namespace App\Http\Livewire\Cards;

use App\Models\Cards\Card;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Edit extends Component
{
    public Card $card;
  
    use AuthorizesRequests;


    protected function rules(){

        return [
            'card.card_holder_name' => 'nullable',
            'card.expiration_year' => 'nullable|numeric|digits:4',
            'card.expiration_month' => 'nullable|numeric|digits:2|min:1|max:12',
            'card.card_number' => 'required|numeric|unique:App\Models\Cards\Card,card_number,'.$this->card->id,
            'card.status' => 'nullable|between:0,1',
        ];
    }

    public function mount($id){

         $this->card = Card::find($id);
       
    }

    public function updated($propertyName){

        $this->validateOnly($propertyName);
    }

    

    public function edit(){
        $this->validate();
        $this->card->update();

        return redirect(route('cards-management'))->with('status','Card successfully updated.');
    }

    public function render()
    {
        return view('livewire.cards.edit');
    }
}
