@extends('layouts.error_app')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="alert" style="padding: 10px;background-color: #d0382d;color: white;margin-bottom: 15px;">
            <span class="closebtn" onclick="this.parentElement.style.display='none';" style="margin-left: 15px;color: white;font-weight: bold;float: right;font-size: 22px;line-height: 20px;cursor: pointer;transition: 0.3s;">&times;</span>
            <strong>Service Unavailable. Please try again later</strong>
        </div>
        <div class="d-flex justify-content-center">
            <span class="align-middle">
                <img src="{{ asset('img/full-logo.png') }}" width="400" alt="error page image">
            </span>
        </div>
        
    </div>
</div>
@endsection
