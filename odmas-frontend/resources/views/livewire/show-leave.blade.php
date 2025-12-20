@push('styles')
    <style>
        #blur {
        color: transparent;
        text-shadow: 0 0 8px #000;
      }
    </style>
@endpush

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h4 class="text-capitalize fw-bold">Annual Leave request</h4>
            <a class="btn btn-secondary px-3" href="{{ route('leave.index') }}">
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
            <div class="border bg-white rounded-3 shadow px-3 pt-2">
                <table class="table table-borderless ">
                    <thead class="d-flex justify-content-center mb-3">
                        <tr> 
                            <th class="fs-4 text-uppercase fw-bold text-center pb-3">
                                <div><img src="{{ asset('img/full-logo.png') }}" width="120" alt=" leave image"></div>
                                <div>Uganda episcopal conference</div> 
                                <div>Uganda catholic secretariat</div>
                                <div>Uganda Catholic medical bureau</div>
                                <div>Application For Annual Leave</div> 
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                       <tr>
                            <td class="fs-5">Leave is calculated from the day of first appointment.</td>
                        </tr>
                        <tr>
                            <td class="py-1 pb-3 fs-5">[N.B: One can apply for leave only after completing at least 12 months of service]</td>
                        </tr>
                        <tr>
                            <td class="py-1 fs-4"><span class="fw-bold">Full Names:</span> {{ $leave['related_document_request']['added_by']['first_name'] }} {{ $leave['related_document_request']['added_by']['last_name']  }}</td>
                        </tr>
                        <tr>
                            <td class="py-1 fs-4"><span class="fw-bold">Department:</span> UCMB </td>
                        </tr>
                        <tr>
                            <td class="py-1 fs-4"><span class="fw-bold">Designation:</span></td>
                        </tr>
                        <tr>
                            <td class="py-1 fs-4"><span class="fw-bold">Present Annual Leave entitlement:</span> {{ $leave['related_leave_management']['present_annual_leave_entitlement']}}</td>
                        </tr>
                        <tr>
                            <td class = "d-flex justify-content-between">
                                <div class="fs-4 "><span class="fs-4 fw-bold">Date of return from last leave:</span> {{ $leave['related_leave_management']['last_leave_return_date'] ?  $leave['related_leave_management']['last_leave_return_date'] : ''}}</div>
                                <div class="fs-4 "><span class="fs-4 fw-bold">Number of days taken:</span> {{ $leave['related_leave_management']['number_days_taken'] }} days</div>
                            </td>
                        </tr>
                        <tr>
                            <td class = "d-flex justify-content-between">
                                <div class="fs-4 "><span class="fs-4 fw-bold">Balance:</span> {{ $leave['related_leave_management']['balance_of_days']}} days</div>
                                <div class="fs-4 "><span class="fs-4 fw-bold">Leave now required:</span> {{ $leave['related_leave_management']['leave_days_required']}} days </div>
                            </td>
                        </tr>
                        <tr>
                            <td class = "d-flex justify-content-between">
                                <div class="fs-4 "><span class="fs-4 fw-bold">From:</span> {{ $leave['related_leave_management']['leave_start_date'] }}</div>
                                <div class="fs-4 "><span class="fs-4 fw-bold">To:</span> {{ $leave['related_leave_management']['leave_end_date'] }}</div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="py-1 fs-4"><span class="fw-bold">Address while on leave:</span> {{ $leave['related_leave_management']['address_while_on_leave'] }} </td>
                        </tr>          
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-12 mt-4">
        <div class="border bg-white rounded-3 shadow p-4">
                <div class="row">
                    <div class="col-4 fs-4">
                        <span class="fw-bold text-capitalize">Requested by:</span> 
                        {{ $currentUser['first_name'] }} {{ $currentUser['last_name'] }}
                    </div>
                </div>
            @foreach($leave['approval_steps'] as $approver)
                <div class="row mt-3">
                    <div class="col-4 fs-4">
                        @if($approver['related_document_approval_step']['approval_step_name']== "REVIEW")
                            <div>
                                <span class="fw-bold text-capitalize">Reviewed by:</span> 
                                @if ($approver['approval_comment'])
                                    <span class="text-muted">
                                        {{ $approver['related_approver']['related_user']['first_name'] }} 
                                        {{ $approver['related_approver']['related_user']['last_name'] }}
                                    </span>
                                @endif
                            </div>
                        @elseif($approver['related_document_approval_step']['approval_step_name']== "APPROVAL")
                            <div>
                                <span class="fw-bold text-capitalize">Approved by:</span>
                                @if ($approver['approval_comment'])
                                    <span class="text-muted">
                                        {{ $approver['related_approver']['related_user']['first_name'] }} 
                                        {{ $approver['related_approver']['related_user']['last_name'] }}
                                    </span>
                                @endif
                            </div>    
                        @elseif($approver['related_document_approval_step']['approval_step_name']== "AUTHORISATION")
                            <div>
                                <span class="fw-bold text-capitalize">Authorized by:</span>
                                @if ($approver['approval_comment'])
                                    <span class="text-muted">
                                        {{ $approver['related_approver']['related_user']['first_name'] }} 
                                        {{ $approver['related_approver']['related_user']['last_name'] }}
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="col-4 fs-4">
                        <div class="fw-bold text-capitalize">{{ \Str::ucfirst(\Str::lower($approver['generic_role_name'])) }}</div>
                    </div>
                    <div class="col-4 fs-4">
                        @if(strtotime($approver['date_performed']))
                            <span class="fw-bold text-capitalize">Date:</span>{{ date('d/m/Y', strtotime($approver['date_performed']))}} 
                        @else
                            <span class="fw-bold text-capitalize">Date:</span>
                        @endif
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 fs-4">
                        <span class="fw-bold text-capitalize">Comment:</span> 
                        <span class="text-muted">
                            {{ $approver['approval_comment'] }}
                        </span>
                    </div>
                </div>
                
            @endforeach
        </div>
    </div>
</div>