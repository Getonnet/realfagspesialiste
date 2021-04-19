<!--begin::Aside-->
<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
    <!--begin::Brand-->
    <div class="brand flex-column-auto" id="kt_brand">
        <!--begin::Logo-->
        <a href="" class="brand-logo">
            <img alt="Logo" src="{{asset('assets/media/logos/logo-light.png')}}" />
        </a>
        <!--end::Logo-->
        <!--begin::Toggle-->
        <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
            <span class="svg-icon svg-icon svg-icon-xl">
                <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
                        <path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>
        </button>
        <!--end::Toolbar-->
    </div>
    <!--end::Brand-->
    <!--begin::Aside Menu-->
    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
        <!--begin::Menu Container-->
        <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
            <!--begin::Menu Nav-->
            <ul class="menu-nav">

                <li class="menu-item {{request()->routeIs('admin.dashboard') ? 'menu-item-open menu-item-here' : ''}}" aria-haspopup="true">
                    <a href="{{route('admin.dashboard')}}" class="menu-link">
                        <i class="menu-icon flaticon-squares"></i>
                        <span class="menu-text">{{__('Dashboard')}}</span>
                    </a>
                </li>

                <!--Divider-->
                <li class="menu-section">
                    <h4 class="menu-text">{{__('Start')}}</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>
                <!--/Divider-->
                @can('Subject List')
                    <li class="menu-item {{request()->routeIs('subjects.index') ? 'menu-item-open menu-item-here' : ''}}" aria-haspopup="true">
                        <a href="{{route('subjects.index')}}" class="menu-link">
                            <i class="menu-icon flaticon2-open-text-book"></i>
                            <span class="menu-text">{{__('Subject')}}</span>
                        </a>
                    </li>
                @endcan
                @can('Package List')
                    <li class="menu-item {{request()->routeIs('package.index') ? 'menu-item-open menu-item-here' : ''}}" aria-haspopup="true">
                        <a href="{{route('package.index')}}" class="menu-link">
                            <i class="menu-icon flaticon2-box-1"></i>
                            <span class="menu-text">{{__('Packages')}}</span>
                        </a>
                    </li>
                @endcan
                @can('Purchase List')
                    <li class="menu-item {{request()->routeIs('orders.index') ? 'menu-item-open menu-item-here' : ''}}" aria-haspopup="true">
                        <a href="{{route('orders.index')}}" class="menu-link">
                            <i class="menu-icon flaticon-bag"></i>
                            <span class="menu-text">{{__('Purchase Order')}}</span>
                        </a>
                    </li>
                @endcan
                @can('Teacher List')
                    <li class="menu-item {{ (request()->is('admin/teacher*')) ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true">
                        <a href="{{route('teacher.index')}}" class="menu-link">
                            <i class="menu-icon flaticon-businesswoman"></i>
                            <span class="menu-text">{{__('Teachers')}}</span>
                        </a>
                    </li>
                @endcan
                @can('Student List')
                    <li class="menu-item {{ (request()->is('admin/student*')) ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true">
                        <a href="{{route('student.index')}}" class="menu-link">
                            <i class="menu-icon flaticon-customer"></i>
                            <span class="menu-text">{{__('Student2')}}</span>
                        </a>
                    </li>
                @endcan
                @canany(['User List', 'Role List'])
                    <li class="menu-item menu-item-submenu {{ (request()->is('admin/users*')) ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-icon flaticon2-user"></i>
                            <span class="menu-text">{{__('User')}}</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">{{__('User')}}</span>
                                    </span>
                                </li>
                                @can('User List')
                                    <li class="menu-item {{request()->routeIs('users.index') ? 'menu-item-active' : ''}}" aria-haspopup="true">
                                        <a href="{{route('users.index')}}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">{{__('User List')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('Role List')
                                    <li class="menu-item {{request()->routeIs('roles.index') ? 'menu-item-active' : ''}}" aria-haspopup="true">
                                        <a href="{{route('roles.index')}}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">{{__('User Role')}}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                @canany(['Reports General', 'Reports Time log'])
                    <li class="menu-item menu-item-submenu {{ (request()->is('admin/reports*')) ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-icon flaticon2-chart"></i>
                            <span class="menu-text">{{__('Reports')}}</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">{{__('Reports')}}</span>
                                    </span>
                                </li>
                                @can('Reports General')
                                    <li class="menu-item {{request()->routeIs('admin.reports') ? 'menu-item-active' : ''}}" aria-haspopup="true">
                                        <a href="{{route('admin.reports')}}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">{{__('General Reports')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('Reports Time log')
                                    <li class="menu-item {{request()->routeIs('admin.time') ? 'menu-item-active' : ''}}" aria-haspopup="true">
                                        <a href="{{route('admin.time')}}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">{{__('Time log Reports')}}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

            </ul>
            <!--end::Menu Nav-->
        </div>
        <!--end::Menu Container-->
    </div>
    <!--end::Aside Menu-->
</div>
<!--end::Aside-->
