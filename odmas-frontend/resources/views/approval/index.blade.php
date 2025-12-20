@extends('layouts.app')

@section('content')

@include('messages.flash')

<div class="container-fluid p-0">
    <div class="row mb-2">
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize">
                Available approvals
            </h3>
             
            <a class="btn btn-outline-secondary" href="{{ route('approvals.history') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M9 16.2l-4.2-4.2-1.4 1.4 5.6 5.6L21.8 6 20.4 4.6l-11 11z"/>
                </svg>

                Previous approvals
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="border bg-white rounded-3 shadow p-4">
                @if($approvals)
                    <div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-capitalize" scope="col">Date added</th>
                                    <th class="text-capitalize" scope="col">Request Title</th>
                                    <th class="text-capitalize" scope="col">Request Category</th>
                                    <th class="text-capitalize" scope="col">Added by</th>
                                    <th scope="col">Action</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($approvals as $approval)
                                    <tr>
                                        <td class="text-capitalize">{{ Carbon\Carbon::parse($approval['date_added'])->format('d/m/Y') }}</td>
                                        <td class="text-capitalize">{{ $approval['fields']['title'] }}</td>
                                        <td class="text-capitalize">{{ Str::lower($approval['request_category']) }}</td>
                                        <td class="text-capitalize">{{ $approval['added_by']['first_name'] }} {{ $approval['added_by']['last_name'] }}</td>
                                        <td>
                                            @if($approval['is_project_document'] && $approval['related_project_document']['document_domain']['document_domain_name'] == 'MEMO')
                                                <a type="button" class="btn btn-sm btn-outline-primary text-capitalize rounded" href="{{ route('memos.edit', $approval['id']) }}">View more</a> 
                                            @elseif($approval['is_project_document'] && $approval['related_project_document']['document_domain']['document_domain_name'] == 'PAYMENT')
                                                <a type="button" class="btn btn-sm btn-outline-primary text-capitalize rounded" href="{{ route('payments.edit', $approval['id']) }}">View more</a> 
                                            @elseif($approval['is_project_document'] && $approval['related_project_document']['document_domain']['document_domain_name'] == 'TRANSPORT')
                                                <a type="button" class="btn btn-sm btn-outline-primary text-capitalize rounded" href="{{ route('travels.edit', $approval['id']) }}">View more</a> 
                                            @elseif($approval['is_project_document'] && $approval['related_project_document']['document_domain']['document_domain_name'] == 'PROCUREMENT')
                                                <a type="button" class="btn btn-sm btn-outline-primary text-capitalize rounded" href="{{ route('procurements.edit', $approval['id']) }}">View more</a> 
                                            @elseif ($approval['request_category'] == 'LEAVE')
                                                <a type="button" class="btn btn-sm btn-outline-primary text-capitalize rounded" href="{{ route('leave.edit', $approval['id']) }}">View more</a> 
                                            @elseif ($approval['request_category'] == 'TIMESHEET')
                                                <a type="button" class="btn btn-sm btn-outline-primary text-capitalize rounded text-decoration-none" href="{{ route('timesheet.approval',$approval['id']) }}">View more</a> 
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center">
                        <h4 class="text-muted">No approvals</h4>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection