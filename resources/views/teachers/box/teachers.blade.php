@section('box')

    <x-modals id="addModal" action="{{route('teacher.store')}}" class="modal-lg" title="{{__('Add new Teacher')}}">

        <div class="row">
            <div class="col">
                <div class="text-center">
                    <x-uploadprofile name="photo" id="profile_photo" />
                </div>
                <x-ninput label="{{__('User Name')}}" name="name" required="required" />
                <x-ninput label="{{__('Email Address')}}" name="email" type="email" required="required" />
                <x-ninput label="{{__('Contact')}}" name="contact" required="required"/>
                <x-ninput label="{{__('Password')}}" name="password" type="password" required="required" />
                <x-ninput label="{{__('Password Confirmation')}}" name="password_confirmation" type="password" required="required" />
            </div>
            <div class="col">
                <x-ninput label="{{__('Birthday')}}" type="date" name="dob" required="required"/>
                <x-nselect label="{{__('Select Gender')}}" name="gender" >
                    <option value="Male">{{__('Male')}}</option>
                    <option value="Female">{{__('Female')}}</option>
                    <option value="Other">{{__('Other')}}</option>
                </x-nselect>
                <x-nselect label="{{__('Weekly Working Hour')}}" name="working_hour" >
                    <option value="2">2 Hours</option>
                    <option value="4">2-4 Hours</option>
                    <option value="6">4-6 Hours</option>
                    <option value="8">6-8 Hours</option>
                    <option value="10">8-10 Hours</option>
                    <option value="12">12+ Hours</option>
                </x-nselect>
                <x-nselect label="{{__('VGS Grade')}}" name="grade" >
                    <option value="2">2.0</option>
                    <option value="2.5">2.5</option>
                    <option value="3">3.0</option>
                    <option value="3.5">3.5</option>
                    <option value="4">4.0</option>
                    <option value="4.5">4.5</option>
                    <option value="5">5.0</option>
                    <option value="5.5">5.5</option>
                    <option value="6">6.0</option>
                    <option value="6.5">6.5</option>
                </x-nselect>
                <x-ninput label="{{__('Zip')}}" name="zip" required="required"/>
                <x-ninput label="{{__('City')}}" name="city" required="required"/>
                <x-ninput label="{{__('Address')}}" name="address" required="required"/>

            </div>
        </div>

    </x-modals>


    <x-modals id="ediModal" action="#" class="modal-lg" title="{{__('Edit Teacher Information')}}">
        @method('PUT')

        <div class="row">
            <div class="col">
                <div class="text-center">
                    <x-uploadprofile name="photo" id="ediprofile_photo" />
                </div>
                <x-ninput label="{{__('User Name')}}" name="name" required="required" />
                <x-ninput label="{{__('Email Address')}}" name="email" type="email" required="required"  readonly="readonly" />
                <x-ninput label="{{__('Contact')}}" name="contact" required="required"/>
                <x-ninput label="{{__('Password')}}" name="password" type="password" />
                <x-ninput label="{{__('Password Confirmation')}}" name="password_confirmation" type="password" />
            </div>
            <div class="col">
                <x-ninput label="{{__('Birthday')}}" type="date" name="dob" required="required"/>
                <x-nselect label="{{__('Select Gender')}}" name="gender" >
                    <option value="Male">{{__('Male')}}</option>
                    <option value="Female">{{__('Female')}}</option>
                    <option value="Other">{{__('Other')}}</option>
                </x-nselect>
                <x-nselect label="{{__('Weekly Working Hour')}}" name="working_hour" >
                    <option value="2">2 Hours</option>
                    <option value="4">2-4 Hours</option>
                    <option value="6">4-6 Hours</option>
                    <option value="8">6-8 Hours</option>
                    <option value="10">8-10 Hours</option>
                    <option value="12">12+ Hours</option>
                </x-nselect>
                <x-nselect label="{{__('VGS Grade')}}" name="grade" >
                    <option value="2">2.0</option>
                    <option value="2.5">2.5</option>
                    <option value="3">3.0</option>
                    <option value="3.5">3.5</option>
                    <option value="4">4.0</option>
                    <option value="4.5">4.5</option>
                    <option value="5">5.0</option>
                    <option value="5.5">5.5</option>
                    <option value="6">6.0</option>
                    <option value="6.5">6.5</option>
                </x-nselect>
                <x-ninput label="{{__('Zip')}}" name="zip" required="required"/>
                <x-ninput label="{{__('City')}}" name="city" required="required"/>
                <x-ninput label="{{__('Address')}}" name="address" required="required"/>

            </div>
        </div>
    </x-modals>

@endsection
