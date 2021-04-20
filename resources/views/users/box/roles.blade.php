@section('box')

    <x-modals id="addModal" class="modal-sm" action="{{route('roles.store')}}" title="{{__('Add new role')}}">

        <x-ninput label="{{__('Role Name')}}" name="name" required="required" />

    </x-modals>


    <x-modals id="ediModal" class="modal-sm" action="#" title="{{__('Edit role')}}">
        @method('PUT')

        <x-ninput label="{{__('Role Name')}}" name="name" required="required" />

    </x-modals>


    <x-modals id="permissionModal" class="modal-lg" action="#" title="{{__('Assign Permission')}}">
        @method('PUT')

        <div class="row">
            @foreach($permissions as $permission)
                <div class="col">
                    <div class="form-group">
                        <div class="checkbox-list">
                            @foreach($permission as $row)
                                <label class="checkbox checkbox-success">
                                    <input type="checkbox" id="checkedPerm{{$row->id}}" name="permissions[]" value="{{$row->id}}"/>
                                    <span></span>
                                    {{__($row->name)}}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


    </x-modals>

@endsection
