<style>
    .search {
        position: relative;
    }

    .searchBox {
        position: absolute;
        top: 80%;
        width: 100%;
        /* height: 5rem; */
        background-color: white;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }

    .hidden {
        display: none
    }
</style>
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>


<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('admin.index') }}" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <img src="{{ asset('images') }}/logo-dark.svg" alt="logo image" class="logo-lg" />
                <span class="badge bg-brand-color-2 rounded-pill ms-2 theme-version">v1.0</span>
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item pc-caption">
                    <label>Navigation</label>
                </li>
                <li class="pc-item pc-\">
                    <a href="{{ route('admin.index') }}" class="pc-link">

                    <span class="pc-mtext">Dashboard</span>
                    <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    <span class="pc-badge">0</span>
                    </a>

                </li>
                <li class="pc-item pc-caption">
                    <label>Admin Panel</label>
                </li>
                @can('groups.view')
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-users-three"></i>
                            </span>
                            <span class="pc-mtext">Groups</span>
                            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="{{ route('admin.groups.index') }}">Group List</a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('user.view')
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-user-list"></i>
                            </span>
                            <span class="pc-mtext">Users</span>
                            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="{{ route('admin.users.index') }}">Users List</a>

                        </ul>
                    </li>
                @endcan
                @can('categories.view')
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-tag"></i>
                            </span>
                            <span class="pc-mtext">Categories</span>
                            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="{{ route('admin.category.index') }}">Category
                                    List</a></li>

                        </ul>
                    </li>
                @endcan

                @can('products.view')
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-armchair"></i>
                            </span>
                            <span class="pc-mtext">Products</span>
                            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="{{ route('admin.products.index') }}">Products
                                    List</a></li>
                        </ul>
                    </li>
                @endcan

                @can('orders.view')
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-list-bullets"></i>
                            </span>
                            <span class="pc-mtext">Orders</span>
                            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="{{ route('admin.orders.index') }}">Orders
                                    List</a></li>
                        </ul>
                    </li>
                @endcan
                @can('vouchers.view')
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-subtitles"></i>
                            </span>
                            <span class="pc-mtext">Vouchers</span>
                            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="{{ route('admin.vouchers.index') }}">Vouchers
                                    List</a></li>
                        </ul>
                    </li>
                @endcan
                @can('topics.view')
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-article-medium"></i>
                            </span>
                            <span class="pc-mtext">Topics</span>
                            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="{{ route('admin.topics.index') }}">Topics
                                    List</a></li>
                        </ul>
                    </li>
                @endcan
                @can('reviews.view')
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-chat-text"></i>
                            </span>
                            <span class="pc-mtext">Reviews</span>
                            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="{{ route('admin.reviews.index') }}">Reviews
                                    List</a></li>
                        </ul>
                    </li>
                @endcan

                @can('posts.view')
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-book-open-text"></i>
                            </span>
                            <span class="pc-mtext">Posts</span>
                            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="{{ route('admin.posts.index') }}">Posts
                                    List</a></li>
                        </ul>
                    </li>
                @endcan
                <li class="pc-item pc-hasmenu">
                    <a href="{{ route('admin.gallery') }}" class="pc-link">
                        <span class="pc-micon">
                            <i class="ph-duotone ph-image"></i>
                        </span>
                        <span class="pc-mtext">Gallery</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>

                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="{{ route('admin.statistic') }}" class="pc-link">
                        <span class="pc-micon">
                            <i class="ph-duotone ph-align-bottom"></i>
                        </span>
                        <span class="pc-mtext">Statistic</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                </li>
            </ul>

        </div>
        <div class="card pc-user-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <img src="{{ Auth::user()->img }}" alt="user-image"
                            class="user-avtar wid-45 rounded-circle" />
                    </div>
                    <div class="flex-grow-1 ms-3 me-2">
                        <h6 class="mb-0">{{ Auth::user()->full_name ?? '' }}</h6>
                        <small>Administrator</small>
                    </div>
                    <div class="dropdown">
                        <a href="#" class="btn btn-icon btn-link-secondary avtar arrow-none dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,20">
                            <i class="ph-duotone ph-windows-logo"></i>
                        </a>
                        <div class="dropdown-menu">
                            <ul>
                                <li><a class="pc-user-links"
                                        href="{{ route('admin.users.detail', Auth::user()->id) }}">
                                        <i class="ph-duotone ph-user"></i>
                                        <span>My Account</span>
                                    </a></li>

                                <li><a class="pc-user-links" href='{{ route('logout') }}'>
                                        <i class="ph-duotone ph-power"></i>
                                        <span>Logout</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<header class="pc-header">
    <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <!-- ======= Menu collapse Icon ===== -->
                <li class="pc-h-item pc-sidebar-collapse">
                    <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="dropdown pc-h-item d-inline-flex d-md-none">
                    <a class="pc-head-link dropdown-toggle arrow-none m-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ph-duotone ph-magnifying-glass"></i>
                    </a>
                    <div class="dropdown-menu pc-h-dropdown drp-search">
                        <form class="px-3">
                            <div class="mb-0 d-flex align-items-center">
                                <input type="search" class="form-control border-0 shadow-none"
                                    placeholder="Search..." />
                                <button class="btn btn-light-secondary btn-search">Search</button>
                            </div>
                        </form>
                    </div>
                </li>
                <li class="pc-h-item d-none d-md-inline-flex">
                    <form class="form-search search">
                        <i class="ph-duotone ph-magnifying-glass icon-search"></i>
                        <input type="search" class="form-control" placeholder="Search..." />

                        <button class="btn btn-search" style="padding: 0"><kbd>ctrl+k</kbd></button>
                    </form>
                    <div class="searchBox p-2">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-borderless table-sm mb-0">
                                    <tbody class="result">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <!-- [Mobile Media Block end] -->
        <div class="ms-auto">
            <ul class="list-unstyled">

                <li class="pc-h-item">
                    <a class="pc-head-link pct-c-btn" href="#" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvas_pc_layout">
                        <i class="ph-duotone ph-gear-six"></i>
                    </a>
                </li>

                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ph-duotone ph-bell"></i>
                        <span class="badge bg-success pc-h-badge">5</span>
                    </a>
                    <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header d-flex align-items-center justify-content-between">

                            <h5 class="m-0">Notifications</h5>
                            <ul class="list-inline ms-auto mb-0">
                                <li class="list-inline-item">
                                    <a href="https://html.phoenixcoded.net/light-able/bootstrap/application/mail.html"
                                        class="avtar avtar-s btn-link-hover-primary">
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="dropdown-body text-wrap header-notification-scroll">
                            <ul class="list-group w-100 notifications">


                            </ul>
                        </div>

                    </div>
                </li>
                <li class="dropdown pc-h-item header-user-profile">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                        <img src="{{ Auth::user()->img }}" alt="user-image" class="user-avtar" />
                    </a>
                    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header d-flex align-items-center justify-content-between">
                            <h5 class="m-0">Profile</h5>
                        </div>
                        <div class="dropdown-body">
                            <div class="profile-notification-scroll position-relative"
                                style="max-height: calc(100vh - 225px)">
                                <ul class="list-group list-group-flush w-100">
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="{{ Auth::user()->img }}" alt="user-image"
                                                    class="wid-50 rounded-circle" />
                                            </div>
                                            <div class="flex-grow-1 mx-3">
                                                <h5 class="mb-0">{{ Auth::user()->full_name ?? '' }}</h5>
                                                <a class="link-primary"
                                                    href="mailto:carson.darrin@company.io">{{ Auth::user()->email ?? '' }}</a>
                                            </div>
                                            <span class="badge bg-primary">PRO</span>
                                        </div>
                                    </li>

                                    <li class="list-group-item">
                                        <a href="{{ route('admin.users.detail', Auth::user()->id) }}"
                                            class="dropdown-item">
                                            <span class="d-flex align-items-center">
                                                <i class="ph-duotone ph-user-circle"></i>
                                                <span>Edit profile</span>
                                            </span>
                                        </a>

                                        <a href="#" class="dropdown-item">
                                            <span class="d-flex align-items-center">
                                                <i class="ph-duotone ph-bell"></i>
                                                <span>Notifications</span>
                                            </span>
                                        </a>

                                    </li>
                                    <li class="list-group-item">

                                        <a href="{{ route('logout') }}" class="dropdown-item">
                                            <span class="d-flex align-items-center">
                                                <i class="ph-duotone ph-power"></i>
                                                <span>Logout</span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>

