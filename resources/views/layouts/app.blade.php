<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <style>
        .dropdown-container {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            display: none;
            float: left;
            min-width: 200px;
            max-width: 330px;
            margin: 2px 0 0;
            list-style: none;
            font-size: 14px;
            background-color: #fff;
            border: 1px solid #ccc;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 4px;
            -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
            background-clip: padding-box
        }

        .dropdown-container > .dropdown-menu {
            position: static;
            z-index: 1000;
            float: none !important;
            padding: 10px 0;
            margin: 0;
            border: 0;
            background: transparent;
            border-radius: 0;
            -webkit-box-shadow: none;
            box-shadow: none;
            max-height: 330px;
            overflow-y: auto
        }

        .dropdown-container > .dropdown-menu + .dropdown-menu {
            padding-top: 0
        }

        .dropdown-menu > li > a {
            overflow: hidden;
            white-space: nowrap;
            word-wrap: normal;
            text-decoration: none;
            text-overflow: ellipsis;
            -o-text-overflow: ellipsis;
            -webkit-transition: none;
            -o-transition: none;
            transition: none
        }

        .dropdown-toggle {
            cursor: pointer
        }

        .dropdown-header {
            white-space: nowrap
        }

        .open > .dropdown-container > .dropdown-menu, .open > .dropdown-container {
            display: block
        }

        .dropdown-toolbar {
            padding-top: 6px;
            padding-left: 20px;
            padding-right: 20px;
            padding-bottom: 5px;
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 4px 4px 0 0
        }

        .dropdown-toolbar > .form-group {
            margin: 5px -10px
        }

        .dropdown-toolbar .dropdown-toolbar-actions {
            float: right
        }

        .dropdown-toolbar .dropdown-toolbar-title {
            margin: 0;
            font-size: 14px
        }

        .dropdown-footer {
            padding: 5px 20px;
            border-top: 1px solid #ccc;
            border-top: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 0 0 4px 4px
        }

        .anchor-block small {
            display: none
        }

        @media (min-width: 992px) {
            .anchor-block small {
                display: block;
                font-weight: normal;
                color: #777777
            }

            .dropdown-menu > li > a.anchor-block {
                padding-top: 6px;
                padding-bottom: 6px
            }
        }

        @media (min-width: 992px) {
            .dropdown.hoverable:hover > ul {
                display: block
            }
        }

        .dropdown-position-topright {
            top: auto;
            right: 0;
            bottom: 100%;
            left: auto;
            margin-bottom: 2px
        }

        .dropdown-position-topleft {
            top: auto;
            right: auto;
            bottom: 100%;
            left: 0;
            margin-bottom: 2px
        }

        .dropdown-position-bottomright {
            right: 0;
            left: auto
        }

        .dropmenu-item-label {
            white-space: nowrap
        }

        .dropmenu-item-content {
            position: absolute;
            text-align: right;
            max-width: 60px;
            right: 20px;
            color: #777777;
            overflow: hidden;
            white-space: nowrap;
            word-wrap: normal;
            -o-text-overflow: ellipsis;
            text-overflow: ellipsis
        }

        small.dropmenu-item-content {
            line-height: 20px
        }

        .dropdown-menu > li > a.dropmenu-item {
            position: relative;
            padding-right: 66px
        }

        .dropdown-submenu .dropmenu-item-content {
            right: 40px
        }

        .dropdown-menu > li.dropdown-submenu > a.dropmenu-item {
            padding-right: 86px
        }

        .dropdown-inverse .dropdown-menu {
            background-color: rgba(0, 0, 0, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.9)
        }

        .dropdown-inverse .dropdown-menu .divider {
            height: 1px;
            margin: 9px 0;
            overflow: hidden;
            background-color: #2b2b2b
        }

        .dropdown-inverse .dropdown-menu > li > a {
            color: #cccccc
        }

        .dropdown-inverse .dropdown-menu > li > a:hover, .dropdown-inverse .dropdown-menu > li > a:focus {
            color: #fff;
            background-color: #262626
        }

        .dropdown-inverse .dropdown-menu > .active > a, .dropdown-inverse .dropdown-menu > .active > a:hover, .dropdown-inverse .dropdown-menu > .active > a:focus {
            color: #fff;
            background-color: #337ab7
        }

        .dropdown-inverse .dropdown-menu > .disabled > a, .dropdown-inverse .dropdown-menu > .disabled > a:hover, .dropdown-inverse .dropdown-menu > .disabled > a:focus {
            color: #777777
        }

        .dropdown-inverse .dropdown-header {
            color: #777777
        }

        .table > thead > tr > th.col-actions {
            padding-top: 0;
            padding-bottom: 0
        }

        .table > thead > tr > th.col-actions .dropdown-toggle {
            color: #777777
        }

        .notifications {
            list-style: none;
            padding: 0
        }

        .notification {
            display: block;
            padding: 9.6px 12px;
            border-bottom: 1px solid #eeeeee;
            color: #333333;
            text-decoration: none
        }

        .notification:last-child {
            border-bottom: 0
        }

        .notification:hover, .notification.active:hover {
            background-color: #f9f9f9
        }

        .notification.active {
            background-color: #f4f4f4
        }

        .notification-title {
            font-size: 15px;
            margin-bottom: 0
        }

        .notification-desc {
            margin-bottom: 0
        }

        .notification-meta {
            color: #777777
        }

        a.notification:hover {
            text-decoration: none
        }

        .dropdown-notifications > .dropdown-container, .dropdown-notifications > .dropdown-menu {
            width: 450px;
            max-width: 450px
        }

        .dropdown-notifications .dropdown-menu {
            padding: 0
        }

        .dropdown-notifications .dropdown-toolbar, .dropdown-notifications .dropdown-footer {
            padding: 9.6px 12px
        }

        .dropdown-notifications .dropdown-toolbar {
            background: #fff
        }

        .dropdown-notifications .dropdown-footer {
            background: #eeeeee
        }

        .notification-icon {
            margin-right: 6.8775px
        }

        .notification-icon:after {
            position: absolute;
            content: attr(data-count);
            margin-left: -6.8775px;
            margin-top: -6.8775px;
            padding: 0 4px;
            min-width: 13.755px;
            height: 13.755px;
            line-height: 13.755px;
            background: red;
            border-radius: 10px;
            color: #fff;
            text-align: center;
            vertical-align: middle;
            font-size: 11.004px;
            font-weight: 600;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif
        }

        .notification .media-body {
            padding-top: 5.6px
        }

        .btn-lg .notification-icon:after {
            margin-left: -8.253px;
            margin-top: -8.253px;
            min-width: 16.506px;
            height: 16.506px;
            line-height: 16.506px;
            font-size: 13.755px
        }

        .btn-xs .notification-icon:after {
            content: '';
            margin-left: -4.1265px;
            margin-top: -2.06325px;
            min-width: 6.25227273px;
            height: 6.25227273px;
            line-height: 6.25227273px;
            padding: 0
        }

        .btn-xs .notification-icon {
            margin-right: 3.43875px
        }
    </style>

    @vite(['resources/css/app.css'])
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    @auth()
        @include('includes.header')
        <!--Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            @include('includes.sidebar')
        </aside>
    @endauth
