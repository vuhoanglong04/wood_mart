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

    <div class="auth-main v1" bis_skin_checked="1">
        <div class="auth-wrapper" bis_skin_checked="1">
            <div class="auth-form" bis_skin_checked="1">
                <div class="card my-5" bis_skin_checked="1">
                    <form action="{{route('code-verification')}}" method="post">
                        @csrf
                        <div class="card-body" bis_skin_checked="1">
                            <div class="text-center" bis_skin_checked="1">
                                <img src="{{ asset('storage/img-auth-code-varify.png') }}" alt="images"
                                    class="img-fluid mb-3">
                                <h4 class="f-w-500 mb-1">Please confirm with OTP</h4>
                                <p class="mb-0">We`ve send you code on your email : <b> {{ Session::get('email') }}</b></p>
                                <p class="mb-3">Did not receive the email? <a href="{{ route('forgot-password') }}"
                                        class="link-primary ms-1">Resend code</a></p>
                            </div>
                            <div class="row my-4 g-3 text-center" bis_skin_checked="1">
                                <div class="col-12" bis_skin_checked="1">
                                    <input name="code" type="text" class="form-control text-center @error('code'){{ 'is-invalid' }}@enderror
                                    @if(session('error')) 'is-invalid'  @endif
                                    "
                                        placeholder="0000">
                                </div>
                                @error('code')
                                <div class="invalid-feedback d-block text-start">{{ $message }}</div>

                                @enderror
                                @if(session('error'))
                                <div class="invalid-feedback d-block text-start">{{ session('error') }}</div>

                                @endif
                            </div>
                            <div class="d-grid mt-4" bis_skin_checked="1">
                                <button type="submit" class="btn btn-primary">Continue</button>
                            </div>
                        </div>
                    </form>
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
