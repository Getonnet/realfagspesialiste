@extends('layouts.general')

@section('title')
    {{__('My Order')}}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">

                <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon-list-1 text-danger"></i>
                        </span>
                            <h3 class="card-label">{{__('My Order List')}}</h3>
                        </div>
                    </div>
                    <div class="card-body">

                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{__('Date')}}</th>
                                <th>{{__('Package Name')}}</th>
                                <th>{{__('Hours')}}</th>
                                <th>{{__('Price')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>Delbetaling</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($table as $row)
                                <tr>
                                    <td>{{date('d.M.Y', strtotime($row->created_at))}}</td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->hours}} <sup>Timer</sup></td>
                                    <td>{{$row->price}} <small>Kr</small></td>
                                    <td>{{__($row->status)}}</td>
                                    <td>{{$row->note}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
                <!--end::Card-->

            </div>
        </div>
    </div>

@endsection

