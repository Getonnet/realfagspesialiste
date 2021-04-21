@extends('layouts.general')
@extends('frontend.teacher.box.report')

@section('title')
    {{__('My Reports')}}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">

                <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <span class="card-icon">
                                <i class="flaticon-user text-danger"></i>
                            </span>
                            <h3 class="card-label">{{__('My Reports')}}</h3>
                        </div>
                        <div class="card-toolbar">
                            <button class="btn btn-primary ml-1" data-toggle="modal" data-target="#addModal"><i class="flaticon2-add-1"></i> {{__('Add new reports')}}</button>
                        </div>
                    </div>
                    <div class="card-body bg-gray-100">
                        <form id="reports_form" action="{{route('teacher.reports-show')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">{{__('Subject')}}</span></div>
                                        <select name="subject_id" class="form-control">
                                            <option value="">{{__('All')}}</option>
                                            @foreach($subjects as $row)
                                                <option value="{{$row->subject_id}}">{{$row->subject->name ?? ''}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">{{__('Student')}}</span></div>
                                        <select name="student_id" class="form-control">
                                            <option value="">{{__('All')}}</option>
                                            @foreach($students as $row)
                                                <option value="{{$row->student_id}}">{{$row->student->name ?? ''}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">{{__('Date')}}</span></div>
                                        <input type="text" id="pic_date" name="date_range" class="form-control" placeholder="Date" />
                                        <div class="input-group-append"><button type="submit" class=" btn btn-primary input-group-btn">Ok</button></div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <hr />

                        <p id="loader" class="text-center text-gray-500" style="display: none;">{{__('Loading')}}...</p>
                        <div id="show_reports">

                        </div>

                    </div>
                </div>
                <!--end::Card-->

            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">

        $(function () {
            var form = $('#reports_form');
            var url = form.attr('action');
            var token = $('#reports_form [name=_token]').val();
            var date_range = "{{date('01/m/Y')}} - {{date('t/m/Y')}}";

            $.ajax({
                type: "POST",
                url: url,
                data: {"_token": token, "date_range":date_range}, // serializes the form's elements.
                beforeSend: function(){
                    $("#loader").show();
                    $("#show_reports").html('');
                },
                complete: function(){
                    $("#loader").hide();
                },
                success: function(result)
                {
                    $('#show_reports').html(result);

                }
            });
        });

        $('#reports_form').on('submit', function (e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                beforeSend: function(){
                    $("#loader").show();
                    $("#show_reports").html('');
                },
                complete: function(){
                    $("#loader").hide();
                },
                success: function(result)
                {
                    $('#show_reports').html(result);

                }
            });
        });

        function viewFn(e) {
            var link = e.getAttribute('data-href');
            $.get(link, function( result ) {
                $( "#viewModal .modal-body" ).html( result );
            });
        }

        $('#addModal [name=event_start]').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            singleDatePicker: true,
            locale: picker_loc
        });

        $('#addModal [name=start_end_time]').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            //singleDatePicker: true,
            locale: picker_loc
        });




        $('#pic_date').daterangepicker({
            locale: picker_loc
        });

    </script>
@endsection
