@extends('layouts.master')

@section('title')
    {{__('Access Denied')}}
@endsection

@section('content')
    <div class="row">

        <div class="col">
            <h1 class="text-center">{{__('Access Denied')}}!!</h1>
            <h3 class="text-center">{{__('Please contact with Super Admin')}}</h3>
        </div>

    </div>
@endsection
