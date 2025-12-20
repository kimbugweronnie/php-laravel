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
        <h4 class="text-capitalize fw-bold">TRAVEL REPORT</h4>
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
                            <div class="text-center pb-4">
                                 <div class=""><img src="{{ asset('img/ucmb_logo.png') }}" width="120" alt=" travel image"></div>
                                <div class="fs-3 text-uppercase">UGANDA EPISCOPAL CONFERENCE</div> 
                                <div class="fs-3 text-uppercase">UGANDA CATHOLIC SECRETARIAT</div>
                                <div class="fs-3 text-uppercase">UGANDA CATHOLIC MEDICAL BUREAU</div>
                                <div class="fs-3 text-uppercase">FLASH PROJECT</div>
                                <div class="fs-3 text-uppercase">TRIP REPORT</div>
                            </div>
                            
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Traveler Name:</td>
                        <td colspan="11"></td>
                        
                    </tr>
                    <tr>
                        <td>Project Name:</td>
                        <td colspan="11">FLASH</td>
                        
                    </tr>
                    <tr>
                        <td>Project Number:</td>
                        <td colspan="11">NU2GGH002289</td>
                        
                    </tr>
                    <tr> 
                        <td colspan="12"></td>   
                    </tr>
                    <tr>
                        <td colspan="2">Travel Dates (Include Return)</td>
                        <td colspan="3">Origin (Location)</td>
                        <td colspan="7">Destination (Location)</td>
                    </tr>
                    <tr> 
                        <td colspan="12">Activities Accomplished During the Trip (These should be related to the proposed activities on the Travel Request Authorization form submitted before the trip)</td>   
                    </tr>
                    <tr> 
                        <td colspan="12"></td>   
                    </tr>
                    <tr> 
                        <td colspan="12">Conclusion/Any Other Issues (These should be any new findings during the trip. Please list what was accomplished exceptionally well and should be replicated, or what was problematic during the trip.)</td>   
                    </tr>
                    <tr> 
                        <td colspan="12"></td>   
                    </tr>
                    <tr>
                        <td>Post trip Action Plan</td>
                        <td colspan="11"></td>
                    </tr>
                    <tr>
                        <td colspan="3">Issues Identified</td>
                        <td colspan="3">Recommendations / Action- plan</td>
                        <td colspan="3">Individual responsible</td>
                        <td colspan="3">Anticipated completion date</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="3"></td>
                        <td colspan="3"></td>
                        <td colspan="3"></td>
                    </tr>
                    <tr>
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
                </tbody>
            </table> 
        </div>
    </div>
</div>
</div>
