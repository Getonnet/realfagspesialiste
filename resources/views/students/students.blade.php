@extends('layouts.master')
@extends('students.box.students')
@section('title')
    {{__('Students List')}}
@endsection


@section('content')

    <div class="row">
        <div class="col">
            <x-card title="{{__('Students List')}}">
                @can('Student Create')
                    <x-slot name="button">
                        <button class="btn btn-primary ml-1" data-toggle="modal" data-target="#addModal"><i class="flaticon2-add-1"></i> Legg til ny elev</button>
                    </x-slot>
                @endcan
                <table class="table table-separate table-head-custom table-sm table-striped students mobile-table" id="kt_datatable">
                    <thead>
                    <tr>
                        <th>{{__('Photo')}}</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Email')}}</th>
                        <th>{{__('Contact')}}</th>
                        <th>{{__('Hour')}}</th>
                        <th class="text-right">{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($table as $row)
                        @php

                            $hour = $row->purchase()->where('status', 'Active')->sum('hours');
                            $spends = $row->time_log()->where('status', 'End')->get();
                            $spend_times = 0;
                            foreach ($spends as $spend){
                                $spend_times += $spend->spend_time();
                            }
                            $hour_to_min = $hour * 60;
                            $remain_min = $hour_to_min - $spend_times;
                            $spend_hour = number_format(($remain_min / 60), 2, '.', ' ');

                        @endphp
                        <tr>
                            <td><img src="{{asset($row->profile_photo_path ?? 'assets/media/users/blank.png')}}" style="height: 30px;" class="img-fluid img-thumbnail" /></td>
                            <td>{{$row->name}}</td>
                            <td>{{$row->email}}</td>
                            <td>{{$row->student->contact ?? ''}}</td>
                            <td data-sort="{{$spend_hour}}">{{$spend_hour}} {{__('Hr')}}</td>
                            <td class="text-right">
                                <x-actions>
                                    @can('Student Edit')
                                        <li class="navi-item">
                                            <a href="javascript:;" class="navi-link" data-toggle="modal" data-target="#ediModal" onclick="ediFn(this)"
                                               data-href="{{route('student.update', ['student' => $row->id])}}"
                                               data-name="{{$row->name}}"
                                               data-email="{{$row->email}}"
                                               data-contact="{{$row->student->contact ?? ''}}"
                                               data-address="{{$row->student->address ?? ''}}"
                                               data-city="{{$row->student->city ?? ''}}"
                                               data-zip="{{$row->student->zip ?? ''}}"
                                               data-photo="{{asset($row->profile_photo_path ?? 'assets/media/users/blank.png')}}">
                                                <span class="navi-icon"><i class="la la-pencil-square-o text-success"></i></span>
                                                <span class="navi-text">{{__('Edit')}}</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('Student View')
                                        <li class="navi-item">
                                            <a href="{{route('student.show', ['student' => $row->id])}}" class="navi-link">
                                                <span class="navi-icon"><i class="la la-eye text-info"></i></span>
                                                <span class="navi-text">{{__('Show')}}</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('Student Delete')
                                        <li class="navi-item">
                                            <a href="javascript:;" data-href="{{route('student.destroy', ['student' => $row->id])}}" class="navi-link" onclick="delFn(this)">
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
            var email = e.getAttribute('data-email');
            var contact = e.getAttribute('data-contact');
            var address = e.getAttribute('data-address');
            var zip = e.getAttribute('data-zip');
            var city = e.getAttribute('data-city');
            var photo = e.getAttribute('data-photo');

            $('#ediModal form').attr('action', link);

            $('#ediModal [name=name]').val(name);
            $('#ediModal [name=email]').val(email);
            $('#ediModal [name=contact]').val(contact);
            $('#ediModal [name=address]').val(address);
            $('#ediModal [name=zip]').val(zip);
            $('#ediModal [name=city]').val(city);

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
                { orderable: false, "targets": [5] }//For Column Order
            ]
        });
    </script>
@endsection
