@extends('layouts.app')

@section('content')


    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-12 d-flex justify-content-between">
                <h3 class="text-capitalize">
                    Summary of leave request
                </h3>
                <div>
                    <a class="btn btn-outline-primary mb-2" href="{{ route('leave.create') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
                            class="bi bi-plus" viewBox="0 0 18 18">
                            <path
                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                        </svg>
                        Create Leave Request
                    </a>
                </div>
            </div>
        </div>
        <div class="row mt-2 mb-3">
            <div class="col-lg-3">
                <div class="border bg-white rounded-3 shadow px-4 py-3">
                    @if ($current_status)
                        <div class="mb-2">
                            <div class="fw-bold text-capitalize">Annual leave entitlement</div>
                            <div>{{ $current_status['present_annual_leave_entitlement'] }}</div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-3">
                <div class="border bg-white rounded-3 shadow px-4 py-3">
                    @if ($current_status)
                        <div class="mb-2">
                            @if ($current_status['balance_of_maternal_days'])
                                <div class="fw-bold text-capitalize">Maternal leave days</div>
                                {{ $current_status['balance_of_maternal_days'] }}
                            @elseif($current_status['balance_of_paternal_days'])
                                <div class="fw-bold text-capitalize">Paternal leave days</div>
                                <div>{{ $current_status['balance_of_paternal_days'] }}</div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-3">
                <div class="border bg-white rounded-3 shadow px-4 py-3">
                    @if ($current_status)
                        <div class="mb-2">
                            <div class="fw-bold text-capitalize">Leave days taken</div>
                            <div>{{ $current_status['number_days_taken'] }}</div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-3">
                <div class="border bg-white rounded-3 shadow px-4 py-3">
                    @if ($current_status)
                        <div class="mb-2">
                            <div class="fw-bold text-capitalize">Balance of days</div>
                            <div>{{ $current_status['balance_of_days'] }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-lg-12">
                <h3 class="text-capitalize">
                    Leave Requests
                </h3>

                <livewire:index-leave />
            </div>
        </div>
    </div>

@endsection