</div>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    @if(session()->has('error'))
        <div class="alert text-center alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{session('error')}}
        </div>
    @endif
    @if(session()->has('success'))
        <div class="alert text-center alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{session('success')}}
        </div>
    @endif
    <section class="content" id="main-div">
        @yield('content')
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer text-center">
    <strong>Copyright &copy; 2022</strong>
    All rights reserved.
    <div class="">
    </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('dist/js/pages/dashboard.js')}}"></script>
{{--<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>--}}
<script type="text/javascript"
        src="https://cdn.jsdelivr.net/gh/geocodezip/geoxml3@a07796fa205d9d40a3c6f898a44324245935984f/polys/geoxml3.js"></script>

{{--<script--}}
{{--    src="https://maps.googleapis.com/maps/api/directions/json?origin=Disneyland&destination=Universal+Studios+Hollywood&key=AIzaSyAqhA7SPufeqSZ3Z5gVJGip3rkKvQo6nUs"--}}
{{--></script>--}}
<script defer type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-uyEouBWzcIFx-183J0W3N_Qu-5xk1s4&callback=initMap"></script>
<script src="{{asset('js/app.js')}}"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

@yield('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        var notificationsWrapper = $('.notif-container');
        var notificationsToggle = notificationsWrapper.find('a[data-toggle]');
        var notificationsCountElem = notificationsToggle.find('i[data-count]');
        var notificationsCount = parseInt(notificationsCountElem.data('count'));
        var notifications = notificationsWrapper.find('ul.dropdown-menu');

        console.log(notificationsCount);
        // if (notificationsCount <= 0) {
        //     notificationsWrapper.hide();
        // }

        var pusher = new Pusher('5d0580b8299de37c3e86', {
            // encrypted: true
            cluster: 'eu'
        });

        // Subscribe to the channel we specified in our Laravel Event
        var channel = pusher.subscribe('new-orders');

        // Bind a function to a Event (the full Laravel class)
        channel.bind('order-created', function (data) {
            var date_value = moment(data.order.updated_at).format('h:mm');
            var order_link = '/orders/' + data.order.id + '/edit';
            var existingNotifications = notifications.html();
            // var avatar = Math.floor(Math.random() * (71 - 20 + 1)) + 20;
            var newNotificationHtml = `
          <li class="notification active">
              <div class="media">
                <div class="media-body">
                  <strong class="notification-title">` + 'Ունենք նոր պատվեր' + `</strong>
                  <div class="notification-meta">
                    <small class="timestamp">Ժամը ֊ ${date_value}</small>
                  </div>
                </div>
              </div>
             <a href="${order_link}" class="notification-desc">Տեսնել մանրամասն</a
          </li>
        `;
            notifications.html(newNotificationHtml + existingNotifications);
            notificationsCount += 1;
            notificationsCountElem.attr('data-count', notificationsCount);
            notificationsWrapper.find('.notif-count').text(notificationsCount);
            // notificationsWrapper.show();
        });
    })
</script>
</body>
</html>
