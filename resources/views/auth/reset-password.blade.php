@extends('layouts.app')

@section('content')

    <!--begin::Signin-->
    <div class="login-form">
        <form method="POST" class="form" id="kt_login_forgot_form" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <!--begin::Title-->
            <div class="pb-5 pb-lg-15">
                <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">{{ __('Password Reset') }}?</h3>
                <p class="text-muted font-weight-bold font-size-h4">{{ __('Enter your new password') }}</p>
            </div>
            <!--end::Title-->
            <!--begin::Form group-->
            <div class="form-group">
                <x-jet-label for="email" class="font-size-h6 font-weight-bolder text-dark" req="true" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="form-control-solid h-auto py-7 px-6 rounded-lg border-0" type="email" name="email" value="{{old('email', $request->email)}}" required autofocus />
                @if ($errors->has('email'))
                    <span class="form-text text-danger">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <!--end::Form group-->
            <!--begin::Form group-->
            <div class="form-group">
                <x-jet-label for="password" class="font-size-h6 font-weight-bolder text-dark" req="true" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="form-control-solid h-auto py-7 px-6 rounded-lg border-0" type="password" name="password" required autocomplete="new-password" />
                @if ($errors->has('password'))
                    <span class="form-text text-danger">{{ $errors->first('password') }}</span>
                @endif
            </div>
            <!--end::Form group-->

            <!--begin::Form group-->
            <div class="form-group">
                <x-jet-label for="password_confirmation" class="font-size-h6 font-weight-bolder text-dark" req="true" value="{{ __('Password Confirmation') }}" />
                <x-jet-input id="password_confirmation" class="form-control-solid h-auto py-7 px-6 rounded-lg border-0" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>
            <!--end::Form group-->
            <!--begin::Form group-->
            <div class="form-group d-flex flex-wrap">
                <button type="submit" id="kt_login_forgot_form_submit_button" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">
                    {{__('Reset Password')}}</button>
            </div>
            <!--end::Form group-->
        </form>
    </div>
    <!--end::Signin-->

@endsection


{{--<x-guest-layout>--}}
{{--    <x-jet-authentication-card>--}}
{{--        <x-slot name="logo">--}}
{{--            <x-jet-authentication-card-logo />--}}
{{--        </x-slot>--}}

{{--        <x-jet-validation-errors class="mb-4" />--}}

{{--        <form method="POST" action="{{ route('password.update') }}">--}}
{{--            @csrf--}}

{{--            <input type="hidden" name="token" value="{{ $request->route('token') }}">--}}

{{--            <div class="block">--}}
{{--                <x-jet-label for="email" value="{{ __('Email') }}" />--}}
{{--                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />--}}
{{--            </div>--}}

{{--            <div class="mt-4">--}}
{{--                <x-jet-label for="password" value="{{ __('Password') }}" />--}}
{{--                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />--}}
{{--            </div>--}}

{{--            <div class="mt-4">--}}
{{--                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />--}}
{{--                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />--}}
{{--            </div>--}}

{{--            <div class="flex items-center justify-end mt-4">--}}
{{--                <x-jet-button>--}}
{{--                    {{ __('Reset Password') }}--}}
{{--                </x-jet-button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </x-jet-authentication-card>--}}
{{--</x-guest-layout>--}}
