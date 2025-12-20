@extends('layouts.app')

@section('content')

    @include('messages.flash')

    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-12 d-flex justify-content-between">
                <h4 class="fw-bold py-1"><span class="text-muted fw-light">Departments / </span>Employees</h4>
                <h4 class="text-capitalize">
                    <a class="btn btn-outline-primary" href="{{ route('employees.create') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
                            class="bi bi-plus" viewBox="0 0 18 18">
                            <path
                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                        </svg>
                        Create Employee
                    </a>
                    <a class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#access-setting"
                        href="{{ route('employees.create') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
                            class="bi bi-sliders" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M11.5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M9.05 3a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0V3zM4.5 7a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M2.05 8a2.5 2.5 0 0 1 4.9 0H16v1H6.95a2.5 2.5 0 0 1-4.9 0H0V8zm9.45 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m-2.45 1a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0v-1z" />
                        </svg>
                        Open Access
                    </a>
                </h4>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-lg-12">
                <div class="border bg-white rounded-3 shadow px-4 py-3">
                    @if ($employees)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Names</th>
                                    <th scope="col">Department </th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Dept Role</th>
                                    <th scope="col">Project role</th>
                                    <th scope="col">Report To</th>
                                    <th scope="col">Employee Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td><a class="text-decoration-none"
                                                href="{{ route('employees.show', $employee['id']) }}">{{ $employee['related_user']['first_name'] }}
                                                {{ $employee['related_user']['last_name'] }}</a></td>
                                        <td>{{ $employee['related_department']['department_name'] }}</td>
                                        <td>{{ $employee['related_user']['username'] }} </td>
                                        <td>{{ $employee['related_role'] ? \Str::ucfirst(\Str::lower($employee['related_role']['role_name'])) : null }}
                                        </td>
                                        <td>{{ $employee['role_name'] ? \Str::ucfirst(\Str::lower($employee['role_name'])) : null }}
                                        </td>
                                        <td>{{ $employee['related_role'] ? \Str::ucfirst(\Str::lower($employee['related_role']['reports_to'])) : null }}
                                        </td>

                                        @if ($employee['leave_status'] == false)
                                            <td><button class="btn btn-sm btn-outline-success rounded">Active</button></td>
                                        @else
                                            <td><button class="btn btn-sm btn-outline-warning rounded">Inactive</button>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            No employees available
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="modal fade" id="access-setting" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Access Settings</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('accessSettings.update') }}" class="hidden" id="submit-accessSetting"
                            method="POST">
                            @method('post')

                            This is to allows all staff to access documents across projects.

                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success text-white"
                            onclick="event.preventDefault(); document.getElementById('submit-accessSetting').submit();">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
