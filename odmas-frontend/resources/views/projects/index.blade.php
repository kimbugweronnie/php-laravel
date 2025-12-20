@extends('layouts.app')

@section('content')

<div class="container-fluid p-0">
    <div class="row">
        @include('messages.flash')
        <div class="col-lg-12 d-flex justify-content-between">
            <h4 class="fw-bold py-1"><span class="text-muted fw-light">Projects / </span>List of Projects</h4>
            <h4 class="text-capitalize">
                <a class="btn btn-outline-primary" href="{{ route('projects.create') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-plus" viewBox="0 0 18 18">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                    </svg>
                    Create Project
                </a>
            </h4>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-lg-12">
            <div class="border bg-white rounded-3 shadow px-4 py-3">
                @if ($projects)
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Number </th>
                                <th scope="col">Donor</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                <tr>
                                    <td><a class="text-decoration-none" href="{{ route('projects.show', $project['id'] ) }}">{{ $project['project_name'] }}</a></td>
                                    <td>{{ $project['project_number'] }}</td>
                                    <td>{{ $project['donor'] }}</td>
                                    <td>
                                        <ul class="navbar-nav navbar-align">
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="{{ route('projects.edit', $project['id']) }}">
                                                        <i class="align-middle me-1" data-feather="edit"></i>
                                                        Edit
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a type="button" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('delete-project-{{ $project['id'] }}').submit();">
                                                        <i class="align-middle me-1" data-feather="trash-2"></i>
                                                        Delete
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <form action="{{ route('projects.destroy', $project['id']) }}" class="hidden"
                                    id="delete-project-{{ $project['id'] }}" method="POST">
                                    @csrf
                                    @method('delete')
                                </form>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center">
                        No projects available
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection