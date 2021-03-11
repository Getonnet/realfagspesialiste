@extends('layouts.general')
@extends('frontend.teacher.box.event')

@section('title')
    {{__('All Events')}}
@endsection

@section('content')

<div class="row">
    <div class="col">

        <x-card title="{{__('Events List')}}">
            <x-slot name="button">
                <button class="btn btn-primary ml-1" data-toggle="modal" data-target="#addModal"><i class="flaticon2-add-1"></i> {{__('Add Tuition Plan')}}</button>
            </x-slot>
            <table class="table table-separate table-head-custom table-sm table-striped" id="kt_datatable">
                <thead>
                <tr>
                    <th>Event Date</th>
                    <th>Subject</th>
                    <th>Student</th>
                    <th>Email</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Hour</th>
                    <th>Status</th>
                    <th class="text-right">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($table as $row)
                    <tr>
                        <td>{{date('d, M h:i A', strtotime($row->event_start))}}</td>
                        <td>{{$row->subject_name}}</td>
                        <td>{{$row->student_name}}</td>
                        <td>{{$row->student_email}}</td>
                        <td>{{isset($row->start_time) ? date('d, M h:i A', strtotime($row->start_time)) : ''}}</td>
                        <td>{{isset($row->end_time) ? date('d, M h:i A', strtotime($row->end_time)) : ''}}</td>
                        <td>{{$row->hour_spend}}</td>
                        <td>{{$row->status}}</td>
                        <td class="text-right">
                            <x-actions>

                                <li class="navi-item">
                                    <a href="javascript:;" class="navi-link" data-toggle="modal" data-target="#ediModal" onclick="ediFn(this)"
                                       data-href="{{route('users.update', ['user' => $row->id])}}"
                                       data-name="{{$row->name}}"
                                       data-email="{{$row->email}}"
                                       data-role="{{$role_id ?? ''}}"
                                       data-photo="{{asset($row->profile_photo_path ?? 'assets/media/users/blank.png')}}"
                                    >
                                        <span class="navi-icon"><i class="la la-pencil-square-o text-success"></i></span>
                                        <span class="navi-text">{{__('Edit')}}</span>
                                    </a>
                                </li>

                                <li class="navi-item">
                                    <a href="javascript:;" data-href="{{route('users.destroy', ['user' => $row->id])}}" class="navi-link" onclick="delFn(this)">
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
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script type="text/javascript">

       // $('.select2').select2();

        $('#addModal [name=event_start]').daterangepicker({
            timePicker: true,
            singleDatePicker: true,
            minDate:new Date(),
            locale: {
                format: 'DD-MM-YYYY hh:mm A'
            }
        });

       $('#kt_datatable').DataTable({
           columnDefs: [
               { orderable: false, "targets": [7,8] }//For Column Order
           ]
       });

    </script>
@endsection
