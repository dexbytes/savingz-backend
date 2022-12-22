<div class="container-fluid py-4"> 
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h5 class="mb-0">Records #{{$file->id}}</h5>
                        </div>
                        <div class="col-6 text-end">
                            <a href="{{ route('import-files-management') }}" class="btn bg-gradient-default mb-0 me-4">
                                <i class="material-icons text-sm">arrow_back_ios</i>&nbsp;&nbsp;Back</a>
                           
                            @if($file->success_count > 0 && count($successData) > 0 && $file->status == 'waiting_approval')
                                <a wire:click="destroyUpload()" class="btn bg-gradient-success mb-0 me-4"><i
                                        class="material-icons text-sm">sync</i>&nbsp;&nbsp;Proceed Now</a>
                            @endif 
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-4">
                            <div class="nav-wrapper position-relative end-0">
                                <ul class="nav nav-pills nav-fill p-1"  >
                                    <li class="nav-item" wire:click="tabChange('valid')">
                                        <a class="nav-link active">
                                            Valid
                                            <span class="badge badge-success">{{$file->success_count}}</span>
                                        </a>
                                    </li>
                                  
                                    <li class="nav-item"  wire:click="tabChange('invalid')">
                                        <a  class="nav-link">
                                           Invalid
                                           <span class="badge badge-primary">{{$file->error_count}}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-8"></div>
                    </div>
                </div>

            
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                @foreach ($header as $head =>  $headValue)
                                    <th class="text-uppercase  text-center text-secondary text-xs font-weight-bolder opacity-7">{{ str_replace('_', ' ',$head) }}</th>
                                @endforeach
                                @if(count($header) > 0)
                                    <th class="text-uppercase  text-center text-secondary text-xs font-weight-bolder opacity-7">{{$status == 'invalid' ? "Error" : 'Warning'}}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="h-100">
                            @foreach ($displayData as $displayKey =>  $displayValue)
                                <tr>
                                     @foreach ($displayValue as $dkey =>  $dValue)
                                      
                                       @if(array_key_exists($dkey, $header))
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-secondary text-xs font-weight-normal"> 
                                                    {{$dValue}}
                                                </span>
                                            </td>
                                        @endif

                                        @if(in_array($dkey, ['error']))
                                            <td class="align-middle text-center text-sm">            
                                                <span class="material-symbols-outlined"  data-bs-toggle="tooltip" data-bs-placement="top" title="{{$dValue}}" data-container="body" data-animation="true">
                                                    @if($status == 'valid') warning @else report @endif
                                                </span>
                                            </td>
                                        @endif
                                    @endforeach

                                </tr> 
                            @endforeach

                            @if(count($displayData) == 0 || count($header) == 0)
                                <tr>
                                    <td colspan="{{ count($header) }}">
                                           <p class="text-center">No records found!</p>
                                    </td>
                                </tr>
                            @endif
    
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
<script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
@endpush
<style>
    .table-responsive {
        overflow-x: auto !important; 
    }
</style>
