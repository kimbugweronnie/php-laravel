<div class="container-fluid p-0">
    <div class="row">
        @include('messages.flash')
        <div class="col-lg-12 d-flex justify-content-between mb-3">
            <div>
                <div class="row">
                    <div class="d-flex justify-content-between">
                        <label class="fw-bold pt-1 me-3" for="category"> Documents</label>
                        <select wire:model="category" wire:change="reqByCategory" class="form-select">
                            <option selected>Choose Category</option>
                            <option value="department_document">Departments</option>
                            <option value="project_general_document">Projects</option>
                        </select>
                    </div>
                </div>
            </div>
            <h3 class="text-capitalize"> 
                <a class="btn btn-outline-primary" href="{{ route('documents.create') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-plus" viewBox="0 0 18 18">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                    </svg>
                    Create Document
                </a>
            </h3>
        </div>
    </div> 
    <div class="row">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a wire:click="handleActiveDoc" class="nav-link text-capitalize {{ $active_doc ? 'active' : '' }}" id="nav-active-tab" data-bs-toggle="tab" data-bs-target="#nav-active" href="#active" type="button" role="tab" aria-controls="nav-active" aria-selected="true">Active</a>
                <a wire:click="handleDeletedDoc" class="nav-link text-capitalize {{ $deleted_doc ? 'active' : '' }}" id="nav-deleted-tab" data-bs-toggle="tab" data-bs-target="#nav-deleted" href="#deleted" type="button" role="tab" aria-controls="nav-deleted" aria-selected="false">Archived</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade {{ $active_doc ? 'show active' : '' }}" id="nav-active" role="tabpanel" aria-labelledby="nav-active-tab" tabindex="0">
                <div class="row">
                    <div class="col-lg-12 mb-5">
                        @if (count($active_docs) > 0)
                            <h4 class="text-capitalize fw-bold my-3">List of Active Documents</h4>
                        @endif
                        <div class="border bg-white rounded-3 shadow px-4 py-3 mt-4">
                            @if (count($active_docs) > 0)
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Date</th>
                                            <th scope="col">Title </th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Document Link</th>
                                            <th scope="col">Added By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($active_docs as $active_doc)
                                            <tr>
                                                <td>{{ date('m/d/Y', strtotime($active_doc['date_added'])) }}</td>
                                                <td><a class="text-decoration-none" href="{{ route('documents.show', $active_doc['id']) }}">{{ \Str::limit($active_doc['file_name'], 20) }}</a></td>
                                                <td>{{ \Str::limit($active_doc['description'], 25) }}</td>
                                                <td><a href="{{ $url.$active_doc["file_path"] }}" target="_blank" download>{{ \Str::limit(pathinfo($active_doc['file_path'])['basename'], 25) }}</a></td>
                                                <td> {{ $active_doc['added_by']['first_name']  }} {{ $active_doc['added_by']['last_name']  }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center text-capitalize">
                                    No data available
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade {{ $deleted_doc ? 'show active' : '' }}" id="nav-deleted" role="tabpanel" aria-labelledby="nav-deleted-tab" tabindex="0">
                <div class="row">
                    <div class="col-lg-12 mb-5">
                        @if (count($deleted_docs) > 0)
                            <h4 class="text-capitalize fw-bold my-3">List of Deleted Documents</h4>
                        @endif
                       <div class="border bg-white rounded-3 shadow px-4 py-3 mt-4">
                            @if (count($deleted_docs) > 0)
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
                                        @foreach($deleted_docs as $deleted_doc)
                                            <tr>
                                                <td>{{date('m/d/Y', strtotime($deleted_doc['date_added']))}}</td>
                                                <td><a class="text-decoration-none" href="{{ route('documents.show', $deleted_doc['id']) }}">{{$deleted_doc['file_name']}}</a></td>
                                                <td>{{$deleted_doc['description']}}</td>
                                                <td><a href="{{ $url.$deleted_doc["file_path"] }}" target="_blank" download>{{pathinfo($deleted_doc['file_path'])['basename']}}</a></td>
                                                <td> {{ $deleted_doc['added_by']['first_name']  }} {{ $deleted_doc['added_by']['last_name']  }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center text-capitalize">
                                    No data available
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