@extends('layouts.app') 

@section('content')

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize">
                Notifications
            </h3>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-lg-12">
            @include('messages.flash')
            <div class="border bg-white rounded-3 shadow px-4 py-3">
                @if ($notifications)
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-capitalize" scope="col">message</th>
                                <th class="text-capitalize" scope="col">description</th>
                                <th class="text-capitalize" scope="col">date created</th>
                                <th class="text-capitalize" scope="col">Read/Unread</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notifications as $notification)
                                <tr>
                                    <td><a class="text-decoration-none" href="#">{{ $notification['message'] }}</a></td>
                                    <td>{{ $notification['description'] }}</td>
                                    <td>{{ date('d/m/Y', strtotime($notification['date_created']))}}</td>
                                    <td>
                                        @if ($notification['is_read'])
                                            <span class="badge bg-primary rounded px-3">read</span>
                                        @else
                                            <span class="badge bg-secondary rounded px-1">un read</span>
                                        @endif
                                    </td>
                                   
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center">
                        No activities available
                    </div>
                @endif
            </div>
        </div>
    </div>



@endsection