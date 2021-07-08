@if($table->count() > 0)

    <table class="table table-separate table-sm table-striped reports-time mobile-table">
        <thead>
        <tr>
            <th>{{__('Date')}}</th>
            <th>{{__('Student')}}</th>
            <th>{{__('Teacher')}}</th>
            <th>{{__('Subject')}}</th>
            <th>{{__('Start')}}</th>
            <th>{{__('End')}}</th>
            <th>{{__('Hour')}}</th>
            <th>{{__('Travel')}}</th>
        </tr>
        </thead>
        <tbody>
        @php
            $hours = 0;
            $travels = 0;
        @endphp
        @foreach($table as $row)
            <tr>
                <td>{{date('d.M.Y', strtotime($row->created_at))}}</td>
                <td>{{$row->student_name}}</td>
                <td>{{$row->teacher_name}}</td>
                <td>{{$row->subject_name}}</td>
                <td>{{isset($row->start_time) ? date('d.M.Y H:i', strtotime($row->start_time)) : ''}}</td>
                <td>{{isset($row->end_time) ? date('d.M.Y H:i', strtotime($row->end_time)) : ''}}</td>
                <td>{{$row->spend_time('H')}} {{__('Hr')}}</td>
                <td>{{number_format(($row->hour_spend / 60), 2, '.', ' ')}} {{__('Hr')}}</td>
            </tr>
            @php
                $hours += (double) $row->spend_time('H');
                $travels += (double) $row->hour_spend;
            @endphp
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6" class="text-right">{{__('Total')}}</th>
                <th>{{$hours}} {{__('Hr')}}</th>
                <th>{{number_format(($travels / 60), 2, '.', ' ')}} {{__('Hr')}}</th>
            </tr>
        </tfoot>
    </table>

@else
    <p class="text-center text-gray-500">{{__('Nothing to found')}}</p>
@endif
