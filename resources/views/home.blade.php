@extends('layouts.master')

@section('title')
    {{__('Dashboard')}}
@endsection

@section('page')
    <x-subheader title="{{__('Dashboard')}}">
        <button class="btn btn-light-primary font-weight-bolder btn-sm ml-1">{{__('Action')}}</button>
    </x-subheader>
@endsection

@section('content')
    Dashboard
@endsection