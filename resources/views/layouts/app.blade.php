<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Callis Fives') }}</title>
        <!-- Favicon -->
        <link rel="icon" type="image/jpeg" href="{{ asset('images') }}/logo_callis.png">
        <!-- Fonts -->     
        <!-- Icons -->
        @include('partials.styles')
    </head>
    <body class="main-content">
        <div class="wrapper">
            @auth
            @include('layouts.navbars.admin-sidebar')
            @include('layouts.navbars.admin-navbar')
            @endauth
            @guest
            @include('layouts.navbars.client-sidebar')
            @include('layouts.navbars.client-navbar')
            @endguest               
            <div class="main-panel">
                <div class="content">                    
                    @yield('content')
                </div>

                @include('layouts.footer')
            </div>                 
            @include('partials.scripts')
            @include('flash::message')
            @stack('js')

            <script>
                $(document).ready(function () {
                    $().ready(function () {
                        $sidebar = $('.sidebar');
                        $navbar = $('.navbar');
                        $main_panel = $('.main-panel');

                        $full_page = $('.full-page');

                        $sidebar_responsive = $('body > .navbar-collapse');
                        sidebar_mini_active = false;
                        white_color = false;

                        window_width = $(window).width();

                        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

                        $('.fixed-plugin a').click(function (event) {
                            if ($(this).hasClass('switch-trigger')) {
                                if (event.stopPropagation) {
                                    event.stopPropagation();
                                } else if (window.event) {
                                    window.event.cancelBubble = true;
                                }
                            }
                        });


                        $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function () {
                            var $btn = $(this);

                            if (sidebar_mini_active == true) {
                                $('body').removeClass('sidebar-mini');
                                sidebar_mini_active = false;
                                whiteDashboard.showSidebarMessage('Sidebar mini deactivated...');
                            } else {
                                $('body').addClass('sidebar-mini');
                                sidebar_mini_active = true;
                                whiteDashboard.showSidebarMessage('Sidebar mini activated...');
                            }

                            // we simulate the window Resize so the charts will get updated in realtime.
                            var simulateWindowResize = setInterval(function () {
                                window.dispatchEvent(new Event('resize'));
                            }, 180);

                            // we stop the simulation of Window Resize after the animations are completed
                            setTimeout(function () {
                                clearInterval(simulateWindowResize);
                            }, 1000);
                        });

                    });
                });
            </script>            
            @stack('js')
            @include('partials.modals')       
    </body>
</html>
