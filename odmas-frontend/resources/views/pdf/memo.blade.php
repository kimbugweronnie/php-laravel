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
                width: 100%;
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
                    <div>{{ $memo['related_document_request']['related_project_document']['related_project']['project_name'] }}</div> 
                    <div>{{ $memo['related_document_request']['related_project_document']['order_number'] }}</div>
                </div>  
            </div>
            <div>&nbsp;</div>
            <div>&nbsp;</div>
            <div class="py-1 fs-6"><span class="fw-bold">Date:</span> {{ Carbon\Carbon::parse($memo['date'])->format('d/m/Y') }}</div>
            <div>&nbsp;</div>
            <div class="py-1 fs-6"><span class="fw-bold">To:</span> {{ $memo['to']['related_user']['first_name'] }} {{ $memo['to']['related_user']['last_name'] }}</div>
            <div class="py-1 fs-6"><span class="fw-bold">Thru: <br /></span> 
                @foreach($memo['meta_fields'] as $personsThru)
                    <span>- {{  $personsThru['persons_through']['role']  ? \Str::ucfirst(\Str::lower($personsThru['persons_through']['role']))  : null }},<br /></span>
                @endforeach
            </div>
            <div>&nbsp;</div>
            <div class="py-1 fs-6"><span class="fw-bold">From:</span>  {{ $memo['related_document_request']['added_by']['first_name']}}  {{ $memo['related_document_request']['added_by']['last_name']}}</div>
            <div>&nbsp;</div>
            <div class="pt-4 pb-1 fs-6"><span class="fw-bold">Title:</span> {{ $memo['title'] }}</div><br />
            <div class="py-1 fs-6"><span class="fw-bold">Background:</span><br /> {{ $memo['background'] }}</div><br />
            <div class="py-1  fs-6"><span class="fw-bold">Purpose:</span><br /> {{ $memo['purpose'] }}</div>
            <div>&nbsp;</div>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td colspan="4">
                            <span class="text-capitalize"><span class="fw-bold">Requested By:</span> <br />
                            {{ $memo['related_document_request']['added_by']['first_name'] }} 
                                {{ $memo['related_document_request']['added_by']['last_name']}}</span>
                        </td>
                        <td colspan="4">
                            {{-- Don't delete --}}
                        </td>   
                        <td colspan="4">
                            <span class="text-capitalize"><span class="fw-bold">Date:</span> {{ date('d/m/Y', strtotime($memo['related_document_request']['date_added'])) }} </span>
                        </td>   
                    </tr>
                    @foreach($memo['approval_steps'] as $approver)
                        <tr>
                            <td colspan="4">
                                <div class="col-3">
                                    @if($approver['related_document_approval_step']['approval_step_name'] == "REVIEW")
                                        <div>
                                            <span class="fw-bold text-capitalize">Reviewed By:</span><br />
                                            @if($approver['approval_comment'])
                                                <span>
                                                    {{ $approver['related_approver']['related_user']['first_name'] }} 
                                                    {{ $approver['related_approver']['related_user']['last_name'] }}
                                                </span>
                                            @endif
                                        </div> 
                                    @elseif($approver['related_document_approval_step']['approval_step_name'] == "VERIFICATION")
                                        <div>
                                            <span class="fw-bold text-capitalize">Verified By:</span> <br />
                                            @if($approver['approval_comment'])
                                                <span>
                                                    {{ $approver['related_approver']['related_user']['first_name'] }} 
                                                    {{ $approver['related_approver']['related_user']['last_name'] }}
                                                </span>
                                            @endif
                                        </div> 
                                    @elseif($approver['related_document_approval_step']['approval_step_name'] == "APPROVAL")
                                        <div>
                                            <span class="fw-bold text-capitalize">Approved By:</span> <br />
                                            @if($approver['approval_comment'])
                                                <span>
                                                    {{ $approver['related_approver']['related_user']['first_name'] }} 
                                                    {{ $approver['related_approver']['related_user']['last_name'] }}
                                                </span>
                                            @endif
                                            
                                        </div>
                                    @elseif($approver['related_document_approval_step']['approval_step_name'] == "AUTHORISATION")
                                        <div>
                                            <span class="fw-bold text-capitalize">Authorized By:</span> <br />
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