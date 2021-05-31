@extends('layouts.general')
@extends('frontend.teacher.box.home')

@section('title')
    {{__('My Dashboard')}}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
            @php
                 $paid_hour = $table->payment()->where('is_travel', 0)->sum('paid_hour');
                 $paid_travel_hour = $table->payment()->where('is_travel', 1)->sum('paid_hour');

                 $spends = $table->time_log_teacher()->where('status', 'End')->get();
                 $total_travel = 0;
                 $spend_times = 0;
                 foreach ($spends as $spend){
                     $spend_times += $spend->spend_time();
                     $total_travel += $spend->hour_spend;
                 }

                 $planeds = $table->time_log_teacher()->where('status', 'Pending')->get();

                 $planed_times = 0;
                 foreach ($planeds as $planed){
                     $planed_times += $planed->spend_time('H');
                 }

                 $travel_hour = number_format(($total_travel / 60), 2, '.', ' ');
                 $spend_hour = $spend_times / 60;
                 $unpaid_hour = number_format(($spend_hour - $paid_hour), 2, '.', ' ');
                 $unpaid_travel = number_format(($travel_hour - $paid_travel_hour), 2, '.', ' ');
            @endphp

                <div class="row mb-5">
                    <div class="col">
                        <div class="card bg-primary">
                            <div class="card-body">
                                <h3 class="text-center text-white"><b>{{__('Travel')}}:</b> {{$travel_hour}}<sup>{{__('Hr')}}</sup></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-success">
                            <div class="card-body">
                                <h3 class="text-center text-white"><b>{{__('Unpaid Travel')}}:</b> {{$unpaid_travel}}<sup>{{__('Hr')}}</sup></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-info">
                            <div class="card-body">
                                <h3 class="text-center text-white"><b>Undervisning:</b> {{number_format($spend_hour, 2, '.', ' ')}}<sup>{{__('Hr')}}</sup></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-danger">
                            <div class="card-body">
                                <h3 class="text-center text-white"><b>{{__('Unpaid Hours')}}:</b> {{$unpaid_hour}}<sup>{{__('Hr')}}</sup></h3>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $paid = $table->payment()->sum('amount');
                @endphp
                <div class="row">
                   <div class="col-md-3">
                       <ul class="list-group">
                           <li class="list-group-item bg-primary text-white pt-lg-5 pb-lg-5">
                               <h1 class="text-center">{{__('Total Planed hours')}}</h1>
                               <h2 class="text-center">{{$planed_times}}<sup>{{__('Hr')}}</sup></h2>
                           </li>
                           <li class="list-group-item bg-info text-white pt-lg-5 pb-lg-5">
                               <h1 class="text-center">{{__('Total hours taught')}}</h1>
                               <h2 class="text-center">{{number_format(($spend_hour + $travel_hour), 2, '.', ' ')}}<sup>{{__('Hr')}}</sup></h2>
                           </li>
                           <li class="list-group-item bg-success text-white pt-lg-5 pb-lg-5">
                               <h1 class="text-center">{{__('Total salary paid')}}</h1>
                               <h2 class="text-center">{{$paid}}<sup>kr</sup></h2>
                           </li>
                       </ul>
                   </div>
                    <div class="col-md-9">
                        <!--begin::Card-->
                        <div class="card card-custom gutter-b">
                            <div class="card-body">
                                <div id="chart_3"></div>
                            </div>
                        </div>
                        <!--end::Card-->
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
                        <div class="card-toolbar">
                            <button class="btn btn-primary ml-1" data-toggle="modal" data-target="#addModal"><i class="flaticon2-add-1"></i> Legg til ny hendelse</button>
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

        // Shared Colors Definition
        const primary = '#6993FF';
        const success = '#1BC5BD';
        const info = '#8950FC';
        const warning = '#FFA800';
        const danger = '#F64E60';

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
                        firstDay: 1,
                        eventTimeFormat: { // like '14:30:00'
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: false
                        },
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

                        eventClick: function(info) {
                            info.jsEvent.preventDefault();

                            $('#del_events').attr('data-href', info.event.del);
                            $('#viewModal .titles').html(info.event.extendedProps.names);
                            $('#viewModal .student').html(info.event.title);
                            $('#viewModal .event_date').html(info.event.extendedProps.ev);
                            $('#viewModal .st').html(info.event.extendedProps.st);
                            $('#viewModal .end').html(info.event.extendedProps.en);
                            $('#viewModal .spend').html(info.event.extendedProps.spend);

                            $('#del_events').attr('data-href', info.event.extendedProps.del);

                            $('#viewModal').modal('show');

                            $('#ediModal form').attr('action', info.event.extendedProps.edit);
                            $('#ediModal [name=student_id]').val(info.event.extendedProps.identity);
                            $('#ediModal [name=name]').val(info.event.extendedProps.names);

                            $('#ediModal [name=event_start]').daterangepicker({
                                timePicker: true,
                                timePicker24Hour: true,
                                singleDatePicker: true,
                                startDate: info.event.extendedProps.calev,
                                locale: picker_loc
                            });
                            //$('#ediModal [name=event_start]').val(event_start);

                            $('#ediModal [name=start_end_time]').daterangepicker({
                                timePicker: true,
                                timePicker24Hour: true,
                                //singleDatePicker: true,
                                startDate: info.event.extendedProps.calst,
                                endDate: info.event.extendedProps.calen,
                                locale: picker_loc
                            });

                        }
                    });

                    calendar.render();
                }
            };
        }();

        //function viewFn(urls) {
            /*$.get(urls, function( result ) {
                $( "#viewModal .modal-body" ).html( result );
            });*/
        //}

        $('#addModal [name=event_start]').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            singleDatePicker: true,
            minDate:new Date(),
            locale: picker_loc
        });

        $('#addModal [name=start_end_time]').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            //singleDatePicker: true,
            locale: picker_loc
        });

        var KTApexChartsDemo = function () {
            var thoughts = function () {
                const apexChart = "#chart_3";
                var options = {
                    series: [{
                        name: "{{__('Hours')}}",
                        data: {!! $data !!}
                    }],
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: {!! $categories !!},
                    },
                    yaxis: {
                        title: {
                            text: "{{__('Hours')}}"
                        },
                        labels: {
                            formatter: function(val) {
                                return Math.floor(val)
                            }
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return val + " T"
                            }
                        }
                    },
                    colors: [success, primary, warning]
                };

                var chart = new ApexCharts(document.querySelector(apexChart), options);
                chart.render();
            }
            return {
                // public functions
                init: function () {
                    thoughts();
                }
            };
        }();

        jQuery(document).ready(function() {
            KTCalendarBasic.init();
            KTApexChartsDemo.init();
        });
    </script>
@endsection
