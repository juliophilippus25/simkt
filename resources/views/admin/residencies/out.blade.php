@extends('layouts.app')

@section('title', 'Keluar Asrama')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Keluar Asrama</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Keluar Asrama</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="card">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Alasan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($outResidencies as $outResidency)
                            <tr>
                                <td>{{ $outResidency->user->profile->name }}</td>
                                <td>{{ Carbon\Carbon::parse($outResidency->created_at)->isoFormat('D MMMM YYYY') }}</td>
                                <td>{{ $outResidency->reason }}</td>
                                <td>
                                    @if ($outResidency->status == 'pending')
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#detailModal{{ $outResidency->id }}">
                                            <i class="fas fa-check"></i> Konfirmasi
                                        </button>

                                        <div class="modal fade" id="detailModal{{ $outResidency->id }}">
                                            <form action="{{ route('admin.penghuni.out.confirmation', $outResidency->id) }}"
                                                method="POST" id="outResidencyForm{{ $outResidency->id }}">
                                                @csrf
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title text-dark">Pengajuan Keluar Asrama
                                                            </h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <p>Apakah Anda yakin konfirmasi
                                                                <b>{{ $outResidency->user->profile->name }}</b> keluar
                                                                asrama?
                                                            </p>
                                                        </div>

                                                        <div class="modal-footer justify-content-end">
                                                            <button type="submit"
                                                                class="btn btn-primary">Konfirmasi</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

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
                    search: "Cari", // Label pencarian
                    searchPlaceholder: "Cari {{ $dataType }}", // Placeholder pencarian
                    lengthMenu: "Tampilkan _MENU_ data per halaman", // Menu jumlah data per halaman
                    info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ {{ $dataType }}", // Info pagination
                    infoEmpty: "Tidak ada {{ $dataType }} yang tersedia", // Pesan saat tidak ada data
                    infoFiltered: "(difilter dari _MAX_ total data)", // Pesan saat data difilter
                    zeroRecords: "Tidak ada {{ $dataType }} yang ditemukan.", // Pesan saat tidak ada hasil
                    emptyTable: "Tidak ada {{ $dataType }} yang tersedia di tabel.",
                    paginate: { // Opsi untuk pagination
                        first: "Pertama", // Tombol "First"
                        previous: "Sebelumnya", // Tombol "Previous"
                        next: "Berikutnya", // Tombol "Next"
                        last: "Terakhir" // Tombol "Last"
                    }
                }
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
@endsection
