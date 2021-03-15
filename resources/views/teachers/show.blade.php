@extends('layouts.master')
@section('title')
    {{__('Teacher Info')}}
@endsection


@section('content')

    <div class="row">
        <div class="col">
            <x-card title="{{__('Teacher Info')}}">
                <x-slot name="button">
                    <a href="{{route('teacher.index')}}" class="btn btn-info ml-1" ><i class="flaticon2-left-arrow"></i> {{__('Back to teacher list')}}</a>
                </x-slot>
            </x-card>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection
