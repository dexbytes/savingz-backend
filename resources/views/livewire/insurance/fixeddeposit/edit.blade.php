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
                    <h5>Edit Fixed Deposits</h5>
                </div>
                <div class="card-body pt-0">

                    <form wire:submit.prevent="edit">

                        <div class="row ">
                            
                            
                            <div class="col-6  mb-4">
                                <div class="input-group input-group-static">
                                    <label>Investor Name *</label>
                                    <input wire:model.lazy="fixedDeposite.investor" type="text" class="form-control" placeholder="Enter a Investor">
                                </div>
                                @error('fixedDeposite.investor')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-6 mb-4">
                                <div class="input-group input-group-static" wire:ignore x-data x-init="flatpickr($refs.picker, {allowInput: false,
                               });">
                                    <label>Allotment Date *</label>
                                    <input wire:model.lazy="fixedDeposite.allotment_date"  x-ref="picker" class="form-control" type="text" placeholder="Enter a Allotment date" />
                                </div>
                                @error('fixedDeposite.allotment_date')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-4 mb-4">
                                <div class="input-group input-group-static">
                                    <label>Entity *</label>
                                    <input wire:model.lazy="fixedDeposite.entity" type="text" class="form-control" placeholder="Enter a Entity">
                                </div>
                                @error('fixedDeposite.entity')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-4  mb-4">
                                <div class="input-group input-group-static">
                                    <label>Pan Number *</label>
                                    <input wire:model.lazy="fixedDeposite.pan" type="text" class="form-control" placeholder="Enter a Pan Number">
                                </div>
                                @error('fixedDeposite.pan')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-4  mb-4">
                                <div class="input-group input-group-static">
                                    <label>FD Issuer *</label>
                                    <input wire:model.lazy="fixedDeposite.fd_issuer" type="text" class="form-control" placeholder="Enter a FD Issuer">
                                </div>
                                @error('fixedDeposite.fd_issuer')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>

                            
                            <div class="col-4  mb-4">
                                <div class="input-group input-group-static">
                                    <label>Tenure Months *</label>
                                    <input wire:model.lazy="fixedDeposite.tenure_months" type="text" class="form-control" placeholder="Enter a Tenure Month">
                                </div>
                                @error('fixedDeposite.tenure_months')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>
                           
                            <div class="col-4  mb-4">
                                <div class="input-group input-group-static">
                                    <label>Tenure Days *</label>
                                    <input wire:model.lazy="fixedDeposite.tenure_days" type="text" class="form-control" placeholder="Enter a Tenure Days">
                                </div>
                                @error('fixedDeposite.tenure_days')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-4  mb-4">
                                <div class="input-group input-group-static">
                                    <label>Amount *</label>
                                    <input wire:model.lazy="fixedDeposite.amount" type="text" class="form-control" placeholder="Enter a Amount">
                                </div>
                                @error('fixedDeposite.amount')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>
                            <div class="col-4  mb-4">
                                <div class="input-group input-group-static">
                                    <label>Interest Rate *</label>
                                    <input wire:model.lazy="fixedDeposite.interest_rate" type="text" class="form-control" placeholder="Enter a Interest Rate">
                                </div>
                                @error('fixedDeposite.interest_rate')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-4  mb-4">
                                <div class="input-group input-group-static">
                                    <label>Type *</label>
                                    <input wire:model.lazy="fixedDeposite.type" type="text" class="form-control" placeholder="Enter a Type">
                                </div>
                                @error('fixedDeposite.type')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-4  mb-4">
                                <div class="input-group input-group-static">
                                    <label>Commission In Rate *</label>
                                    <input wire:model.lazy="fixedDeposite.commission_in_rate" type="text" class="form-control" placeholder="Enter a Commission In Rate">
                                </div>
                                @error('fixedDeposite.commission_in_rate')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>
                            <div class="col-4  mb-4">
                                <div class="input-group input-group-static">
                                    <label>Commission Out Rate *</label>
                                    <input wire:model.lazy="fixedDeposite.commission_out_rate" type="text" class="form-control" placeholder="Enter a Commission Out Rate ">
                                </div>
                                @error('fixedDeposite.commission_out_rate')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>
                            <div class="col-4  mb-4">
                                <div class="input-group input-group-static">
                                    <label>Reference Number *</label>
                                    <input wire:model.lazy="fixedDeposite.reference_number" type="text" class="form-control" placeholder="Enter a Reference Number  ">
                                </div>
                                @error('fixedDeposite.reference_number')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>
                            <div class="col-4  mb-4">
                                <div class="input-group input-group-static">
                                    <label>Bank Name *</label>
                                    <input wire:model.lazy="fixedDeposite.bank_name" type="text" class="form-control" placeholder="Enter a Bank Name">
                                </div>
                                @error('fixedDeposite.bank_name')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-4  mb-4">
                                <div class="input-group input-group-static">
                                    <label>Cheque Number *</label>
                                    <input wire:model.lazy="fixedDeposite.cheque_number" type="text" class="form-control" placeholder="Enter a Cheque Number">
                                </div>
                                @error('fixedDeposite.cheque_number')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-8  mb-4">
                                <div class="input-group input-group-static">
                                    <label>Remarks	*</label>
                                    <input wire:model.lazy="fixedDeposite.remarks" type="text" class="form-control" placeholder="Enter a Remark">
                                </div>
                                @error('fixedDeposite.remarks')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-12 ">
                                <div class="form-group">
                                    
                                    <div class="form-check">
                                        <input wire:model="fixedDeposite.status" class="form-check-input" type="checkbox"  id="flexCheckFirst">
                                        <label class="form-check-label">Status *</label>
                                     </div>
                                </div>
                                @error('fixedDeposite.status')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>   
                            
                           

                        
        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-end mt-4">
                                    <a  href="{{ route('fixed-deposit-management') }}" class="btn btn-light m-0">Cancel</a>
                                    <button type="submit" name="submit" class="btn bg-gradient-dark m-0 ms-2">Update 
                                        Fixed Deposite</button>
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
