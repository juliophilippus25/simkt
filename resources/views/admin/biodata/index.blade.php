@extends('layouts.app')

@section('title', 'Biodata')

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
                        <li class="breadcrumb-item active">Biodata</li>
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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($biodatas as $biodata)
                            <tr>
                                <td>{{ $biodata->user->profile->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($biodata->created_at)->isoFormat('D MMMM YYYY') }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#verifyModal{{ $biodata->id }}" title="Verifikasi">
                                        <i class="fas fa-check"></i> Verifikasi
                                    </button>

                                    <!-- Modal Verifikasi Penghuni -->
                                    <div class="modal fade" id="verifyModal{{ $biodata->id }}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Verifikasi Pengajuan Ubah Biodata</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <!-- Kolom Email Lama -->
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="text-dark">Email lama</label>
                                                                <input id="email_lama" name="email_lama" type="email"
                                                                    class="form-control" value="{{ $biodata->user->email }}"
                                                                    disabled>
                                                            </div>
                                                        </div>

                                                        <!-- Tanda "->" di Tengah -->
                                                        <div
                                                            class="col-md-2 d-flex justify-content-center align-items-center">
                                                            <i class="fas fa-arrow-right"></i>
                                                        </div>

                                                        <!-- Kolom Email Baru -->
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="text-dark">Email baru</label>
                                                                <input id="email" name="email" type="email"
                                                                    class="form-control" placeholder="Email baru"
                                                                    value="{{ $biodata->email }}" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-3">
                                                        <!-- Kolom Nama Lengkap Lama -->
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="text-dark">Nama lengkap lama</label>
                                                                <input id="name_lama" name="name_lama" type="text"
                                                                    class="form-control"
                                                                    value="{{ $biodata->user->profile->name }}" disabled>
                                                            </div>
                                                        </div>

                                                        <!-- Tanda "->" di Tengah -->
                                                        <div
                                                            class="col-md-2 d-flex justify-content-center align-items-center">
                                                            <i class="fas fa-arrow-right"></i>
                                                        </div>

                                                        <!-- Kolom Nama Lengkap Baru -->
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="text-dark">Nama lengkap baru</label>
                                                                <input id="name" name="name" type="text"
                                                                    class="form-control" value="{{ $biodata->name }}"
                                                                    placeholder="Nama baru" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-end">
                                                    <form action="{{ route('admin.biodata.reject', $biodata->id) }}"
                                                        method="POST" id="rejectForm{{ $biodata->user->id }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger">Tolak</button>
                                                    </form>
                                                    <form action="{{ route('admin.biodata.accept', $biodata->id) }}"
                                                        method="POST" id="acceptForm{{ $biodata->user->id }}">
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
