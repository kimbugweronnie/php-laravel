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
        <div class="col-lg-12 d-flex mb-3 justify-content-between">
            <div>
                <a class="btn btn-outline-secondary px-3" href="{{ route('procurements.index') }}">
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
                        href="{{ route('procurements.editProcurement', $procurementReq['related_document_request']['id']) }}">
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
                <a class="btn btn-outline-secondary" id="openPdfLink"
                    href="{{ route('procurement.pdf', $procurementReq['related_document_request']['id']) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-printer me-2" viewBox="0 0 16 16">
                        <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
                        <path
                            d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1" />
                    </svg>
                    Print
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="border bg-white rounded-3 shadow px-4 py-3">
                <div class="fs-4 text-uppercase fw-bold text-center pb-4">
                    <div><img src="{{ asset('img/full-logo.png') }}" width="140" alt=" procurement image"></div>
                    <div>Uganda episcopal conference</div>
                    <div>Uganda catholic secretariat</div>
                    <div>Uganda Catholic medical bureau</div>
                    <div>
                        {{ $procurementReq['related_document_request']['related_project_document']['related_project']['project_name'] }}
                    </div>
                    <div>{{ $procurementReq['related_document_request']['related_project_document']['order_number'] }}
                    </div>
                    <div>Procurement Form</div>
                </div>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th colspan="9"> Procurement Reference Number (Refer to the Procurement Guidelines)</th>
                        </tr>
                        <tr>
                            <th colspan="2">PD Entity Code:</th>
                            <th colspan="2">Wrks/Srvcs/Supplies?</th>
                            <th class="text-capitalize" colspan="2">Budget Year</th>
                            <th>Sequence Number</th>
                            <th>ITB Number</th>
                            <th>Contract Number</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="text-uppercase" colspan="9"> <span class="fw-bold">Subject of
                                    procurement:</span> {{ $procurementReq['title'] }} </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-uppercase" colspan="2">Location for delivery: </td>
                            <td colspan="3">{{ $procurementReq['location_for_delivery'] }}</td>
                            <td class="fw-bold text-capitalize" colspan="2">Date required: </td>
                            <td colspan="2">{{ $procurementReq['date'] }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-capitalize">Item No.</td>
                            <td class="fw-bold text-capitalize" colspan="4">Description</td>
                            <td class="fw-bold text-capitalize">Quantity</td>
                            <td class="fw-bold text-capitalize">Unit of Measure</td>
                            <td class="fw-bold text-capitalize">Estimated Unit Cost</td>
                            <td class="fw-bold text-capitalize">Estimated Total Cost
                                ({{ $procurementReq['currency_id']['currency_symbol'] }})</td>
                        </tr>
                        @php
                            $counter = 1;
                        @endphp
                        @foreach ($procurementReq['meta_fields'] as $item)
                            <tr>
                                <td>{{ $counter }}</td>
                                <td colspan="4">{{ $item['description'] }}</td>
                                <td>{{ number_format($item['quantity'], 2) }}</td>
                                <td>{{ $item['unit_of_measure'] }}</td>
                                <td>{{ number_format($item['estimated_unit_cost'], 2) }}</td>
                                <td>{{ number_format($item['estimated_total_cost'], 2) }}</td>
                            </tr>
                            @php
                                $counter++;
                            @endphp
                        @endforeach

                        <tr>
                            <td></td>
                            <td class="fw-bold text-capitalize"colspan="4">
                                Currency({{ $procurementReq['currency_id']['currency_symbol'] }}):</td>
                            <td></td>
                            <td class="fw-bold text-capitalize"colspan="2">Estimated Total Cost:</td>
                            <td>{{ number_format($total, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="fw-bold text-uppercase" colspan="9">Budget code:</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-uppercase">Program</td>
                            <td class="fw-bold text-uppercase">Project</td>
                            <td class="fw-bold text-uppercase">Donor</td>
                            <td class="fw-bold text-uppercase">Activity</td>
                            <td class="fw-bold text-uppercase">Resp/Cost centre</td>
                            <td class="fw-bold text-uppercase">Annual budget</td>
                            <td class="fw-bold text-uppercase">Exp to date</td>
                            <td class="fw-bold text-uppercase">Budget balance</td>
                            <td class="fw-bold text-uppercase">Amount required</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-uppercase">
                                {{ $procurementReq['related_document_request']['related_project_document']['related_project']['project_name'] }}
                            </td>
                            <td></td>
                            <td>{{ $procurementReq['related_activity']['activity_name'] }}</td>
                            <td>{{ $procurementReq['cost_center']['cost_center_name'] }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
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
                                            {{ $procurementReq['related_document_request']['added_by']['first_name'] }}
                                            {{ $procurementReq['related_document_request']['added_by']['last_name'] }}
                                        </span>
                                    </div>
                                    <div class="col-4">
                                        {{-- Don't delete --}}
                                    </div>
                                    <div class="col-4">
                                        <span class="fw-bold text-capitalize">Date:</span>
                                        <span>
                                            {{ date('d/m/Y', strtotime($procurementReq['related_document_request']['date_added'])) }}
                                        </span>
                                    </div>
                                </div>
                                @foreach ($procurementReq['approval_steps'] as $approver)
                                    <div class="row mt-4">
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
                                                {{ \Str::ucfirst(\Str::lower($approver['generic_role_name'])) }}</div>
                                        </div>
                                        <div class="col-4">
                                            @if (strtotime($approver['date_performed']))
                                                <span class="fw-bold text-capitalize">Date:</span>
                                                {{ date('d/m/Y H:i ', strtotime($approver['date_performed'])) }}
                                            @else
                                                <span class="fw-bold text-capitalize">Date:</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mt-2">
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
                                    <td> {{ $procurementReq['related_document_request']['added_by']['first_name'] }}
                                        {{ $procurementReq['related_document_request']['added_by']['last_name'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                <form wire:submit.prevent="storeDocument">
                    <label for="relevant_documents" class="form-label">Attach Relevant Document:</label> <br />
                    <input class="form-control @error('file') is-invalid @enderror" type="file" wire:model="file"
                        required id="file">
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

@push('scripts')
    <script>
        document.getElementById('openPdfLink').addEventListener('click', function(event) {
            event.preventDefault();
            window.open(this.href, '_blank');
        });
    </script>
@endpush
