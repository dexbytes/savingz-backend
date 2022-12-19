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
                    <h5>Add Bank</h5>
                </div>
                <div class="card-body pt-0">

                    <form wire:submit.prevent="store">

                        <div class="row ">
                            <div class="col-12  mb-4">
                                <div class="input-group input-group-static">
                                    <label>Name *</label>
                                    <input wire:model.lazy="name" type="text" class="form-control" placeholder="Enter a Name">
                                </div>
                                @error('name')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>       
                            <div class="col-12  mb-4">
                                <div class="input-group input-group-static">
                                    <label>Bank Code *</label>
                                    <input wire:model.lazy="bank_code" type="text" class="form-control" placeholder="Enter a bank Code">
                                </div>
                                @error('bank_code')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>  
                            <div class="col-12 ">
                                <div class="form-group">
                               
                                    <div class="form-check">
                                        <input wire:model="status" class="form-check-input" type="checkbox"  id="flexCheckFirst">
                                        <label class="form-check-label">Status</label>
                                     </div>
                                </div>
                                @error('status')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>    

                        </div>
        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-end mt-4">
                                    <a  href="{{ route('bank-management') }}" class="btn btn-light m-0">Cancel</a>
                                    <button type="submit" name="submit" class="btn bg-gradient-dark m-0 ms-2">Create
                                        Bank</button>
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

@endpush
