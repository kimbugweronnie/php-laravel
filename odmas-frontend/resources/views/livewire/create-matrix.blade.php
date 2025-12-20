<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize">Travel Matrix</h3>
            <a class="btn btn-secondary px-3" href="{{ route('travels.index')}}">
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
                <form  wire:submit="travelMatrix">
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="week_start_date" class="form-label">Week Start Date</label>
                            <input wire:model="week_start_date" type="date" class="form-control @error('week_start_date') is-invalid @enderror" value="{{ old('week_start_date') }}" required>
                            @error('week_start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="week_end_date" class="form-label">Week End Date</label>
                            <input wire:model="week_end_date" type="date" class="form-control @error('week_end_date') is-invalid @enderror" value="{{ old('week_end_date') }}" required >
                            @error('week_end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>   
                    <div class="row mb-2">
                        @foreach ($this->travel_matrix_details as $key => $item)
                        <div class="row mb-3">          
                            <div class="col-6">
                                 <label for="destination_details" class="form-label text-capitalize">Destination Details</label>
                                <textarea wire:model="travel_matrix_details.{{ $key }}.destination_details" class="form-control @error('travel_matrix_details.' . $key . '.destination_details') is-invalid @enderror"  required id="destination_details" rows="3">travel_matrix_details.{{ $key }}.destination_details</textarea>
                                @error('destination_details')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                            </div>
                            <div class="col-6">
                                <label for="team" class="form-label">Team</label>
                                <select wire:model="travel_matrix_details.{{ $key }}.team"  data-placeholder="Choose person"  class="form-select @error('travel_matrix_details.'. $key .'.team') is-invalid @enderror" required id="teams">
                                    <option selected>Select Employee</option>
                                    @forelse($employees as $employee)
                                        <option value="{{ $employee['related_user']['first_name'] }} {{ $employee['related_user']['last_name'] }}">{{ $employee['related_user']['first_name'] }} {{ $employee['related_user']['last_name'] }} -- {{ $employee['role_name'] ? \Str::ucfirst(\Str::lower($employee['role_name'])) : null }}</option>
                                    @empty
                                        <option>No Employee</option>
                                    @endforelse
                                </select>
                                @error('travel_matrix_details.'. $key .'.team')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>select employee </strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">          
                            <div class="col-6">
                                <label for="driver_or_alternative" class="form-label">Driver or Alternative</label>
                                <input wire:model="travel_matrix_details.{{ $key }}.driver_or_alternative" type="text" class="form-control @error('travel_matrix_details.' . $key . '.driver_or_alternative') is-invalid @enderror" required id="driver_or_alternative">
                                @error('travel_matrix_details.' . $key . '.driver_or_alternative')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="remarks" class="form-label">Remarks</label>
                                <input wire:model="travel_matrix_details.{{ $key }}.remarks" type="text" class="form-control @error('pre_trip_request_fields.' . $key . '.remarks') is-invalid @enderror" required id="remarks">
                                    @error('travel_matrix_details.' . $key . '.remarks')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>  
                        @if(count($this->travel_matrix_details) > 0)
                            <div class="d-flex justify-content-end mt-3">
                                <button type="button" wire:click="removeRowToRecordList({{ $key }})" class="btn btn-sm btn-outline-warning rounded text-capitalize mb-3">
                                    Remove  Travel Matrix Detail
                                </button>
                            </div>
                        @endif
                        @endforeach
                    </div>
                    <button type="button" wire:click="addRowToRecordList" class="btn btn-sm btn-outline-primary rounded text-capitalize mb-2">
                        Add Travel Matrix Details
                    </button> 
                <div class="col-12 mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-3">Submit</button>
                </div>                   
                </form>
            </div>
        </div>
    </div>
</div>


