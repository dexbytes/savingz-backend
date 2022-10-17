<div class="container-fluid py-4 bg-gray-200">
    <div class="row">
        <div class="col-12">
            <div class="card">                
                <!-- Card header -->               
                <div class="card-header pb-0">
                    <div class="d-lg-flex">                        
                        <div>
                            <h5 class="mb-0">All Products</h5>                           
                        </div>
                        <div>
                            @if ($destroyMultiple)
                            <a class="btn btn-link fst-normal lh-1 pe-3 mb-0 ms-auto w-25 w-md-auto me-12" wire:click="destroyMultiple()">
                                Delete selected products
                            </a>
                            @endif
                        </div>
                        <div class="ms-auto my-auto mt-lg-0 mt-4">
                            <div class="ms-auto my-auto">                                
                                <a href="" class="btn bg-gradient-primary btn-sm mb-0"
                                    target="_blank">+&nbsp; New Product</a>
                                    
                                {{-- <button type="button" class="btn btn-outline-primary btn-sm mb-0" data-bs-toggle="modal"
                                    data-bs-target="#import">
                                    Import
                                </button>
                                <div class="modal fade" id="import" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog mt-lg-10">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ModalLabel">Import CSV</h5>
                                                <i class="material-icons ms-3">file_upload</i>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>You can browse your computer for a file.</p>
                                                <div class="input-group input-group-dynamic mb-3">
                                                    <label class="form-label">Browse file...</label>
                                                    <input type="email" class="form-control" onfocus="focused(this)"
                                                        onfocusout="defocused(this)">
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="importCheck" checked="">
                                                    <label class="custom-control-label" for="importCheck">I
                                                        accept the terms and conditions</label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn bg-gradient-secondary btn-sm"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="button"
                                                    class="btn bg-gradient-primary btn-sm">Upload</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-outline-primary btn-sm export mb-0 mt-sm-0 mt-1" data-type="csv"
                                    type="button" name="button">Export</button> --}}
                            </div>
                            
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

                    <x-table>
                        <x-slot name="head">
                            <x-table.heading>
                            </x-table.heading>
                            <x-table.heading sortable wire:click="sortBy('id')"
                                :direction="$sortField === 'id' ? $sortDirection : null"> ID
                            </x-table.heading>
                            <x-table.heading sortable wire:click="sortBy('name')"
                            :direction="$sortField === 'product' ? $sortDirection : null"> Product
                            </x-table.heading>
                            <x-table.heading> Category
                            </x-table.heading>
                            <x-table.heading sortable wire:click="sortBy('price')"
                            :direction="$sortField === 'price' ? $sortDirection : null">Price
                            </x-table.heading>                           
                            <x-table.heading>Status
                            </x-table.heading>
                            <x-table.heading>Actions</x-table.heading>
                        
                        </x-slot>
                        
                        <x-slot name="body">
                            @foreach ($products as $product)
                            <x-table.row wire:key="row-{{$product->id }}">
                                <x-table.cell><div class="d-flex">
                                 <div class="form-check my-auto">
                                     <input class="form-check-input" type="checkbox" id="customCheck1" value="{{ $product->id }}" wire:model="destroyMultiple">
                                 </div></x-table.cell>
                                <x-table.cell>{{ $product->id }}</x-table.cell>
                                <x-table.cell>                                     
                                    <div class="d-flex">                                       
                                        @if ($product->picture)
                                        <img src="/storage/{{($user->picture)}} " alt="picture"
                                            class="w-10 ms-3 rounded-circle shadow-sm">
                                        @else
                                        <img src="{{ asset('assets') }}/img/default-food-avatar.jpg" alt="avatar"
                                            class="w-10 ms-3 rounded-circle">
                                        @endif
                                        <h6 class="ms-3 my-auto">{{ $product->name }}
                                        @if(auth()->user()->hasRole('Admin'))
                                            <br>
                                            <span class="text-xs text-secondary mb-0">
                                                    {{ $product->store->name }}
                                            </span>
                                        @endif
                                        </h6>
                                      
                                    </div>                                         
                                </x-table.cell>
                                <x-table.cell> {{ $product->productCategories->name}}</x-table.cell>
                                <x-table.cell> {{ $currency}} {{ $product->price }}</x-table.cell>
                                <x-table.cell>
                                    <div class="form-check form-switch ms-3">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault35"  wire:change="statusUpdate({{ $product->id }},{{ $product->status}})"
                                            @if($product->status) checked="" @endif>
                                    </div>
                                </x-table.cell>
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
                                            data-bs-original-title="Delete"  wire:click="destroyConfirm({{ $product->id }})">
                                            <i class="material-icons text-secondary position-relative text-lg">delete</i>
                                        </a>
                                                                      
                                </x-table.cell>
                            </x-table.row>
                            @endforeach
                        </x-slot>
                    </x-table>

                    <div id="datatable-bottom">
                        {{ $products->links() }}
                    </div>

                    @if( $products->total() == 0)
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
