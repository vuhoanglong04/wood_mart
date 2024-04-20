<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->


<!-- Mirrored from html.phoenixcoded.net/light-able/bootstrap/dashboard/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 20 Apr 2024 07:49:38 GMT -->

<head>
    <title>@yield('title')</title>
    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description"
        content="Light Able admin and dashboard template offer a variety of UI elements and pages, ensuring your admin panel is both fast and effective." />
    <meta name="author" content="phoenixcoded" />

    <!-- [Favicon] icon -->
    <link rel="icon" href="https://html.phoenixcoded.net/light-able/bootstrap/assets/images/favicon.svg"
        type="image/x-icon" />

    <!-- map-vector css -->
    <link rel="stylesheet" href="{{ asset('css') }}/plugins/jsvectormap.min.css">
    <!-- [Google Font : Public Sans] icon -->
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&amp;display=swap"
        rel="stylesheet">

    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('fonts') }}/tabler-icons.min.css">
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('fonts') }}/feather.css">
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('fonts') }}/fontawesome.css">
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('fonts') }}/material.css">
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('css') }}/style.css" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('css') }}/style-preset.css">

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr"
    data-pc-theme="light">
    <!-- [ Pre-loader ] start -->

    @include('layout.header')


    <!-- [ Main Content ] start -->
    <div class="pc-container">
            @yield('content')
    </div>
    <!-- [ Main Content ] end -->

    @include('layout.footer')

    <script src="{{ asset('js') }}/plugins/apexcharts.min.js"></script>
    <script src="{{ asset('js') }}/plugins/jsvectormap.min.js"></script>
    <script src="{{ asset('js') }}/plugins/world.js"></script>
    <script src="{{ asset('js') }}/plugins/world-merc.js"></script>
    <script src="{{ asset('js') }}/pages/dashboard-default.js"></script>
    <!-- [Page Specific JS] end -->
    <!-- Required Js -->
    <script src="{{ asset('js') }}/plugins/popper.min.js"></script>
    <script src="{{ asset('js') }}/plugins/simplebar.min.js"></script>
    <script src="{{ asset('js') }}/plugins/bootstrap.min.js"></script>
    <script src="{{ asset('js') }}/fonts/custom-font.js"></script>
    <script src="{{ asset('js') }}/pcoded.js"></script>
    <script src="{{ asset('js') }}/plugins/feather.min.js"></script>
    <script>
        layout_change('light');
    </script>
    <script>
        layout_sidebar_change('light');
    </script>
    <script>
        change_box_container('false');
    </script>
    <script>
        layout_caption_change('true');
    </script>
    <script>
        layout_rtl_change('false');
    </script>
    <script>
        preset_change("preset-1");
    </script>
</body>

</html>
