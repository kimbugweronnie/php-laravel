<div class="container-fluid p-0">
    @include('messages.flash')
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <div>
                <a class="btn btn-secondary" href="{{ route('leave.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-box-arrow-in-left mb-1" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0v-2z" />
                        <path fill-rule="evenodd"
                            d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z" />
                    </svg>
                    Back
                </a>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 col-lg-12 col-xxl-12">

            <div class="border rounded-3 bg-white shadow py-4 px-5">
                <form wire:submit="leaveRequest">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="leave_start_date" class="form-label">Leave start date:</label>
                            <input type="date" class="form-control @error('leave_start_date') is-invalid @enderror"
                                wire:model="leave_start_date" id="leave_start_date"
                                min='{{ now()->addDays(1)->format('Y-m-d') }}' autofocus>
                            @error('leave_start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="text-capitalize mb-2" for="department">Type of Leave</label>
                            <select name="type_of_leave" id="type_of_leave"
                                class="form-select  @error('type_of_leave') is-invalid @enderror"
                                wire:model="type_of_leave">
                                <option selected>Choose Leave Type</option>
                                <option value="NORMAL">Annual Leave</option>
                                <option value="COMPASSIONATE">Compassionate Leave</option>
                                <option value="PATERNAL">Paternity Leave</option>
                                <option value="MATERNAL">Maternity Leave</option>
                                <option value="SICK">Sick Leave</option>
                            </select>
                            @error('type_of_leave')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="leave_days_required" class="form-label text-capitalize">Leave days
                                required:</label>
                            <input wire:model="leave_days_required" type="number"
                                class="form-control @error('leave_days_required') is-invalid @enderror"
                                name="leave_days_required" value="{{ old('leave_days_required') }}"
                                id="leave_days_required">
                            @error('leave_days_required')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-4">
                            <label for="address_while_on_leave" class="form-label">Person Requesting/Behalf of :</label>
                            <select wire:model="related_employee" id="related_employee" aria-label="Default select"
                                class="form-select @error('related_employee') is-invalid @enderror">
                                <option selected value="">Choose person</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee['id'] }}">{{ $employee['related_user']['first_name'] }}
                                        {{ $employee['related_user']['last_name'] }}
                                        {{ $employee['related_role'] ? $employee['related_role']['role_name'] : null }}
                                    </option>
                                @endforeach
                            </select>
                            @error('related_employee')
                                <span class="invalid-feedback" role="alert">
                                    <strong>person field required</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="address_while_on_leave" class="form-label">Address while on leave:</label>
                            <input type="text"
                                class="form-control @error('address_while_on_leave') is-invalid @enderror"
                                wire:model="address_while_on_leave" id="address_while_on_leave"
                                value="{{ old('address_while_on_leave') }}">
                            @error('address_while_on_leave')
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
