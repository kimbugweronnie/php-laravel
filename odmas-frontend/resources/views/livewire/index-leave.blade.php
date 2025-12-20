<div class="container-fluid p-0">
    <div class="row">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a wire:click="handlePending" class="nav-link text-capitalize {{ $pendingClicked ? 'active' : '' }}"
                    id="nav-template-tab" data-bs-toggle="tab" data-bs-target="#nav-unauthorized" href="#unauthorized"
                    type="button" role="tab" aria-controls="nav-pending" aria-selected="true">Unauthorized</a>
                {{-- <a wire:click="handleApproved" class="nav-link text-capitalize {{ $approvedClicked ? 'active' : '' }}"
                    id="nav-request-tab" data-bs-toggle="tab" data-bs-target="#nav-authorized" href="#authorized"
                    type="button" role="tab" aria-controls="nav-approved" aria-selected="false">Authorized</a>
                <a wire:click="handleRejected" class="nav-link text-capitalize {{ $rejectedClicked ? 'active' : '' }}"
                    id="nav-matrix-tab" data-bs-toggle="tab" data-bs-target="#nav-rejected" href="#rejected"
                    type="button" role="tab" aria-controls="#nav-rejected" aria-selected="false">Rejected</a> --}}

            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade {{ $pendingClicked ? 'show active' : '' }}" id="nav-pending" role="tabpanel"
                aria-labelledby="nav-pending-tab" tabindex="0">
                <div class="row">
                    <div class="col-lg-12 mb-5">
                        @if ($pendingRequests)
                            <h4 class="text-capitalize fw-bold my-3">List of Unauthorized Requests</h4>
                        @endif
                        <div class="border bg-white rounded-3 shadow px-4 py-3 mt-4">
                            @if (Session::get('employee_details')['has_department_role'] == false || Session::has('projects'))
                                @if (count($pendingRequests) > 0)
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Title</th>
                                                <th scope="col">Date Added</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pendingRequests as $pendingRequest)
                                                <tr>
                                                    <td><a class="text-decoration-none"
                                                            href="{{ route('leave.show', $pendingRequest['id']) }}">{{ $pendingRequest['fields']['title'] }}</a>
                                                    </td>
                                                    <td>
                                                        {{ date('d/m/Y', strtotime($pendingRequest['date_added'])) }}
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
            <div class="tab-pane fade {{ $approvedClicked ? 'show active' : '' }}" id="nav-approved" role="tabpanel"
                aria-labelledby="nav-approved-tab" tabindex="0">
                <div class="row">
                    <div class="col-lg-12 mb-5">
                        @if ($approvedRequests)
                            <h4 class="text-capitalize fw-bold my-3">List of authorized requests</h4>
                        @endif
                        <div class="border bg-white rounded-3 shadow px-4 py-3 mt-4">
                            @if (Session::get('employee_details')['has_department_role'] == false || Session::has('projects'))
                                @if (count($approvedRequests) > 0)
                                    <table class="table table-hover">
                                        <!-- <thead>
                                            <tr>
                                                <th scope="col">Project</th>
                                                <th scope="col">Station </th>
                                                <th class="text-capitalize" scope="col">Document name</th>
                                                <th class="text-capitalize" scope="col">Order number</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead> -->
                                        <tbody>

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
            <div class="tab-pane fade {{ $rejectedClicked ? 'show active' : '' }}" id="nav-rejected" role="tabpanel"
                aria-labelledby="nav-rejected-tab" tabindex="0">
                <div class="row">
                    <div class="col-lg-12 mb-5">
                        @if ($rejectedRequests)
                            <h4 class="text-capitalize fw-bold my-3">List of rejected requests</h4>
                        @endif
                        <div class="border bg-white rounded-3 shadow px-4 py-3 mt-4">
                            @if (Session::get('employee_details')['has_department_role'] == false || Session::has('projects'))
                                @if (count($rejectedRequests) > 0)
                                    <table class="table table-hover">
                                        <!-- <thead>
                                            <tr>
                                                <th scope="col">Project</th>
                                                <th scope="col">Station </th>
                                                <th class="text-capitalize" scope="col">Document name</th>
                                                <th class="text-capitalize" scope="col">Order number</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead> -->
                                        <tbody>

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
                selectableTab.addEventListener('click', function() {
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
