<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize"> New Department role </h3>
            <a class="btn btn-outline-secondary px-3" href="{{ route('departmentRoles.index') }}">
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
            @include('messages.flash')
            <div class="border rounded-3 bg-white shadow py-4 px-5">
                <form wire:submit="createRole">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="role_name" class="form-label text-capitalize">Role Name</label>
                            <input wire:model="role_name" type="text" class="form-control @error('role_name') is-invalid @enderror" name="role_name" value="{{ old('role_name') }}" id="role_name">
                            @error('role_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="department" class="form-label text-capitalize">Department</label>
                            <select  wire:model="department" aria-label="Default select choice" class="form-control @error('department') is-invalid @enderror" wire:change="getRoles()">
                                <option selected>Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department['id'] }}">{{ $department['department_name'] }}</option>
                                @endforeach
                            </select>
                            @error('department')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-4">
                            <label for="reports_to" class="form-label text-capitalize">Reports to</label>
                            <select wire:model="reports_to" class="form-select @error('reports_to') is-invalid @enderror">
                                <option selected>Select Role</option>
                                @foreach($this->getRoles() as $roles)
                                    <option value="{{ $roles['id'] }}">{{ \Str::ucfirst(\Str::lower($roles['role_name'])) }}</option>
                                @endforeach
                            </select>
                            @error('reports_to')
                            <span class="invalid-feedback" role="alert">
                                <strong>The reports-to role is required.</strong>
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
