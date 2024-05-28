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
                            <li class="breadcrumb-item"><a href="{{ route('admin.vouchers.index') }}">Vouchers List</a></li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Vouchers List</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                @can('vouchers.add')
                    <div class="card-header">
                        <div class="row">

                            <form class="col-sm-6" method="post" action="{{ route('admin.vouchers.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="">Code</label>
                                    <input type="text"maxlength="10"
                                        class="form-control code @error('code'){{ 'is-invalid' }}@enderror" name="code"
                                        placeholder="Enter code" value='{{ old('code') }}'>
                                    @error('code')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                </div>

                                <div class="mb-3">
                                    <label for="demo-range-input @error('discount'){{ 'is-invalid' }}@enderror"
                                        class="form-label">Discount : <b class="percents">20</b>%
                                    </label>
                                    <input class="form-range range" value="20" type="range" name='discount' min="0"
                                        max="100" value="0" id="demo-range-input">
                                    @error('discount')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="example-datemin">Date Expiry</label>
                                    <input type="date" name="date_expiry"
                                        class="form-control @error('date_expiry'){{ 'is-invalid' }}@enderror"
                                        id="example-datemin" min="2000-01-02" value="{{ old('date_expiry') }}">
                                    @error('date_expiry')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" style="color:white" class="btn btn-primary"><i
                                        class="ph-duotone ph-plus-circle" style="margin-top: 3px"></i> Add New
                                    Vouchers</button>
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
                                    <th>Code</th>
                                    <th>Discount</th>
                                    <th>Status</th>
                                    <th>Date Expiry</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vouchers as $key => $item)
                                    <tr id="voucher_{{ $item->id }}">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->code }}</td>
                                        <td>{{ $item->discount }}%</td>
                                        <td>{{ $item->date_expiry }}</td>
                                        <td class='status'>
                                            @if ($item->date_expiry > date('Y-m-d H:i:s'))
                                                <span class="badge bg-light-success">Active</span>
                                            @else
                                                <span class="badge bg-light-danger">Expired</span>
                                            @endif
                                        </td>
                                        <td>
                                            @can('vouchers.update')
                                                <a href="{{ route('admin.vouchers.edit', $item->id) }}"
                                                    class="avtar avtar-xs btn-link-secondary">
                                                    <i class="ti ti-edit f-20"></i>
                                                </a>
                                            @endcan

                                            @can('vouchers.forceDelete')
                                                <a data-id={{ $item->id }}
                                                    class="avtar avtar-xs btn-link-secondary delete_voucher">
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
    <script>
        var range = document.querySelector('.range')
        range.addEventListener('change', function() {
            document.querySelector('.percents').innerText = this.value
        })
        document.querySelector('.code').addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        })
    </script>
@endsection
@push('scripts')
    <script>
        function onDelete(id) {
            Swal.fire({
                title: `Do you want to permanently delete voucher #${id}`,
                icon: "warning",
                showDenyButton: true,
                confirmButtonText: "Delete",
                denyButtonText: `Cancel`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    var url = `{{ URL::to('admin/vouchers/${id}') }}`;
                    var token = '{{ csrf_token() }}';
                    $.ajax({
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        "method": "DELETE",
                        success: function(response) {
                            if (response == true) {
                                $(`#voucher_${id}`).remove();
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

        $('.delete_voucher').click(function() {
            onDelete(this.dataset.id)
        })
    </script>
@endpush
