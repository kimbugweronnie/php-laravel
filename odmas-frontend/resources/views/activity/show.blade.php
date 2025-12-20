@extends('layouts.app')

@section('content')

@include('messages.flash')

<livewire:show-activity :activity="$activity" />

@endsection