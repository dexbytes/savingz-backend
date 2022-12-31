<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h5 class="mb-0">Card Transactions</h5>
                        </div>
                        <div class="col-6 text-end">
                            <a class="btn bg-gradient-dark mb-0 me-4" href="{{ route('import-file', 'CardSummaryReport') }}"><i
                                    class="material-icons text-sm">upload</i>&nbsp;&nbsp;Import Transaction</a> 
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
       
                <!-- <form wire:submit.prevent="sortTable" class="d-flex  align-items-center justify-content-center">
                    <div class="d-flex align-items-center justify-content-center">
                            <p class="text-secondary">From Date&nbsp;&nbsp;</p>
                            <div class="input-group input-group-static  mb-2 me-2" wire:ignore x-data x-init="flatpickr($refs.picker, {allowInput: false, enableTime: 'false',
                            dateFormat:  '{{config('app_settings.date_format.value')}}' });">
                                <input id="from_date" wire:model="from_date"  x-ref="picker" class="form-control" type="text" placeholder="Any Date" />
                            </div>
                    </div>

                        <div class="d-flex align-items-center justify-content-center">
                            <p class="text-secondary">To Date&nbsp;&nbsp;</p>
                            <div class="input-group input-group-static  mb-2 me-2" wire:ignore x-data x-init="flatpickr($refs.picker, {allowInput: false, enableTime: 'false',
                            dateFormat:  '{{config('app_settings.date_format.value')}}' });">
                                <input id="to_date" wire:model="to_date"  x-ref="picker" class="form-control" type="text" placeholder="Any Date" />
                            </div>
                        </div>

                        <div class="">
                            <button type="submit" class="btn btn-sm mb-0 me-4 btn btn-outline-secondary">Filter</button>
                        </div>
                    </form> -->

                    <div class="mt-3">
                        <input  wire:model="search" type="text" class="form-control" placeholder="Search...">
                    </div>


                </div>
                <x-table>

                    <x-slot name="head">
                        
                        <x-table.heading sortable wire:click="sortBy('id')"
                            :direction="$sortField === 'id' ? $sortDirection : null"> ID
                        </x-table.heading>                     
                        <x-table.heading>Card Number</x-table.heading>
                        <x-table.heading>Txn Type</x-table.heading>
                        <x-table.heading>Amount</x-table.heading>
                        <x-table.heading>Balance</x-table.heading>
                        <x-table.heading>Customer Name</x-table.heading>                         
                        <x-table.heading>Status</x-table.heading>                     
                        <x-table.heading sortable wire:click="sortBy('txn_date')"
                            :direction="$sortField === 'txn_date' ? $sortDirection : null">
                            Txn Date
                        </x-table.heading>
                        <x-table.heading sortable wire:click="sortBy('created_at')"
                            :direction="$sortField === 'created_at' ? $sortDirection : null">
                            Uploaded Date
                        </x-table.heading> 
                        <x-table.heading>Actions</x-table.heading>                         
                    </x-slot>

                    <x-slot name="body">
                     
                    @foreach ($transactions as  $transaction)
                        <x-table.row wire:key="row-{{$transaction->id }}">
                            <x-table.cell>{{ $transaction->id }}</x-table.cell>
                            <x-table.cell> {{ $transaction->card_number }}</x-table.cell>   
                            <x-table.cell style="white-space: normal;">{{ $transaction->txn_type }}</x-table.cell>     
                            <x-table.cell>{{ \Utils::ConvertPrice($transaction->txn_amount) }}</x-table.cell> 
                            <x-table.cell>{{ \Utils::ConvertPrice($transaction->txn_available_balance) }}</x-table.cell> 
                            <x-table.cell> 
                                @if (isset($transaction->card->name))
                                  <a href="{{ route('view-user', $transaction->card->user_id) }}">  {{ $transaction->card->name }} </a>
                                @else
                                -
                                @endif
                                 
                                </x-table.cell> 
                            <x-table.cell>{{ $transaction->status }}</x-table.cell> 
                             <x-table.cell>{{ \Carbon\Carbon::parse($transaction->txn_date)->format(config('app_settings.date_format.value') .' '.config('app_settings.time_format.value')) }}</x-table.cell>
                            <x-table.cell>{{ $transaction->created_at->format(config('app_settings.date_format.value').' '.config('app_settings.time_format.value')) }}</x-table.cell>
                            <x-table.cell>                                 
                               <div class="dropdown dropup dropleft">
                                    <button class="btn bg-gradient-default" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="material-icons">
                                            more_vert
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                         <li><a class="dropdown-item"  data-original-title="Edit" title="Edit" href="{{ route('edit-card-transaction', $transaction) }}">Edit</a></li>
                                         <li><a class="dropdown-item text-danger"  data-original-title="Remove" title="Remove" wire:click="destroyConfirm({{ $transaction->id }})">Delete</a></li>
                                    </ul>
                                </div>                           
                            </x-table.cell>
                        </x-table.row>
                        @endforeach
                        
                    </x-slot>
                </x-table>

                <div id="datatable-bottom">
                    {{ $transactions->links() }}
                </div>

                @if( $transactions->total() == 0)
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
<script src="{{ asset('assets') }}/js/plugins/flatpickr.min.js"></script>

<script>
$(document).ready(function(){
	flatpickr("#from_date",{
        maxDate : "today",
		dateFormat: "d-m-Y",
	    defaultDate: "today",
	});
    
	flatpickr("#to_date",{
        maxDate : "today",
		dateFormat: "d-m-Y",
		defaultDate: "today",
	});
    
});
  </script>
@endpush
