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

    </style>
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
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
        <div class="col-12 mt-4 mb-4">
            <a type="submit" href="{{route('admin.users.add')}}" style="color:white" class="btn btn-primary"><i class="ph-duotone ph-plus-circle"></i> Add New
                User</a>
        </div>
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
                        "url": "http:\/\/127.0.0.1:8000\/admin\/users",
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
                                return `<div class="d-inline-block align-middle">
                                            <img src="{{ asset('images/user') }}/${row.img}" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
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
                                if (data == 1) {
                                    status = '<span class="badge bg-light-success">Active</span>'
                                } else status = '<span class="badge bg-light-danger">Disabled</span>'
                                return `${status}
                                        <div class="overlay-edit">
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item m-0"><a href="#" class="avtar avtar-s btn btn-primary p-4"><i class="ti ti-pencil f-18"></i></a></li>
                                                <li class="list-inline-item m-0"><a href="#" class="avtar avtar-s btn bg-white btn-link-danger p-3"><i class="ti ti-trash f-18"></i></a></li>
                                            </ul>
                                        </div>
                                `;
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
@endsection
