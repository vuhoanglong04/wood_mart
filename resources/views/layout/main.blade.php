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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css">
</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr"
    data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader" bis_skin_checked="1" style="display: none; opacity: -7.5287e-16;">
        <div class="p-4 text-center" bis_skin_checked="1">
            <div class="custom-loader" bis_skin_checked="1"></div>
            <h2 class="my-3 f-w-400">Loading..</h2>
            <p class="mb-0">Please wait...</p>
        </div>
    </div>
    @include('layout.header')


    <!-- [ Main Content ] start -->
    <div class="pc-container">
        @yield('content')
    </div>
    <!-- [ Main Content ] end -->

    @include('layout.footer')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
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
    <script src="{{ asset('js') }}/component.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
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
    <script>
        var elem = document.querySelector('.loader'),
            fadeInInterval,
            fadeOutInterval;

        function showLoader() {

            if (!elem.classList.contains('is-active')) {
                clearInterval(fadeInInterval);
                clearInterval(fadeOutInterval);
                elem.fadeIn = function(timing) {
                    var newValue = 0;
                    elem.style.display = 'flex';
                    elem.style.opacity = 0;
                    fadeInInterval = setInterval(function() {
                        if (newValue < 1) {
                            newValue += 0.01;
                        } else if (newValue === 1) {
                            clearInterval(fadeInInterval);
                        }
                        elem.style.opacity = newValue;
                    }, timing);
                }
                elem.fadeIn(3);
            }
        }

        function stopLoader() {
            clearInterval(fadeInInterval);
            clearInterval(fadeOutInterval);
            elem.fadeOut = function(timing) {
                var newValue = 1;
                elem.style.opacity = 1;
                fadeOutInterval = setInterval(function() {
                    if (newValue > 0) {
                        newValue -= 0.01;
                    } else if (newValue < 0) {
                        elem.style.opacity = 0;
                        elem.style.display = 'none';
                        clearInterval(fadeOutInterval);
                    }
                    elem.style.opacity = newValue;
                }, timing);
            }
            elem.fadeOut(3);
        }
    </script>
    @stack('scripts')
</body>

</html>
