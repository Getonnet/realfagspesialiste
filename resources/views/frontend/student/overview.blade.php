

<table class="table table-bordered">
    <tr>
        <th>{{__('Title')}}</th>
        <td>{{$table->name ?? __('No Title')}}</td>
    </tr>
    <tr>
        <th>{{__('Teacher Name')}}</th>
        <td>{{$table->teacher_name}}</td>
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
        <td>{{$table->spend_time('H')}} timer</td>
    </tr>
    <tr>
        <th>{{__('Travel')}}</th>
        <td>{{$table->hour_spend}} Min</td>
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
                    <a class="list-group-item list-group-item-action" href="{{asset($row->file_name)}}">Download</a>
                @endforeach
            </div>
        </td>
    </tr>
</table>

