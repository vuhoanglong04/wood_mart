@extends('layout.main')
@section('content')
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Statistic</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Statistic</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 col-sm-3">
                <div class="card statistics-card-1 overflow-hidden ">
                    <div class="card-body">
                        <img src="https://html.phoenixcoded.net/light-able/bootstrap/assets/images/widget/img-status-4.svg"
                            alt="img" class="img-fluid img-bg">
                        <h5 class="mb-4">Total Orders</h5>
                        <div class="d-flex align-items-center mt-3">
                            <h3 class="f-w-300 d-flex align-items-center m-b-0">{{ $orders }}</h3>
                        </div>
                        <p class="text-muted mb-2 text-sm mt-3">You made an extra
                            {{ ($orders / 100) * 100 }}% (100 orders)</p>
                        <div class="progress" style="height: 7px">
                            <div class="progress-bar bg-brand-color-3" role="progressbar"
                                style="width: {{ ($orders / 100) * 100 }}%" aria-valuenow="75" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="card statistics-card-1 overflow-hidden ">
                    <div class="card-body">
                        <img src="https://html.phoenixcoded.net/light-able/bootstrap/assets/images/widget/img-status-5.svg"
                            alt="img" class="img-fluid img-bg">
                        <h5 class="mb-4">Total Users</h5>
                        <div class="d-flex align-items-center mt-3">
                            <h3 class="f-w-300 d-flex align-items-center m-b-0">{{ $users }}</h3>
                        </div>
                        <p class="text-muted mb-2 text-sm mt-3">Your shop have {{ ($users / 100) * 100 }} users</p>
                        <div class="progress" style="height: 7px">
                            <div class="progress-bar bg-brand-color-3" role="progressbar" style="width:100%"
                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="card statistics-card-1 overflow-hidden ">
                    <div class="card-body">
                        <img src="https://html.phoenixcoded.net/light-able/bootstrap/assets/images/widget/img-status-5.svg"
                            alt="img" class="img-fluid img-bg">
                        <h5 class="mb-4">Total product</h5>
                        <div class="d-flex align-items-center mt-3">
                            <h3 class="f-w-300 d-flex align-items-center m-b-0">{{ $products }}</h3>
                        </div>
                        <p class="text-muted mb-2 text-sm mt-3">You shop have {{ $products }} products</p>
                        <div class="progress" style="height: 7px">
                            <div class="progress-bar bg-brand-color-3" role="progressbar" style="width: 100%"
                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="card statistics-card-1 overflow-hidden  bg-brand-color-3">
                    <div class="card-body">
                        <img src="https://html.phoenixcoded.net/light-able/bootstrap/assets/images/widget/img-status-6.svg"
                            alt="img" class="img-fluid img-bg">
                        <h5 class="mb-4 text-white">Sales</h5>
                        <div class="d-flex align-items-center mt-3">
                            <h3 class="text-white f-w-300 d-flex align-items-center m-b-0">${{ $sales }}</h3>
                        </div>
                        <p class="text-white text-opacity-75 mb-2 text-sm mt-3">You made ${{ $sales }}</p>
                        <div class="progress bg-white bg-opacity-10" style="height: 7px">
                            <div class="progress-bar bg-white" role="progressbar" style="width: 100%" aria-valuenow="75"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card table-card">
                    <div class="card-header">
                        <h5>Top Customer</h5>
                    </div>
                    <div class="card-body py-3 px-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless mb-0">
                                <tbody>
                                    @foreach ($totalByUser as $key => $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $item->user->img }}" alt=""
                                                        class="img-fluid wid-30 rounded-1">
                                                    <h6 class="mb-0 ms-2">{{ $item->user->full_name }}</h6>
                                                </div>
                                            </td>
                                            <td class="text-end f-w-600">${{ $item->total }}</td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card table-card">
                    <div class="card-header d-flex align-items-center justify-content-between py-3">
                        <h5>Recent Review</h5>

                    </div>
                    <div class="card-body py-2 px-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless table-sm mb-0">
                                <tbody>
                                    @foreach ($reviews as $item)


                                    <tr>
                                        <td>
                                            <div class="d-inline-block align-middle">
                                                <img src="{{$item->user->img}}" alt="user image"
                                                    class="img-radius align-top m-r-15" style="width: 40px">
                                                <div class="d-inline-block">
                                                    <h6 class="m-b-0">{{$item->user->full_name}}</h6>
                                                    <p class="m-b-0">Customer</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{$item->stars}} <i class="fas fa-star text-warning"></i></td>
                                        <td>
                                            <p class="mb-0">{{$item->created_at}}</p>
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
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            var options = {
                series: [{
                    name: 'Customer',
                    data: [31, 40, 28, 51, 42, 109, 100]
                }, {
                    name: 'Orders',
                    data: [11, 32, 45, 32, 34, 52, 41]
                }],
                chart: {
                    height: 500,
                    width: 1050,
                    type: 'area'
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    type: 'datetime',
                    categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z",
                        "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z",
                        "2018-09-19T06:30:00.000Z"
                    ]
                },
                tooltip: {
                    x: {
                        format: 'dd/MM/yy HH:mm'
                    },
                },
            };

            // var chart = new ApexCharts(document.querySelector("#chart"), options);
            // chart.render();
        </script>
    @endsection
