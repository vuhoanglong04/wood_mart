@extends('layout.main')

@section('content')
    <style>
        .products_list tbody tr:hover {
            background-color: rgba(57, 70, 95, 0.03);
        }

        tbody tr {
            position: relative;
        }

        .prod-action-links {
            position: absolute;
            display: none;
            top: 50%;
            right: 25px;
            transform: translate(25px, -50%);
            padding: 8px;
            border-radius: 8px;
            background: #ffffff;
            box-shadow: 0px 8px 24px rgba(27, 46, 94, 0.12);
            transition: all 0.3s ease-in-out;
            color: black;
        }

        tbody tr:hover .prod-action-links {
            display: inline;
        }

        select[name="products-table_length"] {
            height: 3rem;
            width: 5rem;
            padding: 0.8rem 2rem 0.8rem 0.75rem;
            font-size: 0.875rem;
            font-weight: 400;
            line-height: 1.5;
            color: #5B6B79;
            background-color: #ffffff !important;
        }

        #products-table_filter input {
            padding: 0.8rem 0.75rem;
            font-size: 0.875rem;
            font-weight: 400;
            line-height: 1.5;
            color: #5B6B79;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-color: #ffffff;
            background-clip: padding-box;
            border: 1px solid #DBE0E5;
            border-radius: 8px;
        }

        #products-table_filter input:focus {
            color: #5B6B79;
            background-color: #ffffff;
            border-color: var(--bs-primary);
        }

        .pagination .page-item .page-link {
            margin-left: 2px;
            margin-right: 2px;
            -webkit-border-radius: 50%;
            border-radius: 50%;
        }

        .pagination .page-item .page-link:hover {
            -webkit-border-radius: 50%;
            border-radius: 50%;
        }

        .pagination .page-item.active .page-link {
            -webkit-border-radius: 50%;
            border-radius: 50%;
        }

        .dataTables_wrapper .dataTables_paginate #products-table_previous {
            cursor: pointer;
            color: white !important;
            border: 1px solid transparent;
            box-shadow: none;
            border-radius: 5px;
        }

        .dataTables_wrapper .dataTables_paginate #products-table_previous:hover {
            background-color: #0779ae;

        }

        .dataTables_wrapper .dataTables_paginate .previous {
            cursor: default;
            color: white !important;
            background: #04A9F5 !important;
        }

        .dataTables_wrapper .dataTables_paginate .previous:hover {
            background-color: #0390d0 !important;
        }

        .dataTables_wrapper .dataTables_paginate .previous.disabled {
            cursor: default;
            color: white !important;
            border: 1px solid transparent;
            background: #ccc !important;
            box-shadow: none;
        }

        .dataTables_wrapper .dataTables_paginate a.paginate_button.current {
            background: white;
            color: #ccc;
            border: 1px solid #e0e0e0;
        }

        .dataTables_wrapper .dataTables_paginate a.paginate_button.current:hover {
            background: rgb(230, 230, 230);
            outline: none;
            border: 1px solid #e0e0e0;
        }



        .dataTables_wrapper .dataTables_paginate #products-table_next {
            cursor: pointer;
            color: white !important;
            border: 1px solid transparent;
            box-shadow: none;
            border-radius: 5px;
        }

        .dataTables_wrapper .dataTables_paginate #products-table_next:hover {
            background-color: #0779ae;

        }

        .dataTables_wrapper .dataTables_paginate .next {
            cursor: default;
            color: white !important;
            background: #04A9F5 !important;
        }

        .dataTables_wrapper .dataTables_paginate .next:hover {
            background-color: #0390d0 !important;
        }

        .dataTables_wrapper .dataTables_paginate .next.disabled {
            cursor: default;
            color: white !important;
            border: 1px solid transparent;
            background: #ccc !important;
            box-shadow: none;
        }
    </style>
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
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Products list</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Products list</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card products_list">
            @can('products.add')
                <div class="col-12 p-4 pb-0 text-start" bis_skin_checked="1">
                    <a type="submit" href="{{ route('admin.products.create') }}" style="color:white" class="btn btn-primary"><i
                            class="ph-duotone ph-plus-circle"></i> Add New
                        Products</a>
                        <a href="{{ URL::to('admin/products/export') }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Export to xlsx" style="color:white" class="btn btn-primary"><i class='ph-duotone ph-file-xls'></i></a>

                </div>
            @endcan
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>

    </div>
    @push('scripts')
        <script type="module">
            var changeDate = function(data) {
                if (data == null) return "---";
                var createdAt = new Date(data);
                var day = createdAt.getDate();
                var month = createdAt.getMonth() + 1; // Tháng được đánh số từ 0 đến 11, nên cần +1
                var year = createdAt.getFullYear();
                var formattedDate = day + "/" + month + "/" + year;
                return formattedDate;
            }
            $(function() {
                window.LaravelDataTables = window.LaravelDataTables || {};
                window.LaravelDataTables["products-table"] = $("#products-table").DataTable({
                    "serverSide": true,
                    "processing": true,
                    responsive: true,

                    fnInitComplete: function() {
                        $('div.toolbar').html(`
            <div class="dataTables_length" id="products-table_length">
                <label><select name="products-table_length" aria-controls="products-table" class="">
                        <option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries per page</label></div>
            `);
                    },
                    language: {
                        searchPlaceholder: "Search",
                        search: "",
                        zeroRecords: `<p class="datatable-empty text-center pt-1" colspan="6">No entries found</p>`,
                    },
                    "ajax": {
                        "url": "{{ route('admin.products.index') }}",
                        "type": "GET",
                        "data": function(data) {
                            for (var i = 0, len = data.columns.length; i < len; i++) {
                                if (!data.columns[i].search.value) delete data.columns[i].search;
                                if (data.columns[i].searchable === true) delete data.columns[i].searchable;
                                if (data.columns[i].orderable === true) delete data.columns[i].orderable;
                                if (data.columns[i].data === data.columns[i].name) delete data.columns[i]
                                    .name;
                            }
                            delete data.search.regex;
                        }
                    },

                    "columns": [{
                        "data": "id",

                        "render": function(data, type, row) {
                            return data;
                        }
                    }, {
                        "data": "product_name",
                        "name": "product_name",
                        "title": "Product Detail",
                        "orderable": true,
                        "searchable": true,
                        "render": function(data, type, row) {
                            return `<div class="row">
                            <div class="col-auto pe-0">
                              <img src="{{ '${row.product_theme}' }}" alt="product-image" class="wid-40 rounded">
                            </div>
                            <div class="col">
                              <h6 class="mb-1"><a href="">${row.product_name}</a></h6>
                              <p class="text-muted f-12 mb-0">${row.category?.category_name}</p>
                            </div>
                          </div>

                         `;
                        }
                    }, {
                        "data": "price",
                        "name": "price",
                        "title": "Price",
                        "orderable": true,
                        "searchable": true,
                        "render": function(data, type, row) {
                            return `$${data}`;
                        }
                    }, {
                        "data": 'created_at',
                        "name": "created_at",
                        "title": "created at",
                        "orderable": true,
                        "searchable": true,
                        "render": function(data, type, row) {
                            return changeDate(data);
                        }
                    }, {
                        "data": "updated_at",
                        "name": "updated_at",
                        "title": "Updated At",
                        "orderable": true,
                        "searchable": true,
                        "render": function(data, type, row) {

                            return changeDate(data);

                        }
                    }, {
                        "data": 'deleted_at',
                        "name": "deleted_at",
                        "className": 'status',
                        "title": "status",
                        "orderable": true,
                        "searchable": true,
                        "render": function(data, type, row) {
                            var show = '';
                            var status = "";
                            if (!row.deleted_at) show =
                                `<span class="badge bg-light-success">Active</span>`;
                            else show = '<span class="badge bg-light-danger">Disabled</span>'

                            if (!row.deleted_at) {
                                @can('products.delete')
                                    status = `   <li class="list-inline-item align-bottom hidden"  title="Disable">
                                                    <a onclick="onHidden('${row.id}' , '${row.product_name}')" class="avtar avtar-xs btn-link-secondary btn-pc-default" >
                                                    <i class="ti ti-eye-off f-18"></i>
                                                    </a>
                                            </li>`
                                @endcan
                            } else {
                                @can('products.restore')

                                status = `   <li class="list-inline-item align-bottom show" title="Active">
                                                    <a onclick="onRestore('${row.id}' , '${row.product_name}')" class="avtar avtar-xs btn-link-secondary btn-pc-default" >
                                                    <i class="ti ti-eye f-18"></i>
                                                    </a>
                                            </li>`
                                @endcan

                            }
                            var result = `${show}
                            <div class="prod-action-links" bis_skin_checked="1">
                                <ul class="list-inline me-auto mb-0 ">
                                    ${status}
                                    `;

                            @can('products.edit')
                                result +=
                                    `
                                <li class="list-inline-item align-bottom" title="Edit">
                                    <a onclick="onEdit('${row.id}')" class="avtar avtar-xs btn-link-success btn-pc-default">
                                        <i class="ti ti-edit-circle f-18"></i>
                                        </a>
                                        </li>
                                        `
                            @endcan
                            @can('products.detail')

                                result += `
                              <li class="list-inline-item align-bottom" title="SKU" onclick="onDetail('${row.id}')">
                                <a href="#" class="avtar avtar-xs btn-link-danger btn-pc-default">
                                  <i class="ti ti-grid-dots f-18"></i>
                                </a>
                              </li>`
                            @endcan
                            @can('products.forceDelete')

                                result += `
                              <li class="list-inline-item align-bottom"" title="Delete" onclick="onDelete('${row.id}' , '${row.product_name}')">
                                <a href="#" class="avtar avtar-xs btn-link-danger btn-pc-default">
                                  <i class="ti ti-trash f-18"></i>
                                </a>
                              </li>
                            `
                            @endcan

                            result += `
                            </ul>
                          </div>`
                            return result;
                        }
                    }],
                    createdRow: function(row, data, dataIndex) {

                        $(row).addClass(`product_${data.id}`);
                    },
                    "order": [
                        [0, "asc"]
                    ],
                    "select": {
                        "style": "single"
                    },
                    "buttons": [{
                        "extend": "excel"
                    }, {
                        "extend": "csv"
                    }, {
                        "extend": "pdf"
                    }, {
                        "extend": "print"
                    }, {
                        "extend": "reset"
                    }, {
                        "extend": "reload"
                    }]
                });
            });
        </script>
    @endpush
    <script>
        function onDelete(id, name) {
            Swal.fire({
                title: `Do you want to permanently delete products ${name}`,
                icon: "warning",
                showDenyButton: true,
                confirmButtonText: "Delete",
                denyButtonText: `Cancel`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    var url = `{{ URL::to('admin/products/${id}') }}`;
                    var token = '{{ csrf_token() }}';
                    $.ajax({
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        "method": "DELETE",
                        success: function(response) {
                            if (response == true) {
                                $(`.product_${id}`).remove();
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "bottom-end",
                                    showConfirmButton: false,
                                    timer: 3000,
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

        function onHidden(id, name) {
            console.log(1);
            Swal.fire({
                title: `Do you want to disable product ${name}?`,
                icon: "warning",
                showDenyButton: true,
                confirmButtonText: "Hidden",
                denyButtonText: `Cancel`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    var url = `{{ URL::to('admin/products/softDelete/${id}') }}`;
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
                                    `.product_${id} .status span`)
                                span.classList.remove('bg-light-success');
                                span.classList.add('bg-light-danger');
                                span.innerText = "Disabled";

                                var btn = document.querySelector(`.product_${id} .hidden`)
                                // btn.parentElement.removeChild(btn);
                                var tag = `<li class="list-inline-item align-bottom show" title="Active">
                                                        <a  class="avtar avtar-xs btn-link-secondary btn-pc-default">
                                                        <i class="ti ti-eye f-18"></i>
                                                        </a>
                                                </li>`
                                btn.insertAdjacentHTML('afterend', tag);
                                btn.remove();
                                $(`.product_${id} .show`).click(function() {
                                    onRestore(id, name)
                                })
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "bottom-end",
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                });
                                Toast.fire({
                                    icon: "success",
                                    title: "Disabled product successfully",
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
                title: `Do you want to enable product ${name}?`,
                icon: "warning",
                showDenyButton: true,
                confirmButtonText: "Hidden",
                denyButtonText: `Cancel`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    var url = `{{ URL::to('admin/products/restore/${id}') }}`;
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
                                    `.product_${id} .status span`)
                                span.classList.remove('bg-light-danger');
                                span.classList.add('bg-light-success');
                                span.innerText = "Active";

                                var btn = document.querySelector(`.product_${id} .show`)
                                // btn.parentElement.removeChild(btn);
                                var tag = `<li class="list-inline-item align-bottom hidden" title="Active">
                                                        <a  class="avtar avtar-xs btn-link-secondary btn-pc-default" >
                                                        <i class="ti ti-eye f-18"></i>
                                                        </a>
                                                </li>`
                                btn.insertAdjacentHTML('afterend', tag);
                                btn.remove();
                                $(`.product_${id} .hidden`).click(function() {
                                    onHidden(id, name)
                                })
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "bottom-end",
                                    showConfirmButton: false,
                                    timer: 3000,
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

        function onEdit(id) {
            window.location.href = `{{ URL::to('admin/products/${id}/edit') }}`

        }

        function onDetail(id) {
            window.location.href = `{{ URL::to('admin/products/${id}') }}`

        }
    </script>
@endsection
