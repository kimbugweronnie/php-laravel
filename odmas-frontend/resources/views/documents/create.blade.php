@extends('layouts.app')

@section('content')

@include('messages.flash')

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize"> New document </h3>
            <a class="btn btn-outline-secondary px-3" href="{{ route('documents.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-left mb-1" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0v-2z"/>
                    <path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                </svg>
                Back
            </a>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="border rounded-3 bg-white shadow py-4 px-5">
                <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="file_name" class="form-label text-capitalize">File name</label>
                        <input type="text" class="form-control @error('file_name') is-invalid @enderror"   name="file_name" value="{{ old('file_name') }}" required id="file_name">
                        @error('file_name')
                        <div class="alert alert-danger p-2 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"  name="description" rows="3" required id="description">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="alert alert-danger p-2 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="related_project" class="form-label text-capitalize">Related project</label>
                            <select name="related_project" class="form-select @error('related_project') is-invalid @enderror">
                                <option disabled>Choose Project</option>
                                @forelse($projects as $project)
                                    <option value="{{ $project['id'] }}">{{ $project['project_name'] }}</option>
                                @empty
                                    <option>No projects</option>
                                @endforelse
                            </select>
                             @error('related_project')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="category" class="form-label text-capitalize">Document Category</label>
                            <select  name="category" class="form-select @error('category') is-invalid @enderror">
                                <option disabled >Choose Category</option>
                                <option value="DEPARTMENT DOCUMENTS">Department</option>
                                <option value="PROJECT DOCUMENTS">Project</option>
                            </select>
                             @error('related_project')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                         <div class="col-4">
                            <label for="file" class="form-label">Attachment</label>
                            <input class="form-control @error('file') is-invalid @enderror" type="file" name="file" accept=".doc,.docx,.pdf" required id="file" multiple>
                        </div>
                         @error('file')
                            <div class="alert alert-danger p-2 mt-2">{{ $message }}</div>
                         @enderror
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