<div class="container-fluid p-0">
    <div class="row">
        @include('messages.flash')
    </div>
    
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-end">
            <div class="row row-cols-lg-auto g-3 align-items-center">
                <div class="col-12">
                    <label class="visually-hidden" for="project_id">Projects</label>
                    <select wire:model="project_id" wire:change="reqByProject" class="form-select">
                        <option selected>Choose Project</option>
                        @forelse($projects as $project)
                            <option value="{{ $project['related_project']['id'] }}">{{ $project['related_project']['project_name'] }}</option>
                        @empty
                            <option>No projects</option>
                        @endforelse
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a wire:click="handleTemplate" class="nav-link text-capitalize {{ $tempClicked ? 'active' : '' }}" id="nav-template-tab" data-bs-toggle="tab" data-bs-target="#nav-template" href="#templates" type="button" role="tab" aria-controls="nav-template" aria-selected="true">Templates</a>
                <a wire:click="handleRequest" class="nav-link text-capitalize {{ $reqClicked ? 'active' : '' }}" id="nav-history-tab" data-bs-toggle="tab" data-bs-target="#nav-history" href="#history" type="button" role="tab" aria-controls="nav-history" aria-selected="false">Request</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade {{ $tempClicked ? 'show active' : '' }}" id="nav-template" role="tabpanel" aria-labelledby="nav-template-tab" tabindex="0">
                <div class="row">
                    <div class="col-lg-12 mb-5">
                        <h4 class="text-capitalize fw-bold my-3">List of payment templates</h4>
                        <div class="border bg-white rounded-3 shadow px-4 py-3 mt-4">
                            @if(Session::get('employee_details')['has_department_role'] == false  || Session::has('projects'))
                                @if (count($paymentTypes) > 0)
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Project</th>
                                                <th scope="col">Station</th>
                                                <th class="text-capitalize" scope="col">Document name</th>
                                                <th class="text-capitalize" scope="col">Order number</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($paymentTypes as $paymentType)
                                                <tr>
                                                    <td>{{ $paymentType['related_project']['project_name'] }}</td>
                                                    <td class="text-capitalize">{{ Str::lower($paymentType['related_region_project']['station_name']) }}</td>
                                                    <td class="text-capitalize">{{ Str::lower($paymentType['document_name']) }}</td>
                                                    <td>{{ $paymentType['order_number'] }}</td>
                                                    <td>
                                                        <a wire:click="createPaymentType({{ $paymentType['id'] }})" class="btn btn-sm btn-outline-primary text-capitalize rounded">
                                                            Create request
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="text-center text-capitalize">
                                        @include('messages.flash')
                                    </div>
                                @endif
                            @else
                                Unable to Create Request
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade {{ $reqClicked ? 'show active' : '' }}" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab" tabindex="0">
                <div class="row">
                    <div class="col-lg-12 mb-5">
                        <div class="d-flex justify-content-between my-3">
                            <h4 class="text-capitalize fw-bold">List of {{ $authStatus ? 'authorized' : '' }} {{ $unAuthStatus ? 'Unauthorized' : ''}} {{ $rejectStatus ? 'Rejected' : ''}} payment requests</h4>
                            <div>
                                <div class="btn-group rounded" role="group">
                                    <button wire:click="unAuthorized" type="button" class="btn btn-outline-primary {{ $unAuthStatus ? 'active' : ''}}">Unauthorized</button>
                                    <button wire:click="authorized"  type="button" class="btn btn-outline-primary {{ $authStatus ? 'active' : ''}}">Authorized</button>
                                    <button wire:click="rejected"  type="button" class="btn btn-outline-primary {{ $rejectStatus ? 'active' : ''}}">Rejected</button>
                                </div>
                            </div>
                        </div>
                        <div class="border bg-white rounded-3 shadow px-4 py-3 mt-4">
                            @if (count($paymentReqs) > 0)
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-capitalize" scope="col">Date added</th>
                                            <th class="text-capitalize" scope="col">Requests title</th>
                                            <th class="text-capitalize" scope="col">Document name</th>
                                            <th scope="col">Project</th>
                                            <th scope="col">Station </th>
                                            <th class="text-capitalize" scope="col">Order number</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($paymentReqs as $paymentReq)
                                            <tr>
                                                <td class="text-capitalize">{{ Carbon\Carbon::parse($paymentReq['date_added'])->format('d/m/Y') }}</td>
                                                <td class="text-capitalize"><a class="text-decoration-none" wire:navigate href="{{ route('payments.show', $paymentReq['id']) }}">{{ Str::lower($paymentReq['fields']['title']) }}</a></td>
                                                <td class="text-capitalize">{{ Str::lower($paymentReq['related_project_document']['document_name']) }}</td>
                                                <td>{{ $paymentReq['related_project_document']['related_project']['project_name'] }}</td>
                                                <td class="text-capitalize">{{ Str::lower($paymentReq['related_project_document']['related_region_project']['station_name']) }}</td>
                                                <td>{{ $paymentReq['related_project_document']['order_number'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center text-capitalize pt-3">
                                    @include('messages.flash')
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let url = location.href.replace(/\/$/, '');
            var tabList = [].slice.call(document.querySelectorAll("#nav-tab a"));
            if (location.hash) {
                const hash = url.split('#');
                const currentTab = tabList[0];
                const curTab = new bootstrap.Tab(currentTab);
                curTab.show();
                url = location.href.replace(/\/#/, '#');
                history.replaceState(null, null, url);
                setTimeout(() => {
                    window.scrollTop = 0;
                }, 400);
            }

            // change url based on selected tab
            tabList.forEach((selectableTab) => {
                selectableTab.addEventListener('click', function () {
                    var newUrl;
                    const hash = selectableTab.getAttribute('href');
                    // if (hash == '#templates') {
                    //     newUrl = url.split('#')[0];
                    // } else {
                    // }
                    newUrl = url.split('#')[0] + hash;
                    history.replaceState(null, null, newUrl);
                });
            });
        });
    </script>
@endpush