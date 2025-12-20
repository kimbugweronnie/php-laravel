<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize">Travel request </h3>
            <a class="btn btn-outline-secondary px-3" href="{{ route('travels.index') }}">
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
                <form  wire:submit="travelRequest">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="title" class="form-label text-capitalize">Title</label>
                            <input wire:model="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" id="title">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="date" class="form-label text-capitalize">Date of request</label>
                            <input wire:model="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}"  id="date" value="{{ now()->format('Y-m-d') }}" >
                            @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12 mt-3">
                            <label for="description" class="form-label text-capitalize">Description</label>
                            <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" name="description"  id="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                     <hr/>
                    <h4 class="text-capitalize fw-bold">Pre-trip items</h4>  
                    <div class="row mb-3">
                        <div class="col-2">
                            <label for="date_of_travel" class="form-label text-capitalize">Date Of Travel</label>
                            <input wire:model="date_of_travel" type="date" class="form-control @error('date_of_travel') is-invalid @enderror" name="date" value="{{ old('date_of_travel') }}"  id="date_of_travel" value="{{ now()->format('Y-m-d') }}">
                            @error('date_of_travel')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-2">
                            <label for="time_of_day" class="form-label text-capitalize">Time Of Day</label>
                            <input wire:model="time_of_day" type="time" class="form-control @error('time_of_day') is-invalid @enderror" name="time_of_day" value="{{ old('time_of_day') }}"  id="time_of_day">
                            @error('time_of_day')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-2">
                            <label for="origin_location" class="form-label text-capitalize">Origin</label>
                            <input wire:model="origin_location" type="text" class="form-control @error('origin_location') is-invalid @enderror" name="origin_location" value="{{ old('origin_location') }}"  id="origin_location">
                            @error('origin_location')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-2">
                            <label for="destination_location" class="form-label text-capitalize">Destination</label>
                            <input wire:model="destination_location" type="text" class="form-control @error('destination_location') is-invalid @enderror" name="destination_location" value="{{ old('destination_location') }}"  id="destination_location">
                            @error('destination_location')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-2">
                            <label for="transport_mode" class="form-label">Mode of Transport</label>
                            <select name="transport_mode" id="transport_mode" class="form-select @error('transport_mode') is-invalid @enderror"  wire:model="transport_mode">
                                <option selected>Choose Transport Mode</option>
                                <option value="Vehicle">Vehicle</option>
                            </select>
                            @error('transport_mode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-2">
                            <label for="number_of_travelers" class="form-label text-capitalize">No. of Travelers</label>
                            <input wire:model="number_of_travelers" type="number" class="form-control @error('number_of_travelers') is-invalid @enderror" name="number_of_travelers" value="{{ old('number_of_travelers') }}" id="number_of_travelers">
                            @error('number_of_travelers')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-2">
                        @foreach ($this->pre_trip_request_fields as $key => $item)
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label for="date_of_travel" class="form-label text-capitalize">Date Of Travel</label>
                                    <input wire:model="pre_trip_request_fields.{{ $key }}.date_of_travel" type="date" class="form-control @error('pre_trip_request_fields.'. $key .'.date_of_travel') is-invalid @enderror" id="date_of_travel">
                                    @error('pre_trip_request_fields.' . $key . '.date_of_travel')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>Date of travel is required.</strong>
                                        </span>
                                    @enderror
                                </div>
                                 <div class="col-2">
                                    <label for="time_of_day" class="form-label text-capitalize">Time Of Day</label>
                                    <input wire:model="pre_trip_request_fields.{{ $key }}.time_of_day" type="time" class="form-control @error('pre_trip_request_fields.' . $key . '.time_of_day') is-invalid @enderror"  id="time_of_day">
                                    @error('pre_trip_request_fields.' . $key . '.time_of_day')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>Time of day field is required.</strong>
                                        </span>
                                    @enderror
                                </div>  

                                <div class="col-2">
                                    <label for="origin_location" class="form-label text-capitalize">Origin</label>
                                    <input wire:model="pre_trip_request_fields.{{ $key }}.origin_location" type="text" class="form-control @error('pre_trip_request_fields.' . $key .'.origin_location') is-invalid @enderror" id="origin_location">
                                    @error('pre_trip_request_fields.' . $key .'.origin_location')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>Origin location  is required.</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-2">
                                    <label for="destination_location" class="form-label text-capitalize">Destination</label>
                                    <input wire:model="pre_trip_request_fields.{{ $key }}.destination_location" type="text" class="form-control @error('pre_trip_request_fields.' . $key . '.destination_location') is-invalid @enderror" id="destination_location">
                                    @error('pre_trip_request_fields.' . $key . '.destination_location')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>Destination location  is required.</strong>
                                        </span>
                                    @enderror
                                </div> 

                                <div class="col-2">
                                    <label for="transport_mode" class="form-label">Mode of Transport</label>
                                    <select wire:model="pre_trip_request_fields.{{ $key }}.transport_mode" class="form-select @error('pre_trip_request_fields.'. $key .'.transport_mode') is-invalid @enderror" required>
                                        <option selected>Select Transport Mode</option>
                                        <option value="Vehicle">Vehicle</option>
                                    </select>
                                    @error('pre_trip_request_fields.'. $key .'.transport_mode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>The selected transport mode is invalid</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-2">
                                    <label for="number_of_travelers" class="form-label text-capitalize">No. Of Traveler</label>
                                    <input wire:model="pre_trip_request_fields.{{ $key }}.number_of_travelers" type="number" class="form-control @error('pre_trip_request_fields.'. $key .'.number_of_travelers') is-invalid @enderror" >
                                     @error('pre_trip_request_fields.' . $key . '.number_of_travelers')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>The number of travelers  must be at least 1.</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> 
                            <div class="row">
                                @if(count($this->pre_trip_request_fields) > 0)
                                    <div class="d-flex justify-content-end ">
                                        <button type="button" wire:click="removeRowTotripList({{ $key }})" class="btn btn-sm btn-outline-warning rounded text-capitalize mb-3">
                                            Remove pre-trip item
                                        </button>
                                    </div>
                                @endif 
                            </div>
                        @endforeach
                    </div>
                    <button type="button" wire:click="addRowTotripList" class="btn btn-sm btn-outline-primary rounded text-capitalize my-2">
                        Add pre-trip item to list
                    </button> 
                    <hr />
                    <div class="row mb-4">
                        <div class="col-4">
                            <label class="col-form-label text-capitalize">Is there Other Communication?</label>
                            <select wire:model="communication" wire:change="hasOtherCommunication"  class="form-select">
                                <option selected>Choose Yes/No</option>
                                <option name="yes" value="yes">Yes</option>
                                <option name="no" value="no">No</option>
                            </select>
                        </div>
                        @if($this->hasOtherCommunication() == "yes")
                            <div class="col-4">
                                <label for="travel_other_communication" class="form-label text-capitalize">Other Communication</label>  
                                <input  wire:model="travel_other_communication" type="string" class="form-control @error('travel_other_communication') is-invalid @enderror"  value="{{ old('travel_other_communication') }}" id="travel_other_communication">
                                 @error('travel_other_communication')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-4">
                                <label for="travel_other_communication_ammount" class="form-label text-capitalize">Amount</label>  
                                <input  wire:model="travel_other_communication_ammount" type="number" class="form-control @error('travel_other_communication_ammount') is-invalid @enderror"  value="{{ old('travel_other_communication_ammount') }}" id="travel_other_communication">
                                 @error('travel_other_communication_ammount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @endif
                    </div>
                    <div class="row mb-4">
                        <div class="col-4">
                            <label class="col-form-label text-capitalize">Is there contigency?</label>
                            <select wire:model="contigency" wire:change="hasContigency"  class="form-select">
                                <option selected >Choose Yes/No</option>
                                <option name="yes" value="yes">Yes</option>
                                <option name="no" value="no">No</option>
                            </select>
                        </div>
                        @if($this->hasContigency() == "yes")
                            <div class="col-4">
                                <label for="contigency" class="form-label text-capitalize">Description</label>  
                                <input  wire:model="travel_contingency_description" type="text" class="form-control @error('travel_contingency_description') is-invalid @enderror"  value="{{ old('travel_contingency_description') }}" id="travel_contingency_description">
                                @error('travel_contingency_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-4">
                                <label for="contigency" class="form-label text-capitalize">Amount</label>  
                                <input  wire:model="travel_contingency_amount" type="number" class="form-control @error('travel_contingency_amount') is-invalid @enderror"  value="{{ old('travel_contingency_amount') }}" id="travel_contingency_amount">
                                @error('travel_contingency_amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @endif
                    </div>

                    <hr/>

                    <h4 class="text-capitalize fw-bold">Travel advance items</h4>  
                    
                    <div class="row mb-3">
                        <div class="col-2">
                            <label for="name_of_persons" class="form-label text-capitalize">Name Of Person</label>
                            <input wire:model="name_of_persons" type="text" class="form-control @error('name_of_persons') is-invalid @enderror" name="name_of_persons" value="{{ old('name_of_persons') }}"  id="name_of_persons">
                            @error('name_of_persons')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label for="designation" class="form-label text-capitalize">Designation</label>
                            <input wire:model="designation" type="text" class="form-control @error('designation') is-invalid @enderror" name="designation" value="{{ old('designation') }}"  id="designation">
                            @error('designation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-2">
                            <label for="days" class="form-label text-capitalize">Days</label>
                            <input wire:model="days"  wire:change="calculateTotal()" type="number" class="form-control @error('days') is-invalid @enderror" name="days" value="{{ old('days') }}"  id="days">
                            @error('days')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-2">
                            <label for="rate" class="form-label text-capitalize">Rate</label>
                            <input wire:model="rate" type="number"  wire:change="calculateTotal()" class="form-control @error('rate') is-invalid @enderror" name="rate" value="{{ old('rate') }}"  id="rate">
                            @error('rate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label for="total" class="form-label text-capitalize">Total</label>
                            <input wire:model="total" wire:change="calculateSubtotal()" type="number" class="form-control @error('total') is-invalid @enderror" name="total" value="{{ old('total') }}"  id="total" disabled>
                            @error('total')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-2">
                        @foreach ($this->travel_advance_request_fields as $key => $item)
                        <div class="row mb-3">
                            <div class="col-2">
                                <label for="name_of_persons" class="form-label text-capitalize">Name Of Person</label>
                                <input wire:model="travel_advance_request_fields.{{ $key }}.name_of_persons" type="text" class="form-control @error('travel_advance_request_fields.' . $key . '.name_of_persons') is-invalid @enderror" >
                                @error('travel_advance_request_fields.' . $key . '.name_of_persons')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>name of persons is required.</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-3">
                                <label for="designation" class="form-label text-capitalize">Designation</label>
                                <input wire:model="travel_advance_request_fields.{{ $key }}.designation" type="text" class="form-control @error('travel_advance_request_fields.' . $key . '.designation') is-invalid @enderror"   id="designation">
                                 @error('travel_advance_request_fields.' . $key . '.designation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Designation is required.</strong>
                                    </span>
                                @enderror
                            </div> 
                            <div class="col-2">
                                <label for="days" class="form-label text-capitalize">Days</label>
                                <input wire:model="travel_advance_request_fields.{{ $key }}.days"  wire:change="calculateTotalCost('{{ $key }}')" type="text" class="form-control @error('travel_advance_request_fields.' . $key . '.days') is-invalid @enderror"  id="days">
                                @error('travel_advance_request_fields.' . $key . '.days')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Days  must be at least 1.</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-2">
                                <label for="rate" class="form-label text-capitalize">Rate</label>
                                <input wire:model="travel_advance_request_fields.{{ $key }}.rate" value="1000"  wire:change="calculateTotalCost('{{ $key }}')"  type="number" class="form-control @error('travel_advance_request_fields.'. $key .'.rate') is-invalid @enderror" id="rate" >
                                @error('travel_advance_request_fields.' . $key . '.rate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Rate must be at least 1.</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-3">
                                <label for="total" class="form-label text-capitalize">Total</label>
                                <input wire:model="travel_advance_request_fields.{{ $key }}.total"  wire:change="calculateSubtotal()" type="integer" class="form-control @error('total') is-invalid @enderror"  id="total" disabled>
                                @error('travel_advance_request_fields.' . $key . '.total')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                           
                        </div>  
                        <div class="row">
                            @if(count($this->travel_advance_request_fields) > 0)
                                <div class="d-flex justify-content-end">
                                    <button type="button" wire:click="removeRowToAdvanceList({{ $key }})" class="btn btn-sm btn-outline-warning rounded text-capitalize mb-3">
                                        Remove travel advance item
                                    </button>
                                </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <button type="button" wire:click="addRowToAdvanceList" class="btn btn-sm btn-outline-primary rounded text-capitalize  my-2">
                        Add travel advance items
                    </button>

                    <div class="row d-flex justify-content-end">
                        <div class="col-3">
                            <label for="total" class="form-label text-capitalize">Final Total</label>
                            <input class="form-control" value = "{{ $this->calculateSubtotal() }}" type="integer" id="total" readonly>
                        </div>
                    </div>
                    
                    @if($temp['related_region_project']['station_name'] == "HEAD OFFICE")
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="head_of_section_id" class="form-label text-capitalize">Head of Section</label>
                                <select wire:model="head_of_section_id" class="form-select @error('head_of_section_id') is-invalid @enderror" id="head_of_section_id">
                                    <option selected>Choose person</option>
                                    @foreach($projectHeadOfSections as $projectUser)
                                        <option value="{{ $projectUser['related_user']['id'] }}">{{ $projectUser['related_user']['first_name'] }} {{ $projectUser['related_user']['last_name'] }} {{ $projectUser['role_name'] ? '-- ' .  \Str::ucfirst(\Str::lower($projectUser['role_name'])) : null }}</option>
                                    @endforeach
                                </select>
                                @error('head_of_section_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>The person is required.</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    @elseif($temp['related_region_project']['station_name'] == "REGIONAL")
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="regional_team_lead_id" class="form-label text-capitalize">Regional Team Lead</label>
                                <select wire:model="regional_team_lead_id" class="form-select @error('regional_team_lead_id') is-invalid @enderror" id="regional_team_lead_id">
                                    <option selected>Choose person</option>
                                    @foreach($projectUsers as $projectUser)
                                        <option value="{{ $projectUser['related_user']['id'] }}">{{ $projectUser['related_user']['first_name'] }} {{ $projectUser['related_user']['last_name'] }} {{ $projectUser['role_name'] ? '-- ' .  \Str::ucfirst(\Str::lower($projectUser['role_name'])) : null }}</option>
                                    @endforeach
                                </select>
                                @error('regional_team_lead_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>The person is required.</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-12 mt-4 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-3">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>