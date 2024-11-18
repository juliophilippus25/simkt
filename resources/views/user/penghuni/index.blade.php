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
        <!-- Alert for Profile Incomplete -->
        @if (!$isProfileComplete)
            <div class="alert alert-warning text-center">
                <strong>Perhatian!</strong> Lengkapi data Anda terlebih dahulu.
                <a href="{{ route('user.profile') }}" class="btn btn-primary mt-2" style="text-decoration: none;">Klik
                    disini</a>
            </div>
        @endif

        @if ($subDays && !now()->lessThanOrEqualTo($subDays))
            @if (!$pendingPayment)
                <div class="alert alert-warning text-center">
                    <strong>Perhatian!</strong> Lakukan pembayaran untuk melanjutkan masa sewa asrama.
                </div>
            @endif
        @endif

        <!-- Pembayaran Status -->
        @if ($pendingPayment)
            <div class="alert alert-info text-center">
                Pembayaran Anda sedang kami periksa.
            </div>
        @endif

        <!-- Pengajuan Status -->
        @if (!$appliedResidency && $isProfileComplete)
            <div class="alert alert-info text-center">
                Data sudah lengkap, Anda dapat mengajukan sebagai penghuni.
                <form action="{{ route('user.penghuni.apply') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary mt-2">Ajukan</button>
                </form>
            </div>
        @elseif ($appliedResidency && $appliedResidency->status == 'pending')
            <div class="alert alert-info text-center">
                Pengajuan Anda sedang kami periksa.
            </div>
        @elseif ($appliedResidency && $appliedResidency->status == 'pending-payment')
            <div class="text-center">
                @if ($rejectedPayment)
                    @if (!$pendingPayment)
                        <div class="alert alert-danger">
                            <strong>Perhatian!</strong> Bukti pembayaran Anda sebelumnya ditolak. Silakan unggah bukti
                            pembayaran baru.
                        </div>

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

                        <form action="{{ route('user.penghuni.payment') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="proof">Upload Bukti Pembayaran <b class="text-danger">*</b></label>
                                <input type="file" name="proof" id="proof" class="form-control" required>
                            </div>

                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">Kirim Bukti Pembayaran</button>
                            </div>
                        </form>
                    @endif
                @else
                    @if (!$pendingPayment)
                        <div class="alert alert-warning">
                            <strong>Perhatian!</strong> Lakukan pembayaran untuk melanjutkan proses pengajuan.
                        </div>

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

                        <form action="{{ route('user.penghuni.payment') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="proof">Upload Bukti Pembayaran <b class="text-danger">*</b></label>
                                <input type="file" name="proof" id="proof" class="form-control" required>
                            </div>

                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">Kirim Bukti Pembayaran</button>
                            </div>
                        </form>
                    @endif
                @endif
            </div>
        @elseif ($appliedResidency && $appliedResidency->status == 'accepted')
            <div class="row">
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

                <div class="col-md-6">
                    @if ($subDays && !now()->lessThanOrEqualTo($subDays))
                        <!-- Form Upload Bukti Pembayaran -->
                        @if (!$pendingPayment)
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
                                        <td>
                                            @if ($penalty > 0)
                                                Rp. {{ number_format($totalAmount, 0, ',', '.') }} (Rp.
                                                {{ number_format($roomPrice, 0, ',', '.') }} + Denda Rp.
                                                {{ number_format($penalty, 0, ',', '.') }})
                                            @else
                                                Rp. {{ number_format($roomPrice, 0, ',', '.') }}
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="text-center">
                                <form action="{{ route('user.penghuni.payment') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="proof">Upload Bukti Pembayaran <b class="text-danger">*</b></label>
                                        <input type="file" name="proof" id="proof" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2">Kirim Bukti Pembayaran</button>
                                </form>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        @elseif ($appliedResidency && $appliedResidency->status == 'rejected')
            <div class="alert alert-danger text-center">
                Pengajuan Anda ditolak. {{ optional($appliedResidency)->reason }}
                <form action="{{ route('user.penghuni.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-primary mt-2">Ajukan Kembali</button>
                </form>
            </div>
        @endif

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
