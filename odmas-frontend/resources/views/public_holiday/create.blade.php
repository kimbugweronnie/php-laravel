@extends('layouts.app')

@section('content')

@include('messages.flash')

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize">
                Mark holiday
            </h3>
            <h3 class="text-capitalize">
                <a class="btn btn-outline-secondary" href="{{ route('publicHolidays.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-left mb-1" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0v-2z"/>
                        <path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                    </svg>
                    Back
                </a>
            </h3>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-lg-12">
            <div class="border rounded-3 bg-white shadow py-4 px-5">
                <form method="POST" action="{{ route('publicHolidays.store') }}">
                    @csrf

                    <div class="row mb-2">
                        <div class="col-12">
                            <label for="public_holiday" class="form-label text-capitalize">Date</label>
                            <input type="date" class="form-control @error('public_holiday') is-invalid @enderror" name="public_holiday" value="{{ old('public_holiday') }}" required id="public_holiday">
                            @error('public_holiday')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="holiday_name" class="form-label text-capitalize">Name</label>
                            <input type="text" class="form-control @error('holiday_name') is-invalid @enderror" name="holiday_name" value="{{ old('holiday_name') }}" required id="holiday_name">
                            @error('holiday_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <label class="form-label text-capitalize" for="categories">Categories</label>
                            <select name = "color" class="form-select" required id="color">
                                <option selected>Choose  Category</option>
                                <option value="#ff8080">Public Holidays</option>
                                <option value="#004d00">Health Days</option>
                                <option value="#4d94ff">Church Holidays</option>
                                <option value="#e68a00">Statutory Meeting</option>
                                <option value="#0000cc">Technical Workshop/Meeting</option>
                                <option value="#b3b3ff">Department Meeting</option>
                            </select>
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