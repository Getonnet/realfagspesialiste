@if($table->count() > 0)

    <table class="table table-separate table-sm table-striped">
        <thead>
        <tr>
            <th>{{__('Date')}}</th>
            <th>{{__('Event Date')}}</th>
            <th>{{__('Student')}}</th>
            <th>{{__('Teacher')}}</th>
            <th>{{__('Subject')}}</th>
            <th>{{__('Start')}}</th>
            <th>{{__('End')}}</th>
            <th>{{__('Hour')}}</th>
            <th>{{__('Status')}}</th>
        </tr>
        </thead>
        <tbody>
        @php
            $hours = 0;
        @endphp
        @foreach($table as $row)
            <tr>
                <td>{{date('d/m/Y', strtotime($row->created_at))}}</td>
                <td>{{date('d, M h:i A', strtotime($row->event_start))}}</td>
                <td>{{$row->student_name}}</td>
                <td>{{$row->teacher_name}}</td>
                <td>{{$row->subject_name}}</td>
                <td>{{isset($row->start_time) ? date('d, M h:i A', strtotime($row->start_time)) : ''}}</td>
                <td>{{isset($row->end_time) ? date('d, M h:i A', strtotime($row->end_time)) : ''}}</td>
                <td>{{$row->spend_time('H')}}</td>
                <td>{{__($row->status)}}</td>
            </tr>
            @php
                $hours += $row->spend_time('H');
            @endphp
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7" class="text-right">Total Hour</th>
                <th>{{$hours}}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>

@else
    <p class="text-center text-gray-500">{{__('Nothing to found')}}</p>
@endif
