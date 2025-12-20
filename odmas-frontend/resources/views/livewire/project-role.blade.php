<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between mb-3">
            <div class="d-flex justify-content-between">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle text-capitalize" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        List of projects
                    </button>
                    <ul class="dropdown-menu">
                        @forelse($projects as $project)
                            <li><button wire:click="fetchRoles({{ $project['id'] }})" class="dropdown-item" href="#">{{ $project['project_name'] }}</button></li>
                        @empty
                            <li>No projects</li>
                        @endforelse
                    </ul>
                </div>
                <div class="mt-2 ms-2">
                    @if ($selectedProject)
                        <span class="text-capitalize fw-bold">{{ $selectedProject['project_name'] }}</span>
                    @else
                        Select A Project
                    @endif
                </div>
            </div>
            <a class="btn btn-outline-primary text-capitalize" href="{{ route('projectRoles.create') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-plus" viewBox="0 0 18 18">
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
                Create role
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="border bg-white rounded-3 shadow px-4 py-3">
                @if ($roles)
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-capitalize" scope="col">Role name</th>
                                <th class="text-capitalize" scope="col">Reports to</th>
                                <th scope="col">status </th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{ \Str::ucfirst($role['role_name']) }}</td>
                                    <td>
                                        @if($role['reports_to'])
                                            {{ \Str::ucfirst($role['reports_to']['role_name']) }}
                                        @else
                                            --
                                        @endif
                                    </td>
                                    @if($role['status'] == 1)
                                        <td><button class="btn btn-sm btn-outline-success rounded">Active</button></td>
                                    @else
                                        <td><button class="btn btn-sm btn-outline-warning rounded">Inactive</button></td>
                                    @endif
                                    <td>
                                        <ul class="navbar-nav navbar-align">
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="{{ route('departmentRoles.edit', $role['id']) }}">
                                                    <i class="align-middle me-1" data-feather="edit"></i>
                                                        Edit
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <!-- <a type="button" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('delete-role-{{ $role['id'] }}').submit();">
                                                        <i class="align-middle me-1" data-feather="trash-2"></i>
                                                        Delete
                                                    </a> -->
                                                </div>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <form action="{{ route('projectRoles.index', $role['id']) }}" class="hidden"
                                    id="delete-role-{{ $role['id'] }}" method="POST">
                                    @csrf
                                    @method('delete')
                                </form>
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
