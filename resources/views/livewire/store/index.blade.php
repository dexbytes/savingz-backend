<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <div class="row">
                        <div class="col col-6">
                            <h5 class="mb-0">
                            @if($this->application_status == 'waiting')
                                Unverified Stores
                            @else
                                Stores
                            @endif
                            </h5>
                        </div>
                        <div class="col col-6 text-end"> 
                            <a class="btn bg-gradient-dark mb-0 me-4" href="{{ route('add-store') }}"><i
                                    class="material-icons text-sm">add</i>&nbsp;&nbsp;Add Store</a>
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
                        <x-table.heading> Logo
                        </x-table.heading>
                        <x-table.heading sortable wire:click="sortBy('name')"
                            :direction="$sortField === 'name' ? $sortDirection : null">Store Name
                        </x-table.heading>
                        <x-table.heading>Email
                        </x-table.heading>
                        <x-table.heading>Phone
                        </x-table.heading> 
                        <x-table.heading>Status
                        </x-table.heading>
                        <x-table.heading sortable wire:click="sortBy('created_at')"
                            :direction="$sortField === 'created_at' ? $sortDirection : null">
                            Creation Date
                        </x-table.heading>
                     
                        <x-table.heading>Actions</x-table.heading>
                    
                    </x-slot>

                    <x-slot name="body">
                        @foreach ($stores as $store)
                        <x-table.row wire:key="row-{{ $store->id }}">
                            <x-table.cell>{{ $store->id }}</x-table.cell>
                            <x-table.cell class="position-relative">
                                @if ($store->picture)
                                <img src="/storage/{{($store->picture)}} " alt="picture"
                                    class="avatar avatar-sm me-3">
                                @else
                                <img src="{{ asset('assets') }}/img/default-avatar.png" alt="avatar"
                                    class="avatar avatar-sm me-3">
                                @endif
                            </x-table.cell>
                            <x-table.cell>{{ $store->name }}</x-table.cell>
                            <x-table.cell>{{ $store->email }}</x-table.cell>
                            <x-table.cell>{{ $store->phone }}</x-table.cell>
                            <x-table.cell> 
                                <div class="form-check form-switch ms-3">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault35"  wire:change="statusUpdate({{ $store->id }},{{ $store->status}})"
                                        @if($store->status) checked="" @endif>
                                </div>
                            </x-table.cell>
                            <x-table.cell>{{ $store->created_at }}</x-table.cell>
                            <x-table.cell>
                              
                            @if($this->application_status == 'waiting')
                                <button type="button" class="btn btn-success btn-link" data-original-title="Approve" title="Approve"
                                wire:click="applicationConfirm({{ $store->id }}, 'approved')">
                                    <i class="material-icons">check</i>
                                    <div class="ripple-container"></div>
                                </button>
                                <button type="button" class="btn btn-danger btn-link" data-original-title="Reject" title="Reject"
                                wire:click="applicationConfirm({{ $store->id }}, 'rejected')">
                                    <i class="material-icons">close</i>
                                    <div class="ripple-container"></div>
                                </button>
                            @else

                                <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('edit-store', $store) }}"
                                    data-original-title="" title="">
                                    <i class="material-icons">edit</i>
                                    <div class="ripple-container"></div>
                                </a>
                                @if ($store->is_primary == 0)
                              
                                <button type="button" class="btn btn-danger btn-link" data-original-title="Remove" title="Remove"
                                    wire:click="destroyConfirm({{ $store->id }})">
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
                    {{ $stores->links() }}
                </div>
                @if($stores->total() == 0)
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
