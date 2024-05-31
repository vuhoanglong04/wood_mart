@extends('layout.main')
@section('title', 'Dashboard')
@section('content')
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a>Home</a></li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Home</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="card statistics-card-1 overflow-hidden ">
                    <div class="card-body">
                        <img src="https://html.phoenixcoded.net/light-able/bootstrap/assets/images/widget/img-status-4.svg"
                            alt="img" class="img-fluid img-bg">
                        <h5 class="mb-4">Daily Sales</h5>
                        <div class="d-flex align-items-center mt-3">
                            <h3 class="f-w-300 d-flex align-items-center m-b-0">${{ $totalToday }}</h3>
                        </div>
                        <p class="text-muted mb-2 text-sm mt-3">You made an extra
                            {{ round(($totalToday / 33333) * 100, 2) }}% this Daily</p>
                        <div class="progress" style="height: 7px">
                            <div class="progress-bar bg-brand-color-3" role="progressbar"
                                style="width: {{ round(($totalToday / 33333) * 100, 2) }}%" aria-valuenow="75"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="card statistics-card-1 overflow-hidden ">
                    <div class="card-body">
                        <img src="https://html.phoenixcoded.net/light-able/bootstrap/assets/images/widget/img-status-5.svg"
                            alt="img" class="img-fluid img-bg">
                        <h5 class="mb-4">Monthly Sales</h5>
                        <div class="d-flex align-items-center mt-3">
                            <h3 class="f-w-300 d-flex align-items-center m-b-0">${{ $totalMonth }}</h3>
                        </div>
                        <p class="text-muted mb-2 text-sm mt-3">You made an extra
                            {{ round(($totalMonth / 1000000) * 100, 2) }}% this Monthly</p>
                        <div class="progress" style="height: 7px">
                            <div class="progress-bar bg-brand-color-3" role="progressbar"
                                style="width: {{ round(($totalMonth / 1000000) * 100, 2) }}%" aria-valuenow="75"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="card statistics-card-1 overflow-hidden  bg-brand-color-3">
                    <div class="card-body">
                        <img src="https://html.phoenixcoded.net/light-able/bootstrap/assets/images/widget/img-status-6.svg"
                            alt="img" class="img-fluid img-bg">
                        <h5 class="mb-4 text-white">Yearly Sales</h5>
                        <div class="d-flex align-items-center mt-3">
                            <h3 class="text-white f-w-300 d-flex align-items-center m-b-0">${{ $totalYear }}</h3>
                        </div>
                        <p class="text-white text-opacity-75 mb-2 text-sm mt-3">You made an extra
                            {{ round(($totalYear / 12000000) * 100, 2) }}% this
                            Year</p>
                        <div class="progress bg-white bg-opacity-10" style="height: 7px">
                            <div class="progress-bar bg-white" role="progressbar"
                                style="width: {{ round(($totalYear / 12000000) * 100, 2) }}%" aria-valuenow="75"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row ">
                <div class="col-sm-6">
                    <div class="card statistics-card-1 p-3">
                        <div id="chart">

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 row ">
                    <div class="col-sm-12 col-xl-12">
                        <div class="card statistics-card-1">
                            <div class="card-header d-flex align-items-center justify-content-between py-3">
                                <h5>Total Customer</h5>
                                <div class="dropdown">
                                    <a class="avtar avtar-xs btn-link-secondary dropdown-toggle arrow-none" href="#"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                            class="material-icons-two-tone f-18">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">View</a>
                                        <a class="dropdown-item" href="#">Edit</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <h3 class="f-w-300 d-flex align-items-center m-b-0">{{ $allUser }}</h3>
                                </div>
                                <p class="text-muted mb-2 text-sm mt-3">Monthly Increase</p>
                                <div class="progress" style="height: 7px">
                                    <div class="progress-bar bg-brand-color-2" role="progressbar" style="width: 100%"
                                        aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-12 col-xl-12">
                        <div class="card statistics-card-1">
                            <div class="card-header d-flex align-items-center justify-content-between py-3">
                                <h5>Online Customer</h5>
                                <div class="dropdown">
                                    <a class="avtar avtar-xs btn-link-secondary dropdown-toggle arrow-none" href="#"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                            class="material-icons-two-tone f-18">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">View</a>
                                        <a class="dropdown-item" href="#">Edit</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <h3 class="f-w-300 d-flex align-items-center m-b-0">{{ $onlineUser }} <small
                                            class="text-muted">/{{ $allUser }}</small></h3>
                                    <span
                                        class="badge bg-light-success ms-2">{{ round(($onlineUser / $allUser) * 100, 1) }}%</span>
                                </div>
                                <p class="text-muted mb-2 text-sm mt-3">Percent of all customer</p>
                                <div class="progress" style="height: 7px">
                                    <div class="progress-bar bg-brand-color-2" role="progressbar"
                                        style="width: {{ round(($onlineUser / $allUser) * 100, 1) }}%" aria-valuenow="75"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        var options = {
            series: [{
                name: 'Inflation',
                data: [{{$monthlyTotals[1]}}, {{$monthlyTotals[2]}}, {{$monthlyTotals[3]}}, {{$monthlyTotals[4]}}, {{$monthlyTotals[5]}}, {{$monthlyTotals[6]}}, {{$monthlyTotals[7]}}, {{$monthlyTotals[8]}}, {{$monthlyTotals[9]}}, {{$monthlyTotals[10]}}, {{$monthlyTotals[11]}}, {{$monthlyTotals[12]}}]
            }],
            chart: {
                height: 350,
                type: 'bar',
                fontFamily: 'sans-serif'
            },
            plotOptions: {
                bar: {
                    borderRadius: 10,
                    dataLabels: {
                        position: 'top', // top, center, bottom
                    },
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function(val) {
                    return '$' + val;
                },
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ["#304758"]
                }
            },

            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                position: 'top',
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                crosshairs: {
                    fill: {
                        type: 'gradient',
                        gradient: {
                            colorFrom: '#D8E3F0',
                            colorTo: '#BED1E6',
                            stops: [0, 100],
                            opacityFrom: 0.4,
                            opacityTo: 0.5,
                        }
                    }
                },
                tooltip: {
                    enabled: true,
                }
            },
            yaxis: {
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false,
                },
                labels: {
                    show: false,
                    formatter: function(val) {
                        return '$' + val;

                    }
                }

            },
            title: {
                text: 'Monthly Profits Woodmart',
                floating: true,
                offsetY: 330,
                align: 'center',
                style: {
                    color: 'black'
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
@endsection
