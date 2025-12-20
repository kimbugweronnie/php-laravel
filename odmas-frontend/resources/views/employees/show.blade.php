@extends('layouts.app')
@section('content')
<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize"> Employee Profile </h3>
            <div class="dropdown">
                <a type="button" class="btn btn-primary dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Actions
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                    <li>
                        <a class="dropdown-item" href="{{ route('employees.edit', $employee['id']) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square mx-1" viewBox="0 0 19 19">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>
                            Employee Details
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('employees.editLevelsOfEffort', $employee['id']) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square mx-1" viewBox="0 0 19 19">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>
                            Levels of Effort
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('employees.editPassword', $employee['id']) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square mx-1" viewBox="0 0 19 19">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>
                            Edit Password
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#deleteEmployee">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3 mx-1" viewBox="0 0 19 19">
                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                            </svg>
                            Delete
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('employees.index') }}">
                            <i class="align-middle me-2" data-feather="arrow-left-circle"></i>
                            Back
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        <form action="{{ route('employees.delete') }}" class="hidden" id="delete-employee" method="POST">
            @method('post')
            @csrf
            <input type="hidden" name="employee_id" value="{{ $employee['related_user']['id'] }}">
            <input type="hidden" name="username" value="{{ $employee['related_user']['username'] }}">
        </form>
        <div class="modal fade" id="deleteEmployee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ $employee['related_user']['first_name'] }} {{ $employee['related_user']['last_name'] }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger text-white" onclick="event.preventDefault(); document.getElementById('delete-employee').submit();">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-12">
             @include('messages.flash')
            <div class="border rounded-3 bg-white shadow py-4 px-5">
                <div class="row mb-3">
                    <div class="col-4">
                        <label for="first_name" class="form-label text-capitalize">First name</label>
                        <input type="text" class="form-control text-muted" name="first_name" value="{{ $employee["related_user"]["first_name"] }}" aria-label="Disabled" disabled readonly>

                    </div>
                    <div class="col-4">
                        <label for="last_name" class="form-label text-capitalize">Last name</label>
                        <input type="text" class="form-control text-muted" name="last_name" value="{{ $employee["related_user"]["last_name"] }}" aria-label="Disabled" disabled readonly>  
                    </div>
                    <div class="col-4">
                        <label for="employee_role" class="form-label text-capitalize">Username</label>
                        <input type="text" class="form-control text-muted" name="username" value="{{ $employee["related_user"]["username"] }}" aria-label="Disabled" disabled readonly>                           
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label for="department_name" class="form-label text-capitalize">Department Name</label>
                        <input type="text" class="form-control text-muted" name="department_name" value="{{ $employee["related_department"]["department_name"] }}" aria-label="Disabled" disabled readonly>                           
                    </div>
                    
                    <div class="col-6">
                        <label for="role" class="form-label text-capitalize">Role</label>
                        <input type="text" class="form-control text-muted" name="role" value="{{ $employee["related_role"] ? $employee["related_role"]['role_name']: ''  }}" aria-label="Disabled" disabled readonly>                           
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label for="tenant_name" class="form-label text-capitalize">Tenant Name</label>
                        <input type="text" class="form-control text-muted" name="tenant_name" value="{{ $employee["related_tenant"]["tenant_name"] }}" aria-label="Disabled" disabled readonly>                           
                    </div>
                    <div class="col-6">
                        <label for="tenant_address" class="form-label text-capitalize">Address</label>
                        <input type="text" class="form-control text-muted" name="tenant_address" value="{{ $employee["related_tenant"]["tenant_address"] }}" aria-label="Disabled" disabled readonly>                           

                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label for="email" class="form-label text-capitalize">Email</label>
                        <input type="text" class="form-control text-muted" name="email" value="{{ $employee["related_user"]["email"] }}" aria-label="Disabled" disabled readonly>                           
                    </div>
                    <div class="col-6">
                        <label for="number" class="form-label text-capitalize">Phone Number</label>
                        <input type="text" class="form-control text-muted" name="tenant_address" value="{{ $employee["related_user"]["phone_number"] }}" aria-label="Disabled" disabled readonly>                           

                    </div>
                </div>
                
                <div class="row mb-3">
                    <h4 class="text-capitalize">Project Attachments</h4>
                    @foreach ($projects_attached as  $attachment)
                    <div class="col-4">
                        <label for="project_name" class="form-label text-capitalize">Project Name</label>
                        <input type="text" class="form-control text-muted" name="project_name" value="{{ $attachment["related_project"]["project_name"] }}" aria-label="Disabled" disabled readonly>                           
                    </div>
                    <div class="col-4">
                        <label for="role_name" class="form-label text-capitalize">Project Role</label>
                        <input type="text" class="form-control text-muted" name="role_name" value="{{ \Str::ucfirst(\Str::lower($attachment["related_project_role"]["role_name"])) }}" aria-label="Disabled" disabled readonly>                           
                    </div>
                    <div class="col-4 mb-3">
                        <label for="level_of_effort" class="form-label text-capitalize">Level of Effort</label>
                        <input type="text" class="form-control text-muted" name="level_of_effort" value="{{ $attachment["level_of_effort"] }}" aria-label="Disabled" disabled readonly>                           
                    </div>
                    
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>
</div>


@endsection