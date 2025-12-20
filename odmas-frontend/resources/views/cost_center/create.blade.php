@extends('layouts.app')

@section('content')

<div class="container-fluid p-0">
    <div class="row">
        @include('messages.flash')
        <div class="col-lg-12 d-flex justify-content-between">
            <h4 class="fw-bold py-1"><span class="text-muted fw-light">Projects / </span><a class="text-decoration-none" href="{{ route('costCenters.index') }}">List of Cost Center / </a>New Cost Center</h4>
            <div>
                <a class="btn btn-secondary px-3" href="{{ route('costCenters.index') }}">
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
                <form method="POST" action="{{ route('costCenters.store') }}">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="cost_center_name" class="form-label text-capitalize">Cost center name</label>
                            <input type="text" class="form-control @error('cost_center_name') is-invalid @enderror" name="cost_center_name" value="{{ old('cost_center_name') }}" id="cost_center_name">
                            @error('cost_center_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The project name  is required.</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="related_project" class="form-label text-capitalize">Project</label>
                            <select name="related_project" class="form-select @error('related_project') is-invalid @enderror" aria-label="Default select manager" >
                                <option selected>Select project</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project['id'] }}">{{ $project['project_name'] }}</option>
                                @endforeach
                            </select>
                            @error('related_project')
                                <span class="invalid-feedback" role="alert">
                                    <strong>A project is required.</strong>
                                </span>
                            @enderror
                        </div>
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