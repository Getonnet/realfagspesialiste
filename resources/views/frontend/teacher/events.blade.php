@extends('layouts.general')
@extends('frontend.teacher.box.event')

@section('title')
    {{__('All Events')}}
@endsection

@section('content')

<div class="row">
    <div class="col">

        <x-card title="{{__('Events List')}}">
{{--            <x-slot name="button">--}}
{{--                <button class="btn btn-primary ml-1" data-toggle="modal" data-target="#addModal"><i class="flaticon2-add-1"></i> {{__('Add Tuition Plan')}}</button>--}}
{{--            </x-slot>--}}
            <table class="table table-separate table-head-custom table-sm table-striped events mobile-table" id="kt_datatable">
                <thead>
                <tr>
                    <th>{{__('Event Date')}}</th>
                    <th>{{__('Title')}}</th>
                    <th>{{__('Subject')}}</th>
                    <th>{{__('Student')}}</th>
                    <th>{{__('Start')}}</th>
                    <th>{{__('End')}}</th>
                    <th>{{__('Hour')}}</th>
                    <th>{{__('Travel')}}</th>
{{--                    <th>{{__('Status')}}</th>--}}
                    <th class="text-right">{{__('Action')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($table as $row)
                    <tr>
                        <td data-sort="{{strtotime($row->event_start)}}">{{date('d.M.Y', strtotime($row->event_start))}}</td>
                        <td class="{{$row->status != 'End' ? 'text-primary': ''}}">{{$row->name ?? __('No Title')}}</td>
                        <td>{{$row->subject_name}}</td>
                        <td>{{$row->student_name}}</td>
                        <td data-sort="{{strtotime($row->start_time)}}">{{isset($row->start_time) ? date('d.M H:i', strtotime($row->start_time)) : ''}}</td>
                        <td data-sort="{{strtotime($row->end_time)}}">{{isset($row->end_time) ? date('d.M H:i', strtotime($row->end_time)) : ''}}</td>
                        <td>{{$row->spend_time('H')}} {{__('Hr')}}</td>
                        <td>{{$row->hour_spend}} Min</td>
{{--                            @if($row->status == 'Pending')--}}
{{--                            <td><a href="javascript:;" data-href="{{route('teacher.events-status-running', ['id' => $row->id])}}" onclick="runFn(this)">{{__('Start')}}</a></td>--}}
{{--                            @elseif($row->status == 'Running')--}}
{{--                                <td><a href="javascript:;"--}}
{{--                                       onclick="endFn(this)"--}}
{{--                                       data-name="{{$row->name}}"--}}
{{--                                       data-subject="{{$row->subject_id}}"--}}
{{--                                       data-student="{{$row->student_name}}"--}}
{{--                                       data-description="{{$row->description}}"--}}
{{--                                       data-start="{{date('d.M.Y H:i', strtotime($row->start_time))}}"--}}
{{--                                       data-href="{{route('teacher.events-status-end', ['id' => $row->id])}}"--}}
{{--                                       data-toggle="modal" data-target="#endModal">{{__('Stop')}}</a></td>--}}
{{--                            @else--}}
{{--                                <td>{{__($row->status)}}</td>--}}
{{--                            @endif--}}
                        <td class="text-right">

                            <x-actions>
                                @if($row->status != 'End')
                                    <li class="navi-item">
                                        <a href="javascript:;" class="navi-link" data-toggle="modal" data-target="#ediModal" onclick="ediFn(this)"
                                           data-href="{{route('teacher.events-edit', ['id' => $row->id])}}"
                                           data-name="{{$row->name}}"
                                           data-subject="{{$row->subject_id}}"
                                           data-student="{{$row->student_id}}"
                                           data-description="{{$row->description}}"
                                           data-event="{{date('d.M.Y H:i', strtotime($row->event_start))}}"
                                           data-start="{{date('d.M.Y H:i', strtotime($row->start_time))}}"
                                           data-end="{{date('d.M.Y H:i', strtotime($row->end_time))}}"
                                        >
                                            <span class="navi-icon"><i class="la la-pencil-square-o text-success"></i></span>
                                            <span class="navi-text">{{__('Edit')}}</span>
                                        </a>
                                    </li>

                                    <li class="navi-item">
                                        <a href="javascript:;" data-href="{{route('teacher.events-del', ['id' => $row->id])}}" class="navi-link" onclick="delFn(this)">
                                            <span class="navi-icon"><i class="la la-trash-o text-danger"></i></span>
                                            <span class="navi-text">{{__('Delete')}}</span>
                                        </a>
                                    </li>
                                    @else
                                    <li class="navi-item">
                                        <a href="{{route('teacher.events-edit-show', ['id' => $row->id])}}" class="navi-link" >
                                            <span class="navi-icon"><i class="la la-pencil-square-o text-success"></i></span>
                                            <span class="navi-text">{{__('Edit')}}</span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href="javascript:;" class="navi-link" data-toggle="modal" data-target="#viewModal" onclick="viewFn(this)"
                                           data-href="{{route('teacher.events-overview', ['id' => $row->id])}}"
                                        >
                                            <span class="navi-icon"><i class="fab la-phabricator text-info"></i></span>
                                            <span class="navi-text">{{__('View')}}</span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href="javascript:;" data-href="{{route('teacher.events-del', ['id' => $row->id])}}" class="navi-link" onclick="delFn(this)">
                                            <span class="navi-icon"><i class="la la-trash-o text-danger"></i></span>
                                            <span class="navi-text">{{__('Delete')}}</span>
                                        </a>
                                    </li>
                                @endif

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

       function viewFn(e) {
           var link = e.getAttribute('data-href');
           $.get( link, function( result ) {
               $( "#viewModal .modal-body" ).html( result );
           });
       }

       function runFn(e){
           var link = e.getAttribute('data-href');

           Swal.fire({
               title: "{{__('Are you sure?')}}",
               text: "{{__('You wont be able to revert this!')}}",
               icon: "warning",
               showCancelButton: true,
               confirmButtonText: "{{__('Yes, delete it!')}}",
               cancelButtonText: "{{__('No, cancel!')}}",
               reverseButtons: true
           }).then(function(result) {
               //alert(link);
               if (result.value) {
                   window.location.href = link;
               }

           });
       }

       function endFn(e) {
           var link = e.getAttribute('data-href');
           var subject_id = e.getAttribute('data-subject');
           var description = e.getAttribute('data-description');
           var name = e.getAttribute('data-name');
           var start_time = e.getAttribute('data-start');

           $('#endModal form').attr('action', link);
           $('#endModal [name=description]').val(description);
           $('#endModal [name=name]').val(name);
           $('#endModal [name=subject_id]').val(subject_id);

           $('#endModal [name=start_time]').daterangepicker({
               timePicker: true,
               timePicker24Hour: true,
               singleDatePicker: true,
               startDate: start_time,
               locale: picker_loc
           });
          // $('#endModal [name=start_time]').val(start_time);

           $('#endModal [name=end_time]').daterangepicker({
               timePicker: true,
               timePicker24Hour: true,
               singleDatePicker: true,
               minDate:new Date(),
               locale: picker_loc
           });
       }

       function ediFn(e){
           var link = e.getAttribute('data-href');

           var subject_id = e.getAttribute('data-subject');
           var student_id = e.getAttribute('data-student');
           var description = e.getAttribute('data-description');
           var event = e.getAttribute('data-event');
           var start = e.getAttribute('data-start');
           var end = e.getAttribute('data-end');
           var name = e.getAttribute('data-name');

           $('#ediModal form').attr('action', link);

           $('#ediModal [name=subject_id]').val(subject_id);
           $('#ediModal [name=student_id]').val(student_id);
           $('#ediModal [name=description]').val(description);
           $('#ediModal [name=name]').val(name);

           $('#ediModal [name=event_start]').daterangepicker({
               timePicker: true,
               timePicker24Hour: true,
               singleDatePicker: true,
               startDate: event,
               locale: picker_loc
           });
           //$('#ediModal [name=event_start]').val(event_start);

           $('#ediModal [name=start_end_time]').daterangepicker({
               timePicker: true,
               timePicker24Hour: true,
               //singleDatePicker: true,
               startDate: start,
               endDate: end,
               locale: picker_loc
           });
       }

        $('#addModal [name=event_start]').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            singleDatePicker: true,
            minDate:new Date(),
            locale: picker_loc
        });

       $('#kt_datatable').DataTable({
           order: [],//Disable default sorting
           language: {
               url: "{{asset('no.json')}}"
           },
           columnDefs: [
               { orderable: false, "targets": [8] }//For Column Order
           ]
       });

    </script>
@endsection
