@extends('layouts.app')

@section('content')

@include('messages.flash')

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between">
            <h3 class="text-capitalize">
                Calendar view
            </h3>
            @if(Session::get('employee_details')['has_department_role'] == false  || Session::has('projects'))
                <h3 class="text-capitalize mb-2">
                    <a class="btn btn-outline-primary" href="{{ route('activities.create') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-plus" viewBox="0 0 18 18">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                        </svg>
                        Create activity
                    </a>
                </h3>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mt-2">
            <div class="card p-2">
                <div class="card-body">
                    <div id="calendar" style="width: 100%;height:100vh"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var calendarEl = document.getElementById('calendar');
        var events = [];
        var holidays = [];
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            initialView: 'dayGridMonth',
            timeZone: 'EAT',
            displayEventTime: true,
            events: '/events',
            editable: true,
            selectable: true,
            selectHelper: true,
            eventContent: function(info) {
                var eventTitle = info.event.title;
                var eventId = info.event.id;
                var eventDescription = info.event.description;
                var start = info.event.start;
                var end = info.event.end;
                var color = info.event.color;
                var eventElement = document.createElement('div');
                eventElement.innerHTML = '<a style= "text-decoration:none;background-color:'+color+'" href="/activities/' + eventId + '"><h4 class="fw-bold" >' + eventTitle + '</h4></a>';
                return {
                    domNodes: [eventElement]
                };
            }

           
        });
         console.log(events);
        calendar.render();
     </script>
@endpush


