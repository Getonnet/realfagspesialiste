@section('box')

    <x-modals id="addModal" action="{{route('student.store')}}" class="modal-lg" title="{{__('Add new Student')}}">

        <div class="text-center">
            <x-uploadprofile name="photo" id="profile_photo" />
        </div>

        <div class="row">
            <div class="col">
                <x-ninput label="{{__('User Name')}}" name="name" required="required" />
                <x-ninput label="{{__('Email Address')}}" name="email" type="email" required="required" />
                <x-ninput label="{{__('Password')}}" name="password" type="password" required="required" />
                <x-ninput label="{{__('Password Confirmation')}}" name="password_confirmation" type="password" required="required" />
            </div>
            <div class="col">
                <x-ninput label="{{__('Contact')}}" name="contact" required="required"/>
                <x-ninput label="{{__('Zip')}}" name="zip" required="required"/>
                <x-ninput label="{{__('City')}}" name="city" required="required"/>
                <x-ninput label="{{__('Address')}}" name="address" required="required"/>
            </div>
        </div>

    </x-modals>


    <x-modals id="ediModal" action="#" class="modal-lg" title="{{__('Edit Student Information')}}">
        @method('PUT')
        <div class="text-center">
            <x-uploadprofile name="photo" id="ediprofile_photo" />
        </div>

        <div class="row">
            <div class="col">
                <x-ninput label="{{__('User Name')}}" name="name" required="required" />
                <x-ninput label="{{__('Email Address')}}" name="email" type="email" required="required"  readonly="readonly" />
                <x-ninput label="{{__('Password')}}" name="password" type="password"/>
                <x-ninput label="{{__('Password Confirmation')}}" name="password_confirmation" type="password" />
            </div>
            <div class="col">
                <x-ninput label="{{__('Contact')}}" name="contact" required="required"/>
                <x-ninput label="{{__('Zip')}}" name="zip" required="required"/>
                <x-ninput label="{{__('City')}}" name="city" required="required"/>
                <x-ninput label="{{__('Address')}}" name="address" required="required"/>
            </div>
        </div>
    </x-modals>

    <x-modals id="viewModal" title="{{__('Event overview')}}">

    </x-modals>

@endsection
