@extends('layouts.general')

@section('title')
    {{__('My Dashboard')}}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
            @php
                $paid_hour = $table->payment()->sum('paid_hour');

                 $spends = $table->time_log_teacher()->where('status', 'End')->get();
                 $travel_times = 0;
                 $fixed_travel = 0;
                 $spend_times = 0;
                 foreach ($spends as $spend){
                     $spend_times += $spend->spend_time();
                     if($spend->spend_time() > 30){
                         $fixed_travel += 30;
                     }else{
                         $travel_times += $spend->spend_time();
                     }
                 }

                 $total_travel = $travel_times + $fixed_travel;
                 $travel_hour = number_format(($total_travel / 60), 2, '.', ' ');
                 $spend_hour = $spend_times / 60;
                 $unpaid_hour = number_format(($spend_hour - $paid_hour), 2, '.', ' ');
            @endphp

                <div class="row mb-5">
                    <div class="col">
                        <div class="card bg-primary">
                            <div class="card-body">
                                <h3 class="text-center text-white"><b>{{__('Travel')}}:</b> {{$travel_hour}}<sup>Hr</sup></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-danger">
                            <div class="card-body">
                                <h3 class="text-center text-white"><b>{{__('Unpaid')}}:</b> {{$unpaid_hour}}<sup>Hr</sup></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-success">
                            <div class="card-body">
                                <h3 class="text-center text-white"><b>{{__('Paid')}}:</b> {{number_format($paid_hour, 2, '.', ' ')}}<sup>Hr</sup></h3>
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
                        events: "{{route('teacher.events-all')}}",

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
