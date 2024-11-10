@extends('layouts.app')

@section('title', 'Detail Penghuni')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Penghuni</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.penghuni.index') }}">Pengajuan Penghuni</a></li>
                        <li class="breadcrumb-item active">Detail Penghuni</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <!-- Detail Info Penghuni -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Penghuni</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <td>Nama Penghuni</td>
                                <td>:</td>
                                <td>{{ $user->profile->name }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td>No. Telepon</td>
                                <td>:</td>
                                <td>{{ $user->profile->phone }}</td>
                            </tr>
                            <tr>
                                <td>Universitas</td>
                                <td>:</td>
                                <td>{{ $user->profile->university }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

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
                                <td>{{ Carbon\Carbon::parse($user->userRoom->created_at)->isoFormat('D MMMM YYYY') }}</td>
                            </tr>
                            <tr>
                                <td>Akhir Sewa</td>
                                <td>:</td>
                                <td>{{ Carbon\Carbon::parse($user->userRoom->rent_period)->isoFormat('D MMMM YYYY') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Pembayaran -->
        <div class="card mt-3">
            <div class="card-header">
                Riwayat Pembayaran
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal Pembayaran</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->payment as $payment)
                            <tr>
                                <td>{{ Carbon\Carbon::parse($payment->created_at)->isoFormat('D MMMM YYYY') }}</td>
                                <td>{{ $payment->is_accepted ? 'Diterima' : 'Belum Diterima' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ route('admin.penghuni.index') }}" class="btn btn-secondary mb-3">Kembali</a>
        </div>
    </section>
@endsection
