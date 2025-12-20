@extends('layouts.app')

@section('content')

@include('messages.flash')

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize">{{ $task['task_name'] }} </h3>
            <a class="btn btn-secondary px-3" href="{{ route('activities.show', $task['related_activity']['id']) }}">
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
                <form method="POST" action="{{ route('tasks.update', $task['id']) }}">
                    @csrf
                    @method('patch')
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="related_activity" class="form-label text-capitalize">Activity name</label>
                            <select name="related_activity" class="form-select" aria-label="Default select choice">
                                @if ($activities)
                                    <option  value="{{ $task['related_activity']['id'] }}" selected>{{ $task['related_activity']['activity_name'] }}</option>
                                    @foreach($activities as $activity)
                                        <option value="{{ $activity['id'] }}">{{ $activity['activity_name'] }}</option>
                                    @endforeach
                                @else
                                    <option value="">No activity</option>
                                @endif
                            </select>
                            @error('related_activity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-6"> 
                            <label for="task_name" class="form-label text-capitalize">Task name</label>
                            <input type="text" class="form-control @error('task_name') is-invalid @enderror" name="task_name" value="{{ old('task_name', $task['task_name']) }}" id="task_name">
                            @error('task_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div> 
                        <input type="hidden" class="form-control" name="related_task" value="">
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="start_date" class="form-label text-capitalize">Start date</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date', $task['start_date']) }}" id="start_date">
                            @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="end_date" class="form-label text-capitalize">End date</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date', $task['end_date']) }}" id="end_date">
                            @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="task_assignee" class="form-label text-capitalize fw-bold">Task assignees</label><br/>
                            @foreach ($task['task_assignee'] as $assignee)
                                <div class="d-flex align-items-center mb-1">
                                    {{ $assignee['assigned_to']['related_user']['first_name'] }}
                                    {{-- <form action="{{ route('assignee.remove', ['task_id' => $task['id'], 'assignee_id' => $assignee['id']]) }}" method="POST" class="ms-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm ms-2">
                                            Delete
                                        </button>
                                    </form> --}}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <label for="task_assignee" class="form-label text-capitalize">Task assignee</label>
                            <select name="task_assignee" class="form-select" aria-label="Default select choice">
                                @foreach ($task['task_assignee'] as $assignee)
                                    <option value="{{ $assignee['id'] }}" selected>{{ $assignee['assigned_to']['related_user']['first_name'] }} {{ $assignee['assigned_to']['related_user']['last_name'] }}</option>
                                @endforeach
                                @if ($projectUsers)
                                    @foreach($projectUsers as $projectUser)
                                        <option value="{{ $projectUser['id'] }}">{{ $projectUser['related_user']['first_name'] }} {{ $projectUser['related_user']['last_name'] }}</option>
                                    @endforeach
                                @else
                                    <option value="">No users</option>
                                @endif
                            </select>
                            @error('task_assignee')
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