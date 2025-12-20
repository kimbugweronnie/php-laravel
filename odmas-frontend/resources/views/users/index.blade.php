@extends('layouts.app')

@section('content')

@include('messages.flash')

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h4 class="fw-bold py-1 text-capitalize"><span class="text-muted fw-light">Project users / </span>List of users</h4>
            <h4 class="text-capitalize">
                <a class="btn btn-outline-primary" href="{{ route('projectUsers.create') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-plus" viewBox="0 0 18 18">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                    </svg>
                    Create project user
                </a>
            </h4>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-lg-12">
            <div class="border bg-white rounded-3 shadow px-4 py-3">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email </th>
                            <th scope="col">Role</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="table-active">
                            <td><a class="text-decoration-none" href="#">Jonh Doore</a></td>
                            <td>doore@gmail.com</td>
                            <td>Manager</td>
                            <td><button class="btn btn-sm btn-outline-success rounded">Active</button></td>
                            <td>
                                <ul class="navbar-nav navbar-align">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                            Process
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">
                                                <i class="align-middle me-1" data-feather="edit"></i>
                                                Edit
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#meetingModal">
                                                <i class="align-middle me-1" data-feather="trash-2"></i>
                                                Delete
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td><a class="text-decoration-none" href="#">Samuel King</a></td>
                            <td>king@gmail.com</td>
                            <td>Manager</td>
                            <td><button class="btn btn-sm btn-outline-success rounded">Active</button></td>
                            <td>
                                <ul class="navbar-nav navbar-align">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                            Process
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">
                                                <i class="align-middle me-1" data-feather="edit"></i>
                                                Edit
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#meetingModal">
                                                <i class="align-middle me-1" data-feather="trash-2"></i>
                                                Delete
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection