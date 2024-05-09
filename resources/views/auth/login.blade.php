<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>Login</title>
    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description"
        content="Light Able admin and dashboard template offer a variety of UI elements and pages, ensuring your admin panel is both fast and effective." />
    <meta name="author" content="phoenixcoded" />

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('images') }}/favicon.svg" type="image/x-icon" />
    <!-- [Google Font : Public Sans] icon -->
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="icon" href="https://html.phoenixcoded.net/light-able/bootstrap/assets/images/favicon.svg"
        type="image/x-icon" />

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


</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr"
    data-pc-theme="light">

    <!--Notifications -->

    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <div class="auth-main v1">
        <div class="auth-wrapper">
            <div class="auth-form">
                <div class="card my-5">
                    <div class="card-body">

                        <div class="text-center">
                            <img src="{{ asset('images') }}/logo-dark.svg" alt="images" class="img-fluid mb-3">
                            <h2 class="f-w-500 mb-3">Login with your email</h2>
                        </div>
                        @if ($errors->has('password') || $errors->has('confirm_password'))
                            <div class="alert alert-warning" role="alert">
                                Email or password is not valid
                            </div>
                        @endif
                        @if (session('notexist'))
                            <script>
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "{{ session('notexist') }}",
                                });
                            </script>
                        @endif
                        @if ($errors->has('msg'))
                            <script>
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "{{ $errors->first('msg') }}",
                                });
                            </script>
                        @endif
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="email"
                                    class="form-control @error('email'){{ 'is-invalid' }}@enderror "
                                    id="floatingInput" value='{{ old('email') }}' placeholder="Email Address">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password"
                                    class="form-control @error('password'){{ 'is-invalid' }}@enderror"
                                    id="floatingInput1" placeholder="Password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                            <div class="d-flex mt-1 justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input input-primary" type="checkbox" id="customCheckc1"
                                        checked="">
                                    <label class="form-check-label text-muted" for="customCheckc1">Remember me?</label>
                                </div>
                                <a href="../pages/forgot-password-v1.html">
                                    <h6 class="f-w-400 mb-0">Forgot Password?</h6>
                                </a>
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
@if (session('login'))
    <script>
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Please login first!!",
        });
    </script>
@endif

</html>