<div class="offcanvas border-0 pct-offcanvas offcanvas-end" tabindex="-1" id="offcanvas_pc_layout">
    <div class="offcanvas-header justify-content-between">
        <h5 class="offcanvas-title">Settings</h5>
        <button type="button" class="btn btn-icon btn-link-danger" data-bs-dismiss="offcanvas"
            aria-label="Close"><i class="ti ti-x"></i></button>
    </div>
    <div class="pct-body customizer-body">
        <div class="offcanvas-body py-0">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="pc-dark">
                        <h6 class="mb-1">Theme Mode</h6>
                        <p class="text-muted text-sm">Choose light or dark mode or Auto</p>
                        <div class="row theme-color theme-layout">
                            <div class="col-6">
                                <div class="d-grid">
                                    <button class="preset-btn btn active" data-value="true"
                                        onclick="layout_change('light');">
                                        <span class="btn-label">Light</span>
                                        <span
                                            class="pc-lay-icon"><span></span><span></span><span></span><span></span></span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-grid">
                                    <button class="preset-btn btn dark  " data-value="false"
                                        onclick="layout_change('dark')">
                                        <span class="btn-label">Dark</span>
                                        <span
                                            class="pc-lay-icon"><span></span><span></span><span></span><span></span></span>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <h6 class="mb-1">Sidebar Theme</h6>
                    <p class="text-muted text-sm">Choose Sidebar Theme</p>
                    <div class="row theme-color theme-sidebar-color">
                        <div class="col-6">
                            <div class="d-grid">
                                <button class="preset-btn btn active sidebarLight" data-id='1' data-value="false"
                                    onclick="layout_sidebar_change('light');">
                                    <span class="btn-label">Light</span>
                                    <span
                                        class="pc-lay-icon"><span></span><span></span><span></span><span></span></span>
                                </button>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-grid">
                                <button class="preset-btn btn sidebarDark" data-id='0' data-value="true"
                                    onclick="layout_sidebar_change('dark');">
                                    <span class="btn-label">Dark</span>
                                    <span
                                        class="pc-lay-icon"><span></span><span></span><span></span><span></span></span>
                                </button>
                            </div>
                        </div>

                    </div>
                </li>


            </ul>
        </div>
    </div>
