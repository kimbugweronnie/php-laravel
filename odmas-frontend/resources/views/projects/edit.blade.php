@extends('layouts.app')

@section('content')

<div class="container-fluid p-0">
    <div class="row">
        @include('messages.flash')
        <div class="col-lg-12 d-flex justify-content-between">
            <h4 class="fw-bold py-1"><span class="text-muted fw-light">Projects / </span><a class="text-decoration-none" href="{{ route('projects.index') }}">List of Projects /</a> {{ $project['project_name'] }}</h4>
            <div>
                <a class="btn btn-outline-secondary px-3" href="{{ route('projects.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-left mb-1" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0v-2z"/>
                        <path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                    </svg>
                    Back
                </a>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="border rounded-3 bg-white shadow py-4 px-5">
                <form method="POST" action="{{ route('projects.update', $project['id']) }}">
                    @csrf
                    @method('patch')

                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="project_name" class="form-label text-capitalize">Name</label>
                            <input type="text" class="form-control @error('project_name') is-invalid @enderror" name="project_name" value="{{ old('project_name', $project['project_name']) }}" id="project_name">
                            @error('project_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="project_number" class="form-label text-capitalize">Number</label>
                            <input type="text" class="form-control @error('project_number') is-invalid @enderror" name="project_number" value="{{ old('project_number', $project['project_number']) }}" id="project_number">
                            @error('project_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="donor" class="form-label text-capitalize">Donor</label>
                            <input type="text" class="form-control @error('donor') is-invalid @enderror" name="donor" value="{{ old('donor', $project['donor']) }}" id="donor">
                            @error('donor')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        {{-- <div class="col-6">
                            <label for="project_participant" class="form-label text-capitalize">Project Manager</label>
                            <select name="project_participant" class="form-select" aria-label="Default select manager">
                                <option selected>Select manager</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee['id'] }}">{{ $employee['related_user']['first_name'] }} {{ $employee['related_user']['last_name'] }}</option>
                                @endforeach
                            </select>
                            @error('project_participant')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> --}}
                    </div>

                    <div class="col-12 mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-3">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection