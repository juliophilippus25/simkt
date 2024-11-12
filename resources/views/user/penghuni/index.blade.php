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
        <div class="card">
            <div class="card-body">
                @if ($user->userRoom && optional($appliedResidency)->status == 'accepted')
                    <div class="row">
                        <!-- Info Kamar -->
                        <div class="col-md-6">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-center">Informasi Kamar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Nama Kamar</strong></td>
                                        <td>{{ $user->userRoom->room->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Penempatan</strong></td>
                                        <td>
                                            @if ($user->profile->gender == 'M' && $user->userRoom->room->room_type == 'M')
                                                Asrama Putra
                                            @elseif ($user->profile->gender == 'F' && $user->userRoom->room->room_type == 'F')
                                                Asrama Putri
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Masuk</strong></td>
                                        <td>{{ Carbon\Carbon::parse($user->userRoom->created_at)->isoFormat('D MMMM YYYY') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Akhir Sewa</strong></td>
                                        <td>{{ Carbon\Carbon::parse($user->userRoom->rent_period)->isoFormat('D MMMM YYYY') }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Info Pembayaran -->
                        @if (!now()->lessThanOrEqualTo($subDays))
                            <div class="col-md-6">
                                <!-- Pembayaran Status -->
                                @if ($pendingPayment)
                                    <p class="text-bold  text-center">
                                        Pembayaran Anda
                                        sedang
                                        kami periksa.</p>
                                @else
                                    <!-- Form Upload Bukti Pembayaran -->
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

                                    <div class="d-flex justify-content-center align-items-center">
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
                                                <button type="submit" class="btn btn-primary">Kirim Bukti
                                                    Pembayaran</button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Pengajuan Ditolak -->
                @if (optional($appliedResidency)->status == 'rejected')
                    <div class="text-center">
                        <p class="text-bold text-danger">Pengajuan Anda ditolak. {{ optional($appliedResidency)->reason }}
                        </p>
                        <form action="{{ route('user.penghuni.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-primary">Ajukan Kembali</button>
                        </form>
                    </div>
                @endif

                <!-- Profil Belum Lengkap -->
                @if (!$isProfileComplete)
                    <div class="alert alert-warning text-center">
                        <p><strong>Perhatian!</strong> Lengkapi data Anda terlebih dahulu.</p>
                        <a href="{{ route('user.profile') }}" class="btn btn-primary">Klik disini</a>
                    </div>
                @else
                    <!-- Pengajuan Tidak Ada atau Status Pengajuan -->
                    @if (!$appliedResidency)
                        <div class="text-center">
                            <p>Data sudah lengkap, Anda dapat mengajukan sebagai penghuni.</p>
                            <form action="{{ route('user.penghuni.apply') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Ajukan</button>
                            </form>
                        </div>
                    @elseif ($appliedResidency->status == 'pending')
                        <div class="text-center text-bold ">
                            <p>Pengajuan Anda sedang kami periksa.</p>
                        </div>
                    @elseif ($appliedResidency->status == 'pending-payment')
                        <div class="text-center">
                            @if ($rejectedPayment)
                                @if (!$pendingPayment)
                                    <p><strong>Perhatian!</strong> Bukti pembayaran Anda sebelumnya ditolak. Silakan unggah
                                        bukti pembayaran baru.</p>
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
                                            <tr>
                                                <td class="text-center" style="color: orange;" colspan="2">
                                                    <strong>Lakukan pembayaran dalam waktu
                                                        <span class="badge badge-danger" id="countdown-timer">...</span>
                                                    </strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

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
                                @else
                                    <p class="text-bold ">
                                        Pembayaran Anda
                                        sedang
                                        kami periksa.
                                    </p>
                                @endif
                            @else
                                @if (now()->lessThanOrEqualTo($residencyDeadline) && !$pendingPayment)
                                    <p class="text-bold">
                                        Pengajuan Anda telah disetujui. Silakan melakukan pembayaran untuk menjadi penghuni.
                                    </p>
                                    <!-- Informasi Pembayaran dan Countdown -->
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
                                            <tr>
                                                <td class="text-center" style="color: orange;" colspan="2">
                                                    <strong>Lakukan pembayaran dalam waktu
                                                        <span class="badge badge-danger" id="countdown-timer">...</span>
                                                    </strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

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
                                @elseif($pendingPayment)
                                    <p class="text-bold text-bold">Pembayaran Anda sedang kami periksa.</p>
                                @endif
                            @endif
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </section>

@section('script')
    <script>
        // Menggunakan pengecekan apakah $appliedResidency atau $residencyDeadline ada sebelum melanjutkan
        @if (isset($appliedResidency) && isset($appliedResidency->updated_at))
            var deadline = new Date("{{ Carbon\Carbon::parse($appliedResidency->updated_at)->addDays(3) }}");
        @else
            var deadline = new Date(); // Default fallback jika tidak ada deadline
        @endif

        function formatCountdown(ms) {
            var days = Math.floor(ms / (1000 * 60 * 60 * 24));
            var hours = Math.floor((ms % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((ms % (1000 * 60 * 60)) / (1000 * 60));

            var countdownText = "";
            if (days > 0) countdownText += days + " hari ";
            if (hours > 0) countdownText += hours + " jam ";
            if (minutes > 0) countdownText += minutes + " menit";

            return countdownText;
        }

        var countdownInterval = setInterval(function() {
            var now = new Date().getTime();
            var remainingTime = deadline - now;

            if (remainingTime <= 0) {
                clearInterval(countdownInterval);
                document.getElementById("countdown-timer").innerHTML = "WAKTU HABIS";
            } else {
                document.getElementById("countdown-timer").innerHTML = formatCountdown(remainingTime);
            }
        }, 1000);
    </script>
@endsection

@endsection
