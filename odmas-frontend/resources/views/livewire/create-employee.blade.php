
<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize"> New Employee </h3>
            <a class="btn btn-outline-secondary px-3" href="{{ route('employees.index') }}">
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
                <form  wire:submit="createEmployee">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="first_name" class="form-label text-capitalize">First name</label>
                            <input wire:model="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror"  value="{{ old('first_name') }}"  id="first_name">
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="last_name" class="form-label text-capitalize">Last name</label>
                            <input wire:model="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror"  value="{{ old('last_name') }}"  id="last_name">
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="username" class="form-label text-capitalize">Username</label>
                            <input wire:model="username" type="text" class="form-control @error('username') is-invalid @enderror"  value="{{ old('username') }}"  id="username">
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="email" class="form-label text-capitalize">Email</label>
                            <input wire:model="email" type="email" class="form-control @error('email') is-invalid @enderror"  value="{{ old('email') }}"  id="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="phone_number" class="form-label text-capitalize">Phone number</label>
                            <input  wire:model="phone_number"  type="text" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') }}" id="phone_number">
                            @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The phone number field is invalid</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="password" class="form-label text-capitalize">Password</label>
                            <input  wire:model="password" type="text" class="form-control @error('password') is-invalid @enderror"  value="{{ old('password') }}" id="password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="gender" class="form-label">Gender</label>
                            <select wire:model="gender" name="gender" required id="gender" class="form-select @error('gender') is-invalid @enderror">
                                <option selected >Choose Gender</option>
                                <option value="FEMALE">Female</option>
                                <option value="MALE">Male</option>
                            </select>
                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-4">
                            <label class="col-form-label text-capitalize">Does this employee have a department role?</label>
                            <select wire:model="option" wire:change="hasRole"  class="form-select">
                                <option selected >Choose Yes/No</option>
                                <option name="yes" value="yes">Yes</option>
                                <option name="no" value="no">No</option>
                            </select>
                        </div>
                        @if($this->hasRole() == "yes")
                        <div class="col-4">
                            <label for="related_role" class="form-label text-capitalize">Role</label>                          
                            <select wire:model="related_role" id="related_role" class="form-select @error('related_role') is-invalid @enderror">
                            <option selected >Choose Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role['id'] }}">{{ $role['role_name'] }}</option>
                            @endforeach
                            </select>
                            @error('related_role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The related role field required</strong>
                                </span>
                            @enderror
                        </div>
                        @endif

                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-4">
                            <label class="col-form-label text-capitalize">Does this employee have a project role?</label>
                            <select wire:model="project_option" wire:change="hasProjectRole"  class="form-select">
                                <option selected >Choose Yes/No</option>
                                <option name="yes" value="yes">Yes</option>
                                <option name="no" value="no">No</option>
                            </select>
                        </div>
                    </div> 
                    @if($this->hasProjectRole() == "yes")
                        <div class="row mt-3 mb-3">
                            <h4 class="text-capitalize fw-bold">Add Projects and Levels of Effort</h4>
                            <hr/>
                              <p class="mb-3 text-danger fw-bold">*Levels of effort should be equal to 100%</p>
                                 <p class="mb-3 text-danger fw-bold">*Do not choose a project more than once</p>
                            <div class="col-3">
                                <label for="related_project" class="form-label">Project</label>
                                <select wire:model="related_project" name="related_project" required id="related_project" class="form-select @error('related_project') is-invalid @enderror" wire:change="getRoles()">
                                <option selected >Choose Project</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project['id'] }}">{{ $project['project_name'] }}</option>
                                @endforeach
                                </select>
                                @error('related_project')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-3">
                                <label for="project_role" class="form-label">Choose Project Role</label>
                                <select wire:model="related_project_role" required id="related_project_role" class="form-select @error('related_project_role') is-invalid @enderror" >
                                    <option selected >Choose Project Role</option>
                                    @foreach($this->getRoles() as $role )
                                        <option value="{{ $role['id'] }}">{{ $role['role_name'] }}</option>
                                    @endforeach
                                </select>
                                @error('related_project_role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-3">
                                <label for="related_station" class="form-label">Station</label>
                                <select wire:model="related_station" name="related_station" required id="related_station" class="form-select @error('related_station') is-invalid @enderror">
                                <option selected >Choose Station</option>
                                @foreach($stations as $station)
                                    <option value="{{ $station['id'] }}">{{ $station['station_name'] }}</option>
                                @endforeach
                                </select>
                                @error('related_station')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-3 mb-3">
                                <label for="level_of_effort" class="form-label text-capitalize">Level Of Effort</label>
                                <input type="number" class="form-control @error('level_of_effort') is-invalid @enderror" wire:model="level_of_effort" wire:change="checkLevel()" value="{{ old('level_of_effort') }}"  id="level_of_effort">
                                @error('level_of_effort')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            @foreach ($this->projects_attached as $key => $item)
                                <div class="col-3">
                                    <label for="project" class="form-label">Project</label>
                                    <select wire:model="projects_attached.{{ $key }}.related_project" required id="project" class="form-select  @error('projects_attached.'. $key .'.related_project') is-invalid @enderror"  wire:change="getProjectRoles('{{ $key }}')">
                                        <option selected disabled>Choose Project</option>
                                    @foreach($projects as $project)
                                            <option value="{{ $project['id'] }}">{{ $project['project_name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('projects_attached.' . $key . '.related_project')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>related project invalid.</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <label for="project_role" class="form-label">Choose Project Role</label>
                                    <select wire:model="projects_attached.{{ $key }}.related_project_role" required id="related_project_role" class="form-select @error('projects_attached.'. $key .'.related_project_role') is-invalid @enderror">
                                        <option selected >Choose Project Role</option>
                                        @foreach($this->getProjectRoles($key) as $role )
                                            <option value="{{ $role['id'] }}">{{ $role['role_name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('projects_attached.'. $key .'.related_project_role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>related project invalid.</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <label for="project_role" class="form-label">Choose Station</label>
                                    <select wire:model="projects_attached.{{ $key }}.related_station"  id="related_station" class="form-select @error('projects_attached.'. $key .'.related_station') is-invalid @enderror">
                                        <option selected >Choose Station</option>
                                        @foreach($stations as $station)
                                               <option value="{{ $station['id'] }}">{{ $station['station_name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('projects_attached.'. $key .'.related_station')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>related station invalid.</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-3 mb-3">
                                    <label for="level_of_effort" class="form-label text-capitalize">Level Of Effort</label>
                                    <input type="number" class="form-control @error('projects_attached.'. $key .'.level_of_effort') is-invalid @enderror"  wire:model="projects_attached.{{ $key }}.level_of_effort"  wire:change="checkLevel()"  id="level_of_effort">
                                    @error('projects_attached.'. $key .'.level_of_effort')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>level of effort field must be at least 1.</strong>
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
                    @else
                    @endif 
                   
                    <div class="col-12 mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-3" @if($this->hasProjectRole() && $this->checkLevel()) disabled @endif>
                            @if($this->hasProjectRole() && $this->checkLevel())
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
