@extends('layout.main')
@section('content')
    <div class="pc-content">
        @if (session('success'))
            <script>
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
                    title: "{{ session('success') }}",
                });
                document.querySelector('.swal2-container').classList.remove('swal2-backdrop-show')
                document.querySelector('.swal2-container').classList.add('mb-2')
            </script>
        @endif
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders List</a></li>
                            <li class="breadcrumb-item">Order Detail</li>

                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Order Detail #{{ $order->id }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" bis_skin_checked="1">
            <!-- [ sample-page ] start -->
            <div class="col-sm-12" bis_skin_checked="1">
                <div class="card" bis_skin_checked="1">
                    <div class="card-body p-0" bis_skin_checked="1">
                        <ul class="nav nav-tabs checkout-tabs mb-0" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="ecomtab-tab-0" data-bs-toggle="tab" href="#ecomtab-0"
                                    role="tab" aria-controls="ecomtab-0" aria-selected="true">
                                    <div class="d-flex align-items-center" bis_skin_checked="1">
                                        <div class="flex-shrink-0" bis_skin_checked="1">
                                            <div class="avtar avtar-s" bis_skin_checked="1">
                                                <i class="ti ti-hand-stop"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-2" bis_skin_checked="1">
                                            <h5 class="mb-0">Action</h5>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="ecomtab-tab-1" data-bs-toggle="tab" href="#ecomtab-1" role="tab"
                                    aria-controls="ecomtab-1" aria-selected="true">
                                    <div class="d-flex align-items-center" bis_skin_checked="1">
                                        <div class="flex-shrink-0" bis_skin_checked="1">
                                            <div class="avtar avtar-s" bis_skin_checked="1">
                                                <i class="ti ti-shopping-cart"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-2" bis_skin_checked="1">
                                            <h5 class="mb-0">Orders Details</h5>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="ecomtab-tab-2" data-bs-toggle="tab" href="#ecomtab-2" role="tab"
                                    aria-controls="ecomtab-2" aria-selected="true">
                                    <div class="d-flex align-items-center" bis_skin_checked="1">
                                        <div class="flex-shrink-0" bis_skin_checked="1">
                                            <div class="avtar avtar-s" bis_skin_checked="1">
                                                <i class="ti ti-building-skyscraper"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-2" bis_skin_checked="1">
                                            <h5 class="mb-0">Shipping Information & Payment</h5>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="ecomtab-tab-3" data-bs-toggle="tab" href="#ecomtab-3" role="tab"
                                    aria-controls="ecomtab-3" aria-selected="false" tabindex="-1">
                                    <div class="d-flex align-items-center" bis_skin_checked="1">
                                        <div class="flex-shrink-0" bis_skin_checked="1">
                                            <div class="avtar avtar-s" bis_skin_checked="1">
                                                <i class="ti ti-credit-card"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-2" bis_skin_checked="1">
                                            <h5 class="mb-0">Invoice</h5>
                                        </div>
                                    </div>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
                @can('orders.update')
                    <div class="card col-xl-6" bis_skin_checked="1">

                        <div class="card-body" bis_skin_checked="1">
                            <form class="row row-cols-md-auto g-3 align-items-center">

                                <div class="col-xl-6" bis_skin_checked="1">
                                    <label class="sr-only" for="inlineFormSelectPref">Preference</label>
                                    <select class="form-select" id="inlineFormSelectPref">
                                        <option value=" " selected hidden>Choose Status</option>
                                        @if ($order->status != 0)
                                            <option value="0">Cancel</option>
                                        @endif

                                        @if ($order->status >= 1)
                                            <option value="2">Confirm</option>
                                            <option value="3">Preparing</option>
                                            <option value="4">
                                                Being Transported
                                            </option>
                                            <option value="5">
                                                Delivered successfully
                                            </option>
                                        @endif
                                    </select>
                                </div>

                                <div class="col-12" bis_skin_checked="1">
                                    <button type="button" class="btn btn-primary save">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endcan
                <div class="tab-content" bis_skin_checked="1">
                    <div class="tab-pane  active show" id="ecomtab-0" role="tabpanel" aria-labelledby="ecomtab-tab-0"
                        bis_skin_checked="1">
                        <div class="col-sm-12" bis_skin_checked="1">
                            <div id="basicwizard" class="form-wizard row justify-content-center" bis_skin_checked="1">
                                <div class="col-12" bis_skin_checked="1">
                                    <div class="card" bis_skin_checked="1">
                                        <div class="card-body p-3" bis_skin_checked="1">
                                            <ul class="nav nav-pills nav-justified" role="tablist">
                                                <li class="nav-item" data-target-form="#contactDetailForm"
                                                    role="presentation">
                                                    <a href="#contactDetail" data-bs-toggle="tab" data-toggle="tab"
                                                        class="nav-link {{ $order->status == '0' ? 'active' : '' }}"
                                                        aria-selected="true" role="tab">
                                                        <i class="ti ti-receipt-off"></i>
                                                        <span class="d-none d-sm-inline"
                                                            style="font-size: 14px">Cancelled</span>
                                                    </a>
                                                </li>
                                                <!-- end nav item -->
                                                <li class="nav-item" data-target-form="#jobDetailForm"
                                                    role="presentation">
                                                    <a href="#jobDetail" data-bs-toggle="tab" data-toggle="tab"
                                                        class="nav-link icon-btn {{ $order->status == '1' ? 'active' : '' }}"
                                                        aria-selected="false" role="tab" tabindex="-1">
                                                        <i class="ti ti-loader"></i>
                                                        <span class="d-none d-sm-inline" style="font-size: 14px">Awaiting
                                                            Payment</span>
                                                    </a>
                                                </li>
                                                <!-- end nav item -->
                                                <li class="nav-item" data-target-form="#educationDetailForm"
                                                    role="presentation">
                                                    <a href="#educationDetail" data-bs-toggle="tab" data-toggle="tab"
                                                        class="nav-link icon-btn {{ $order->status == '2' ? 'active' : '' }}"
                                                        aria-selected="false" role="tab" tabindex="-1">
                                                        <i class="ti ti-checkbox"></i>
                                                        <span class="d-none d-sm-inline" style="font-size: 14px">Waiting
                                                            Confirm</span>
                                                    </a>
                                                </li>
                                                <!-- end nav item -->
                                                <li class="nav-item" role="presentation">
                                                    <a href="#preparing" data-bs-toggle="tab" data-toggle="tab"
                                                        class="nav-link icon-btn {{ $order->status == '3' ? 'active' : '' }}"
                                                        aria-selected="false" role="tab" tabindex="-1">
                                                        <i class="ti ti-dots"></i>
                                                        <span class="d-none d-sm-inline"
                                                            style="font-size: 14px">Preparing</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a href="#delivering" data-bs-toggle="tab" data-toggle="tab"
                                                        class="nav-link icon-btn {{ $order->status == '4' ? 'active' : '' }}"
                                                        aria-selected="false" role="tab" tabindex="-1">
                                                        <i class="ti ti-truck-delivery"></i>
                                                        <span class="d-none d-sm-inline" style="font-size: 14px">Being
                                                            Transported</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a href="#delivered" data-bs-toggle="tab" data-toggle="tab"
                                                        class="nav-link icon-btn {{ $order->status == '5' ? 'active' : '' }}"
                                                        aria-selected="false" role="tab" tabindex="-1">
                                                        <i class="ti ti-circle-check"></i>
                                                        <span class="d-none d-sm-inline"
                                                            style="font-size: 14px">Delivered</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card" bis_skin_checked="1">
                                        <div class="card-body" bis_skin_checked="1">
                                            <div class="tab-content" bis_skin_checked="1">
                                                <!-- START: Define your progress bar here -->
                                                <div id="bar" class="progress mb-3" style="height: 7px;"
                                                    bis_skin_checked="1">
                                                    <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                        bis_skin_checked="1"
                                                        style="width: {{ $order->status == '0' ? '0%' : '' }} {{ $order->status == '1' ? '20%' : '' }} {{ $order->status == '2' ? '40%' : '' }} {{ $order->status == '3' ? '60%' : '' }} {{ $order->status == '4' ? '80%' : '' }} {{ $order->status == '5' ? '100%' : '' }};">
                                                    </div>
                                                </div>
                                                <div class="tab-pane {{ $order->status == '0' ? 'active' : '' }} show"
                                                    id="contactDetail" role="tabpanel" bis_skin_checked="1">
                                                    <form id="contactForm" method="post" action="#"
                                                        class="was-validated">
                                                        <div class="text-center" bis_skin_checked="1">
                                                            <h3 class="mb-2">Cancelled</h3>
                                                            <i class='ti ti-circle-off' style="font-size: 10rem"></i>
                                                        </div>

                                                    </form>
                                                </div>
                                                <!-- end contact detail tab pane -->
                                                <div class="tab-pane {{ $order->status == '1' ? 'active' : '' }}"
                                                    id="jobDetail" role="tabpanel" bis_skin_checked="1">

                                                    <div class="text-center" bis_skin_checked="1">
                                                        <h3 class="mb-2">Awaiting Payment</h3>
                                                        <i class='ti ti-loader' style="font-size: 10rem"></i>

                                                    </div>

                                                </div>
                                                <!-- end job detail tab pane -->
                                                <div class="tab-pane {{ $order->status == '2' ? 'active' : '' }}"
                                                    id="educationDetail" role="tabpanel" bis_skin_checked="1">

                                                    <div class="text-center" bis_skin_checked="1">
                                                        <h3 class="mb-2">Waiting Confirmation</h3>
                                                        <i class='ti ti-checkbox' style="font-size: 10rem"></i>

                                                    </div>

                                                </div>
                                                <!-- end education detail tab pane -->
                                                <div class="tab-pane {{ $order->status == '3' ? 'active' : '' }}"
                                                    id="preparing" role="tabpanel" bis_skin_checked="1">
                                                    <div class="text-center" bis_skin_checked="1">
                                                        <h3 class="mb-2">Preparing</h3>
                                                        <i class='ti ti-dots' style="font-size: 10rem"></i>

                                                    </div>

                                                </div>
                                                <div class="tab-pane {{ $order->status == '4' ? 'active' : '' }}"
                                                    id="delivering" role="tabpanel" bis_skin_checked="1">
                                                    <div class="text-center" bis_skin_checked="1">
                                                        <h3 class="mb-2">Being Transported</h3>
                                                        <i class='ti ti-truck-delivery' style="font-size: 10rem"></i>

                                                    </div>

                                                </div>
                                                <div class="tab-pane {{ $order->status == '5' ? 'active' : '' }} "
                                                    id="delivered" role="tabpanel" bis_skin_checked="1">
                                                    <div class="text-center" bis_skin_checked="1">
                                                        <h3 class="mb-2 ">Delivered successfully</h3>
                                                        <i class='ti ti-circle-check ' style="font-size: 10rem"></i>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- end tab content-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane  show" id="ecomtab-1" role="tabpanel" aria-labelledby="ecomtab-tab-1"
                        bis_skin_checked="1">
                        <div class="row gy-4" bis_skin_checked="1">
                            <div class="col-xl-8" bis_skin_checked="1">
                                <div class="card" bis_skin_checked="1">


                                    <div class="card-body p-0 table-body" bis_skin_checked="1">
                                        <div class="table-responsive" bis_skin_checked="1">
                                            <table class="table mb-0" id="pc-dt-simple">
                                                <thead>
                                                    <tr>
                                                        <th>Product</th>
                                                        <th class="text-end">Price</th>
                                                        <th class="text-center">Quantity</th>
                                                        <th class="text-end">Total</th>
                                                        <th class="text-end"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($listProductInOrder as $item)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center"
                                                                    bis_skin_checked="1">
                                                                    <div class="flex-shrink-0" bis_skin_checked="1">
                                                                        <img src="{{ asset('storage/products') }}/{{ $item->product_variant_img }}"
                                                                            alt="image" class="bg-light rounded"
                                                                            style="width:50px ; height:50px; oject-fit:cover">
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-3" bis_skin_checked="1">
                                                                        <h5 class="mb-1">
                                                                            {{ $item->product->product_name }}</h5>
                                                                        <div class="d-flex">
                                                                            <span class="badge rounded-pill  me-2"
                                                                                style="background-color: {{ $item->color->color_value }}">{{ $item->color->color_name }}</span>
                                                                            <span
                                                                                class="badge rounded-pill text-bg-secondary">{{ $item->material->material_value }}</span>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-end">
                                                                <h5 class="mb-0">${{ $item->price }}</h5>
                                                            </td>
                                                            <td class="text-end">
                                                                <h5 class="mb-0 text-center">x{{ $item->quantity }}</h5>
                                                            </td>
                                                            <td class="text-end">
                                                                <h5 class="mb-0">${{ $item->price * $item->quantity }}
                                                                </h5>
                                                            </td>

                                                        </tr>
                                                    @endforeach



                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-4" bis_skin_checked="1">

                                <div class="card" bis_skin_checked="1">
                                    <div class="card-body py-2" bis_skin_checked="1">
                                        <ul class="list-group list-group-flush">

                                            <li class="list-group-item px-0">
                                                <h5 class="mb-0">Order Summary</h5>
                                            </li>
                                            <li class="list-group-item px-0">
                                                <div class="float-end" bis_skin_checked="1">
                                                    <h5 class="mb-0">${{ $total }}.00</h5>
                                                </div><span class="text-muted">Sub Total</span>
                                            </li>
                                            <li class="list-group-item px-0">
                                                <div class="float-end" bis_skin_checked="1">
                                                    <h5 class="mb-0">${{ $order->shipping->fee }}</h5>
                                                </div><span
                                                    class="text-muted">{{ $order->shipping->shipping_name }}</span>
                                            </li>
                                            <li class="list-group-item px-0">
                                                <div class="float-end" bis_skin_checked="1">
                                                    <h5 class="mb-0">
                                                        @if ($voucher)
                                                            {{ $order->voucher }} (-{{ $voucher->discount }}%)
                                                        @endif
                                                    </h5>
                                                </div><span class="text-muted">Voucher</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card" bis_skin_checked="1">
                                    <div class="card-body py-2" bis_skin_checked="1">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item px-0">
                                                <div class="float-end" bis_skin_checked="1">
                                                    <h5 class="mb-0">${{ $total + $order->shipping->fee }}.00</h5>
                                                </div>
                                                <h5 class="mb-0 d-inline-block">Total</h5>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane  show" id="ecomtab-2" role="tabpanel" aria-labelledby="ecomtab-tab-2"
                        bis_skin_checked="1">
                        <div class="row" bis_skin_checked="1">
                            <div class="col-xl-7" bis_skin_checked="1">
                                <div class="card" bis_skin_checked="1">

                                    <div class="collapse multi-collapse show" id="multiCollapseExample1"
                                        bis_skin_checked="1">
                                        <div class="card-body border-bottom" bis_skin_checked="1">
                                            <div class="row align-items-center" bis_skin_checked="1">
                                                <div class="col" bis_skin_checked="1">
                                                    <h5 class="mb-0">Shipping Information</h5>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="card-body" bis_skin_checked="1">
                                            <div class="address-check-block" bis_skin_checked="1">
                                                <div class="address-check border rounded p-3" bis_skin_checked="1">
                                                    <div class="form-check" bis_skin_checked="1">
                                                        <input type="radio" name="radio1"
                                                            class="form-check-input input-primary" id="address-check-1"
                                                            checked="">
                                                        <label class="form-check-label d-block" for="address-check-1">
                                                            <span
                                                                class="h6 mb-0 d-block">{{ $order->user->full_name }}</span>
                                                        
                                                            <span
                                                                class="text-muted address-details">{{ $order->address }}</span>
                                                            <span class="row align-items-center justify-content-between">
                                                                <span class="col-6">
                                                                    <span
                                                                        class="text-muted mb-0">{{ $order->user->phone_number }}</span>
                                                                </span>
                                                                <span class="col-6 text-end">
                                                                    <span
                                                                        class="address-btns d-flex align-items-center justify-content-end gap-2">
                                                                        <a href="#"
                                                                            class="avtar avtar-s btn-link-danger btn-pc-default">
                                                                            <i class="ti ti-trash f-20"></i>
                                                                        </a>
                                                                        <span
                                                                            class="btn btn-sm btn-outline-primary">Deliver
                                                                            to this address</span>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse multi-collapse" id="multiCollapseExample2" bis_skin_checked="1">
                                        <div class="card-body border-bottom" bis_skin_checked="1">
                                            <div class="row align-items-center" bis_skin_checked="1">
                                                <div class="col" bis_skin_checked="1">
                                                    <h5 class="mb-0">Add new address</h5>
                                                </div>
                                                <div class="col-auto" bis_skin_checked="1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body" bis_skin_checked="1">
                                            <div class="row" bis_skin_checked="1">
                                                <div class="col-12" bis_skin_checked="1">
                                                    <div class="mb-3 row align-items-center g-2" bis_skin_checked="1">
                                                        <label class="col-lg-4 col-form-label py-0">Address Type :<small
                                                                class="text-muted d-block">Enter Add Type</small></label>
                                                        <div class="col-lg-8" bis_skin_checked="1">
                                                            <div class="form-check form-check-inline"
                                                                bis_skin_checked="1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="flexRadioDefault" id="addtypecheck1"
                                                                    checked="">
                                                                <label class="form-check-label" for="addtypecheck1">
                                                                    Home (All day Delivery)
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-inline"
                                                                bis_skin_checked="1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="flexRadioDefault" id="addtypecheck2">
                                                                <label class="form-check-label" for="addtypecheck2">
                                                                    Work (Between 10 AM to 5 PM)
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row align-items-center g-2" bis_skin_checked="1">
                                                        <label class="col-lg-4 col-form-label py-0">First Name :<small
                                                                class="text-muted d-block">Enter
                                                                your first name</small></label>
                                                        <div class="col-lg-8" bis_skin_checked="1">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row align-items-center g-2" bis_skin_checked="1">
                                                        <label class="col-lg-4 col-form-label py-0">Last Name :<small
                                                                class="text-muted d-block">Enter
                                                                your last name</small></label>
                                                        <div class="col-lg-8" bis_skin_checked="1">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row align-items-center g-2" bis_skin_checked="1">
                                                        <label class="col-lg-4 col-form-label py-0">Email Id :<small
                                                                class="text-muted d-block">Enter
                                                                Email id</small></label>
                                                        <div class="col-lg-8" bis_skin_checked="1">
                                                            <input type="email" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row align-items-center g-2" bis_skin_checked="1">
                                                        <label class="col-lg-4 col-form-label py-0">Date of Birth :<small
                                                                class="text-muted d-block">Enter
                                                                the date of birth</small></label>
                                                        <div class="col-lg-8" bis_skin_checked="1">
                                                            <input type="date" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row align-items-center g-2" bis_skin_checked="1">
                                                        <label class="col-lg-4 col-form-label py-0">Phone number :<small
                                                                class="text-muted d-block">Enter
                                                                Phone number</small></label>
                                                        <div class="col-lg-8" bis_skin_checked="1">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row align-items-center g-2" bis_skin_checked="1">
                                                        <label class="col-lg-4 col-form-label py-0">City :<small
                                                                class="text-muted d-block">Enter
                                                                City name</small></label>
                                                        <div class="col-lg-8" bis_skin_checked="1">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3" bis_skin_checked="1">
                                                        <div class="form-check" bis_skin_checked="1">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" id="checkaddres" checked="">
                                                            <label class="form-check-label" for="checkaddres">
                                                                Save this new address for future shipping
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="text-end btn-page mb-0 mt-4" bis_skin_checked="1">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            data-bs-toggle="collapse" data-bs-target=".multi-collapse"
                                                            aria-expanded="false"
                                                            aria-controls="multiCollapseExample1 multiCollapseExample2">Cancel</button>
                                                        <button class="btn btn-primary"
                                                            onclick="change_tab('#ecomtab-3')">Save &amp; Deliver to this
                                                            Address</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-5">
                                <div class="card" bis_skin_checked="1">
                                    <div class="card-body" bis_skin_checked="1">

                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item px-0">
                                                <h5 class="mb-0"> Payment Method</h5>
                                            </li>
                                            <li class="list-group-item px-0">
                                                <div class="float-end" bis_skin_checked="1">
                                                    <h5 class="mb-0">{{ $order->userPayment->payment->payment_name }}
                                                    </h5>
                                                </div><span class="text-muted">Sub Total</span>
                                            </li>
                                            <li class="list-group-item px-0">
                                                <div class="float-end" bis_skin_checked="1">
                                                    <h5 class="mb-0">{{ $order->userPayment->card_number }}</h5>
                                                </div><span class="text-muted">Account number/Card number</span>
                                            </li>
                                            <li class="list-group-item px-0">
                                                <div class="float-end" bis_skin_checked="1">
                                                    <h5 class="mb-0">{{ $order->status == '0' ? 'Waiting...' : 'Paid' }}
                                                    </h5>
                                                </div><span class="text-muted">Status</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane  show" id="ecomtab-3" role="tabpanel" aria-labelledby="ecomtab-tab-3"
                        bis_skin_checked="1">
                        <div class="row" bis_skin_checked="1">
                            <div class="col-sm-12" bis_skin_checked="1">
                                <div class="card" bis_skin_checked="1">
                                    <div class="card-body" bis_skin_checked="1">

                                        <div class="card shadow-none bg-body mb-0" bis_skin_checked="1">
                                            <div class="card-body" bis_skin_checked="1">
                                                <div class="card" bis_skin_checked="1">
                                                    <div class="card-body" bis_skin_checked="1">
                                                        <div class="row g-3" bis_skin_checked="1">
                                                            <div class="col-12" bis_skin_checked="1">
                                                                <div class="row align-items-center g-3"
                                                                    bis_skin_checked="1">
                                                                    <div class="col-sm-6" bis_skin_checked="1">
                                                                        <div class="d-flex align-items-center mb-2"
                                                                            bis_skin_checked="1">
                                                                            @if ($order->status == 0)
                                                                                <span
                                                                                    class="badge text-bg-danger">Cancelled</span>
                                                                            @elseif ($order->status == 1)
                                                                                <span
                                                                                    class="badge text-bg-light text-dark">Awaiting
                                                                                    Payment</span>
                                                                            @elseif ($order->status == 2)
                                                                                <span
                                                                                    class="badge text-bg-warning text-dark">Waiting
                                                                                    Confirmation</span>
                                                                            @elseif ($order->status == 3)
                                                                                <span
                                                                                    class="badge text-bg-primary">Preparing</span>
                                                                            @elseif($order->status == 4)
                                                                                <span
                                                                                    class="badge text-bg-light text-secondary">Being
                                                                                    Transported</span>
                                                                            @else
                                                                                <span
                                                                                    class="badge text-bg-success">'Delivered
                                                                                    successfully'</span>
                                                                            @endif
                                                                        </div>
                                                                        <p class="mb-0">#WM-{{ $order->id }}</p>
                                                                    </div>
                                                                    <div class="col-sm-6 text-sm-end"
                                                                        bis_skin_checked="1">
                                                                        <h6>Date :<span
                                                                                class="text-muted f-w-400">{{ $order->created_at }}</span>
                                                                        </h6>
                                                                        <h6>Due Date :<span
                                                                                class="text-muted f-w-400">{{ $order->updated_at }}</span>
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6" bis_skin_checked="1">
                                                                <div class="border rounded p-3" bis_skin_checked="1">
                                                                    <h6 class="mb-0">To:</h6>
                                                                    <h5>{{ $order->user->full_name }}</h5>
                                                                    <p class="mb-0">{{ $order->address }}</p>
                                                                    <p class="mb-0">{{ $order->user->phone_number }}</p>
                                                                    <p class="mb-0">{{ $order->user->email }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-12" bis_skin_checked="1">
                                                                <div class="table-responsive" bis_skin_checked="1">
                                                                    <table class="table table-hover mb-0">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Product</th>
                                                                                <th>Price</th>
                                                                                <th>Quantity</th>
                                                                                <th>Total</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($listProductInOrder as $key => $item)
                                                                                <tr>
                                                                                    <td>{{ $key + 1 }}</td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center"
                                                                                            bis_skin_checked="1">
                                                                                            <div class="flex-shrink-0"
                                                                                                bis_skin_checked="1">
                                                                                                <img src="{{ asset('storage/products') }}/{{ $item->product_variant_img }}"
                                                                                                    alt="image"
                                                                                                    class="bg-light rounded"
                                                                                                    style="width:50px ; height:50px; oject-fit:cover">
                                                                                            </div>
                                                                                            <div class="flex-grow-1 ms-3"
                                                                                                bis_skin_checked="1">
                                                                                                <h5 class="mb-1">
                                                                                                    {{ $item->product->product_name }}
                                                                                                </h5>
                                                                                                <div class="d-flex">
                                                                                                    <span
                                                                                                        class="badge rounded-pill  me-2"
                                                                                                        style="background-color: {{ $item->color->color_value }}">{{ $item->color->color_name }}</span>
                                                                                                    <span
                                                                                                        class="badge rounded-pill text-bg-secondary">{{ $item->material->material_value }}</span>

                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="text-center">
                                                                                        <h5 class="mb-0">
                                                                                            ${{ $item->price }}</h5>
                                                                                    </td>
                                                                                    <td class="text-center">
                                                                                        <h5 class="mb-0 text-center">
                                                                                            x{{ $item->quantity }}</h5>
                                                                                    </td>
                                                                                    <td class="text-center">
                                                                                        <h5 class="mb-0">
                                                                                            ${{ $item->price * $item->quantity }}
                                                                                        </h5>
                                                                                    </td>

                                                                                </tr>
                                                                            @endforeach



                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="text-start" bis_skin_checked="1">
                                                                    <hr class="mb-2 mt-1">
                                                                </div>
                                                            </div>
                                                            <div class="col-12" bis_skin_checked="1">
                                                                <div class="invoice-total ms-auto" bis_skin_checked="1">
                                                                    <div class="row" bis_skin_checked="1">

                                                                        <div class="col-6" bis_skin_checked="1">
                                                                            <p class="text-muted mb-1 text-start">Sub Total
                                                                                :</p>
                                                                        </div>
                                                                        <div class="col-6" bis_skin_checked="1">
                                                                            <p class="f-w-600 mb-1 text-end">
                                                                                ${{ $total }}.00</p>
                                                                        </div>
                                                                        <div class="col-6" bis_skin_checked="1">
                                                                            <p class="text-muted mb-1 text-start">Fee
                                                                                Deliver
                                                                                :</p>
                                                                        </div>
                                                                        <div class="col-6" bis_skin_checked="1">
                                                                            <p class="f-w-600 mb-1 text-end text-success">
                                                                                +${{ $order->shipping->fee }}.00</p>
                                                                        </div>
                                                                        @if ($voucher)
                                                                            <div class="col-6" bis_skin_checked="1">
                                                                                <p class="text-muted mb-1 text-start">
                                                                                    Voucher
                                                                                    :</p>
                                                                            </div>
                                                                            <div class="col-6" bis_skin_checked="1">
                                                                                <p class="f-w-600 mb-1 text-end">
                                                                                    -${{ ($total * $voucher->discount) / 100 }}
                                                                                </p>
                                                                            </div>
                                                                        @endif
                                                                        <div class="col-6" bis_skin_checked="1">
                                                                            <p class="f-w-600 mb-1 text-start">Grand Total
                                                                                :</p>
                                                                        </div>
                                                                        <div class="col-6" bis_skin_checked="1">
                                                                            <p class="f-w-600 mb-1 text-end">
                                                                                @if ($voucher)
                                                                                   ${{($total + $order->shipping->fee) -($total + $order->shipping->fee) * $voucher->discount /100  }}
                                                                                @else
                                                                                ${{ $total  + $order->shipping->fee}}
                                                                                @endif
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row d-print-none align-items-center justify-content-end"
                                                    bis_skin_checked="1">
                                                    <div class="col-auto btn-page" bis_skin_checked="1">
                                                        <a href="{{ route('admin.orders.exportPDF', $order->id) }}"
                                                            class="btn btn-outline-secondary btn-print-invoice">Download
                                                            PDF</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- [ sample-page ] end -->
        </div>
    </div>
    <script>
        var changeDate = function(data) {
            if (data == null) return "---";
            var createdAt = new Date(data);
            var day = createdAt.getDate();
            var month = createdAt.getMonth() + 1; // Tháng được đánh số từ 0 đến 11, nên cần +1
            var year = createdAt.getFullYear();
            var formattedDate = day + "/" + month + "/" + year;
            return formattedDate;
        }
        var select = document.querySelector('#inlineFormSelectPref')
        document.querySelector('.save').addEventListener('click', function() {
            if (select.value == " ") {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Not thing to change!",
                });
            } else {
                showLoader()
                var id = `{{ $order->id }}`;

                var url = `{{ URL::to('admin/orders/update/${id}') }}`;
                var token = '{{ csrf_token() }}';
                $.ajax({
                    url: url,
                    data: {
                        _token: token,
                        status: select.value
                    },
                    "method": "POST",
                    success: function(response) {
                        stopLoader();
                        console.log(response);
                        if (response == true) {
                            Swal.fire({
                                icon: "success",
                                title: "You have changed order status sucessfully",
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                    },
                    error: function(xhr, status, error) {

                    }

                });
            }
        })
    </script>
@endsection
