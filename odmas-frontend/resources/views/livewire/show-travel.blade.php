@push('styles')
    <style>
        table,
        th,
        td {
            border: 2px solid #0a0a0a !important;
        }
    </style>
@endpush

<div class="container-fluid p-0">
    <div class="row">
        @include('messages.flash')
        <div class="col-lg-12 d-flex justify-content-between">
            <div>
                <a class="btn btn-outline-secondary px-3" href="{{ route('travels.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-box-arrow-in-left mb-1" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0v-2z" />
                        <path fill-rule="evenodd"
                            d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z" />
                    </svg>
                    Back
                </a>
            </div>
            <div class="d-flex justify-content-between">
                @if (is_null($this->isItApproved()))
                    <a class="btn btn-outline-secondary me-3"
                        href="{{ route('travels.editDetails', $travelReq['related_document_request']['id']) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-pencil-square mx-1" viewBox="0 0 19 19">
                            <path
                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                            <path fill-rule="evenodd"
                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                        </svg>
                        Edit
                    </a>
                @endif
                <a class="btn btn-outline-secondary me-3" id="openPdfLink" type="button"
                    href="{{ route('travel.pdf', $travelReq['related_document_request']['id']) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-printer me-2" viewBox="0 0 16 16">
                        <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
                        <path
                            d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1" />
                    </svg>
                    Print
                </a>
                @if (!is_null($this->isItApproved()))
                    <a class="btn btn-outline-secondary"
                        href="{{ route('create-travel-matrix', $travelReq['related_document_request']['id']) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-plus-circle mx-1">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="16"></line>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                        Add Travel Matrix
                    </a>
                @endif
            </div>
        </div>
    </div>
    <div class="row mt-3">
        @include('messages.flash')
        <div class="col-lg-12">
            <div class="border bg-white rounded-3 p-4">
                <div class="fs-4 text-uppercase fw-bold text-center pb-3">
                    <div><img src="{{ asset('img/full-logo.png') }}" width="140" alt=" travel image"></div>
                    <div>Uganda episcopal conference</div>
                    <div>Uganda catholic secretariat</div>
                    <div>Uganda Catholic medical bureau</div>
                    <div>
                        {{ $travelReq['related_document_request']['related_project_document']['related_project']['project_name'] }}
                    </div>
                    <div>TRAVEL REQUEST AUTHORIZATION</div>
                </div>
                <div>
                    <div class="row mb-3">
                        <div class="fs-4 ">This form is to be filled out BEFORE the trip for trip approval.</div>
                    </div>
                    <table class="table table-bordered">
                        <tbody>
                            <tr colspan="8">
                                <td class="">Traveler Names:</td>
                                <td class="" colspan="2">
                                    {{ $travelReq['related_document_request']['added_by']['first_name'] }}
                                    {{ $travelReq['related_document_request']['added_by']['last_name'] }}</td>
                                <td class="">Date of Request:</td>
                                <td class=""colspan="2">
                                    {{ Carbon\Carbon::parse($travelReq['related_document_request']['date_added'])->format('d-m-Y') }}
                                </td>

                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td colspan="8" class="fw-bold text-capitalize">A. Project Information</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="fw-bold text-capitalize">Project Name</td>
                                <td colspan="4" class="fw-bold text-capitalize">Project Number</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-uppercase" colspan="3">
                                    {{ $travelReq['related_document_request']['related_project_document']['related_project']['project_name'] }}
                                </td>
                                <td colspan="4">
                                    {{ $this->getProject($travelReq['related_document_request']['related_project_document']['related_project']['id']) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered">
                        <tbody>

                            <tr>
                                <td colspan="7" class="fw-bold">B. Trip Scope of Work (Attach or fill in a SOW for
                                    the trip),</td>

                            </tr>

                            <tr>
                                <td colspan="7" class="fw-bold ">Indicate, in detail, what will be accomplished
                                    during this trip.</td>
                            </tr>
                            <tr>
                                <td colspan="8" class="fw-bold ">{{ $travelReq['title'] }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td colspan="5" class="fw-bold">C. Pre Trip Request*</td>
                                <td colspan="3" class="fw-bold">Transportation Arrangements</td>
                            </tr>
                            <tr>
                                <td colspan="2"class="fw-bold">Date of Travel</td>
                                <td class="fw-bold">Origin (Location)</td>
                                <td colspan="2"class="fw-bold">Destination (Location)</td>
                                <td class="fw-bold">Mode</td>
                                <td class="fw-bold">Time of Day</td>
                                <td class="fw-bold">Number of Travelers</td>
                            </tr>

                            @foreach ($travelReq['meta_fields'] as $item)
                                <tr>
                                    <td colspan="2">{{ $item['date_of_travel'] }}</td>
                                    <td>{{ $item['origin_location'] }}</td>
                                    <td colspan="2">{{ $item['destination_location'] }}</td>
                                    <td>{{ $item['transport_mode'] }}</td>
                                    <td>{{ $item['time_of_day'] }}</td>
                                    <td>{{ $item['number_of_travelers'] }}</td>
                                </tr>
                            @endforeach

                            <tr>
                                <td colspan="8"class="fw-bold">* If more space is needed for travel schedule, you
                                    must attach a spreadsheet with the above columns and information.</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td colspan="7" class="fw-bold">D. Travel Advance Request (if the partner has
                                    travel advance policy)</td>
                            </tr>
                            <tr>
                                <td colspan="2"class="fw-bold">Details</td>
                                <td class="fw-bold">No. of Persons</td>
                                <td colspan="2"class="fw-bold">Days</td>
                                <td colspan="2"class="fw-bold">Rate</td>
                                <td class="fw-bold">Total</td>
                            </tr>
                            <tr>
                                <td colspan="2">Perdiem</td>
                                <td></td>
                                <td colspan="2"></td>
                                <td colspan="2"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2">(a) Officers-(
                                    @foreach ($travelReq['travel_advance_request_fields'] as $item)
                                        <span>{{ $item['name_of_persons'] }},</span>
                                    @endforeach
                                    )
                                </td>
                                <td>{{ $employees }}</td>
                                <td colspan="2">{{ $days }}</td>
                                <td colspan="2">{{ number_format($rates, 2) }}</td>
                                <td>{{ number_format($subTotal, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">Other-Communication</td>
                                <td>{{ $travelReq['travel_other_communication'] }}</td>
                                <td colspan="2"></td>
                                <td colspan="2"></td>
                                <td>{{ number_format($travelReq['travel_other_communication_amount'], 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td></td>
                                <td colspan="2"></td>
                                <td colspan="2"class="fw-bold">Sub Total</td>
                                <td>{{ number_format($subTotal, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="2"class="fw-bold"></td>
                                <td class="fw-bold"></td>
                                <td colspan="2"class="fw-bold"></td>
                                <td colspan="2"class="fw-bold">Contingency</td>
                                <td>{{ number_format($travelReq['travel_contingency_amount'], 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="2"class="fw-bold"></td>
                                <td class="fw-bold"></td>
                                <td colspan="2"class="fw-bold"></td>
                                <td colspan="2"class="fw-bold">TOTAL</td>
                                <td class="fw-bold">
                                    {{ number_format($travelReq['total'] + $travelReq['travel_other_communication_amount'], 2) }}
                                </td>
                                {{-- <td class="fw-bold">{{ number_format(($travelReq['total'] + $travelReq['travel_other_communication_amount']), 2) }}</td> --}}
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td colspan="12">
                                    <div class="row">
                                        <div class="col-4">
                                            <span class="fw-bold text-capitalize">Requested By:</span>
                                            <span>
                                                {{ $travelReq['related_document_request']['added_by']['first_name'] }}
                                                {{ $travelReq['related_document_request']['added_by']['last_name'] }}
                                            </span>
                                        </div>
                                        <div class="col-4">
                                            {{-- Don't delete --}}
                                        </div>
                                        <div class="col-4">
                                            <span class="fw-bold text-capitalize">Date:</span>
                                            <span>
                                                {{ date('d/m/Y', strtotime($travelReq['related_document_request']['date_added'])) }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td colspan="7">
                                    @foreach ($travelReq['approval_steps'] as $approver)
                                        <div class="row">
                                            <div class="col-4">
                                                @if ($approver['related_document_approval_step']['approval_step_name'] == 'REVIEW')
                                                    <div>
                                                        <span class="fw-bold text-capitalize">Reviewed By:</span>
                                                        @if ($approver['approval_comment'])
                                                            <span>
                                                                {{ $approver['related_approver']['related_user']['first_name'] }}
                                                                {{ $approver['related_approver']['related_user']['last_name'] }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @elseif($approver['related_document_approval_step']['approval_step_name'] == 'VERIFICATION')
                                                    <div>
                                                        <span class="fw-bold text-capitalize">Verified By:</span>
                                                        @if ($approver['approval_comment'])
                                                            <span>
                                                                {{ $approver['related_approver']['related_user']['first_name'] }}
                                                                {{ $approver['related_approver']['related_user']['last_name'] }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @elseif($approver['related_document_approval_step']['approval_step_name'] == 'APPROVAL')
                                                    <div>
                                                        <span class="fw-bold text-capitalize">Approved By:</span>
                                                        @if ($approver['approval_comment'])
                                                            <span>
                                                                {{ $approver['related_approver']['related_user']['first_name'] }}
                                                                {{ $approver['related_approver']['related_user']['last_name'] }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @elseif($approver['related_document_approval_step']['approval_step_name'] == 'AUTHORISATION')
                                                    <div>
                                                        <span class="fw-bold text-capitalize">Authorized By:</span>
                                                        @if ($approver['approval_comment'])
                                                            <span>
                                                                {{ $approver['related_approver']['related_user']['first_name'] }}
                                                                {{ $approver['related_approver']['related_user']['last_name'] }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-4">
                                                <div class="text-capitalize"><span
                                                        class="fw-bold text-capitalize">Title:</span>
                                                    {{ \Str::ucfirst(\Str::lower($approver['generic_role_name'])) }}
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                @if (strtotime($approver['date_performed']))
                                                    <span
                                                        class="fw-bold text-capitalize">Date:</span>{{ date('d/m/Y H:i', strtotime($approver['date_performed'])) }}
                                                @else
                                                    <span class="fw-bold text-capitalize">Date:</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12 text-capitalize">
                                                <span class="fw-bold">Comment:</span>
                                                <span>
                                                    {{ $approver['approval_comment'] }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="border bg-white rounded-3 shadow px-4 py-3 mt-3">
                    @if (count($attachedDocuments) > 0)
                        <label for="relevant_documents" class="form-label">Attached Documents:</label> <br />
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Title </th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Link</th>
                                    <th scope="col">Added By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attachedDocuments as $attachedDocument)
                                    <tr class="">
                                        <td>{{ date('m/d/Y', strtotime($attachedDocument['date_added'])) }}</td>
                                        <td><a class="text-decoration-none"
                                                href="{{ route('documents.show', $attachedDocument['id']) }}">{{ $attachedDocument['file_name'] }}</a>
                                        </td>
                                        <td>{{ $attachedDocument['description'] }}</td>
                                        <td><a href="{{ $url . $attachedDocument['file_path'] }}" target="_blank"
                                                download>{{ pathinfo($attachedDocument['file_path'])['basename'] }}</a>
                                        </td>
                                        <td> {{ $travelReq['related_document_request']['added_by']['first_name'] }}
                                            {{ $travelReq['related_document_request']['added_by']['last_name'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    <form wire:submit.prevent="storeDocument">
                        <label for="relevant_documents" class="form-label">Attach Relevant Document:</label> <br />
                        <input class="form-control @error('file') is-invalid @enderror" type="file"
                            wire:model="file" required id="file">
                        @error('file')
                            <div class="alert alert-danger p-2 mt-2">Unable to upload file,try again</div>
                        @enderror
                        <div class="col-12 mt-4 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-3">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.getElementById('openPdfLink').addEventListener('click', function(event) {
            event.preventDefault();
            window.open(this.href, '_blank');
        });
    </script>
@endpush
