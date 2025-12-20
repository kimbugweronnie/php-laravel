@extends('layouts.app')

@section('content')

<livewire:timesheet-approval :id="$id" :employee_id="$employee_id" :month="$month" :year="$year"/>

@endsection