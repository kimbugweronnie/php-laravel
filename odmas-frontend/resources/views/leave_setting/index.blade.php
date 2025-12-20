@extends('layouts.app')

@section('content')
    @include('messages.flash')

    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-12 d-flex justify-content-between">
                <h3 class="text-capitalize">
                    List of leave request setting
                </h3>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-lg-12">
                <div class="border bg-white rounded-3 shadow px-4 py-3">
                    @if ($leaveRequestSettings)
                        <table class="table table-hover">
                            <thead>
                                <tr class="text-capitalize">
                                    <th scope="col">Annual leave days</th>
                                    <th scope="col">Paternity leave days</th>
                                    <th scope="col">Maternity leave days</th>
                                    <th scope="col">Compassionate leave days</th>
                                    <th scope="col">Sick leave days</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $leaveRequestSettings['mandatory_leave_days'] }}</td>
                                    <td>{{ $leaveRequestSettings['paternity_leave_days'] }}</td>
                                    <td>{{ $leaveRequestSettings['maternity_leave_days'] }}</td>
                                    <td>10</td>
                                    <td>{{ $leaveRequestSettings['sick_leave_days'] }}</td>
                                    <td>
                                        <ul class="navbar-nav navbar-align">
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#submitleaveSetting">
                                                        <i class="align-middle me-1" data-feather="edit"></i>
                                                        Edit
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            No leave request settings available
                        </div>
                    @endif
                </div>
            </div>
            <div class="modal fade" id="submitleaveSetting" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Update Leave Settings</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('leaveRequestSetting.update') }}" class="hidden" id="submit-leaveSetting"
                                method="POST">
                                @method('post')
                                @csrf
                                <div class="mb-3">
                                    <label for="name_of_director" class="col-form-label">Mandatory Leave Days:</label>
                                    <input type="text" class="form-control" name="mandatory_leave_days"
                                        value="{{ $leaveRequestSettings['mandatory_leave_days'] }}"
                                        id="mandatory_leave_days">
                                    @error('mandatory_leave_days')
                                        <div class="alert alert-danger p-2 mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="name_of_director" class="col-form-label">Paternity Leave Days:</label>
                                    <input type="text" class="form-control" name="paternity_leave_days"
                                        value="{{ $leaveRequestSettings['paternity_leave_days'] }}"
                                        id="paternity_leave_days">
                                    @error('paternity_leave_days')
                                        <div class="alert alert-danger p-2 mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="name_of_director" class="col-form-label">Maternity Leave Days:</label>
                                    <input type="text" class="form-control" name="maternity_leave_days"
                                        value="{{ $leaveRequestSettings['maternity_leave_days'] }}"
                                        id="maternity_leave_days">
                                    @error('maternity_leave_days')
                                        <div class="alert alert-danger p-2 mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="name_of_director" class="col-form-label">Sick Leave Days:</label>
                                    <input type="text" class="form-control" name="sick_leave_days"
                                        value="{{ $leaveRequestSettings['sick_leave_days'] }}" id="sick_leave_days">
                                    @error('sick_leave_days')
                                        <div class="alert alert-danger p-2 mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success text-white"
                                onclick="event.preventDefault(); document.getElementById('submit-leaveSetting').submit();">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
