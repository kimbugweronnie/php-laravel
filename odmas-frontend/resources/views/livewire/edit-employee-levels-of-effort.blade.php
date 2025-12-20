
<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize"> Edit Employee</h3>
            <a class="btn btn-secondary px-3" href="{{ route('employees.show', $employee['id']) }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-left mb-1" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0v-2z"/>
                    <path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                </svg>
                Back
            </a>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-12 mb-3">
             @include('messages.flash')
            <div class="border rounded-3 bg-white shadow py-4 px-5">
                <h4 class="text-capitalize fw-bold">Edit Levels Of Effort</h4>  <p class="mb-3 text-danger fw-bold"><i>*Levels of effort should be equal to 100%</i></p>
                 <p class="mb-3 text-danger fw-bold">*Do not choose a project more than once</i></p>
                <hr/>
                 <p class="mb-3 fw-bold">Current Project Attachments</p>
                <form  wire:submit="employeeProjectAttachment">
                    @if(count($this->attached_projects) > 0)
                        <div class="row mb-2">
                            @foreach($this->previous_attached as $key => $item)
                                <div class="col-3">
                                    <label for="project" class="form-label">Project</label>
                                    <select wire:model="previous_attached.{{ $key }}.related_project" name="project" id="project" class="form-select @error('previous_attached.'. $key .'.related_project') is-invalid @enderror" wire:change="getPreviousRoles('{{ $key }}')">
                                    @foreach($projects as $project)
                                            <option value="{{ $project['id'] }}">{{ $project['project_name'] }}</option>
                                        @endforeach
                                    </select>
                                     @error('previous_attached.' . $key . '.related_project')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                               <div class="col-3">
                                    <label for="project_role" class="form-label">Choose Project Role</label>
                                    <select wire:model="previous_attached.{{ $key }}.previous_project_role"  id="related_project_role" class="form-select @error('previous_attached.'. $key .'.previous_project_role') is-invalid @enderror" >
                                        @foreach($this->getPreviousRoles($key) as $role )
                                            <option value="{{ $role['id'] }}">{{ $role['role_name'] }}</option>
                                        @endforeach
                                    </select>
                                   @error('previous_attached.' . $key . '.previous_project_role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <label for="project_role" class="form-label">Choose Station</label>
                                    <select wire:model="previous_attached.{{ $key }}.previous_related_station" required id="related_station" class="form-select @error('previous_attached.'. $key .'.previous_related_station') is-invalid @enderror">
                                        @foreach($previous_stations as $station)
                                            <option value="{{ $station['id'] }}">{{ $station['station_name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('previous_attached.' . $key . '.previous_related_station')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-3 mb-3">
                                    <label for="percentage" class="form-label text-capitalize">Level Of Effort</label>
                                    <input type="number" class="form-control @error('previous_attached.'. $key .'.previous_level_of_effort') is-invalid @enderror"  wire:change="checkLevel()"   wire:model="previous_attached.{{ $key }}.previous_level_of_effort" value="$previous_attached.{{ $key }}.level_of_effort" id="level_of_effort">
                                    @error('previous_attached.' . $key . '.previous_level_of_effort')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>level of effort field must be at least 1.</strong>
                                        </span>
                                    @enderror
                                </div>
                                @if(count($this->previous_attached) > 0)
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" wire:click="removeRowToPreviousItemList({{ $key }})" class="btn btn-sm btn-outline-warning rounded text-capitalize mb-3">
                                        Remove Project & Level of Effort
                                    </button>
                                </div>
                            @endif
                            @endforeach
                        </div>
                    @else
                        <span class="mb-2">
                            <strong> No projects attached yet</strong>
                        </span>
                    @endif
                    <div class="row mb-2">
                        <hr/>
                        <h4 class="text-capitalize fw-bold">Add Project Attachment</h4>  
                        @foreach ($this->projects_attached as $key => $item)
                         
                            <div class="col-3">
                                <label for="project" class="form-label">Project</label>
                                <select wire:model="projects_attached.{{ $key }}.related_project"  id="project" class="form-select @error('projects_attached.'. $key .'.related_project') is-invalid @enderror" wire:change="getProjectRoles('{{ $key }}')">
                                    <option selected>Choose Project</option>
                                @foreach($projects as $project)
                                        <option value="{{ $project['id'] }}">{{ $project['project_name'] }}</option>
                                    @endforeach
                                </select>
                                @error('projects_attached.' . $key . '.related_project')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>project field required </strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-3">
                                <label for="project_role" class="form-label">Choose Project Role</label>
                                <select wire:model="projects_attached.{{ $key }}.related_project_role"  id="related_project_role" class="form-select @error('projects_attached.'. $key .'.related_project_role') is-invalid @enderror" >
                                    <option selected>Choose Project Role</option>
                                    @foreach($this->getProjectRoles($key) as $role )
                                        <option value="{{ $role['id'] }}">{{ $role['role_name'] }}</option>
                                    @endforeach
                                </select>
                                @error('projects_attached.' . $key . '.related_project_role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>project role required </strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-3">
                                <label for="related_station" class="form-label">Choose Station</label>
                                <select wire:model="projects_attached.{{ $key }}.related_station" class="form-select @error('projects_attached.'. $key .'.related_station') is-invalid @enderror" id="related_station" >
                                    <option selected>Choose Station</option>
                                    @foreach($stations as $station)
                                        <option value="{{ $station['id'] }}">{{ $station['station_name'] }}</option>
                                    @endforeach
                                </select>
                                 @error('projects_attached.' . $key . '.related_station')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>station field required</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-3 mb-3">
                                <label for="percentage" class="form-label text-capitalize">Level Of Effort</label>
                                <input type="number" class="form-control @error('projects_attached.'. $key .'.level_of_effort') is-invalid @enderror"   wire:change="checkLevel()"  wire:model="projects_attached.{{ $key }}.level_of_effort"  id="percentage">
                                @error('projects_attached.' . $key . '.level_of_effort')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>level of effort should be more than 1</strong>
                                    </span>
                                @enderror
                            </div>
                        @if(count($this->projects_attached) > 0)
                            <div class="d-flex justify-content-end mt-3">
                                <button type="button" wire:click="removeRowToItemList({{ $key }})" class="btn btn-sm btn-outline-warning rounded text-capitalize mb-3">
                                    Remove Project & Level of Effort
                                </button>
                            </div>
                        @endif
                        @endforeach
                    </div>
                    <button type="button" wire:click="addRowToItemList" class="btn btn-sm btn-outline-primary rounded text-capitalize mb-2">
                        Add Project & Level of Effort
                    </button>
                    <div class="col-12 mt-4 d-flex justify-content-end">
                       <button type="submit" class="btn btn-primary px-3" @if($this->checkLevel()) disabled @endif>
                            @if($this->checkLevel())
                                {{ $this->checkLevel() }}
                            @else
                                Submit
                            @endif
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
