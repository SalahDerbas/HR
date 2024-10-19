@include('Website.layouts.app')


<head>
    @include('Website.layouts.head')
</head>

<body>

    @include('Website.layouts.main-header')


    @yield('content')


    @include('Website.layouts.footer')

    @include('Website.layouts.footer-scripts')

</body>

</html>
