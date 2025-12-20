<div class="container-fluid p-0">
    <div class="row">
        @include('messages.flash')
    </div>
    <div class="row">
        <div class="col-lg-6 d-flex justify-content-between">
            <div>
                <h4 class="fw-bold py-1"><span class="text-muted fw-light">Projects / </span>List of Cost Center</h4>
            </div>
            <div>
                <label class="visually-hidden" for="project_id">Projects</label>
                <select wire:model="project_id" wire:change="reqByProject" class="form-select">
                    <option selected>Choose Project</option>
                    @forelse($projects as $project)
                        <option value="{{ $project['id'] }}">{{ $project['project_name'] }}</option>
                    @empty
                        <option>No projects</option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="col-lg-6 d-flex justify-content-end">
            <h4 class="text-capitalize">
                <a class="btn btn-outline-primary" href="{{ route('costCenters.create') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-plus" viewBox="0 0 18 18">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                    </svg>
                    Create Cost center
                </a>
            </h4>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-lg-12">
            <div class="border bg-white rounded-3 shadow px-4 py-3">
                @if ($costCenters)
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Cost Center Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($costCenters as $costCenter)
                                <tr>
                                    <td>{{ $costCenter['cost_center_name'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center">
                        No cost centers available
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>