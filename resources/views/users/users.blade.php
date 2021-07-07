@extends('layouts.master')
@extends('users.box.users')

@section('title')
    {{__('Users')}}
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <x-card title="{{__('User List')}}">
                @can('User Create')
                <x-slot name="button">
                    <button class="btn btn-primary ml-1" data-toggle="modal" data-target="#addModal"><i class="flaticon2-add-1"></i> Legg til ny bruker</button>
                </x-slot>
                @endcan
                <table class="table table-separate table-head-custom table-sm table-striped users mobile-table" id="kt_datatable">
                    <thead>
                    <tr>
                        <th>{{__('Photo')}}</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Email')}}</th>
                        <th>{{__('User Role')}}</th>
                        <th class="text-right">{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($table as $row)
                            @php
                                $role = $row->getRoleNames()->first();
                                if($role != null){
                                    $role_id = $row->roles()->first()->id;
                                }
                            @endphp
                        <tr>
                            <td><img src="{{asset($row->profile_photo_path ?? 'assets/media/users/blank.png')}}" style="height: 30px;" class="img-fluid img-thumbnail" /></td>
                            <td>{{$row->name}}</td>
                            <td>{{$row->email}}</td>
                            <td>{{$role ?? ''}}</td>
                            <td class="text-right">
                                <x-actions>
                                    @can('User Edit')
                                        <li class="navi-item">
                                            <a href="javascript:;" class="navi-link" data-toggle="modal" data-target="#ediModal" onclick="ediFn(this)"
                                                data-href="{{route('users.update', ['user' => $row->id])}}"
                                                data-name="{{$row->name}}"
                                                data-email="{{$row->email}}"
                                                data-role="{{$role_id ?? ''}}"
                                                data-photo="{{asset($row->profile_photo_path ?? 'assets/media/users/blank.png')}}"
                                            >
                                                <span class="navi-icon"><i class="la la-pencil-square-o text-success"></i></span>
                                                <span class="navi-text">{{__('Edit')}}</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('User Delete')
                                        <li class="navi-item">
                                            <a href="javascript:;" data-href="{{route('users.destroy', ['user' => $row->id])}}" class="navi-link" onclick="delFn(this)">
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

      //  $('.select2').select2();

        function ediFn(e){
            var link = e.getAttribute('data-href');

            var email = e.getAttribute('data-email');
            var name = e.getAttribute('data-name');
            var photo = e.getAttribute('data-photo');
            var role_id = e.getAttribute('data-role');

            $('#ediModal form').attr('action', link);

            $('#ediModal [name=name]').val(name);
            $('#ediModal [name=email]').val(email);
            $('#ediModal [name=role_id]').val(role_id);

            $('#ediModal .ediprofile_photo').css('background-image', 'url("' + photo + '")');
        }

        new KTImageInput('profile_photo');
        new KTImageInput('ediprofile_photo');

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
