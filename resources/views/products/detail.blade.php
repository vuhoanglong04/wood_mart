@extends('layout.main')

@section('content')
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
    @if (session('unique'))
        <script>
            Swal.fire({
                title: "Something Is Wrong!",
                text: "{{ session('unique') }}",
                icon: "error"
            });
        </script>
    @endif
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Product List</a></li>
                            <li class="breadcrumb-item" aria-current="page">Products Detail</li>

                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Products Detail</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" bis_skin_checked="1">
            <div class="card-body" bis_skin_checked="1">
                <div class="row" bis_skin_checked="1">
                    <div class="col-md-6" bis_skin_checked="1">
                        <div class="sticky-md-top product-sticky" bis_skin_checked="1">
                            <div id="carouselExampleCaptions" class="carousel slide ecomm-prod-slider"
                                data-bs-ride="carousel" bis_skin_checked="1">
                                <div class="carousel-inner bg-light rounded position-relative border" bis_skin_checked="1">

                                    @foreach ($listVariant as $key => $value)
                                        <div class="carousel-item @if ($key == 0) {{ 'active' }} @endif"
                                            bis_skin_checked="1">
                                            <img src="{{$value->img}}"
                                                class="d-block w-100" alt="Product images">
                                        </div>
                                    @endforeach

                                </div>
                                <ol
                                    class="list-inline carousel-indicators position-relative product-carousel-indicators my-sm-3 mx-0">
                                    @foreach ($listVariant as $key => $value)
                                        <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $key }}"
                                            class="list-inline-item @if ($key == 0) {{ 'active' }} @endif"
                                            style="height: 4rem; width:4rem">
                                            <img src="{{ $value->img }}"
                                                class="d-block wid-50 rounded w-100 h-100" alt="Product images"
                                                style="object-fit: cover;">
                                        </li>
                                    @endforeach

                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" bis_skin_checked="1">

                        <span
                            class="badge bg-{{ !$product->deleted_at ? 'success' : 'danger' }} f-14">{{ !$product->deleted_at ? 'Instock' : 'Disabled' }}</span>
                        <h3 class="my-3">{{ $product->product_name }}</h3>
                        <h3 class="mb-4">
                            <b id="price">${{ $product->price }}.00</b>
                            <span
                                class="mx-2 f-16 text-muted f-w-400 text-decoration-line-through sale">${{ $product->price }}.00</span>
                        </h3>
                        <div class="star f-18 mb-3" bis_skin_checked="1">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star-half-alt text-warning"></i>
                            <i class="far fa-star text-muted"></i>
                            <span class="text-sm text-muted">(4.0)</span>
                        </div>
      
                        <div class="mb-3 row" bis_skin_checked="1">
                            <label class="col-form-label col-lg-2 col-sm-12">Colors <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6 col-md-12 col-sm-12 d-flex align-items-center allColor"
                                bis_skin_checked="1">

                            </div>
                        </div>
                        <div class=" row align-items-center" bis_skin_checked="1">
                            <label class="col-form-label col-lg-2 col-sm-12">
                                <span class="d-block">Size</span></label>
                            <div class="col-lg-9 col-md-12 col-sm-12 " bis_skin_checked="1">
                                <div class="row g-2 allMaterial" bis_skin_checked="1">

                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center" bis_skin_checked="1">
                            <label class="col-form-label col-lg-6 col-sm-12">
                                <span style="display: none">Quantity in stock: <b id="qty_in_stock"> 12
                                        (items)</b></span></label>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @can('productsVariant.add')
                <div class="card col-xl-4" bis_skin_checked="1">
                    <div class="card-header" bis_skin_checked="1">
                        <h5 id="add">Add Variants</h5>
                    </div>
                    <div class="card-body" bis_skin_checked="1">

                        <form action="{{ route('admin.productsVariation.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="id" value="{{ $product->id }}" style="display: none;">
                            <div class=" mb-3" bis_skin_checked="1">
                                <label class="form-label">Colors</label>
                                <div class="col-lg-12 col-md-12 col-sm-12 d-flex align-items-center flex-wrap mb-0 p-2"
                                    bis_skin_checked="1">

                                    @foreach ($colors as $key => $item)
                                        <div class="form-check form-check-inline color-checkbox mb-0 me-4 text-start h-50"
                                            bis_skin_checked="1">
                                            <input class="form-check-input" type="radio" name="color_id[]"
                                                value="{{ $item->id }}"
                                                {{ $item->id == old('color_id.' . 0) ? 'checked' : '' }}>
                                            <i class="fas fa-circle text-primary"
                                                style="color:{{ $item->color_value }} !important; margin-right:5px"></i>
                                            <p class="mb-0">{{ $item->color_name }}</p>
                                        </div>
                                    @endforeach
                                </div>
                                @error('color_id')
                                    <span style="color:red" class=''>{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3" bis_skin_checked="1">
                                <label class="form-label">Materials</label>
                                <select class="form-select @error('material_id'){{ 'is-invalid' }}@enderror"
                                    name="material_id">
                                    <option value="" selected hidden>Select Material</option>
                                    @foreach ($materials as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == old('material_id') ? 'selected' : '' }}>
                                            {{ $item->material_value }}</option>
                                    @endforeach
                                </select>
                                @error('material_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3" bis_skin_checked="1">
                                <label class="form-label d-flex align-items-center">Price <i class="ph-duotone ph-info ms-1"
                                        data-bs-toggle="tooltip" data-bs-title="Price"></i></label>
                                <div class="input-group" bis_skin_checked="1">
                                    <span style=" @error('price'){{ 'border:red 1px solid' }}@enderror"
                                        class="input-group-text">$</span>
                                    <input type="text" class="form-control @error('price'){{ 'is-invalid' }}@enderror"
                                        placeholder="Price" name="price" value="{{ old('price') }}">
                                </div>
                                @error('price')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3" bis_skin_checked="1">
                                <label class="form-label">Quantity</label>
                                <input type="text" class="form-control @error('qty_in_stock'){{ 'is-invalid' }}@enderror"
                                    placeholder="Enter Quantity" name="qty_in_stock" value="{{ old('qty_in_stock') }}">
                                @error('qty_in_stock')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3" bis_skin_checked="1">
                                <label class="form-label">Variant Image</label>
                                <br>
                                <label class="btn btn-outline-secondary" for="flupld"><i class="ti ti-upload me-2"></i>
                                    Click to Upload</label>
                                <input type="file" id="flupld" class="d-none" name="img">
                                @error('img')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            @if (session('unique'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('unique') }}
                                </div>
                            @endif
                            <button onclick ="onAddVariant()"class="btn btn-primary mb-0">Save</button>
                        </form>
                    </div>
                </div>
            @endcan
            @can('productsVariant.view')


            <div class="col-md-8" bis_skin_checked="1">
                <div class="card" bis_skin_checked="1">
                    <div class="card-header" bis_skin_checked="1">
                        <h5>Variants</h5>
                    </div>
                    <div class="card-body table-border-style" bis_skin_checked="1">
                        <div class="table-responsive" bis_skin_checked="1">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th>Color</th>
                                        <th>Materials</th>
                                        <th>Price</th>
                                        <th>Quantity (Unit)</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listVariant as $item)
                                        <tr id='variant_{{ $item->id }}'>
                                            <td>{{ $item->color->color_name }}</td>
                                            <td>{{ $item->material->material_value }}</td>
                                            <td>${{ $item->price }}.00</td>
                                            <td>{{ $item->qty_in_stock }}</td>
                                            <td class="status">
                                                @if (!$item->deleted_at)
                                                    <span class="badge bg-light-success">Active</span>
                                                @else
                                                    <span class="badge bg-light-danger">Disabled</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="prod-action-links" bis_skin_checked="1">
                                                    <ul class="list-inline me-auto mb-0 ">
                                                        @if (!$item->deleted_at)
                                                            @can('productsVariant.delete')
                                                                <li class="list-inline-item align-bottom" title="Disable">
                                                                    <a data-id="{{ $item->id }}"
                                                                        class="avtar avtar-xs btn-link-secondary btn-pc-default hiddenVariant">
                                                                        <i class="ti ti-eye-off f-18"></i>
                                                                    </a>
                                                                </li>
                                                            @endcan
                                                        @else
                                                            @can('productsVariant.restore')
                                                                <li class="list-inline-item align-bottom" title="Enable">
                                                                    <a data-id="{{ $item->id }}"
                                                                        class="avtar avtar-xs btn-link-secondary btn-pc-default restore">
                                                                        <i class="ti ti-eye f-18"></i>
                                                                    </a>
                                                                </li>
                                                            @endcan
                                                        @endif

                                                        @can('productsVariant.forceDelete')
                                                            <li class="list-inline-item align-bottom" title="Delete">
                                                                <a data-id="{{ $item->id }}"
                                                                    class="avtar avtar-xs btn-link-danger btn-pc-default forceDelete">
                                                                    <i class="ti ti-trash f-18"></i>
                                                                </a>
                                                            </li>
                                                        @endcan
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endcan
        </div>
    </div>
    @if ($errors->any() || session('unique') || session('success'))
        <script>
            window.addEventListener('DOMContentLoaded', (event) => {
                const paraElement = document.getElementById('add');
                paraElement.scrollIntoView();
            });
        </script>
    @endif
