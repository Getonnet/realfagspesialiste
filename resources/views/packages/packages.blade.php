@extends('layouts.master')
@extends('packages.box.packages')

@section('title')
    {{__('Package')}}
@endsection

@section('content')

    <div class="row">
        <div class="col">
            <x-card title="{{__('Package List')}}">
                @can('Package Create')
                    <x-slot name="button">
                        <button class="btn btn-primary ml-1" data-toggle="modal" data-target="#addModal"><i class="flaticon2-add-1"></i> Legg til ny timepakke</button>
                    </x-slot>
                @endcan
                <table class="table table-separate table-head-custom table-sm table-striped packages mobile-table" id="kt_datatable">
                    <thead>
                    <tr>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Hours')}}</th>
                        <th>{{__('Price')}}</th>
                        <th>{{__('Description')}}</th>
                        <th class="text-right">{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($table as $row)
                        <tr>
                            <td>{{$row->name}} <small class="text-danger">{{$row->isCoupon == true ? '*':''}}</small></td>
                            <td>{{$row->hours}}</td>
                            <td>{{$row->price}} kr</td>
                            <td>{{Str::limit($row->description, 25)}}</td>
                            <td class="text-right">
                                <x-actions>
                                    @can('Package Edit')
                                        <li class="navi-item">
                                            <a href="javascript:;" class="navi-link" data-toggle="modal" data-target="#ediModal" onclick="ediFn(this)"
                                               data-href="{{route('package.update', ['package' => $row->id])}}"
                                               data-name="{{$row->name}}"
                                                data-hours="{{$row->hours}}"
                                                data-price="{{$row->price}}"
                                                data-description="{{$row->description}}"
                                                data-expire="{{date('Y-m-d h:i A', strtotime($row->expire))}}"
                                                data-coupon="{{$row->isCoupon}}">
                                                <span class="navi-icon"><i class="la la-pencil-square-o text-success"></i></span>
                                                <span class="navi-text">{{__('Edit')}}</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('Package Delete')
                                        <li class="navi-item">
                                            <a href="javascript:;" data-href="{{route('package.destroy', ['package' => $row->id])}}" class="navi-link" onclick="delFn(this)">
                                                <span class="navi-icon"><i class="la la-trash-o text-danger"></i></span>
                                                <span class="navi-text">{{__('Delete')}}</span>
                                            </a>
                                        </li>
                                    @endcan
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
            var name = e.getAttribute('data-name');
            var hours = e.getAttribute('data-hours');
            var price = e.getAttribute('data-price');
            var description = e.getAttribute('data-description');
            var expire = e.getAttribute('data-expire');
            var coupon = e.getAttribute('data-coupon');


            $('#ediModal form').attr('action', link);

            $('#ediModal [name=name]').val(name);
            $('#ediModal [name=hours]').val(hours);
            $('#ediModal [name=price]').val(price);
            $('#ediModal [name=description]').val(description);

            if(coupon == 1){
                $('#checkCoupon').prop('checked', true);
            }else{
                $('#checkCoupon').prop('checked', false);
            }


            $('#ediModal [name=expire]').daterangepicker({
                timePicker: true,
                singleDatePicker: true,
                startDate: new Date(expire),
                locale: {
                    format: 'DD-MM-YYYY hh:mm A'
                }
            });

            $('#ediModal [name=expire]').val(expire);


        }

        $('#addModal [name=expire]').daterangepicker({
            timePicker: true,
            singleDatePicker: true,
            locale: {
                format: 'DD-MM-YYYY hh:mm A'
            }
        });

        $('#kt_datatable').DataTable({
            order: [],//Disable default sorting
            language: {
                url: "{{asset('no.json')}}"
            },
            columnDefs: [
                { orderable: false, "targets": [4] }//For Column Order
            ]
        });
    </script>
@endsection
