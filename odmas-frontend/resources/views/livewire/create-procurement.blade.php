<div class="container-fluid p-0">
    <div class="row"> 
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize">Procurement request </h3>
            <a class="btn btn-outline-secondary px-3" href="{{ route('procurements.index') }}">
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
                <form  wire:submit="procurementRequest">
                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="date" class="form-label text-capitalize">Date </label>
                            <input wire:model="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}"   id="date" value="{{ now()->format('Y-m-d') }}" min='{{ now()->format('Y-m-d') }}'>
                            @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The date  is required.</strong>
                                </span>
                            @enderror 
                        </div>
                        <div class="col-3">
                            <label for="title" class="form-label text-capitalize">Subject of procurement</label>
                            <input wire:model="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}"   id="title">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The title  is required.</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label for="location_for_delivery" class="form-label text-capitalize">Location for delivery</label>
                            <input wire:model="location_for_delivery" type="text" class="form-control @error('location_for_delivery') is-invalid @enderror" name="location_for_delivery" value="{{ old('location_for_delivery') }}"  id="location_for_delivery">
                            @error('location_for_delivery')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The location for delivery  is required.</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label for="related_activity" class="form-label">Activity</label>
                            <select wire:model="related_activity"  aria-label="Default select" class="form-select @error('related_activity') is-invalid @enderror">
                                <option value="">Select activity</option>
                                @forelse($activities as $activity)
                                    <option value="{{ $activity['id'] }}">{{ $activity['activity_name'] }}</option>
                                @empty
                                    <option>No activity</option>
                                @endforelse
                            </select> 
                            @error('related_activity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Activity invalid</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                     <h4 class="text-capitalize fw-bold">Item lists</h4>
                    <hr/>
                    <div class="row mb-3"> 
                        <div class="col-12 mb-3">
                            <label for="description" class="form-label text-capitalize">Description</label>
                            <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" name="description"  id="description" rows="2">{{ old('description') }}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The description  is required.</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3"> 
                        <div class="col-3">
                            <label for="quantity" class="form-label text-capitalize">Quantity</label>
                            <input wire:model="quantity" wire:change="calculateTotal()" type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity') }}"   id="quantity">
                            @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label for="unit_of_measure" class="form-label text-capitalize">Unit of measure</label>
                            <input wire:model="unit_of_measure" type="text" class="form-control @error('unit_of_measure') is-invalid @enderror" name="unit_of_measure" value="{{ old('unit_of_measure') }}"  id="unit_of_measure">
                            @error('unit_of_measure')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The quantity  must be at least 1.</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label for="estimated_unit_cost" class="form-label text-capitalize">Estimated unit cost</label>
                            <input wire:model="estimated_unit_cost" wire:change="calculateTotal()" type="number" class="form-control @error('estimated_unit_cost') is-invalid @enderror" name="estimated_unit_cost" value="{{ old('estimated_unit_cost') }}"   id="estimated_unit_cost">
                            @error('estimated_unit_cost')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The unit of measure is required.</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <div class="d-flex justify-content-between">
                                <label for="total_amount" class="form-label text-capitalize">Estimated total cost</label> 
                            </div>
                            <input wire:model="estimated_total_cost" type="number"  wire:change="calculateSubtotal()"  class="form-control @error('estimated_total_cost') is-invalid @enderror" name="estimated_total_cost" value="{{ old('estimated_total_cost') }}"   id="estimated_total_cost" readonly>
                            @error('estimated_total_cost')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The estimated unit cost  must be at least 1.</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        @foreach ($this->meta_fields as $key => $item)
                            <div class="col-12 mb-3">
                                <label for="description" class="form-label text-capitalize">Description</label>
                                <textarea wire:model="meta_fields.{{ $key }}.description" class="form-control @error('meta_fields.'. $key .'.description') is-invalid @enderror" id="description" rows="2">{{ old('description') }}</textarea>
                                 @error('meta_fields.'. $key .'.description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Description  is required.</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-3">
                                <label for="quantity" class="form-label text-capitalize">Quantity</label>
                                <input wire:model="meta_fields.{{ $key }}.quantity"  wire:change="calculateTotalCost('{{ $key }}')" type="number" class="form-control @error('meta_fields.'. $key .'.quantity') is-invalid @enderror" id="quantity">
                                @error('meta_fields.'. $key .'.quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Quantity  must be at least 1.</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-3">
                                <label for="unit_of_measure" class="form-label text-capitalize">Unit of measure</label>
                                <input wire:model="meta_fields.{{ $key }}.unit_of_measure" type="text"  class="form-control @error('meta_fields.'. $key .'.unit_of_measure') is-invalid @enderror" id="unit_of_measure">
                                @error('meta_fields.'. $key .'.unit_of_measure')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Unit of measure  is required.</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-3">
                                <label for="estimated_unit_cost" class="form-label text-capitalize">Estimated unit cost</label>
                                <input wire:model="meta_fields.{{ $key }}.estimated_unit_cost"  wire:change="calculateTotalCost('{{ $key }}')" type="number" class="form-control @error('meta_fields.'. $key .'.estimated_unit_cost') is-invalid @enderror" id="estimated_unit_cost">
                                @error('meta_fields.'. $key .'.estimated_unit_cost')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Estimated unit cost  must be at least 1.</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-3">
                                <div class="d-flex justify-content-between">
                                    <label for="total_amount" class="form-label text-capitalize">Estimated total cost</label>
                                </div>
                                <input wire:model="meta_fields.{{ $key }}.estimated_total_cost" type="number"  wire:change="calculateSubtotal()" class="form-control @error('meta_fields.'. $key .'.estimated_total_cost') is-invalid @enderror" name="estimated_total_cost" value="{{ old('estimated_total_cost') }}"   id="estimated_total_cost" readonly>
                                @error('meta_fields.'. $key .'.estimated_total_cost')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Estimated total cost  must be at least 1.</strong>
                                    </span>
                                @enderror
                            </div>

                            @if(count($this->meta_fields) > 0)
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" wire:click="removeRowToItemList({{ $key }})" class="btn btn-sm btn-outline-warning rounded text-capitalize mb-3">
                                        Remove item
                                    </button>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <button type="button" wire:click="addRowToItemList" class="btn btn-sm btn-outline-primary rounded text-capitalize mb-2">
                        Add item to list
                    </button>
                    <div class="row d-flex justify-content-end">
                        <div class="col-3">
                            <label for="total" class="form-label text-capitalize">Final Total</label>
                            <input class="form-control" value = "{{ $this->calculateSubtotal() }}" type="integer" id="total" readonly>
                        </div>
                    </div>
                    
                    <h4><strong class="text-capitalize">Budget code</strong></h4>
                     <hr/>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="activity" class="form-label">Activity</label>
                            <select wire:model="related_activity" required id="related_activity" class="form-select @error('related_activity') is-invalid @enderror">
                                <option selected>Choose Activity</option>
                                @foreach($activities as $activity)
                                    <option value="{{ $activity['id'] }}">{{ $activity['activity_name'] }}</option>
                                @endforeach
                            </select>
                            @error('related_activity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The related activity  is required.</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="cost_centre" class="form-label text-capitalize">Cost centre</label>
                            <select wire:model="cost_center" class="form-select @error('cost_center') is-invalid @enderror" id="related_activity">
                                <option selected>Choose Center</option>
                                @foreach($cost_centers as $center)
                                    <option value="{{ $center['id'] }}">{{ $center['cost_center_name'] }}</option>
                                @endforeach
                            </select>
                            @error('cost_center')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The cost center  is required.</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="currency" class="form-label text-capitalize">Currency</label>
                            <select wire:model="related_currency" class="form-select @error('related_currency') is-invalid @enderror" id="related_currency">
                                <option selected>Choose Currency</option>
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency['id'] }}">{{ $currency['currency_name'] }}</option>
                                @endforeach
                            </select>
                            @error('related_currency')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The related currency  is required.</strong>
                                </span>
                            @enderror
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

                    <div class="col-12 mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-3">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>