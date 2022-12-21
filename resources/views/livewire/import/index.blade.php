<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h5 class="mb-0">Import Files</h5>
                        </div>
                        <div class="col-6 text-end">
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
                        <x-table.heading>Name
                        </x-table.heading> 
                        <x-table.heading>Type
                        </x-table.heading>                       
                        <x-table.heading>Status
                        </x-table.heading> 
                        <x-table.heading>Records
                        </x-table.heading>                      
                        <x-table.heading sortable wire:click="sortBy('created_at')"
                            :direction="$sortField === 'created_at' ? $sortDirection : null">
                            Creation Date
                        </x-table.heading>                        
                        <x-table.heading>Actions</x-table.heading>
                         
                    </x-slot>

                    <x-slot name="body">                     
                        @foreach ($import_files as  $files)
                        <x-table.row wire:key="row-{{$files->id }}">
                            <x-table.cell>{{ $files->id }}</x-table.cell>
                            <x-table.cell><a href="{{ route('import-files-view', $files->id ) }}">{{ $files->file_name }}</a></x-table.cell>    
                            <x-table.cell>{{ $files->category_type }}</x-table.cell>     
                            <x-table.cell> {{ ucfirst(str_replace('_', ' ', $files->status)) }} </x-table.cell>  
                            <x-table.cell><span data-original-title="Success" title="Success" >{{ $files->success_count  }}</span> / <span data-original-title="Total" title="Total">{{ ($files->success_count+$files->error_count) }}</span></x-table.cell>                              
                            <x-table.cell>{{ $files->created_at->format(config('app_settings.date_format.value')) }}</x-table.cell>
                            <x-table.cell>
                               <div class="dropdown dropup dropleft">
                                    <button class="btn bg-gradient-default" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="material-icons">
                                            more_vert
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item"  data-original-title="View" title="View" href="{{ route('import-files-view', $files->id ) }}">View</a></li>
                                        @if(in_array( $files->status, ['pending', 'waiting_approval', 'in_progress', 'importing', 'accepted'] ))
                                            <li><a class="dropdown-item"  data-original-title="View" title="View" wire:click="cancel({{ $files->id }})">Cancel</a></li> 
                                        @endif   
                                        <li><a class="dropdown-item text-danger"  data-original-title="Remove" title="Remove" wire:click="destroyConfirm({{ $files->id }})">Delete</a></li>
                                    </ul>
                                </div>
                           
                            </x-table.cell>
                        </x-table.row>
                        @endforeach
                    </x-slot>
                </x-table>
                <div id="datatable-bottom">
                    {{ $import_files->links() }}
                </div>
                @if( $import_files->total() == 0)
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
