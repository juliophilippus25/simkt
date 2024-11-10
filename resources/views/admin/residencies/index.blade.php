@extends('layouts.app')

@section('title', 'Pengajuan Penghuni')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pengajuan Penghuni</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pengajauan Penghuni</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pengajuan Penghuni</h3>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Diverifikasi Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($residencies as $residency)
                            <tr>
                                <td>{{ $residency->user->profile->name }}</td>
                                <td>
                                    @if ($residency->user->profile->gender == 'M')
                                        Laki-laki
                                    @else
                                        Perempuan
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($residency->created_at)->isoFormat('D MMMM YYYY') }}</td>
                                <td>{{ $residency->verifiedBy->name ?? 'Belum diverifikasi' }}</td>
                                <td>
                                    @if ($residency->verified_by == null)
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#verifyModal{{ $residency->user->id }}" title="Verifikasi">
                                            <i class="fas fa-check"></i>
                                        </button>

                                        {{-- Modal Verifikasi --}}
                                        <div class="modal fade" id="verifyModal{{ $residency->user->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Verifikasi Penghuni</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p></p>
                                                        Apakah Anda yakin ingin verifikasi pengajuan
                                                        <b>{{ $residency->user->profile->name }}</b>?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer justify-content-end">
                                                        <form action="{{ route('admin.pengajuan.reject', $residency->id) }}"
                                                            method="POST" id="rejectForm{{ $residency->user->id }}">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger">
                                                                Tolak
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.pengajuan.accept', $residency->id) }}"
                                                            method="POST" id="acceptForm{{ $residency->user->id }}">
                                                            @csrf
                                                            <button type="submit" class="btn btn-primary">
                                                                Terima
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($residency)
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $residency->id }}" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
