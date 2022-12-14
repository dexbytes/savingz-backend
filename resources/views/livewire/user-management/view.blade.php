<div class="container-fluid my-3 py-3">
    
    <div class="row mb-5">
        {{-- @if(env('GOOGLE_MAP_KEY') == '')
            <div class="col-lg-10 col-10 mx-auto position-relative">
                <div class="row mb-5 text-center">
                    <div class="alert alert-warning" role="alert">
                        <strong>Warning! </strong>Get the coordinates of a stores, You will need to set your API Key. <a class="btn-link">Set Google API Key now</a>
                    </div>
                </div>
            </div>
        @endif --}}

        <div class="col-lg-3">
            <div class="card position-sticky top-1">
                <ul class="nav flex-column bg-white border-radius-lg p-3">
                    <li class="nav-item">
                        <a class="nav-link text-dark d-flex" data-scroll="" href="#profile">
                            <i class="material-icons text-lg me-2">person</i>
                            <span class="text-sm">Profile</span>
                        </a>
                    </li>
                    <li class="nav-item pt-2">
                        <a class="nav-link text-dark d-flex" data-scroll="" href="#basic-info">
                            <i class="material-icons text-lg me-2">receipt_long</i>
                            <span class="text-sm">Basic Info</span>
                        </a>
                    </li>

                    <li class="nav-item pt-2">
                        <a class="nav-link text-dark d-flex" data-scroll="" href="#change-password">
                            <i class="material-icons text-lg me-2">lock_reset</i>
                            <span class="text-sm">Change Password</span>
                        </a>
                    </li>
                  
                    @if($this->user->hasRole('Customer'))
                        <li class="nav-item pt-2">
                            <a class="nav-link text-dark d-flex" data-scroll="" href="#cards">
                                <i class="material-icons text-lg me-2">add_card</i>
                                <span class="text-sm">Cards</span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item pt-2">
                        <a class="nav-link text-dark d-flex" data-scroll="" href="#other-info">
                            <i class="material-icons text-lg me-2">info</i>
                            <span class="text-sm">Other Info</span>
                        </a>
                    </li>

                    <li class="nav-item pt-2">
                        <a class="nav-link text-dark d-flex" data-scroll="" href="#device-info">
                            <i class="material-icons text-lg me-2">smartphone</i>
                            <span class="text-sm">Device Info</span>
                        </a>
                    </li>
                     
                </ul>
            </div>
        </div>

        <div class="col-lg-9 mt-lg-0 mt-4">

            <!-- Card Profile -->
            <div class="card card-body" id="profile">
                <div class="row justify-content-center align-items-center">
                   
                    <div class="col-sm-auto col-4">                          
                        <div class="avatar avatar-xl position-relative preview">
                            @if($profile_photo)                               
                            <img src="{{$profile_photo->temporaryUrl() }}" class="w-100 h-100 rounded-circle shadow-sm"
                                alt="Profile Photo">
                            @elseif ($user->profile_photo)                                
                            <img src="{{ Storage::disk(config('app_settings.filesystem_disk.value'))->url($user->profile_photo)}}" alt="avatar"
                                class="w-100  h-100 rounded-circle shadow-sm">
                            @else
                            <img src="{{ asset('assets') }}/img/default-avatar.png" alt="avatar"
                                class="w-100  h-100 rounded-circle shadow-sm">
                            @endif
                            <label for="file-input"
                                class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 end-0 mb-n2 me-n2">
                                <i class="fa fa-pen top-0" data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                    aria-hidden="true" data-bs-original-title="Edit Image"
                                    aria-label="Edit Image"></i><span class="sr-only">Edit Image</span>
                            </label>
                            <input wire:model='profile_photo' type="file" id="file-input">
                            @error('profile_photo')                            
                                <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-auto col-8 my-auto">
                        <div class="h-100">
                            <h5 class="mb-1 font-weight-bolder">
                             {{ $user->name }} ({{ $user->getRoleNames()->implode(',') }})
                            </h5>
                            <p class="mb-0 font-weight-normal text-sm">
                               @if($user->phone) + {{ $user->country_code }} {{ $user->phone }} @endif
                            </p>
                        </div>
                    </div>

                    <div class="col-sm-auto ms-sm-auto mt-sm-0 mt-3 d-flex">
                        <label class="form-check-label mb-0">
                            <small id="profileVisibility">
                                Active
                            </small>
                        </label>
                        <div class="form-check form-switch ms-2 my-auto">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault35"  wire:change="statusUpdate({{ $user->id }},{{ $user->status}})"
                                @if($user->status) checked="" @endif>
                        </div>
                    </div>

                </div>
            </div>

        @if (session('status'))
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-success alert-dismissible text-white mt-3" role="alert">
                        <span class="text-sm">{{ Session::get('status') }}</span>
                        <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif
      
        @if (session('status'))
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-success alert-dismissible text-white mt-3" role="alert">
                    <span class="text-sm">{{ Session::get('status') }}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
        <!-- Card Basic Info -->
    <form wire:submit.prevent="update">

        <div class="card mt-4" id="basic-info">
            <div class="card-header">
                <h5>Basic Info</h5>
            </div>
            <div class="card-body pt-0">               
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="input-group input-group-static">
                                <label>Full Name *</label>
                                <input wire:model.lazy="user.name" type="text" class="form-control" placeholder="Enter a full Name">
                            </div>
                            @error('user.name')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>                      
 
                        <div class="col-4  mb-4">
                            <div class="input-group input-group-static">
                                <label>Country Code *</label>
                                <select class="form-control input-group input-group-dynamic" wire:model.lazy="user.country_code" id="countryCode" onfocus="focused(this)" onfocusout="defocused(this)">
                                    <option value = '' selected>Select</option>
                                        @foreach ($countries  as $countryValue)
                                            <option value="{{ $countryValue['country_code'] }}">{{ $countryValue['country_code']}}</option>
                                        @endforeach
                                    </select>
                            </div>
                            @error('user.country_code')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>
                                
                        <div class="col-4  mb-4">
                            <div class="input-group input-group-static">
                                <label>Phone Number *</label>
                                <input wire:model.lazy="user.phone" type="text" class="form-control" placeholder="Enter a Phone Number">
                            </div>
                            @error('user.phone')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div> 

                        <div class="col-4  mb-4">
                            <div class="input-group input-group-static">
                                <label>Email *</label>
                                <input wire:model.lazy="user.email" type="text" class="form-control" placeholder="Enter a email">
                            </div>
                            @error('user.email')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div> 
                        
                        <div class="col-6 mb-4">
                                <div class="input-group input-group-static">
                                    <label>PAN Number </label>
                                    <input wire:model.lazy="user.pan_card_number" type="text" class="form-control" placeholder="Enter a PAN Number">
                                </div>
                                @error('user.pan_card_number')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-6 mb-4">
                                <div class="input-group input-group-static">
                                    <label>Aadhar Number </label>
                                    <input wire:model.lazy="user.aadhar_card_number" type="text" class="form-control" placeholder="Enter a Aadhar Number">
                                </div>
                                @error('user.aadhar_card_number')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>
                        
                        @if (($user->id != auth()->id() || $user->id  != 1))
                        <div class="col-12 mb-4">
                            <div class="input-group input-group-static">
                                <label>Select Role *</label>
                                <select multiple="multiple"  class="form-control" wire:model="role_id"
                                        data-style="select-with-transition" title="Role" data-size="100"  id="role_id">
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">                                        
                                            {{ $role->name }}</option>
                                        @endforeach
                                    </select>
                            </div>
                            @error('role_id')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>  
                        @endif
                    </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" name="submit" class="btn bg-gradient-dark m-0 ms-2">Update
                                </button>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </form>

       <!-- change-password -->
       <form wire:submit.prevent="passwordUpdate">      
            <div class="card mt-4" id="change-password">
                <div class="card-header">
                    <h5>Change Password</h5>
                </div>
                <div class="card-body pt-0">  
                    <div class="row">
                        <div class="col-md-12">            
                            @csrf
                            <div class="input-group input-group-static ">
                                <input wire:model.lazy='new_password' type="password" class="form-control"
                                    placeholder="New Password">
                            </div>
                            @error('new_password')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                            <div class="input-group input-group-static mt-4">
                                <input wire:model="confirmationPassword" type="password" class="form-control"
                                    placeholder="Confirm New Password">
                            </div>
                            @error('confirmationPassword')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" name="submit" class="btn bg-gradient-dark m-0 ms-2">Update
                                    </button>
                            </div>
                        </div>      
                    </div>
                </div>           
            </div> 
           
        </form>   

        <!-- Card Info -->
        @if($this->user->hasRole('Customer'))
            <div class="card mt-4" id="cards">
                <div class="card-header">
                   <div class="row">
                        <div class="col col-6">
                            <h5>Cards</h5>
                        </div>
                        <div class="col col-6 text-end">
                            <button type="button" class="btn bg-gradient-dark mb-0 me-4" data-bs-toggle="modal" data-bs-target="#addModalCard">
                                Assign a Card
                            </button>                    
                        </div>
                   </div>  
                </div>
               
                <div class="pt-0">
                    <x-table>
                        <x-slot name="head">
                            <x-table.heading > ID
                        </x-table.heading>
                        <x-table.heading>Card Number
                        </x-table.heading>
                        <x-table.heading>Holder Name
                        </x-table.heading>
                        <x-table.heading>Expiry On
                        </x-table.heading>
                        <x-table.heading>Status
                        </x-table.heading>                     
                        <x-table.heading> Creation Date
                        </x-table.heading>                        
                       <x-table.heading>Actions</x-table.heading>
                        </x-slot>
                        <x-slot name="body">
                            @foreach ($card as $key => $value)
                            <x-table.row>
                                <x-table.cell>{{$value->id }}</x-table.cell>
                                <x-table.cell >
                                {{$value->card_number}}
                                </x-table.cell>
                                <x-table.cell >
                                {{$value->card_holder_name}}
                                </x-table.cell>
                                <x-table.cell> 
                                    {{$value->expiration_month}} @if(!empty($value->expiration_year)) / @endif {{$value->expiration_year}}
                                </x-table.cell>
                                <x-table.cell> 
                                    {{$value->status == 1 ? 'Active' : 'Inactive'}}
                                </x-table.cell>  
                                <x-table.cell> 
                                    {{$value->created_at->format(config('app_settings.date_format.value'))}}
                                </x-table.cell> 
                                <x-table.cell>                                 
                                    <div class="dropdown dropup dropleft">
                                         <button class="btn bg-gradient-default" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                             <span class="material-icons">
                                                 more_vert
                                             </span>
                                         </button>
                                         <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                 <li><a class="dropdown-item"  data-original-title="Edit" title="Edit" href="{{ route('edit-card', $value) }}">Edit</a></li>
                                            <li><a class="dropdown-item text-danger"  data-original-title="Remove" title="Remove" wire:click="destroyConfirm({{ $value->id }})">Delete</a></li>
                                         </ul>
                                     </div>                           
                                 </x-table.cell>                               
                            </x-table.row>
                            @endforeach
                        </x-slot>
                    </x-table>   
                    @if($card->count() == 0)
                    <div>
                        <p class="text-center">No card assigned by customer!</p>
                    </div> 
                @endif                 
                </div>
            </div>   
        @endif   
 
        <!-- Card Store -->
        @if ($this->user->hasRole('Provider'))
        <div class="card mt-4" id="stores">
            <div class="card-header">
                <h5>Stores</h5>
            </div>
            <div class="card-body pt-0">
                <x-table>
                    <x-slot name="head">
                        <x-table.heading> ID
                        </x-table.heading>
                        <x-table.heading> Name
                        </x-table.heading> 
                        <x-table.heading> Phone Number
                        </x-table.heading>                                            
                        <x-table.heading>
                            Creation Date
                        </x-table.heading>                        
                        <x-table.heading>Actions</x-table.heading>
                    </x-slot>

                    <x-slot name="body">
                        @foreach ($stores as $store)                     
                        <x-table.row wire:key="row-{{ $store->id }}">
                            <x-table.cell><a href="{{ route('edit-store' , $store->store) }}">{{ $store->store->id}}</a></x-table.cell>
                            <x-table.cell><a href="{{ route('edit-store' , $store->store) }}">{{ $store->store->name }}</a></x-table.cell>     
                            <x-table.cell>{{ $store->store->phone }}</x-table.cell>
                            <x-table.cell>{{ $store->created_at }}</x-table.cell>
                            <x-table.cell>
                                <a  href="javascript:void(0)"  wire:click="destroyOwnerConfirm({{ $store->id }})">
                                    <span class="material-symbols-outlined" >
                                        delete
                                    </span>
                                </a>
                            </x-table.cell>
                        </x-table.row>
                        @endforeach
                    </x-slot>
                </x-table>
                @if(empty($stores))
                    <div>
                        <p class="text-center">No stores assign to user!</p>
                    </div> 
                @endif
            </div>
        </div>  
       @endif


    @if($this->user->hasRole('Driver'))
        <!-- commission info Time -->
        <div class="card mt-4" id="commission-info">
            <div class="card-header">
                <h5>Commission Settings</h5>
            </div>
            <div class="card-body pt-0">                
                <div class="row">

                    <div class="col-12  mb-4">
                    
                        <div class="form-check">
                            <input wire:model.lazy="is_global_commission" class="form-check-input" type="checkbox"  id="is_global_commission">
                            <label class="form-check-label" for="is_global_commission">
                                Enable Global Commission
                            </label>
                        </div>
                    </div>

                    @if(!$is_global_commission &&  $user->driver)
                        <div class="col-12 mb-4">
                            <div class="input-group input-group-static">
                                <label>Commission (In {{$user->driver->driver_commission_type}}) *</label>
                                <input wire:model.lazy="driver_commission_value" type="text" class="form-control" placeholder="Enter Amount">
                            </div>
                            @error('driver_commission_value')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>
                    @endif    
                
                </div>
            </div>
        </div> 
    @endif
    
        <!-- Card Other Info -->
        <div class="card mt-4" id="other-info">
            <div class="card-header">
                <h5>Other Info</h5>
            </div>
            <div class="card-body pt-0">
                <x-table>                    
                    <x-slot name="head">
                        <x-table.heading>SNo
                        </x-table.heading>
                        <x-table.heading>Name
                        </x-table.heading>
                       <x-table.heading>Value
                        </x-table.heading>  
                    </x-slot>
                    <x-slot name="body">
                        @foreach ($userMeta as $meta => $value)
                        <x-table.row>                            
                            <x-table.cell>{{$loop->iteration }}</x-table.cell>
                            <x-table.cell >
                               {{ ucfirst(str_replace('_' , ' ' , $value->key)) }}
                            </x-table.cell>
                            <x-table.cell> 
                                @php $allowed = array('jpg','png','gif', 'pdf', 'jpeg');
                                 $ext = pathinfo($value->value, PATHINFO_EXTENSION); 
                                @endphp
                                @if(in_array( $ext, $allowed ) )
                                    <img  src="{{ Storage::disk(config('app_settings.filesystem_disk.value'))->url($value->value)}}" alt="picture"
                                class="avatar avatar-sm me-3"> 
                                @else
                                    @if(strcmp($value->key, "date_of_birth") !==0)
                                        {{ ucfirst(str_replace('_' , ' ' , $value->value)) }}
                                    @else
                                        {{ \Carbon\Carbon::parse($value->value)->format(config('app_settings.date_format.value')) }}
                                    @endif
                                @endif                              
                            </x-table.cell>
                         </x-table.row>
                        @endforeach
                    </x-slot>
                </x-table>  
               
                @if($userMeta->count() == 0)
                    <div>
                        <p class="text-center">No records found!</p>
                    </div> 
                @endif              
            </div>
        </div>                           
            
        <!-- Card Other Info -->
        <div class="card mt-4" id="device-info">
            <div class="card-header">
                <h5>Device Info</h5>
            </div>
            <div class="card-body pt-0">
                <x-table>                    
                    <x-slot name="head">
                        <x-table.heading>S No
                        </x-table.heading>
                        <x-table.heading>Device Info
                        </x-table.heading>
                        <x-table.heading>App Info
                        </x-table.heading>
                        <x-table.heading>Date
                        </x-table.heading>  
                    </x-slot>
                    <x-slot name="body">                        
                        @foreach($user->device as $dkey => $device)
                        <x-table.row>                            
                            <x-table.cell>{{$loop->iteration }}</x-table.cell>
                            <x-table.cell >
                                {{ ucfirst($device->device_type) }}({{$device->device_version}}), {{ ucfirst($device->device_name) }} @if($device->device_model) ({{$device->device_model}}) @endif
                            </x-table.cell>
                            <x-table.cell>
                                {{ucfirst($device->app_name .' App' )}} @if($device->app_version) ({{$device->app_version}}) @endif        
                            </x-table.cell>
                            <x-table.cell>
                                {{$device->updated_at->format(config('app_settings.date_format.value')) }}       
                            </x-table.cell>
                            
                        </x-table.row>
                        @endforeach
                    </x-slot>
                </x-table>  
            
                @if($user->device->count() == 0)
                    <div>
                        <p class="text-center">No records found!</p>
                    </div> 
                @endif              
            </div>
        </div>

        @if($this->user->hasRole('Driver') && $user->driver)
            <!-- CardAccount -->
            <div class="card mt-4" id="suspend">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-sm-0 mb-4">
                        <div class="w-50">
                            <h5>Account Suspended</h5>
                            <p class="text-sm mb-0">Once you suspended this account, It means that the store has remove temporarily.</p>
                        </div>
                        <div class="w-50 text-end">
                            <button class="btn bg-gradient-{{ $user->driver->account_status == 'suspended' ? 'success' : 'warning' }} mb-0 ms-2" type="button" name="button" wire:click="suspendedConfirm({{ $user }})">{{ $user->driver->account_status == 'suspended' ? 'Re-Active Account' : 'Account suspended' }}</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
       
        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="addModalCard" tabindex="-1" role="dialog" aria-labelledby="exampleModalSignTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-m" role="document">
                <div  class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-left">
                                <h5 class="">Add Card</h5>
                                <p class="mb-0">Find a Card are not associated with user.</p>
                            </div>
                            <div class="card-body pb-3">    
                                
                                <div class="col-12 mb-4">
                                    <div class="input-group input-group-static">
                                        <label>Search Card *</label>
                                        <input wire:model.lazy="search_card" type="text" class="form-control"  placeholder="Search by 16 digit Card Number eg. 4242424242424242">
                                    </div>
                                    @error('search_card')
                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                </div>                                
                           
                                    @if($search_card!= '')
                                        @if(!empty($searchResultCards))
                                            @if ($is_card_available)   
                                                <div class="col-12 mt-4">                                        
                                                    <ul class="list-group list-group-flush list my--3">
                                                        <li style="cursor: pointer;" class="list-group-item px-0 border-0" wire:click="selectCard({{$searchResultCards->id}})">
                                                            <div class="row align-items-center">
                                                            <div class="col-auto">
                                                                @if($selected_card_id)
                                                                    <span class="material-symbols-outlined text-success">
                                                                        check_circle
                                                                    </span>
                                                                @else
                                                                    <span class="material-symbols-outlined">
                                                                        radio_button_unchecked
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div class="col">
                                                                    <p class="text-xs font-weight-bold mb-0">Card:</p>
                                                                    <h6 class="text-sm font-weight-normal mb-0">{{$searchResultCards->card_number}}</h6>
                                                                </div>
                                                                <div class="col text-center">
                                                                    <p class="text-xs font-weight-bold mb-0">Expiry:</p>
                                                                    <h6 class="text-sm font-weight-normal mb-0">
                                                                        @if(!$searchResultCards->expiration_year && !$searchResultCards->expiration_month) 
                                                                            -
                                                                        @endif
                                                                        {{$searchResultCards->expiration_month}} @if($searchResultCards->expiration_year)/@endif {{$searchResultCards->expiration_year}}
                                                                    </h6>
                                                                </div>
                                                                <div class="col text-center">
                                                                    <p class="text-xs font-weight-bold mb-0">Status:</p>
                                                                    <h6 class="text-sm font-weight-normal mb-0">{{$searchResultCards->status == 1 ? 'Active' : 'Inactive'}}</h6>
                                                                </div>
                                                            </div>
                                                            <hr class="horizontal dark mt-3 mb-1">
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="col-12 mt-4">
                                                    <div class="input-group input-group-static">
                                                        <label>Card Holder Name</label>
                                                        <input wire:model.lazy="card_holder_name" type="text" class="form-control" placeholder="Enter a Card Holder Name">
                                                    </div>
                                                    @error('card_holder_name')
                                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                                    @enderror
                                                </div>
                                            @else
                                                <p class="text-sm text-center">
                                                    Card already assigned!
                                                </p>                                        
                                            @endif
                                        @endif
                                    @endif 

                                </div>            
                              
                                <div class="modal-footer mt-6">
                                    <button type="button" wire:click.prevent="cancel()" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn bg-gradient-dark submit" @if(!$selected_card_id) disabled @endif id="submitCard" wire:click="$emit('cardSubmit')">Assign</button>
                                 </div>
                          </div>           
                        
                    </div>
                </div>
            </div>
        </div>
  </div>
</div>
@push('js')
<script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
<script src="{{ asset('assets') }}/js/plugins/quill.min.js"></script>
<script>   
    $(document).ready(function() { 

        window.initSelectRole=()=>{  
            $('#role_id').select2({
                placeholder: 'Select a Role',
                allowClear: true
            });
        }        
        initSelectRole();

        $('#role_id').on('change', function (e) {  
            var selected_element = $(e.currentTarget);
            var select_val = selected_element.val();   console.log(select_val);
            window.livewire.emit('getRoleIdForInput', select_val);
        });

        window.livewire.on('select2',()=>{  
            initSelectRole();
        });

    });
</script>
 
@endpush
