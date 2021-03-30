@extends('layouts.master')
@extends('teachers.box.teachers')
@section('title')
    {{__('Teacher List')}}
@endsection


@section('content')

    <div class="row">
        <div class="col">
            <x-card title="{{__('Teacher List')}}">
                <x-slot name="button">
                    <button class="btn btn-primary ml-1" data-toggle="modal" data-target="#addModal"><i class="flaticon2-add-1"></i> {{__('Add new record')}}</button>
                </x-slot>

                <table class="table table-separate table-head-custom table-sm table-striped" id="kt_datatable">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Unpaid Travel</th>
                            <th>Unpaid Hour</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($table as $row)
                        @php
                            $paid_hour = $row->payment()->where('is_travel', 0)->sum('paid_hour');
                            $paid_travel_hour = $row->payment()->where('is_travel', 1)->sum('paid_hour');

                            $spends = $row->time_log_teacher()->where('status', 'End')->get();
                            $total_travel = 0;
                            $spend_times = 0;
                            foreach ($spends as $spend){
                                $spend_times += $spend->spend_time();
                                $total_travel += $spend->hour_spend;
                            }

                            $travel_hour = number_format(($total_travel / 60), 2, '.', ' ');
                            $spend_hour = $spend_times / 60;
                            $unpaid_hour = number_format(($spend_hour - $paid_hour), 2, '.', ' ');
                            $unpaid_travel = number_format(($travel_hour - $paid_travel_hour), 2, '.', ' ');
                            $total_unpaid_hours = $travel_hour + $unpaid_hour;

                        @endphp
                        <tr>
                            <td><img src="{{asset($row->profile_photo_path ?? 'assets/media/users/blank.png')}}" style="height: 30px;" class="img-fluid img-thumbnail" /></td>
                            <td>{{$row->name}}</td>
                            <td>{{$row->email}}</td>
                            <td>{{$row->teacher->contact ?? ''}}</td>
                            <td>{{$unpaid_travel}}</td>
                            <td>{{$unpaid_hour}}</td>
                            <td class="text-right">
                                <x-actions>

                                    <li class="navi-item">
                                        <a href="javascript:;" class="navi-link" data-toggle="modal" data-target="#ediModal" onclick="ediFn(this)"
                                           data-href="{{route('teacher.update', ['teacher' => $row->id])}}"
                                           data-name="{{$row->name}}"
                                           data-email="{{$row->email}}"
                                           data-contact="{{$row->teacher->contact ?? ''}}"
                                           data-address="{{$row->teacher->address ?? ''}}"
                                           data-city="{{$row->teacher->city ?? ''}}"
                                           data-zip="{{$row->teacher->zip ?? ''}}"
                                           data-dob="{{$row->teacher->dob ?? ''}}"
                                           data-gender="{{$row->teacher->gender ?? ''}}"
                                           data-grade="{{$row->teacher->grade ?? ''}}"
                                           data-working="{{$row->teacher->working_hour ?? ''}}"
                                           data-photo="{{asset($row->profile_photo_path ?? 'assets/media/users/blank.png')}}">
                                            <span class="navi-icon"><i class="la la-pencil-square-o text-success"></i></span>
                                            <span class="navi-text">{{__('Edit')}}</span>
                                        </a>
                                    </li>

                                    @php
                                        $data = [];
                                        $assign = $row->student_assign()->select('student_id')->get();
                                        foreach ($assign as $permit){
                                            $data[] = $permit->student_id;
                                        }
                                        //dd($data);
                                    @endphp

                                    <li class="navi-item">
                                        <a href="javascript:;" class="navi-link" data-toggle="modal" data-target="#assignModal" onclick="assignFn(this)"
                                           data-href="{{route('assign.teacher', ['id' => $row->id])}}"
                                           data-permission="{{json_encode($data)}}">
                                            <span class="navi-icon"><i class="la la-hand-point-right text-primary"></i></span>
                                            <span class="navi-text">{{__('Assign Students')}}</span>
                                        </a>
                                    </li>

                                    @if($total_unpaid_hours > 0)
                                    <li class="navi-item">
                                        <a href="javascript:;" class="navi-link" data-toggle="modal" data-target="#payModal" onclick="payFn(this)"
                                           data-href="{{route('pay.teacher', ['teacher' => $row->id])}}"
                                           data-hour="{{$total_unpaid_hours}}"
                                        >
                                            <span class="navi-icon"><i class="la la-money text-warning"></i></span>
                                            <span class="navi-text">{{__('Payment')}}</span>
                                        </a>
                                    </li>
                                    @endif

                                    <li class="navi-item">
                                        <a href="{{route('teacher.show', ['teacher' => $row->id])}}" class="navi-link">
                                            <span class="navi-icon"><i class="la la-eye text-info"></i></span>
                                            <span class="navi-text">{{__('Show')}}</span>
                                        </a>
                                    </li>

                                    <li class="navi-item">
                                        <a href="javascript:;" data-href="{{route('teacher.destroy', ['teacher' => $row->id])}}" class="navi-link" onclick="delFn(this)">
                                            <span class="navi-icon"><i class="la la-trash-o text-danger"></i></span>
                                            <span class="navi-text">{{__('Delete')}}</span>
                                        </a>
                                    </li>

                                </x-actions>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </x-card>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">

        function ediFn(e){
            var link = e.getAttribute('data-href');
            var name = e.getAttribute('data-name');
            var email = e.getAttribute('data-email');
            var contact = e.getAttribute('data-contact');
            var address = e.getAttribute('data-address');
            var zip = e.getAttribute('data-zip');
            var city = e.getAttribute('data-city');
            var gender = e.getAttribute('data-gender');
            var grade = e.getAttribute('data-grade');
            var working_hour = e.getAttribute('data-working');
            var dob = e.getAttribute('data-dob');
            var photo = e.getAttribute('data-photo');

            $('#ediModal form').attr('action', link);

            $('#ediModal [name=name]').val(name);
            $('#ediModal [name=email]').val(email);
            $('#ediModal [name=contact]').val(contact);
            $('#ediModal [name=address]').val(address);
            $('#ediModal [name=zip]').val(zip);
            $('#ediModal [name=city]').val(city);
            $('#ediModal [name=gender]').val(gender);
            $('#ediModal [name=grade]').val(grade);
            $('#ediModal [name=dob]').val(dob);
            $('#ediModal [name=working_hour]').val(working_hour);

            $('#ediModal .ediprofile_photo').css('background-image', 'url("' + photo + '")');
        }

        function payFn(e){
            var link = e.getAttribute('data-href');
            var hour = e.getAttribute('data-hour');
            $('#payModal form').attr('action', link);
            $('#payModal [name=paid_hour]').attr('max', hour);
        }

        function assignFn(e) {
            var link = e.getAttribute('data-href');
            var permission = e.getAttribute('data-permission');

            $('#assignModal input:checkbox').prop('checked',false);

            $('#assignModal form').attr('action', link);

            $.each(JSON.parse(permission), function( index, value ) {
                $('#assignModal #checkedPerm'+value).prop('checked',true);
            });

        }

        new KTImageInput('profile_photo');
        new KTImageInput('ediprofile_photo');

        $('#kt_datatable').DataTable({
            columnDefs: [
                { orderable: false, "targets": [5] }//For Column Order
            ]
        });
    </script>
@endsection
