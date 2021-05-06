@section('box')
<x-modals id="viewModal" title="{{__('Tuition overview')}}">

</x-modals>

<x-modals id="addModal" action="{{route('teacher.events-save')}}" title="Legg til ny hendelse">

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

    <x-ninput label="{{__('Event Date')}}" name="event_start" required="required" />
    <x-ninput label="{{__('Start')}} & {{__('End')}}" name="start_end_time" required="required" />

</x-modals>
@endsection
