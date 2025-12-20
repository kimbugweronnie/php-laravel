@extends('layouts.auth_app')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        @include('messages.flash')
        <div class="d-flex justify-content-center">
            <span class="align-middle">
                <img src="{{ asset('img/full-logo.png') }}" width="140" alt="landing page image">
            </span>
        </div>
        <div class="col-md-8 mt-4">
            <div class="card">
                <livewire:show-day />
                <div class="card-body py-5">
                    <form method="POST" action="{{ route('login.custom') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="text" class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>
                            <div class="col-md-6">
                                <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <livewire:show-hide-password />
                        <div class="row justify-content-center mb-0 mt-4">
                            <div class="col-md-8">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-sm btn-primary fw-bold px-4">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
