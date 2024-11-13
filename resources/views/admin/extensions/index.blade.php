@extends('layouts.app')

@section('title', 'Perpanjangan')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Perpanjangan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Perpanjangan</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Perpanjangan Penghuni</h3>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Penempatan</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $payment)
                            <tr>
                                <td>{{ $payment->user->profile->name }}</td>
                                <td>
                                    @if ($payment->user->profile->gender == 'M')
                                        Asrama Putra | {{ $payment->user->userRoom->room->name }}
                                    @else
                                        Asrama Putri | {{ $payment->user->userRoom->room->name }}
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($payment->created_at)->isoFormat('D MMMM YYYY') }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#verifyModal{{ $payment->id }}" title="Verifikasi">
                                        <i class="fas fa-check"></i>
                                    </button>

                                    <!-- Modal Verifikasi Penghuni -->
                                    <div class="modal fade" id="verifyModal{{ $payment->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Verifikasi Pembayaran</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Bukti Pembayaran:</label>
                                                        <a href="{{ asset('storage/users/bukti-bayar/' . $payment->proof) }}"
                                                            target="_blank">Lihat Bukti Pembayaran</a>
                                                    </div>
                                                    Apakah Anda yakin ingin verifikasi pembayaran
                                                    <b>{{ $payment->user->profile->name }}</b>?
                                                </div>
                                                <div class="modal-footer justify-content-end">
                                                    <form action="{{ route('admin.extension.reject', $payment->id) }}"
                                                        method="POST" id="rejectForm{{ $payment->user->id }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger">Tolak</button>
                                                    </form>
                                                    <form action="{{ route('admin.extension.accept', $payment->id) }}"
                                                        method="POST" id="acceptForm{{ $payment->user->id }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary">Terima</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
