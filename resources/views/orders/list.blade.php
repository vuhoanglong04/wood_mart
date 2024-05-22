@extends('layout.main');
@section('content')
    <style>
        .datatable-table> :not(:last-child)> :last-child>*,
        .table> :not(:last-child)> :last-child>* {
            border-bottom-color: transparent !important;
        }

        .order-profile-list table {
            border-collapse: separate !important;
            border-spacing: 0 10px !important;
        }

        .order-profile-list tbody tr:hover {
            background-color: rgba(57, 70, 95, 0.03);
        }

        table.dataTable.no-footer {
            border-bottom: none !important;
        }

        select[name="orders-table_length"] {
            height: 3rem;
            width: 5rem;
            padding: 0.8rem 2rem 0.8rem 0.75rem;
            font-size: 0.875rem;
            font-weight: 400;
            line-height: 1.5;
            color: #5B6B79;
            background-color: #ffffff !important;
        }

        #orders-table_filter input {
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

        #orders-table_filter input:focus {
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

        .dataTables_wrapper .dataTables_paginate #orders-table_previous {
            cursor: pointer;
            color: white !important;
            border: 1px solid transparent;
            box-shadow: none;
            border-radius: 5px;
        }

        .dataTables_wrapper .dataTables_paginate #orders-table_previous:hover {
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



        .dataTables_wrapper .dataTables_paginate #orders-table_next {
            cursor: pointer;
            color: white !important;
            border: 1px solid transparent;
            box-shadow: none;
            border-radius: 5px;
        }

        .dataTables_wrapper .dataTables_paginate #orders-table_next:hover {
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

        .order-profile-list table tbody tr .overlay-edit .btn,
        .order-profile-list table tbody tr .overlay-edit .introjs-tooltip .introjs-button,
        .introjs-tooltip .order-profile-list table tbody tr .overlay-edit .introjs-button {
            margin: 0 3px;
            width: 50px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
        }

        .datepicker-dropdown {
            top: 46% !important;
        }

        .overlay-edit {
            display: none;
        }

        tr:hover .overlay-edit {
            display: inline
        }
    </style>
    @can('orders.detail')
        <style>
            tr:hover #date {
                display: none
            }
        </style>
    @endcan

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
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Orders List</li>

                        </ul>
                    </div>

                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Orders List</h2>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ sample-page ] start -->
            <div class="col-sm-12">
                <div class="card border-0 table-card order-profile-list p-4">
                    <div class="col-sm-4 mb-3">
                        <label for="" class='mb-2'>Search by date</label>
                        <input type="text" id="datePicker" class="form-control" placeholder="yyyy/mm/dd">

                    </div>
                    <div class="card-body">

                        <div class="table-responsive">

                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
    @push('scripts')
        <script type="module">
            // var hasForceDeletePermission = {{ Gate::allows('users.forceDelete') ? 'true' : 'false' }};

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
                var ordersTable = $("#orders-table").DataTable({
                    "serverSide": true,
                    "processing": true,
                    responsive: true,
                    columnDefs: [{
                            className: 'text-center',
                            targets: '_all'
                        }

                    ],
                    fnInitComplete: function() {
                        $('div.toolbar').html(`
                        <div class="dataTables_length" id="users-table_length">
                            <label><select name="users-table_length" aria-controls="orders-table" class="">
                                    <option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries per page</label></div>
                        `);
                    },
                    language: {
                        searchPlaceholder: "Search",
                        search: "",
                        zeroRecords: `<p class="datatable-empty text-center pt-1" colspan="6">No entries found</p>`,
                    },
                    "ajax": {
                        "url": "{{ route('admin.orders.index') }}",
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
                            "data": "user_id",
                            "title": "user",
                            "className": 'p-3',
                            "render": function(data, type, row) {
                                return row.user.full_name;
                            }
                        },
                        {
                            "data": "address",
                            "name": "address",
                            "title": "address",
                            "orderable": true,
                            "searchable": true
                        }, {
                            "data": "shipping_id",
                            "name": "shipping_id",
                            "title": "Shipping Method",
                            "render": function(data, type, row) {
                                if (type === 'filter' || type === 'sort') {
                                    // Trả về shipping name để sử dụng cho tìm kiếm và sắp xếp
                                    return row.shipping.shipping_name;
                                } else {
                                    // Hiển thị giá trị dữ liệu trong ô
                                    return row.shipping.shipping_name;

                                }
                            }
                        }, {
                            "data": "user_payment_id",
                            "name": "user_payment_id",
                            "title": "Payment",
                            "orderable": true,
                            "searchable": true
                        }, {
                            "data": "total",
                            "name": "total",
                            "title": "total",
                            "render": function(data, type, row) {
                                return `$${data}`
                            }
                        }, {
                            "data": "status",
                            "name": "status",
                            "title": "status",
                            "orderable": true,
                            "searchable": true,
                            "render": function(data, type, row) {
                                var tag = ''
                                if (data == 0) tag =
                                    `<span class="badge text-bg-danger">Cancelled</span>`
                                else if (data == 1) tag =
                                    `<span class="badge text-bg-light text-dark">Awaiting Payment</span>`
                                else if (data == 2) tag =
                                    `<span class="badge text-bg-warning text-dark">Waiting Confirmation</span>`
                                else if (data == 3) tag =
                                    `<span class="badge text-bg-primary">Preparing</span>`
                                else if (data == 4) tag =
                                    `<span class="badge text-bg-light text-secondary">Being Transported</span>`
                                else tag =
                                    `  <span class="badge text-bg-success">Delivered successfully</span>`

                                return tag;
                            }
                        }, {
                            "data": "created_at",
                            "name": "created_at",
                            "title": "Created At",
                            "render": function(data, type, row) {
                                var tag = `<p id='date' class=''>${changeDate(data)}</p>`
                                @can('orders.detail')
                                    tag += `<div class="overlay-edit">
                                                        <div class="btn-group">
                                                        <button class="btn btn-primary dropdown-toggle p-2" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More</button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item detail" onclick="onDetail(${row.id})">Detail</a>
                                                        </div>
                                                </div>
                                                </div>
                                                `
                                @endcan
                                return tag;
                            }
                        },
                    ],
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

                function onDetailOrder(id) {
                    console.log(id);
                }
                $('#datePicker').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    todayHighlight: true,
                    clearBtn: true
                }).on('changeDate', function() {
                    var selectedDate = $(this).val();
                    $('.dataTable').DataTable().column(6).search(selectedDate).draw();

                });



            });
        </script>
    @endpush
    <script>
        function onDetail(id) {
            window.location.href = `{{ URL::to('admin/order-detail/${id}') }}`
        }
    </script>
@endsection
