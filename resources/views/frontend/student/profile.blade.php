@extends('layouts.general')

@section('title')
    {{__('My Profile')}}
@endsection

@section('content')
    <div class="row">
        <div class="col">

            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
                <!--begin::Container-->
                <div class="container">
                    <!--begin::Profile Personal Information-->
                    <div class="d-flex flex-row">
                        <!--begin::Aside-->
                        <div class="flex-row-auto offcanvas-mobile w-250px w-xxl-350px" id="kt_profile_aside">
                            <!--begin::Profile Card-->
                            <div class="card card-custom card-stretch">
                                <!--begin::Body-->
                                <div class="card-body pt-4">
                                    <!--begin::User-->
                                    <div class="d-flex align-items-center">
                                        <img class="img-thumbnail" src="{{asset($table->profile_photo_path ?? 'assets/media/users/blank.png')}}">
                                    </div>
                                    <!--end::User-->
                                    <!--begin::Contact-->
                                    <div class="py-9">
                                        <div>
                                            <h1 class="text-center text-primary">{{$table->name}}</h1>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <span class="font-weight-bold mr-2 text-hover-primary">{{__('Email')}}:</span>
                                            <span class="text-muted text-hover-primary">{{$table->email}}</span>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <span class="font-weight-bold mr-2 text-hover-primary">{{__('Contact')}}:</span>
                                            <span class="text-muted text-hover-primary">{{$table->student->contact ?? ''}}</span>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <span class="font-weight-bold mr-2 text-hover-primary">{{__('City')}}:</span>
                                            <span class="text-muted text-hover-primary">{{$table->student->city ?? ''}}</span>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <span class="font-weight-bold mr-2 text-hover-primary">{{__('Zip Code')}}:</span>
                                            <span class="text-muted text-hover-primary">{{$table->student->zip ?? ''}}</span>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="font-weight-bold mr-2 text-hover-primary">{{__('Address')}}:</span>
                                            <span class="text-muted text-hover-primary">{{$table->student->address ?? ''}}</span>
                                        </div>
                                    </div>
                                    <!--end::Contact-->
                                    <hr />
                                    <!--Hour Calculation -->
                                    @php

                                        $hour = $table->purchase()->where('status', 'Active')->sum('hours');

                                    @endphp
                                    <h1 class="text-center text-danger" style="font-size: 70px;">{{$hour}}<sup>hr</sup></h1>
                                    <!--/Hour Calculation -->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Profile Card-->
                        </div>
                        <!--end::Aside-->
                        <!--begin::Content-->
                        <div class="flex-row-fluid ml-lg-8">
                            <!--begin::Card-->
                            <form action="{{route('update.myprofile', ['id' => $table->id])}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="card card-custom card-stretch">
                                <!--begin::Header-->
                                <div class="card-header py-3">
                                    <div class="card-title align-items-start flex-column">
                                        <h3 class="card-label font-weight-bolder text-dark">{{__('Personal Information')}}</h3>
                                        <span class="text-muted font-weight-bold font-size-sm mt-1">{{__('Update your personal information')}}</span>
                                    </div>
                                    <div class="card-toolbar">
                                        <button type="submit" class="btn btn-success mr-2">{{__('Update Changes')}}</button>
                                    </div>
                                </div>
                                <!--end::Header-->
                                <!--begin::Form-->
                                <form class="form">
                                    <!--begin::Body-->
                                    <div class="card-body">
                                        <div class="row">
                                            <label class="col-xl-3"></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <h5 class="font-weight-bold mb-6">{{__('Account Info')}}</h5>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('Avatar')}}</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <x-uploadprofile name="photo" id="profile_photo" />
                                                <span class="form-text text-muted">{{__('Allowed file types: png, jpg, jpeg.')}}</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('Name')}} <small class="text-danger">*</small></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input class="form-control form-control-lg form-control-solid" name="name" type="text" value="{{$table->name}}" required />
                                                @error('name')
                                                <span class="form-text text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('Email')}} <small class="text-danger">*</small></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input class="form-control form-control-lg form-control-solid" name="email" type="email" value="{{$table->email}}" readonly />
                                                @error('email')
                                                <span class="form-text text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('Password')}}</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input class="form-control form-control-lg form-control-solid" name="password" type="password"/>
                                                @error('password')
                                                <span class="form-text text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('Confirm Password')}}</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input class="form-control form-control-lg form-control-solid" name="password_confirmation" type="password" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-xl-3"></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <h5 class="font-weight-bold mt-10 mb-6">{{__('Contact Info')}}</h5>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('Contact')}} <small class="text-danger">*</small></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input class="form-control form-control-lg form-control-solid" name="contact" type="text" value="{{$table->student->contact ?? ''}}" required />
                                                @error('contact')
                                                <span class="form-text text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('City')}} <small class="text-danger">*</small></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input class="form-control form-control-lg form-control-solid" name="city" type="text" value="{{$table->student->city ?? ''}}" required />
                                                @error('city')
                                                <span class="form-text text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('Zip')}} <small class="text-danger">*</small></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input class="form-control form-control-lg form-control-solid" name="zip" type="text" value="{{$table->student->zip ?? ''}}" required />
                                                @error('zip')
                                                <span class="form-text text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('Address')}} <small class="text-danger">*</small></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input class="form-control form-control-lg form-control-solid" name="address" type="text" value="{{$table->student->address ?? ''}}" required />
                                                @error('address')
                                                <span class="form-text text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <!--end::Body-->
                                </form>
                                <!--end::Form-->
                            </div>
                            </form>
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Profile Personal Information-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Entry-->

        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('.profile_photo').css('background-image', 'url("{{asset($table->profile_photo_path ?? 'assets/media/users/blank.png')}}")');
        new KTImageInput('profile_photo');
    </script>
@endsection

