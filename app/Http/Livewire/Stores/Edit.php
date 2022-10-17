<?php

namespace App\Http\Livewire\Stores;

use App\Models\Stores\Store;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public Store $store;

    public $picture;
    public $roles;
    public $password='';
    public $confirmPassword='';

    protected function rules(){
        return [
            'store.email' => 'required|email|unique:users,email,'.$this->store->id,
            'store.name' =>'required|',
        ];
    }

    public function mount($id) {

        $this->store = Store::find($id);
    }

    public function update(){
        
        $this->validate();

        if ($this->picture){
            $this->validate([
                'picture' => 'mimes:jpg,jpeg,png,bmp,tiff |max:4096',
            ]);
            $currentAvatar = $this->user->picture;

            if($currentAvatar !== 'profile/avatar.jpg' && $currentAvatar !== 'profile/avatar2.jpg' && $currentAvatar !== 'profile/avatar3.jpg' && !empty($currentAvatar)){

                unlink(storage_path('app/public/'.$currentAvatar));
                $this->store->update([
                    'picture' => $this->picture->store('profile', 'public')
                ]);
            }
            else{
                $this->store->update([
                    'picture' => $this->picture->store('profile', 'public')
                ]);
            }
        }

        
        $this->store->save();

        return redirect(route('store-management'))->with('status', 'Store successfully updated.');
    }

    public function render()
    {
       // $this->authorize('manage-users', User::class);
        
        return view('livewire.store.edit');
    }
}
