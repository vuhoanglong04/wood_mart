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
                            <li class="breadcrumb-item"><a href="{{ route('admin.topics.index') }}">Topics List</a></li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Topics List</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                @can('topics.add')
                    <div class="card-header">
                        <div class="row">
                            <form class="col-sm-6" method="post" action="{{ route('admin.topics.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="exampleInputEmail1">Topic Name</label>
                                    <input type="text" class="form-control @error('topic_name'){{ 'is-invalid' }}@enderror"
                                        value="{{ old('topic_name') }}" name="topic_name" placeholder="Enter topic name">
                                    @error('topic_name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="exampleInputEmail1">Parent Topic</label>
                                    <select class="mb-0 form-select @error('parent_topic_id'){{ 'is-invalid' }}@enderror"
                                        name="parent_topic_id">
                                        <option value="0" selected="">None</option>
                                        @foreach ($topics as $item)
                                            <option value="{{ $item->id }}">{{ $item->topic_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('parent_topic_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" style="color:white" class="btn btn-primary"><i
                                        class="ph-duotone ph-plus-circle" style="margin-top: 3px"></i> Add New
                                    Topic</button>
                            </form>
                        </div>

                    </div>
                @endcan
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="30%">#ID</th>
                                    <th>Topic Name</th>
                                    <th>Parent Topic</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topics as $item)
                                    <tr id="topics_{{ $item->id }}">
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->topic_name }}</td>
                                        <td>{{ $item->parent_topic_id }}</td>

                                        <td class='status'>
                                            @if ($item->deleted_at == null)
                                                <span class="badge bg-light-success">Active</span>
                                            @else
                                                <span class="badge bg-light-danger">Disabled</span>
                                            @endif
                                        </td>
                                        <td class='action'>
                                            @can('topics.edit')
                                                <a href="{{ route('admin.topics.edit', $item->id) }}"
                                                    class="avtar avtar-xs btn-link-secondary">
                                                    <i class="ti ti-edit f-20"></i>
                                                </a>
                                            @endcan

                                            @if (!$item->deleted_at)
                                                @can('topics.delete')
                                                    <a data-id="{{ $item->id }}" data-name="{{ $item->topic_name }}"
                                                        class="avtar avtar-xs btn-link-secondary disable edit">
                                                        <i class="ti ti-eye-off f-20"></i>
                                                    </a>
                                                @endcan
                                            @else
                                                @can('topics.restore')
                                                    <a data-id="{{ $item->id }}" data-name="{{ $item->topic_name }}"
                                                        class="avtar avtar-xs btn-link-secondary enable edit">
                                                        <i class="ti ti-eye f-20 "></i>
                                                    </a>
                                                @endcan
                                            @endif
                                            @can('topics.forceDelete')
                                                <a data-id="{{ $item->id }}" data-name="{{ $item->topic_name }}"
                                                    class="avtar avtar-xs btn-link-secondary delete_topic">
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
                    title: `Do you want to disable topic ${name}?`,
                    icon: "warning",
                    showDenyButton: true,
                    confirmButtonText: "Hidden",
                    denyButtonText: `Cancel`
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var url = `{{ URL::to('admin/topics/softDelete/${id}') }}`;
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
                                        `#topics_${id} .status span`)
                                    span.classList.remove('bg-light-success');
                                    span.classList.add('bg-light-danger');
                                    span.innerText = "Disabled";

                                    var btn = document.querySelector(`#topics_${id} .edit`)
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
                                        title: "Disabled topic successfully",
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
                    title: `Do you want to enable topic ${name}?`,
                    icon: "warning",
                    showDenyButton: true,
                    confirmButtonText: "Hidden",
                    denyButtonText: `Cancel`
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var url = `{{ URL::to('admin/topics/restore/${id}') }}`;
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
                                        `#topics_${id} .status span`)
                                    span.classList.remove('bg-light-danger');
                                    span.classList.add('bg-light-success');
                                    span.innerText = "Active";

                                    var btn = document.querySelector(`#topics_${id} .edit`)
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
                                        title: "Active topic successfully",
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
                    title: `Do you want to permanently delete topic ${name}`,
                    icon: "warning",
                    showDenyButton: true,
                    confirmButtonText: "Delete",
                    denyButtonText: `Cancel`
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var url = `{{ URL::to('admin/topics/${id}') }}`;
                        var token = '{{ csrf_token() }}';
                        $.ajax({
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': token
                            },
                            "method": "DELETE",
                            success: function(response) {
                                if (response == true) {
                                    $(`#topics_${id}`).remove();
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

            $('.action .delete_topic').click(function() {
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
