@extends('layouts.app')

@section('content')

@include('messages.flash')

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <div>
                <a href="{{ url()->previous() }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-left mb-1" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0v-2z"/>
                        <path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                    </svg>
                    Back 
                </a>
            </div>
            <div>
                <a type="button" data-bs-toggle="modal" data-bs-target="#deleteDocument" class="btn btn-primary">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash mb-1" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M10.354 3.354a.5.5 0 0 1 .708 0l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 1 1-.708-.708L11.793 5.5 10.354 4.146a.5.5 0 0 1 0-.708zM4.5 1a.5.5 0 0 1 .5.5V2h7V1.5a.5.5 0 0 1 1 0V2a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 1 2V1.5a.5.5 0 0 1 .5-.5zM13 5H3v9a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V5z"/>
                    </svg>
                    Delete
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mt-3">
            <div class="border rounded-3 bg-white shadow p-4">
                <div class="mb-2">
                    <span class="fw-bold">Name Of Document:</span><span class="text-muted"> {{ $document['file_name'] }}</span>
                </div>
                <div class="mb-2">
                    <span class="fw-bold">Description:</span><span class="text-muted"> {{ $document['description'] }} </span>
                </div>
                <div class="mb-2">
                    <span class="fw-bold">File Link:</span><br /><span class="text-muted"><a class="text-decoration-none" href="{{ $url.$document["file_path"] }}" target="_blank" download>{{pathinfo($document['file_path'])['basename']}}</a></span>
                </div>
                <div class="mb-2">
                    <span class="fw-bold">Added On :</span><br /><span class="text-muted">{{date('m/d/Y', strtotime($document['date_added']))}}</span>
                </div>
               
            </div>
        </div>
    </div>
     <form action="{{ route('documents.destroy', $document['id']) }}" class="hidden" id="delete-document" method="POST">
        @method('delete')
        @csrf
    </form>

    <div class="modal fade" id="deleteDocument" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{$document['file_name']}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger text-white" onclick="event.preventDefault(); document.getElementById('delete-document').submit();">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection