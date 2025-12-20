@extends('layouts.app')

@section('content')

@include('messages.flash')

<livewire:edit-leave :id="$id" />
    
@endsection