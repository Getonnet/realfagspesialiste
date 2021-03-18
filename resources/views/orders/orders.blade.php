@extends('layouts.master')
@extends('orders.box.orders')

@section('title')
    {{__('Purchase Order')}}
@endsection

@section('content')

    <div class="row">
        <div class="col">
            <x-card title="{{__('Purchase Order')}}">
                <table class="table table-separate table-head-custom table-sm table-striped" id="kt_datatable">
                    <thead>
                    <tr>
                        <th>{{__('Date')}}</th>
                        <th>{{__('Student Name')}}</th>
                        <th>{{__('Package')}}</th>
                        <th>{{__('Hours')}}</th>
                        <th>{{__('Amount')}}</th>
                        <th>{{__('Status')}}</th>
                        <th class="text-right">{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($table as $row)
                        <tr>
                            <td>{{date('d/m/Y', strtotime($row->created_at))}}</td>
                            <td>{{$row->user->name ?? ''}}</td>
                            <td>{{$row->name}}</td>
                            <td>{{$row->hours}}</td>
                            <td>{{$row->price}}</td>
                            <td>{{$row->status}}</td>
                            <td class="text-right">
                                <x-actions>

                                    <li class="navi-item">
                                        <a href="javascript:;" class="navi-link" data-toggle="modal" data-target="#ediModal" onclick="ediFn(this)"
                                           data-href="{{route('orders.update', ['order' => $row->id])}}"
                                           data-date="{{date('d/m/Y', strtotime($row->created_at))}}"
                                           data-student="{{$row->user->name}}"
                                           data-package="{{$row->name}}"
                                           data-coupon="{{$row->coupon}}"
                                           data-hours="{{$row->hours}}"
                                           data-price="{{$row->price}}"
                                           data-description="{{$row->description}}"
                                           data-expire="{{date('Y-m-d h:i A', strtotime($row->expire))}}"
                                           data-status="{{$row->status}}">
                                            <span class="navi-icon"><i class="la la-pencil-square-o text-success"></i></span>
                                            <span class="navi-text">{{__('View')}}</span>
                                        </a>
                                    </li>

                                    <li class="navi-item">
                                        <a href="javascript:;" data-href="{{route('orders.destroy', ['order' => $row->id])}}" class="navi-link" onclick="delFn(this)">
                                            <span class="navi-icon"><i class="la la-trash-o text-danger"></i></span>
                                            <span class="navi-text">{{__('Delete')}}</span>
                                        </a>
                                    </li>

                                </x-actions>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </x-card>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">

        function ediFn(e){
            var link = e.getAttribute('data-href');
            var date = e.getAttribute('data-date');
            var student = e.getAttribute('data-student');
            var package = e.getAttribute('data-package');
            var coupon = e.getAttribute('data-coupon');
            var hours = e.getAttribute('data-hours');
            var price = e.getAttribute('data-price');

            var status = e.getAttribute('data-status');


            $('#ediModal form').attr('action', link);

            $('#ediModal [name=status]').val(status);

            $('#o_date').html(date);
            $('#o_name').html(student);
            $('#o_package').html(package);
            $('#o_hour').html(hours);
            $('#o_price').html(price);
            $('#o_coupon').html(coupon);

        }

        $('#addModal [name=expire]').daterangepicker({
            timePicker: true,
            singleDatePicker: true,
            locale: {
                format: 'DD-MM-YYYY hh:mm A'
            }
        });

        $('#kt_datatable').DataTable({
            columnDefs: [
                { orderable: false, "targets": [6] }//For Column Order
            ]
        });

    </script>
@endsection
