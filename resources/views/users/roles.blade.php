@extends('layouts.master')

@section('title')
    {{__('User Roles')}}
@endsection

@section('page')
    <x-subheader title="{{__('User Roles')}}">
        <button class="btn btn-light-primary font-weight-bolder btn-sm ml-1">{{__('Action')}}</button>
    </x-subheader>
@endsection

@section('content')
    User Roles
@endsection