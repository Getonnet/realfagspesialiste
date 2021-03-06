@php
    $hour = $table->student->purchase()->where('status', 'Active')->sum('hours');
    $spends = $table->student->time_log()->where('status', 'End')->get();
    $travel_times = 0;
    $spend_times = 0;
    foreach ($spends as $spend){
        $spend_times += $spend->spend_time();
        $travel_times += $spend->hour_spend;
    }
    $hour_to_min = $hour * 60;
    $remain_min = $hour_to_min - ($spend_times + $travel_times);
    $remaining = number_format(($remain_min / 60), 2, '.', ' ');

//dd($remaining);

@endphp
<table class="table table-bordered">
    <tr>
        <th>{{__('Title')}}</th>
        <td>{{$table->name ?? __('No Title')}}</td>
    </tr>
    <tr>
        <th>{{__('Student Name')}}</th>
        <td>{{$table->student_name}}</td>
    </tr>

    <tr>
        <th>{{__('Event Date')}}</th>
        <td>{{isset($table->event_start) ? date('d, M H:i', strtotime($table->event_start)) : ''}}</td>
    </tr>

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
        <td>{{$table->spend_time('H')}} {{__('Hr')}}</td>
    </tr>
    <tr>
        <th>{{__('Remaining Hours')}}</th>
        <td>{{$remaining}} {{__('Hr')}}</td>
    </tr>
</table>

