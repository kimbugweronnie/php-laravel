<html>
    <head>
    <style>
        body {
            font-family: 'Intel', sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            
        }
        th {
            border: 1px solid black;
            font-size: 7px;
            padding-bottom: 10px;
            padding-top: 10px;
            padding-left: 0;
            padding-right: 0;
        }
        td {
            border: 1px solid black;
            font-size: 7px;
            padding-top: 7px;
            padding-bottom: 2px;
            padding-left: 0;
            padding-right: 0;
        }
        .text-center {
            text-align: center;
        }
        .space{
            margin-right: 50px; 
        }
        .pb-4 {
            padding-bottom: 1rem;
        }
    </style>
</head>

    <body>
        <div class="col-lg-12"> 
            <div class="fs-4 text-uppercase fw-bold text-center mb-3" style="font-weight: bold; text-transform: uppercase; margin-bottom: 20px;">
                <div class="me-4" style="display: inline-block;"><img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/full-logo.png'))) }}" width="120"></div>
                <div>Uganda episcopal conference</div> 
                <div>Uganda catholic secretariat</div>
                <div>Uganda Catholic medical bureau</div>
                <div>Time Sheet </div> 
                <div>Monthly Time Report For {{ $timesheet['data']['month'] }} {{$timesheet['data']['year'] }}</div>
            </div>
            <div class="text-left mb-3">
                <div class="fs-8 text-capitalize"> <span style="font-weight: bold;">Name:</span> {{ $timesheet['data']['related_user']['first_name'] }} {{ $timesheet['data']['related_user']['last_name'] }}
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-muted "><span style="font-weight: bold;">Location:</span> UCS</span> 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">Department:</span> {{ $timesheet['data']['related_department']['department_name'] }}
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span style="font-weight: bold;">Period</span>: {{$timesheet['data']['month'] }} {{$timesheet['data']['year'] }}
                </div>
            </div>
            <div style="display: inline-block;">
             <div>&nbsp;</div>
                <div class="fs-8 text-uppercase fw-bold"> <span style="font-weight: bold;">Job Title:</span> {{ $timesheet['data']['related_role'] ? $timesheet['data']['related_role']['role_name']: ''}}</div> 
            </div>
            <div>&nbsp;</div>
            <div class="col-lg-12">
                <div class="row">
                    <livewire:timesheet-pdf :month="$timesheet['data']['month']" :year="$timesheet['data']['year']" />
                </div>
            </div>
            <div class="text-left mb-3">
                @foreach($timesheetapproval as $approver )
                    <div class="fs-8 text-capitalize"> <span style="font-weight: bold;">Reviewed by:</span>
                        @if ($approver['approval_comment'])
                            <span>
                                {{ $approver['related_approver']['related_user']['first_name'] }} 
                                {{ $approver['related_approver']['related_user']['last_name'] }}
                            </span>
                        @endif
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-muted "><span style="font-weight: bold;">Title:</span>{{ \Str::ucfirst(\Str::lower($approver['generic_role_name'])) }}</span> 
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        @if(strtotime($approver['date_performed']))
                        <span class="fw-bold text-capitalize">Date:</span> {{ date('d/m/Y', strtotime($approver['date_performed']))}} 
                        @else
                            <span class="fw-bold text-capitalize">Date:</span>
                        @endif
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;            
                    </div>
                @endforeach
            </div>
        </div>
    </body>
</html>