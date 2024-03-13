<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>{{$page_title??"Admin Panel Lakhpati"}}</title>

        <meta name="author" content="abdul hadi">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
        <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">

        @yield('css_before')
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
        <link rel="stylesheet" id="css-main" href="{{ mix('/css/oneui.css') }}">

        @yield('css_after')

        <script>window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};</script>
    </head>
    <body>
       
        <div id="page-container" class="sidebar-o enable-page-overlay sidebar-dark side-scroll page-header-fixed main-content-narrow">
            <aside id="side-overlay" class="fs-sm">
                <div class="content-header border-bottom">
                    <a class="img-link me-1" href="javascript:void(0)">
                        <img class="img-avatar img-avatar32" src="{{ asset('media/avatars/avatar10.jpg') }}" alt="">
                    </a>
                    <div class="ms-2">
                        <a class="text-dark fw-semibold fs-sm" href="javascript:void(0)">John Smith</a>
                    </div>
                    <a class="ms-auto btn btn-sm btn-alt-danger" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_close">
                        <i class="fa fa-fw fa-times"></i>
                    </a>
                </div>

                <div class="content-side">
                    <p>
                        Content..
                    </p>
                </div>
            </aside>
          
            @include('components.inc.dashboard-menu')
            @include('components.inc.dashboard-header')
            <main id="main-container">
                @yield('content')
            </main>
            @include('components.inc.dashboard-footer')
        </div>
        
        <script src="{{ mix('js/oneui.app.js') }}"></script>
        @yield('js_after')
    </body>
</html>
