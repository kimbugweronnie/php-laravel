
<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize"> Edit Payment Request </h3>
            <a class="btn btn-outline-secondary px-3" href="{{ route('payments.show',$paymentReq['related_document_request']['id']) }}">
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
                <form  wire:submit="editPayment">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="payment_date" class="form-label">Date</label>
                            <input wire:model="date" type="date" class="form-control @error('date') is-invalid @enderror" value="{{ $date }}">
                            @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The payment date is required.</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="title" class="form-label">Title</label>
                            <input wire:model="title" type="text" class="form-control @error('title') is-invalid @enderror" value="{{ $title }}">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The title is required.</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="center" class="form-label text-capitalize">Cost center</label>
                            <select wire:model="center" aria-label="Default select" class="form-select @error('center') is-invalid @enderror">
                                <option value="{{ $previous_center['id'] }}" selected>{{ $previous_center['cost_center_name'] }}</option>
                                @foreach($centers as $center)
                                    <option value="{{ $center['id'] }}" >{{ $center['cost_center_name'] }}</option>
                                @endforeach
                            </select>
                             @error('center')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Cost Center invalid</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label for="related_activity" class="form-label">Activity</label>
                            <select wire:model="related_activity" aria-label="Default select" class="form-select @error('related_activity') is-invalid @enderror">
                                <option value="{{ $previous_actvity['id'] }}" selected>{{ $previous_actvity['activity_name'] }}</option>
                                 @foreach($activities as $activity)
                                    <option value="{{ $activity['id'] }}" >{{ $activity['activity_name'] }}</option>
                                @endforeach
                            </select> 
                            @error('related_activity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Activity invalid</strong>
                                </span>
                            @enderror 
                        </div>
                        <div class="col-3">
                            <label for="currency" class="form-label text-capitalize">Currency</label>
                            <select wire:model="currency" id="currency" aria-label="Default select" class="form-select @error('currency') is-invalid @enderror">
                                <option value="{{ $previous_currency['id'] }}">{{ $previous_currency['currency_symbol'] }}</option>
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency['id'] }}">{{ $currency['currency_symbol'] }}</option>
                                @endforeach
                            </select>
                            @error('currency')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Currency invalid</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <div class="d-flex justify-content-between">
                                <label for="total_amount" class="form-label text-capitalize">Sub total</label>

                            </div>
                            <input wire:model="total_amount" type="number" class="form-control @error('total_amount') is-invalid @enderror" value="{{ $total_amount }}" readonly>
                            @error('total_amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <h4 class="text-capitalize fw-bold">Current Items</h4>  
                     <hr/>
                    @foreach ($this->previous_items_attached as $key => $item)
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="date" class="form-label text-capitalize">Date</label>
                            <input wire:model="previous_items_attached.{{ $key }}.date" id="date"  value="{{ 'previous_items_attached.'. $key .'.date' }}" type="date" class="form-control @error('previous_items_attached.'. $key .'.date') is-invalid @enderror">
                            @error('previous_items_attached.'. $key .'.date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Date is required</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-4">
                                <label for="budget_code" class="form-label text-capitalize">Budget code</label>
                            <input wire:model="previous_items_attached.{{ $key }}.budget_code" value="{{ 'previous_items_attached.' . $key . '.budget_code' }}" type="text" class="form-control @error('previous_items_attached.'. $key .'.budget_code') is-invalid @enderror">
                            @error('previous_items_attached.'. $key .'.budget_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Budget Code is required</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="amount" class="form-label text-capitalize">Amount</label>
                            <input wire:model="previous_items_attached.{{ $key }}.amount"  value="{{ 'previous_items_attached.' . $key . '.amount' }}" wire:change = "getFinalTotal" type="number" class="form-control @error('previous_items_attached.'. $key .'.amount') is-invalid @enderror">
                            @error('previous_items_attached.'. $key .'.amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Amount should be atleast 1</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12 mt-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea wire:model="previous_items_attached.{{ $key }}.description" class="form-control @error('previous_items_attached.'. $key .'.description') is-invalid @enderror" rows="2">{{ $this->previous_items_attached[$key]['description'] }}</textarea>
                            @error('previous_items_attached.'. $key .'.description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Description is required.</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    @if(count($this->previous_items_attached) > 0)
                        <div class="d-flex justify-content-end mt-2">
                            <button type="button" wire:click="removeRowPreviousItemList({{ $key }})" class="btn btn-sm btn-outline-warning rounded text-capitalize mb-3">
                                Remove previous item
                            </button>
                        </div>
                    @endif 
                    @endforeach
                    <h4 class="text-capitalize fw-bold">Item list</h4>
                    <hr/>
                    <div>
                        @foreach ($this->meta_fields as $key => $item)
                            <div class="row mb-2">
                                <div class="col-4">
                                    <label for="date" class="form-label text-capitalize">Date</label>
                                    <input wire:model="meta_fields.{{ $key }}.date" type="date" class="form-control @error('meta_fields.'. $key .'.date') is-invalid @enderror">
                                    @error('meta_fields.'. $key .'.date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>Date is required</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="budget_code" class="form-label text-capitalize">Budget code</label>
                                    <input wire:model="meta_fields.{{ $key }}.budget_code" type="text" class="form-control @error('meta_fields.'. $key .'.budget_code') is-invalid @enderror">
                                    @error('meta_fields.'. $key .'.budget_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>Budget Code is required</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="amount" class="form-label text-capitalize">Amount</label>
                                    <input wire:model="meta_fields.{{ $key }}.amount" wire:change = "getFinalTotal" type="number" class="form-control @error('meta_fields.'. $key .'.amount') is-invalid @enderror">
                                    @error('meta_fields.'. $key .'.amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>Amount should be atleast 1</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="description" class="form-label">Description</label>
                                <textarea wire:model="meta_fields.{{ $key }}.description"  class="form-control @error('meta_fields.'. $key .'.description') is-invalid @enderror" rows="2" >{{ old('description') }}</textarea>
                                @error('meta_fields.'. $key .'.description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Description is required.</strong>
                                    </span>
                                @enderror
                            </div>
                            @if(count($this->meta_fields) > 0)
                                <div class="d-flex justify-content-end">
                                    <button type="button" wire:click="removeRowToItemList({{ $key }})" class="btn btn-sm btn-outline-warning rounded text-capitalize mb-3">
                                        Remove item
                                    </button>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    
                    <button type="button" wire:click="addRowToItemList" class="btn btn-sm btn-outline-primary rounded text-capitalize mt-1">
                        Add item to list
                    </button>

                    {{-- <div class="row my-3">
                        <div class="col-12">
                            <label for="head_of_section_id" class="form-label text-capitalize">Head of Section</label>
                            <select wire:model="head_of_section_id" class="form-select @error('head_of_section_id') is-invalid @enderror" id="head_of_section_id">
                                <option selected value="">Choose person</option>
                                @foreach($projectUsers as $projectUser)
                                    <option value="{{ $projectUser['related_user']['id'] }}">{{ $projectUser['related_user']['first_name'] }} {{ $projectUser['related_user']['last_name'] }} {{ $projectUser['role_name'] ? '-- ' .  $projectUser['role_name'] : null }}</option>
                                @endforeach
                            </select>
                            @error('head_of_section_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The person is required.</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="regional_team_lead_id" class="form-label text-capitalize">Regional Team Lead</label>
                            <select wire:model="regional_team_lead_id" class="form-select @error('regional_team_lead_id') is-invalid @enderror" id="regional_team_lead_id">
                                <option selected value="">Choose person</option>
                                @foreach($projectUsers as $projectUser)
                                    <option value="{{ $projectUser['related_user']['id'] }}">{{ $projectUser['related_user']['first_name'] }} {{ $projectUser['related_user']['last_name'] }} {{ $projectUser['role_name'] ? '-- ' .  $projectUser['role_name'] : null }}</option>
                                @endforeach
                            </select>
                            @error('regional_team_lead_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The person is required.</strong>
                                </span>
                            @enderror
                        </div>
                    </div> --}}
                    
                    <div class="col-12 mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-3">Submit</button>
                    </div>
                </form>
            </div>
        </div> 
    </div>   
</div>
