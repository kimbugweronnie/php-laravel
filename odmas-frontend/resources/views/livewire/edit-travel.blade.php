@push('styles')
    <style>
        table, th, td {
            border: 2px solid #0a0a0a !important;
        }
       
    </style>
@endpush

<div class="container-fluid p-0">
    <div class="row">
        @include('messages.flash')
        <div class="col-lg-12 d-flex justify-content-between">
            <a class="btn btn-outline-secondary px-3" href="{{ url()->previous() }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-left mb-1" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0v-2z"/>
                    <path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                </svg>
                Back
            </a>
            <a id="openPdfLink" class="btn btn-outline-secondary px-3" href="{{ route('travel.pdf', $travelReq['related_document_request']['id']) }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer me-2" viewBox="0 0 16 16">
                    <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/>
                    <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1"/>
                </svg>
                Print
            </a>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="border bg-white rounded-3  p-4">
                <div class="fs-4 text-uppercase fw-bold text-center pb-5">
                    <div><img src="{{ asset('img/full-logo.png') }}" width="140" alt=" travel image"></div>
                    <div>Uganda episcopal conference</div> 
                    <div>Uganda catholic secretariat</div>
                    <div>Uganda Catholic medical bureau</div>
                    <div>{{$travelReq['related_document_request']['related_project_document']['related_project']['project_name']}}</div>
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
                            <td class="" colspan="2">{{$travelReq['related_document_request']['added_by']['first_name']}} {{$travelReq['related_document_request']['added_by']['last_name']}}</td>
                            <td class="">Date of Request:</td>
                            <td class=""colspan="2">{{ Carbon\Carbon::parse($travelReq['related_document_request']['date_added'])->format('d-m-Y')}}</td>
                          
                        </tr>

                    </tbody>
                </table>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="8" class="fw-bold text-capitalize">A. Project Information</td> 
                        </tr>
                        <tr>
                            <td  colspan="3" class="fw-bold text-capitalize">Project Name</td>  
                            <td  colspan="4" class="fw-bold text-capitalize">Project Number</td> 
                            <td class="fw-bold text-capitalize"></td> 
                        </tr>
                         <tr> 
                            <td class="fw-bold text-uppercase" colspan="3">{{$travelReq['related_document_request']['related_project_document']['related_project']['project_name']}}</td>  
                            <td colspan="4">{{ $this->getProject($travelReq['related_document_request']['related_project_document']['related_project']['id'])  }}</td> 
                            <td></td>  
                        </tr> 

                        <tr> 
                            <td colspan="3" class="fw-bold text-capitalize"></td>  
                            <td colspan="4" class="fw-bold text-capitalize"></td> 
                            <td></td>   
                        </tr>

                        <tr> 
                            <td colspan="7" class="fw-bold">B. Trip Scope of Work (Attach or fill in a SOW for the trip)</td>  
                            <td></td>   
                        </tr>
                       
                         <tr>
                            <td colspan="7" class="fw-bold ">Indicate, in detail, what will be accomplished during this trip.</td>  
                            <td></td> 
                        </tr>   
                        <tr>
                            <td colspan="8" class="fw-bold " >{{ $travelReq["title"] }}</td>  
                        </tr> 
                        <tr>
                            <td colspan="7"></td>  
                            <td></td> 
                        </tr>   
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
                         
                         @foreach($travelReq['meta_fields'] as $item)
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
                            <td colspan="8"class="fw-bold">* If more space is needed for travel schedule, you must attach a spreadsheet with the above columns and information.</td> 
                        </tr>
                         <tr>
                            <td colspan="7" class="fw-bold">D. Travel Advance Request (if the partner has travel advance policy)</td> 
                        </tr>
                        <tr>
                            <td colspan="2"class="fw-bold">Details</td> 
                            <td class="fw-bold">No. of Persons</td> 
                            <td colspan="2"class="fw-bold">Days</td> 
                            <td colspan="2"class="fw-bold">Rate</td> 
                            <td class="fw-bold">Total</td> 
                        </tr> 
                         <tr>
                            <td colspan="2"class="fw-bold">Perdiem:</td> 
                            <td class="fw-bold"></td> 
                            <td colspan="2"class="fw-bold"></td> 
                            <td colspan="2"class="fw-bold"></td> 
                            <td class="fw-bold"></td> 
                        </tr> 
                        <tr>
                            <td colspan="2"class="fw-bold">(a) Officers-(
                                @foreach($travelReq['travel_advance_request_fields'] as $item)
                                    <span>{{ $item['name_of_persons'] }},</span>
                                @endforeach
                            )
                            </td> 
                            <td class="fw-bold">{{ $employees }}</td> 
                            <td colspan="2">{{ $days }}</td> 
                            <td colspan="2">{{ number_format($rates,2) }}</td> 
                            <td>{{ number_format($total,2) }}</td> 
                        </tr> 
                       
                        <tr>
                            <td colspan="2"class="fw-bold">Other-Communication</td> 
                            <td class="fw-bold">Amount</td> 
                            <td colspan="2"class="fw-bold"></td> 
                            <td class="fw-bold"></td> 
                        </tr>
                        <tr>
                            <td colspan="2">{{ $travelReq['travel_other_communication'] }}</td> 
                            <td>{{ $travelReq['travel_other_communication_amount'] }}</td>  
                            <td colspan="2"class="fw-bold"></td> 
                            <td colspan="2"class="fw-bold">Sub Total</td> 
                            <td>{{  number_format($total, 2) }}</td> 
                        </tr> 
                        <tr>
                            <td colspan="2"class="fw-bold"></td> 
                            <td class="fw-bold"></td> 
                            <td colspan="2"class="fw-bold"></td> 
                            <td colspan="2"class="fw-bold">Contingency</td> 
                            <td>{{ $travelReq['travel_contingency_amount'] }}</td> 
                        </tr> 
                        <tr>
                            <td colspan="2"class="fw-bold"></td> 
                            <td class="fw-bold"></td> 
                            <td colspan="2"class="fw-bold"></td> 
                            <td colspan="2"class="fw-bold">TOTAL</td> 
                            <td class="fw-bold">{{ number_format(($travelReq['total'] + $travelReq['travel_other_communication_amount']), 2) }}</td>
                        </tr> 
                        <tr>
                            <td colspan="12">
                                <div class="row mt-4">
                                    <div class="col-4 fs-4">
                                        <span class="fw-bold text-capitalize">Requested By:</span>
                                        <span class="text-muted">
                                            {{ $travelReq['related_document_request']['added_by']['first_name']  }} 
                                            {{ $travelReq['related_document_request']['added_by']['last_name']  }}
                                        </span>
                                    </div>
                                    <div class="col-4 fs-4">
                                        <span class="fw-bold text-capitalize">Date:</span>
                                        <span class="text-muted">
                                            {{ date('d/m/Y', strtotime($travelReq['related_document_request']['date_added']))}} 
                                        </span>
                                    </div>
                                </div> 
                                @foreach($travelReq['approval_steps'] as $approver)
                                <div class="row mt-4">
                                    <div class="col-4 fs-4">
                                
                                        @if($approver['related_document_approval_step']['approval_step_name'] == "REVIEW" && 
                                           $approver['generic_role_name']  == "HEAD OF SECTION" 
                                            )
                                            <div>
                                                <span class="fw-bold text-capitalize">Reviewed By:</span>
                                                @if($approver['approval_comment'])
                                                    <span class="text-muted">
                                                       {{ $approver['related_approver']['related_user']['first_name'] }} 
                                                        {{ $approver['related_approver']['related_user']['last_name'] }}
                                                    </span>
                                                @endif
                                               
                                            </div> 
                                        @elseif($approver['related_document_approval_step']['approval_step_name'] == "APPROVAL"
                                        && $approver['generic_role_name']  == "PROGRAM MANAGER" 
                                        )
                                            <div>
                                                <span class="fw-bold text-capitalize">Approved By:</span>
                                                @if($approver['approval_comment'])
                                                    <span class="text-muted">
                                                      {{ $approver['related_approver']['related_user']['first_name'] }} 
                                                        {{ $approver['related_approver']['related_user']['last_name'] }}
                                                    </span>
                                                @endif
                                             
                                            </div>
                                        @elseif($approver['related_document_approval_step']['approval_step_name'] == "VERIFICATION"
                                         && $approver['generic_role_name']  == "FINANCE MANAGER" 
                                        )
                                            <div>
                                                <span class="fw-bold text-capitalize">Verified By:</span>
                                                @if($approver['approval_comment'])
                                                    <span class="text-muted">
                                                       {{ $approver['related_approver']['related_user']['first_name'] }} 
                                                        {{ $approver['related_approver']['related_user']['last_name'] }}
                                                    </span>
                                                @endif
                                             
                                            </div>
                                         @elseif($approver['related_document_approval_step']['approval_step_name'] == "VERIFICATION"
                                         && $approver['generic_role_name']  == "ACCOUNTANT" 
                                        )
                                            <div>
                                                <span class="fw-bold text-capitalize">Verified By:</span>
                                                @if($approver['approval_comment'])
                                                    <span class="text-muted">
                                                       {{ $approver['related_approver']['related_user']['first_name'] }} 
                                                        {{ $approver['related_approver']['related_user']['last_name'] }}
                                                    </span>
                                                @endif
                                             
                                            </div>
                                          
                                            @endif
                                      
                                    </div>
                                    <div class="col-4 fs-4">
                                        <div class="fw-bold text-capitalize">{{ \Str::ucfirst(\Str::lower($approver['generic_role_name'])) }}</div>
                                    </div>
                                    <div class="col-4 fs-4">
                                        @if(strtotime($approver['date_performed']))
                                            <span class="fw-bold text-capitalize">Date:</span>{{ date('d/m/Y', strtotime($approver['date_performed']))}} 
                                        @else
                                            <span class="fw-bold text-capitalize">Date:</span>
                                        @endif

                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12 fs-4">
                                        <span class="fw-bold text-capitalize">Comment:</span> 
                                        <span class="text-muted">
                                            {{ $approver['approval_comment'] }}
                                        </span>
                                    </div>
                                </div> 
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>   

                <div class="">Verification by finance that employee has no outstanding advances</div>  
                
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="7">
                                @foreach($travelReq['approval_steps'] as $approver)
                                    @if($approver['generic_role_name'] == "FINANCE MANAGER")
                                        <div class="row mt-4">
                                            <div class="col-4 fs-4">
                                                <div>
                                                    <span class="fw-bold text-capitalize">Verified By:</span>
                                                    @if($approver['approval_comment'])
                                                        <span class="text-muted">
                                                            {{ $approver['related_approver']['related_user']['first_name'] }} 
                                                            {{ $approver['related_approver']['related_user']['last_name'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-4 fs-4">
                                                <div class="fw-bold text-capitalize">{{ \Str::ucfirst(\Str::lower($approver['generic_role_name'])) }}</div>
                                            </div>
                                            <div class="col-4 fs-4">
                                                @if(strtotime($approver['date_performed']))
                                                    <span class="fw-bold text-capitalize">Date:</span>{{ date('d/m/Y', strtotime($approver['date_performed']))}} 
                                                @else
                                                    <span class="fw-bold text-capitalize">Date:</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-12 fs-4">
                                                <span class="fw-bold text-capitalize">Comment:</span> 
                                                <span class="text-muted">
                                                    {{ $approver['approval_comment'] }}
                                                </span>
                                            </div>
                                        </div>
                                        @break
                                    @endif 
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
            <div class="border bg-white rounded-3 shadow px-4 py-3 mt-3">
                @if(count($attachedDocuments) > 0)
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
                            @foreach($attachedDocuments as $attachedDocument)
                                <tr class="">
                                    <td>{{date('m/d/Y', strtotime($attachedDocument['date_added']))}}</td>
                                    <td><a class="text-decoration-none" href="{{ route('documents.show', $attachedDocument['id']) }}">{{$attachedDocument['file_name']}}</a></td>
                                    <td>{{$attachedDocument['description']}}</td>
                                    <td><a href="{{ $url.$attachedDocument["file_path"] }}" target="_blank" download>{{pathinfo($attachedDocument['file_path'])['basename']}}</a></td>
                                    <td> {{ $travelReq['related_document_request']['added_by']['first_name']  }} 
                                        {{ $travelReq['related_document_request']['added_by']['last_name']  }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else 
                    <p class="text-muted">No attachments</p>  
                @endif
            </div>
                <div class="col-lg-12 mt-5">
                    @include('messages.flash')
                    <div class="border bg-white rounded-3 shadow p-4">
                        @foreach($travelReq['approval_steps'] as $approver)
                      
                            <div class="row mt-2">
                                <div class="col-6 fs-4">
                                    @if($approver['related_document_approval_step']['approval_step_name'] == "VERIFICATION" )
                                        <span class="fw-bold text-capitalize">Verified by:</span>
                                    @elseif($approver['related_document_approval_step']['approval_step_name'] == "REVIEW" )
                                        <span class="fw-bold text-capitalize">Reviewed by:</span>
                                    @elseif($approver['related_document_approval_step']['approval_step_name'] == "VERIFICATION" )
                                        <span class="fw-bold text-capitalize">Verified by:</span>
                                    @elseif($approver['related_document_approval_step']['approval_step_name'] == "APPROVAL")
                                        <span class="fw-bold text-capitalize">Approved by:</span>
                                    @elseif($approver['related_document_approval_step']['approval_step_name'] == "AUTHORISATION")
                                        <span class="fw-bold text-capitalize">Authorized by:</span>
                                    @endif
                                   {{ $approver['related_approver']['related_user']['first_name'] }} 
                                    {{ $approver['related_approver']['related_user']['last_name'] }}
                                </div>
                                <div class="col-6 fs-4">
                                    <span class="fw-bold text-capitalize">{{ Str::lower( $approver['generic_role_name']) }}</span> 
                                </div>
                                <div class="col-12">
                                    @if ($approver['next_step'] && !$approver['status'] && Session::get('userDetails')['id'] ==  $approver['related_approver']['related_user']['id'])
                                        <div class="mt-2">
                                            <form>
                                                <div>
                                                    <label class="mb-2 fw-bold" for="comment">Comment</label>
                                                    <textarea wire:model="comment" class="form-control" cols="30" rows="4" required></textarea>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12">
                                    @if ($approver['next_step'] && !$approver['status'] && $approver['next_step'] && Session::get('userDetails')['id'] == $approver['related_approver']['related_user']['id'])
                                        <div class="d-flex justify-content-start">
                                            <form  wire:submit="approveRequest">
                                                <div>
                                                    <input wire:model="approval_step_id" type="hidden">
                                                    <input wire:model="relatedDocumentApprovalStep" type="hidden">
                                                </div>
                                                <div class="pt-2">
                                                    <button type="submit" class="btn btn-outline-primary text-capitalize px-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-fingerprint me-2" viewBox="0 0 16 16">
                                                            <path d="M8.06 6.5a.5.5 0 0 1 .5.5v.776a11.5 11.5 0 0 1-.552 3.519l-1.331 4.14a.5.5 0 0 1-.952-.305l1.33-4.141a10.5 10.5 0 0 0 .504-3.213V7a.5.5 0 0 1 .5-.5Z"/>
                                                            <path d="M6.06 7a2 2 0 1 1 4 0 .5.5 0 1 1-1 0 1 1 0 1 0-2 0v.332c0 .409-.022.816-.066 1.221A.5.5 0 0 1 6 8.447c.04-.37.06-.742.06-1.115zm3.509 1a.5.5 0 0 1 .487.513 11.5 11.5 0 0 1-.587 3.339l-1.266 3.8a.5.5 0 0 1-.949-.317l1.267-3.8a10.5 10.5 0 0 0 .535-3.048A.5.5 0 0 1 9.569 8Zm-3.356 2.115a.5.5 0 0 1 .33.626L5.24 14.939a.5.5 0 1 1-.955-.296l1.303-4.199a.5.5 0 0 1 .625-.329Z"/>
                                                            <path d="M4.759 5.833A3.501 3.501 0 0 1 11.559 7a.5.5 0 0 1-1 0 2.5 2.5 0 0 0-4.857-.833.5.5 0 1 1-.943-.334Zm.3 1.67a.5.5 0 0 1 .449.546 10.72 10.72 0 0 1-.4 2.031l-1.222 4.072a.5.5 0 1 1-.958-.287L4.15 9.793a9.72 9.72 0 0 0 .363-1.842.5.5 0 0 1 .546-.449Zm6 .647a.5.5 0 0 1 .5.5c0 1.28-.213 2.552-.632 3.762l-1.09 3.145a.5.5 0 0 1-.944-.327l1.089-3.145c.382-1.105.578-2.266.578-3.435a.5.5 0 0 1 .5-.5Z"/>
                                                            <path d="M3.902 4.222a4.996 4.996 0 0 1 5.202-2.113.5.5 0 0 1-.208.979 3.996 3.996 0 0 0-4.163 1.69.5.5 0 0 1-.831-.556Zm6.72-.955a.5.5 0 0 1 .705-.052A4.99 4.99 0 0 1 13.059 7v1.5a.5.5 0 1 1-1 0V7a3.99 3.99 0 0 0-1.386-3.028.5.5 0 0 1-.051-.705ZM3.68 5.842a.5.5 0 0 1 .422.568c-.029.192-.044.39-.044.59 0 .71-.1 1.417-.298 2.1l-1.14 3.923a.5.5 0 1 1-.96-.279L2.8 8.821A6.531 6.531 0 0 0 3.058 7c0-.25.019-.496.054-.736a.5.5 0 0 1 .568-.422Zm8.882 3.66a.5.5 0 0 1 .456.54c-.084 1-.298 1.986-.64 2.934l-.744 2.068a.5.5 0 0 1-.941-.338l.745-2.07a10.51 10.51 0 0 0 .584-2.678.5.5 0 0 1 .54-.456Z"/>
                                                            <path d="M4.81 1.37A6.5 6.5 0 0 1 14.56 7a.5.5 0 1 1-1 0 5.5 5.5 0 0 0-8.25-4.765.5.5 0 0 1-.5-.865Zm-.89 1.257a.5.5 0 0 1 .04.706A5.478 5.478 0 0 0 2.56 7a.5.5 0 0 1-1 0c0-1.664.626-3.184 1.655-4.333a.5.5 0 0 1 .706-.04ZM1.915 8.02a.5.5 0 0 1 .346.616l-.779 2.767a.5.5 0 1 1-.962-.27l.778-2.767a.5.5 0 0 1 .617-.346Zm12.15.481a.5.5 0 0 1 .49.51c-.03 1.499-.161 3.025-.727 4.533l-.07.187a.5.5 0 0 1-.936-.351l.07-.187c.506-1.35.634-2.74.663-4.202a.5.5 0 0 1 .51-.49"/>
                                                        </svg>
                                                         @if($approver['related_document_approval_step']['approval_step_name'] == "VERIFICATION" )
                                                            <span class="fw-bold text-capitalize">Verify</span>
                                                        @elseif($approver['related_document_approval_step']['approval_step_name'] == "REVIEW" )
                                                            <span class="fw-bold text-capitalize">Review</span>
                                                        @elseif($approver['related_document_approval_step']['approval_step_name'] == "APPROVAL")
                                                            <span class="fw-bold text-capitalize">Approve</span>
                                                        @elseif($approver['related_document_approval_step']['approval_step_name'] == "AUTHORISATION")
                                                            <span class="fw-bold text-capitalize">Authorize</span>
                                                        @endif
                                                    </button>
                                                </div>
                                            </form>
                                            <form  wire:submit="ReferBackRequest">
                                                <div>
                                                    <input wire:model="approval_step_id" type="hidden">
                                                    <input wire:model="relatedDocumentApprovalStep" type="hidden">
                                                </div>
                                                <div class="pt-2">
                                                    <button type="submit" class="btn btn-outline-primary text-capitalize ms-4 px-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-fingerprint me-2" viewBox="0 0 16 16" style="color:#ffa64d;">
                                                            <path d="M8.06 6.5a.5.5 0 0 1 .5.5v.776a11.5 11.5 0 0 1-.552 3.519l-1.331 4.14a.5.5 0 0 1-.952-.305l1.33-4.141a10.5 10.5 0 0 0 .504-3.213V7a.5.5 0 0 1 .5-.5Z"/>
                                                            <path d="M6.06 7a2 2 0 1 1 4 0 .5.5 0 1 1-1 0 1 1 0 1 0-2 0v.332c0 .409-.022.816-.066 1.221A.5.5 0 0 1 6 8.447c.04-.37.06-.742.06-1.115zm3.509 1a.5.5 0 0 1 .487.513 11.5 11.5 0 0 1-.587 3.339l-1.266 3.8a.5.5 0 0 1-.949-.317l1.267-3.8a10.5 10.5 0 0 0 .535-3.048A.5.5 0 0 1 9.569 8Zm-3.356 2.115a.5.5 0 0 1 .33.626L5.24 14.939a.5.5 0 1 1-.955-.296l1.303-4.199a.5.5 0 0 1 .625-.329Z"/>
                                                            <path d="M4.759 5.833A3.501 3.501 0 0 1 11.559 7a.5.5 0 0 1-1 0 2.5 2.5 0 0 0-4.857-.833.5.5 0 1 1-.943-.334Zm.3 1.67a.5.5 0 0 1 .449.546 10.72 10.72 0 0 1-.4 2.031l-1.222 4.072a.5.5 0 1 1-.958-.287L4.15 9.793a9.72 9.72 0 0 0 .363-1.842.5.5 0 0 1 .546-.449Zm6 .647a.5.5 0 0 1 .5.5c0 1.28-.213 2.552-.632 3.762l-1.09 3.145a.5.5 0 0 1-.944-.327l1.089-3.145c.382-1.105.578-2.266.578-3.435a.5.5 0 0 1 .5-.5Z"/>
                                                            <path d="M3.902 4.222a4.996 4.996 0 0 1 5.202-2.113.5.5 0 0 1-.208.979 3.996 3.996 0 0 0-4.163 1.69.5.5 0 0 1-.831-.556Zm6.72-.955a.5.5 0 0 1 .705-.052A4.99 4.99 0 0 1 13.059 7v1.5a.5.5 0 1 1-1 0V7a3.99 3.99 0 0 0-1.386-3.028.5.5 0 0 1-.051-.705ZM3.68 5.842a.5.5 0 0 1 .422.568c-.029.192-.044.39-.044.59 0 .71-.1 1.417-.298 2.1l-1.14 3.923a.5.5 0 1 1-.96-.279L2.8 8.821A6.531 6.531 0 0 0 3.058 7c0-.25.019-.496.054-.736a.5.5 0 0 1 .568-.422Zm8.882 3.66a.5.5 0 0 1 .456.54c-.084 1-.298 1.986-.64 2.934l-.744 2.068a.5.5 0 0 1-.941-.338l.745-2.07a10.51 10.51 0 0 0 .584-2.678.5.5 0 0 1 .54-.456Z"/>
                                                            <path d="M4.81 1.37A6.5 6.5 0 0 1 14.56 7a.5.5 0 1 1-1 0 5.5 5.5 0 0 0-8.25-4.765.5.5 0 0 1-.5-.865Zm-.89 1.257a.5.5 0 0 1 .04.706A5.478 5.478 0 0 0 2.56 7a.5.5 0 0 1-1 0c0-1.664.626-3.184 1.655-4.333a.5.5 0 0 1 .706-.04ZM1.915 8.02a.5.5 0 0 1 .346.616l-.779 2.767a.5.5 0 1 1-.962-.27l.778-2.767a.5.5 0 0 1 .617-.346Zm12.15.481a.5.5 0 0 1 .49.51c-.03 1.499-.161 3.025-.727 4.533l-.07.187a.5.5 0 0 1-.936-.351l.07-.187c.506-1.35.634-2.74.663-4.202a.5.5 0 0 1 .51-.49"/>
                                                        </svg>
                                                        @if($approver['related_document_approval_step']['approval_step_name'] == "VERIFICATION" )
                                                            <span class="fw-bold text-capitalize">Refer Back</span>
                                                        @elseif($approver['related_document_approval_step']['approval_step_name'] == "REVIEW" )
                                                            <span class="fw-bold text-capitalize">Refer Back</span>
                                                        @elseif($approver['related_document_approval_step']['approval_step_name'] == "APPROVAL")
                                                            <span class="fw-bold text-capitalize">Refer Back</span>
                                                        @elseif($approver['related_document_approval_step']['approval_step_name'] == "AUTHORISATION")
                                                            <span class="fw-bold text-capitalize">Refer Back</span>
                                                        @endif
                                                    </button>
                                                </div>
                                            </form>
                                            <div class="pt-2">
                                                <button type="submit" class="btn btn-outline-primary text-capitalize ms-4 px-3" data-bs-toggle="modal" data-bs-target="#submitdelegate">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-fingerprint me-2" viewBox="0 0 16 16" style="color:#4dff88;">
                                                        <path d="M8.06 6.5a.5.5 0 0 1 .5.5v.776a11.5 11.5 0 0 1-.552 3.519l-1.331 4.14a.5.5 0 0 1-.952-.305l1.33-4.141a10.5 10.5 0 0 0 .504-3.213V7a.5.5 0 0 1 .5-.5Z"/>
                                                        <path d="M6.06 7a2 2 0 1 1 4 0 .5.5 0 1 1-1 0 1 1 0 1 0-2 0v.332c0 .409-.022.816-.066 1.221A.5.5 0 0 1 6 8.447c.04-.37.06-.742.06-1.115zm3.509 1a.5.5 0 0 1 .487.513 11.5 11.5 0 0 1-.587 3.339l-1.266 3.8a.5.5 0 0 1-.949-.317l1.267-3.8a10.5 10.5 0 0 0 .535-3.048A.5.5 0 0 1 9.569 8Zm-3.356 2.115a.5.5 0 0 1 .33.626L5.24 14.939a.5.5 0 1 1-.955-.296l1.303-4.199a.5.5 0 0 1 .625-.329Z"/>
                                                        <path d="M4.759 5.833A3.501 3.501 0 0 1 11.559 7a.5.5 0 0 1-1 0 2.5 2.5 0 0 0-4.857-.833.5.5 0 1 1-.943-.334Zm.3 1.67a.5.5 0 0 1 .449.546 10.72 10.72 0 0 1-.4 2.031l-1.222 4.072a.5.5 0 1 1-.958-.287L4.15 9.793a9.72 9.72 0 0 0 .363-1.842.5.5 0 0 1 .546-.449Zm6 .647a.5.5 0 0 1 .5.5c0 1.28-.213 2.552-.632 3.762l-1.09 3.145a.5.5 0 0 1-.944-.327l1.089-3.145c.382-1.105.578-2.266.578-3.435a.5.5 0 0 1 .5-.5Z"/>
                                                        <path d="M3.902 4.222a4.996 4.996 0 0 1 5.202-2.113.5.5 0 0 1-.208.979 3.996 3.996 0 0 0-4.163 1.69.5.5 0 0 1-.831-.556Zm6.72-.955a.5.5 0 0 1 .705-.052A4.99 4.99 0 0 1 13.059 7v1.5a.5.5 0 1 1-1 0V7a3.99 3.99 0 0 0-1.386-3.028.5.5 0 0 1-.051-.705ZM3.68 5.842a.5.5 0 0 1 .422.568c-.029.192-.044.39-.044.59 0 .71-.1 1.417-.298 2.1l-1.14 3.923a.5.5 0 1 1-.96-.279L2.8 8.821A6.531 6.531 0 0 0 3.058 7c0-.25.019-.496.054-.736a.5.5 0 0 1 .568-.422Zm8.882 3.66a.5.5 0 0 1 .456.54c-.084 1-.298 1.986-.64 2.934l-.744 2.068a.5.5 0 0 1-.941-.338l.745-2.07a10.51 10.51 0 0 0 .584-2.678.5.5 0 0 1 .54-.456Z"/>
                                                        <path d="M4.81 1.37A6.5 6.5 0 0 1 14.56 7a.5.5 0 1 1-1 0 5.5 5.5 0 0 0-8.25-4.765.5.5 0 0 1-.5-.865Zm-.89 1.257a.5.5 0 0 1 .04.706A5.478 5.478 0 0 0 2.56 7a.5.5 0 0 1-1 0c0-1.664.626-3.184 1.655-4.333a.5.5 0 0 1 .706-.04ZM1.915 8.02a.5.5 0 0 1 .346.616l-.779 2.767a.5.5 0 1 1-.962-.27l.778-2.767a.5.5 0 0 1 .617-.346Zm12.15.481a.5.5 0 0 1 .49.51c-.03 1.499-.161 3.025-.727 4.533l-.07.187a.5.5 0 0 1-.936-.351l.07-.187c.506-1.35.634-2.74.663-4.202a.5.5 0 0 1 .51-.49"/>
                                                    </svg>
                                                    Delegate
                                                </button>
                                            </div>
                                        </div>
                                    @elseif ($approver['status'])
                                        <div class="d-flex justify-content-start">
                                            @if($approver['date_performed'])
                                                <div class="pt-2">
                                                    <button type="submit" class="btn btn-outline-primary text-capitalize px-2" disabled>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-check-all" viewBox="0 0 16 16">
                                                            <path d="M8.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992zm-.92 5.14.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486z"/>
                                                        </svg>
                                                        @if($approver['related_document_approval_step']['approval_step_name'] == "VERIFICATION" )
                                                            <span class="fw-bold text-capitalize">Verified</span>
                                                        @elseif($approver['related_document_approval_step']['approval_step_name'] == "REVIEW" )
                                                            <span class="fw-bold text-capitalize">Reviewed</span>
                                                        @elseif($approver['related_document_approval_step']['approval_step_name'] == "APPROVAL")
                                                            <span class="fw-bold text-capitalize">Approved</span>
                                                        @elseif($approver['related_document_approval_step']['approval_step_name'] == "AUTHORISATION")
                                                            <span class="fw-bold text-capitalize">Authorized</span>
                                                        @endif
                                                    </button>
                                                </div>
                                            @endif 
                                        @if(!$approver['date_performed'])
                                                <div class="pt-2">
                                                    <button type="submit" class="btn btn-outline-primary text-capitalize ms-4 px-3" disabled>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-fingerprint me-2" viewBox="0 0 16 16">
                                                            <path d="M8.06 6.5a.5.5 0 0 1 .5.5v.776a11.5 11.5 0 0 1-.552 3.519l-1.331 4.14a.5.5 0 0 1-.952-.305l1.33-4.141a10.5 10.5 0 0 0 .504-3.213V7a.5.5 0 0 1 .5-.5Z"/>
                                                            <path d="M6.06 7a2 2 0 1 1 4 0 .5.5 0 1 1-1 0 1 1 0 1 0-2 0v.332c0 .409-.022.816-.066 1.221A.5.5 0 0 1 6 8.447c.04-.37.06-.742.06-1.115zm3.509 1a.5.5 0 0 1 .487.513 11.5 11.5 0 0 1-.587 3.339l-1.266 3.8a.5.5 0 0 1-.949-.317l1.267-3.8a10.5 10.5 0 0 0 .535-3.048A.5.5 0 0 1 9.569 8Zm-3.356 2.115a.5.5 0 0 1 .33.626L5.24 14.939a.5.5 0 1 1-.955-.296l1.303-4.199a.5.5 0 0 1 .625-.329Z"/>
                                                            <path d="M4.759 5.833A3.501 3.501 0 0 1 11.559 7a.5.5 0 0 1-1 0 2.5 2.5 0 0 0-4.857-.833.5.5 0 1 1-.943-.334Zm.3 1.67a.5.5 0 0 1 .449.546 10.72 10.72 0 0 1-.4 2.031l-1.222 4.072a.5.5 0 1 1-.958-.287L4.15 9.793a9.72 9.72 0 0 0 .363-1.842.5.5 0 0 1 .546-.449Zm6 .647a.5.5 0 0 1 .5.5c0 1.28-.213 2.552-.632 3.762l-1.09 3.145a.5.5 0 0 1-.944-.327l1.089-3.145c.382-1.105.578-2.266.578-3.435a.5.5 0 0 1 .5-.5Z"/>
                                                            <path d="M3.902 4.222a4.996 4.996 0 0 1 5.202-2.113.5.5 0 0 1-.208.979 3.996 3.996 0 0 0-4.163 1.69.5.5 0 0 1-.831-.556Zm6.72-.955a.5.5 0 0 1 .705-.052A4.99 4.99 0 0 1 13.059 7v1.5a.5.5 0 1 1-1 0V7a3.99 3.99 0 0 0-1.386-3.028.5.5 0 0 1-.051-.705ZM3.68 5.842a.5.5 0 0 1 .422.568c-.029.192-.044.39-.044.59 0 .71-.1 1.417-.298 2.1l-1.14 3.923a.5.5 0 1 1-.96-.279L2.8 8.821A6.531 6.531 0 0 0 3.058 7c0-.25.019-.496.054-.736a.5.5 0 0 1 .568-.422Zm8.882 3.66a.5.5 0 0 1 .456.54c-.084 1-.298 1.986-.64 2.934l-.744 2.068a.5.5 0 0 1-.941-.338l.745-2.07a10.51 10.51 0 0 0 .584-2.678.5.5 0 0 1 .54-.456Z"/>
                                                            <path d="M4.81 1.37A6.5 6.5 0 0 1 14.56 7a.5.5 0 1 1-1 0 5.5 5.5 0 0 0-8.25-4.765.5.5 0 0 1-.5-.865Zm-.89 1.257a.5.5 0 0 1 .04.706A5.478 5.478 0 0 0 2.56 7a.5.5 0 0 1-1 0c0-1.664.626-3.184 1.655-4.333a.5.5 0 0 1 .706-.04ZM1.915 8.02a.5.5 0 0 1 .346.616l-.779 2.767a.5.5 0 1 1-.962-.27l.778-2.767a.5.5 0 0 1 .617-.346Zm12.15.481a.5.5 0 0 1 .49.51c-.03 1.499-.161 3.025-.727 4.533l-.07.187a.5.5 0 0 1-.936-.351l.07-.187c.506-1.35.634-2.74.663-4.202a.5.5 0 0 1 .51-.49"/>
                                                        </svg>
                                                        @if($approver['related_document_approval_step']['approval_step_name'] == "VERIFICATION" )
                                                            <span class="fw-bold text-capitalize">Referred Back</span>
                                                        @elseif($approver['related_document_approval_step']['approval_step_name'] == "REVIEW" )
                                                            <span class="fw-bold text-capitalize">Referred Back</span>
                                                        @elseif($approver['related_document_approval_step']['approval_step_name'] == "APPROVAL")
                                                            <span class="fw-bold text-capitalize">Referred Back</span>
                                                        @elseif($approver['related_document_approval_step']['approval_step_name'] == "AUTHORISATION")
                                                            <span class="fw-bold text-capitalize">Referred Back</span>
                                                        @endif
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="my-2 mb-3">
                                            <span class="fw-bold">Comment:</span> {{ $approver['approval_comment'] }}
                                        </div>
                                    @else
                                        <div class="pt-2">
                                            <button type="button" id="blur" class="btn btn-outline-primary text-capitalize px-3" disabled>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-fingerprint me-2" viewBox="0 0 16 16">
                                                    <path d="M8.06 6.5a.5.5 0 0 1 .5.5v.776a11.5 11.5 0 0 1-.552 3.519l-1.331 4.14a.5.5 0 0 1-.952-.305l1.33-4.141a10.5 10.5 0 0 0 .504-3.213V7a.5.5 0 0 1 .5-.5Z"/>
                                                    <path d="M6.06 7a2 2 0 1 1 4 0 .5.5 0 1 1-1 0 1 1 0 1 0-2 0v.332c0 .409-.022.816-.066 1.221A.5.5 0 0 1 6 8.447c.04-.37.06-.742.06-1.115zm3.509 1a.5.5 0 0 1 .487.513 11.5 11.5 0 0 1-.587 3.339l-1.266 3.8a.5.5 0 0 1-.949-.317l1.267-3.8a10.5 10.5 0 0 0 .535-3.048A.5.5 0 0 1 9.569 8Zm-3.356 2.115a.5.5 0 0 1 .33.626L5.24 14.939a.5.5 0 1 1-.955-.296l1.303-4.199a.5.5 0 0 1 .625-.329Z"/>
                                                    <path d="M4.759 5.833A3.501 3.501 0 0 1 11.559 7a.5.5 0 0 1-1 0 2.5 2.5 0 0 0-4.857-.833.5.5 0 1 1-.943-.334Zm.3 1.67a.5.5 0 0 1 .449.546 10.72 10.72 0 0 1-.4 2.031l-1.222 4.072a.5.5 0 1 1-.958-.287L4.15 9.793a9.72 9.72 0 0 0 .363-1.842.5.5 0 0 1 .546-.449Zm6 .647a.5.5 0 0 1 .5.5c0 1.28-.213 2.552-.632 3.762l-1.09 3.145a.5.5 0 0 1-.944-.327l1.089-3.145c.382-1.105.578-2.266.578-3.435a.5.5 0 0 1 .5-.5Z"/>
                                                    <path d="M3.902 4.222a4.996 4.996 0 0 1 5.202-2.113.5.5 0 0 1-.208.979 3.996 3.996 0 0 0-4.163 1.69.5.5 0 0 1-.831-.556Zm6.72-.955a.5.5 0 0 1 .705-.052A4.99 4.99 0 0 1 13.059 7v1.5a.5.5 0 1 1-1 0V7a3.99 3.99 0 0 0-1.386-3.028.5.5 0 0 1-.051-.705ZM3.68 5.842a.5.5 0 0 1 .422.568c-.029.192-.044.39-.044.59 0 .71-.1 1.417-.298 2.1l-1.14 3.923a.5.5 0 1 1-.96-.279L2.8 8.821A6.531 6.531 0 0 0 3.058 7c0-.25.019-.496.054-.736a.5.5 0 0 1 .568-.422Zm8.882 3.66a.5.5 0 0 1 .456.54c-.084 1-.298 1.986-.64 2.934l-.744 2.068a.5.5 0 0 1-.941-.338l.745-2.07a10.51 10.51 0 0 0 .584-2.678.5.5 0 0 1 .54-.456Z"/>
                                                    <path d="M4.81 1.37A6.5 6.5 0 0 1 14.56 7a.5.5 0 1 1-1 0 5.5 5.5 0 0 0-8.25-4.765.5.5 0 0 1-.5-.865Zm-.89 1.257a.5.5 0 0 1 .04.706A5.478 5.478 0 0 0 2.56 7a.5.5 0 0 1-1 0c0-1.664.626-3.184 1.655-4.333a.5.5 0 0 1 .706-.04ZM1.915 8.02a.5.5 0 0 1 .346.616l-.779 2.767a.5.5 0 1 1-.962-.27l.778-2.767a.5.5 0 0 1 .617-.346Zm12.15.481a.5.5 0 0 1 .49.51c-.03 1.499-.161 3.025-.727 4.533l-.07.187a.5.5 0 0 1-.936-.351l.07-.187c.506-1.35.634-2.74.663-4.202a.5.5 0 0 1 .51-.49"/>
                                                </svg>
                                                @if($approver['related_document_approval_step']['approval_step_name'] == "VERIFICATION" )
                                                    <span class="fw-bold text-capitalize">Verify</span>
                                                @elseif($approver['related_document_approval_step']['approval_step_name'] == "REVIEW" )
                                                    <span class="fw-bold text-capitalize">Review</span>
                                                @elseif($approver['related_document_approval_step']['approval_step_name'] == "APPROVAL")
                                                    <span class="fw-bold text-capitalize">Approve</span>
                                                @elseif($approver['related_document_approval_step']['approval_step_name'] == "AUTHORISATION")
                                                    <span class="fw-bold text-capitalize">Authorize</span>
                                                @endif
                                            </button>

                                            <button type="button" id="blur" class="btn btn-outline-primary text-capitalize ms-4 px-3" disabled>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-fingerprint me-2" viewBox="0 0 16 16">
                                                    <path d="M8.06 6.5a.5.5 0 0 1 .5.5v.776a11.5 11.5 0 0 1-.552 3.519l-1.331 4.14a.5.5 0 0 1-.952-.305l1.33-4.141a10.5 10.5 0 0 0 .504-3.213V7a.5.5 0 0 1 .5-.5Z"/>
                                                    <path d="M6.06 7a2 2 0 1 1 4 0 .5.5 0 1 1-1 0 1 1 0 1 0-2 0v.332c0 .409-.022.816-.066 1.221A.5.5 0 0 1 6 8.447c.04-.37.06-.742.06-1.115zm3.509 1a.5.5 0 0 1 .487.513 11.5 11.5 0 0 1-.587 3.339l-1.266 3.8a.5.5 0 0 1-.949-.317l1.267-3.8a10.5 10.5 0 0 0 .535-3.048A.5.5 0 0 1 9.569 8Zm-3.356 2.115a.5.5 0 0 1 .33.626L5.24 14.939a.5.5 0 1 1-.955-.296l1.303-4.199a.5.5 0 0 1 .625-.329Z"/>
                                                    <path d="M4.759 5.833A3.501 3.501 0 0 1 11.559 7a.5.5 0 0 1-1 0 2.5 2.5 0 0 0-4.857-.833.5.5 0 1 1-.943-.334Zm.3 1.67a.5.5 0 0 1 .449.546 10.72 10.72 0 0 1-.4 2.031l-1.222 4.072a.5.5 0 1 1-.958-.287L4.15 9.793a9.72 9.72 0 0 0 .363-1.842.5.5 0 0 1 .546-.449Zm6 .647a.5.5 0 0 1 .5.5c0 1.28-.213 2.552-.632 3.762l-1.09 3.145a.5.5 0 0 1-.944-.327l1.089-3.145c.382-1.105.578-2.266.578-3.435a.5.5 0 0 1 .5-.5Z"/>
                                                    <path d="M3.902 4.222a4.996 4.996 0 0 1 5.202-2.113.5.5 0 0 1-.208.979 3.996 3.996 0 0 0-4.163 1.69.5.5 0 0 1-.831-.556Zm6.72-.955a.5.5 0 0 1 .705-.052A4.99 4.99 0 0 1 13.059 7v1.5a.5.5 0 1 1-1 0V7a3.99 3.99 0 0 0-1.386-3.028.5.5 0 0 1-.051-.705ZM3.68 5.842a.5.5 0 0 1 .422.568c-.029.192-.044.39-.044.59 0 .71-.1 1.417-.298 2.1l-1.14 3.923a.5.5 0 1 1-.96-.279L2.8 8.821A6.531 6.531 0 0 0 3.058 7c0-.25.019-.496.054-.736a.5.5 0 0 1 .568-.422Zm8.882 3.66a.5.5 0 0 1 .456.54c-.084 1-.298 1.986-.64 2.934l-.744 2.068a.5.5 0 0 1-.941-.338l.745-2.07a10.51 10.51 0 0 0 .584-2.678.5.5 0 0 1 .54-.456Z"/>
                                                    <path d="M4.81 1.37A6.5 6.5 0 0 1 14.56 7a.5.5 0 1 1-1 0 5.5 5.5 0 0 0-8.25-4.765.5.5 0 0 1-.5-.865Zm-.89 1.257a.5.5 0 0 1 .04.706A5.478 5.478 0 0 0 2.56 7a.5.5 0 0 1-1 0c0-1.664.626-3.184 1.655-4.333a.5.5 0 0 1 .706-.04ZM1.915 8.02a.5.5 0 0 1 .346.616l-.779 2.767a.5.5 0 1 1-.962-.27l.778-2.767a.5.5 0 0 1 .617-.346Zm12.15.481a.5.5 0 0 1 .49.51c-.03 1.499-.161 3.025-.727 4.533l-.07.187a.5.5 0 0 1-.936-.351l.07-.187c.506-1.35.634-2.74.663-4.202a.5.5 0 0 1 .51-.49"/>
                                                </svg>
                                                @if($approver['related_document_approval_step']['approval_step_name'] == "VERIFICATION" )
                                                    <span class="fw-bold text-capitalize">Refer Back</span>
                                                @elseif($approver['related_document_approval_step']['approval_step_name'] == "REVIEW" )
                                                    <span class="fw-bold text-capitalize">Refer Back</span>
                                                @elseif($approver['related_document_approval_step']['approval_step_name'] == "APPROVAL")
                                                    <span class="fw-bold text-capitalize">Refer Back</span>
                                                @elseif($approver['related_document_approval_step']['approval_step_name'] == "AUTHORISATION")
                                                    <span class="fw-bold text-capitalize">Refer Back</span>
                                                @endif
                                            </button>

                                            <button type="button" id="blur" class="btn btn-outline-primary text-capitalize ms-4 px-3" disabled>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-fingerprint me-2" viewBox="0 0 16 16">
                                                    <path d="M8.06 6.5a.5.5 0 0 1 .5.5v.776a11.5 11.5 0 0 1-.552 3.519l-1.331 4.14a.5.5 0 0 1-.952-.305l1.33-4.141a10.5 10.5 0 0 0 .504-3.213V7a.5.5 0 0 1 .5-.5Z"/>
                                                    <path d="M6.06 7a2 2 0 1 1 4 0 .5.5 0 1 1-1 0 1 1 0 1 0-2 0v.332c0 .409-.022.816-.066 1.221A.5.5 0 0 1 6 8.447c.04-.37.06-.742.06-1.115zm3.509 1a.5.5 0 0 1 .487.513 11.5 11.5 0 0 1-.587 3.339l-1.266 3.8a.5.5 0 0 1-.949-.317l1.267-3.8a10.5 10.5 0 0 0 .535-3.048A.5.5 0 0 1 9.569 8Zm-3.356 2.115a.5.5 0 0 1 .33.626L5.24 14.939a.5.5 0 1 1-.955-.296l1.303-4.199a.5.5 0 0 1 .625-.329Z"/>
                                                    <path d="M4.759 5.833A3.501 3.501 0 0 1 11.559 7a.5.5 0 0 1-1 0 2.5 2.5 0 0 0-4.857-.833.5.5 0 1 1-.943-.334Zm.3 1.67a.5.5 0 0 1 .449.546 10.72 10.72 0 0 1-.4 2.031l-1.222 4.072a.5.5 0 1 1-.958-.287L4.15 9.793a9.72 9.72 0 0 0 .363-1.842.5.5 0 0 1 .546-.449Zm6 .647a.5.5 0 0 1 .5.5c0 1.28-.213 2.552-.632 3.762l-1.09 3.145a.5.5 0 0 1-.944-.327l1.089-3.145c.382-1.105.578-2.266.578-3.435a.5.5 0 0 1 .5-.5Z"/>
                                                    <path d="M3.902 4.222a4.996 4.996 0 0 1 5.202-2.113.5.5 0 0 1-.208.979 3.996 3.996 0 0 0-4.163 1.69.5.5 0 0 1-.831-.556Zm6.72-.955a.5.5 0 0 1 .705-.052A4.99 4.99 0 0 1 13.059 7v1.5a.5.5 0 1 1-1 0V7a3.99 3.99 0 0 0-1.386-3.028.5.5 0 0 1-.051-.705ZM3.68 5.842a.5.5 0 0 1 .422.568c-.029.192-.044.39-.044.59 0 .71-.1 1.417-.298 2.1l-1.14 3.923a.5.5 0 1 1-.96-.279L2.8 8.821A6.531 6.531 0 0 0 3.058 7c0-.25.019-.496.054-.736a.5.5 0 0 1 .568-.422Zm8.882 3.66a.5.5 0 0 1 .456.54c-.084 1-.298 1.986-.64 2.934l-.744 2.068a.5.5 0 0 1-.941-.338l.745-2.07a10.51 10.51 0 0 0 .584-2.678.5.5 0 0 1 .54-.456Z"/>
                                                    <path d="M4.81 1.37A6.5 6.5 0 0 1 14.56 7a.5.5 0 1 1-1 0 5.5 5.5 0 0 0-8.25-4.765.5.5 0 0 1-.5-.865Zm-.89 1.257a.5.5 0 0 1 .04.706A5.478 5.478 0 0 0 2.56 7a.5.5 0 0 1-1 0c0-1.664.626-3.184 1.655-4.333a.5.5 0 0 1 .706-.04ZM1.915 8.02a.5.5 0 0 1 .346.616l-.779 2.767a.5.5 0 1 1-.962-.27l.778-2.767a.5.5 0 0 1 .617-.346Zm12.15.481a.5.5 0 0 1 .49.51c-.03 1.499-.161 3.025-.727 4.533l-.07.187a.5.5 0 0 1-.936-.351l.07-.187c.506-1.35.634-2.74.663-4.202a.5.5 0 0 1 .51-.49"/>
                                                </svg>
                                                Delegate
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                
                            </div>
                        @endforeach
                        <div class="modal fade" id="submitdelegate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Delegate Approval</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <form action="{{ route('approvals.delegate')}}" class="hidden" id="submit-delegate" method="POST">
                                        @method('post')
                                        @csrf
                                        <div>
                                            <input wire:model="approval_step_id" type="hidden">
                                            <input type="hidden" value="{{ $this->approval_step_id }}" name="approval_step_id" id="approval_step_id">
                                            <label for="address_while_on_leave" class="form-label">Person Delegated to:</label>
                                            <select id="related_employee" name="related_employee" class="form-select" aria-label="Default select">
                                                <option disabled >--</option>
                                                <option selected>Choose person</option>
                                                @foreach($delegated_employees as $employee)
                                                    <option value="{{ $employee['id'] }}">{{ $employee['related_user']['first_name'] }} {{ $employee['related_user']['last_name'] }} {{ $employee['related_role'] ? $employee['related_role']['role_name'] : null }}</option>
                                                @endforeach
                                            </select>
                                            @error('related_employee')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>person field required</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-success text-white" onclick="event.preventDefault(); document.getElementById('submit-delegate').submit();">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>      
        </div>
    </div>
</div>
