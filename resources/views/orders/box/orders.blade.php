@section('box')

    <x-modals id="ediModal" action="#" title="{{__('Update Status')}}">
        @method('PUT')

        <table class="table table-sm table-bordered">
            <tr>
                <th>Date</th>
                <td id="o_date"></td>
            </tr>
            <tr>
                <th>Student Name</th>
                <td id="o_name"></td>
            </tr>
            <tr>
                <td colspan="2"></td>
            </tr>
            <tr>
                <th>Package</th>
                <td id="o_package"></td>
            </tr>
            <tr>
                <th>Coupon</th>
                <td id="o_coupon"></td>
            </tr>
            <tr class="text-primary">
                <th>Amount</th>
                <td id="o_price"></td>
            </tr>
            <tr class="text-danger">
                <th>Hours</th>
                <td id="o_hour"></td>
            </tr>
        </table>

        <x-nselect label="{{__('Change Status')}}" name="status" >
            <option value="Pending">{{__('Pending')}}</option>
            <option value="Paid">{{__('Paid')}}</option>
            <option value="Unpaid">{{__('Unpaid')}}</option>
            <option value="Active">{{__('Active')}}</option>
        </x-nselect>

    </x-modals>

@endsection
