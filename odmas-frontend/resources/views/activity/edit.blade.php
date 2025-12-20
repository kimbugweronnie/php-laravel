@extends('layouts.app')

@section('content')

@include('messages.flash')

<livewire:edit-activity :id="$id" />

@endsection