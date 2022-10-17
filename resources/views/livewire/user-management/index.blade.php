<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <div class="row">
                        <div class="col col-6">
                            <h5 class="mb-0">
                            @if($this->account_status == 'waiting')
                                Unverified {{Str::ucfirst($this->filter['role'] == '' ? 'All User' :  $this->filter['role']) }}s 
                            @else
                                {{Str::ucfirst($this->filter['role'] == '' ? 'All User' :  $this->filter['role']) }}s
                            @endif
                            </h5>
                        </div>
                        <div class="col col-6 text-end">
                            <a class="btn bg-gradient-dark mb-0 me-4" href="{{ route('add-user') }}"><i
                                    class="material-icons text-sm">add</i>&nbsp;&nbsp;Add User</a>
                        </div>
                    </div>
                </div>
                @if (Session::has('status'))
                <div class="alert alert-success alert-dismissible text-white mx-4" role="alert">
                    <span class="text-sm">{{ Session::get('status') }}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @elseif (Session::has('error'))
                <div class="alert alert-danger alert-dismissible text-white mx-4" role="alert">
                    <span class="text-sm">{{ Session::get('error') }}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
               
               
                <div class="d-flex flex-row justify-content-between mx-4">
                    <div class="d-flex mt-3 align-items-center justify-content-center">
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
                        <x-table.heading> Photo
                        </x-table.heading>
                        <x-table.heading sortable wire:click="sortBy('name')"
                            :direction="$sortField === 'name' ? $sortDirection : null"> Name
                        </x-table.heading>
                        <!-- <x-table.heading>Email
                        </x-table.heading> -->
                        <x-table.heading>Phone
                        </x-table.heading>
                        <x-table.heading>Status
                        </x-table.heading>
                        @if(!empty(Route::current()->parameter('role')) && Route::current()->parameter('role') == 'driver')
                            <x-table.heading>Status
                            </x-table.heading>
                        @endif
                        @if(empty($this->filter['role']))
                            <x-table.heading>Role
                            </x-table.heading>
                        @endif
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
                                @if ($user->picture)
                                <img src="/storage/{{($user->picture)}} " alt="picture"
                                    class="avatar avatar-sm me-3">
                                @else
                                <img src="{{ asset('assets') }}/img/default-avatar.png" alt="avatar"
                                    class="avatar avatar-sm me-3">
                                @endif
                            </x-table.cell>
                            <x-table.cell>{{ $user->name }}</x-table.cell>
                            <!-- <x-table.cell>{{ $user->email }}</x-table.cell> -->
                            <x-table.cell>{{ $user->phone }}</x-table.cell>
                            <x-table.cell> 
                            @if ($user->id != auth()->id() || $user->id  != 1)
                                <div class="form-check form-switch ms-3">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault35"  wire:change="statusUpdate({{ $user->id }},{{ $user->status}})"
                                        @if($user->status) checked="" @endif>
                                </div>
                            @endif
                            </x-table.cell>
                            @if(!empty($this->filter['role']) && $this->filter['role'] == 'driver')
                            <x-table.cell>
                                <span class="badge badge-dot me-4">
                                   @if($user->driver && $user->driver->is_live)
                                    <i class="bg-success"></i>
                                    <span class="text-dark text-xs">Online</span>
                                    @else
                                    <i class="bg-danger"></i>
                                    <span class="text-dark text-xs">Offline</span>
                                    @endif
                                </span>
                            </x-table.cell>
                            @endif

                            @if(empty($this->filter['role']))
                                <x-table.cell>{{ $user->getRoleNames()->implode(',') }}
                                </x-table.cell>
                            @endif
                            <x-table.cell>{{ $user->created_at }}</x-table.cell>
                            <x-table.cell>                              
                            
                            @if($this->account_status == 'waiting')
                                <button type="button" class="btn btn-success btn-link" data-original-title="Approve" title="Approve" 
                                wire:click="applicationConfirm({{ $user->id }}, 'approved')">
                                    <i class="material-icons">check</i>
                                    <div class="ripple-container"></div>
                                </button>
                                <button type="button" class="btn btn-danger btn-link" data-original-title="Reject" title="Reject"
                                wire:click="applicationConfirm({{ $user->id }}, 'rejected')">
                                    <i class="material-icons">close</i>
                                    <div class="ripple-container"></div>
                                </button>
                            @else
                                <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('edit-user', $user) }}"
                                    data-original-title="Edit" title="Edit">
                                    <i class="material-icons">edit</i>
                                    <div class="ripple-container"></div>
                                </a>
                                @if ($user->id != auth()->id() || $user->id  != 1)
                              
                                <button type="button" class="btn btn-danger btn-link" data-original-title="Remove" title="Remove"
                                     wire:click="destroyConfirm({{ $user->id }})">
                                    <i class="material-icons">delete</i>
                                    <div class="ripple-container"></div>
                                </button>
                                @endif
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
