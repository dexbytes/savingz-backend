<?php

namespace App\Http\Livewire\UserManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Driver\UserDriver;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;

class Application extends Component
{

    use AuthorizesRequests;
    use WithPagination;

    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public $account_status = '';
    public $filterStatus = ['pending', 'cancelled', 'declined', 'suspended'];
    public $deleteId = '';
    public $actionStatus = '';
    public $userId = '';
    public $roles;
    public $filter = [];

    protected $listeners = ['remove', 'confirmApplication'];

    protected $queryString = ['sortField', 'sortDirection'];
    protected $paginationTheme = 'bootstrap';


    public function mount($status = null) { 

        if($status == 'pending'){
            $this->filterStatus =  ['pending'];
        }

        if($status == 'declined'){
            $this->filterStatus =  ['declined', 'cancelled', 'suspended'];
        }
        
        $this->perPage = config('commerce.pagination_per_page');
    }

    public function sortBy($field){
        if($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    
    public function render()
    {
        return view('livewire.user-management.application',[
            'users' => User::with(['roles'])->whereIn('account_status', $this->filterStatus)->searchMultipleUsers(trim(strtolower($this->search)), $this->filter)->orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage)
        ]);
    }


   /**
     * Write code on Method
     *
     * @return response()
     */
    public function destroyConfirm($userId)
    {
        $this->deleteId  = $userId;
        $this->dispatchBrowserEvent('swal:confirm', [
                'action' => 'remove',
                'type' => 'warning',  
                'confirmButtonText' => 'Yes, delete it!',
                'cancelButtonText' => 'No, cancel!',
                'message' => 'Are you sure?', 
                'text' => 'If deleted, you will not be able to recover this imaginary file!'
            ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove()
    {
        User::find($this->deleteId)->delete();

        $this->dispatchBrowserEvent('alert', 
            ['type' => 'success',  'message' => 'User Delete Successfully!']);
    }

    

     /**
     * Write code on Method
     *
     * @return response()
     */
    public function applicationConfirm($userId, $status)
    {
        $this->userId  = $userId;
        $this->actionStatus = $status;

        $this->dispatchBrowserEvent('swal:confirmApplication', [
                'action' => 'confirmApplication',
                'type' => 'warning',  
                'confirmButtonText' =>  $status == 'accepted' ? 'Yes, approve it!' : 'Yes reject it',
                'cancelButtonText' => 'No, cancel!',
                'message' => $status == 'accepted' ? 'Are you approve?' : 'Are you Reject', 
                'text' =>  $status == 'accepted' ?  'If approved, Customer will be listed in customers sections!' : 'If rejected, customer will be not listed in customers sections!'
            ]);
    }  

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function confirmApplication()
    {        
        $password = 'password';
        User::where('id', '=' , $this->userId)->update(['status' => 1, 'password' => Hash::make( $password ), 'account_status' => $this->actionStatus]);
       
        //Twillo API
        $message = 'Your password is : '. $password;
        //Twillo::sendMessage($mobileNumber, $message);

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',  
            'message' => $this->actionStatus == 'accepted' ? 'Customer Application Approved Successfully!' : 'Customer Application Rejected ', 
            'text' =>  $this->actionStatus == 'accepted' ?  'It will be list on users table soon.' : 'It will be not list on users table soon.'
        ]);

    }

        
    /**
     * update store status
     *
     * @return response()
     */
    public function statusUpdate($userId, $status)
    {        
        $status = ( $status == 1 ) ? 0 : 1;
        User::where('id', '=' , $userId )->update(['status' => $status]);      

   }


}
