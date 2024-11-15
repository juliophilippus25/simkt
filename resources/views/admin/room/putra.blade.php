@extends('layouts.app')

@section('title', 'Asrama Putra')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Asrama Putra</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Asrama Putra</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Kamar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rooms as $room)
                            <tr>
                                <td>{{ $room->name }}</td>
                                <td>
                                    @if ($room->status == 'available')
                                        <span class="badge bg-success">TERSEDIA</span>
                                    @else
                                        <span class="badge bg-info">TERISI</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($room->userRooms->isNotEmpty())
                                        <a href="{{ route('admin.room.putra.show', $room->userRooms->first()->user_id) }}"
                                            class="btn btn-primary">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
    <!-- /.content -->
@section('script')
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "language": {
                    search: "Cari",
                    searchPlaceholder: "Cari {{ $dataType }}",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ {{ $dataType }}",
                    infoEmpty: "Tidak ada {{ $dataType }} yang tersedia",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    zeroRecords: "Tidak ada {{ $dataType }} yang ditemukan.",
                    emptyTable: "Tidak ada {{ $dataType }} yang tersedia di tabel.",
                    paginate: {
                        first: "Pertama",
                        previous: "Sebelumnya",
                        next: "Berikutnya",
                        last: "Terakhir"
                    }
                },
                "order": [
                    [1, 'asc']
                ],
                "columnDefs": [{
                    "targets": 2,
                    "type": "date"
                }]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection

@endsection
