

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <a class="btn btn-secondary px-3" href="{{ route('tasks.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-left mb-1" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0v-2z"/>
                    <path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                </svg>
                Back
            </a>
        </div>
    </div>
    <div class="row mt-3">
        @include('messages.flash')
        <div class="col-lg-12">
            <div class="border rounded-3 bg-white shadow py-4 px-5">
                <form  wire:submit="taskRequest">
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="related_activity" class="form-label text-capitalize">Activity name</label>
                            <select wire:model="related_activity"  aria-label="Default select choice" class="form-select @error('related_activity') is-invalid @enderror" >
                                <option selected>Select choice</option>
                                @if ($activities)
                                    @foreach($activities as $activity)
                                        <option value="{{ $activity['id'] }}">{{ $activity['activity_name'] }}</option>
                                    @endforeach
                                @else
                                    <option value="">No activity</option>
                                @endif
                            </select>
                            @error('related_activity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The related activity  is required.</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-6"> 
                            <label for="task_name" class="form-label text-capitalize">Task name</label>
                            <input wire:model="task_name" type="text" class="form-control @error('task_name') is-invalid @enderror"  id="task_name">
                            @error('task_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The task name  is required.</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="start_date" class="form-label text-capitalize">Start Date</label>
                            <input wire:model="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" id="date" >
                            @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The start date  is required.</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="date" class="form-label text-capitalize">End Date</label>
                            <input wire:model="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="date" id="date" >
                            @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The end date  is required.</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                   
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="employee" class="form-label text-capitalize">Employee name</label>
                            <select wire:model="employee" class="form-select @error('employee') is-invalid @enderror" aria-label="Default select choice">
                                <option selected>Select choice</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee['related_user']['id'] }}">{{ $employee['related_user']['first_name'] }} {{ $employee['related_user']['last_name'] }}</option>
                                    @endforeach
                            </select>
                            @error('employee')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The employee  is required.</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-6">
                            <label for="has_report" class="form-label text-capitalize">Has Report</label>
                            <select wire:model="has_report" aria-label="Default select choice" class="form-select @error('has_report') is-invalid @enderror">
                                <option selected>Select choice</option>
                                <option value="true">True</option>
                                <option value="false">False</option>

                            </select>
                            @error('has_report')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The has report  is required.</strong>
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
