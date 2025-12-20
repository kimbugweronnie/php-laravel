@push('styles')
    <style>
        body {
            font-family: 'Intel', sans-serif;
        }
    </style>
@endpush

<div>
    <table>    
        <tbody>
            <tr>
                <th>Activity/Project</th>
                <th style="text-transform: capitalize;">Fund and project</th>
                @foreach($days as $day)
                    <th>
                        <div style="transform: rotate(-90deg);">
                            {{ $this->tranformDay($day) }}
                        </div>            
                    </th>
                @endforeach
                <th rowspan="2" style="text-transform: capitalize;"><b>Total hours</b></th>
                <th rowspan="2" style="text-transform: capitalize;"><b>%age to charge</b></th>
            </tr>
            <tr>
                <td class = "text-center"></td>
                <td class = "text-center"></td>
                @php
                    $counter = 1;
                @endphp
                    @foreach($days as $day)
                    <td class ="text-center">{{ $counter }}</td>
                @php
                    $counter++;
                @endphp  
                @endforeach
            </tr>
            @foreach($activities as $activity)
                <tr>
                    <td class = "text-center">{{$activity['display_name']}}</td>
                    @if($activity['display_name'] === "Flash Project" || $activity['display_name'] === "IDI-KHP PROJECT")
                        <td class = "text-center"></td>
                    @else
                        <td class = "text-center"></td>
                    @endif
                    @foreach($days as $day)
                        @if($day['clock_in'] === false)
                            <td class = "text-center">0</td>
                        @elseif(!empty($day['timesheet']['timesheet_records']))
                            <td class = "text-center">{{ $this->getTimeTaken($day['timesheet']['timesheet_records'],$activity['display_name']) }}</td>
                        @else
                        <td class = "text-center">0</td>  
                        @endif
                    @endforeach
                    <td class = "text-center"><span class="red-text">{{ $this->getTotalTimeTaken($days,$activity['display_name'])}}</span></td>
                    <td class = "text-center">{{ $this->percentageToChange($days,$activity['display_name']) }} %</td>
                </tr>
            @endforeach

            <tr>
                <td class = "text-center" style="text-transform: capitalize;">Total hours</td>
                <td class = "text-center"></td>
                @foreach($days as $day) 
                    @if($day['timesheet'] === false && $day['hours'] > 0)  
                        <td class = "text-center">{{$day['hours']}}</td>    
                    @else
                        <td class = "text-center">{{$day['hours']}}</td>
                    @endif 
                @endforeach
                <td class = "text-center">{{ $this->totalHoursTaken($days) }}</td>
                <td class = "text-center">100%</td>
            </tr>

            <tr>
                <td class = "text-center" style="text-transform: capitalize;">Total expected hours of work</td>
                <td class = "text-center"></td>
                @foreach($days as $day)
                    @if(strpos($day['day_string'], "Saturday") !== false || strpos($day['day_string'], "Sunday") !== false)
                        <td class = "text-center">0</td>
                    @else
                        <td class = "text-center">8</td>
                    @endif
                @endforeach
                <td class = "text-center">{{ $this->totalExpectedHours($days) }}</td>
                <td class = "text-center"></td>
            </tr>
            <tr>
                <td class = "text-center" style="text-transform: capitalize;">Percentage time worked</td>
                <td class = "text-center"></td>
                @foreach($days as $day)
                    @if($day['hours'] == 0)
                        <td class = "text-center">0</td>
                    @else
                        <td class = "text-center">{{ $this->percentTimeWorked($day)}}</td>
                    @endif
                @endforeach
                <td class = "text-center"><b>{{ $this->totalHoursPercentage($days)}}%</b></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <div>&nbsp; </div>
    <div class="text-left mb-3">
        @isset($timesheetapproval)
        @foreach($timesheetapproval as $approver )
            <div class="row mb-3">
                <div class="col-4">
                    @if($approver['related_document_approval_step']['approval_step_name'] == "REVIEW")
                        <div>
                            <span class="fw-bold text-capitalize">Reviewed by:</span> 
                            @if ($approver['approval_comment'])
                                <span>
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
                <div class="col-4">
                    <div class="text-capitalize"><span class="fw-bold text-capitalize">Title:</span>  {{ \Str::ucfirst(\Str::lower($approver['generic_role_name'])) }}</div>
                </div>
                <div class="col-4">
                    @if(strtotime($approver['date_performed']))
                        <span class="fw-bold text-capitalize">Date:</span> {{ date('d/m/Y H:i', strtotime($approver['date_performed']))}} 
                    @else
                        <span class="fw-bold text-capitalize">Date:</span>
                    @endif
                </div>
                <div class="row mt-2 mb-3">
                    <div class="col-12">
                        <span class="fw-bold text-capitalize">Comment:</span> 
                        <span>
                            {{ $approver['approval_comment'] }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
        @endisset
    </div>
</div>