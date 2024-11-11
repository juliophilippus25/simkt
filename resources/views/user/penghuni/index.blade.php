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
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
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
                @if ($user->userRoom && optional($appliedResidency)->status == 'accepted')
                    <div class="row">
                        <!-- Detail Info Kamar -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Informasi Kamar</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <tr>
                                            <td>Nama Kamar</td>
                                            <td>:</td>
                                            <td>{{ $user->userRoom->room->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Penempatan</td>
                                            <td>:</td>
                                            <td>
                                                @if ($user->profile->gender == 'M' && $user->userRoom->room->room_type == 'M')
                                                    Asrama Putra
                                                @elseif ($user->profile->gender == 'F' && $user->userRoom->room->room_type == 'F')
                                                    Asrama Putri
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Masuk</td>
                                            <td>:</td>
                                            <td>{{ Carbon\Carbon::parse($user->userRoom->created_at)->isoFormat('D MMMM YYYY') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Akhir Sewa</td>
                                            <td>:</td>
                                            <td>{{ Carbon\Carbon::parse($user->userRoom->rent_period)->isoFormat('D MMMM YYYY') }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if (optional($appliedResidency)->status == 'rejected')
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="text-center">
                            <p>Pengajuan Anda ditolak. {{ optional($appliedResidency)->reason }}</p>
                            <form action="{{ route('user.penghuni.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-primary">Ajukan Kembali</button>
                            </form>
                        </div>
                    </div>
                @endif

                @if (!$dataLengkap)
                    <div class="d-flex justify-content-center">
                        <div class="alert alert-warning text-center" style="width: 100%;">
                            <p><strong>Perhatian!</strong> Lengkapi data Anda terlebih dahulu.</p>
                            <a href="{{ route('user.profile') }}" class="btn btn-primary"
                                style="text-decoration: none;">Klik disini</a>
                        </div>
                    </div>
                @else
                    @if (!$appliedResidency)
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="text-center">
                                <p>Data sudah lengkap, Anda dapat mengajukan sebagai penghuni.</p>
                                <form action="{{ route('user.penghuni.apply') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Ajukan</button>
                                </form>
                            </div>
                        </div>
                    @elseif ($appliedResidency)
                        @if ($appliedResidency->status == 'pending')
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="text-center">
                                    <p>Pengajuan Anda sedang kami periksa.</p>
                                </div>
                            </div>
                        @elseif ($hasPaid)
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="text-center">
                                    <p>Pembayaran Anda sedang kami periksa.</p>
                                </div>
                            </div>
                        @elseif ($appliedResidency->status == 'pending-payment')
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="text-center">
                                    @if ($rejectedPayment)
                                        <p><strong>Perhatian!</strong> Bukti pembayaran Anda sebelumnya ditolak. Silakan
                                            unggah bukti pembayaran baru.</p>
                                    @elseif (!$hasPaid)
                                        <p>Pengajuan Anda telah disetujui. Silakan melakukan pembayaran untuk menjadi
                                            penghuni.</p>
                                    @endif
                                    <!-- Informasi Pembayaran -->
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="text-center">Informasi Pembayaran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>Bank</strong></td>
                                                <td>BRI</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Atas Nama</strong></td>
                                                <td>Dora</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Nomor Rekening</strong></td>
                                                <td>1234-5678-9101</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Bayar</strong></td>
                                                <td>Rp. 250.000</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <!-- Form untuk upload bukti pembayaran -->
                                    <form action="{{ route('user.penghuni.payment') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="proof">Upload Bukti Pembayaran <b
                                                    class="text-danger">*</b></label>
                                            <input type="file" name="proof" id="proof" class="form-control"
                                                required>
                                        </div>

                                        <div class="form-group mt-3">
                                            <button type="submit" class="btn btn-primary">Kirim Bukti Pembayaran</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endif
                @endif
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
