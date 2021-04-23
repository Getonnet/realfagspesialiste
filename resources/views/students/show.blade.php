@extends('layouts.master')
@extends('students.box.students')
@section('title')
    {{__('Student Info')}}
@endsection


@section('content')

    <div class="row">
        <div class="col">
            <x-card title="{{__('Student Info')}}">
                <x-slot name="button">
                    <a href="{{route('student.index')}}" class="btn btn-info ml-1" ><i class="flaticon2-left-arrow"></i> {{__('Back to student list')}}</a>
                </x-slot>

                <div class="row">
                    <div class="col-lg-3 overflow-hidden">
                        <div class="card">
                            <img src="{{asset($table->profile_photo_path ?? 'assets/media/users/blank.png')}}" class="card-img-top" alt="{{$table->name}}">
                            <div class="card-body">
                                <h5 class="card-title text-center text-primary">{{$table->name}}</h5>
                                <table class="table">
                                    <tr>
                                        <th>{{__('Email')}}</th>
                                        <td>{{$table->email}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{__('Contact')}}</th>
                                        <td>{{$table->student->contact ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{__('City')}}</th>
                                        <td>{{$table->student->city ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{__('Zip')}}</th>
                                        <td>{{$table->student->zip ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{__('Address')}}</th>
                                        <td>{{$table->student->address ?? ''}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

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

                    <div class="col-lg-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="row font-size-h3">
                                    <div class="col text-right text-primary"><b>{{__('Purchase')}}:</b></div>
                                    <div class="col  border-right text-primary">{{number_format(($hour), 2, '.', ' ')}} <sup>{{__('Hr')}}</sup></div>

                                    <div class="col text-right  text-danger"><b>{{__('Spend')}}:</b></div>
                                    <div class="col  border-right  text-danger">{{number_format(($spend_times_hour), 2, '.', ' ')}} <sup>{{__('Hr')}}</sup></div>

                                    <div class="col text-right  text-info"><b>{{__('Remaining')}}:</b></div>
                                    <div class="col  text-info">{{$spend_hour}} <sup>{{__('Hr')}}</sup></div>
                                </div>

                            </div>
                        </div>



                        <div class="mt-5">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{__('Time Spend Reports')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{__('Purchase Reports')}}</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    @php
                                        $events = $table->time_log()->orderBy('id', 'DESC')->get();
                                    @endphp
                                    <table class="table table-separate table-head-custom table-sm table-striped" id="kt_datatable">
                                        <thead>
                                        <tr>
                                            <th>{{__('Date')}}</th>
                                            <th>{{__('Teacher')}}</th>
                                            <th>{{__('Email')}}</th>
                                            <th>{{__('Subject')}}</th>
                                            <th>{{__('Spend')}}</th>
                                            <th class="text-right">{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($events as $row)
                                            <tr>
                                                <td data-sort="{{strtotime($row->created_at)}}">{{date('d.M.Y', strtotime($row->created_at))}}</td>
                                                <td>{{$row->teacher_name}}</td>
                                                <td>{{$row->teacher_email}}</td>
                                                <td>{{$row->subject_name}}</td>
                                                <td data-sort="{{$row->spend_time('H')}}">{{$row->spend_time('H')}} {{__('Hr')}}</td>
                                                <td class="text-right">

                                                    <x-actions>
                                                        <li class="navi-item">
                                                            <a href="javascript:;" class="navi-link" data-toggle="modal" data-target="#viewModal" onclick="viewFn(this)"
                                                               data-href="{{route('student.edit', ['student' => $row->id])}}">
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
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    @php
                                        $purchase = $table->purchase()->orderBy('id', 'DESC')->get();
                                    @endphp
                                    <table class="table table-separate table-head-custom table-sm table-striped" id="kt_datatable2">
                                        <thead>
                                        <tr>
                                            <th>{{__('Date')}}</th>
                                            <th>{{__('Package')}}</th>
                                            <th>{{__('Hour')}}</th>
                                            <th>{{__('Coupon')}}</th>
                                            <th>{{__('Status')}}</th>
                                            <th>{{__('Amount')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($purchase as $row)
                                            <tr>
                                                <td data-sort="{{strtotime($row->created_at)}}">{{date('d.M.Y', strtotime($row->created_at))}}</td>
                                                <td>{{$row->name}}</td>
                                                <td data-sort="{{$row->hours}}">{{$row->hours}} {{__('Hr')}}</td>
                                                <td>{{$row->coupon}}</td>
                                                <td>{{__($row->status)}}</td>
                                                <td data-sort="{{$row->price}}">{{$row->price}} kr</td>
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

        $('#kt_datatable').DataTable({
            order: [],//Disable default sorting
            language: {
                url: "{{asset('no.json')}}"
            },
            columnDefs: [
                { orderable: false, "targets": [5] }//For Column Order
            ]
        });

        $('#kt_datatable2').DataTable({
            order: [],//Disable default sorting
            language: {
                url: "{{asset('no.json')}}"
            }
        });
    </script>
@endsection
