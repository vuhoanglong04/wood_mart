@extends('layout.main')
@section('content')
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">User List</a></li>
                            <li class="breadcrumb-item" aria-current="page">Detail User</li>

                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Detail User #{{ $user->id }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- [ sample-page ] start -->
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-lg-5 col-xxl-3">
                        <div class="card overflow-hidden">
                            <div class="card-body position-relative">
                                <div class="text-center mt-3">
                                    <div class="chat-avtar d-inline-flex mx-auto">
                                        <img class="rounded-circle img-fluid wid-90 img-thumbnail"
                                            src="{{ asset('storage/user/' . $user->img) }}" alt="User image">
                                        <i class="chat-badge bg-success me-2 mb-2"></i>
                                    </div> <br>
                                    @if (!$user->deleted_at)
                                        <span class="badge text-bg-success m-2">Active</span>
                                    @else
                                        <span class="badge text-bg-danger">Disabled</span>
                                    @endif
                                    <h5 class="mb-0">{{ $user->full_name }}</h5>
                                    <p class="text-muted text-sm ">DM on <a href="#"
                                            class="link-primary">{{ $user->email }} </a> 😍</p>
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <h5 class="mb-0">86</h5>
                                            <small class="text-muted">Orders</small>
                                        </div>
                                        <div class="col-6 border border-top-0 border-bottom-0 border-end-0">
                                            <h5 class="mb-0">40</h5>
                                            <small class="text-muted">Comments</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="nav flex-column nav-pills list-group list-group-flush account-pills mb-0"
                                id="user-set-tab" role="tablist" aria-orientation="vertical">

                                <a class="nav-link list-group-item list-group-item-action active" id="user-set-profile-tab"
                                    data-bs-toggle="pill" href="#user-set-profile" role="tab"
                                    aria-controls="user-set-profile" aria-selected="true">
                                    <span class="f-w-500"><i class="ph-duotone ph-user-circle m-r-10"></i>Profile
                                        Overview</span>
                                </a>
                                <a class="nav-link list-group-item list-group-item-action" id="user-set-account-tab"
                                    data-bs-toggle="pill" href="#user-set-account" role="tab"
                                    aria-controls="user-set-account" aria-selected="false" tabindex="-1">
                                    <span class="f-w-500"><i class="ph-duotone ph-notebook m-r-10"></i>General Settings
                                    </span>
                                </a>
                                <a class="nav-link list-group-item list-group-item-action" id="user-set-passwort-tab"
                                    data-bs-toggle="pill" href="#user-set-passwort" role="tab"
                                    aria-controls="user-set-passwort" aria-selected="false" tabindex="-1">
                                    <span class="f-w-500"><i class="ph-duotone ph-key m-r-10"></i>Change Password</span>
                                </a>
                                <a class="nav-link list-group-item list-group-item-action" id="user-set-email-tab"
                                    data-bs-toggle="pill" href="#user-set-email" role="tab"
                                    aria-controls="user-set-email" aria-selected="false" tabindex="-1">
                                    <span class="f-w-500"><i class="ph-duotone ph-envelope-open m-r-10"></i>Email
                                        settings</span>
                                </a>

                            </div>
                        </div>

                    </div>
                    <div class="col-lg-7 col-xxl-9">
                        <div class="tab-content" id="user-set-tabContent">
                            <div class="tab-pane fade show active" id="user-set-profile" role="tabpanel"
                                aria-labelledby="user-set-profile-tab">

                                <div class="card">
                                    <div class="card-header">
                                        <h5>Personal Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item px-0 pt-0">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p class="mb-1 text-muted">Full Name</p>
                                                        <p class="mb-0">{{ $user->full_name }}</p>
                                                    </div>

                                                </div>
                                            </li>
                                            <li class="list-group-item px-0">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p class="mb-1 text-muted">Phone</p>
                                                        <p class="mb-0">{{ $user->phone_number }}</p>
                                                    </div>

                                                </div>
                                            </li>
                                            <li class="list-group-item px-0">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p class="mb-1 text-muted">Email</p>
                                                        <p class="mb-0">{{ $user->email }}</p>
                                                    </div>
                                                </div>
                                            </li>
                                      
                                        </ul>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h5>Lastest Orders</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush acc-feeds-list">
                                            @foreach ($lastestOrders as $item)
                                                <li class="list-group-item p-0">
                                                    <div class="row">
                                                        <div class="col-md-4 feed-title">
                                                            <p class="mb-1 text-muted">#WM-{{$item->id}}</p>
                                                            <p class="mb-0">{{$item->address}}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="mt-2 text-muted">-${{$item->total}}</p>

                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            
                            </div>
                            <div class="tab-pane fade" id="user-set-information" role="tabpanel"
                                aria-labelledby="user-set-information-tab">
                                <form action="{{ route('admin.users.update', $user->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Personal Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-xl-12">

                                                    @if ($errors->any())
                                                        <div class="alert alert-danger" role="alert">
                                                            Please fill in all the required fields.
                                                        </div>
                                                    @endif

                                                    <div class="">
                                                        <label class="form-label">Full name</label>
                                                        <input type="text" name='full_name'
                                                            class="form-control @error('full_name'){{ 'is-invalid' }}@enderror"
                                                            placeholder="Enter full name" id="floatingInput"
                                                            value="{{ old('full_name') ?? $user->full_name }}">
                                                    </div>
                                                    @error('full_name')
                                                        <div class="invalid-feedback d-block">{{ $message }}
                                                        </div>
                                                    @enderror
                                                    <div class="mt-3">
                                                        <label class="form-label">Email</label>
                                                        <input type="text" name='email'
                                                            class="form-control @error('email'){{ 'is-invalid' }}@enderror"
                                                            placeholder="Emaill address"
                                                            value="{{ old('email') ?? $user->email }}">
                                                    </div>
                                                    @error('email')
                                                        <div class="invalid-feedback d-block">{{ $message }}
                                                        </div>
                                                    @enderror
                                                    <div class="mt-3">
                                                        <label class="form-label">Phone Number</label>
                                                        <input type="text" name='phone_number'
                                                            class="form-control @error('phone_number'){{ 'is-invalid' }}@enderror"
                                                            placeholder="+84"
                                                            value="{{ old('phone_number') ?? $user->phone_number }}">
                                                    </div>
                                                    @error('phone_number')
                                                        <div class="invalid-feedback d-block">{{ $message }}
                                                        </div>
                                                    @enderror

                                                    @csrf



                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end btn-page">
                                        <button type="submit"class="btn btn-primary">Update Profile</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="user-set-account" role="tabpanel"
                                aria-labelledby="user-set-account-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>General Settings</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                           
                                            <li class="list-group-item px-0">
                                                <div class="row mb-0">
                                                    <label class="col-form-label col-md-4 col-sm-12 text-md-end">Account
                                                        Email <span class="text-danger">*</span></label>
                                                    <div class="col-md-8 col-sm-12">
                                                        <input type="text" class="form-control"
                                                            value="demo@sample.com">
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item px-0">
                                                <div class="row mb-0">
                                                    <label
                                                        class="col-form-label col-md-4 col-sm-12 text-md-end">Language</label>
                                                    <div class="col-md-8 col-sm-12">
                                                        <select class="form-control">
                                                            <option>Washington</option>
                                                            <option>India</option>
                                                            <option>Africa</option>
                                                            <option>New York</option>
                                                            <option>Malaysia</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item px-0 pb-0">
                                                <div class="row mb-0">
                                                    <label class="col-form-label col-md-4 col-sm-12 text-md-end">Sign in
                                                        Using <span class="text-danger">*</span></label>
                                                    <div class="col-md-8 col-sm-12">
                                                        <select class="form-control">
                                                            <option>Password</option>
                                                            <option>Face Recognition</option>
                                                            <option>Thumb Impression</option>
                                                            <option>Key</option>
                                                            <option>Pin</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Advance Settings</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item px-0 pt-0">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <p class="mb-1">Secure Browsing</p>
                                                        <p class="text-muted text-sm mb-0">Browsing Securely ( https ) when
                                                            it's necessary</p>
                                                    </div>
                                                    <div class="form-check form-switch p-0">
                                                        <input class="form-check-input h4 position-relative m-0"
                                                            type="checkbox" role="switch" checked="">
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item px-0">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <p class="mb-1">Login Notifications</p>
                                                        <p class="text-muted text-sm mb-0">Notify when login attempted from
                                                            other place</p>
                                                    </div>
                                                    <div class="form-check form-switch p-0">
                                                        <input class="form-check-input h4 position-relative m-0"
                                                            type="checkbox" role="switch" checked="">
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item px-0 pb-0">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <p class="mb-1">Login Approvals</p>
                                                        <p class="text-muted text-sm mb-0">Approvals is not required when
                                                            login from unrecognized
                                                            devices.</p>
                                                    </div>
                                                    <div class="form-check form-switch p-0">
                                                        <input class="form-check-input h4 position-relative m-0"
                                                            type="checkbox" role="switch" checked="">
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Recognized Devices</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item px-0 pt-0">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="me-2">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avtar bg-light-primary">
                                                                <i class="ph-duotone ph-desktop f-24"></i>
                                                            </div>
                                                            <div class="ms-2">
                                                                <p class="mb-1">Celt Desktop</p>
                                                                <p class="mb-0 text-muted">4351 Deans Lane</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <div class="text-success d-inline-block me-2">
                                                            <i class="fas fa-circle f-10 me-2"></i>
                                                            Current Active
                                                        </div>
                                                        <a href="#!" class="text-danger"><i
                                                                class="feather icon-x-circle"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item px-0">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="me-2">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avtar bg-light-primary">
                                                                <i class="ph-duotone ph-device-tablet-camera f-24"></i>
                                                            </div>
                                                            <div class="ms-2">
                                                                <p class="mb-1">Imco Tablet</p>
                                                                <p class="mb-0 text-muted">4185 Michigan Avenue</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <div class="text-muted d-inline-block me-2">
                                                            <i class="fas fa-circle f-10 me-2"></i>
                                                            Active 5 days ago
                                                        </div>
                                                        <a href="#!" class="text-danger"><i
                                                                class="feather icon-x-circle"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item px-0 pb-0">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="me-2">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avtar bg-light-primary">
                                                                <i class="ph-duotone ph-device-mobile-camera f-24"></i>
                                                            </div>
                                                            <div class="ms-2">
                                                                <p class="mb-1">Albs Mobile</p>
                                                                <p class="mb-0 text-muted">3462 Fairfax Drive</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <div class="text-muted d-inline-block me-2">
                                                            <i class="fas fa-circle f-10 me-2"></i>
                                                            Active 1 month ago
                                                        </div>
                                                        <a href="#!" class="text-danger"><i
                                                                class="feather icon-x-circle"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Active Sessions</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item px-0 pt-0">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="me-2">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avtar bg-light-primary">
                                                                <i class="ph-duotone ph-desktop f-24"></i>
                                                            </div>
                                                            <div class="ms-2">
                                                                <p class="mb-1">Celt Desktop</p>
                                                                <p class="mb-0 text-muted">4351 Deans Lane</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-link-danger">Logout</button>
                                                </div>
                                            </li>
                                            <li class="list-group-item px-0 pb-0">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="me-2">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avtar bg-light-primary">
                                                                <i class="ph-duotone ph-device-tablet-camera f-24"></i>
                                                            </div>
                                                            <div class="ms-2">
                                                                <p class="mb-1">Moon Tablet</p>
                                                                <p class="mb-0 text-muted">4185 Michigan Avenue</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-link-danger">Logout</button>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body text-end">
                                        <button class="btn btn-outline-dark me-2">Clear</button>
                                        <button class="btn btn-primary">Update Profile</button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="user-set-passwort" role="tabpanel"
                                aria-labelledby="user-set-passwort-tab">

                                <div class="card">
                                    <div class="card-header">
                                        <h5>Change Password</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item px-0">
                                                <div class="row mb-0">
                                                    <label class="col-form-label col-md-4 col-sm-12 text-md-end">New
                                                        Password <span class="text-danger">*</span></label>
                                                    <div class="col-md-8 col-sm-12">
                                                        <input type="password" class="form-control password">
                                                        <div class="error"></div>
                                                    </div>

                                                </div>
                                            </li>
                                            <li class="list-group-item pb-3 px-0">
                                                <div class="row mb-0">
                                                    <label class="col-form-label col-md-4 col-sm-12 text-md-end">Confirm
                                                        Password <span class="text-danger">*</span></label>
                                                    <div class="col-md-8 col-sm-12">
                                                        <input type="password" class="form-control confirmPassword">
                                                        <div class="error"></div>

                                                    </div>

                                                </div>
                                            </li>
                                            <div class="card-body text-end">
                                                <button class="btn btn-primary changePass">Change Password</button>
                                            </div>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="user-set-email" role="tabpanel"
                                aria-labelledby="user-set-email-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Email Settings</h5>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="mb-3">Setup Email Notification</h6>
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <div>
                                                <p class="text-muted mb-0">Email Notification</p>
                                            </div>
                                            <div class="form-check form-switch p-0">
                                                <input class="m-0 form-check-input h5 position-relative" type="checkbox"
                                                    role="switch" checked="">
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-0">
                                            <div>
                                                <p class="text-muted mb-0">Send Copy To Personal Email</p>
                                            </div>
                                            <div class="form-check form-switch p-0">
                                                <input class="m-0 form-check-input h5 position-relative" type="checkbox"
                                                    role="switch">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Activity Related Emails</h5>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="mb-3">When to email?</h6>
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <div>
                                                <p class="text-muted mb-0">Have new notifications</p>
                                            </div>
                                            <div class="form-check form-switch p-0">
                                                <input class="m-0 form-check-input h5 position-relative" type="checkbox"
                                                    role="switch" checked="">
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <div>
                                                <p class="text-muted mb-0">You're sent a direct message</p>
                                            </div>
                                            <div class="form-check form-switch p-0">
                                                <input class="m-0 form-check-input h5 position-relative" type="checkbox"
                                                    role="switch">
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <div>
                                                <p class="text-muted mb-0">Someone adds you as a connection</p>
                                            </div>
                                            <div class="form-check form-switch p-0">
                                                <input class="m-0 form-check-input h5 position-relative" type="checkbox"
                                                    role="switch" checked="">
                                            </div>
                                        </div>
                                        <hr class="my-2 border border-secondary-subtle">
                                        <h6 class="mb-3">When to escalate emails?</h6>
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <div>
                                                <p class="text-muted mb-0">Upon new order</p>
                                            </div>
                                            <div class="form-check form-switch p-0">
                                                <input class="m-0 form-check-input h5 position-relative" type="checkbox"
                                                    role="switch" checked="">
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <div>
                                                <p class="text-muted mb-0">New membership approval</p>
                                            </div>
                                            <div class="form-check form-switch p-0">
                                                <input class="m-0 form-check-input h5 position-relative" type="checkbox"
                                                    role="switch">
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-0">
                                            <div>
                                                <p class="text-muted mb-0">Member registration</p>
                                            </div>
                                            <div class="form-check form-switch p-0">
                                                <input class="m-0 form-check-input h5 position-relative" type="checkbox"
                                                    role="switch" checked="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Updates from System Notification</h5>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="mb-3">Email you with?</h6>
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <div>
                                                <p class="text-muted mb-0">News about PCT-themes products and feature
                                                    updates</p>
                                            </div>
                                            <div class="form-check form-switch p-0">
                                                <input class="m-0 form-check-input h5 position-relative" type="checkbox"
                                                    role="switch" checked="">
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <div>
                                                <p class="text-muted mb-0">Tips on getting more out of PCT-themes</p>
                                            </div>
                                            <div class="form-check form-switch p-0">
                                                <input class="m-0 form-check-input h5 position-relative" type="checkbox"
                                                    role="switch" checked="">
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <div>
                                                <p class="text-muted mb-0">Things you missed since you last logged into
                                                    PCT-themes</p>
                                            </div>
                                            <div class="form-check form-switch p-0">
                                                <input class="m-0 form-check-input h5 position-relative" type="checkbox"
                                                    role="switch">
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <div>
                                                <p class="text-muted mb-0">News about products and other services</p>
                                            </div>
                                            <div class="form-check form-switch p-0">
                                                <input class="m-0 form-check-input h5 position-relative" type="checkbox"
                                                    role="switch">
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-0">
                                            <div>
                                                <p class="text-muted mb-0">Tips and Document business products</p>
                                            </div>
                                            <div class="form-check form-switch p-0">
                                                <input class="m-0 form-check-input h5 position-relative" type="checkbox"
                                                    role="switch">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body text-end btn-page">
                                        <div class="btn btn-outline-secondary">Cancel</div>
                                        <div class="btn btn-primary">Update Profile</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            // Gán sự kiện click cho nút "Cập nhật mật khẩu"
            $('.changePass').click(function() {
                // Lấy giá trị của các trường input
                var password = document.querySelector('.password');
                var confirmPassword = document.querySelector('.confirmPassword');
                var token = '{{ csrf_token() }}'
                // Tạo object chứa dữ liệu cần gửi
                var data = {
                    _token: token,
                    password: password.value,
                    confirm_password: confirmPassword.value
                };
                var id = '{{ $user->id }}';
                // console.log(id);
                // Gửi cuộc gọi Ajax
                $.ajax({
                    url: `{{ URL::to('admin/users/update-password/1') }}`,
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        // Xử lý kết quả thành công
                        //   alert(response)


                        if (response != true) {
                            var p1 = password.parentElement;
                            var p2 = confirmPassword.parentElement;
                            var tag1 = p1.querySelector('.error');
                            var tag2 = p2.querySelector('.error');
                            console.log(response);
                            tag1.innerHTML = "";
                            tag2.innerHTML = "";
                            if (response.password) {
                                if (tag1.innerHTML == "") {
                                    password.classList.add('is-invalid');
                                    response.password.forEach(message => {
                                        var x = document.createElement('div');
                                        x.innerText = message;
                                        x.classList.add('invalid-feedback');
                                        x.classList.add('d-block');
                                        tag1.appendChild(x);
                                    });
                                    p1.appendChild(tag1);
                                }
                            } else {
                                password.classList.remove('is-invalid');
                                tag1.innerHTML = "";
                            }


                            if (response.confirm_password) {
                                if (tag2.innerHTML == "") {

                                    confirmPassword.classList.add('is-invalid');
                                    response.confirm_password.forEach(message => {
                                        var x = document.createElement('div');
                                        x.innerText = message;
                                        x.classList.add('invalid-feedback');
                                        x.classList.add('d-block');
                                        tag2.appendChild(x);
                                    });

                                    p2.appendChild(tag2);
                                }
                            } else {
                                confirmPassword.classList.remove('is-invalid');
                                tag2.innerHTML = "";
                            }
                        } else {
                            var p1 = password.parentElement;
                            var p2 = confirmPassword.parentElement;
                            var tag1 = p1.querySelector('.error');
                            var tag2 = p2.querySelector('.error');
                            confirmPassword.classList.remove('is-invalid');
                            password.classList.remove('is-invalid');
                            tag1.innerHTML = "";
                            tag2.innerHTML = "";
                            password.value = "";
                            confirmPassword.value = "";
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
                                title: "Changed Password Successfully",
                            });
                            document.querySelector('.swal2-container').classList.remove(
                                'swal2-backdrop-show')
                            document.querySelector('.swal2-container').classList.add('mb-2')

                        }
                    },
                    error: function(xhr, status, error) {
                        // Xử lý lỗi
                        // password.classList.add('is-invalid')

                        console.log(passInput);
                    }
                });
            });
        });
    </script>
@endpush
