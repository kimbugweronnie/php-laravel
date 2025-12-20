<html>
    <head>
        <style>
            
            .container-fluid {
                padding: 0;
            }

            .mt-3 {
                margin-top: 1rem;
            }

            .col-lg-12 {
                width: 100%;
            }

            .border {
                border: 1px solid #dee2e6;
            }

            .bg-white {
                background-color: #fff;
            }

            .rounded-3 {
                border-radius: 0.3rem;
            }
            .space{
                margin-right: 50px; 
            }

            .shadow {
                box-shadow: 0 .125rem .25rem rgba(0, 0, 0, 0.075);
            }

            .p-4 {
                padding: 1.5rem;
            }

            .custom-tab {
                /* Add your custom tab styles here */
            }

            .table {
                width: 100%;
                border:1;
                color: #343a40;
            }

            .thead-dark {
                color: #fff;
                background-color: #343a40;
            }

            .fw-bold {
                font-weight: bold;
            }

            .text-capitalize {
                text-transform: capitalize;
            }

            .text-center {
                text-align: center;
            }

            .text-left {
                text-align: left;
            }

            .text-uppercase {
                text-transform: uppercase;
            }

            .fs-3 {
                font-size: 1.875rem;
            }

            .fs-4 {
                font-size: 1.5rem;
            }

            .pb-4 {
                padding-bottom: 1rem;
            }

            .py-3 {
                padding-top: 0.75rem;
                padding-bottom: 0.75rem;
            }

            .mb-3 {
                margin-bottom: 1rem;
            }

            .text-muted {
                color: #6c757d;
            }

            .row {
                display: flex;
                flex-wrap: wrap;
            
            }

            .col-6 {
                width: 50%;
            }

            .col-4 {
                width: 33.33333333%;
            }

            .col-12 {
                width: 100%;
            }
            body {
                font-family: 'Intel', sans-serif;
            }

            table {
                border-collapse: collapse;
                width: 100%;
                border: 1px solid black;
            }

            table td {
                border: 1px solid black;
            }
        </style>
   
    </head>
    <body>
        <div class="col-lg-12">
            <div class="fs-6 text-uppercase text-center fw-bold pb-5 mb-3">
                <div class="me-4" style="display: inline-block;"><img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/full-logo.png'))) }}" width="120"></div>
                <div style="display: inline-block; margin-left: 200px;">
                    <div>Uganda episcopal conference</div> 
                    <div>Uganda catholic secretariat</div>
                    <div>Uganda Catholic medical bureau</div>
                    <div>{{ $travelReq['related_document_request']['related_project_document']['related_project']['project_name'] }}</div>
                    <div>Travel Request Authorization</div> 
                </div>  
            </div>
            <div>
                <div class="row mb-2">
                <div class="fs-6 ">This form is to be filled out BEFORE the trip for trip approval.</div>    
            </div>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="">Traveler Names:</td>
                        <td class="" colspan="2">{{$travelReq['related_document_request']['added_by']['first_name']}} {{$travelReq['related_document_request']['added_by']['last_name']}}</td>
                        <td class="">Date of Request:</td>
                        <td class=""colspan="2">{{ Carbon\Carbon::parse($travelReq['related_document_request']['date_added'])->format('d-m-Y')}}</td>
                    </tr>
                </tbody>
            </table>
            <div>&nbsp;</div>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td colspan="8" class="fw-bold text-capitalize">A. Project Information</td> 
                    </tr>
                    <tr>
                        <td  colspan="4" class="text-capitalize">Project Name</td>  
                        <td  colspan="4" class="text-capitalize">Project Number</td> 
                    </tr>
                        <tr> 
                        <td class="text-uppercase" colspan="4">{{$travelReq['related_document_request']['related_project_document']['related_project']['project_name']}}</td>  
                        <td colspan="4">{{ $project_number }}</td> 
                    </tr> 
                </tbody>
             </table>  
             <div>&nbsp;</div>
            <table class="table table-bordered">
                <tbody>
                    <tr> 
                        <td colspan="8" class="fw-bold">B. Trip Scope of Work (Attach or fill in a SOW for the trip),</td>  
                    </tr>
                    <tr> 
                        <td colspan="8" class="fw-bold">Indicate, in detail, what will be accomplished during this trip</td>  
                    </tr>
                    <tr>
                        <td colspan="8" class="">{{ $travelReq["title"]  }}</td>  
                    </tr> 
                </tbody>
            </table>  
            <div>&nbsp;</div>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td colspan="5" class="fw-bold">C. Pre Trip Request*</td>  
                        <td colspan="3" class="fw-bold">Transportation Arrangements</td>   
                    </tr>   
                        <tr>
                        <td colspan="2"class="fw-bold">Date of Travel</td> 
                        <td class="fw-bold">Origin (Location)</td> 
                        <td colspan="2"class="fw-bold">Destination (Location)</td> 
                        <td class="fw-bold">Mode</td> 
                        <td class="fw-bold">Time of Day</td> 
                        <td class="fw-bold">Number of Travelers</td>
                    </tr> 
                        
                        @foreach($travelReq['meta_fields'] as $item)
                        <tr>
                            <td colspan="2">{{ $item['date_of_travel'] }}</td> 
                            <td>{{ $item['origin_location'] }}</td> 
                            <td colspan="2">{{ $item['destination_location'] }}</td> 
                            <td>{{ $item['transport_mode'] }}</td> 
                            <td>{{ $item['time_of_day'] }}</td> 
                            <td>{{ $item['number_of_travelers'] }}</td>
                        </tr>    
                        @endforeach
                    
                    <tr>
                        <td colspan="8"class="fw-bold">* If more space is needed for travel schedule, you must attach a spreadsheet with the above columns and information.</td> 
                    </tr>
                </tbody>
            </table>
            <div>&nbsp;</div>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td colspan="8" class="fw-bold">D. Travel Advance Request (if the partner has travel advance policy)</td> 
                    </tr>
                    <tr>
                        <td colspan="2"class="fw-bold">Details</td> 
                        <td class="fw-bold">No. of Persons</td> 
                        <td colspan="2"class="fw-bold">Days</td> 
                        <td colspan="2"class="fw-bold">Rate</td> 
                        <td class="fw-bold">Total</td> 
                    </tr> 
                    <tr>
                        <td colspan="2">Perdiem</td> 
                        <td></td> 
                        <td colspan="2"></td> 
                        <td colspan="2"></td> 
                        <td></td> 
                    </tr> 
                    <tr>
                        <td colspan="2">(a) Officers-(
                            @foreach($travelReq['travel_advance_request_fields'] as $item)
                                <span>{{ $item['name_of_persons'] }},</span>
                            @endforeach
                        )
                        </td> 
                        <td>{{ $numberOfPersons }}</td> 
                        <td colspan="2">{{ $days }}</td> 
                        <td colspan="2">{{ number_format($rate, 2) }}</td> 
                        <td>{{ number_format($subTotal, 2) }}</td> 
                    </tr> 
                    <tr>
                        <td colspan="2">Other-Communication</td> 
                        <td>{{ $travelReq['travel_other_communication'] }}</td> 
                        <td colspan="2"></td> 
                        <td colspan="2"></td> 
                        <td>{{ number_format($travelReq['travel_other_communication_amount'], 2) }}</td> 
                    </tr>
                    <tr>
                        <td colspan="2"></td> 
                        <td></td> 
                        <td colspan="2"></td> 
                        <td colspan="2"class="fw-bold">Sub Total</td> 
                        <td>{{  number_format($subTotal, 2) }}</td> 
                    </tr> 
                    <tr>
                        <td colspan="2"class="fw-bold"></td> 
                        <td class="fw-bold"></td> 
                        <td colspan="2"class="fw-bold"></td> 
                        <td colspan="2"class="fw-bold">Contingency</td> 
                        <td>{{ number_format($travelReq['travel_contingency_amount'], 2) }}</td> 
                    </tr> 
                    <tr>
                        <td colspan="2"class="fw-bold"></td> 
                        <td class="fw-bold"></td> 
                        <td colspan="2"class="fw-bold"></td> 
                        <td colspan="2"class="fw-bold">TOTAL</td> 
                        <td class="fw-bold">{{ number_format(($travelReq['total'] + $travelReq['travel_other_communication_amount']), 2) }}</td>
                    </tr> 
                </tbody>
            </table> 
            <div>&nbsp;</div>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td colspan="10">
                            <span class="text-capitalize "><span class="fw-bold">Requested By:</span> {{ $travelReq['related_document_request']['added_by']['first_name']  }} 
                                {{ $travelReq['related_document_request']['added_by']['last_name']}}</span>
                        </td>
                        <td colspan="2">
                            <span class="text-capitalize"><span class="fw-bold">Date:</span> {{ date('d/m/Y', strtotime($travelReq['related_document_request']['date_added']))}} </span>
                        </td>   
                    </tr>
                </tbody>
            </table>
            <div>&nbsp;</div>
            <table class="table table-bordered">
                <tbody>
                    @foreach($travelReq['approval_steps'] as $approver)
                        @if($approver['related_document_approval_step']['approval_step_name'] == "REVIEW")
                            <tr>
                                <td colspan="3">
                                    <div class="col-3 fs-6">
                                        <div>
                                            <span class="fw-bold text-capitalize">Reviewed By: <br /></span>
                                            @if($approver['approval_comment'])
                                                <span>
                                                    {{ $approver['related_approver']['related_user']['first_name'] }} 
                                                    {{ $approver['related_approver']['related_user']['last_name'] }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <div class="col-3 fs-6">
                                        <div class="text-capitalize">{{ \Str::ucfirst(\Str::lower($approver['generic_role_name'])) }}</div>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="col-2 fs-6">
                                        @if(strtotime($approver['date_performed']))
                                            <span class="fw-bold text-capitalize">Date:</span> <br />{{ date('d/m/Y', strtotime($approver['date_performed']))}} 
                                        @else
                                            <span class="fw-bold text-capitalize">Date:</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @elseif($approver['related_document_approval_step']['approval_step_name'] == "VERIFICATION")
                            <tr>
                                <td colspan="3">
                                    <div class="col-3 fs-6">
                                        <div>
                                            <span class="fw-bold text-capitalize">Verified By: <br /></span>
                                            @if($approver['approval_comment'])
                                                <span>
                                                    {{ $approver['related_approver']['related_user']['first_name'] }} 
                                                    {{ $approver['related_approver']['related_user']['last_name'] }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <div class="col-3 fs-6">
                                        <div class="text-capitalize">{{ \Str::ucfirst(\Str::lower($approver['generic_role_name'])) }}</div>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="col-2 fs-6">
                                        @if(strtotime($approver['date_performed']))
                                            <span class="fw-bold text-capitalize">Date:</span> <br />{{ date('d/m/Y H:i', strtotime($approver['date_performed']))}} 
                                        @else
                                            <span class="fw-bold text-capitalize">Date:</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @elseif($approver['related_document_approval_step']['approval_step_name'] == "APPROVAL")
                            <tr>
                                <td colspan="3">
                                    <div class="col-3 fs-6">
                                        <div>
                                            <span class="fw-bold text-capitalize">Approved By: <br /></span>
                                            @if($approver['approval_comment'])
                                                <span>
                                                    {{ $approver['related_approver']['related_user']['first_name'] }} 
                                                    {{ $approver['related_approver']['related_user']['last_name'] }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <div class="col-3 fs-6">
                                        <div class="text-capitalize">{{ \Str::ucfirst(\Str::lower($approver['generic_role_name'])) }}</div>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="col-2 fs-6">
                                        @if(strtotime($approver['date_performed']))
                                            <span class="fw-bold text-capitalize">Date:</span> {{ date('d/m/Y', strtotime($approver['date_performed']))}} 
                                        @else
                                            <span class="fw-bold text-capitalize">Date:</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @elseif($approver['related_document_approval_step']['approval_step_name'] == "AUTHORISATION")
                            <tr>
                                <td colspan="3">
                                    <div class="col-3 fs-6">
                                        <div>
                                            <span class="fw-bold text-capitalize">Authorized By: <br /></span>
                                            @if($approver['approval_comment'])
                                                <span>
                                                    {{ $approver['related_approver']['related_user']['first_name'] }} 
                                                    {{ $approver['related_approver']['related_user']['last_name'] }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <div class="col-3 fs-6">
                                        <div class="text-capitalize">{{ \Str::ucfirst(\Str::lower($approver['generic_role_name'])) }}</div>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="col-2 fs-6">
                                        @if(strtotime($approver['date_performed']))
                                            <span class="fw-bold text-capitalize">Date:</span> {{ date('d/m/Y', strtotime($approver['date_performed']))}} 
                                        @else
                                            <span class="fw-bold text-capitalize">Date:</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endif 
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>
