@extends('layouts.master')
@extends('teachers.box.show')
@section('title')
    {{__('Teacher Info')}}
@endsection


@section('content')

    <div class="row">
        <div class="col">
            <x-card title="{{__('Teacher Info')}}">
                <x-slot name="button">
                    <a href="{{route('teacher.index')}}" class="btn btn-info ml-1" ><i class="flaticon2-left-arrow"></i> {{__('Back to student list')}}</a>
                </x-slot>

                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <img src="{{asset($table->profile_photo_path ?? 'assets/media/users/blank.png')}}" class="card-img-top" alt="{{$table->name}}">
                            <div class="card-body">
                                <h5 class="card-title text-center text-primary">{{$table->name}}</h5>
                                <table class="table">
                                    <tr>
                                        <th>{{__('Birthday')}}</th>
                                        <td>{{isset($table->teacher->dob) ? date('d-M-Y', strtotime($table->teacher->dob)) : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{__('Gender')}}</th>
                                        <td>{{$table->teacher->gender ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{__('Contact')}}</th>
                                        <td>{{$table->teacher->contact ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{__('Email')}}</th>
                                        <td>{{$table->email}}</td>
                                    </tr>

                                    <tr>
                                        <th>{{__('City')}}</th>
                                        <td>{{$table->teacher->city ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{__('Zip')}}</th>
                                        <td>{{$table->teacher->zip ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{__('Address')}}</th>
                                        <td>{{$table->teacher->address ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{__('Working Hour')}}</th>
                                        <td>{{$table->teacher->working_hour ?? ''}}/Week</td>
                                    </tr>
                                    <tr>
                                        <th>{{__('VGS Grade')}}</th>
                                        <td>{{$table->teacher->grade ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{__('CV')}}</th>
                                        <td><a href="{{asset($table->teacher->cv ?? '')}}">{{__('Download')}}</a></td>
                                    </tr>
                                    <tr>
                                        <th>{{__('Diploma Certificate')}}</th>
                                        <td><a href="{{asset($table->teacher->diploma ?? '')}}">{{__('Download')}}</a></td>
                                    </tr>
                                    <tr>
                                        <th>{{__('Descriptions')}}</th>
                                        <td>{{$table->teacher->description ?? ''}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

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
                            $travel_hour = number_format(($total_travel / 60), 2, '.', ' ');
                            $unpaid_travel_hour = number_format(($travel_hour - $paid_travel_hour), 2, '.', ' ');
                            $spend_hour = $spend_times / 60;
                            $unpaid_hour = number_format(($spend_hour - $paid_hour), 2, '.', ' ');
                    @endphp

                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="row font-size-h3">
                                    <div class="col text-right text-primary"><b>{{__('Unpaid Travel')}}:</b></div>
                                    <div class="col  border-right text-primary">{{$unpaid_travel_hour}} <sup>{{__('Hr')}}</sup></div>

                                    <div class="col text-right  text-danger"><b>{{__('Unpaid')}}:</b></div>
                                    <div class="col  border-right  text-danger">{{$unpaid_hour}} <sup>{{__('Hr')}}</sup></div>

                                    <div class="col text-right  text-info"><b>{{__('Paid')}}:</b></div>
                                    <div class="col  text-info">{{number_format(($paid_hour), 2, '.', ' ')}} <sup>{{__('Hr')}}</sup></div>
                                </div>


                            </div>
                        </div>



                        <div class="mt-5">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{__('Payment Reports')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{__('Time Spend Reports')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#assign" role="tab" aria-controls="profile" aria-selected="false">{{__('Student Assign')}}</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    @php
                                        $payments = $table->payment()->orderBy('id', 'DESC')->get();
                                    @endphp
                                    <table class="table table-separate table-head-custom table-sm table-striped" id="kt_datatable2">
                                        <thead>
                                        <tr>
                                            <th>{{__('Date')}}</th>
                                            <th>{{__('Payment Mode')}}</th>
                                            <th>{{__('Hour')}}</th>
                                            <th>{{__('Amount')}}</th>
                                            <th>{{__('Description')}}</th>
                                            <th class="text-right">{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($payments as $row)
                                            <tr>
                                                <td>{{date('d/m/Y', strtotime($row->created_at))}}</td>
                                                <td>{{$row->is_travel == 0 ? 'Regular': 'Travel'}}</td>
                                                <td>{{number_format(($row->paid_hour), 2, '.', ' ')}}</td>
                                                <td>{{number_format(($row->amount), 2, '.', ' ')}}</td>
                                                <td title="{{$row->description}}">{{Str::limit($row->description, 20)}}</td>
                                                <td class="text-right">
                                                    <x-actions>

                                                        <li class="navi-item">
                                                            <a href="javascript:;" class="navi-link" data-toggle="modal" data-target="#ediPayModal" onclick="ediFn(this)"
                                                               data-href="{{route('pay-update.teacher', ['id' => $row->id])}}"
                                                               data-hour="{{$row->paid_hour}}"
                                                               data-amount="{{$row->amount}}"
                                                               data-travel="{{$row->is_travel}}"
                                                               data-description="{{$row->description}}">
                                                                <span class="navi-icon"><i class="la la-pencil-square-o text-success"></i></span>
                                                                <span class="navi-text">{{__('Edit')}}</span>
                                                            </a>
                                                        </li>

                                                        <li class="navi-item">
                                                            <a href="javascript:;" data-href="{{route('pay-del.teacher', ['id' => $row->id])}}" class="navi-link" onclick="delFn(this)">
                                                                <span class="navi-icon"><i class="la la-trash-o text-danger"></i></span>
                                                                <span class="navi-text">{{__('Delete')}}</span>
                                                            </a>
                                                        </li>

                                                    </x-actions>
                                                </td>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    @php
                                        $events = $table->time_log_teacher()->orderBy('id', 'DESC')->get();
                                    @endphp
                                    <table class="table table-separate table-head-custom table-sm table-striped" id="kt_datatable">
                                        <thead>
                                        <tr>
                                            <th>{{__('Date')}}</th>
                                            <th>{{__('Student')}}</th>
                                            <th>{{__('Email')}}</th>
                                            <th>{{__('Subject')}}</th>
                                            <th>{{__('Spend')}}</th>
                                            <th>{{__('Status')}}</th>
                                            <th class="text-right">{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($events as $row)
                                            <tr>
                                                <td>{{date('d/m/Y', strtotime($row->created_at))}}</td>
                                                <td>{{$row->student_name}}</td>
                                                <td>{{$row->student_email}}</td>
                                                <td>{{$row->subject_name}}</td>
                                                <td>{{$row->spend_time('H')}}</td>
                                                <td>{{__($row->status)}}</td>
                                                <td class="text-right">

                                                    <x-actions>
                                                        <li class="navi-item">
                                                            <a href="javascript:;" class="navi-link" data-toggle="modal" data-target="#viewModal" onclick="viewFn(this)"
                                                               data-href="{{route('teacher.edit', ['teacher' => $row->id])}}">
                                                                <span class="navi-icon"><i class="fab la-phabricator text-info"></i></span>
                                                                <span class="navi-text">{{__('View')}}</span>
                                                            </a>
                                                        </li>
                                                    </x-actions>

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane fade" id="assign" role="tabpanel" aria-labelledby="profile-tab">
                                    @php
                                        $assign = $table->student_assign()->get();

                                    //dd($assign)
                                    @endphp
                                    <table class="table table-separate table-head-custom table-sm table-striped" id="kt_datatableAs">
                                        <thead>
                                        <tr>
                                            <th>{{__('Photo')}}</th>
                                            <th>{{__('Student')}}</th>
                                            <th>{{__('Email')}}</th>
                                            <th>{{__('Contact')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($assign as $row)
                                            <tr>
                                                <td><img src="{{asset($row->students->profile_photo_path ?? 'assets/media/users/blank.png')}}" style="height: 30px;" class="img-fluid img-thumbnail" /></td>
                                                <td>{{$row->students->name ?? ''}}</td>
                                                <td>{{$row->students->email ?? ''}}</td>
                                                <td>{{$row->students->student->contact ?? ''}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>

                    </div>

                </div>

            </x-card>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">

        function viewFn(e) {
            var link = e.getAttribute('data-href');
            $.get( link, function( result ) {
                $( "#viewModal .modal-body" ).html( result );
            });
        }

        function ediFn(e){
            var link = e.getAttribute('data-href');
            var paid_hour = e.getAttribute('data-hour');
            var amount = e.getAttribute('data-amount');
            var description = e.getAttribute('data-description');
            var is_travel = e.getAttribute('data-travel');
            //var hour = "{{$unpaid_hour}}";


            $('#ediPayModal form').attr('action', link);
            $('#ediPayModal [name=paid_hour]').val(paid_hour);
            $('#ediPayModal [name=amount]').val(amount);
            $('#ediPayModal [name=is_travel]').val(is_travel);
            $('#ediPayModal [name=description]').val(description);
            //if(paid_hour > hour)
            //$('#ediPayModal [name=paid_hour]').attr('max', hour);
        }

        $('#kt_datatable').DataTable({
            columnDefs: [
                { orderable: false, "targets": [5] }//For Column Order
            ]
        });

        $('#kt_datatableAs').DataTable();

        $('#kt_datatable2').DataTable({
            columnDefs: [
                { orderable: false, "targets": [4] }//For Column Order
            ]
        });
    </script>
@endsection
