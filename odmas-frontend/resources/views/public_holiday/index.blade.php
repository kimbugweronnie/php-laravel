@extends('layouts.app')

@section('content')

@include('messages.flash')

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize">
                List of holidays
            </h3>
            <h3 class="text-capitalize">
                <a class="btn btn-outline-primary" href="{{ route('publicHolidays.create') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-plus" viewBox="0 0 18 18">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                    </svg>
                    Mark holiday
                </a>
            </h3>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-lg-12">
            <div class="border bg-white rounded-3 shadow px-4 py-3">
                @if ($publicHolidays)
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Holiday Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($publicHolidays as $publicHoliday)
                                <tr>
                                    <td>{{ $publicHoliday['public_holiday'] }}</td>
                                    <td>{{ $publicHoliday['holiday_name'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center">
                        No public holidays available
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection