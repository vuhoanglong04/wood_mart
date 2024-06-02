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
                            <li class="breadcrumb-item"><a href="{{ route('admin.category.index') }}">Category List</a></li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Category List</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @can('categories.add')
                        <div class="row">
                            <form class="col-sm-6" method="post" action="{{ route('admin.category.store') }}"
                                enctype="multipart/form-data" >
                                <h3>Add New Category</h3>
                                <hr>
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="exampleInputEmail1">Category Name</label>
                                    <input type="text"
                                        class="form-control @error('category_name'){{ 'is-invalid' }}@enderror"
                                        value="{{ old('category_name') }}" name="category_name"
                                        placeholder="Enter category name">
                                    @error('category_name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="exampleInputEmail1">Parent Category</label>
                                    <select class="mb-0 form-select" name="parent_category_id">
                                        <option value="0" selected>None</option>
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class=" mt-3">
                                    <label class="form-label"
                                        for="inputGroupFile01">Icon</label>
                                    <input type="file" name="icon" class="form-control  @error('icon'){{ 'is-invalid' }}@enderror" id="inputGroupFile01">
                                    @error('icon')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class=" mt-3">
                                    <label class="form-label" for="inputGroupFile02">Background</label>
                                    <input type="file" name="background" class="form-control @error('background'){{ 'is-invalid' }}@enderror" id="inputGroupFile02">
                                    @error('background')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                </div>
                                <button type="submit" style="color:white" class="btn btn-primary mt-3"><i
                                        class="ph-duotone ph-plus-circle" style="margin-top: 3px"></i> Add New
                                    Category</button>

                            </form>
                        </div>
                    @endcan
                </div>

                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="30%">#ID</th>
                                    <th>Category Name</th>
                                    <th>Icon</th>
                                    <th>Parent Category Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $item)
                                    <tr id="group_{{ $item->id }}">
                                        <td>{{ $item->id }}</td>
                                        <td><img src="{{$item->icon}}" alt=""></td>
                                        <td>{{ $item->category_name }}</td>
                                        <td>{{ $item->parent_category_id }}</td>
                                        <td class='status'>
                                            @if ($item->deleted_at == null)
                                                <span class="badge bg-light-success">Active</span>
                                            @else
                                                <span class="badge bg-light-danger">Disabled</span>
                                            @endif
                                        </td>
                                        <td class='action'>
                                            {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Open modal for @mdo</button> --}}
                                            @can('categories.edit')
                                                <a href="{{ route('admin.category.edit', $item->id) }}"
                                                    class="avtar avtar-xs btn-link-secondary">
                                                    <i class="ti ti-edit f-20"></i>
                                                </a>
                                            @endcan


                                            @if (!$item->deleted_at)
                                                @can('categories.delete')
                                                    <a data-id="{{ $item->id }}" data-name="{{ $item->category_name }}"
                                                        class="avtar avtar-xs btn-link-secondary disable edit">
                                                        <i class="ti ti-eye-off f-20"></i>
                                                    </a>
                                                @endcan
                                            @else
                                                @can('categories.restore')
                                                    <a data-id="{{ $item->id }}" data-name="{{ $item->category_name }}"
                                                        class="avtar avtar-xs btn-link-secondary enable edit">
                                                        <i class="ti ti-eye f-20 "></i>
                                                    </a>
                                                @endcan
                                            @endif

                                            @can('categories.forceDelete')
                                                <a data-id="{{ $item->id }}" data-name="{{ $item->category_name }}"
                                                    class="avtar avtar-xs btn-link-secondary delete_category">
                                                    <i class="ti ti-trash f-20"></i>
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            function onHidden(id, name) {
                Swal.fire({
                    title: `Do you want to disable group ${name}?`,
                    icon: "warning",
                    showDenyButton: true,
                    confirmButtonText: "Hidden",
                    denyButtonText: `Cancel`
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var url = `{{ URL::to('admin/category/softDelete/${id}') }}`;
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
                                        `#group_${id} .status span`)
                                    span.classList.remove('bg-light-success');
                                    span.classList.add('bg-light-danger');
                                    span.innerText = "Disabled";

                                    var btn = document.querySelector(`#group_${id} .edit`)
                                    // btn.parentElement.removeChild(btn);
                                    var tag = `<a data-id="${id}" data-name="${name}"
                                                    class="avtar avtar-xs btn-link-secondary enable edit">
                                                    <i class="ti ti-eye f-20"></i>
                                                </a>`
                                    btn.insertAdjacentHTML('afterend', tag);
                                    btn.remove();
                                    $('.action .enable').click(function() {
                                        onRestore(this.dataset.id, this.dataset.name)
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
                                        title: "Disabled category successfully",
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

            function onRestore(id, name) {
                Swal.fire({
                    title: `Do you want to enable category ${name}?`,
                    icon: "warning",
                    showDenyButton: true,
                    confirmButtonText: "Hidden",
                    denyButtonText: `Cancel`
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var url = `{{ URL::to('admin/category/restore/${id}') }}`;
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
                                        `#group_${id} .status span`)
                                    span.classList.remove('bg-light-danger');
                                    span.classList.add('bg-light-success');
                                    span.innerText = "Active";

                                    var btn = document.querySelector(`#group_${id} .edit`)
                                    // btn.parentElement.removeChild(btn);
                                    var tag = `<a data-id="${id}" data-name="${name}"
                                                    class="avtar avtar-xs btn-link-secondary disable edit">
                                                    <i class="ti ti-eye-off f-20"></i>
                                                </a>`
                                    btn.insertAdjacentHTML('afterend', tag);
                                    btn.remove();
                                    $('.action .disable').click(function() {
                                        onHidden(this.dataset.id, this.dataset.name)
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
                                        title: "Active category successfully",
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

            function onDelete(id, name) {
                Swal.fire({
                    title: `Do you want to permanently delete category ${name}`,
                    icon: "warning",
                    showDenyButton: true,
                    confirmButtonText: "Delete",
                    denyButtonText: `Cancel`
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var url = `{{ URL::to('admin/category/${id}') }}`;
                        var token = '{{ csrf_token() }}';
                        $.ajax({
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': token
                            },
                            "method": "DELETE",
                            success: function(response) {
                                if (response == true) {
                                    $(`#group_${id}`).remove();
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

            $('.action .delete_category').click(function() {
                onDelete(this.dataset.id, this.dataset.name)
            })
            $('.action .disable').click(function() {
                onHidden(this.dataset.id, this.dataset.name)
            })
            $('.action .enable').click(function() {
                onRestore(this.dataset.id, this.dataset.name)
            })
        })
    </script>
@endpush
