<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize">{{ $activity['activity_name'] }}</h3>
            <a class="btn btn-secondary px-3" href="{{ route('activities.index') }}">
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
                <form  wire:submit="updateActivity">
                    <div class="row mb-2">
                        <div class="col-12">
                            <label for="activity_name" class="form-label text-capitalize">Activity name</label>
                            <input type="text" class="form-control @error('activity_name') is-invalid @enderror" wire:model="activity_name" value="{{ $activity_name }}" id="activity_name">
                            @error('activity_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="start_date" class="form-label text-capitalize">Start date</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" wire:model="start_date" placeholder="{{  $start_date }}" id="start_date">
                            @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="end_date" class="form-label text-capitalize">End date</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" wire:model="end_date" value="{{ $end_date }}" id="end_date">
                            @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="is_recurring" class="form-label text-capitalize">Recurrence</label>
                            <select wire:model="is_recurring" class="form-select" aria-label="Default select choice">
                                @if ($activity['is_recurring'])
                                    <option  value="True" selected>Yes</option>
                                @else
                                    <option value="False" selected>No</option>
                                @endif
                                <option value="True">Yes</option>
                                <option value="False">No</option>
                            </select>
                            @error('is_recurring')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="recurring_frequency" class="form-label text-capitalize">Frequency of recurrence</label>
                            <select wire:model="recurring_frequency" class="form-select" aria-label="Default select choice">
                                <option value="{{ $activity['recurring_frequency'] }}" selected>{{ $activity['recurring_frequency'] }}</option>
                                <option value="DAILY">Daily</option>
                                <option value="WEEKLY">Weekly</option>
                                <option value="MONTHLY">Monthly</option>
                            </select>
                            @error('recurring_frequency')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="has_report" class="form-label text-capitalize">Has report</label>
                        <select wire:model="has_report" class="form-select" aria-label="Default select choice">
                            @if ($activity['has_report'])
                                <option value="True" selected>Yes</option>
                            @else
                                <option value="False" selected>No</option>
                            @endif
                            <option value="True">Yes</option>
                            <option value="False">No</option>
                        </select>
                        @error('has_report')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
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