<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Order\Order;
use Illuminate\Support\Facades\DB;
use App\Traits\GlobalTrait;
class Index extends Component
{   
   use GlobalTrait;

    public $totalCustomers= 0;
    public $newCustomers= 0;
    public $pendingRequest = 0;
    public $sales = 0;
    public $data = [];
    public $orders;

    public $months = [];
    public $completed = [];
    public $total = [];
    public $dateBeforeSeven;
    public $todayDate;
    public $orderStatus = ['completed', 'pending', 'cancelled', 'refund'];
    public $totalCompletedOrders = 0;
     

    public function mount() {
        
         // New customers registered in last 7 days 
        $this->dateBeforeSeven = \Carbon\Carbon::today()->subDays(7);
        $this->todayDate = \Carbon\Carbon::today();
 
    } 

    public function render()
    {
        return view('livewire.dashboard.home');
    }
}
