<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Order\Order;
use Illuminate\Support\Facades\DB;
use App\Traits\GlobalTrait;
use App\Models\Bank\UserCard;

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
    public $totalBankCards = 0;
     

    public function mount() {
        
         // New customers registered in last 7 days 
        $this->dateBeforeSeven = \Carbon\Carbon::today()->subDays(7);
        $this->todayDate = \Carbon\Carbon::today();

         //Total customers        
         $this->totalCustomers = User::whereHas('roles', function ($query) {
            $query->where('name' , '=' ,  'Customer');
            })->count();     

        $this->newCustomers = User::whereHas('roles', function ($query){
                $query->where('name' , '=' ,  'Customer');
                })->where('created_at','>=', $this->dateBeforeSeven)->count();
                
        $this->pendingRequest = User::whereHas('roles', function ($query){
            $query->where('name' , '=' ,  'Customer');
            })->where('account_status', 'pending')->count();

        $this->totalBankCards = UserCard::where('created_at','>=', $this->dateBeforeSeven)->count();
 
    } 

    public function render()
    {
        return view('livewire.dashboard.home');
    }
}
