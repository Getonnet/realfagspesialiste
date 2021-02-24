@section('box')

    <x-modals id="addModal" action="{{route('users.store')}}" title="{{__('Add new user')}}">

        <div class="text-center">
            <x-uploadprofile name="photo" id="profile_photo" />
        </div>

        <x-ninput label="{{__('User Name')}}" name="name" required="required" />

        <x-ninput label="{{__('Email Address')}}" name="email" type="email" required="required" />

        <x-ninput label="{{__('Password')}}" name="password" type="password" required="required" />

        <x-ninput label="{{__('Password Confirmation')}}" name="password_confirmation" type="password" required="required" />

    </x-modals>

    <x-modals id="ediModal" action="#" title="{{__('Edit user')}}">
        @method('PUT')
        <div class="text-center">
            <x-uploadprofile name="photo" id="ediprofile_photo" />
        </div>

        <x-ninput label="{{__('User Name')}}" name="name" required="required" />

        <x-ninput label="{{__('Email Address')}}" name="email" type="email" required="required" />

        <x-ninput label="{{__('Password')}}" name="password" type="password"/>

        <x-ninput label="{{__('Password Confirmation')}}" name="password_confirmation" type="password"/>

    </x-modals>

@endsection
