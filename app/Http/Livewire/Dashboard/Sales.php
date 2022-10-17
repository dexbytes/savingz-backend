<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\GlobalTrait;

class Sales extends Component
{ 
    use GlobalTrait;

    public function render()
    {
        return view('livewire.dashboard.sales');
    }
}
