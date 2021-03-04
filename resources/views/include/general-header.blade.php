<!--begin::Header-->
<div id="kt_header" class="header header-fixed">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <!--begin::Header Menu Wrapper-->
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
            <!--begin::Header Logo-->
            <div class="header-logo">
                <a href="">
                    <img alt="Logo" src="{{asset('assets/media/logos/logo-dark.png')}}" />
                </a>
            </div>
            <!--end::Header Logo-->
            <!--begin::Header Menu-->
            <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                <!--begin::Header Nav-->
                <ul class="menu-nav">
                    @if(auth()->check() && auth()->user()->user_type == 'Student')
                        <li class="menu-item menu-item-rel {{request()->routeIs('student.package') ? 'menu-item-active':''}}">
                            <a href="{{route('student.dashboard')}}" class="menu-link">
                                <span class="menu-text">{{__('Package')}}</span>
                            </a>
                        </li>

                        <li class="menu-item menu-item-rel {{request()->routeIs('order.list') ? 'menu-item-active':''}}">
                            <a href="{{route('order.list')}}" class="menu-link">
                                <span class="menu-text">{{__('Order List')}}</span>
                            </a>
                        </li>

                        <li class="menu-item menu-item-rel {{request()->routeIs('my.profile') ? 'menu-item-active':''}}">
                            <a href="{{route('my.profile')}}" class="menu-link">
                                <span class="menu-text">{{__('Profile')}}</span>
                            </a>
                        </li>

                        <li class="menu-item menu-item-rel {{request()->routeIs('my.reports') ? 'menu-item-active':''}}">
                            <a href="{{route('my.reports')}}" class="menu-link">
                                <span class="menu-text">{{__('Reports')}}</span>
                            </a>
                        </li>
                    @endif

                    @if(auth()->check() && auth()->user()->user_type == 'Teacher')
                        <li class="menu-item menu-item-rel {{request()->routeIs('teacher.home') ? 'menu-item-active':''}}">
                            <a href="{{route('teacher.home')}}" class="menu-link">
                                <span class="menu-text">{{__('Dashboard')}}</span>
                            </a>
                        </li>
                    @endif

                </ul>
                <!--end::Header Nav-->
            </div>
            <!--end::Header Menu-->
        </div>
        <!--end::Header Menu Wrapper-->
        <!--begin::Topbar-->
        <div class="topbar">
        @if(auth()->check())
            <!--begin::User-->
                <div class="topbar-item">
                    <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                        <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
                        <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{auth()->check() ? auth()->user()->name : 'User name'}}</span>
                        <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                        <span class="symbol-label font-size-h5 font-weight-bold">S</span>
                    </span>
                    </div>
                </div>
            <!--end::User-->
            @else
                <div class="topbar-item">
                    <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2">
                        <a href="{{route('register')}}" class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3"><i class="flaticon2-user-1"></i> {{__('Register')}}</a>
                    </div>
                </div>
                <div class="topbar-item">
                    <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2">
                        <a href="{{route('login')}}" class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3"><i class="flaticon2-user"></i> {{__('Login')}}</a>
                    </div>
                </div>
            @endif
        </div>
        <!--end::Topbar-->
    </div>
    <!--end::Container-->
</div>
<!--end::Header-->
