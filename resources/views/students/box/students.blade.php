@section('box')

    <x-modals id="ediModal" action="#" title="{{__('Edit Student Info')}}">
        @method('PUT')
        <div class="text-center">
            <x-uploadprofile name="photo" id="ediprofile_photo" />
        </div>

        <x-ninput label="{{__('User Name')}}" name="name" required="required" />

        <x-ninput label="{{__('Contact')}}" name="Contact" />
        <x-ninput label="{{__('Zip')}}" name="zip" />
        <x-ninput label="{{__('City')}}" name="city" />
        <x-ninput label="{{__('Address')}}" name="address" />

    </x-modals>

@endsection