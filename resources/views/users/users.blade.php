@extends('layouts.master')

@section('title')
    {{__('User')}}
@endsection

@section('page')
    <x-subheader title="{{__('User List')}}">
        <button class="btn btn-light-primary font-weight-bolder btn-sm ml-1">{{__('Action')}}</button>
    </x-subheader>
@endsection

@section('content')
    User
@endsection