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

                        <div class="row">
                            <div class="col">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">Select Subject</span></div>
                                    <select class="form-control">
                                        <option value="">All</option>
                                        @foreach($subject as $row)
                                            <option value="{{$row->id}}">{{$row->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">Date</span></div>
                                    <input type="text" id="pic_date" class="form-control" placeholder="Date" />
                                    <div class="input-group-append"><button type="button" class=" btn btn-primary input-group-btn">Submit</button></div>
                                </div>
                            </div>
                        </div>

                        <hr />


                    </div>
                </div>
                <!--end::Card-->

            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">

        $('#pic_date').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

    </script>
@endsection
