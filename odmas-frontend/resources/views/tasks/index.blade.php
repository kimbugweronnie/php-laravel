@extends('layouts.app')

@section('content')

@include('messages.flash')

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize">
                List of tasks
            </h3>
            <h3 class="text-capitalize">
                <a class="btn btn-outline-primary" href="{{ route('tasks.create') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-plus" viewBox="0 0 18 18">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                    </svg>
                    Create task
                </a>
            </h3>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-lg-12">
            <div class="border bg-white rounded-3 shadow px-4 py-3">
                @if ($tasks)
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-capitalize" scope="col">Activity</th>
                                <th class="text-capitalize" scope="col">Task name</th>
                                <th class="text-capitalize" scope="col">Start date</th>
                                <th class="text-capitalize" scope="col">End date</th>
                                <th class="text-capitalize" scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>{{ $task['related_activity']['activity_name'] }}</td>
                                    <td><a class="text-decoration-none" href="{{ route('tasks.show', $task['id']) }}">{{ $task['task_name'] }}</a></td>
                                    <td>{{ $task['start_date'] }}</td>
                                    <td>{{ $task['end_date'] }}</td>
                                    <td>
                                        <ul class="navbar-nav navbar-align">
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="{{ route('tasks.edit', $task['id']) }}">
                                                        <i class="align-middle me-1" data-feather="edit"></i>
                                                        Edit
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a type="button" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('delete-task-{{ $task['id'] }}').submit();">
                                                        <i class="align-middle me-1" data-feather="trash-2"></i>
                                                        Delete
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <form action="{{ route('tasks.destroy', $task['id']) }}" class="hidden"
                                    id="delete-task-{{ $task['id'] }}" method="POST">
                                    @csrf
                                    @method('delete')
                                </form>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center">
                        No tasks available
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection