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
                            <li class="breadcrumb-item"><a href="{{ route('admin.reviews.index') }}">Reviews List</a></li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Reviews List</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">

                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">#ID</th>
                                    <th>User</th>
                                    <th>Product</th>
                                    <th>Stars</th>
                                    <th width="30%">Comment</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reviews as $item)
                                    <tr id="reviews_{{ $item->id }}">
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->user->full_name }}</td>
                                        <td>{{$item->product->product_name}}</td>
                                        <td>{{$item->stars}} <i class="fas fa-star text-warning"></i> </td>
                                        <td>{{$item->comment}}</td>
                                        <td class='status'>
                                            @if ($item->deleted_at == null)
                                                <span class="badge bg-light-success">Active</span>
                                            @else
                                                <span class="badge bg-light-danger">Disabled</span>
                                            @endif
                                        </td>
                                        <td class='action'>

                                            @if (!$item->deleted_at)
                                                @can('reviews.delete')
                                                    <a data-id="{{ $item->id }}"
                                                        class="avtar avtar-xs btn-link-secondary disable edit">
                                                        <i class="ti ti-eye-off f-20"></i>
                                                    </a>
                                                @endcan
                                            @else
                                                @can('reviews.restore')
                                                    <a data-id="{{ $item->id }}"
                                                        class="avtar avtar-xs btn-link-secondary enable edit">
                                                        <i class="ti ti-eye f-20 "></i>
                                                    </a>
                                                @endcan
                                            @endif
                                            @can('reviews.forceDelete')
                                                <a data-id="{{ $item->id }}"
                                                    class="avtar avtar-xs btn-link-secondary delete_group">
                                                    <i class="ti ti-trash f-20"></i>
                                                @endcan
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

            function onHidden(id) {
                Swal.fire({
                    title: `Do you want to disable this review?`,
                    icon: "warning",
                    showDenyButton: true,
                    confirmButtonText: "Hidden",
                    denyButtonText: `Cancel`
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var url = `{{ URL::to('admin/reviews/softDelete/${id}') }}`;
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
                                        `#reviews_${id} .status span`)
                                    span.classList.remove('bg-light-success');
                                    span.classList.add('bg-light-danger');
                                    span.innerText = "Disabled";

                                    var btn = document.querySelector(`#reviews_${id} .edit`)
                                    // btn.parentElement.removeChild(btn);
                                    var tag = `<a data-id="${id}"
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
                                        title: "Disabled review successfully",
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
                    title: `Do you want to enable this review?`,
                    icon: "warning",
                    showDenyButton: true,
                    confirmButtonText: "Hidden",
                    denyButtonText: `Cancel`
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var url = `{{ URL::to('admin/reviews/restore/${id}') }}`;
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
                                        `#reviews_${id} .status span`)
                                    span.classList.remove('bg-light-danger');
                                    span.classList.add('bg-light-success');
                                    span.innerText = "Active";

                                    var btn = document.querySelector(`#reviews_${id} .edit`)
                                    // btn.parentElement.removeChild(btn);
                                    var tag = `<a data-id="${id}"
                                                    class="avtar avtar-xs btn-link-secondary disable edit">
                                                    <i class="ti ti-eye-off f-20"></i>
                                                </a>`
                                    btn.insertAdjacentHTML('afterend', tag);
                                    btn.remove();
                                    $('.action .disable').click(function() {
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
                                        title: "Active review successfully",
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

            function onDelete(id) {
                Swal.fire({
                    title: `Do you want to permanently delete this review`,
                    icon: "warning",
                    showDenyButton: true,
                    confirmButtonText: "Delete",
                    denyButtonText: `Cancel`
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var url = `{{ URL::to('admin/reviews/${id}') }}`;
                        var token = '{{ csrf_token() }}';
                        $.ajax({
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': token
                            },
                            "method": "DELETE",
                            success: function(response) {
                                if (response == true) {
                                    $(`#reviews_${id}`).remove();
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
                onDelete(this.dataset.id)
            })
            $('.action .disable').click(function() {
                onHidden(this.dataset.id)
            })
            $('.action .enable').click(function() {
                onRestore(this.dataset.id)
            })

        })
    </script>
@endpush
