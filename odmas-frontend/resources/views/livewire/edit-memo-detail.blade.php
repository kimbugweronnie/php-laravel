@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/slim-select@latest/dist/slimselect.css" />
@endpush

<div class="container-fluid p-0">
    @include('messages.flash')
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize"> New memo </h3>
            <a class="btn btn-secondary px-3" href="{{ route('memos.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-left mb-1" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0v-2z"/>
                    <path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                </svg>
                Back
            </a>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="border rounded-3 bg-white shadow py-4 px-5">
                <form  wire:submit="memoRequest">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" wire:model="date" value="{{ $memoReq['date'] }}">
                            @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Date  is required.</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" wire:model="title" value="{{ $memoReq['title'] }}">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The title  is required.</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-2">
                        <label for="purpose" class="form-label">Purpose</label>
                        <input type="text" class="form-control @error('purpose') is-invalid @enderror" wire:model="purpose" value="{{ $memoReq['purpose'] }}">
                        @error('purpose')
                            <span class="invalid-feedback" role="alert">
                                <strong>The purpose is required.</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="background" class="form-label">Background</label>
                        <textarea wire:model="background" class="form-control @error('background') is-invalid @enderror" rows="3">{{ $memoReq['background'] }}</textarea>
                        @error('background')
                            <span class="invalid-feedback" role="alert">
                                <strong>The background  is required.</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="persons_through" class="form-label text-capitalize">Persons through</label>
                        <select multiple wire:model="persons_through" id = "person_to" aria-label="Default select" class="form-select @error('persons_through') is-invalid @enderror">
                            @foreach($projectUsers as $projectUser)
                                <option value="{{ $projectUser['id'] }}">{{ $projectUser['related_user']['first_name'] }} {{ $projectUser['related_user']['last_name'] }}</option>
                            @endforeach
                        </select>
                        @error('persons_through')
                            <span class="invalid-feedback" role="alert">
                                <strong>Persons through  is required.</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-12 mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-3">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://unpkg.com/slim-select@latest/dist/slimselect.min.js"></script>
    <script>
        new SlimSelect({
            select: '#multiple_persons_thru',
            settings: {
                placeholderText: 'Select persons',
                minSelected: 1,
            }
        })
        new SlimSelect({
            select: '#person_to',
            settings: {
                placeholderText: 'Select person',
                minSelected: 1,
            }
        })
    </script>
@endpush