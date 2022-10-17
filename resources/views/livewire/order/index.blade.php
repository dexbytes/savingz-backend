<div class="container-fluid py-4">
<div class="d-sm-flex justify-content-between">
        <div>
            <!-- <a href="javascript:;" class="btn btn-icon bg-gradient-primary">
                New order
            </a> -->
        </div>
        <div class="d-flex">
            <div class="dropdown d-inline">
                <a href="javascript:;" class="btn btn-outline-dark dropdown-toggle " data-bs-toggle="dropdown"
                    id="navbarDropdownMenuLink2">
                    Filters
                </a>
                <ul class="dropdown-menu dropdown-menu-lg-start px-2 py-3" aria-labelledby="navbarDropdownMenuLink2"
                    data-popper-placement="left-start">
                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Status: Paid</a></li>
                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Status: Refunded</a></li>
                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Status: Canceled</a></li>
                    <li>
                        <hr class="horizontal dark my-2">
                    </li>
                    <li><a class="dropdown-item border-radius-md text-danger" href="javascript:;">Remove
                            Filter</a></li>
                </ul>
            </div>
            <button class="btn btn-icon btn-outline-dark ms-2 export" data-type="csv" type="button">
                <i class="material-icons text-xs position-relative">archive</i>
                Export CSV
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">                
                <!-- Card header -->               
                <div class="card-header pb-0">
                    <div class="d-lg-flex">                        
                        <div>
                            <h5 class="mb-0">All Orders</h5>                           
                        </div>
                    </div>
                </div>

                <div class="card-body px-0 pb-0">
                    <div class="d-flex flex-row justify-content-between mx-4">
                        <div class="d-flex mt-3 align-items-center justify-content-center">
                            <p class="text-secondary pt-2">Show&nbsp;&nbsp;</p>
                            <select wire:model="perPage" class="form-control mb-2" id="entries">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option selected value="50">50</option>
                                <option value="100">100</option>                               
                            </select>
                            <p class="text-secondary pt-2">&nbsp;&nbsp;entries</p>
                        </div>
                        <div class="mt-3 ">
                            <input wire:model="search" type="text" class="form-control border p-2" placeholder="Search...">
                        </div>
                    </div>

                    <x-table class="table table-flush">
                        <x-slot name="head">
                            <x-table.heading> Id
                            </x-table.heading>
                            <x-table.heading> Order Number
                            </x-table.heading>
                            <x-table.heading> Date
                            </x-table.heading>
                            <x-table.heading> Status
                            </x-table.heading>
                            <x-table.heading> Store
                            </x-table.heading>
                            <x-table.heading> Customer
                            </x-table.heading>                           
                            <x-table.heading> Amount
                            </x-table.heading>
                            <x-table.heading>Actions</x-table.heading>
                        
                        </x-slot>
                        
                        <x-slot name="body">
                            @foreach ($orders as $order)
                            <x-table.row wire:key="row-{{$order->id }}">
                                <x-table.cell>{{ $order->id }}</x-table.cell>
                                <x-table.cell>#{{ $order->order_number }}</x-table.cell>
                                <x-table.cell>{{ $order->created_at }}</x-table.cell>
                                <x-table.cell>{{ $order->order_status }}</x-table.cell>
                                <x-table.cell>{{ $order->store->name }}</x-table.cell>
                                <x-table.cell>{{ $order->user->name }}</x-table.cell>
                                <x-table.cell>{{ $order->total_amount }}</x-table.cell>
                                <x-table.cell>                                  
                                    <a href="javascript:;" data-bs-toggle="tooltip"
                                        data-bs-original-title="Preview">
                                        <i
                                            class="material-icons text-secondary position-relative text-lg">visibility</i>
                                    </a>
                                    <a href="javascript:;" class="mx-3" data-bs-toggle="tooltip"
                                        data-bs-original-title="Edit">
                                        <i
                                            class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                                    </a>
                                    <a href="javascript:;" data-bs-toggle="tooltip"
                                        data-bs-original-title="Delete"  wire:click="destroyConfirm({{ $order->id }})">
                                        <i class="material-icons text-secondary position-relative text-lg">delete</i>
                                    </a>                                                                    
                                </x-table.cell>
                            </x-table.row>
                            
                            @endforeach
                        </x-slot>
                    </x-table>

                    <div id="datatable-bottom">
                        {{ $orders->links() }}
                    </div>

                    @if( $orders->total() == 0)
                        <div>
                            <p class="text-center">No records found!</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
<!--   Core JS Files   -->
@push('js')
<script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
<script src="{{ asset('assets') }}/js/plugins/datatables.js"></script>
  
@endpush
