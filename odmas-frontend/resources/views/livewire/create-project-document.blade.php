<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize">Add Project Document </h3>
            <a class="btn btn-outline-secondary px-3" href="{{ route('projectDocuments.index') }}">
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
                <form  wire:submit="projectDocument">
                    <div class="row mb-3">
                        <div class="col-6">
                           <label for="related_project" class="form-label text-capitalize">Project</label>
                            <select wire:model="related_project" class="form-select @error('related_project') is-invalid @enderror" id="related_project">
                                <option selected>Choose Project</option>
                                @foreach($related_projects as $related_project)
                                    <option value="{{ $related_project['id'] }}">{{ $related_project['project_name'] }}</option>
                                @endforeach
                            </select>
                            @error('related_project')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The project field is required.</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="related_document_type" class="form-label text-capitalize">Document Type</label>
                            <select wire:model="related_document_type"  class="form-select @error('related_document_type') is-invalid @enderror" id="related_document_type">
                                <option selected>Choose Document Type</option>
                                @foreach($related_document_types as $related_document_type)
                                    <option value="{{ $related_document_type['id'] }}">{{ \Str::ucfirst(\Str::lower($related_document_type['document_type_name'])) }}</option>
                                @endforeach
                            </select>
                            @error('related_document_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The document type field is required.</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3"> 
                        <div class="col-6">
                            <label for="related_document_domain" class="form-label text-capitalize">Document Domain</label>
                            <select wire:model="related_document_domain"  class="form-select @error('related_document_domain') is-invalid @enderror"  id="related_document_domain">
                                <option selected>Choose Document Domain</option>
                                @foreach($related_document_domains as $related_document_domain)
                                    <option value="{{ $related_document_domain['id'] }}">{{ \Str::ucfirst(\Str::lower($related_document_domain['document_domain_name'])) }}</option>
                                @endforeach
                            </select>
                            @error('related_document_domain')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The  document domain field is required.</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="related_region_project" class="form-label text-capitalize">Region</label>
                            <select wire:model="related_region_project"  class="form-select @error('related_region_project') is-invalid @enderror" id="related_region_project">
                                <option selected>Choose Region</option>
                                @foreach($related_region_projects as $related_region_project)
                                    <option value="{{ $related_region_project['id'] }}">{{ \Str::ucfirst(\Str::lower($related_region_project['station_name'])) }}</option>
                                @endforeach
                            </select>
                            @error('related_region_project')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The region field is required.</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3"> 
                        <div class="col-6">
                             <label for="document_name" class="form-label text-capitalize">Document Name</label>
                            <input wire:model="document_name" type="text" class="form-control @error('document_name') is-invalid @enderror" name="document_name" value="{{ old('document_name') }}"  id="document_name">
                            @error('document_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror 
                        </div>
                        <div class="col-6">
                             <label for="order_number" class="form-label text-capitalize">Order Number</label>
                            <input wire:model="order_number" type="text" class="form-control @error('order_number') is-invalid @enderror" name="order_number" value="{{ old('order_number') }}"  id="order_number">
                            @error('order_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <h4 class="text-capitalize">Add Aproval Steps</h4>  <p class="mb-3 text-danger"><i>*Atleast two approval steps must be added </i></p>
                    <hr/>
                    <div class="row mb-2">
                        @foreach ($this->approval_steps_fields as $key => $item)
                            <div class="col-6">
                                <label for="related_approval_step" class="form-label text-capitalize">Approval Step</label>
                                <select wire:model="approval_steps_fields.{{ $key }}.related_approval_step" class="form-select @error('approval_steps_fields.'. $key .'.related_approval_step') is-invalid @enderror" id="related_approval_step">
                                    <option selected>Choose Step</option>
                                    @foreach($related_approval_steps as $related_approval_step)
                                        <option value="{{ $related_approval_step['id'] }}">{{ $related_approval_step['approval_step_name'] }}</option>
                                    @endforeach
                                </select>
                                 @error('approval_steps_fields.'. $key .'.related_approval_step')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>approval step field required</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="related_approver" class="form-label text-capitalize">Approver</label>
                                <select wire:model="approval_steps_fields.{{ $key }}.related_approver" class="form-select @error('approval_steps_fields.'. $key .'.related_approver') is-invalid @enderror" required id="related_approver">
                                    <option selected>Choose Step</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee['id'] }}">{{ $employee['related_user']['first_name'] }} {{ $employee['related_user']['last_name'] }} {{ $employee['related_role'] ? ' -- ' . $employee['related_role']['role_name'] : null }}</option>
                                    @endforeach
                                </select>
                                @error('approval_steps_fields.'. $key .'.related_approver')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>approver field required</strong>
                                    </span>
                                @enderror
                            </div>

                            @if(count($this->approval_steps_fields) > 0)
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" wire:click="removeRowToItemList({{ $key }})" class="btn btn-sm btn-outline-warning rounded text-capitalize mb-3">
                                        Remove step
                                    </button>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <button type="button" wire:click="addRowToItemList" class="btn btn-sm btn-outline-primary rounded text-capitalize mb-2">
                        Add approval step
                    </button>
                    
                    <div class="col-12 mt-4 d-flex justify-content-end">
                        @if(count($this->approval_steps_fields) < 2)
                            <button type="submit" class="btn btn-primary px-3" disabled >Submit</button>
                        @else
                            <button type="submit" class="btn btn-primary px-3">Submit</button>
                        @endif

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>