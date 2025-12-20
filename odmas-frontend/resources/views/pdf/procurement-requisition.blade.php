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

        /* Add more styles as needed */
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
                <div>{{ $procurementReq['related_document_request']['related_project_document']['related_project']['project_name'] }}</div>
                <div>{{ $procurementReq['related_document_request']['related_project_document']['order_number'] }}</div>
                <div>Procurement Requisition</div> 
            </div>  
        </div>
        <table class="table table-bordered">
        <tbody>
            <tr>
                <td colspan="9" class="text-left fw-bold"> Procurement Reference Number (Refer to the Procurement Guidelines)</th>
            </tr>
            <tr>
                <td colspan="2">PD Entity Code:</td>
                <td colspan="3">Wrks/Srvcs/Supplies?</td>
                <td class="text-capitalize">Budget Year</td>
                <td>Sequence Number</td>
                <td>ITB Number</th>
                <td>Contract Number</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            </tbody>
        </table>
        <div>&nbsp;</div>
        <table>
            <tbody>
                <tr>
                    <td class="text-capitalize" colspan="9"><span class="fw-bold">Subject of procurement:</span> {{ $procurementReq['title'] }} </td>
                </tr>
                <tr class="text-capitalize">
                    <td class="fw-bold" colspan="2">Location for delivery: </td>
                    <td colspan="3">{{ $procurementReq['location_for_delivery'] }}</td>
                    <td class="fw-bold" colspan="2">Date required: </td>
                    <td colspan="2">{{ $procurementReq['date'] }}</td>
                </tr>
                <tr class="fw-bold text-capitalize">
                    <td>Item No.</td>
                    <td colspan="4">Description</td>
                    <td>Quantity</td>
                    <td>Unit of Measure</td>
                    <td>Estimated Unit Cost</td>
                    <td>Estimated Total Cost ({{$procurementReq['currency_id']['currency_symbol']}})</td>
                </tr>
                @php
                    $counter = 1;
                @endphp
                @foreach($procurementReq['meta_fields'] as $item)
                    <tr>
                        <td>{{ $counter }}</td>
                        <td colspan="4">{{ $item['description'] }}</td>
                        <td>{{  number_format($item['quantity'],2) }}</td>
                        <td>{{ $item['unit_of_measure'] }}</td>
                        <td>{{  number_format($item['estimated_unit_cost'],2) }}</td>
                        <td>{{  number_format($item['estimated_total_cost'],2) }}</td>
                    </tr>
                    @php
                        $counter++;
                    @endphp
                @endforeach
                <tr>
                    <td></td>
                    <td class="fw-bold text-capitalize"colspan="4">Currency ({{$procurementReq['currency_id']['currency_symbol']}}):</td>
                    <td></td>
                    <td class="fw-bold text-capitalize"colspan="2">Estimated Total Cost:</td>
                    <td>{{ number_format($total,2) }}</td>
                </tr>
            </tbody>
        </table>
        <div>&nbsp;</div>
        <table>
            <tbody>
                <tr>
                    <td class="fw-bold text-capitalize" colspan="9">Budget code:</td>
                </tr>
                <tr>
                    <td class="fw-bold text-capitalize">Program</td>
                    <td class="fw-bold text-capitalize">Project</td>
                    <td class="fw-bold text-capitalize">Donor</td>
                    <td class="fw-bold text-capitalize">Activity</td>
                    <td class="fw-bold text-capitalize">Resp/Cost centre</td>
                    <td class="fw-bold text-capitalize">Annual budget</td>
                    <td class="fw-bold text-capitalize">Exp to date</td>
                    <td class="fw-bold text-capitalize">Budget balance</td>
                    <td class="fw-bold text-capitalize">Amount required</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-capitalize">{{ $procurementReq['related_document_request']['related_project_document']['related_project']['project_name'] }}</td>
                    <td></td>
                    <td>{{ $procurementReq['related_activity']['activity_name'] }}</td>
                    <td>{{ $procurementReq['cost_center']['cost_center_name'] }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td> 
                </tr>
            </tbody>
        </table>
        <div>&nbsp;</div>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td colspan="4">
                        <span class="text-capitalize"><span class="fw-bold">Requested By:</span> 
                            {{ $procurementReq['related_document_request']['added_by']['first_name'] }} 
                            {{ $procurementReq['related_document_request']['added_by']['last_name']}}</span>
                    </td>
                    <td colspan="4">
                        {{-- Don't delete --}}
                    </td>   
                    <td colspan="4">
                        <span class="text-capitalize"><span class="fw-bold">Date:</span> {{ date('d/m/Y', strtotime($procurementReq['related_document_request']['date_added'])) }} </span>
                    </td>   
                </tr>
                @foreach($procurementReq['approval_steps'] as $approver)
                    <tr>
                        <td colspan="4">
                            <div class="col-3">
                                @if($approver['related_document_approval_step']['approval_step_name'] == "REVIEW")
                                    <div>
                                        <span class="fw-bold text-capitalize">Reviewed By:</span>
                                        @if($approver['approval_comment'])
                                            <span>
                                                {{ $approver['related_approver']['related_user']['first_name'] }} 
                                                {{ $approver['related_approver']['related_user']['last_name'] }}
                                            </span>
                                        @endif
                                    </div> 
                                @elseif($approver['related_document_approval_step']['approval_step_name'] == "VERIFICATION")
                                    <div>
                                        <span class="fw-bold text-capitalize">Verified By:</span>
                                        @if($approver['approval_comment'])
                                            <span>
                                                {{ $approver['related_approver']['related_user']['first_name'] }} 
                                                {{ $approver['related_approver']['related_user']['last_name'] }}
                                            </span>
                                        @endif
                                    </div> 
                                @elseif($approver['related_document_approval_step']['approval_step_name'] == "APPROVAL")
                                    <div>
                                        <span class="fw-bold text-capitalize">Approved By:</span>
                                        @if($approver['approval_comment'])
                                            <span>
                                                {{ $approver['related_approver']['related_user']['first_name'] }} 
                                                {{ $approver['related_approver']['related_user']['last_name'] }}
                                            </span>
                                        @endif
                                        
                                    </div>
                                @elseif($approver['related_document_approval_step']['approval_step_name'] == "AUTHORISATION")
                                    <div>
                                        <span class="fw-bold text-capitalize">Authorized By:</span>
                                        @if($approver['approval_comment'])
                                            <span>
                                                {{ $approver['related_approver']['related_user']['first_name'] }} 
                                                {{ $approver['related_approver']['related_user']['last_name'] }}
                                            </span>
                                        @endif
                                    </div>    
                                @endif
                            </div>
                        </td>
                        <td colspan="4">
                            <div class="col-3">
                                <div class="text-capitalize">{{ \Str::ucfirst(\Str::lower($approver['generic_role_name'])) }}</div>
                            </div>
                        </td>
                        <td colspan="4">
                            <div class="col-2 fs-6">
                                @if(strtotime($approver['date_performed']))
                                    <span class="fw-bold text-capitalize">Date:</span> {{ date('d/m/Y H:i', strtotime($approver['date_performed']))}} 
                                @else
                                    <span class="fw-bold text-capitalize">Date:</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </body>
</html>


