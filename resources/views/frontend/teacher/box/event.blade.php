@section('box')

    <x-modals id="addModal" action="{{route('teacher.events-save')}}" title="{{__('Update Status')}}">

        <x-ninput label="{{__('Event Start')}}" name="event_start" required="required" />

        <x-nselect label="{{__('Subject Select')}}" name="subject_id" required="required" >
            @foreach($subjects as $row)
            <option value="{{$row->id}}">{{$row->name}}</option>
            @endforeach
        </x-nselect>

        <x-nselect label="{{__('Student Select')}}" name="student_id" required="required" >
            @foreach($students as $row)
                <option value="{{$row->id}}">{{$row->name}}</option>
            @endforeach
        </x-nselect>

        <div class="form-group">
            <label for="exampleTextarea">Descriptions</label>
            <textarea class="form-control" name="description" placeholder="{{__('Lesson Descriptions')}}" rows="3"></textarea>
        </div>

    </x-modals>

@endsection
