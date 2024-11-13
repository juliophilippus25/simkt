@extends('layouts.app')

@section('title', 'Penghuni')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Penghuni</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Penghuni</li>
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
                <h3 class="card-title">Penghuni</h3>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <a href="{{ asset('storage/users/ktp/' . $user->profile->ktp) }}" target="_blank">
                                        {{ $user->profile->name }}
                                    </a>
                                </td>
                                <td>{{ $user->profile->gender == 'M' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($user->created_at)->isoFormat('D MMMM YYYY') }}
                                </td>
                                <td>
                                    @if ($user->is_verified == 0)
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#verifyModal{{ $user->id }}" title="Verifikasi">
                                            <i class="fas fa-check"></i>
                                        </button>

                                        {{-- Modal Verifikasi --}}
                                        <div class="modal fade" id="verifyModal{{ $user->id }}">
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
                                                        <p>
                                                            Apakah Anda yakin ingin verifikasi
                                                            <b>{{ $user->profile->name }}</b>?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Tutup</button>
                                                        <form action="{{ route('admin.users.verify', $user->id) }}"
                                                            method="POST" id="verifyForm{{ $user->id }}">
                                                            @csrf
                                                            <button type="submit" class="btn btn-primary">
                                                                Verifikasi
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($user->is_verified == 1)
                                        <a href="{{ route('admin.users.show', $user->id) }}"
                                            class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
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
                    [2, 'desc']
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
