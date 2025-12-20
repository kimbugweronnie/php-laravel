@extends('layouts.app')

@section('content')

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h4 class="fw-bold py-1"><span class="text-muted fw-light">Department Role / </span><a class="text-decoration-none" href="{{ route('departmentRoles.index') }}">List of Department Roles /</a> {{ \Str::ucfirst(\Str::lower($role['role_name'])) }}</h4>
            <div class="dropdown">
                <a type="button" class="btn btn-primary dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Actions
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                    <li>
                        <a class="dropdown-item" href="{{  route('departmentRoles.index') }}">
                            <i class="align-middle me-2" data-feather="arrow-left-circle"></i>
                            Back
                        </a>
                    </li>
                </ul>
         
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-12">
            @include('messages.flash')
            <div class="border rounded-3 bg-white shadow py-4 px-5">
                <div class="row mb-3">
                    <h5><span class="fw-bold">Name:</span> {{ \Str::ucfirst(\Str::lower($role['role_name'])) }}</h5>
                </div>
                <div class="row mb-3">
                    <h5><span class="fw-bold">Reports To:</span> {{ \Str::ucfirst(\Str::lower($role['reports_to'])) }}</h5>
                </div>
                <div class="row">
                    <h5><span class="fw-bold">Department Name:</span> {{ $role['related_department']['department_name'] }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection