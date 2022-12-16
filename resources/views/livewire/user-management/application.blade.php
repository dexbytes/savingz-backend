<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <div class="row">
                        <div class="col col-6">
                            <h5 class="mb-0">
                                Unverified Customers
                            </h5>
                        </div>
               
                    </div>
                </div>
 
                <div class="d-flex flex-row justify-content-between mx-4">
                    <div class="d-flex mt-3">
                        <p class="text-secondary pt-2">Show&nbsp;&nbsp;</p>
                        <select wire:model="perPage" class="form-control mb-2" id="entries">
                            <option value="10">10</option>
                            <option selected value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <p class="text-secondary pt-2">&nbsp;&nbsp;entries</p>
                    </div>
                   
                    <div class="mt-3 ">
                        <input wire:model="search" type="text" class="form-control" placeholder="Search...">
                    </div>
                </div>
                <x-table>

                    <x-slot name="head">
                        <x-table.heading sortable wire:click="sortBy('id')"
                            :direction="$sortField === 'id' ? $sortDirection : null"> ID
                        </x-table.heading>
                        <x-table.heading>Photo
                        </x-table.heading>
                        <x-table.heading sortable wire:click="sortBy('name')"
                            :direction="$sortField === 'name' ? $sortDirection : null"> Name
                        </x-table.heading>
                        <x-table.heading>PAN Number
                        </x-table.heading>
                        <x-table.heading>Phone
                        </x-table.heading>
                        <x-table.heading>Status
                        </x-table.heading>
                        <x-table.heading>Role
                        </x-table.heading>
                        <x-table.heading sortable wire:click="sortBy('created_at')"
                            :direction="$sortField === 'created_at' ? $sortDirection : null">
                            Creation Date
                        </x-table.heading>
                         <x-table.heading>Actions</x-table.heading>
                    
                    </x-slot>

                    <x-slot name="body">
                        @foreach ($users as $user)
                        <x-table.row wire:key="row-{{ $user->id }}">
                            <x-table.cell>{{ $user->id }}</x-table.cell>
                            <x-table.cell class="position-relative">
                                @if ($user->profile_photo)
                                <img src="{{ Storage::disk(config('app_settings.filesystem_disk.value'))->url($user->profile_photo)}}" alt="picture"
                                    class="avatar avatar-sm me-3">
                                @else
                                <img src="{{ asset('assets') }}/img/default-avatar.png" alt="avatar"
                                    class="avatar avatar-sm me-3">
                                @endif
                            </x-table.cell>
                            <x-table.cell><a href="{{ route('view-user', $user) }}">{{ $user->name }}</a></x-table.cell>   
                            <x-table.cell>{{ $user->pan_card_number }}</x-table.cell>                          
                            <x-table.cell> @if($user->phone) +{{$user->country_code}} {{ substr($user->phone , +(strlen($user->country_code)))  }} @endif</x-table.cell>
                            <x-table.cell>{{ $user->account_status }}</x-table.cell>
                            <x-table.cell>{{ $user->getRoleNames()->implode(',') }}</x-table.cell>
                            <x-table.cell>{{ $user->created_at->format(config('app_settings.date_format.value')) }}</x-table.cell>
                            <x-table.cell>                             
                                @if($user->account_status == 'pending')
                                    <button type="button" class="btn btn-success btn-link" data-original-title="Approve" title="Approve" 
                                    wire:click="applicationConfirm({{ $user->id }}, 'accepted')">
                                        <i class="material-icons">check</i>
                                        <div class="ripple-container"></div>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-link" data-original-title="Reject" title="Reject"
                                    wire:click="applicationConfirm({{ $user->id }}, 'rejected')">
                                        <i class="material-icons">close</i>
                                        <div class="ripple-container"></div>
                                    </button>                            
                                @endif    
                            </x-table.cell>
                        </x-table.row>
                        @endforeach
                    </x-slot>
                </x-table>
                <div id="datatable-bottom">
                    {{ $users->links() }}
                </div>
                
                    @if($users->total() == 0)
                        <div>
                            <p class="text-center">No records found!</p>
                        </div>
                    @endif
            </div>
        </div>
    </div>
</div>
@push('js')
<script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
@endpush
