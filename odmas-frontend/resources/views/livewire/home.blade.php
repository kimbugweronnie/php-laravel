<div class="container-fluid p-0">
     @include('messages.flash')
    <h1 class="h3 mb-3">Home</h1>
    <div class="row">
        <div class="col-xl-6 col-xxl-5 d-flex">
            <div class="w-100">
                <div class="row">
                    <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Activities</h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-dice-5" viewBox="0 0 16 16">
                                                    <path d="M13 1a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h10zM3 0a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V3a3 3 0 0 0-3-3H3z"/>
                                                    <path d="M5.5 4a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm8 0a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0 8a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-8 0a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm4-4a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">{{ $activityCount }}</h1>
                                    <div class="mb-0">
                                        <span class="text-muted"><a type="button" class="text-capitalize text-decoration-none" href="{{ route('activities.index') }}">View more</a></span>
                                    </div>
                                </div>
                            </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Calendar</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-calendar4-week" viewBox="0 0 16 16">
                                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/>
                                                <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-2 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <h1>&nbsp;</h1>
                                <div class="mb-0">
                                    <span class="text-muted"><a type="button" class="btn btn-outline-primary d-flex justify-content-center text-capitalize" href="{{ route('calendar.index') }}">View more</a></span>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Leave</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-cup-hot" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M.5 6a.5.5 0 0 0-.488.608l1.652 7.434A2.5 2.5 0 0 0 4.104 16h5.792a2.5 2.5 0 0 0 2.44-1.958l.131-.59a3 3 0 0 0 1.3-5.854l.221-.99A.5.5 0 0 0 13.5 6zM13 12.5a2.01 2.01 0 0 1-.316-.025l.867-3.898A2.001 2.001 0 0 1 13 12.5M2.64 13.825 1.123 7h11.754l-1.517 6.825A1.5 1.5 0 0 1 9.896 15H4.104a1.5 1.5 0 0 1-1.464-1.175Z"/>
                                                <path d="m4.4.8-.003.004-.014.019a4.167 4.167 0 0 0-.204.31 2.327 2.327 0 0 0-.141.267c-.026.06-.034.092-.037.103v.004a.593.593 0 0 0 .091.248c.075.133.178.272.308.445l.01.012c.118.158.26.347.37.543.112.2.22.455.22.745 0 .188-.065.368-.119.494a3.31 3.31 0 0 1-.202.388 5.444 5.444 0 0 1-.253.382l-.018.025-.005.008-.002.002A.5.5 0 0 1 3.6 4.2l.003-.004.014-.019a4.149 4.149 0 0 0 .204-.31 2.06 2.06 0 0 0 .141-.267c.026-.06.034-.092.037-.103a.593.593 0 0 0-.09-.252A4.334 4.334 0 0 0 3.6 2.8l-.01-.012a5.099 5.099 0 0 1-.37-.543A1.53 1.53 0 0 1 3 1.5c0-.188.065-.368.119-.494.059-.138.134-.274.202-.388a5.446 5.446 0 0 1 .253-.382l.025-.035A.5.5 0 0 1 4.4.8m3 0-.003.004-.014.019a4.167 4.167 0 0 0-.204.31 2.327 2.327 0 0 0-.141.267c-.026.06-.034.092-.037.103v.004a.593.593 0 0 0 .091.248c.075.133.178.272.308.445l.01.012c.118.158.26.347.37.543.112.2.22.455.22.745 0 .188-.065.368-.119.494a3.31 3.31 0 0 1-.202.388 5.444 5.444 0 0 1-.253.382l-.018.025-.005.008-.002.002A.5.5 0 0 1 6.6 4.2l.003-.004.014-.019a4.149 4.149 0 0 0 .204-.31 2.06 2.06 0 0 0 .141-.267c.026-.06.034-.092.037-.103a.593.593 0 0 0-.09-.252A4.334 4.334 0 0 0 6.6 2.8l-.01-.012a5.099 5.099 0 0 1-.37-.543A1.53 1.53 0 0 1 6 1.5c0-.188.065-.368.119-.494.059-.138.134-.274.202-.388a5.446 5.446 0 0 1 .253-.382l.025-.035A.5.5 0 0 1 7.4.8m3 0-.003.004-.014.019a4.077 4.077 0 0 0-.204.31 2.337 2.337 0 0 0-.141.267c-.026.06-.034.092-.037.103v.004a.593.593 0 0 0 .091.248c.075.133.178.272.308.445l.01.012c.118.158.26.347.37.543.112.2.22.455.22.745 0 .188-.065.368-.119.494a3.198 3.198 0 0 1-.202.388 5.385 5.385 0 0 1-.252.382l-.019.025-.005.008-.002.002A.5.5 0 0 1 9.6 4.2l.003-.004.014-.019a4.149 4.149 0 0 0 .204-.31 2.06 2.06 0 0 0 .141-.267c.026-.06.034-.092.037-.103a.593.593 0 0 0-.09-.252A4.334 4.334 0 0 0 9.6 2.8l-.01-.012a5.099 5.099 0 0 1-.37-.543A1.53 1.53 0 0 1 9 1.5c0-.188.065-.368.119-.494.059-.138.134-.274.202-.388a5.446 5.446 0 0 1 .253-.382l.025-.035A.5.5 0 0 1 10.4.8"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <h1>&nbsp;</h1>
                                <div class="mb-0">
                                    <span class="text-muted"><a type="button" class="btn btn-outline-primary d-flex justify-content-center text-capitalize" href="{{ route('leave.index') }}">View more</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Approvals</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-gear-wide-connected" viewBox="0 0 16 16">
                                                <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5m0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8zm.344 7.646.087.065z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">{{ $apprNums }}</h1>
                                <div class="mb-0">
                                    <span class="text-muted"><a type="button" class="text-capitalize text-decoration-none" href="{{ route('approvals.index') }}">View more</a></span>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title text-capitalize">Clock in & Clock out</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-watch" viewBox="0 0 16 16">
                                                <path d="M8.5 5a.5.5 0 0 0-1 0v2.5H6a.5.5 0 0 0 0 1h2a.5.5 0 0 0 .5-.5z"/>
                                                <path d="M5.667 16C4.747 16 4 15.254 4 14.333v-1.86A6 6 0 0 1 2 8c0-1.777.772-3.374 2-4.472V1.667C4 .747 4.746 0 5.667 0h4.666C11.253 0 12 .746 12 1.667v1.86a6 6 0 0 1 1.918 3.48.502.502 0 0 1 .582.493v1a.5.5 0 0 1-.582.493A6 6 0 0 1 12 12.473v1.86c0 .92-.746 1.667-1.667 1.667zM13 8A5 5 0 1 0 3 8a5 5 0 0 0 10 0"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <h1>&nbsp;</h1>
                                <div class="row mx-1">
                                    @if($clockin_clockout["data"] == 0)
                                        <button onclick="enableLocation()" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#clockin">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
                                                <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
                                            </svg>
                                            Clock In
                                        </button>
                                        <form method="POST" id="clock-in" action="{{ route('storeClockIn') }}">
                                            @csrf
                                        </form>
                                    @elseif($clockin_clockout["data"] == 1 && $clockin_clockout["clock_out"] == 0)
                                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#clockout">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
                                                <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
                                            </svg>
                                            Clock Out
                                        </button>
                                        <form method="POST" id="clock-out" action="{{ route('storeClockOut') }}">
                                            @csrf
                                        </form>
                                    @elseif($clockin_clockout["data"] == 1 && $clockin_clockout["clock_out"] == 1 )
                                        <a class="text-capitalize text-decoration-none" href="{{ route('clockIns.index') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
                                                <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
                                            </svg>
                                            View More
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="modal fade" id="clockin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ date('h:i A', strtotime('+3 hours')) }}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-success text-white" onclick="event.preventDefault(); document.getElementById('clock-in').submit();">Clockin</button>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="clockout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold" id="exampleModalLabel">Are you sure?</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ date('H:i A', strtotime('+3 hours')) }}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" id="clockOutButton" class="btn btn-success text-white" onclick="event.preventDefault(); document.getElementById('clock-out').submit();">Clockout</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div> 
        </div>
        <div class="col-xl-6 col-xxl-7">
            <div class="card flex-fill w-100">
                <div class="card-header">
                    <h5 class="card-title mb-0 text-capitalize">List of approvals</h5>
                </div>
                <div class="card-body py-0">
                    @if(count($approvals) > 0)
                        <div>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-capitalize" scope="col">Date added</th>
                                        <th class="text-capitalize" scope="col">Request Title</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($approvals as $approval)
                                        @if($approval['is_project_document'] && $approval['related_project_document']['document_domain']['document_domain_name'] == 'PAYMENT')
                                            <tr>
                                                <td class="text-capitalize">{{ Carbon\Carbon::parse($approval['date_added'])->format('d/m/Y') }}</td>
                                                <td class="text-capitalize">{{ $approval['fields']['title'] }}</td>
                                                <td>
                                                    <a type="button" class="btn btn-sm btn-outline-primary text-capitalize rounded text-decoration-none" href="{{ route('payments.edit', $approval['id']) }}">View more</a> 
                                                </td>
                                            </tr>
                                        @elseif($approval['is_project_document'] && $approval['related_project_document']['document_domain']['document_domain_name'] == 'PROCUREMENT')
                                            <tr>
                                                <td class="text-capitalize">{{ Carbon\Carbon::parse($approval['date_added'])->format('d/m/Y') }}</td>
                                                <td class="text-capitalize">{{ $approval['fields']['title'] }}</td>
                                                <td>
                                                    <a type="button" class="btn btn-sm btn-outline-primary text-capitalize rounded text-decoration-none" href="{{ route('procurements.edit', $approval['id']) }}">View more</a> 
                                                </td>
                                            </tr>
                                        @elseif($approval['is_project_document'] && $approval['related_project_document']['document_domain']['document_domain_name'] == 'MEMO')
                                            <tr>
                                                <td class="text-capitalize">{{ Carbon\Carbon::parse($approval['date_added'])->format('d/m/Y') }}</td>
                                                <td class="text-capitalize">{{ $approval['fields']['title'] }}</td>
                                                <td>
                                                    <a type="button" class="btn btn-sm btn-outline-primary text-capitalize rounded text-decoration-none" href="{{ route('memos.edit', $approval['id']) }}">View more</a> 
                                                </td>
                                            </tr>
                                        @elseif($approval['is_project_document'] && $approval['related_project_document']['document_domain']['document_domain_name'] == 'TRANSPORT')
                                            <tr>
                                                <td class="text-capitalize">{{ Carbon\Carbon::parse($approval['date_added'])->format('d/m/Y') }}</td>
                                                <td class="text-capitalize">{{ $approval['fields']['title'] }}</td>
                                                <td>
                                                    <a type="button" class="btn btn-sm btn-outline-primary text-capitalize rounded text-decoration-none" href="{{ route('travels.edit', $approval['id']) }}">View more</a> 
                                                </td>
                                            </tr>
                                        @elseif($approval['request_category'] == 'TIMESHEET')
                                            <tr>
                                                <td class="text-capitalize">{{ Carbon\Carbon::parse($approval['date_added'])->format('d/m/Y') }}</td>
                                                <td class="text-capitalize">{{ $approval['fields']['title'] }}</td>
                                                <td>
                                                    <a type="button" class="btn btn-sm btn-outline-primary text-capitalize rounded text-decoration-none" href="{{ route('timesheet.approval',$approval['id']) }}">View more</a> 
                                                </td>
                                            </tr>
                                        @elseif($approval['request_category'] == 'LEAVE')
                                            <tr>
                                                <td class="text-capitalize">{{ Carbon\Carbon::parse($approval['date_added'])->format('d/m/Y') }}</td>
                                                <td class="text-capitalize">{{ $approval['fields']['title'] }}</td>
                                                <td>
                                                    <a type="button" class="btn btn-sm btn-outline-primary text-capitalize rounded text-decoration-none" href="{{ route('leave.edit', $approval['id']) }}">View more</a> 
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center">
                            <h4 class="text-muted mb-4">No approvals</h4>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
        function enableLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    successCallback,
                    errorCallback,
                    { enableHighAccuracy: true }
                );
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function sendLocation(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;
            fetch('/clockIns', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf"]').content,
                },
                body: JSON.stringify({
                    latitude: latitude,
                    longitude: longitude,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Location updated successfully!');
                } else {
                    alert('Failed to update location.');
                }
            });
        }
    </script>
@endpush

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var currentTime = new Date();
        var hours = currentTime.getHours()+ 3;
        var minutes = currentTime.getMinutes();
        if (hours > 17 || (hours === 17 && minutes >= 0)) {
            document.getElementById("clockOutButton").style.display = "block";
        }
    });

</script>
@endpush