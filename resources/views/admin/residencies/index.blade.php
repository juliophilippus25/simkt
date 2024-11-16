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
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Penempatan</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($residencies as $residency)
                            <tr>
                                <td>{{ $residency->user->profile->name }}</td>
                                <td>
                                    @if ($residency->user->profile->gender == 'M')
                                        Asrama Putra | {{ $residency->room_name }}
                                    @else
                                        Asrama Putri | {{ $residency->room_name }}
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($residency->created_at)->isoFormat('D MMMM YYYY') }}</td>
                                <td>
                                    @if ($residency->status == 'pending')
                                        <span class="badge badge-info">PROSES</span>
                                    @elseif ($residency->status == 'pending-payment' && $residency->payment_proof)
                                        <span class="badge badge-info">PEMBAYARAN MASUK</span>
                                    @elseif ($residency->status == 'pending-payment')
                                        <span class="badge badge-warning">MENUNGGU PEMBAYARAN</span>
                                    @elseif ($residency->status == 'accepted')
                                        <span class="badge badge-success">DISETUJUI</span>
                                    @elseif ($residency->status == 'rejected')
                                        <span class="badge badge-danger">DITOLAK</span>
                                    @endif
                                </td>
                                <td>
                                    <!-- Modal Verifikasi Penghuni -->
                                    @if ($residency->status == 'pending')
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#verifyModal{{ $residency->user->id }}_{{ $residency->id }}"
                                            title="Verifikasi">
                                            <i class="fas fa-check"></i> Verifikasi
                                        </button>

                                        <!-- Modal Verifikasi Penghuni -->
                                        <div class="modal fade"
                                            id="verifyModal{{ $residency->user->id }}_{{ $residency->id }}">
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
                                                        Apakah Anda yakin ingin verifikasi pengajuan
                                                        <b>{{ $residency->user->profile->name }}</b>?
                                                    </div>
                                                    <div class="modal-footer justify-content-end">
                                                        <form action="{{ route('admin.penghuni.reject', $residency->id) }}"
                                                            method="POST" id="rejectForm{{ $residency->user->id }}">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger">Tolak</button>
                                                        </form>
                                                        <form action="{{ route('admin.penghuni.accept', $residency->id) }}"
                                                            method="POST" id="acceptForm{{ $residency->user->id }}">
                                                            @csrf
                                                            <button type="submit" class="btn btn-primary">Terima</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($residency->status == 'pending-payment')
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#detailModal{{ $residency->user->id }}" title="Verfikasi">
                                            <i class="fas fa-check"></i> Verifikasi
                                        </button>

                                        <!-- Modal Detail Verifikasi Kamar -->
                                        <div class="modal fade" id="detailModal{{ $residency->user->id }}">
                                            <form
                                                action="{{ route('admin.penghuni.verify-or-reject', $residency->user->id) }}"
                                                method="POST" id="paymentForm{{ $residency->user->id }}">
                                                @csrf
                                                <input type="hidden" name="action" value="verify">

                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Verifikasi Kamar Penghuni -
                                                                {{ $residency->user->profile->name }}</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            @if ($residency->payment_status == 'Belum Bayar')
                                                                <div class="alert alert-warning">Belum ada bukti pembayaran
                                                                    yang diupload.</div>
                                                            @else
                                                                @if ($residency->payment_proof)
                                                                    <div class="form-group">
                                                                        <label>Bukti Pembayaran:</label>
                                                                        <a href="{{ asset('storage/users/bukti-bayar/' . $residency->payment_proof) }}"
                                                                            target="_blank">Lihat Bukti Pembayaran</a>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="room_id">Kamar <b
                                                                                class="text-danger">*</b></label>
                                                                        <select name="room_id" id="room_id"
                                                                            class="form-control">
                                                                            <option value="">Pilih kamar penghuni
                                                                            </option>
                                                                            @foreach ($rooms as $room)
                                                                                @if (
                                                                                    ($residency->user->profile->gender == 'M' && $room->room_type == 'M') ||
                                                                                        ($residency->user->profile->gender == 'F' && $room->room_type == 'F'))
                                                                                    @if ($room->status == 'available')
                                                                                        <option
                                                                                            value="{{ $room->id }}">
                                                                                            {{ $room->name }}</option>
                                                                                    @endif
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </div>

                                                        <div class="modal-footer justify-content-end">
                                                            @if ($residency->payment_status == 'Sudah Bayar')
                                                                <button type="submit" class="btn btn-danger"
                                                                    onclick="this.form.querySelector('input[name=action]').value='reject'">Tolak</button>

                                                                <button type="submit" class="btn btn-primary"
                                                                    onclick="this.form.querySelector('input[name=action]').value='verify'">Verifikasi</button>
                                                            @endif
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
