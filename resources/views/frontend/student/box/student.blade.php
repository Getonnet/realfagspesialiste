@section('box')
    <!-- Modal-->
    <div class="modal fade" id="orderModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('Order Confirm')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form action="{{route('package.orders')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" />
                    <div class="modal-body">

                        <table class="table table-bordered">
                            <tr>
                                <th>{{__('Package name')}}</th>
                                <td id="p_name"></td>
                            </tr>
                            <tr>
                                <th>Antall timer</th>
                                <td id="p_hour"></td>
                            </tr>
                            <tr>
                                <th>{{__('Price')}}</th>
                                <td  id="p_price"></td>
                            </tr>
                        </table>

                        <div id="show_coupon"></div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">{{__('Cancel')}}</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">{{__('Confirm')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-modals id="viewModal" title="{{__('Tuition overview')}}">

    </x-modals>

@endsection
