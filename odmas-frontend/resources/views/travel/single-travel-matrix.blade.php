 @extends('layouts.app')

@section('content')

@include('messages.flash')

<!-- <div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize">Travel Matrix</h3>
            <a class="btn btn-secondary px-3" href="{{ route('travels.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-left mb-1" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0v-2z"/>
                    <path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                </svg>
                Back
            </a>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-12"> 
            <div class="border rounded-3 bg-white shadow py-4 px-5">
                <div class="mb-2">
                    <span class="fw-bold text-capitalize">Week Start Date:</span> {{ $data[0]["week_from"] }}
                </div>
                <div class="mb-2">
                    <span class="fw-bold text-capitalize">Week End Date:</span> {{ $data[0]["week_to"] }}
                </div>
                <div class="mb-2">
                    <span class="fw-bold text-capitalize">Destination Details:</span> {{ $data[0]["destination_details"] }}
                </div>
                <div class="mb-2">
                    <span class="fw-bold text-capitalize">Team:</span> {{ $data[0]["team"] }}
                </div>
                <div class="mb-2">
                    <span class="fw-bold text-capitalize">Driver or Alternative:</span> {{ $data[0]["driver_or_alternative"] }}
                </div>
                <div class="mb-2">
                    <span class="fw-bold text-capitalize">Remarks:</span> {{ $data[0]["remarks"] }}
                </div>
            </div>
        </div>
    </div>
</div>
 --> 

@push('styles')
<style>
    table, th, td {
        border: 2px solid #0a0a0a !important;
    }

</style>
@endpush

<div class="container-fluid p-0">
<div class="row">
    <div class="col-lg-12 d-flex mb-3 justify-content-between">
        <h4 class="text-capitalize fw-bold">TRAVEL MATRIX</h4>
        <a class="btn btn-secondary px-3" href="{{ route('travels.index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-left mb-1" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0v-2z"/>
                <path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
            </svg>
            Back
        </a>
    </div>
</div>
<div class="row mt-3">
    <div class="col-lg-12">
        <div class="border bg-white rounded-3 shadow p-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="12">
                            <div>
                                <div class="row mb-3">
                                <div class="text-uppercase fw-bold text-center pb-3">
                                         <div class=""><img src="{{ asset('img/full-logo.png') }}" width="140" alt=" travel image"></div>
                                        <div class="fs-4">TRAVEL MATRIX WEEK OF  {{ $data[0]["week_from"] }} to  {{ $data[0]["week_to"] }}</div>
                                    </div>
                                </div>    
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="7">DESTINATION ,ACTIVITY AND DATES</td>
                        <td colspan="3">TEAM</td>
                        <td>DRIVER/ALTERNATIVE</td>
                        <td>REMARKS</td>
                    </tr>
                    <tr>
                        <td colspan="7">{{ $data[0]["destination_details"] }}</td>
                        <td colspan="3"> {{ $data[0]["team"] }}</td>
                        <td> {{ $data[0]["driver_or_alternative"] }}</td>
                        <td> {{ $data[0]["remarks"] }}</td>
                    </tr>
                   
                    <!-- <tr>
                            <td colspan="12">
                                <div class="row mt-4">
                                    <div class="col-2 fs-4">
                                        <div>
                                            <span class="fw-bold text-capitalize">Requested By: (Traveler)</span> 
                                            </span>
                                        </div>
                                        </div>
                                        <div class="col-5  fs-4">
                                            <div>
                                                <span class="fw-bold text-capitalize">_____________________________________________</span> 
                                                </span>
                                            </div>
                                            <span class="fw-bold">Name </span>
                                            <span class="mx-6"></span> 
                                            <span class="fw-bold">Signature</span>
                                        </div>
                                        <div class="col-5 fs-4">
                                             <div>
                                                <span class="fw-bold text-capitalize">______________</span> 
                                                </span>
                                            </div>
                                            <span class="fw-bold text-capitalize">Date:</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-2 fs-4">
                                        <div>
                                            <span class="fw-bold text-capitalize">Reviewed By:(Head of Section)</span> 
                                            </span>
                                        </div>
                                        </div>
                                        <div class="col-5  fs-4">
                                            <div>
                                                <span class="fw-bold text-capitalize">_____________________________________________</span> 
                                                </span>
                                            </div>
                                            <span class="fw-bold">Name </span>
                                            <span class="mx-6"></span> 
                                            <span class="fw-bold">Signature</span>
                                        </div>
                                        <div class="col-5 fs-4">
                                             <div>
                                                <span class="fw-bold text-capitalize">______________</span> 
                                                </span>
                                            </div>
                                            <span class="fw-bold text-capitalize">Date:</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-2 fs-4">
                                        <div>
                                            <span class="fw-bold text-capitalize">Approved By:(Program Manager)</span> 
                                            </span>
                                        </div>
                                        </div>
                                        <div class="col-5  fs-4">
                                            <div>
                                                <span class="fw-bold text-capitalize">_____________________________________________</span> 
                                                </span>
                                            </div>
                                            <span class="fw-bold">Name </span>
                                            <span class="mx-6"></span> 
                                            <span class="fw-bold">Signature</span>
                                        </div>
                                        <div class="col-5 fs-4">
                                            <div>
                                                <span class="fw-bold text-capitalize">______________</span> 
                                                </span>
                                            </div>
                                            <span class="fw-bold text-capitalize">Date:</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                     -->
                </tbody>
            </table> 
        </div>
    </div>
</div>
</div>
@endsection
