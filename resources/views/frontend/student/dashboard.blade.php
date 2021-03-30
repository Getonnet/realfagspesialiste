@extends('layouts.general')

@section('title')
    {{__('My Dashboard')}}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">

                @php
                    $hour = $table->purchase()->where('status', 'Active')->sum('hours');
                    $spends = $table->time_log()->orderBy('id', 'DESC')->where('status', 'End')->get();
                    $spend_times = 0;
                    foreach ($spends as $spend){
                        $spend_times += $spend->spend_time();
                    }
                    $spend_times_hour = $spend_times/60;
                    $hour_to_min = $hour * 60;
                    $remain_min = $hour_to_min - $spend_times;
                    $spend_hour = number_format(($remain_min / 60), 2, '.', ' ');
                @endphp

                <div class="row mb-5">
                    <div class="col">
                        <div class="card bg-primary">
                            <div class="card-body">
                                <h3 class="text-center text-white"><b>{{__('Purchase')}}:</b> {{number_format(($hour), 2, '.', ' ')}}<sup>Hr</sup></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-danger">
                            <div class="card-body">
                                <h3 class="text-center text-white"><b>{{__('Spend')}}:</b> {{number_format(($spend_times_hour), 2, '.', ' ')}}<sup>Hr</sup></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-success">
                            <div class="card-body">
                                <h3 class="text-center text-white"><b>{{__('Remaining')}}:</b> {{number_format($spend_hour, 2, '.', ' ')}}<sup>Hr</sup></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon-calendar-with-a-clock-time-tools text-primary"></i>
                        </span>
                            <h3 class="card-label">{{__('My Calender')}}</h3>
                        </div>
                    </div>
                    <div class="card-body">

                        <div id="kt_calendar"></div>

                    </div>
                </div>
                <!--end::Card-->

            </div>
        </div>
    </div>

@endsection

@section('script')
    <!--begin::Page Vendors(used by this page)-->
    <script src="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
    <!--end::Page Vendors-->
    <script type="text/javascript">
        var KTCalendarBasic = function() {

            return {
                //main function to initiate the module
                init: function() {
                    var todayDate = moment().startOf('day');
                    var YM = todayDate.format('YYYY-MM');
                    var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
                    var TODAY = todayDate.format('YYYY-MM-DD');
                    var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

                    var calendarEl = document.getElementById('kt_calendar');
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list' ],
                        themeSystem: 'bootstrap',

                        isRTL: KTUtil.isRTL(),

                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay'
                        },

                        height: 800,
                        contentHeight: 780,
                        aspectRatio: 3,  // see: https://fullcalendar.io/docs/aspectRatio

                        nowIndicator: true,
                        now: TODAY + 'T09:25:00', // just for demo

                        views: {
                            dayGridMonth: { buttonText: 'month' },
                            timeGridWeek: { buttonText: 'week' },
                            timeGridDay: { buttonText: 'day' }
                        },

                        defaultView: 'dayGridMonth',
                        defaultDate: TODAY,

                        eventLimit: true, // allow "more" link when too many events
                        navLinks: true,
                        events: "{{route('student.events-all')}}",

                        eventRender: function(info) {
                            var element = $(info.el);

                            if (info.event.extendedProps && info.event.extendedProps.description) {
                                if (element.hasClass('fc-day-grid-event')) {
                                    element.data('content', info.event.extendedProps.description);
                                    element.data('placement', 'top');
                                    KTApp.initPopover(element);
                                } else if (element.hasClass('fc-time-grid-event')) {
                                    element.find('.fc-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                                } else if (element.find('.fc-list-item-title').lenght !== 0) {
                                    element.find('.fc-list-item-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                                }
                            }
                        }
                    });

                    calendar.render();
                }
            };
        }();

        jQuery(document).ready(function() {
            KTCalendarBasic.init();
        });
    </script>
@endsection
