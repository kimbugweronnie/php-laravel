@extends('layouts.app')

@section('content')

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h4 class="fw-bold py-1"><span class="text-muted fw-light">Projects / </span><a class="text-decoration-none" href="{{ route('projects.index') }}">List of Projects /</a> {{ $project['project_name'] }}</h4>
            <div class="dropdown">
                <a type="button" class="btn btn-primary dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Actions
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                    <li>
                        <a class="dropdown-item" href="{{ route('projects.edit', $project['id']) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square mx-1" viewBox="0 0 19 19">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>
                            Edit Project
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{  route('projects.index') }}">
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
                    <h5><span class="fw-bold">Name:</span> {{ $project['project_name'] }}</h5>
                </div>
                <div class="row mb-3">
                    <h5><span class="fw-bold">Project number:</span> {{ $project['project_number'] }}</h5>
                </div>
                <div class="row">
                    <h5><span class="fw-bold">Donor:</span> {{ $project['donor'] }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection