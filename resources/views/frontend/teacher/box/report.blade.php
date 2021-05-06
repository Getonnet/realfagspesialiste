@section('box')
    <x-modals id="viewModal" title="{{__('Tuition overview')}}">

    </x-modals>

    <x-modals id="addModal" action="{{route('teacher.events-add')}}" class="modal-lg" title="{{__('Add new reports')}}">

        <div class="row">
            <div class="col">
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

                <x-ninput label="{{__('Title')}}" name="name" required="required" />
                <!--<x-ninput label="{{__('Event Date')}}" name="event_start" required="required" />-->
                <x-ninput label="{{__('Start')}} & {{__('End')}}" name="start_end_time" required="required" />

                <x-nselect label="{{__('Subject Select')}}" name="subject_id" required="required" >
                    <option value="">{{__('Select Subject')}}</option>
                    @foreach($subjects as $row)
                        <option value="{{$row->subject_id}}">{{$row->subject->name ?? ''}}</option>
                    @endforeach
                </x-nselect>

                <x-nselect label="{{__('Transport Time')}}" name="hour_spend" required="required" >
                    <option value="">{{__('Select Time')}}</option>
                    <option value="0">0 min</option>
                    <option value="15">15 min</option>
                    <option value="20">20 min</option>
                    <option value="25">25 min</option>
                    <option value="30">30 min</option>
                </x-nselect>

            </div>

            <div class="col">

                <x-ninput label="{{__('Motivational Scale (1-10)')}}" name="motivational" type="number" min="1" max="10" required="required" />
                <x-ninput label="{{__('Understanding Scale (1-10)')}}" name="understanding" type="number" min="1" max="10" required="required" />

                <div class="form-group">
                    <label for="descriptionx">{{__('Descriptions')}}</label>
                    <textarea class="form-control" id="descriptionx" name="description" placeholder="{{__('Lesson Descriptions')}}" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="summeryx">{{__('Summery')}}</label>
                    <textarea class="form-control" id="summeryx" name="summery" placeholder="{{__('Summery this session')}}" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="files">{{__('Study Materials')}}</label>
                    <input id="files" type="file" name="materials[]" multiple>
                </div>
            </div>
        </div>

    </x-modals>
@endsection
