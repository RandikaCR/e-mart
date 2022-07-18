@extends('layouts.emart-app')

@section('page_title')
    Dashboard | E-Mart marketplace
@endsection

@section('content')

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
        </div>
    </div>

    @if(Auth::user()->user_type_id == 1 )
    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-center align-items-baseline">
                                <h6 class="card-title mb-0">All Orders</h6>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <h3 class="mb-2">{{ number_format($all_orders, 0) }}</h3>
                                    <div class="d-flex justify-content-center align-items-baseline mt-3">
                                        <a href="{{ url('orders') }}" class="btn btn-instagram btn-sm">View All</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-center align-items-baseline">
                                <h6 class="card-title mb-0">All Products</h6>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <h3 class="mb-2">{{ number_format($all_products, 0) }}</h3>
                                    <div class="d-flex justify-content-center align-items-baseline mt-3">
                                        <a href="{{ url('products') }}" class="btn btn-github btn-sm">View All</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-center align-items-baseline">
                                <h6 class="card-title mb-0">Customers</h6>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <h3 class="mb-2">{{ number_format($all_customers, 0) }}</h3>
                                    <div class="d-flex justify-content-center align-items-baseline mt-3">
                                        <a href="{{ url('customers') }}" class="btn btn-bitbucket btn-sm">View All</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- row -->

    <div class="row">
        <div class="col-lg-7 col-xl-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <h6 class="card-title mb-0">Monthly sales</h6>
                    </div>
                    <p class="text-muted"></p>
                    <div id="monthlySalesChartEmart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-xl-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body d-flex flex-wrap justify-content-between flex-column">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h6 class="card-title mb-0">Orders Today</h6>
                    </div>
                    <div class="d-flex justify-content-center align-items-center flex-column">
                        <p class="text-primary" style="font-size: 6rem; line-height: 5rem;">{{ $orders_today }}</p>
                        <p class="text-secondary" style="font-size: 2rem;">Rs. {{ number_format($orders_today_amount, 2) }}</p>
                    </div>
                    <div class="d-grid">
                        <a href="{{ url('orders') }}" class="btn btn-primary">View All</a>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- row -->

    @endif

    <div class="row">
        <div class="col-lg-5 col-xl-4 grid-margin grid-margin-xl-0 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-4">
                        <h6 class="card-title mb-0">Recent Customers</h6>
                    </div>
                    <div class="d-flex flex-column">
                        @foreach( $recent_customers as $rc )
                        <a href="{{ route('customers.edit', $rc->id ) }}" class="d-flex align-items-center border-bottom pb-3 mt-2">
                            <div class="me-3">
                                <img src="{{ asset('assets/images/user.png') }}" class="rounded-circle wd-35" alt="user">
                            </div>
                            <div class="w-100">
                                <div class="d-flex justify-content-between">
                                    <h6 class="text-body mb-2">{{ $rc->customer_name }}</h6>
                                    <p class="text-muted tx-12">{{ date('Y-m-d H:i A', strtotime($rc->created_at)) }}</p>
                                </div>
                                <p class="text-muted tx-13">{{ $rc->email }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-xl-8 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-4">
                        <h6 class="card-title mb-0">Recent Orders</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                            <tr>
                                <th class="pt-0">#</th>
                                <th class="pt-0">Customer Name</th>
                                <th class="pt-0 text-center">Order Total</th>
                                <th class="pt-0 text-center">Order Date</th>
                                <th class="pt-0 text-center">Status</th>
                                <th class="pt-0">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $recent_orders as $o )
                            <tr>
                                <td style="vertical-align: middle;">{{ $o->id }}</td>
                                <td style="vertical-align: middle;">{{ $o->customer->customer_name }}</td>
                                <td style="text-align: right;vertical-align: middle;">{{ number_format($o->order_total(), 2) }}</td>
                                <td class="text-center" style="vertical-align: middle;">{{ date('d-m-Y h:i A', strtotime($o->order_date)) }}</td>
                                <td class="text-center" style="vertical-align: middle;"><span class="badge {{ $o->order_status()['label'] }}">{{ $o->order_status()['text'] }}</span></td>
                                <td style="text-align: right;vertical-align: middle;">
                                    <a href="{{ route('orders.show', $o->id) }}" class="btn btn-primary btn-icon btn-sm" style="margin-right: 10px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
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
    </div> <!-- row -->

@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
@endsection

@section('custom_style')
@endsection

@section('script')
    <script src="{{ asset('assets/vendors/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard-light.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker.js') }}"></script>
@endsection

@section('custom_script')

    <script>
        $(document).ready(function () {

            var colors = {
                primary        : "#6571ff",
                secondary      : "#7987a1",
                success        : "#05a34a",
                info           : "#66d1d1",
                warning        : "#fbbc06",
                danger         : "#ff3366",
                light          : "#e9ecef",
                dark           : "#060c17",
                muted          : "#7987a1",
                gridBorder     : "rgba(77, 138, 240, .15)",
                bodyColor      : "#000",
                cardBg         : "#fff"
            }

            var fontFamily = "'Roboto', Helvetica, sans-serif";


            // Monthly Sales Chart
            if($('#monthlySalesChartEmart').length) {
                var options = {
                    chart: {
                        type: 'bar',
                        height: '318',
                        parentHeightOffset: 0,
                        foreColor: colors.bodyColor,
                        background: colors.cardBg,
                        toolbar: {
                            show: false
                        },
                    },
                    theme: {
                        mode: 'light'
                    },
                    tooltip: {
                        theme: 'light'
                    },
                    colors: [colors.primary],
                    fill: {
                        opacity: .9
                    } ,
                    grid: {
                        padding: {
                            bottom: -4
                        },
                        borderColor: colors.gridBorder,
                        xaxis: {
                            lines: {
                                show: true
                            }
                        }
                    },
                    series: [{
                        name: 'Sales',
                        data: [
                            @foreach($monthly_sales as $ms )
                            {{ $ms }},
                            @endforeach
                        ]
                    }],
                    xaxis: {
                        type: 'datetime',
                        categories: ['01/01/2022','02/01/2022','03/01/2022','04/01/2022','05/01/2022','06/01/2022','07/01/2022', '08/01/2022','09/01/2022','10/01/2022', '11/01/2022', '12/01/2022'],
                        axisBorder: {
                            color: colors.gridBorder,
                        },
                        axisTicks: {
                            color: colors.gridBorder,
                        },
                    },
                    yaxis: {
                        title: {
                            text: 'Number of Sales',
                            style:{
                                size: 9,
                                color: colors.muted
                            }
                        },
                    },
                    legend: {
                        show: true,
                        position: "top",
                        horizontalAlign: 'center',
                        fontFamily: fontFamily,
                        itemMargin: {
                            horizontal: 8,
                            vertical: 0
                        },
                    },
                    stroke: {
                        width: 0
                    },
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: '10px',
                            fontFamily: fontFamily,
                        },
                        offsetY: -27
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: "50%",
                            borderRadius: 4,
                            dataLabels: {
                                position: 'top',
                                orientation: 'vertical',
                            }
                        },
                    },
                }

                var apexBarChart = new ApexCharts(document.querySelector("#monthlySalesChartEmart"), options);
                apexBarChart.render();
            }
            // Monthly Sales Chart - END
        });
    </script>

@endsection


