@section('box')

<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class = "modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('Tuition overview')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
                <div class="modal-body">

                    <table class="table table-bordered">
                        <tr>
                            <th>{{__('Title')}}</th>
                            <td class="titles"></td>
                        </tr>
                        <tr>
                            <th>{{__('Student Name')}}</th>
                            <td class="student"></td>
                        </tr>

{{--                        <tr>--}}
{{--                            <th>{{__('Event Date')}}</th>--}}
{{--                            <td class="event_date"></td>--}}
{{--                        </tr>--}}

                        <tr>
                            <th>{{__('Session Start')}}</th>
                            <td class="st"></td>
                        </tr>
                        <tr>
                            <th>{{__('Session End')}}</th>
                            <td class="end"></td>
                        </tr>
                        <tr>
                            <th>{{__('Hour Spend')}}</th>
                            <td class="spend"></td>
                        </tr>
                    </table>

                </div>
                <div class="modal-footer">

                    <a href="javascript:;" class="btn btn-light-success font-weight-bold" data-toggle="modal" data-target="#ediModal">{{__('Edit')}}</a>
                    <a class="btn btn-light-dark font-weight-bold" id="del_events" href="javascript:;" data-href="" class="navi-link" onclick="delFn(this)">{{__('Delete')}}</a>
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">{{__('Close')}}</button>
                </div>
        </div>
    </div>
</div>



<x-modals id="addModal" action="{{route('teacher.events-save')}}" title="Legg til ny hendelse">
    <input type="hidden" name="status" value="Pending" />
    <x-ninput label="{{__('Title')}}" name="name" required="required" />
    <x-nselect label="{{__('Select Student')}}" name="student_id" required="required" >
        <option value="">{{__('Select Student')}}</option>
        @foreach($student as $row)

            @php
                $hour = $row->students->purchase()->where('status', 'Active')->sum('hours');
                $spends = $row->students->time_log()->where('status', 'End')->get();
                $spend_times = 0;
                foreach ($spends as $spend){
                    $spend_times += $spend->spend_time();
                }
                $hour_to_min = $hour * 60;
                $remain_min = $hour_to_min - $spend_times;
                $remaining = number_format(($remain_min / 60), 2, '.', ' ');

            @endphp

            <option value="{{$row->student_id}}">{{$row->students->name ?? ''}} ({{$remaining}})</option>
        @endforeach
    </x-nselect>

{{--    <x-ninput label="{{__('Event Date')}}" name="event_start" required="required" />--}}
    <x-ninput label="{{__('Start')}} & {{__('End')}}" name="start_end_time" required="required" />

</x-modals>

<x-modals id="ediModal" action="#" title="{{__('Edit Tuition Plan')}}">

    @method('PUT')

    <x-ninput label="{{__('Title')}}" name="name" required="required" />

{{--    <x-ninput label="{{__('Event Start')}}" name="event_start" required="required" />--}}


    <x-nselect label="{{__('Select Student')}}" name="student_id" required="required" >
        <option value="">{{__('Select Student')}}</option>
        @foreach($student as $row)
            @php
                $hour = $row->students->purchase()->where('status', 'Active')->sum('hours');
                $spends = $row->students->time_log()->where('status', 'End')->get();
                $spend_times = 0;
                foreach ($spends as $spend){
                    $spend_times += $spend->spend_time();
                }
                $hour_to_min = $hour * 60;
                $remain_min = $hour_to_min - $spend_times;
                $remaining = number_format(($remain_min / 60), 2, '.', ' ');

            @endphp

            <option value="{{$row->student_id}}">{{$row->students->name ?? ''}} ({{$remaining}})</option>
        @endforeach
    </x-nselect>

    <x-ninput label="{{__('Start')}} & {{__('End')}}" name="start_end_time" required="required" />

</x-modals>
@endsection
