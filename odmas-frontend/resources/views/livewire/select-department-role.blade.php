<div class="row mb-3">
                                <div class="col-3">
                                    <label for="project" class="form-label">Project</label>
                                    <select wire:model="previous_attached.{{ $key }}.related_project['id']" name="related_project" id="related_project" class="form-select" wire:change="getProjectRoles('{{ $key }}')" > 
                                        <option value="$previous_attached.{{ $key }}.related_project['id']" selected>{{ $previous_attached[$key]['related_project']['project_name'] }}</option>
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
                                    <select wire:model="previous_attached.{{ $key }}.related_project_role"  id="related_project_role" class="form-select">
                                        <option value="$previous_attached.{{ $key }}.related_project_role['id']" selected>{{ $previous_attached[$key]['related_project_role']['role_name'] }}</option>
                                        @foreach($this->getProjectRoles($key) as $role )
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
                                    <label for="related_station" class="form-label">Choose Station</label>
                                    <select wire:model="previous_attached.{{ $key }}.related_station"  id="related_station" class="form-select" >
                                        <option value="$previous_attached.{{ $key }}.related_station" selected>{{ $previous_attached[$key]['related_station'] }}</option>
                                        @foreach($stations as $station)
                                            <option value="{{ $station['id'] }}">{{ $station['id'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('related_project_role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-3 mb-2">
                                    <label for="level_of_effort" class="form-label text-capitalize">Level Of Effort</label>
                                    <input type="number" class="form-control @error('percentage') is-invalid @enderror"  wire:model="previous_attached.{{ $key }}.level_of_effort" value="$previous_attached.{{ $key }}.level_of_effort" id="level_of_effort">
                                    @error('level_of_effort')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>  

                             $this->previous_attached[] = [
                    'related_project' => $value['related_project'],
                    'related_project_role'=> $value['related_project_role'],
                    'related_station' => $value['related_station'],
                    'level_of_effort' =>  $value['level_of_effort']
                ];