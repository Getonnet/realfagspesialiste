
    <table class="table table-bordered">
        <tr>
            <th>{{__('Student Name')}}</th>
            <td>{{$table->student_name}}</td>
        </tr>
        <tr>
            <th>{{__('Student Email')}}</th>
            <td>{{$table->student_email}}</td>
        </tr>
        <tr>
            <th>{{__('Subject')}}</th>
            <td>{{$table->subject_name}}</td>
        </tr>
        <tr>
            <th>{{__('Event Date')}}</th>
            <td>{{date('d, M h:i A', strtotime($table->event_start))}}</td>
        </tr>
        <tr>
            <th>{{__('Session Start')}}</th>
            <td>{{isset($table->start_time) ? date('d, M h:i A', strtotime($table->start_time)) : ''}}</td>
        </tr>
        <tr>
            <th>{{__('Session End')}}</th>
            <td>{{isset($table->end_time) ? date('d, M h:i A', strtotime($table->end_time)) : ''}}</td>
        </tr>
        <tr>
            <th>{{__('Hour Spend')}}</th>
            <td>{{$table->spend_time('H')}} Hr</td>
        </tr>
        <tr>
            <th>{{__('Travel Time')}}</th>
            <td>{{$table->hour_spend}} Min</td>
        </tr>
        <tr>
            <th>{{__('Status')}}</th>
            <td>{{$table->status}}</td>
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

