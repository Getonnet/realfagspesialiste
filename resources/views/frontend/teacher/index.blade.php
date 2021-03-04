@extends('layouts.general')

@section('title')
    {{__('My Dashboard')}}
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
                            <i class="flaticon-user text-danger"></i>
                        </span>
                            <h3 class="card-label">{{__('My Dashboard')}}</h3>
                        </div>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
                <!--end::Card-->

            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection
