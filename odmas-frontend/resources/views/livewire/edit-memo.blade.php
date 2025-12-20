@push('styles')
    <style>
        #blur {
        color: transparent;
        text-shadow: 0 0 8px #000;
      }
    </style>
@endpush

<div class="container-fluid p-0">
    <div class="row">
        @include('messages.flash')
        <div class="col-lg-12 d-flex justify-content-between">
            <h4 class="text-capitalize fw-bold">{{ $memo['title'] }}</h4>
            <a class="btn btn-secondary px-3" href="{{ url()->previous() }}">
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
            <div class="border bg-white rounded-3 shadow px-3 pt-2">
                <table class="table table-borderless ">
                    <thead class="d-flex justify-content-center mb-3">
                        <tr>
                        <th class="fs-4 text-uppercase fw-bold text-center pb-4">
                                <div><img src="{{ asset('img/full-logo.png') }}" width="140" alt=" memo image"></div>
                                <div>Uganda episcopal conference</div> 
                                <div>Uganda catholic secretariat</div>
                                <div>Uganda catholic medical bureau</div>  
                                <div>{{ $memo['related_document_request']['related_project_document']['related_project']['project_name'] }}</div> 
                                <div>{{ $memo['related_document_request']['related_project_document']['order_number'] }}</div>
                                <div>{{ $memo['title'] }}</div>    
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-1 fs-4"><span class="fw-bold">Date:</span> {{ Carbon\Carbon::parse($memo['date'])->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td class="py-1 fs-4"><span class="fw-bold">To:</span> {{ $memo['to']['related_user']['first_name'] }} {{ $memo['to']['related_user']['last_name'] }} -- {{ $memo['to']['role'] ?  $memo['to']['role'] : null }}</td>
                        </tr>
                        <tr>
                            <td class="py-1 fs-4"><span class="fw-bold">Thru:</span> 
                                @foreach($memo['meta_fields'] as $personsThru)
                                    <span>{{ $personsThru['persons_through']['related_user']['first_name'] }} {{ $personsThru['persons_through']['related_user']['last_name'] }} -- {{  $personsThru['persons_through']['role']  ? $personsThru['persons_through']['role']  : null }},</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td class="py-1 fs-4"><span class="fw-bold">Added By:</span> {{ $memo['related_document_request']['added_by']['first_name']}}  {{ $memo['related_document_request']['added_by']['last_name']}}</td>
                        </tr>
                        <tr>
                            <td class="pt-4 pb-1 fs-4"><span class="fw-bold">Title:</span> {{ $memo['title'] }}</td>
                        </tr>
                        <tr>
                            <td class="py-1 fs-4"><span class="fw-bold">Background:</span> {{ $memo['background'] }}</td>
                        </tr>
                        <tr>
                            <td class="py-1 fs-4"><span class="fw-bold">Purpose:</span> {{ $memo['purpose'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-12 my-4">
            <div class="border bg-white rounded-3 shadow px-4 py-3">
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
                                    <td> {{ $currentUser['first_name'] }} {{ $currentUser['last_name'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else 
                    <div>
                        <p class="text-center text-muted">No attachments</p>  
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-12">
            @include('messages.flash')
            <div class="border bg-white rounded-3 shadow p-4">
                @foreach($memo['approval_steps'] as $approver)
                    <div class="row mt-4">
                        <div class="col-6 fs-4">
                            @if($approver['related_document_approval_step']['approval_step_name'] == "REVIEW")
                                <span class="fw-bold text-capitalize">Reviewed by:</span>
                            @elseif($approver['related_document_approval_step']['approval_step_name'] == "APPROVAL")
                                <span class="fw-bold text-capitalize">Approved by:</span>
                            @elseif($approver['related_document_approval_step']['approval_step_name'] == "AUTHORISATION")
                                <span class="fw-bold text-capitalize">Authorized by:</span>
                            @endif
                            {{ $approver['related_approver']['related_user']['first_name'] }} 
                            {{ $approver['related_approver']['related_user']['last_name'] }}
                        </div>

                        <div class="col-6 fs-4">
                            <span class="fw-bold text-capitalize">{{ Str::lower($approver['generic_role_name']) }}</span> 
                        </div>
                        <div class="col-12">
                            @if ($approver['next_step'] && !$approver['status'])
                                <div class="my-2">
                                    <form>
                                        <div>
                                            <label class="fw-bold mb-2" for="comment">Comment:</label>
                                            <textarea wire:model="comment" class="form-control" cols="30" rows="4" required></textarea>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <div class="col-12"> 
                            @if ($approver['next_step'] && !$approver['status'])
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
                                                @if($approver['related_document_approval_step']['approval_step_name']== "REVIEW")
                                                    <span class="fw-bold text-capitalize px-2">Review</span>
                                                @elseif($approver['related_document_approval_step']['approval_step_name']== "APPROVAL")
                                                    <span class="fw-bold text-capitalize px-1">Approve</span>
                                                @elseif($approver['related_document_approval_step']['approval_step_name']== "AUTHORISATION")
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
                                            <button type="submit" class="btn btn-outline-primary text-capitalize ms-4 px-3" >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-fingerprint me-2" viewBox="0 0 16 16" style="color:#ffa64d;">
                                                    <path d="M8.06 6.5a.5.5 0 0 1 .5.5v.776a11.5 11.5 0 0 1-.552 3.519l-1.331 4.14a.5.5 0 0 1-.952-.305l1.33-4.141a10.5 10.5 0 0 0 .504-3.213V7a.5.5 0 0 1 .5-.5Z"/>
                                                    <path d="M6.06 7a2 2 0 1 1 4 0 .5.5 0 1 1-1 0 1 1 0 1 0-2 0v.332c0 .409-.022.816-.066 1.221A.5.5 0 0 1 6 8.447c.04-.37.06-.742.06-1.115zm3.509 1a.5.5 0 0 1 .487.513 11.5 11.5 0 0 1-.587 3.339l-1.266 3.8a.5.5 0 0 1-.949-.317l1.267-3.8a10.5 10.5 0 0 0 .535-3.048A.5.5 0 0 1 9.569 8Zm-3.356 2.115a.5.5 0 0 1 .33.626L5.24 14.939a.5.5 0 1 1-.955-.296l1.303-4.199a.5.5 0 0 1 .625-.329Z"/>
                                                    <path d="M4.759 5.833A3.501 3.501 0 0 1 11.559 7a.5.5 0 0 1-1 0 2.5 2.5 0 0 0-4.857-.833.5.5 0 1 1-.943-.334Zm.3 1.67a.5.5 0 0 1 .449.546 10.72 10.72 0 0 1-.4 2.031l-1.222 4.072a.5.5 0 1 1-.958-.287L4.15 9.793a9.72 9.72 0 0 0 .363-1.842.5.5 0 0 1 .546-.449Zm6 .647a.5.5 0 0 1 .5.5c0 1.28-.213 2.552-.632 3.762l-1.09 3.145a.5.5 0 0 1-.944-.327l1.089-3.145c.382-1.105.578-2.266.578-3.435a.5.5 0 0 1 .5-.5Z"/>
                                                    <path d="M3.902 4.222a4.996 4.996 0 0 1 5.202-2.113.5.5 0 0 1-.208.979 3.996 3.996 0 0 0-4.163 1.69.5.5 0 0 1-.831-.556Zm6.72-.955a.5.5 0 0 1 .705-.052A4.99 4.99 0 0 1 13.059 7v1.5a.5.5 0 1 1-1 0V7a3.99 3.99 0 0 0-1.386-3.028.5.5 0 0 1-.051-.705ZM3.68 5.842a.5.5 0 0 1 .422.568c-.029.192-.044.39-.044.59 0 .71-.1 1.417-.298 2.1l-1.14 3.923a.5.5 0 1 1-.96-.279L2.8 8.821A6.531 6.531 0 0 0 3.058 7c0-.25.019-.496.054-.736a.5.5 0 0 1 .568-.422Zm8.882 3.66a.5.5 0 0 1 .456.54c-.084 1-.298 1.986-.64 2.934l-.744 2.068a.5.5 0 0 1-.941-.338l.745-2.07a10.51 10.51 0 0 0 .584-2.678.5.5 0 0 1 .54-.456Z"/>
                                                    <path d="M4.81 1.37A6.5 6.5 0 0 1 14.56 7a.5.5 0 1 1-1 0 5.5 5.5 0 0 0-8.25-4.765.5.5 0 0 1-.5-.865Zm-.89 1.257a.5.5 0 0 1 .04.706A5.478 5.478 0 0 0 2.56 7a.5.5 0 0 1-1 0c0-1.664.626-3.184 1.655-4.333a.5.5 0 0 1 .706-.04ZM1.915 8.02a.5.5 0 0 1 .346.616l-.779 2.767a.5.5 0 1 1-.962-.27l.778-2.767a.5.5 0 0 1 .617-.346Zm12.15.481a.5.5 0 0 1 .49.51c-.03 1.499-.161 3.025-.727 4.533l-.07.187a.5.5 0 0 1-.936-.351l.07-.187c.506-1.35.634-2.74.663-4.202a.5.5 0 0 1 .51-.49"/>
                                                </svg>
                                                @if($approver['related_document_approval_step']['approval_step_name']== "REVIEW")
                                                    <span class="fw-bold text-capitalize px-2">Refer Back</span>
                                                @elseif($approver['related_document_approval_step']['approval_step_name']== "APPPROVAL")
                                                    <span class="fw-bold text-capitalize px-2">Refer Back</span>
                                                @elseif($approver['related_document_approval_step']['approval_step_name']== "AUTHORISATION")
                                                    <span class="fw-bold text-capitalize px-2">Refer Back</span>
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
                            @else
                                <div>
                                    <div>
                                        @if ($approver['approval_comment'])
                                            <div>
                                                <p>{{ $approver['approval_comment'] }}</p>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-outline-primary text-capitalize px-3" disabled>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16">
                                                        <path d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0"/>
                                                        <path d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708"/>
                                                    </svg>
                                                    @if($approver['related_document_approval_step']['approval_step_name']== "REVIEW")
                                                        <span class="fw-bold text-capitalize px-2">Reviewed</span>
                                                    @elseif($approver['related_document_approval_step']['approval_step_name']== "APPPROVAL")
                                                        <span class="fw-bold text-capitalize px-1">Approved</span>
                                                    @elseif($approver['related_document_approval_step']['approval_step_name']== "AUTHORISATION")
                                                        <span class="fw-bold text-capitalize">Authorized</span>
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
                                                    @if($approver['related_document_approval_step']['approval_step_name']== "REVIEW")
                                                        <span class="fw-bold text-capitalize px-2">Referred Back</span>
                                                    @elseif($approver['related_document_approval_step']['approval_step_name']== "APPPROVAL")
                                                        <span class="fw-bold text-capitalize px-2">Referred Back</span>
                                                    @elseif($approver['related_document_approval_step']['approval_step_name']== "AUTHORISATION")
                                                        <span class="fw-bold text-capitalize px-2">Referred Back</span>
                                                    @endif
                                                </button>
                                            </div>
                                        @else
                                            <button type="button" id="blur" class="btn btn-outline-primary text-capitalize px-3" disabled>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-fingerprint me-2" viewBox="0 0 16 16">
                                                    <path d="M8.06 6.5a.5.5 0 0 1 .5.5v.776a11.5 11.5 0 0 1-.552 3.519l-1.331 4.14a.5.5 0 0 1-.952-.305l1.33-4.141a10.5 10.5 0 0 0 .504-3.213V7a.5.5 0 0 1 .5-.5Z"/>
                                                    <path d="M6.06 7a2 2 0 1 1 4 0 .5.5 0 1 1-1 0 1 1 0 1 0-2 0v.332c0 .409-.022.816-.066 1.221A.5.5 0 0 1 6 8.447c.04-.37.06-.742.06-1.115zm3.509 1a.5.5 0 0 1 .487.513 11.5 11.5 0 0 1-.587 3.339l-1.266 3.8a.5.5 0 0 1-.949-.317l1.267-3.8a10.5 10.5 0 0 0 .535-3.048A.5.5 0 0 1 9.569 8Zm-3.356 2.115a.5.5 0 0 1 .33.626L5.24 14.939a.5.5 0 1 1-.955-.296l1.303-4.199a.5.5 0 0 1 .625-.329Z"/>
                                                    <path d="M4.759 5.833A3.501 3.501 0 0 1 11.559 7a.5.5 0 0 1-1 0 2.5 2.5 0 0 0-4.857-.833.5.5 0 1 1-.943-.334Zm.3 1.67a.5.5 0 0 1 .449.546 10.72 10.72 0 0 1-.4 2.031l-1.222 4.072a.5.5 0 1 1-.958-.287L4.15 9.793a9.72 9.72 0 0 0 .363-1.842.5.5 0 0 1 .546-.449Zm6 .647a.5.5 0 0 1 .5.5c0 1.28-.213 2.552-.632 3.762l-1.09 3.145a.5.5 0 0 1-.944-.327l1.089-3.145c.382-1.105.578-2.266.578-3.435a.5.5 0 0 1 .5-.5Z"/>
                                                    <path d="M3.902 4.222a4.996 4.996 0 0 1 5.202-2.113.5.5 0 0 1-.208.979 3.996 3.996 0 0 0-4.163 1.69.5.5 0 0 1-.831-.556Zm6.72-.955a.5.5 0 0 1 .705-.052A4.99 4.99 0 0 1 13.059 7v1.5a.5.5 0 1 1-1 0V7a3.99 3.99 0 0 0-1.386-3.028.5.5 0 0 1-.051-.705ZM3.68 5.842a.5.5 0 0 1 .422.568c-.029.192-.044.39-.044.59 0 .71-.1 1.417-.298 2.1l-1.14 3.923a.5.5 0 1 1-.96-.279L2.8 8.821A6.531 6.531 0 0 0 3.058 7c0-.25.019-.496.054-.736a.5.5 0 0 1 .568-.422Zm8.882 3.66a.5.5 0 0 1 .456.54c-.084 1-.298 1.986-.64 2.934l-.744 2.068a.5.5 0 0 1-.941-.338l.745-2.07a10.51 10.51 0 0 0 .584-2.678.5.5 0 0 1 .54-.456Z"/>
                                                    <path d="M4.81 1.37A6.5 6.5 0 0 1 14.56 7a.5.5 0 1 1-1 0 5.5 5.5 0 0 0-8.25-4.765.5.5 0 0 1-.5-.865Zm-.89 1.257a.5.5 0 0 1 .04.706A5.478 5.478 0 0 0 2.56 7a.5.5 0 0 1-1 0c0-1.664.626-3.184 1.655-4.333a.5.5 0 0 1 .706-.04ZM1.915 8.02a.5.5 0 0 1 .346.616l-.779 2.767a.5.5 0 1 1-.962-.27l.778-2.767a.5.5 0 0 1 .617-.346Zm12.15.481a.5.5 0 0 1 .49.51c-.03 1.499-.161 3.025-.727 4.533l-.07.187a.5.5 0 0 1-.936-.351l.07-.187c.506-1.35.634-2.74.663-4.202a.5.5 0 0 1 .51-.49"/>
                                                </svg>
                                                @if($approver['related_document_approval_step']['approval_step_name']== "REVIEW")
                                                    <span class="fw-bold text-capitalize px-2">Review</span>
                                                @elseif($approver['related_document_approval_step']['approval_step_name']== "APPPROVAL")
                                                    <span class="fw-bold text-capitalize px-1">Approved</span>
                                                @elseif($approver['related_document_approval_step']['approval_step_name']== "AUTHORISATION")
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
                                                @if($approver['related_document_approval_step']['approval_step_name']== "REVIEW")
                                                    <span class="fw-bold text-capitalize px-2">Refer Back</span>
                                                @elseif($approver['related_document_approval_step']['approval_step_name']== "APPPROVAL")
                                                    <span class="fw-bold text-capitalize px-2">Refer Back</span>
                                                @elseif($approver['related_document_approval_step']['approval_step_name']== "AUTHORISATION")
                                                    <span class="fw-bold text-capitalize px-2">Refer Back</span>
                                                @endif
                                            </button>
                                        @endif    
                                    </div>
                                </div>
                            @endif
                        </div>                       
                    </div>
                @endforeach
            </div>
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
                                    @foreach($employees as $employee)
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