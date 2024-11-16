@extends('layouts.app')

@section('title', $user->profile->name)

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profil</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $user->profile->name }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @if ($user->profile->photo)
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ asset('storage/users/foto/' . $user->profile->photo) }}"
                                        alt="User profile picture" style="width: 120px; height: 120px; object-fit: cover;">
                                @else
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ asset('images/default.png') }}" alt="User profile picture"
                                        style="width: 120px; height: 120px; object-fit: cover;">
                                @endif
                            </div>

                            <h3 class="profile-username text-center">{{ $user->profile->name }}</h3>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#biodata"
                                        data-toggle="tab">Biodata</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#berkas" data-toggle="tab">Berkas</a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">

                                {{-- Biodata --}}
                                <div class="active tab-pane" id="biodata">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">Email</td>
                                                <td style="width: 70%;">{{ $user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">NIK</td>
                                                <td style="width: 70%;">{{ $user->nik }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">Nama Lengkap</td>
                                                <td style="width: 70%;">{{ $user->profile->name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">Nomor HP</td>
                                                <td style="width: 70%;">{{ $user->profile->phone }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">Jenis Kelamin</td>
                                                <td style="width: 70%;">
                                                    @if ($user->profile->gender == 'M')
                                                        Laki-laki
                                                    @else
                                                        Perempuan
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 50%;">Tanggal Lahir</td>
                                                <td style="width: 50%;">
                                                    {{ isset($user->profile) && $user->profile->birth_date
                                                        ? \Carbon\Carbon::parse($user->profile->birth_date)->isoFormat('D MMMM YYYY')
                                                        : '-' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">Kabupaten/kota Asal</td>
                                                <td style="width: 70%;">
                                                    {{ $user->profile->regency->name ?? '-' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">NIM</td>
                                                <td style="width: 70%;">{{ $user->profile->nim ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">Universitas</td>
                                                <td style="width: 70%;">
                                                    {{ $user->profile->university ?? '-' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">Jurusan</td>
                                                <td style="width: 70%;">
                                                    {{ $user->profile->major ?? '-' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>

                                {{-- Berkas --}}
                                <div class="tab-pane" id="berkas">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">KTP</td>
                                                <td style="width: 70%;">
                                                    @if ($user->profile->ktp)
                                                        <a href="{{ asset('storage/users/ktp/' . $user->profile->ktp) }}"
                                                            target="_blank">Lihat KTP
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">Kartu Keluarga</td>
                                                <td style="width: 70%;">
                                                    @if ($user->profile->family_card)
                                                        <a href="{{ asset('storage/users/kartu-keluarga/' . $user->profile->family_card) }}"
                                                            target="_blank">Lihat Kartu Keluarga
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">Surat Aktif Kuliah</td>
                                                <td style="width: 70%;">
                                                    @if ($user->profile->active_student)
                                                        <a href="{{ asset('storage/users/surat-aktif/' . $user->profile->active_student) }}"
                                                            target="_blank">Lihat Surat Aktif Kuliah
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">Foto</td>
                                                <td style="width: 70%;">
                                                    @if ($user->profile->photo)
                                                        <a href="{{ asset('storage/users/foto/' . $user->profile->photo) }}"
                                                            target="_blank">Lihat Foto
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mb-3">Kembali</a>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@section('script')
    <script>
        $(function() {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });

        $(function() {
            bsCustomFileInput.init();
        });
    </script>
@endsection
@endsection
