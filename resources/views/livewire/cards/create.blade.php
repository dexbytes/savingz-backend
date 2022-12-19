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
                    <h5>Add a Card</h5>
                </div>
                <div class="card-body pt-0">

                    <form wire:submit.prevent="store">

                        <div class="row ">
                            <div class="col-12  mb-4">
                                <div class="input-group input-group-static">
                                    <label>Card Number *</label>
                                    <input wire:model.lazy="card_number" type="text" class="form-control" placeholder="Enter a Card Number">
                                </div>
                                @error('card_number')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>
                            
                            <div class="col-6  mb-4">
                                <div class="input-group input-group-static">
                                    <label>Expiration Year </label>
                                    <input wire:model.lazy="expiration_year" type="text" class="form-control" placeholder="Enter a Expiration Year">
                                </div>
                                @error('expiration_year')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-6 mb-4">
                                <div class="input-group input-group-static">
                                    <label>Expiration Month </label>
                                    <input wire:model.lazy="expiration_month" type="text" class="form-control" placeholder="Enter a Expiration Month">
                                </div>
                                @error('expiration_month')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-12  mb-4">
                                <div class="input-group input-group-static">
                                    <label>Card Holder Name</label>
                                    <input wire:model.lazy="card_holder_name" type="text" class="form-control" placeholder="Enter a Card Holder Name">
                                </div>
                                @error('card_holder_name')
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
                                    <a  href="{{ route('cards-management') }}" class="btn btn-light m-0">Cancel</a>
                                    <button type="submit" name="submit" class="btn bg-gradient-dark m-0 ms-2">Create
                                        Card</button>
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
@endpush
