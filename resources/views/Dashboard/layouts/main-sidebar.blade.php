<div class="container-fluid">
    <div class="row">
        <!-- Left Sidebar start-->
        <div class="side-menu-fixed">
            <div class="scrollbar side-menu-bg" style="overflow: scroll">
                <ul class="nav navbar-nav side-menu" id="sidebarnav">
                    <!-- menu item Dashboard-->
                    <li>
                        <a href="{{ url('/dashboard') }}">
                            <div class="pull-left"><i class="ti-home"></i><span class="right-nav-text">{{trans('main_trans.Dashboard')}}</span>
                            </div>
                            <div class="clearfix"></div>
                        </a>
                    </li>
                    <!-- menu title -->
                    <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">{{trans('main_trans.Programname')}} </li>

                    @can('List_Users')
                    <!-- Users-->
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#Users-icon">
                            <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text">{{trans('main_trans.Users')}}</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="Users-icon" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="{{ route('Dashboard.Users.index') }}">{{ trans('main_trans.Users')}}</a> </li>
                        </ul>
                    </li>
                    @endcan
                    @can('Settings')
                    <!-- Settings-->
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#Settings-icon">
                            <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text">{{trans('main_trans.Settings')}}</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="Settings-icon" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="{{ route('Dashboard.Settings.index') }}">{{ trans('main_trans.Settings')}}</a> </li>
                        </ul>
                    </li>
                    @endcan

                    @can('Roles_and_Permissions')
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#Roles_and_Permissions-icon">
                            <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text">{{trans('main_trans.Roles_and_Permissions')}}</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="Roles_and_Permissions-icon" class="collapse" data-parent="#sidebarnav">
                        @can('List_Roles')
                        <li> <a href="{{ route('Roles.index') }}">{{ trans('main_trans.Roles')}}</a> </li>
                        @endcan
                        @can('List_Permissions')
                        <li> <a href="{{ route('permissions') }}">{{ trans('main_trans.Permissions')}}</a> </li>
                        @endcan
                        </ul>
                    </li>
                @endcan



                    @can('List_Push_Notifications')
                    <!-- Push Notifications -->
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#PushNotifications-icon">
                            <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text">{{trans('main_trans.PushNotifications')}}</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="PushNotifications-icon" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="{{ route('Dashboard.PushNotification.index') }}">{{ trans('main_trans.PushNotifications')}}</a> </li>
                        </ul>
                    </li>
                    @endcan
                    @can('Reports')
                    <!-- Reports -->
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#Reports-icon">
                            <div class="pull-left"><i class="fas fa-book"></i><span class="right-nav-text">{{trans('main_trans.Reports')}}</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="Reports-icon" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="{{ route('Dashboard.Reports.index') }}">{{ trans('main_trans.Reports')}}</a> </li>
                        </ul>
                    </li>
                    @endcan
                </ul>
            </div>
        </div>

        <!-- Left Sidebar End-->

        <!--=================================
