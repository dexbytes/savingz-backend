<?php

namespace App\Http\Livewire\Investment;

use Livewire\Component;
use App\Models\Investment\InvestmentType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Create extends Component
{   
    use AuthorizesRequests;
    
    public $name = '';
    public $status;

    protected $rules = [
        'name'   => 'required|max:255|unique:App\Models\Investment\InvestmentType,name',
        'status' => 'nullable|between:0,1',
    ];


    public function updated($propertyName){

        $this->validateOnly($propertyName);

    } 

    public function store() {
        $this->validate();
        
        InvestmentType::create([
            'name'   => $this->name,
            'status' => $this->status ? 1 : 0,
        ]);

        return redirect(route('investment-type-management'))->with('status','Investment type successfully created.');
    }

    public function render()
    {
        return view('livewire.investment.create');
    }
}
