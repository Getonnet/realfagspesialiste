@extends('layouts.general')
@extends('frontend.student.box.report')
@section('title')
    {{__('My Reports')}}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">

                <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon-user text-danger"></i>
                        </span>
                            <h3 class="card-label">{{__('My Reports')}}</h3>
                        </div>
                    </div>
                    <div class="card-body bg-gray-100">
                        <form id="reports_form" action="{{route('student.reports')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">{{__('Subject')}}</span></div>
                                        <select name="subject_id" class="form-control">
                                            <option value="">{{__('All')}}</option>
                                            @foreach($subject as $row)
                                                <option value="{{$row->id}}">{{$row->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">{{__('Teacher')}}</span></div>
                                        <select name="teacher_id" class="form-control">
                                            <option value="">{{__('All')}}</option>
                                            @foreach($teacher as $row)
                                                <option value="{{$row->teacher_id}}">{{$row->teacher->name ?? ''}}</option>
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

        $('#pic_date').daterangepicker({
            locale: picker_loc_repo
        });

    </script>
@endsection
