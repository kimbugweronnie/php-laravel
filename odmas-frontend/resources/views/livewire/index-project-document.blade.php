<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between mb-3">
            <div class="row row-cols-lg-auto g-3 align-items-center">
                <div class="col-12">
                   <label class="visually-hidden" for="project_id">Projects</label>
                    <select wire:model="project_id" wire:change="reqByProject" class="form-select">
                        <option selected>Choose Project</option>
                        @forelse($this->projects as $project)
                            <option value="{{ $project['id'] }}">{{ $project['project_name'] }}</option>
                        @empty
                            <option>No projects</option>
                        @endforelse
                    </select>
                </div>
            </div>
            <h3 class="text-capitalize">
                <a class="btn btn-outline-primary" href="{{ route('projectDocuments.create') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-plus" viewBox="0 0 18 18">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                    </svg>
                    Create Project Document
                </a>
            </h3>
        </div>
    </div> 
    <div class="row">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a wire:click="handleMemo" class="nav-link text-capitalize {{ $memoClicked ? 'active' : '' }}" id="nav-memo-tab" data-bs-toggle="tab" data-bs-target="#nav-memo" href="#memo" type="button" role="tab" aria-controls="nav-memo" aria-selected="true">Memos</a>
                <a wire:click="handleProcurement" class="nav-link text-capitalize {{ $procurementClicked ? 'active' : '' }}" id="nav-procurement-tab" data-bs-toggle="tab" data-bs-target="#nav-procurement" href="#procurement" type="button" role="tab" aria-controls="nav-procurement" aria-selected="false">Procurement</a>
                <a wire:click="handlePayment" class="nav-link text-capitalize {{ $paymentClicked ? 'active' : '' }}" id="nav-payment-tab" data-bs-toggle="tab" data-bs-target="#nav-payment" href="#payment" type="button" role="tab" aria-controls="nav-payment" aria-selected="false">Payment</a>
                <a wire:click="handleTravel" class="nav-link text-capitalize {{ $travelClicked ? 'active' : '' }}" id="nav-travel-tab" data-bs-toggle="tab" data-bs-target="#nav-travel" href="#travel" type="button" role="tab" aria-controls="nav-travel" aria-selected="false">Travel</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade {{ $memoClicked ? 'show active' : '' }}" id="nav-memos" role="tabpanel" aria-labelledby="nav-active-tab" tabindex="0"> 
                <div class="row">
                    <div class="col-lg-12 mb-5">
                        @if (count($memoTypes) > 0)
                            <h4 class="text-capitalize fw-bold my-3">List of memo templates</h4>
                        @endif
                        <div class="border bg-white rounded-3 shadow px-4 py-3 mt-4">
                            @if (count($memoTypes) > 0)
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Project</th>
                                            <th scope="col">Station </th>
                                            <th class="text-capitalize" scope="col">Document name</th>
                                            <th class="text-capitalize" scope="col">Order number</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($memoTypes as $memoType)
                                            <tr>
                                                <td>{{ $memoType['related_project']['project_name'] }}</td>
                                                <td class="text-capitalize">{{ Str::lower($memoType['related_region_project']['station_name']) }}</td>
                                                <td class="text-capitalize"><a class="text-decoration-none" wire:navigate href="{{ route('projectDocuments.edit', $memoType['id']) }}">{{ Str::lower($memoType['document_name']) }}</a></td>
                                                <td>{{ $memoType['order_number'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center text-capitalize">
                                    <h5>No templates</h5>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade {{ $procurementClicked ? 'show active' : '' }}" id="nav-procurement" role="tabpanel" aria-labelledby="nav-procurement-tab" tabindex="0">   
                <div class="row">
                    <div class="col-lg-12 mb-5">
                        @if (count($procurementTypes) > 0)
                            <h4 class="text-capitalize fw-bold my-3">List of procurement templates</h4>
                        @endif
                        <div class="border bg-white rounded-3 shadow px-4 py-3 mt-4">
                            @if (count($procurementTypes) > 0)
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Project</th>
                                            <th scope="col">Station </th>
                                            <th class="text-capitalize" scope="col">Document name</th>
                                            <th class="text-capitalize" scope="col">Order number</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($procurementTypes as $procurementType)
                                            <tr>
                                                <td>{{ $procurementType['related_project']['project_name'] }}</td>
                                                <td class="text-capitalize">{{ Str::lower($procurementType['related_region_project']['station_name']) }}</td>
                                                <td class="text-capitalize"><a class="text-decoration-none" wire:navigate href="{{ route('projectDocuments.edit', $procurementType['id']) }}">{{ Str::lower($procurementType['document_name']) }}</a></td>
                                                <td>{{ $procurementType['order_number'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center text-capitalize">
                                    <div class="text-center text-capitalize">
                                        <h5>No templates</h5>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade {{ $paymentClicked ? 'show active' : '' }}" id="nav-payment" role="tabpanel" aria-labelledby="nav-payment-tab" tabindex="0"> 
                <div class="row">
                    <div class="col-lg-12 mb-5">
                        @if (count($paymentTypes) > 0)
                            <h4 class="text-capitalize fw-bold my-3">List of payment templates</h4>
                        @endif
                        <div class="border bg-white rounded-3 shadow px-4 py-3 mt-4">
                            @if (count($paymentTypes) > 0)
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Project</th>
                                            <th scope="col">Station </th>
                                            <th class="text-capitalize" scope="col">Document name</th>
                                            <th class="text-capitalize" scope="col">Order number</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($paymentTypes as $paymentTemp)
                                            <tr>
                                                <td>{{ $paymentTemp['related_project']['project_name'] }}</td>
                                                <td class="text-capitalize">{{ Str::lower($paymentTemp['related_region_project']['station_name']) }}</td>
                                                <td class="text-capitalize"><a class="text-decoration-none" wire:navigate href="{{ route('projectDocuments.edit', $paymentTemp['id']) }}">{{ Str::lower($paymentTemp['document_name']) }}</a></td>
                                                <td>{{ $paymentTemp['order_number'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center text-capitalize">
                                    <h5>No templates</h5>
                                </div>
                            @endif
                        </div>
                    </div>
                </div> 
            </div>
            <div class="tab-pane fade {{ $travelClicked ? 'show active' : '' }}" id="nav-travel" role="tabpanel" aria-labelledby="nav-travel-tab" tabindex="0"> 
                <div class="row">
                    <div class="col-lg-12 mb-5">
                        @if (count($travelTypes) > 0)
                            <h4 class="text-capitalize fw-bold my-3">List of travel templates</h4>
                        @endif
                        <div class="border bg-white rounded-3 shadow px-4 py-3 mt-4">
                            @if (count($travelTypes) > 0)
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Project</th>
                                            <th scope="col">Station </th>
                                            <th class="text-capitalize" scope="col">Document name</th>
                                            <th class="text-capitalize" scope="col">Order number</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($travelTypes as $travelTemp)
                                            <tr>
                                                <td>{{ $travelTemp['related_project']['project_name'] }}</td>
                                                <td class="text-capitalize">{{ Str::lower($travelTemp['related_region_project']['station_name']) }}</td>
                                                <td class="text-capitalize"><a class="text-decoration-none" wire:navigate href="{{ route('projectDocuments.edit', $travelTemp['id']) }}">{{ Str::lower($travelTemp['document_name']) }}</a></td>
                                                <td>{{ $travelTemp['order_number'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center text-capitalize">
                                    <h5>No templates</h5>
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
                    // if (hash == '#active') {
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