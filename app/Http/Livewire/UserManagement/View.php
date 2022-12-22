<?php

namespace App\Http\Livewire\UserManagement;

use App\Constants\OrderReviewTypes;
use App\Models\Address;
use App\Models\Bank\Card;
use App\Models\Bank\UserCard;
use App\Models\Driver\UserDriver;
use App\Models\Stores\StoreOwners;
use App\Models\User;
use App\Models\Users\UserMetaData;
use App\Models\Worlds\Country;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use DB;
use Str;

class View extends Component
{


    use WithFileUploads;
    use AuthorizesRequests;

    public User $user;
    public $address;
    public $profile_photo;
    public $roles;
    public $role_id = []; 
    public $countries = '';
    public $userId = '';
    public $confirmationPassword ='';
    public $new_password = "";
    public $stores;
    public $userMeta;
    public $orderReviewType = [];  
    public $driver_commission_value;
    public $is_global_commission;
    public $search_card ;
    public $searchResultCards; 
    public $card;
    public $card_id = '';
    public $user_id = '';
    public $deleteId = '';
    public $selected_card_id = '';
    public $is_card_available;
    public $card_holder_name;
    
    protected $listeners = [
        'remove',
        'cardSubmit',
        'ownerRemove',
        'getRoleIdForInput',
        'refreshComponent' => '$refresh'
    ];

    
    protected function rules(){
        return [
            'user.email' => 'required|email|unique:App\Models\User,email,'.$this->user->id,
            'user.name' =>'required',
            'user.phone' =>'required|min:8|unique:App\Models\User,phone,'.$this->user->id,            
            'role_id' => 'required',
            'user.country_code' => 'required',
            'user.aadhar_card_number' => 'nullable|regex:/^\d{12}$/|unique:App\Models\User,aadhar_card_number,'.$this->user->id,  
            'user.pan_card_number' => 'nullable|regex:/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/|unique:App\Models\User,pan_card_number,'.$this->user->id,  
        ];
    }

    public function mount($id) {

        $this->user = User::find($id);
        $this->is_card_available = false;
        $this->selected_card_id = '';
        $this->card_holder_name =  $this->user->name;
        $this->card = Card::whereHas('UserCard',function ($query) use($id){
            $query->where('user_id',$id);
        })->get();
        
        $this->user->phone = substr($this->user->phone , +(strlen($this->user->country_code)));
        $this->roles = Role::where('guard_name', 'web')->where('status', 1)->get(['id','name']);
        $this->role_id  = $this->user->getRoleNames();
        $this->countries = Country::all();
        $this->address = Address::where('user_id' , $this->user->id)->get();
        $this->stores = StoreOwners::where('user_id', $this->user->id)->get();
        $this->userMeta = UserMetaData::where('user_id' , $this->user->id)->get();
       
        $orderReviewType = new OrderReviewTypes;
        $this->orderReviewType = $orderReviewType->getConstants();
       
        $this->driver_commission_value =  !empty($this->user->driver) ? $this->user->driver->driver_commission_value : 0;
        $this->is_global_commission =  !empty($this->user->driver) ? $this->user->driver->is_global_commission : 0;
 
    }

    public function updated($propertyName){

        $this->validateOnly($propertyName);

    } 


    public function selectCard($cardId){
        
        if($this->selected_card_id){
            $this->selected_card_id = '';
        }else{
            $this->selected_card_id = $cardId;
        }
       
    }


