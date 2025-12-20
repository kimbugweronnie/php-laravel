@extends('layouts.app')

@section('content')

@include('messages.flash')

<livewire:show-memo :id="$id" />

@endsection