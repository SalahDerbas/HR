<!--=================================
header start-->
<nav class="admin-header navbar navbar-default col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <!-- logo -->
    <div class="text-left navbar-brand-wrapper">
        <a class="navbar-brand brand-logo" href="{{ url('/dashboard') }}"><img src="{{ URL::asset('assets/images/Logo SD1.png') }}" alt=""></a>
        <a class="navbar-brand brand-logo-mini" href="{{ url('/dashboard') }}"><img src="{{ URL::asset('assets/images/Logo SD1.png') }}"
                alt=""></a>


    </div>
    <!-- Top bar left -->
    <ul class="nav navbar-nav mr-auto">
        <li class="nav-item">
            <a id="button-toggle" class="button-toggle-nav inline-block ml-20 pull-left"
                href="javascript:void(0);"><i class="zmdi zmdi-menu ti-align-right"></i></a>
        </li>
        <li class="nav-item">
            <div class="search">
                <a class="search-btn not_click" href="javascript:void(0);"></a>
                <div class="search-box not-click">
                    <input type="text" class="not-click form-control" placeholder="Search" value=""
                        name="search">
                    <button class="search-button" type="submit"> <i class="fa fa-search not-click"></i></button>
                </div>
            </div>
        </li>

        @can('Log_Viewer')
        <li class="nav-item">
            <a class="nav-link"  href="{{ route('logs') }}" target="_blank"  style="margin:9px;background-color:#f8f9fa;color:black;padding:14px;" role="button">
            {{trans('main_trans.Log_Viewer')}}
        </a>
        </li >
       @endcan

    </ul>
    <!-- top bar right -->
    <ul class="nav navbar-nav ml-auto">

        <div class="btn-group mb-1">
            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              @if (App::getLocale() == 'ar')
              {{ LaravelLocalization::getCurrentLocaleName() }}
             <img src="{{ URL::asset('assets/images/flags/EG.png') }}" alt="">
              @else
              {{ LaravelLocalization::getCurrentLocaleName() }}
              <img src="{{ URL::asset('assets/images/flags/US.png') }}" alt="">
              @endif
              </button>
            <div class="dropdown-menu">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            {{ $properties['native'] }}
                        </a>
                @endforeach
            </div>
        </div>

        <li class="nav-item fullscreen">
            <a id="btnFullscreen" href="#" class="nav-link"><i class="ti-fullscreen"></i></a>
        </li>
        <li class="nav-item dropdown ">
            <a class="nav-link top-nav" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                aria-expanded="false">
                <i class="ti-bell"></i>
                <span class="badge badge-danger notification-status"> </span>
            </a>

            @can('Notifications')


            <div class="dropdown-menu dropdown-menu-right dropdown-big dropdown-notifications">
                <div class="dropdown-header notifications">
                    <strong>{{trans('Sidebar_trans.Notifications')}}</strong>
                    <span class="badge badge-pill badge-warning">{{ Auth::user()->unreadnotifications->count() }}</span>
                </div>
                <div class="dropdown-divider"></div>
                @foreach(Auth::user()->unreadNotifications as $unreadnotification)
                <a href="{{ url('/') }}/readNotification/{{$unreadnotification->id}}" class="dropdown-item" style="background: #3baaa8; color: #fff !important;">
                        <i class="fa fa-envelope mr-2"></i> {{ $unreadnotification->data['data'] }}
                        <span class="float-right text-sm text-white">{{ date('Y-m-d', strtotime($unreadnotification->created_at )) }}</span>
                        <br>
                        <i class="fa fa-user"></i> &nbsp; {{ $unreadnotification->data['firstname'] }}
                        <div class="dropdown-divider"></div>
                    </a>
                @endforeach
                @foreach(Auth::user()->readNotifications as $readnotification)
                    <a href="#" class="dropdown-item">
                        <i class="fa fa-envelope mr-2"></i> {{ $readnotification->data['data'] }}
                        <span class="float-right text-sm text-dark">{{ date('Y-m-d', strtotime($readnotification->created_at )) }}</span>
                        <br>
                        <i class="fa fa-user"></i> &nbsp; {{ $readnotification->data['firstname'] }}
                    </a>
                    <div class="dropdown-divider"></div>
                @endforeach

            </div>

            @endcan
        </li>
        <li class="nav-item dropdown ">
            <a class="nav-link top-nav" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                aria-expanded="true"> <i class=" ti-view-grid"></i> </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-big">
                <div class="dropdown-header">
                    <strong>Quick Links</strong>
                </div>
                <div class="dropdown-divider"></div>
                <div class="nav-grid">
                    <a href="#" class="nav-grid-item"><i class="ti-files text-primary"></i>
                        <h5>New Task</h5>
                    </a>
                    <a href="#" class="nav-grid-item"><i class="ti-check-box text-success"></i>
                        <h5>Assign Task</h5>
                    </a>
                </div>
                <div class="nav-grid">
                    <a href="#" class="nav-grid-item"><i class="ti-pencil-alt text-warning"></i>
                        <h5>Add Orders</h5>
                    </a>
                    <a href="#" class="nav-grid-item"><i class="ti-truck text-danger "></i>
                        <h5>New Orders</h5>
                    </a>
                </div>
            </div>
        </li>
        <li class="nav-item dropdown mr-30">
            <a class="nav-link nav-pill user-avatar" data-toggle="dropdown" href="#" role="button"
                aria-haspopup="true" aria-expanded="false">
                <img src="{{ URL::asset('assets/images/user_icon.png') }}" alt="avatar">


            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header">
                    <div class="media">
                        <div class="media-body">
                            <h5 class="mt-0 mb-0">{{ Auth::user()->name }}</h5>
                            <span>{{ Auth::user()->email }}</span>
                        </div>
                    </div>
                </div>
                @can('Profile')
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('Dashboard.Users.getProfile')}}"><i class="text-warning ti-user"></i>{{ trans('main_trans.Profile')}}</a>
                @endcan
                <div class="dropdown-divider"></div>
                @can('Settings')
                <a class="dropdown-item" href="{{ route('Dashboard.Settings.index')}}"><i class="text-info ti-settings"></i>{{ trans('main_trans.Settings')}}</a>
                @endcan
                @can('Reset_Password')
                <div class="dropdown-divider"></div>
                <a href="{{ route('Dashboard.Users.resetPassword') }}" class="dropdown-item">
                    <i class="text-warning ti-user"></i> {{trans('main_trans.Reset_Password')}}
                </a>
                @endcan
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="text-danger ti-unlock"></i>{{ __('Sidebar_trans.Logout') }}</a>
                 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>

<!--=================================
header End-->
