<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize">
                Clock In & Out history
            </h3>
        </div>
    </div>
    <div class="row">
        @include('messages.flash')
        <div class="col-lg-12 d-flex justify-content-between">
            <div>
                <form wire:submit="fetchClockInsAndOutRange" class="row row-cols-lg-auto align-items-center">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <label for="start_date" class="form-label text-capitalize pt-2">Start date</label>
                        </div>
                        <div class="col-auto">
                            <input wire:model="start_date" type="date" class="form-control" value="{{ old('start_date') }}">
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <label for="end_date" class="form-label text-capitalize pt-2">End date</label>
                        </div>
                        <div class="col-auto">
                            <input wire:model="end_date" type="date" class="form-control" value="{{ old('end_date') }}">
                        </div>
                    </div>

                    <div class="row">
                        <button type="submit" class="btn btn-outline-secondary text-capitalize px-3">Get</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-lg-12">
            <div class="border bg-white rounded-3 shadow px-4 py-3">
                @if ($clockInsAndOuts)
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-capitalize" scope="col">Date</th>
                                <th class="text-capitalize" scope="col">Clock In</th>
                                <th class="text-capitalize" scope="col">Clock Out</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clockInsAndOuts as $clockInsAndOut)
                                <tr>
                                    <td>{{ $clockInsAndOut['day_recorded'] }}</td>
                                    <td>{{ $clockInsAndOut['clock_in_time'] }}</td>
                                    <td>
                                    {{ $clockInsAndOut['clock_out_time'] }} 
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center">
                        No clockin available
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
