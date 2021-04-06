@extends('layouts.master')

@section('title')
    {{__('General Reports')}}
@endsection

@section('content')
    <div class="row">
        <div class="col">

            <div class="card card-custom">
                <div class="card-header card-header-tabs-line">
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-bold nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1_4">
                                    <span class="nav-icon"><i class="flaticon-interface-9"></i></span>
                                    <span class="nav-text">{{__('Sells Reports')}}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2_4">
                                    <span class="nav-icon"><i class="flaticon-folder-1"></i></span>
                                    <span class="nav-text">{{__('Teacher Payment Reports')}}</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="kt_tab_pane_1_4" role="tabpanel" aria-labelledby="kt_tab_pane_1_4">
                            <div>
                                <form id="reports_form" action="{{route('admin.reports-sells')}}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text">{{__('Date')}}</span></div>
                                                <input type="text" id="pic_date" name="date_range" class="form-control" placeholder="Date" />
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text">{{__('Packages')}}</span></div>
                                                <select name="package_id" class="form-control">
                                                    <option value="">{{__('All')}}</option>
                                                    @foreach($package as $row)
                                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text">{{__('Student')}}</span></div>
                                                <select name="user_id" class="form-control">
                                                    <option value="">{{__('All')}}</option>
                                                    @foreach($student as $row)
                                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                                    @endforeach
                                                </select>
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
                        <div class="tab-pane fade" id="kt_tab_pane_2_4" role="tabpanel" aria-labelledby="kt_tab_pane_2_4">
                            <div>
                                <form id="reports_form_pay" action="{{route('admin.reports-pay')}}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text">{{__('Date')}}</span></div>
                                                <input type="text" id="pic_date_pay" name="date_range" class="form-control" placeholder="Date" />
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text">{{__('Teacher')}}</span></div>
                                                <select name="user_id" class="form-control">
                                                    <option value="">{{__('All')}}</option>
                                                    @foreach($teacher as $row)
                                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text">{{__('Payment Mode')}}</span></div>
                                                <select name="is_travel" class="form-control">
                                                    <option value="">{{__('All')}}</option>
                                                    <option value="0">{{__('Regular Payment')}}</option>
                                                    <option value="1">{{__('Travel Payment')}}</option>
                                                </select>
                                                <div class="input-group-append"><button type="submit" class=" btn btn-primary input-group-btn">Ok</button></div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <hr />

                                <p id="loader_pay" class="text-center text-gray-500" style="display: none;">{{__('Loading')}}...</p>
                                <div id="show_reports_pay">

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
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

        $('#reports_form_pay').on('submit', function (e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                beforeSend: function(){
                    $("#loader_pay").show();
                    $("#show_reports_pay").html('');
                },
                complete: function(){
                    $("#loader_pay").hide();
                },
                success: function(result)
                {
                    $('#show_reports_pay').html(result);
                }
            });
        });


        $('#pic_date').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        $('#pic_date_pay').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });
    </script>
@endsection
