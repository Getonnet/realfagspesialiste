@extends('layouts.general')
@extends('frontend.student.box.student')

@section('title')
    {{__('All Events')}}
@endsection

@section('content')

    <div class="row">
        <div class="col">

            <x-card title="{{__('Events List')}}">
                <table class="table table-separate table-head-custom table-sm table-striped" id="kt_datatable">
                    <thead>
                    <tr>
                        <th>{{__('Event Date')}}</th>
                        <th>{{__('Subject')}}</th>
                        <th>{{__('Teacher')}}</th>
                        <th>{{__('Email')}}</th>
                        <th>{{__('Start')}}</th>
                        <th>{{__('End')}}</th>
                        <th>{{__('Hour')}}</th>
                        <th>{{__('Status')}}</th>
                        <th class="text-right">{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($table as $row)
                        <tr>
                            <td>{{date('d, M h:i A', strtotime($row->event_start))}}</td>
                            <td>{{$row->subject_name}}</td>
                            <td>{{$row->teacher_name}}</td>
                            <td>{{$row->teacher_email}}</td>
                            <td>{{isset($row->start_time) ? date('d, M h:i A', strtotime($row->start_time)) : ''}}</td>
                            <td>{{isset($row->end_time) ? date('d, M h:i A', strtotime($row->end_time)) : ''}}</td>
                            <td>{{$row->spend_time('H')}}</td>
                            <td>{{__($row->status)}}</td>
                            <td class="text-right">

                                <x-actions>
                                    <li class="navi-item">
                                        <a href="javascript:;" class="navi-link" data-toggle="modal" data-target="#viewModal" onclick="viewFn(this)"
                                           data-href="{{route('student.events-overview', ['id' => $row->id])}}">
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

        $('#kt_datatable').DataTable({
            columnDefs: [
                { orderable: false, "targets": [7,8] }//For Column Order
            ]
        });

    </script>
@endsection
