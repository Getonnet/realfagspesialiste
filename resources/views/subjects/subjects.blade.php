@extends('layouts.master')
@extends('subjects.box.subjects')

@section('title')
    {{__('Subjects')}}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-6">
            <x-card title="{{__('Subject List')}}">
                @can('Subject Create')
                    <x-slot name="button">
                        <button class="btn btn-primary ml-1" data-toggle="modal" data-target="#addModal"><i class="flaticon2-add-1"></i> {{__('Add new record')}}</button>
                    </x-slot>
                @endcan
                <table class="table table-separate table-head-custom table-sm table-striped" id="kt_datatable">
                    <thead>
                    <tr>
                        <th>{{__('Name')}}</th>
                        <th class="text-right">{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($table as $row)
                        <tr>
                            <td>{{$row->name}}</td>
                            <td class="text-right">
                                <x-actions>
                                    @can('Subject Edit')
                                        <li class="navi-item">
                                            <a href="javascript:;" class="navi-link" data-toggle="modal" data-target="#ediModal" onclick="ediFn(this)"
                                               data-href="{{route('subjects.update', ['subject' => $row->id])}}"
                                               data-name="{{$row->name}}">
                                                <span class="navi-icon"><i class="la la-pencil-square-o text-success"></i></span>
                                                <span class="navi-text">{{__('Edit')}}</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('Subject Delete')
                                        <li class="navi-item">
                                            <a href="javascript:;" data-href="{{route('subjects.destroy', ['subject' => $row->id])}}" class="navi-link" onclick="delFn(this)">
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

            $('#ediModal form').attr('action', link);

            $('#ediModal [name=name]').val(name);
        }

        $('#kt_datatable').DataTable({
            order: [],//Disable default sorting
            language: {
                url: "{{asset('no.json')}}"
            },
            columnDefs: [
                { orderable: false, "targets": [1] }//For Column Order
            ]
        });
    </script>
@endsection
