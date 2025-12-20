<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize">Edit Project Document approval steps </h3>
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
            <div class="border rounded-3 bg-white shadow pt-3 pb-4 px-5">
                <form  wire:submit="editProjDocApprovalSteps">
                    <div class="row">
                        <div class="col-6">
                            <label for="document_name" class="form-label">Document Name</label>
                            <input wire:model="document_name" type="text" class="form-control @error('document_name') is-invalid @enderror" value="{{ $document_name }}">
                            @error('document_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>document name date is required.</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="order_number" class="form-label">Order Number</label>
                            <input wire:model="order_number" type="text" class="form-control @error('order_number') is-invalid @enderror" value="{{ $order_number }}">
                            @error('order_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>order number is required.</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        @foreach($projectDocumentTemp['approval_steps'] as $approval_step)
                            <div class="col-6 mt-3">
                                <label for="related_approval_step" class="form-label text-capitalize">Approval Step</label>
                                <select wire:model="related_approval_step" class="form-select" id="related_approval_step">
                                    <option selected value="{{ $approval_step['related_approval_step']['id'] }}">{{ $approval_step['related_approval_step']['approval_step_name'] }}</option>
                                    @foreach($related_approval_steps as $related_approval_step)
                                        <option value="{{ $related_approval_step['id'] }}">{{ $related_approval_step['approval_step_name'] }}</option>
                                    @endforeach
                                </select>
                                    @error('')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>approval step field required</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-6 mt-3">
                                <label for="related_approver" class="form-label text-capitalize">Approver</label>
                                <select wire:model="related_approver" class="form-select" required id="related_approver">
                                    <option selected>{{ $approval_step['related_approver']['related_user']['first_name'] }} {{ $approval_step['related_approver']['related_user']['last_name'] }}</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee['related_user']['id'] }}">{{ $employee['related_user']['first_name'] }} {{ $employee['related_user']['last_name'] }} {{ $employee['related_role'] ? ' -- ' . $employee['related_role']['role_name'] : null }}</option>
                                    @endforeach
                                </select>
                                @error('')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>approver field required</strong>
                                    </span>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="col-12 mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-3">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>