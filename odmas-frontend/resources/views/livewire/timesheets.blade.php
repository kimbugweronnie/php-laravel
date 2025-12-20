<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize">
                List of Submitted timesheets
            </h3>
             @if(Session::get('employee_details')['has_department_role'] == false  || Session::has('projects'))
                <h3 class="text-capitalize">
                    <a class="btn btn-outline-primary" href="{{ route('timeSheets.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-left mb-1" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0v-2z"/>
                            <path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                        </svg>
                        Back
                    </a>
                </h3>
            @endif
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-lg-12">
            @include('messages.flash')
            <div class="border bg-white rounded-3 shadow px-4 py-3">
                @if (count($timesheets) > 0)
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-capitalize" scope="col">Title</th>
                                <th class="text-capitalize" scope="col">Date Added</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($timesheets as $timesheet)
                                <tr>
                                    <td><a class="text-decoration-none" href="{{ route('approved.timesheet',$timesheet['id'])}}">{{ $timesheet['fields']['title'] }}</a></td>
                                    <td>
                                     {{ date('d/m/Y',strtotime($timesheet['date_added']))}}
                                    </td>
                                </tr>    
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center">
                        No submittedd timesheets
                    </div>
                @endif
            </div>
        </div>
    </div>