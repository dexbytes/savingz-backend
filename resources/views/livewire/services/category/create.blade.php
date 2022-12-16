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
                    <h5>Service Category</h5>
                </div>
                <div class="card-body pt-0">
                    <form wire:submit.prevent="store">
                                <div class="row mt-3">
                                    <div class="col-12 ">
                                        <div class="input-group input-group-static">
                                            <label>Name *</label>
                                            <input wire:model.lazy="name" class="multisteps-form__input form-control" type="text" placeholder="Enter a Service Category name" />
                                        </div>
                                        @error('name')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                    
                                </div>
                               
                                   
                                    
                                 
                                <div class="row mt-4">
                                    <div class="col-12 col-sm-6">
                                        <div class="input-group input-group-static">
                                            <div class="form-check form-switch ms-3">
                                                <label>Status</label>
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault35" wire:model="status">
                                            </div>
                                            @error('status')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                </div>                       
                    </form>
                </div>
            </div>
            


            <div class="card mt-4" id="basic-info">
                <div class="card-header">
                    <h5>Keywords</h5>
                </div>
                <div class="card-body pt-0">
                    <form wire:submit.prevent="store">
                        <x-table>
                            <x-slot name="head">
                                <x-table.heading>
                                    Keyword Name
                                </x-table.heading>
                                
                            </x-slot>
                            <x-slot name="body">
                                @foreach($keywords as $key => $keyword)
                                <x-table.row>
                                    <x-table.cell style="border:none">
                                        <div class="col-12  mb-4">
                                            <div class="input-group input-group-static">
                                                    <label>Name *</label>
                                                    <input wire:model.lazy="keywords.{{$key}}.name" type="text" class="form-control" placeholder="Enter a Keyword name">
                                            </div>
                                                @error('keywords.'.$key.'.name')
                                                 <p class='text-danger inputerror'>{{ $message }} </p>
                                                 @enderror
                                        </div>
                                    </x-table.cell>
                                  
                                    @if($key > 0)
                                    <x-table.cell style="border:none">
                                        <a href="#" wire:click.prevent="removeInput({{$key}})"><span class="material-symbols-outlined">
                                            delete
                                            </span></a>
                                    </x-table.cell>
                                    @endif
                                    
                                </x-table.row>
                              @endforeach
                            </x-slot>    
                        </x-table>
                        <div wire:click="addInput" class="cursor-pointer btn btn-light m-0">
                            <span>
                               + add Keywords
                                </span>
                                 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-end mt-4">
                                    <a  href="{{ route('service-category-management') }}" class="btn btn-light m-0">Cancel</a>
                                    <button type="submit" name="submit" class="btn bg-gradient-dark m-0 ms-2">Create
                                        Service Category</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>





        </div>
    </div>
</div>
@push('js')
<script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
@endpush
