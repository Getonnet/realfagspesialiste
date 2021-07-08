@extends('layouts.general')
@section('title')
    {{__('All Payments')}}
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col">

            <x-card title="{{__('Payment History')}}">
                <table class="table table-separate table-head-custom table-sm table-striped history mobile-table" id="kt_datatable">
                    <thead>
                    <tr>
                        <th>{{__('Date')}}</th>
                        <th>{{__('Payment Mode')}}</th>
                        <th>{{__('Paid Hour')}}</th>
                        <th>{{__('Paid Amount')}}</th>
                        <th>{{__("Payment Descriptions")}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($table as $row)
                        <tr>
                            <td data-sort="{{strtotime($row->created_at)}}">{{date('d.M.Y', strtotime($row->created_at))}}</td>
                            <td>{{$row->is_travel == 0 ? 'Regular' : 'Travel'}}</td>
                            <td>{{number_format($row->paid_hour, 2, '.', ' ')}} {{__('Hr')}}</td>
                            <td>{{number_format($row->amount, 2, '.', ' ')}} kr</td>
                            <td>{{$row->description}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </x-card>

        </div>
    </div>
</div>

@endsection

@section('script')
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script type="text/javascript">

        $('#kt_datatable').DataTable({
            order: [],//Disable default sorting
            language: {
                url: "{{asset('no.json')}}"
            },
        });

    </script>
@endsection
