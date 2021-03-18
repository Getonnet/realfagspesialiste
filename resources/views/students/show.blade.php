@extends('layouts.master')
@section('title')
    {{__('Student Info')}}
@endsection


@section('content')

    <div class="row">
        <div class="col">
            <x-card title="{{__('Student Info')}}">
                <x-slot name="button">
                    <a href="{{route('student.index')}}" class="btn btn-info ml-1" ><i class="flaticon2-left-arrow"></i> {{__('Back to student list')}}</a>
                </x-slot>

                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <img src="{{asset($table->profile_photo_path ?? 'assets/media/users/blank.png')}}" class="card-img-top" alt="{{$table->name}}">
                            <div class="card-body">
                                <h5 class="card-title text-center text-primary">{{$table->name}}</h5>
                                <table class="table">
                                    <tr>
                                        <th>{{__('Email')}}</th>
                                        <td>{{$table->email}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{__('Contact')}}</th>
                                        <td>{{$table->student->contact ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{__('City')}}</th>
                                        <td>{{$table->student->city ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{__('Zip')}}</th>
                                        <td>{{$table->student->zip ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{__('Address')}}</th>
                                        <td>{{$table->student->address ?? ''}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                This is some text within a card body.
                            </div>
                        </div>
                    </div>

                </div>

            </x-card>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection
