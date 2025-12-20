@extends('layouts.app')

@section('content')

@include('messages.flash')

<livewire:create-matrix :id="$id" />

@endsection

<!-- @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        const thruElement = document.querySelector('#teams');
        const thruChoices = new Choices(thruElement, {
            searchEnabled: true,
            searchChoices: true,
            removeItems: true,
            removeItemButton: true,
            duplicateItemsAllowed: false,
        });
    </script>
@endpush -->
