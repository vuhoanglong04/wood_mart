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
                            <li class="breadcrumb-item"><a href="{{ route('admin.groups.index') }}">Groups List</a></li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Groups List</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <form class="col-sm-6" method="post" action="{{ route('admin.groups.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="exampleInputEmail1">Group Name</label>
                                <input type="text" class="form-control @error('group_name'){{ 'is-invalid' }}@enderror"
                                    value="{{ old('group_name') }}" name="group_name" placeholder="Enter group name">
                                @error('group_name')
                                <div class="invalid-feedback d-block">{{$message }}</div>

                                @enderror

                            </div>

                            <button type="submit" style="color:white" class="btn btn-primary"><i
                                    class="ph-duotone ph-plus-circle" style="margin-top: 3px"></i> Add New
                                Group</button>



                        </form>
                    </div>

                </div>

                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="30%">#ID</th>
                                    <th>Group Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groups as $item)
                                    <tr id="group_{{ $item->id }}">
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->group_name }}</td>
                                        <td class='status'>
                                            @if ($item->deleted_at == null)
                                                <span class="badge bg-light-success">Active</span>
                                            @else
                                                <span class="badge bg-light-danger">Disabled</span>
                                            @endif
                                        </td>
                                        <td class='action'>
                                            {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Open modal for @mdo</button> --}}

                                            <a href="{{ route('admin.groups.edit', $item->id) }}"
                                                class="avtar avtar-xs btn-link-secondary">
                                                <i class="ti ti-edit f-20"></i>
                                            </a>


                                            @if (!$item->deleted_at)
                                                <a data-id="{{ $item->id }}" data-name="{{ $item->group_name }}"
                                                    class="avtar avtar-xs btn-link-secondary disable edit">
                                                    <i class="ti ti-eye-off f-20"></i>
                                                </a>
                                            @else
                                                <a data-id="{{ $item->id }}" data-name="{{ $item->group_name }}"
                                                    class="avtar avtar-xs btn-link-secondary enable edit">
                                                    <i class="ti ti-eye f-20 "></i>
                                                </a>
                                            @endif
                                            <a data-id="{{ $item->id }}" data-name="{{ $item->group_name }}"
                                                class="avtar avtar-xs btn-link-secondary delete_group">
                                                <i class="ti ti-trash f-20"></i>
                                            </a>
                                            <a data-id="{{ $item->id }}" data-name="{{ $item->group_name }}"
                                                class="avtar avtar-xs btn-link-secondary">
                                                <i class="ti ti-hand-off f-20"></i>
                                            </a>
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
                        var url = `{{ URL::to('admin/groups/softDelete/${id}') }}`;
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

            function onRestore(id, name) {
                Swal.fire({
                    title: `Do you want to enable group ${name}?`,
                    icon: "warning",
                    showDenyButton: true,
                    confirmButtonText: "Hidden",
                    denyButtonText: `Cancel`
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var url = `{{ URL::to('admin/groups/restore/${id}') }}`;
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
                                        title: "Active group successfully",
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
                    title: `Do you want to permanently delete group ${name}`,
                    icon: "warning",
                    showDenyButton: true,
                    confirmButtonText: "Delete",
                    denyButtonText: `Cancel`
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var url = `{{ URL::to('admin/groups/${id}') }}`;
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

            $('.action .delete_group').click(function() {
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
