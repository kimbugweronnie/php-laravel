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
            </div>
        </div>
        @if (Session::has('userDetails') &&
                Session::get('userDetails')['id'] != $timesheetRequest['related_document_request']['added_by']['id']
        )
            <div class="col-lg-12 mt-5">
                @include('messages.flash')
                <div class="border bg-white rounded-3 shadow p-4">
                    @foreach ($timesheetRequest['approval_steps'] as $approver)
                        <div class="row mt-2">
                            <div class="col-6 fs-4">
                                @if ($approver['related_document_approval_step']['approval_step_name'] == 'VERIFICATION')
                                    <span class="fw-bold text-capitalize">Verified by:</span>
                                @elseif($approver['related_document_approval_step']['approval_step_name'] == 'REVIEW')
                                    <span class="fw-bold text-capitalize">Reviewed by:</span>
                                @elseif($approver['related_document_approval_step']['approval_step_name'] == 'VERIFICATION')
                                    <span class="fw-bold text-capitalize">Verified by:</span>
                                @elseif($approver['related_document_approval_step']['approval_step_name'] == 'APPROVAL')
                                    <span class="fw-bold text-capitalize">Approved by:</span>
                                @elseif($approver['related_document_approval_step']['approval_step_name'] == 'AUTHORISATION')
                                    <span class="fw-bold text-capitalize">Authorized by:</span>
                                @endif
                                {{ $approver['related_approver']['related_user']['first_name'] }}
                                {{ $approver['related_approver']['related_user']['last_name'] }}
                            </div>
                            <div class="col-6 fs-4">
                                <span
                                    class="fw-bold text-capitalize">{{ Str::lower($approver['generic_role_name']) }}</span>
                            </div>
                            <div class="col-12">
                                @if (
                                    $approver['next_step'] &&
                                        !$approver['status'] &&
                                        Session::get('userDetails')['id'] == $approver['related_approver']['related_user']['id']
                                )
                                    <div class="mt-2">
                                        <form>
                                            <div>
                                                <label class="mb-2 fw-bold" for="comment">Comment</label>
                                                <textarea wire:model="comment" class="form-control" cols="30" rows="4" required></textarea>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            </div>
                            <div class="col-12">
                                @if (
                                    $approver['next_step'] &&
                                        !$approver['status'] &&
                                        $approver['next_step'] &&
                                        Session::get('userDetails')['id'] == $approver['related_approver']['related_user']['id']
                                )
                                    <div class="d-flex justify-content-start">

                                        <form wire:submit="approveRequest">
                                            <div>
                                                <input wire:model="approval_step_id" type="hidden">
                                                <input wire:model="relatedDocumentApprovalStep" type="hidden">
                                            </div>
                                            <div class="pt-2">
                                                <button type="submit"
                                                    class="btn btn-outline-primary text-capitalize px-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor"
                                                        class="bi bi-fingerprint me-2" viewBox="0 0 16 16">
                                                        <path
                                                            d="M8.06 6.5a.5.5 0 0 1 .5.5v.776a11.5 11.5 0 0 1-.552 3.519l-1.331 4.14a.5.5 0 0 1-.952-.305l1.33-4.141a10.5 10.5 0 0 0 .504-3.213V7a.5.5 0 0 1 .5-.5Z" />
                                                        <path
                                                            d="M6.06 7a2 2 0 1 1 4 0 .5.5 0 1 1-1 0 1 1 0 1 0-2 0v.332c0 .409-.022.816-.066 1.221A.5.5 0 0 1 6 8.447c.04-.37.06-.742.06-1.115zm3.509 1a.5.5 0 0 1 .487.513 11.5 11.5 0 0 1-.587 3.339l-1.266 3.8a.5.5 0 0 1-.949-.317l1.267-3.8a10.5 10.5 0 0 0 .535-3.048A.5.5 0 0 1 9.569 8Zm-3.356 2.115a.5.5 0 0 1 .33.626L5.24 14.939a.5.5 0 1 1-.955-.296l1.303-4.199a.5.5 0 0 1 .625-.329Z" />
                                                        <path
                                                            d="M4.759 5.833A3.501 3.501 0 0 1 11.559 7a.5.5 0 0 1-1 0 2.5 2.5 0 0 0-4.857-.833.5.5 0 1 1-.943-.334Zm.3 1.67a.5.5 0 0 1 .449.546 10.72 10.72 0 0 1-.4 2.031l-1.222 4.072a.5.5 0 1 1-.958-.287L4.15 9.793a9.72 9.72 0 0 0 .363-1.842.5.5 0 0 1 .546-.449Zm6 .647a.5.5 0 0 1 .5.5c0 1.28-.213 2.552-.632 3.762l-1.09 3.145a.5.5 0 0 1-.944-.327l1.089-3.145c.382-1.105.578-2.266.578-3.435a.5.5 0 0 1 .5-.5Z" />
                                                        <path
                                                            d="M3.902 4.222a4.996 4.996 0 0 1 5.202-2.113.5.5 0 0 1-.208.979 3.996 3.996 0 0 0-4.163 1.69.5.5 0 0 1-.831-.556Zm6.72-.955a.5.5 0 0 1 .705-.052A4.99 4.99 0 0 1 13.059 7v1.5a.5.5 0 1 1-1 0V7a3.99 3.99 0 0 0-1.386-3.028.5.5 0 0 1-.051-.705ZM3.68 5.842a.5.5 0 0 1 .422.568c-.029.192-.044.39-.044.59 0 .71-.1 1.417-.298 2.1l-1.14 3.923a.5.5 0 1 1-.96-.279L2.8 8.821A6.531 6.531 0 0 0 3.058 7c0-.25.019-.496.054-.736a.5.5 0 0 1 .568-.422Zm8.882 3.66a.5.5 0 0 1 .456.54c-.084 1-.298 1.986-.64 2.934l-.744 2.068a.5.5 0 0 1-.941-.338l.745-2.07a10.51 10.51 0 0 0 .584-2.678.5.5 0 0 1 .54-.456Z" />
                                                        <path
                                                            d="M4.81 1.37A6.5 6.5 0 0 1 14.56 7a.5.5 0 1 1-1 0 5.5 5.5 0 0 0-8.25-4.765.5.5 0 0 1-.5-.865Zm-.89 1.257a.5.5 0 0 1 .04.706A5.478 5.478 0 0 0 2.56 7a.5.5 0 0 1-1 0c0-1.664.626-3.184 1.655-4.333a.5.5 0 0 1 .706-.04ZM1.915 8.02a.5.5 0 0 1 .346.616l-.779 2.767a.5.5 0 1 1-.962-.27l.778-2.767a.5.5 0 0 1 .617-.346Zm12.15.481a.5.5 0 0 1 .49.51c-.03 1.499-.161 3.025-.727 4.533l-.07.187a.5.5 0 0 1-.936-.351l.07-.187c.506-1.35.634-2.74.663-4.202a.5.5 0 0 1 .51-.49" />
                                                    </svg>
                                                    @if ($approver['related_document_approval_step']['approval_step_name'] == 'VERIFICATION')
                                                        <span class="fw-bold text-capitalize">Verify</span>
                                                    @elseif($approver['related_document_approval_step']['approval_step_name'] == 'REVIEW')
                                                        <span class="fw-bold text-capitalize">Review</span>
                                                    @elseif($approver['related_document_approval_step']['approval_step_name'] == 'APPROVAL')
                                                        <span class="fw-bold text-capitalize">Approve</span>
                                                    @elseif($approver['related_document_approval_step']['approval_step_name'] == 'AUTHORISATION')
                                                        <span class="fw-bold text-capitalize">Authorize</span>
                                                    @endif
                                                </button>
                                            </div>
                                        </form>
                                        <form wire:submit="ReferBackRequest">
                                            <div>
                                                <input wire:model="approval_step_id" type="hidden">
                                                <input wire:model="relatedDocumentApprovalStep" type="hidden">
                                            </div>
                                            <div class="pt-2">
                                                <button type="submit"
                                                    class="btn btn-outline-primary text-capitalize ms-4 px-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor"
                                                        class="bi bi-fingerprint me-2" viewBox="0 0 16 16">
                                                        <path
                                                            d="M8.06 6.5a.5.5 0 0 1 .5.5v.776a11.5 11.5 0 0 1-.552 3.519l-1.331 4.14a.5.5 0 0 1-.952-.305l1.33-4.141a10.5 10.5 0 0 0 .504-3.213V7a.5.5 0 0 1 .5-.5Z" />
                                                        <path
                                                            d="M6.06 7a2 2 0 1 1 4 0 .5.5 0 1 1-1 0 1 1 0 1 0-2 0v.332c0 .409-.022.816-.066 1.221A.5.5 0 0 1 6 8.447c.04-.37.06-.742.06-1.115zm3.509 1a.5.5 0 0 1 .487.513 11.5 11.5 0 0 1-.587 3.339l-1.266 3.8a.5.5 0 0 1-.949-.317l1.267-3.8a10.5 10.5 0 0 0 .535-3.048A.5.5 0 0 1 9.569 8Zm-3.356 2.115a.5.5 0 0 1 .33.626L5.24 14.939a.5.5 0 1 1-.955-.296l1.303-4.199a.5.5 0 0 1 .625-.329Z" />
                                                        <path
                                                            d="M4.759 5.833A3.501 3.501 0 0 1 11.559 7a.5.5 0 0 1-1 0 2.5 2.5 0 0 0-4.857-.833.5.5 0 1 1-.943-.334Zm.3 1.67a.5.5 0 0 1 .449.546 10.72 10.72 0 0 1-.4 2.031l-1.222 4.072a.5.5 0 1 1-.958-.287L4.15 9.793a9.72 9.72 0 0 0 .363-1.842.5.5 0 0 1 .546-.449Zm6 .647a.5.5 0 0 1 .5.5c0 1.28-.213 2.552-.632 3.762l-1.09 3.145a.5.5 0 0 1-.944-.327l1.089-3.145c.382-1.105.578-2.266.578-3.435a.5.5 0 0 1 .5-.5Z" />
                                                        <path
                                                            d="M3.902 4.222a4.996 4.996 0 0 1 5.202-2.113.5.5 0 0 1-.208.979 3.996 3.996 0 0 0-4.163 1.69.5.5 0 0 1-.831-.556Zm6.72-.955a.5.5 0 0 1 .705-.052A4.99 4.99 0 0 1 13.059 7v1.5a.5.5 0 1 1-1 0V7a3.99 3.99 0 0 0-1.386-3.028.5.5 0 0 1-.051-.705ZM3.68 5.842a.5.5 0 0 1 .422.568c-.029.192-.044.39-.044.59 0 .71-.1 1.417-.298 2.1l-1.14 3.923a.5.5 0 1 1-.96-.279L2.8 8.821A6.531 6.531 0 0 0 3.058 7c0-.25.019-.496.054-.736a.5.5 0 0 1 .568-.422Zm8.882 3.66a.5.5 0 0 1 .456.54c-.084 1-.298 1.986-.64 2.934l-.744 2.068a.5.5 0 0 1-.941-.338l.745-2.07a10.51 10.51 0 0 0 .584-2.678.5.5 0 0 1 .54-.456Z" />
                                                        <path
                                                            d="M4.81 1.37A6.5 6.5 0 0 1 14.56 7a.5.5 0 1 1-1 0 5.5 5.5 0 0 0-8.25-4.765.5.5 0 0 1-.5-.865Zm-.89 1.257a.5.5 0 0 1 .04.706A5.478 5.478 0 0 0 2.56 7a.5.5 0 0 1-1 0c0-1.664.626-3.184 1.655-4.333a.5.5 0 0 1 .706-.04ZM1.915 8.02a.5.5 0 0 1 .346.616l-.779 2.767a.5.5 0 1 1-.962-.27l.778-2.767a.5.5 0 0 1 .617-.346Zm12.15.481a.5.5 0 0 1 .49.51c-.03 1.499-.161 3.025-.727 4.533l-.07.187a.5.5 0 0 1-.936-.351l.07-.187c.506-1.35.634-2.74.663-4.202a.5.5 0 0 1 .51-.49" />
                                                    </svg>
                                                    @if ($approver['related_document_approval_step']['approval_step_name'] == 'VERIFICATION')
                                                        <span class="fw-bold text-capitalize">Refer Back</span>
                                                    @elseif($approver['related_document_approval_step']['approval_step_name'] == 'REVIEW')
                                                        <span class="fw-bold text-capitalize">Refer Back</span>
                                                    @elseif($approver['related_document_approval_step']['approval_step_name'] == 'APPROVAL')
                                                        <span class="fw-bold text-capitalize">Refer Back</span>
                                                    @elseif($approver['related_document_approval_step']['approval_step_name'] == 'AUTHORISATION')
                                                        <span class="fw-bold text-capitalize">Refer Back</span>
                                                    @endif
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @elseif ($approver['status'])
                                    <div class="d-flex justify-content-start">
                                        @if ($approver['date_performed'])
                                            <div class="pt-2">
                                                <button type="submit"
                                                    class="btn btn-outline-primary text-capitalize px-2" disabled>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                        height="18" fill="currentColor" class="bi bi-check-all"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M8.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992zm-.92 5.14.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486z" />
                                                    </svg>
                                                    @if ($approver['related_document_approval_step']['approval_step_name'] == 'VERIFICATION')
                                                        <span class="fw-bold text-capitalize">Verified</span>
                                                    @elseif($approver['related_document_approval_step']['approval_step_name'] == 'REVIEW')
                                                        <span class="fw-bold text-capitalize">Reviewed</span>
                                                    @elseif($approver['related_document_approval_step']['approval_step_name'] == 'APPROVAL')
                                                        <span class="fw-bold text-capitalize">Approved</span>
                                                    @elseif($approver['related_document_approval_step']['approval_step_name'] == 'AUTHORISATION')
                                                        <span class="fw-bold text-capitalize">Authorized</span>
                                                    @endif
                                                </button>
                                            </div>
                                        @endif
                                        @if (!$approver['date_performed'])
                                            <div class="pt-2">
                                                <button type="submit"
                                                    class="btn btn-outline-primary text-capitalize ms-4 px-3" disabled>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor"
                                                        class="bi bi-fingerprint me-2" viewBox="0 0 16 16">
                                                        <path
                                                            d="M8.06 6.5a.5.5 0 0 1 .5.5v.776a11.5 11.5 0 0 1-.552 3.519l-1.331 4.14a.5.5 0 0 1-.952-.305l1.33-4.141a10.5 10.5 0 0 0 .504-3.213V7a.5.5 0 0 1 .5-.5Z" />
                                                        <path
                                                            d="M6.06 7a2 2 0 1 1 4 0 .5.5 0 1 1-1 0 1 1 0 1 0-2 0v.332c0 .409-.022.816-.066 1.221A.5.5 0 0 1 6 8.447c.04-.37.06-.742.06-1.115zm3.509 1a.5.5 0 0 1 .487.513 11.5 11.5 0 0 1-.587 3.339l-1.266 3.8a.5.5 0 0 1-.949-.317l1.267-3.8a10.5 10.5 0 0 0 .535-3.048A.5.5 0 0 1 9.569 8Zm-3.356 2.115a.5.5 0 0 1 .33.626L5.24 14.939a.5.5 0 1 1-.955-.296l1.303-4.199a.5.5 0 0 1 .625-.329Z" />
                                                        <path
                                                            d="M4.759 5.833A3.501 3.501 0 0 1 11.559 7a.5.5 0 0 1-1 0 2.5 2.5 0 0 0-4.857-.833.5.5 0 1 1-.943-.334Zm.3 1.67a.5.5 0 0 1 .449.546 10.72 10.72 0 0 1-.4 2.031l-1.222 4.072a.5.5 0 1 1-.958-.287L4.15 9.793a9.72 9.72 0 0 0 .363-1.842.5.5 0 0 1 .546-.449Zm6 .647a.5.5 0 0 1 .5.5c0 1.28-.213 2.552-.632 3.762l-1.09 3.145a.5.5 0 0 1-.944-.327l1.089-3.145c.382-1.105.578-2.266.578-3.435a.5.5 0 0 1 .5-.5Z" />
                                                        <path
                                                            d="M3.902 4.222a4.996 4.996 0 0 1 5.202-2.113.5.5 0 0 1-.208.979 3.996 3.996 0 0 0-4.163 1.69.5.5 0 0 1-.831-.556Zm6.72-.955a.5.5 0 0 1 .705-.052A4.99 4.99 0 0 1 13.059 7v1.5a.5.5 0 1 1-1 0V7a3.99 3.99 0 0 0-1.386-3.028.5.5 0 0 1-.051-.705ZM3.68 5.842a.5.5 0 0 1 .422.568c-.029.192-.044.39-.044.59 0 .71-.1 1.417-.298 2.1l-1.14 3.923a.5.5 0 1 1-.96-.279L2.8 8.821A6.531 6.531 0 0 0 3.058 7c0-.25.019-.496.054-.736a.5.5 0 0 1 .568-.422Zm8.882 3.66a.5.5 0 0 1 .456.54c-.084 1-.298 1.986-.64 2.934l-.744 2.068a.5.5 0 0 1-.941-.338l.745-2.07a10.51 10.51 0 0 0 .584-2.678.5.5 0 0 1 .54-.456Z" />
                                                        <path
                                                            d="M4.81 1.37A6.5 6.5 0 0 1 14.56 7a.5.5 0 1 1-1 0 5.5 5.5 0 0 0-8.25-4.765.5.5 0 0 1-.5-.865Zm-.89 1.257a.5.5 0 0 1 .04.706A5.478 5.478 0 0 0 2.56 7a.5.5 0 0 1-1 0c0-1.664.626-3.184 1.655-4.333a.5.5 0 0 1 .706-.04ZM1.915 8.02a.5.5 0 0 1 .346.616l-.779 2.767a.5.5 0 1 1-.962-.27l.778-2.767a.5.5 0 0 1 .617-.346Zm12.15.481a.5.5 0 0 1 .49.51c-.03 1.499-.161 3.025-.727 4.533l-.07.187a.5.5 0 0 1-.936-.351l.07-.187c.506-1.35.634-2.74.663-4.202a.5.5 0 0 1 .51-.49" />
                                                    </svg>
                                                    @if ($approver['related_document_approval_step']['approval_step_name'] == 'VERIFICATION')
                                                        <span class="fw-bold text-capitalize">Referred Back</span>
                                                    @elseif($approver['related_document_approval_step']['approval_step_name'] == 'REVIEW')
                                                        <span class="fw-bold text-capitalize">Referred Back</span>
                                                    @elseif($approver['related_document_approval_step']['approval_step_name'] == 'APPROVAL')
                                                        <span class="fw-bold text-capitalize">Referred Back</span>
                                                    @elseif($approver['related_document_approval_step']['approval_step_name'] == 'AUTHORISATION')
                                                        <span class="fw-bold text-capitalize">Referred Back</span>
                                                    @endif
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="my-2 mb-3">
                                        <span class="fw-bold">Comment:</span> {{ $approver['approval_comment'] }}
                                    </div>
                                @else
                                    <div class="pt-2">
                                        <button type="button" id="blur"
                                            class="btn btn-outline-primary text-capitalize px-3" disabled>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-fingerprint me-2"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M8.06 6.5a.5.5 0 0 1 .5.5v.776a11.5 11.5 0 0 1-.552 3.519l-1.331 4.14a.5.5 0 0 1-.952-.305l1.33-4.141a10.5 10.5 0 0 0 .504-3.213V7a.5.5 0 0 1 .5-.5Z" />
                                                <path
                                                    d="M6.06 7a2 2 0 1 1 4 0 .5.5 0 1 1-1 0 1 1 0 1 0-2 0v.332c0 .409-.022.816-.066 1.221A.5.5 0 0 1 6 8.447c.04-.37.06-.742.06-1.115zm3.509 1a.5.5 0 0 1 .487.513 11.5 11.5 0 0 1-.587 3.339l-1.266 3.8a.5.5 0 0 1-.949-.317l1.267-3.8a10.5 10.5 0 0 0 .535-3.048A.5.5 0 0 1 9.569 8Zm-3.356 2.115a.5.5 0 0 1 .33.626L5.24 14.939a.5.5 0 1 1-.955-.296l1.303-4.199a.5.5 0 0 1 .625-.329Z" />
                                                <path
                                                    d="M4.759 5.833A3.501 3.501 0 0 1 11.559 7a.5.5 0 0 1-1 0 2.5 2.5 0 0 0-4.857-.833.5.5 0 1 1-.943-.334Zm.3 1.67a.5.5 0 0 1 .449.546 10.72 10.72 0 0 1-.4 2.031l-1.222 4.072a.5.5 0 1 1-.958-.287L4.15 9.793a9.72 9.72 0 0 0 .363-1.842.5.5 0 0 1 .546-.449Zm6 .647a.5.5 0 0 1 .5.5c0 1.28-.213 2.552-.632 3.762l-1.09 3.145a.5.5 0 0 1-.944-.327l1.089-3.145c.382-1.105.578-2.266.578-3.435a.5.5 0 0 1 .5-.5Z" />
                                                <path
                                                    d="M3.902 4.222a4.996 4.996 0 0 1 5.202-2.113.5.5 0 0 1-.208.979 3.996 3.996 0 0 0-4.163 1.69.5.5 0 0 1-.831-.556Zm6.72-.955a.5.5 0 0 1 .705-.052A4.99 4.99 0 0 1 13.059 7v1.5a.5.5 0 1 1-1 0V7a3.99 3.99 0 0 0-1.386-3.028.5.5 0 0 1-.051-.705ZM3.68 5.842a.5.5 0 0 1 .422.568c-.029.192-.044.39-.044.59 0 .71-.1 1.417-.298 2.1l-1.14 3.923a.5.5 0 1 1-.96-.279L2.8 8.821A6.531 6.531 0 0 0 3.058 7c0-.25.019-.496.054-.736a.5.5 0 0 1 .568-.422Zm8.882 3.66a.5.5 0 0 1 .456.54c-.084 1-.298 1.986-.64 2.934l-.744 2.068a.5.5 0 0 1-.941-.338l.745-2.07a10.51 10.51 0 0 0 .584-2.678.5.5 0 0 1 .54-.456Z" />
                                                <path
                                                    d="M4.81 1.37A6.5 6.5 0 0 1 14.56 7a.5.5 0 1 1-1 0 5.5 5.5 0 0 0-8.25-4.765.5.5 0 0 1-.5-.865Zm-.89 1.257a.5.5 0 0 1 .04.706A5.478 5.478 0 0 0 2.56 7a.5.5 0 0 1-1 0c0-1.664.626-3.184 1.655-4.333a.5.5 0 0 1 .706-.04ZM1.915 8.02a.5.5 0 0 1 .346.616l-.779 2.767a.5.5 0 1 1-.962-.27l.778-2.767a.5.5 0 0 1 .617-.346Zm12.15.481a.5.5 0 0 1 .49.51c-.03 1.499-.161 3.025-.727 4.533l-.07.187a.5.5 0 0 1-.936-.351l.07-.187c.506-1.35.634-2.74.663-4.202a.5.5 0 0 1 .51-.49" />
                                            </svg>
                                            @if ($approver['related_document_approval_step']['approval_step_name'] == 'VERIFICATION')
                                                <span class="fw-bold text-capitalize">Verify</span>
                                            @elseif($approver['related_document_approval_step']['approval_step_name'] == 'REVIEW')
                                                <span class="fw-bold text-capitalize">Review</span>
                                            @elseif($approver['related_document_approval_step']['approval_step_name'] == 'APPROVAL')
                                                <span class="fw-bold text-capitalize">Approve</span>
                                            @elseif($approver['related_document_approval_step']['approval_step_name'] == 'AUTHORISATION')
                                                <span class="fw-bold text-capitalize">Authorize</span>
                                            @endif
                                        </button>

                                        <button type="button" id="blur"
                                            class="btn btn-outline-primary text-capitalize ms-4 px-3" disabled>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-fingerprint me-2"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M8.06 6.5a.5.5 0 0 1 .5.5v.776a11.5 11.5 0 0 1-.552 3.519l-1.331 4.14a.5.5 0 0 1-.952-.305l1.33-4.141a10.5 10.5 0 0 0 .504-3.213V7a.5.5 0 0 1 .5-.5Z" />
                                                <path
                                                    d="M6.06 7a2 2 0 1 1 4 0 .5.5 0 1 1-1 0 1 1 0 1 0-2 0v.332c0 .409-.022.816-.066 1.221A.5.5 0 0 1 6 8.447c.04-.37.06-.742.06-1.115zm3.509 1a.5.5 0 0 1 .487.513 11.5 11.5 0 0 1-.587 3.339l-1.266 3.8a.5.5 0 0 1-.949-.317l1.267-3.8a10.5 10.5 0 0 0 .535-3.048A.5.5 0 0 1 9.569 8Zm-3.356 2.115a.5.5 0 0 1 .33.626L5.24 14.939a.5.5 0 1 1-.955-.296l1.303-4.199a.5.5 0 0 1 .625-.329Z" />
                                                <path
                                                    d="M4.759 5.833A3.501 3.501 0 0 1 11.559 7a.5.5 0 0 1-1 0 2.5 2.5 0 0 0-4.857-.833.5.5 0 1 1-.943-.334Zm.3 1.67a.5.5 0 0 1 .449.546 10.72 10.72 0 0 1-.4 2.031l-1.222 4.072a.5.5 0 1 1-.958-.287L4.15 9.793a9.72 9.72 0 0 0 .363-1.842.5.5 0 0 1 .546-.449Zm6 .647a.5.5 0 0 1 .5.5c0 1.28-.213 2.552-.632 3.762l-1.09 3.145a.5.5 0 0 1-.944-.327l1.089-3.145c.382-1.105.578-2.266.578-3.435a.5.5 0 0 1 .5-.5Z" />
                                                <path
                                                    d="M3.902 4.222a4.996 4.996 0 0 1 5.202-2.113.5.5 0 0 1-.208.979 3.996 3.996 0 0 0-4.163 1.69.5.5 0 0 1-.831-.556Zm6.72-.955a.5.5 0 0 1 .705-.052A4.99 4.99 0 0 1 13.059 7v1.5a.5.5 0 1 1-1 0V7a3.99 3.99 0 0 0-1.386-3.028.5.5 0 0 1-.051-.705ZM3.68 5.842a.5.5 0 0 1 .422.568c-.029.192-.044.39-.044.59 0 .71-.1 1.417-.298 2.1l-1.14 3.923a.5.5 0 1 1-.96-.279L2.8 8.821A6.531 6.531 0 0 0 3.058 7c0-.25.019-.496.054-.736a.5.5 0 0 1 .568-.422Zm8.882 3.66a.5.5 0 0 1 .456.54c-.084 1-.298 1.986-.64 2.934l-.744 2.068a.5.5 0 0 1-.941-.338l.745-2.07a10.51 10.51 0 0 0 .584-2.678.5.5 0 0 1 .54-.456Z" />
                                                <path
                                                    d="M4.81 1.37A6.5 6.5 0 0 1 14.56 7a.5.5 0 1 1-1 0 5.5 5.5 0 0 0-8.25-4.765.5.5 0 0 1-.5-.865Zm-.89 1.257a.5.5 0 0 1 .04.706A5.478 5.478 0 0 0 2.56 7a.5.5 0 0 1-1 0c0-1.664.626-3.184 1.655-4.333a.5.5 0 0 1 .706-.04ZM1.915 8.02a.5.5 0 0 1 .346.616l-.779 2.767a.5.5 0 1 1-.962-.27l.778-2.767a.5.5 0 0 1 .617-.346Zm12.15.481a.5.5 0 0 1 .49.51c-.03 1.499-.161 3.025-.727 4.533l-.07.187a.5.5 0 0 1-.936-.351l.07-.187c.506-1.35.634-2.74.663-4.202a.5.5 0 0 1 .51-.49" />
                                            </svg>
                                            @if ($approver['related_document_approval_step']['approval_step_name'] == 'VERIFICATION')
                                                <span class="fw-bold text-capitalize">Refer Back</span>
                                            @elseif($approver['related_document_approval_step']['approval_step_name'] == 'REVIEW')
                                                <span class="fw-bold text-capitalize">Refer Back</span>
                                            @elseif($approver['related_document_approval_step']['approval_step_name'] == 'APPROVAL')
                                                <span class="fw-bold text-capitalize">Refer Back</span>
                                            @elseif($approver['related_document_approval_step']['approval_step_name'] == 'AUTHORISATION')
                                                <span class="fw-bold text-capitalize">Refer Back</span>
                                            @endif
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@push('scripts')
    <script>
        document.getElementById('openPdfLink').addEventListener('click', function(event) {
            event.preventDefault();
            window.open(this.href, '_blank');
        });
    </script>
@endpush
