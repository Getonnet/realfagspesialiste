

<table class="table table-bordered">
    <tr>
        <th>{{__('Title')}}</th>
        <td>{{$table->name ?? __('No Title')}}</td>
    </tr>
    <tr>
        <th>{{__('Teacher Name')}}</th>
        <td>{{$table->teacher_name}}</td>
    </tr>
{{--    <tr>--}}
{{--        <th>{{__('Event Date')}}</th>--}}
{{--        <td>{{isset($table->event_start) ? date('d, M H:i', strtotime($table->event_start)) : ''}}</td>--}}
{{--    </tr>--}}
    <tr>
        <th>{{__('Session Start')}}</th>
        <td>{{isset($table->start_time) ? date('d, M H:i', strtotime($table->start_time)) : ''}}</td>
    </tr>
    <tr>
        <th>{{__('Session End')}}</th>
        <td>{{isset($table->end_time) ? date('d, M H:i', strtotime($table->end_time)) : ''}}</td>
    </tr>
    <tr>
        <th>{{__('Hour Spend')}}</th>
        <td>{{$table->spend_time('H')}} timer</td>
    </tr>
    <tr>
        <th>{{__('Travel')}}</th>
        <td>{{$table->hour_spend}} Min</td>
    </tr>
</table>

