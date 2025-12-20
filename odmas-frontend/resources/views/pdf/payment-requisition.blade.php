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
            <div >Uganda Catholic medical bureau</div>
            <div>{{ $paymentReq['related_document_request']['related_project_document']['related_project']['project_name'] }}</div>
            <div>{{ $paymentReq['related_document_request']['related_project_document']['order_number'] }}</div>
            <div>Payment request form</div>
        </div> 
    </div>
    <div class="text-left mb-3">
        <div class="fs-6"><span class="fw-bold">Requisitioning Officer: </span>
            <span>{{ $paymentReq['related_document_request']['added_by']['first_name'] }} {{ $paymentReq['related_document_request']['added_by']['last_name'] }}</span> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="space fw-bold">Source Of Funds:</span> 
        </div>
    </div>
    <div class="text-left">
        <div class="fs-6 mb-3"><span class="fw-bold">Purpose:</span> {{ $paymentReq['title'] }}</div>    
    </div>
             
    <table>
        <tbody>
            <tr class="fw-bold text-capitalize">
                <td>Date</td>
                <td colspan="2">Description</td>
                <td colspan="2">Budget code</td>
                <td colspan="2">Amount ({{ $paymentReq['currency_id']['currency_symbol'] }})</td>
            </tr>
            @forelse($paymentReq['meta_fields'] as $item)
                <tr>
                    <td>{{ Carbon\Carbon::parse($item['date'])->format('d/m/Y') }}</td>
                    <td colspan="2">{{ $item['description'] }}</td>
                    <td colspan="2">{{ $item['budget_code'] }}</td>
                    <td colspan="2">{{  number_format($item['amount'],2) }}</td>
                </tr>
            @empty
                <tr>
                    <td></td>
                    <td colspan="2"></td>
                    <td colspan="2"></td>
                    <td colspan="2"></td>
                </tr>
            @endforelse
            <tr>
                <td></td>
                <td class="fw-bold" colspan="2">Total</td>
                <td colspan="2"></td>
                <td class="fw-bold" colspan="2">{{  number_format($total,2) }}</td>
            </tr>
            <tr>
                <td class="fw-bold text-capitalize" colspan="3">Budget financing source:</td>
                <td colspan="4"></td>
            </tr>
            <tr class="fw-bold text-capitalize">
                <td>Cost center</td>
                <td>Project</td>
                <td>Donor</td>
                <td>Project category</td>
                <td class="px-5">Budget Category</td>
                <td>Activity</td>
                <td>Sub activity</td>
            </tr>
                
            <tr class="text-capitalize">
                <td>{{ $paymentReq['cost_center']['cost_center_name'] }}</td>
                <td>{{ $paymentReq['related_document_request']['related_project_document']['related_project']['project_name'] }}</td>
                <td></td>
                <td></td>
                <td>{{ $paymentReq['budget_category'] }}</td>
                <td>{{ $paymentReq['related_activity'] ? $paymentReq['related_activity']['activity_name'] : null }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <div>&nbsp;</div>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td colspan="4">
                    <span class="text-capitalize "><span class="fw-bold">Requested By:</span> {{ $paymentReq['related_document_request']['added_by']['first_name']  }} 
                        {{ $paymentReq['related_document_request']['added_by']['last_name']}}</span>
                </td>
                <td colspan="4">
                    {{-- Don't delete --}}
                </td>   
                <td colspan="4">
                    <span class="text-capitalize"><span class="fw-bold">Date:</span> {{ date('d/m/Y', strtotime($paymentReq['related_document_request']['date_added']))}} </span>
                </td>   
            </tr>
            @foreach($paymentReq['approval_steps'] as $approver)
            <tr>
                <td colspan="4">
                    <div class="col-3 fs-6">
                        @if($approver['related_document_approval_step']['approval_step_name'] == "REVIEW")
                            <div>
                                <span class="fw-bold text-capitalize">Reviewed by:</span> 
                                @if ($approver['approval_comment'])
                                    <span class="text-muted">
                                        {{ $approver['related_approver']['related_user']['first_name'] }} 
                                        {{ $approver['related_approver']['related_user']['last_name'] }}
                                    </span>
                                @endif
                            </div>
                        @elseif($approver['related_document_approval_step']['approval_step_name'] == "VERIFICATION")
                            <div>
                                <span class="fw-bold text-capitalize">Verified by:</span>
                                @if ($approver['approval_comment'])
                                    <span>
                                        {{ $approver['related_approver']['related_user']['first_name'] }} 
                                        {{ $approver['related_approver']['related_user']['last_name'] }}
                                    </span>
                                @endif
                            </div>    
                        @elseif($approver['related_document_approval_step']['approval_step_name'] == "APPROVAL")
                            <div>
                                <span class="fw-bold text-capitalize">Approved by:</span>
                                @if ($approver['approval_comment'])
                                    <span>
                                        {{ $approver['related_approver']['related_user']['first_name'] }} 
                                        {{ $approver['related_approver']['related_user']['last_name'] }}
                                    </span>
                                @endif
                            </div>    
                        @elseif($approver['related_document_approval_step']['approval_step_name'] == "AUTHORISATION")
                            <div>
                                <span class="fw-bold text-capitalize">Authorized by:</span>
                                @if ($approver['approval_comment'])
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
                    <div class="col-3 fs-6">
                        <div class="text-capitalize">{{ \Str::ucfirst(\Str::lower($approver['generic_role_name'])) }}</div>
                    </div>
                </td>
                <td colspan="4">
                    <div class="fs-6">
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