</div>
<script>
    var searchInput = document.querySelector('.search input');
    var result = document.querySelector('.result');
    var modules = ['dashboard', 'groups', 'users', 'categories', 'products', 'orders', 'vouchers', 'topics', 'reviews',
        'posts', 'gallery', 'statistic'
    ];
    var resultParent = result.parentNode.parentNode.parentNode.parentNode
    resultParent.classList.add('hidden');
    searchInput.addEventListener('input', function(event) {
        // result.innerText = " ";
        var listTD = result.querySelectorAll('.tagSearch')
        if (listTD.length != 0) {
            listTD.forEach(item => {
                item.parentNode.remove()
            })
        }
        if (this.value == "") resultParent.classList.add('hidden');
        else {

            resultParent.classList.remove('hidden');
            modules.forEach(element => {
                if (element.includes(searchInput.value.trim())) {
                    var url = `{{ URL::to('admin/${element}') }}`
                    var tag =
                        `<td><a class="mt-2 mb-2 tagSearch" href="${url}">${element.charAt(0).toUpperCase() + element.slice(1)}</a> </td>`
                    result.insertAdjacentHTML('beforeend', tag);
                }
            });
        }

    })
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script>
    var token = '{{ csrf_token() }}';
    var url = `{{ URL::to('admin/notifications') }}`;
    var notifications = document.querySelector('.notifications');
    $.ajax({
        url: url,
        headers: {
            'X-CSRF-TOKEN': token
        },
        "method": "GET",
        success: function(response) {

            response.forEach(item => {
                var time = moment(item.created_at);
                var timeAgo = time.fromNow();
                var tag = `
                    <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="avtar avtar-s bg-light-primary">
                                                <i class="ph-duotone ph-chats-teardrop f-18"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-7">
                                            <div class="d-flex">
                                                <h6 class="mb-0 me-3">Message</h6>
                                            </div>
                                            <p class="position-relative mt-1 mb-2"><br /><span
                                                    class="text-truncate">${item.content}</span></p>
                                        </div>
                                        <div class="col-sm-3">
                                            <span class="text-sm mb-2">${timeAgo}</span>

                                        </div>
                                    </div>
                                </li>`

                notifications.insertAdjacentHTML('beforeend', tag);
            })
        },
        error: function(xhr, status, error) {

        }

    });
    var pusher = new Pusher('35dfd6b6ef9bde652f85', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('woodmart');
    channel.bind('my-event', function(data) {
        var time = moment();
        var timeAgo = time.fromNow();
        var tag = `
                    <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="avtar avtar-s bg-light-primary">
                                                <i class="ph-duotone ph-chats-teardrop f-18"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-7">
                                            <div class="d-flex">
                                                <h6 class="mb-0 me-3">Message</h6>
                                            </div>
                                            <p class="position-relative mt-1 mb-2"><br /><span
                                                    class="text-truncate">${data}</span></p>
                                        </div>
                                        <div class="col-sm-3">
                                            <span class="text-sm mb-2">${timeAgo}</span>

                                        </div>
                                    </div>
                                </li>`

        notifications.insertAdjacentHTML('afterbegin', tag);
        notifications.removeChild(notifications.lastElementChild);
        const Toast = Swal.mixin({
            toast: true,
            position: "bottom-end",
            showConfirmButton: false,
            timer: 3000,
            backdrop: 'swal2-backdrop-hide',
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "success",
            title: `${data}`,
        });
        document.querySelector('.swal2-container').classList.remove('swal2-backdrop-show')
        document.querySelector('.swal2-container').classList.add('mb-2')

        $.ajax({
            url: url,
            headers: {
                'X-CSRF-TOKEN': token
            },
            data: {
                'content': data
            },
            "method": "POST",
            success: function(response) {

            },
            error: function(xhr, status, error) {

            }

        });


    });
</script>
