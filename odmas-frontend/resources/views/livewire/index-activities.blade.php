<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize">
                List of activities
            </h3>
             @if(Session::get('employee_details')['has_department_role'] == false  || Session::has('projects'))
                <h3 class="text-capitalize">
                    <a class="btn btn-outline-primary" href="{{ route('activities.create') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-plus" viewBox="0 0 18 18">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                        </svg>
                        Create activity
                    </a>
                </h3>
            @endif
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-lg-12">
            @include('messages.flash')
            <div class="border bg-white rounded-3 shadow px-4 py-3">
                @if ($activities)
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-capitalize" scope="col">Activity name</th>
                                <th class="text-capitalize" scope="col">Start date</th>
                                <th class="text-capitalize" scope="col">End date</th>
                                <th class="text-capitalize" scope="col">Recurrence</th>
                                <th class="text-capitalize" scope="col">Frequency of recurrence</th>
                                <th class="text-capitalize" scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $activity)
                                <tr>
                                    <td><a class="text-decoration-none" href="{{ route('activities.show', $activity['id'])}}">{{ $activity['activity_name'] }}</a></td>
                                    <td>{{ $activity['start_date'] }}</td>
                                    <td>{{ $activity['end_date'] }}</td>
                                    <td>
                                        @if ($activity['is_recurring'])
                                            <span class="badge bg-primary rounded px-3">Recurrent</span>
                                        @else
                                            <span class="badge bg-secondary rounded px-1">Non recurrent</span>
                                        @endif
                                    </td>
                                    <td>{{ $activity['recurring_frequency'] }}</td>
                                    <td>
                                        <ul class="navbar-nav navbar-align">
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="{{ route('activities.edit', $activity['id']) }}">
                                                        <i class="align-middle me-1" data-feather="edit"></i>
                                                        Edit
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a type="button" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('delete-activity-{{ $activity['id'] }}').submit();">
                                                        <i class="align-middle me-1" data-feather="trash-2"></i>
                                                        Delete
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <form action="{{ route('activities.destroy', $activity['id']) }}" class="hidden"
                                    id="delete-activity-{{ $activity['id'] }}" method="POST">
                                    @csrf
                                    @method('delete')
                                </form>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center">
                        No activities available
                    </div>
                @endif
            </div>
        </div>
    </div>