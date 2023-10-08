@extends('layouts.admin')
@section('content')
    <h3 class="page-title">{{ trans('global.systemCalendar') }}</h3>
    <div class="card">
        <div class="card-header">
            {{ trans('global.systemCalendar') }}
        </div>

        <div class="card-body">
            <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.5/dist/fullcalendar.min.css" rel="stylesheet">

            <div id='calendar'></div>


        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/moment@2/min/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.5/dist/fullcalendar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.5/dist/locale-all.min.js"></script>

    <script>
        $(document).ready(function() {
            // page is now ready, initialize the calendar...
            events = {!! json_encode($events) !!};

            console.log(events)
            $('#calendar').fullCalendar({
                // put your options and callbacks here
                views: {
                    agendaCustom: {
                        type: 'agenda',
                        duration: {
                            days: 7
                        },
                        buttonText: '7 day'
                    }
                },
                locale: 'pl',
                events: events,
                defaultView: 'agendaCustom',
                minTime: '07:00:00',
                maxTime: '21:00:00',
            })
        })
    </script>
@stop
