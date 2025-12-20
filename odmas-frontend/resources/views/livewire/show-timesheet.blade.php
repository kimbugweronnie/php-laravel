@push('styles')
    <style>
        table, th, td {
            border: 2px solid #0a0a0a !important;
            font-size: 10px;
            padding: 0.6em;
        }
        .vertical-text {
            writing-mode: vertical-rl;
            text-orientation: mixed;
            
        }
    </style>
@endpush
<div class="container-fluid p-0">
    <div class="row mb-3">
        <div class="col-lg-12 d-flex justify-content-between">
            <div class="col-6">
                <a class="btn btn-outline-secondary"  href="{{ route('user.timesheets') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-left mb-1" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0v-2z"/>
                        <path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                    </svg>
                    Back
                </a>
            </div>
            <div  class="row row-cols-lg-auto g-3 align-items-center">
                <div class="col-6">
                    <a class="btn btn-outline-secondary" id="openPdfLink"  href="{{ route('timesheet.pdf',[$timesheet['data']['month'],$timesheet['data']['year'],$timesheetRequest['related_document_request']['id']]) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer me-2" viewBox="0 0 16 16">
                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/>
                            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1"/>
                        </svg>
                        Print
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row"> 
        <div class="col-lg-12">
            <div class="border bg-white rounded-3 shadow p-4" style="overflow-x: auto">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="35">
                                <div class="fs-4 text-uppercase fw-bold text-center pb-3">
                                    <div><img src="{{ asset('img/full-logo.png') }}" width="140" alt=" timesheet image"></div>
                                    <div>Uganda episcopal conference</div>
                                    <div>Uganda catholic secretariat</div>
                                    <div>Uganda Catholic medical bureau</div>
                                    <div>Time Sheet </div>
                                    <div>Monthly Time Report For {{ $timesheet['data']['month'] }} {{ $timesheet['data']['year'] }}
                                    </div>

                                </div>
                                <div>
                                    <div class="row mb-3">
                                        <div class="col-3">
                                            <div class="fs-4 text-capitalize"><span class="fw-bold">Name:</span>
                                                {{ $timesheet['data']['related_user']['first_name'] }}
                                                {{ $timesheet['data']['related_user']['last_name'] }}</div>
                                        </div>
                                        <div class="col-3">
                                            <div class="fs-4 text-capitalize"><span class="fw-bold">Location:</span> UCS</div>
                                        </div>
                                        <div class="col-3">
                                            <div class="fs-4 text-capitalize"><span class="fw-bold">Department:</span>
                                                {{ $timesheet['data']['related_department']['department_name'] }}</div>
                                        </div>
                                        <div class="col-3">
                                            <div class="fs-4 text-capitalize"><span class="fw-bold">Period:</span>
                                                {{ $timesheet['data']['month'] }} {{ $timesheet['data']['year'] }}</div>
                                        </div>
                                    </div>
                                    <div class="fs-4 mb-3 text-capitalize"><span class="fw-bold">Job Title:</span>
                                        {{ $timesheet['data']['related_role'] ? $timesheet['data']['related_role']['role_name'] : '' }}
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Activity/Project</td>
                            <td class="text-capitalize">Fund and Project</td>
                            @foreach($days as $day)
                                <td class="vertical-text"><b>{{date('l', strtotime($day['day']))}}</b></td>
                            @endforeach
                            <td rowspan="2" class="text-capitalize"><b>Total Hours</b></td>
                            <td rowspan="2" class="text-capitalize"><b>%age to Charge</b></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            @php
                                $counter = 1;
                            @endphp
                            @foreach($days as $day)
                                <td class=>{{ $counter }}</td>
                            @php
                                $counter++;
                            @endphp  
                            @endforeach
                        </tr>
                        @foreach($activities as $activity)
                            <tr>
                                <td>{{$activity['display_name']}}</td>
                                @if($activity['display_name'] === "Flash Project" || $activity['display_name'] === "IDI-KHP PROJECT")
                                    <td></td>
                                @else
                                    <td></td>
                                @endif
                                @foreach($days as $day)
                                    @if($day['clock_in'] === false)
                                        <td>0</td>
                                    @elseif(!empty($day['timesheet']['timesheet_records']))
                                        <td>{{ $this->getTimeTaken($day['timesheet']['timesheet_records'],$activity['display_name']) }}</td>
                                    @else
                                    <td>0</td>  
                                    @endif
                                @endforeach
                                <td><span class="red-text">{{ $this->getTotalTimeTaken($days,$activity['display_name'])}}</span></td>
                                <td>{{ $this->percentageToChange($days,$activity['display_name']) }} %</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="text-capitalize">Total Hours</td>
                            <td></td>
                            @foreach($days as $day) 
                                @if($day['timesheet'] === false && $day['hours'] > 0)  
                                    <td>{{$day['hours']}}</td>    
                                @else
                                    <td>{{$day['hours']}}</td>
                                @endif 
                            @endforeach
                            <td><span class="red-text">{{ $this->totalHoursTaken($days) }}</span></td>
                            <td>100%</td>
                        </tr>
                        <tr>
                            <td class="text-capitalize">Total expected hours of work</td>
                            <td></td>
                            @foreach($days as $day)
                                @if(strpos($day['day_string'], "Saturday") !== false || strpos($day['day_string'], "Sunday") !== false)
                                    <td>0</td>
                                @else
                                    <td>8</td>
                                @endif
                            @endforeach
                            <td>{{ $this->totalExpectedHours($days) }}</td>
                        </tr>
                        <tr>
                            <td class="text-capitalize">Percentage time worked</td>
                            <td></td>
                            @foreach($days as $day)
                                @if($day['hours'] == 0)
                                    <td>0</td>
                                @else
                                    <td>{{ $this->percentTimeWorked($day)}}</td>
                                @endif
                            @endforeach
                            <td><b>{{ $this->totalHoursPercentage($days)}}%</b></td>
                        </tr>
                    </tbody>
                </table>
                @foreach($timesheetRequest['approval_steps'] as $approver)
                    <div class="row mb-3">
                        <div class="col-4">
                            @if($approver['related_document_approval_step']['approval_step_name'] == "REVIEW")
                                <div class="fs-4 text-capitalize">
                                    <span class="fw-bold">Reviewed by:</span> 
                                    @if ($approver['approval_comment'])
                                        <span class="fw-bold" >
                                            {{ $approver['related_approver']['related_user']['first_name'] }} 
                                            {{ $approver['related_approver']['related_user']['last_name'] }}
                                        </span>
                                    @endif
                                </div>
                            @elseif($approver['related_document_approval_step']['approval_step_name'] == "VERIFICATION")
                                <div class="fs-4 text-capitalize">
                                    <span class="fw-bold">Verified by:</span>
                                    @if ($approver['approval_comment'])
                                        <span class="fw-bold" >
                                            {{ $approver['related_approver']['related_user']['first_name'] }} 
                                            {{ $approver['related_approver']['related_user']['last_name'] }}
                                        </span>
                                    @endif
                                </div>    
                            @elseif($approver['related_document_approval_step']['approval_step_name'] == "APPROVAL")
                                    <div class="fs-4 text-capitalize">
                                    <span class="fw-bold">Approved by:</span>
                                    @if ($approver['approval_comment'])
                                        <span class="fw-bold" >
                                            {{ $approver['related_approver']['related_user']['first_name'] }} 
                                            {{ $approver['related_approver']['related_user']['last_name'] }}
                                        </span>
                                    @endif
                                </div>    
                            @elseif($approver['related_document_approval_step']['approval_step_name'] == "AUTHORISATION")
                                <div class="fs-4 text-capitalize">
                                    <span class="fw-bold">Authorized by:</span>
                                    @if ($approver['approval_comment'])
                                        <span class="fw-bold" >
                                            {{ $approver['related_approver']['related_user']['first_name'] }} 
                                            {{ $approver['related_approver']['related_user']['last_name'] }}
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="col-4">
                            <div class="fs-4 text-capitalize"><span class="fw-bold">Title:</span>  {{ \Str::ucfirst(\Str::lower($approver['generic_role_name'])) }}</div>
                        </div>
                        <div class="fs-4 text-capitalize col-4">
                            @if(strtotime($approver['date_performed']))
                                <span class="fw-bold">Date:</span> {{ date('d/m/Y H:i', strtotime($approver['date_performed']))}} 
                            @else
                                <span class="fw-bold">Date:</span>
                            @endif
                        </div>
                        <div class="row mt-2 mb-3">
                            <div class="col-12 fs-4 text-capitalize">
                                <span class="fw-bold">Comment:</span> 
                                <span>
                                    {{ $approver['approval_comment'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
    </div>
</div>
@push('scripts')
    <script>
    document.getElementById('openPdfLink').addEventListener('click', function (event) {
        event.preventDefault();
        window.open(this.href, '_blank');
    });
</script>
@endpush