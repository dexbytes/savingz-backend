<div class="container-fluid py-4 bg-gray-200">
    <div class="row mb-5">
        <div class="col-lg-9 col-12 mx-auto position-relative">
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
            <div class="card mt-4" id="basic-info">
                <div class="card-header">
                    <h5>Edit Transaction</h5>
                </div>
                <div class="card-body pt-0">

                    <form wire:submit.prevent="edit">

                        <div class="row ">
                            <div class="col-12  mb-4">
                                <div class="input-group input-group-static">
                                    <label>Card Number *</label>
                                    <input wire:model.lazy="cardTransaction.card_number" type="text" class="form-control" placeholder="Enter a Card Number">
                                </div>
                                @error('cardTransaction.card_number')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>
                            
                            <div class="col-12  mb-4">
                                <div class="input-group input-group-static">
                                    <label>Transaction Type </label>
                                    <input wire:model.lazy="cardTransaction.txn_type" type="text" class="form-control" placeholder="Enter a Transaction Type">
                                </div>
                                @error('cardTransaction.txn_type')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-4 mb-4">
                                <div class="input-group input-group-static">
                                    <label>Transaction Amount </label>
                                    <input wire:model.lazy="cardTransaction.txn_amount" type="text" class="form-control" placeholder="Enter a Transaction Amount">
                                </div>
                                @error('cardTransaction.txn_amount')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-4  mb-4">
                                <div class="input-group input-group-static">
                                    <label>Available Balance </label>
                                    <input wire:model.lazy="cardTransaction.txn_available_balance" type="text" class="form-control" placeholder="Enter a Available Balance">
                                </div>
                                @error('cardTransaction.txn_available_balance')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-4  mb-4">
                                <div class="input-group input-group-static">
                                    <label>Ledger Balance </label>
                                    <input wire:model.lazy="cardTransaction.txn_ledger_balance" type="text" class="form-control" placeholder="Enter a Ledger Balance">
                                </div>
                                @error('cardTransaction.txn_ledger_balance')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>

                            
                                <div class="col-6 mb-4">
                                    <div class="input-group input-group-static" wire:ignore x-data x-init="flatpickr($refs.picker, {allowInput: false, enableTime: 'true',
                                    dateFormat: 'Y-m-d H:i'});">
                                        <label>Transaction Date </label>
                                        <input wire:model.lazy="cardTransaction.txn_date"  x-ref="picker" class="form-control" type="text" placeholder="Enter a Transaction date" />
                                    </div>
                                    @error('cardTransaction.txn_date')
                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                </div>
                           

                            
                            <div class="col-6  mb-4">
                                 
                                <div class="input-group input-group-static">
                                    <label>Status </label>
                                    <select class="form-control input-group input-group-static" name="status" wire:model.lazy="cardTransaction.status"  id="projectName" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @foreach($this->allStatus as $status)
                                    <option value="{{  $status }}">{{  $status }}</option>
                                  
                                 @endforeach
                                    </select>
                                  
                                </div>
                                
                               
                             </div>
                                @error('cardTransaction.status')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>

                        
        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-end mt-4">
                                    <a  href="{{ route('card-transaction-management') }}" class="btn btn-light m-0">Cancel</a>
                                    <button type="submit" name="submit" class="btn bg-gradient-dark m-0 ms-2">Update 
                                        Transaction</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
 
        </div>
    </div>
</div>
@push('js')
<script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
<script src="{{ asset('assets') }}/js/plugins/quill.min.js"></script>
<script src="{{ asset('assets') }}/js/plugins/flatpickr.min.js"></script>
@endpush
