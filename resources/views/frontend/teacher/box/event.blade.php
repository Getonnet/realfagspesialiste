@section('box')

    <x-modals id="addModal" action="{{route('teacher.events-save')}}" title="{{__('Add Tuition Plan')}}">

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

    <x-modals id="ediModal" action="#" title="{{__('Edit Tuition Plan')}}">

        @method('PUT')

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
            <label for="exampleTextarea">{{__('Descriptions')}}</label>
            <textarea class="form-control" name="description" placeholder="{{__('Lesson Descriptions')}}" rows="3"></textarea>
        </div>

    </x-modals>

    <x-modals id="endModal" action="#" title="{{__('Ending Time Log')}}">
        @method('PUT')
        <p><b>{{__('Student Name')}}:</b> <span id="student_names"></span></p>
        <p><b>{{__('Subject Name')}}:</b> <span id="subject_names"></span></p>

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

    </x-modals>

    <x-modals id="viewModal" title="{{__('Tuition overview')}}">

    </x-modals>

@endsection
