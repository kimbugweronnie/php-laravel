<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between mb-3">
            <div class="d-flex justify-content-between">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle text-capitalize" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        List of Departments
                    </button>
                    <ul class="dropdown-menu">
                        @forelse($departments as $department)
                            <li><button wire:click="fetchRoles({{ $department['id'] }})" class="dropdown-item" href="#">{{ $department['department_name'] }}</button></li>
                        @empty
                            <li>No Departments</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            <a class="btn btn-outline-primary text-capitalize" href="{{ route('departmentRoles.create') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-plus" viewBox="0 0 18 18">
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
                Create Department Role
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="border bg-white rounded-3 shadow px-4 py-3">
                @if ($roles)
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-capitalize" scope="col">Role name</th>
                                <th class="text-capitalize" scope="col">Reports to</th>
                                <th scope="col">Department</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td><a class="text-decoration-none"  href="{{ route('departmentRoles.show', $role['id']) }}">{{ \Str::ucfirst(\Str::lower($role['role_name'])) }}</td>
                                    <td>
                                        @if($role['reports_to'])
                                            {{ \Str::ucfirst(\Str::lower($role['reports_to'])) }}
                                        @else
                                            --
                                        @endif
                                    </td>
                                    <td>
                                        {{ $role['related_department']['department_name'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>         
                    </table>
                @else
                    <div class="text-center">
                        No roles available
                    </div>
                @endif
            </div>
        </div>
    </div>  
</div>
