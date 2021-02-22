@extends('layouts.master')

@section('title')
    {{__('Roles')}}
@endsection

@section('page')
    <x-subheader title="{{__('Roles')}}">
        <button class="btn btn-light-primary font-weight-bolder btn-sm ml-1">{{__('Action')}}</button>
    </x-subheader>
@endsection

@section('content')
    Roles
@endsection