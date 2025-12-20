@extends('layouts.app')

@section('content')

@include('messages.flash')

<livewire:create-payment />

@endsection