@endsection
@push('scripts')
    <script>
        showLoader();
        $(document).ready(function() {
            var id = `{{ $product->id }}`;
            var url = `{{ URL::to('admin/productsVariation/${id}') }}`;
            var token = '{{ csrf_token() }}';
            $.ajax({
                url: url,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                "method": "GET",
                success: function(response) {
                    var map1 = new Map();
                    var map2 = new Map();
                    for (item of response) {
                        map1.set(item.color_id, item.color.color_value);
                        map2.set(item.material_id, item.material.material_value);
                    }
                    var allColor = document.querySelector('.allColor');
                    var allMaterial = document.querySelector('.allMaterial');

                    for (const [key, value] of map1) {
                        var tag = ` <div class="form-check form-check-inline color-checkbox mb-0" bis_skin_checked="1">
                                    <input class="form-check-input color" value="${key}" type="radio"
                                        name="product_color">
                                    <i class="fas fa-circle"
                                        style="color:${value} !important; margin-right:5px"></i>
                                </div>`
                        allColor.insertAdjacentHTML('beforeend', tag);
                    }
                    var i = 0;
                    for (const [key, value] of map2) {
                        var tag = `  <div class="col-auto" bis_skin_checked="1">
                                            <input type="radio" class="btn-check material"
                                                id="btnrdolite_${key}" name="btn_radio2"
                                                value="${key}" disabled>
                                            <label class="btn btn-sm btn-light-primary"
                                                for="btnrdolite_${key}">${value}</label>
                                        </div>`
                        i++;
                        allMaterial.insertAdjacentHTML('beforeend', tag);
                    }
                    stopLoader();
                    var colorChecking = -1;
                    var colors = document.querySelectorAll('.color');
                    var materials = document.querySelectorAll('.material');

                    colors.forEach(color => {
                        color.addEventListener('change', function() {
                            colorChecking = this.value;
                            var listRadioMaterial = document.querySelectorAll(
                                '.material');

                            listRadioMaterial.forEach(item => {
                                if (item.disabled) {
                                    item.removeAttribute('disabled');
                                }
                                if (item.checked) {
                                    item.checked = false;
                                }
                            });

                            var id_color = this.value;
                            var listMate = new Set();
                            for (item of response) {
                                if (item.color_id == id_color) {
                                    listMate.add(item.material_id);
                                }
                            }


                            listRadioMaterial.forEach(item => {
                                if (!listMate.has(Number(item.value))) {
                                    item.setAttribute('disabled', true);
                                }
                            })
                        })
                    });
                    materials.forEach(item => {
                        item.addEventListener('change', function() {
                            showLoader();
                            for (x of response) {
                                if (x.color_id == colorChecking && x.material_id == item
                                    .value) {

                                    document.getElementById('price').innerText =
                                        `$${x.price}.00`
                                    document.querySelector('.sale').innerText =
                                        `$${x.price  + (x.price*20 /100)}.00`
                                    var quantity = document.querySelector(
                                        '#qty_in_stock')

                                    quantity.parentElement.style.display = 'flex';
                                    quantity.innerText = `${x.qty_in_stock} (items)`
                                    stopLoader();
                                }
                            }
                        })
                    })
                },
                error: function(xhr, status, error) {

                }

            });
        });

        function onDelete(id) {
            showLoader();
            Swal.fire({
                title: `Do you want to permanently delete this variant?`,
                icon: "warning",
                showDenyButton: true,
                confirmButtonText: "Delete",
                denyButtonText: `Cancel`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                stopLoader();
                if (result.isConfirmed) {
                    var url = `{{ URL::to('admin/productsVariation/${id}') }}`;
                    var token = '{{ csrf_token() }}';
                    $.ajax({
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        "method": "DELETE",
                        success: function(response) {
                            if (response == true) {
                                stopLoader();
                                $(`#variant_${id}`).remove();
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
                                    title: "Deleted Success",
                                });
                                document.querySelector('.swal2-container').classList.remove(
                                    'swal2-backdrop-show')
                                document.querySelector('.swal2-container').classList.add(
                                    'mb-2')
                            }
                        },
                        error: function(xhr, status, error) {

                        }

                    });
                }
            });
        }

        function onRestore(id) {
            Swal.fire({
                title: `Do you want to enable this variant?`,
                icon: "warning",
                showDenyButton: true,
                confirmButtonText: "Hidden",
                denyButtonText: `Cancel`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    var url = `{{ URL::to('admin/productsVariation/restore/${id}') }}`;
                    var token = '{{ csrf_token() }}';
                    $.ajax({
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        "method": "GET",
                        success: function(response) {
                            if (response == true) {
                                var span = document.querySelector(
                                    `#variant_${id} .status span`)
                                span.classList.remove('bg-light-danger');
                                span.classList.add('bg-light-success');
                                span.innerText = "Active";

                                var btn = document.querySelector(`#variant_${id} .restore`)
                                // btn.parentElement.removeChild(btn);
                                var tag = `
                                                            <a data-id="${id}"
                                                                class="avtar avtar-xs btn-link-secondary btn-pc-default hiddenVariant">
                                                                <i class="ti ti-eye-off f-18"></i>
                                                            </a>
                                              `
                                btn.insertAdjacentHTML('afterend', tag);
                                btn.remove();
                                $('.hiddenVariant').click(function() {
                                    onHidden(this.dataset.id)
                                })
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
                                    title: "Enable variant successfully",
                                });
                                document.querySelector('.swal2-container').classList.remove(
                                    'swal2-backdrop-show')
                                document.querySelector('.swal2-container').classList.add(
                                    'mb-2')
                            }
                        },
                        error: function(xhr, status, error) {

                        }

                    });
                }
            });
        }

        function onHidden(id) {
            Swal.fire({
                title: `Do you want to disable this variant?`,
                icon: "warning",
                showDenyButton: true,
                confirmButtonText: "Hidden",
                denyButtonText: `Cancel`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    var url = `{{ URL::to('admin/productsVariation/softDelete/${id}') }}`;
                    var token = '{{ csrf_token() }}';
                    $.ajax({
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        "method": "DELETE",
                        success: function(response) {
                            if (response == true) {
                                var span = document.querySelector(
                                    `#variant_${id} .status span`)
                                span.classList.remove('bg-light-success');
                                span.classList.add('bg-light-danger');
                                span.innerText = "Disabled";

                                var btn = document.querySelector(`#variant_${id} .hiddenVariant`)
                                // btn.parentElement.removeChild(btn);
                                var tag = `
                                                            <a data-id="${id}"
                                                                class="avtar avtar-xs btn-link-secondary btn-pc-default restore">
                                                                <i class="ti ti-eye f-18"></i>
                                                            </a>
                                              `
                                btn.insertAdjacentHTML('afterend', tag);
                                btn.remove();
                                $('.restore').click(function() {
                                    onRestore(this.dataset.id)
                                })
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
                                    title: "Disabled group successfully",
                                });
                                document.querySelector('.swal2-container').classList.remove(
                                    'swal2-backdrop-show')
                                document.querySelector('.swal2-container').classList.add(
                                    'mb-2')
                            }
                        },
                        error: function(xhr, status, error) {

                        }

                    });
                }
            });
        }
        $('.forceDelete').click(function() {
            onDelete(this.dataset.id)
        })
        $('.hiddenVariant').click(function() {
            onHidden(this.dataset.id)
        })
        $('.restore').click(function() {
            onRestore(this.dataset.id)
        })
    </script>
@endpush
