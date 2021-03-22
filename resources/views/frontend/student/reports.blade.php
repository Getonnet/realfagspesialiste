@extends('layouts.general')

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
                    <div class="card-body">
                        <form id="reports_form" action="{{route('student.reports')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">{{__('Subject')}}</span></div>
                                        <select name="subject_id" class="form-control">
                                            <option value="">All</option>
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
                                            <option value="">All</option>
                                            @foreach($teacher as $row)
                                                <option value="{{$row->teacher_id}}">{{$row->teacher->name ?? ''}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">Date</span></div>
                                        <input type="text" id="pic_date" name="date_range" class="form-control" placeholder="Date" />
                                        <div class="input-group-append"><button type="submit" class=" btn btn-primary input-group-btn">Ok</button></div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <hr />

                        <p id="loader" class="text-center text-gray-500" style="display: none;">Loading...</p>
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

        $('#pic_date').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

    </script>
@endsection
