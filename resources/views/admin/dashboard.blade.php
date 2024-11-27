@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row d-flex justify-content-center">
                <div class="col-lg-3 col-12">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $userCount }}</h3>

                            <p>Penghuni</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="{{ route('admin.users.index') }}" class="small-box-footer">Info lebih lanjut <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Jumlah Penghuni Asrama</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="pieChart"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Jumlah Masuk Penghuni Per Bulan tahun {{ date('Y') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="barChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Perpanjangan Kamar Belum Diverifikasi</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-striped table-valign-middle">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Kamar</th>
                                        <th>Penempatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($getUsersWithPendingPayment as $user)
                                        <tr>
                                            <td>{{ $user->profile->name }}</td>
                                            <td>{{ $user->userRoom->room->name }}</td>
                                            <td>
                                                {{ $user->userRoom->room->room_type == 'M' ? 'Asrama Putra' : 'Asrama Putri' }}
                                            </td>
                                            <td>
                                                @if ($user->payment->where('status', 'pending')->isNotEmpty())
                                                    <a href="{{ route('admin.extension.index') }}"
                                                        class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                                @else
                                                    <span class="badge badge-danger">Belum dibayar</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>

            </div>


        </div>

    </section>
    <!-- /.content -->
    @section('script')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            $(function() {
                //-------------
                //- PIE CHART -
                //-------------
                // Get context with jQuery - using jQuery's .get() method.
                var userTypeMCount = @json($userTypeMCount);
                var userTypeFCount = @json($userTypeFCount);
                var donutData = {
                    labels: [
                        'Asrama Putra',
                        'Asrama Putri',
                    ],
                    datasets: [{
                        data: [userTypeMCount, userTypeFCount],
                        backgroundColor: ['#f56954', '#00a65a'],
                    }]
                }
                var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
                var pieData = donutData;
                var pieOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                }
                //Create pie or douhnut chart
                // You can switch between pie and douhnut using the method below.
                new Chart(pieChartCanvas, {
                    type: 'pie',
                    data: pieData,
                    options: pieOptions
                })

                //-------------
                //- BAR CHART -
                //-------------
                var userTypeFJoinCount = @json($userTypeFJoinCount);
                var userTypeMJoinCount = @json($userTypeMJoinCount);
                var years = @json($years);
                var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                    'Oktover', 'November', 'Desember'
                ];

                var areaChartData = {
                    labels: months,
                    datasets: [{
                            label: 'Asrama Putri',
                            backgroundColor: 'rgba(0, 166, 90, 1)',
                            borderColor: 'rgba(60,141,188,0.8)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: months.map(function(month, index) {
                                // Mengambil jumlah penghuni berdasarkan bulan dan tahun
                                var data = 0;
                                years.forEach(function(year) {
                                    if (userTypeFJoinCount[year] && userTypeFJoinCount[year][
                                            index +
                                            1
                                        ]) {
                                        data += userTypeFJoinCount[year][index + 1];
                                    }
                                });
                                return data;
                            })
                        },
                        {
                            label: 'Asrama Putra',
                            backgroundColor: 'rgba(245, 105, 84, 1)',
                            borderColor: 'rgba(210, 214, 222, 1)',
                            pointRadius: false,
                            pointColor: 'rgba(210, 214, 222, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(220,220,220,1)',
                            data: months.map(function(month, index) {
                                // Mengambil jumlah penghuni berdasarkan bulan dan tahun
                                var data = 0;
                                years.forEach(function(year) {
                                    if (userTypeMJoinCount[year] && userTypeMJoinCount[year][
                                            index +
                                            1
                                        ]) {
                                        data += userTypeMJoinCount[year][index + 1];
                                    }
                                });
                                return data;
                            })
                        },
                    ]
                }
                var barChartCanvas = $('#barChart').get(0).getContext('2d')
                var barChartData = $.extend(true, {}, areaChartData)
                var temp0 = areaChartData.datasets[0]
                var temp1 = areaChartData.datasets[1]
                barChartData.datasets[0] = temp1
                barChartData.datasets[1] = temp0

                var barChartOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    datasetFill: false
                }

                new Chart(barChartCanvas, {
                    type: 'bar',
                    data: barChartData,
                    options: barChartOptions
                })

            })
        </script>
    @endsection

@endsection
