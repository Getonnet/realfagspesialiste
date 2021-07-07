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
            <th>{{__('Subject')}}</th>
            <td>{{$table->subject_name}}</td>
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
            <th>{{__('Travel Time')}}</th>
            <td>{{$table->hour_spend}} Min</td>
        </tr>
        <tr>
            <th>{{__('Remaining Hours')}}</th>
            <td>{{$remaining}} {{__('Hr')}}</td>
        </tr>
        <tr>
            <th>{{__('Motivational Scale (1-10)')}}</th>
            <td>{{$table->motivational}}</td>
        </tr>
        <tr>
            <th>{{__('Understanding Scale (1-10)')}}</th>
            <td>{{$table->understanding}}</td>
        </tr>
        <tr>
            <th colspan="2" class="text-center">{{__('Lesson Descriptions')}}</th>
        </tr>
        <tr>
            <td colspan="2">{{$table->description}}</td>
        </tr>
        <tr>
            <th colspan="2" class="text-center">{{__('Session Summery')}}</th>
        </tr>
        <tr>
            <td colspan="2">{{$table->summery}}</td>
        </tr>
        <tr>
            <th colspan="2" class="text-center">{{__('Course Material')}}</th>
        </tr>
        <tr>
            <td colspan="2">
                @php
                    $mat = $table->studyMaterials()->get();
                @endphp
              <div class="list-group">
                    @foreach($mat as $row)
                      <a class="list-group-item list-group-item-action" href="{{asset($row->file_name)}}">{{__('Download')}}</a>
                    @endforeach
                </div>
            </td>
        </tr>
    </table>

