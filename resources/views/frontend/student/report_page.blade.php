@if($table->count() > 0)

    <table class="table table-separate table-sm table-striped">
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
            </tr>
        @endforeach
        </tbody>
    </table>

@else
    <p class="text-center text-gray-500">{{__('Nothing to found')}}</p>
@endif
