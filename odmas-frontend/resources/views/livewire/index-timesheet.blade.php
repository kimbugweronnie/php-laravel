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
        <div class="col-lg-12 d-flex mb-3 justify-content-between">
            <div class="row row-cols-lg-auto g-3 align-items-center">
                <div class="col-6">
                    <label class="fw-bold mb-2" for="month"> Select Month</label>
                    <select wire:model="month" wire:change="filterPerMonthYear" class="form-select">
                        @foreach ($this->months as $month)
                            <option value="{{ $month }}">{{ $month }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-6">
                    <label class="fw-bold mb-2" for="month"> Select Year</label>
                    <select wire:model="year" wire:change="filterPerMonthYear" class="form-select">
                        @foreach ($this->years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-lg-12 d-flex justify-content-between">
            <div>
                <a class="btn btn-outline-secondary text-capitalize" data-bs-toggle="modal"
                    data-bs-target="#submitTimesheet">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-send" viewBox="0 0 16 16">
                        <path
                            d="M.5 2.2l14.5 6.8-14.5 6.8v-4.7l9-2.1-9-2.1v-4.6zm1.015.771l10.947 5.188-10.947 5.188v-2.8l7.308-1.7-7.308-1.7v-2.8z" />
                    </svg>
                    Submit form
                </a>
            </div>
            <div class="row row-cols-lg-auto g-3 align-items-center">
                <div class="col-6">
                    <a class="btn btn-outline-secondary" href="{{ route('user.timesheets') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                            class="bi bi-table" viewBox="0 0 16 16">
                            <path
                                d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm15 2h-4v3h4zm0 4h-4v3h4zm0 4h-4v3h3a1 1 0 0 0 1-1zm-5 3v-3H6v3zm-5 0v-3H1v2a1 1 0 0 0 1 1zm-4-4h4V8H1zm0-4h4V4H1zm5-3v3h4V4zm4 4H6v3h4z" />
                        </svg>
                        Timesheets
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @if ($this->timesheet['status'] === 200)
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
                                @foreach ($days as $day)
                                    <td class="vertical-text"><b>{{ date('l', strtotime($day['day'])) }}</b></td>
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
                                @foreach ($days as $day)
                                    <td class=>{{ $counter }}</td>
                                    @php
                                        $counter++;
                                    @endphp
                                @endforeach
                            </tr>
                            @foreach ($activities as $activity)
                                <tr>
                                    <td>{{ $activity['display_name'] }}</td>
                                    @if ($activity['display_name'] === 'Flash Project' || $activity['display_name'] === 'IDI-KHP PROJECT')
                                        <td></td>
                                    @else
                                        <td></td>
                                    @endif
                                    @foreach ($days as $day)
                                        @if ($day['clock_in'] === false)
                                            <td>0</td>
                                        @elseif(!empty($day['timesheet']['timesheet_records']))
                                            <td>{{ $this->getTimeTaken($day['timesheet']['timesheet_records'], $activity['display_name']) }}
                                            </td>
                                        @else
                                            <td>0</td>
                                        @endif
                                    @endforeach
                                    <td><span
                                        class="red-text">{{ $this->getTotalTimeTaken($days, $activity['display_name']) }}</span>
                                    </td>
                                    <td>{{ $this->percentageToChange($days, $activity['display_name']) }} %</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="text-capitalize">Total Hours</td>
                                <td></td>
                                @foreach ($days as $day)
                                    @if ($day['timesheet'] === false && $day['hours'] > 0)
                                        <td>{{ $day['hours'] }}</td>
                                    @else
                                        <td>{{ $day['hours'] }}</td>
                                    @endif
                                @endforeach
                                <td><span class="red-text">{{ $this->totalHoursTaken($days) }}</span></td>
                                <td>100%</td>
                            </tr>
                            <tr>
                                <td class="text-capitalize">Total expected hours of work</td>
                                <td></td>
                                @foreach ($days as $day)
                                    @if (strpos($day['day_string'], 'Saturday') !== false || strpos($day['day_string'], 'Sunday') !== false)
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
                                @foreach ($days as $day)
                                    @if ($day['hours'] == 0)
                                        <td>0</td>
                                    @else
                                        <td>{{ $this->percentTimeWorked($day) }}</td>
                                    @endif
                                @endforeach
                                <td><b>{{ $this->totalHoursPercentage($days) }}%</b></td>
                            </tr>

                        </tbody>
                    </table>

                    <form
                        action="{{ route('timesheet.approve', [$timesheet['data']['month'], $timesheet['data']['year']]) }}"
                        class="hidden" id="submit-timesheet" method="POST">
                        @method('post')
                        @csrf
                        <input type="hidden" name="month" value="{{ $timesheet['data']['month'] }}">
                        <input type="hidden" name="year" value="{{ $timesheet['data']['year'] }}">
                    </form>
                    <div class="modal fade" id="submitTimesheet" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    For {{ $timesheet['data']['month'] }},{{ $timesheet['data']['year'] }}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-success text-white"
                                        onclick="event.preventDefault(); document.getElementById('submit-timesheet').submit();">Submit
                                        Timesheet</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="updateTimesheet" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Update Timesheet</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    For {{ $timesheet['data']['month'] }},{{ $timesheet['data']['year'] }}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
