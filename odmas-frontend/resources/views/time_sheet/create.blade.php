@extends('layouts.app')

@section('content')

@include('messages.flash')

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize"> New timesheet </h3>
            <a class="btn btn-secondary px-3" href="{{ route('timeSheets.index') }}">
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
                <form method="POST" action="{{ route('timeSheets.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="related_activity" class="form-label text-capitalize">Activity name</label>
                        <input type="text" class="form-control @error('related_activity') is-invalid @enderror" name="related_activity" value="{{ old('related_activity') }}" id="related_activity" autofocus>
                        @error('related_activity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="detail" class="form-label text-capitalize">Details</label>
                        <textarea type="text" class="form-control @error('detail') is-invalid @enderror" name="detail" id="detail" rows="2">{{ old('detail') }}</textarea>
                        @error('detail')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="day_recorded" class="form-label text-capitalize">Day recorded</label>
                            <input type="date" class="form-control @error('day_recorded') is-invalid @enderror" name="day_recorded" value="{{ old('day_recorded') }}" id="day_recorded">
                            @error('day_recorded')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="time_taken" class="form-label text-capitalize">Time taken</label>
                            <input type="number" class="form-control @error('time_taken') is-invalid @enderror" name="time_taken" value="{{ old('time_taken') }}" id="time_taken">
                            @error('time_taken')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
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