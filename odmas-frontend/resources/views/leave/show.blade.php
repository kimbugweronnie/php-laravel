@extends('layouts.app')

@section('content')

@include('messages.flash')

<livewire:show-leave :id="$id" />

@endsection