     /**
     * Write code on Method
     *
     * @return response()
     */
    public function destroyConfirm($cart_id)
    {
        $this->deleteId  = $cart_id;
        $this->dispatchBrowserEvent('swal:confirm', [
                'action' => 'remove',
                'type' => 'warning',  
                'confirmButtonText' => 'Yes, delete it!',
                'cancelButtonText' => 'No, cancel!',
                'message' => 'Are you sure?', 
                'text' => 'If deleted, you will not be able to recover this card'
            ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove()
    {
        UserCard::where('card_id',$this->deleteId)->delete();

        $this->dispatchBrowserEvent('alert', 
            ['type' => 'success',  'message' => 'Card Delete Successfully!']);
            return redirect(request()->header('Referer'));     
    }

    

    public function resetField(){
        $this->user->phone = substr($this->user->phone , (strlen($this->user->country_code)));
        $this->search_card = ''; 
        $this->selected_card_id = '';   
        $this->emit('refreshComponent');       
    }

    public function cancel()
    {
        $this->resetField();
    }


    public function update(){
        
        $this->validate();
        $this->user->phone =  $this->user->country_code. $this->user->phone;
        if(!empty($this->role_id)){
            $this->user->syncRoles($this->role_id);     
        }

        $this->user->save();
        $this->resetField();
        
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => 'User successfully updated.']); 
    }


    public function updatedIsGlobalCommission(){
       
        $this->is_global_commission = $this->is_global_commission ? 1 : 0;
        $this->user->driver->update(['is_global_commission' => $this->is_global_commission, 'driver_commission_value' => config('app_settings.driver_commission.value')]);
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => 'Commission successfully updated.']);
    }


    public function updatedDriverCommissionValue(){
       
        $this->validate([
            'driver_commission_value' => 'required|max:'.config('app_settings.driver_commission.value').'|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
        ]);
        
        $this->user->driver->update(['driver_commission_value' => $this->driver_commission_value]);
     
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => 'Commission successfully updated.']);
    }

     /**
     * update user Profile
     *
     * @return response()
     */
    public function updatedProfilePhoto()
    {        
        $this->validate([
            'profile_photo' => 'required|mimes:jpg,jpeg,png|max:1024',
        ]);
          
        $profile_photo = $this->profile_photo->store('users', config('app_settings.filesystem_disk.value'));
        User::where('id', '=' , $this->user->id )->update(['profile_photo' => $profile_photo]);
        
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => 'Profile photo changed Successfully!']); 

   }


   
    public function passwordUpdate(){

        $this->validate([ 
            'new_password' => 'required|min:7',
            'confirmationPassword' => 'required|min:7|same:new_password'
        ]);  
                 
        $user = User::findorFail($this->user->id);
        $user->password = $this->new_password;
        $user->save();

        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => 'Password successfully updated.']); 
    
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

       /**
     * Write code on Method
     *
     * @return response()
     */
    public function destroyOwnerConfirm($storeOnwerId)
    {
        $this->deleteId  = $storeOnwerId;
        $this->dispatchBrowserEvent('swal:confirm', [
                'action' => 'ownerRemove',
                'type' => 'warning',  
                'confirmButtonText' => 'Yes, delete it!',
                'cancelButtonText' => 'No, cancel!',
                'message' => 'Are you sure?', 
                'text' => 'If deleted, You will be not able to adding this store with owner!'
            ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function ownerRemove()
    {
        StoreOwners::find($this->deleteId)->delete();
        $this->accounts = StoreOwners::where('user_id', $this->user->id)->get();
        
        $this->dispatchBrowserEvent('alert', 
            ['type' => 'success',  'message' => 'Remove Store Delete Successfully!']);

            return redirect(request()->header('Referer'));     
    } 



    public function updatedSearchCard()
   {   
    
        $this->searchResultCards = '';
        $this->is_card_available = false;
        $this->selected_card_id = '';

        $validator = $this->validate([ 
            'search_card' => 'required|numeric|digits:16|exists:App\Models\Bank\Card,card_number',
        ]);
        $this->searchResultCards = Card::select('cards.*','user_cards.card_id as joined_card_id','user_cards.id as joined_id')->leftjoin('user_cards', function ($query) {
            $query->on('user_cards.card_id','cards.id');              
        })->where('card_number', $this->search_card)->first(); 
       
        if($this->searchResultCards && empty($this->searchResultCards->joined_card_id)){
            $this->is_card_available = true;

            if(!empty($this->searchResultCards->card_holder_name)){
                $this->card_holder_name = $this->searchResultCards->card_holder_name;
            }           
        }else{
            $this->is_card_available = false;
        }
    }

    
    public function cardSubmit(){
       
        if(!$this->selected_card_id) {
            $this->dispatchBrowserEvent('alert', 
            ['type' => 'error',  'message' => 'Please select a Card!']);
            return false;
        }
        if(empty($this->card_holder_name)) {
            $this->dispatchBrowserEvent('alert', 
            ['type' => 'error',  'message' => 'Please enter a Card Holder Name!']);
            return false;
        }
 
        UserCard::create([
            'card_id' => $this->selected_card_id,
            'user_id' => $this->user->id ,
        ]);

        Card::where('id', $this->selected_card_id)->update(['card_holder_name' => $this->card_holder_name]);

        $this->dispatchBrowserEvent('alert', 
         ['type' => 'success',  'message' => 'Card Assigned Successfully!']);

       
        return redirect(request()->header('Referer'));
        
     }
    
     /**
     * update application status
     *
     * @return response()
     */
    public function suspendedConfirm($user)
    {  
        $account_status = ( $user['driver']['account_status'] == 'suspended' ) ? 'approved' : 'suspended';
        $status = ($user['driver']['account_status'] == 'suspended'  ) ? 0 : 1;
        $this->user->driver->update(['account_status' => $account_status, 'is_live' => 0]);      
        $this->user->account_status = $account_status ;
   }

    public function render()
    {
        return view('livewire.user-management.view');
    }

    
    public function hydrate()
    {
        $this->emit('select2');
    }

    public function getRoleIdForInput($value){ 
        $this->role_id = $value;
    }
}
