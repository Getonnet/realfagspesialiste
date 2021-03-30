@section('box')
    <x-modals id="ediPayModal" action="#" title="{{__('Teacher Payment Edit')}}">
        @method('PUT')
        <x-ninput label="{{__('Pay Amount')}}" type="number" min="0" step="any" name="amount" required="required" />
        <x-ninput label="{{__('Pay Hour')}}" type="number" min="0" step="any" name="paid_hour" required="required" />
        <x-ninput label="{{__('Description')}}" name="description"/>
    </x-modals>
@endsection
