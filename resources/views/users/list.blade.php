@extends('layout.main');
@section('content')
    <style>
        .datatable-table> :not(:last-child)> :last-child>*,
        .table> :not(:last-child)> :last-child>* {
            border-bottom-color: transparent !important;
        }

        .user-profile-list table {
            border-collapse: separate !important;
            border-spacing: 0 10px !important;
        }

        .user-profile-list tbody tr:hover {
            background-color: rgba(57, 70, 95, 0.03);
        }

        table.dataTable.no-footer {
            border-bottom: none !important;
        }

        select[name="users-table_length"] {
            height: 3rem;
            width: 5rem;
            padding: 0.8rem 2rem 0.8rem 0.75rem;
            font-size: 0.875rem;
            font-weight: 400;
            line-height: 1.5;
            color: #5B6B79;
            background-color: #ffffff !important;
        }

        #users-table_filter input {
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

        #users-table_filter input:focus {
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

        .dataTables_wrapper .dataTables_paginate #users-table_previous {
            cursor: pointer;
            color: white !important;
            border: 1px solid transparent;
            box-shadow: none;
            border-radius: 5px;
        }

        .dataTables_wrapper .dataTables_paginate #users-table_previous:hover {
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



        .dataTables_wrapper .dataTables_paginate #users-table_next {
            cursor: pointer;
            color: white !important;
            border: 1px solid transparent;
            box-shadow: none;
            border-radius: 5px;
        }

        .dataTables_wrapper .dataTables_paginate #users-table_next:hover {
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

        .user-profile-list table tbody tr .overlay-edit .btn,
        .user-profile-list table tbody tr .overlay-edit .introjs-tooltip .introjs-button,
        .introjs-tooltip .user-profile-list table tbody tr .overlay-edit .introjs-button {
            margin: 0 3px;
            width: 50px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
        }
    </style>
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
                            <li class="breadcrumb-item" aria-current="page">User List</li>
                        </ul>
                    </div>

                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">User List</h2>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        @can('user.add')
            <div class="col-12 mt-4 mb-4">
                <a type="submit" href="{{ route('admin.users.add') }}" style="color:white" class="btn btn-primary"><i
                        class="ph-duotone ph-plus-circle"></i> Add New
                    User</a>
                <a type="submit" href="{{ route('admin.users.export') }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Export to xlsx" style="color:white" class="btn btn-primary"><i class='ph-duotone ph-file-xls'></i></a>
            </div>
        @endcan
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ sample-page ] start -->
            <div class="col-sm-12">
                <div class="card border-0 table-card user-profile-list">
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
            var hasForceDeletePermission = {{ Gate::allows('users.forceDelete') ? 'true' : 'false' }};
            console.log(hasForceDeletePermission);
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
                window.LaravelDataTables["users-table"] = $("#users-table").DataTable({
                    "serverSide": true,
                    "processing": true,
                    responsive: true,

                    fnInitComplete: function() {
                        $('div.toolbar').html(`
                        <div class="dataTables_length" id="users-table_length">
                            <label><select name="users-table_length" aria-controls="users-table" class="">
                                    <option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries per page</label></div>
                        `);
                    },
                    language: {

                        searchPlaceholder: "Search",
                        search: "",
                        zeroRecords: `<p class="datatable-empty text-center pt-1" colspan="6">No entries found</p>`,
                    },

                    "ajax": {
                        "url": "{{ route('admin.users.list') }}",
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
                            "data": "full_name",
                            "className": 'p-3',
                            "render": function(data, type, row) {
                                // console.log(row);
                                var role = "";
                                if (row.group_id == 1) role = "Staff"
                                else if (row.group_id == 2) role = "Admintrator";
                                else role = "Customer"
                                var path = 'storage/user/' + row.img;
                                return `<div class="d-inline-block align-middle">
                                            <img src="{{ asset('${path}') }}" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
                                            <div class="d-inline-block">
                                                <h6 class="m-b-0">${row.full_name}</h6>
                                                <p class="m-b-0 text-primary">
                                                ${role}
                                                </p>
                                            </div>
                                        </div>`
                            }
                        },
                        {
                            "data": "email",
                            "name": "email",
                            "title": "Email",
                            "orderable": true,
                            "searchable": true
                        }, {
                            "data": "phone_number",
                            "name": "phone_number",
                            "title": "Phone Number",
                            "orderable": true,
                            "searchable": true
                        }, {
                            "data": "created_at",
                            "name": "created_at",
                            "title": "Created At",
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
                            "data": "status",
                            "name": "status",
                            "title": "Status",
                            "orderable": true,
                            "searchable": true,
                            "render": function(data, type, row) {
                                var status = "";
                                if (row.deleted_at == null) {
                                    status = '<span class="badge bg-light-success">Active</span>'
                                } else status = '<span class="badge bg-light-danger">Disabled</span>'
                                var result = `${status}
                                        <div class="overlay-edit">
                                            <div class="btn-group mb-2 me-2">
                                            <button class="btn btn-primary dropdown-toggle p-2" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More</button>
                                            <div class="dropdown-menu">`
                                @can('user.detail')

                                    result +=
                                        ` <a class="dropdown-item" onclick="onDetail('${row.id}')">Detail</a>`
                                @endcan

                                @can('user.edit')

                                    result +=
                                        `<a class="dropdown-item" onclick="onEdit('${row.id}')">Edit</a>`;
                                @endcan

                                if (!row.deleted_at) {
                                    @can('user.delete')
                                        result +=
                                            `<a class="dropdown-item" onclick="onLock('${row.id}' ,'${row.full_name}' )">Lock account</a>`
                                    @endcan
                                } else {
                                    @can('user.restore')
                                        result +=
                                            `<a class="dropdown-item" onclick="onUnLock('${row.id}' ,'${row.full_name}' )">Unlock account</a>`
                                    @endcan
                                }
                                @can('user.forceDelete')

                                    result += `<a class="dropdown-item" onclick="forceDelete('${row.id}' ,'${row.full_name}' )">Force Delete (<span style='color:red'>*</span>)</a>
                                </div>
                                </div>
                                </div>
                                `;
                                @endcan

                                return result;
                            }
                        }
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
            });
        </script>
    @endpush
    <script>
        function onLock(id, name) {
            Swal.fire({
                title: `Do you want to lock account ${name}?`,
                icon: "warning",
                showDenyButton: true,
                confirmButtonText: "Lock Account",
                denyButtonText: `Cancel`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    window.location.href = `{{ URL::to('admin/users/delete/${id}') }}`
                }
            });
        }

        function onUnLock(id, name) {
            Swal.fire({
                title: `Do you want to unlock account ${name}?`,
                icon: "info",
                showDenyButton: true,
                confirmButtonText: "Unlock",
                denyButtonText: `Cancel`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    window.location.href = `{{ URL::to('admin/users/restore/${id}') }}`
                }
            });
        }

        function forceDelete(id, name) {
            Swal.fire({
                title: `Do you want to permanently delete ${name}?
                (Can't restore in the future)`,
                icon: "warning",
                showDenyButton: true,
                confirmButtonText: "Delete",
                denyButtonText: `Cancel`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    window.location.href = `{{ URL::to('admin/users/force-delete/${id}') }}`
                }
            });
        }

        function onEdit(id) {
            window.location.href = `{{ URL::to('admin/users/edit/${id}') }}`
        }

        function onDetail(id) {
            window.location.href = `{{ URL::to('admin/users/detail/${id}') }}`
        }
    </script>
@endsection
