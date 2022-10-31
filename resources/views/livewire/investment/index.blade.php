<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h5 class="mb-0">Investment Types</h5>
                        </div>
                        <div class="col-6 text-end">
                            <a class="btn bg-gradient-dark mb-0 me-4" href="{{ route('add-investment-type') }}"><i
                                    class="material-icons text-sm">add</i>&nbsp;&nbsp;Add Investment Type</a>
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
                        <x-table.heading sortable wire:click="sortBy('name')"
                            :direction="$sortField === 'name' ? $sortDirection : null"> Name
                        </x-table.heading>                       
                        <x-table.heading sortable wire:click="sortBy('created_at')"
                            :direction="$sortField === 'created_at' ? $sortDirection : null">
                            Creation Date
                        </x-table.heading>
                        <x-table.heading>
                            status
                        </x-table.heading>
                        <x-table.heading>Actions</x-table.heading>
                    </x-slot>
                    <x-slot name="body">
                        @foreach ($investmentTypes as $investmentType)
                        <x-table.row wire:key="row-{{ $investmentType->id }}">
                            <x-table.cell>{{ $investmentType->id }}</x-table.cell>
                            <x-table.cell>{{ $investmentType->name }}</x-table.cell>                            
                            <x-table.cell>{{ $investmentType->created_at }}</x-table.cell>
                            <x-table.cell> 
                                <div class="form-check form-switch ms-3">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault35"  wire:change="statusUpdate({{ $investmentType->id }},{{ $investmentType->status }})"
                                        @if($investmentType->status) checked="" @endif>
                                </div>
                            </x-table.cell>
                            <x-table.cell>
                                
                                <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('edit-investment-type', $investmentType) }}"
                                    data-original-title="Edit" title="Edit">
                                    <i class="material-icons">edit</i>
                                    <div class="ripple-container"></div>
                                </a>
                               
                                <button type="button" class="btn btn-danger btn-link" data-original-title="Remove" title="Remove"
                                    wire:click="destroyConfirm({{ $investmentType->id }})">
                                    <i class="material-icons">delete</i>
                                    <div class="ripple-container"></div>
                                </button>
                                
                            </x-table.cell>
                        </x-table.row>
                        @endforeach
                    </x-slot>
                </x-table>
                <div id="datatable-bottom">
                    {{ $investmentTypes->links() }}
                </div>
                @if($investmentTypes->total() == 0)
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

