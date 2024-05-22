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

<body data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr"
    data-pc-theme="light">
    <div class="loader" bis_skin_checked="1" style="display: none; opacity: -7.5287e-16;">
        <div class="p-4 text-center" bis_skin_checked="1">
            <div class="custom-loader" bis_skin_checked="1"></div>
            <h2 class="my-3 f-w-400">Loading..</h2>
            <p class="mb-0">Please wait...</p>
        </div>
    </div>
    <div class="auth-main v1" bis_skin_checked="1">
        <div class="auth-wrapper" bis_skin_checked="1">
            <div class="auth-form" bis_skin_checked="1">
                <div class="card my-5" bis_skin_checked="1">
                    <div class="card-body" bis_skin_checked="1">
                        <div class="text-center" bis_skin_checked="1">
                            <img src="{{ asset('storage/img-auth-reset-password.png') }}" alt="images"
                                class="img-fluid mb-3">
                            <h4 class="f-w-500 mb-1">Reset password</h4>
                            <p class="mb-3">Back to <a href="{{ route('login') }}" class="link-primary ms-1">Log
                                    in</a></p>
                        </div>
                        <div class="mb-3" bis_skin_checked="1">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control pass" placeholder="Password">
                        </div>

                        <div class="mb-3" bis_skin_checked="1">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="confirmPassword" class="form-control confirm"
                                placeholder="Confirm Password">
                        </div>
                        <div class="d-grid mt-4">
                            <button type="button" class="btn btn-primary " id="resetBtn">Reset Password</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>


        </div>
    </div>

</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
<script>
    $(document).ready(function() {
        function reset() {

            Swal.fire({
                title: `Do you want to change password?`,
                icon: "warning",
                showDenyButton: true,
                confirmButtonText: "Save",
                denyButtonText: `Cancel`
            }).then((result) => {

                if (result.isConfirmed) {
                    showLoader();
                    var password = document.querySelector('.pass');
                    var confirm = document.querySelector('.confirm');
                    var url = `{{ URL::to('reset-password') }}`;
                    var token = '{{ csrf_token() }}';
                    var data = {
                        _token: token,
                        password: password.value,
                        confirmPassword: confirm.value
                    }
                    console.log(data);
                    $.ajax({
                        url: url,
                        data: data,
                        method: "POST",
                        success: function(response) {
                            stopLoader();
                            var allMessage = document.querySelectorAll('.invalid-feedback');
                            if (allMessage) {
                                password.classList.remove('is-invalid');
                                confirm.classList.remove('is-invalid');
                                allMessage.forEach(element => {
                                    element.remove();
                                });
                            }
                            if (response != 1) {
                                if (response.password) {
                                    password.classList.add('is-invalid');
                                    for (message of response.password) {
                                        var tag =
                                            `<div class="invalid-feedback d-block">${message}</div>`
                                        password.parentElement.insertAdjacentHTML(
                                            'beforeend', tag);
                                    }
                                }
                                if (response.confirmPassword) {
                                    confirm.classList.add('is-invalid');
                                    for (message of response.confirmPassword) {
                                        var tag =
                                            `<div class="invalid-feedback d-block">${message}</div>`
                                        confirm.parentElement.insertAdjacentHTML(
                                            'beforeend', tag);
                                    }
                                }
                            } else {
                                Swal.fire({
                                    icon: "success",
                                    title: "You have changed your password sucessfully",
                                    showConfirmButton: false,
                                    allowOutsideClick :false
                                });
                                setTimeout(() => {
                                    window.location.href = `{{ URL::to('/login') }}`
                                }, 2000);
                            }
                        },
                        error: function(xhr, status, error) {

                        }

                    });
                }
            });
        }

        $('#resetBtn').click(function() {
            reset()
        })
    })
</script>


</html>
