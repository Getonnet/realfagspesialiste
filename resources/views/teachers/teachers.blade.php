@extends('layouts.master')
@extends('students.box.students')
@section('title')
    {{__('Teacher List')}}
@endsection


@section('content')

    <div class="row">
        <div class="col">
            <x-card title="{{__('Teacher List')}}">
                <table class="table table-separate table-head-custom table-sm table-striped" id="kt_datatable">
                    <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Hour</th>
                        <th class="text-right">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($table as $row)
                        @php

                            $hour = $row->purchase()->where('status', 'Active')->sum('hours');

                        @endphp
                        <tr>
                            <td><img src="{{asset($row->profile_photo_path ?? 'assets/media/users/blank.png')}}" style="height: 30px;" class="img-fluid img-thumbnail" /></td>
                            <td>{{$row->name}}</td>
                            <td>{{$row->email}}</td>
                            <td>{{$row->student->contact ?? ''}}</td>
                            <td>{{$hour}}</td>
                            <td class="text-right">
                                <x-actions>

                                    <li class="navi-item">
                                        <a href="javascript:;" class="navi-link" data-toggle="modal" data-target="#ediModal" onclick="ediFn(this)"
                                           data-href="{{route('subjects.update', ['subject' => $row->id])}}"
                                           data-name="{{$row->name}}">
                                            <span class="navi-icon"><i class="la la-pencil-square-o text-success"></i></span>
                                            <span class="navi-text">{{__('Edit')}}</span>
                                        </a>
                                    </li>

                                    <li class="navi-item">
                                        <a href="javascript:;" data-href="{{route('subjects.destroy', ['subject' => $row->id])}}" class="navi-link" onclick="delFn(this)">
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
            var name = e.getAttribute('data-name');

            $('#ediModal form').attr('action', link);

            $('#ediModal [name=name]').val(name);
        }

        $('#kt_datatable').DataTable({
            columnDefs: [
                { orderable: false, "targets": [5] }//For Column Order
            ]
        });
    </script>
@endsection