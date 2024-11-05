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
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
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
                                <img class="profile-user-img img-fluid img-circle" src="{{ asset('images/default.png') }}"
                                    alt="User profile picture">
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
                                <li class="nav-item"><a class="nav-link" href="#akun" data-toggle="tab">Akun</a>
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
                                                        : 'Belum ada' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">Kabupaten/kota Asal</td>
                                                <td style="width: 70%;">{{ $user->profile->regency->name ?? 'Belum ada' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">NIM</td>
                                                <td style="width: 70%;">{{ $user->profile->nim ?? 'Belum ada' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">Universitas</td>
                                                <td style="width: 70%;">{{ $user->profile->university ?? 'Belum ada' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">Jurusan</td>
                                                <td style="width: 70%;">{{ $user->profile->major ?? 'Belum ada' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                        data-target="#updateModal{{ $user->id }}">
                                        Edit
                                    </button>

                                    {{-- Modal Verifikasi --}}
                                    <div class="modal fade" id="updateModal{{ $user->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Profil</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('user.profile.update', $user->id) }}"
                                                        method="POST" id="updateForm{{ $user->id }}">
                                                        @csrf
                                                        @method('POST')

                                                        <div class="form-group">
                                                            <label for="name">Nama Lengkap <b
                                                                    class="text-danger">*</b></label>
                                                            <div class="input-group">
                                                                <input type="text" id="name"
                                                                    class="form-control @error('name') is-invalid @enderror"
                                                                    placeholder="Nama lengkap" name="name"
                                                                    value="{{ old('name', $user->profile->name) }}"
                                                                    required>
                                                            </div>
                                                            @error('name')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="birth_date">Tanggal Lahir <b
                                                                    class="text-danger">*</b></label>
                                                            <input type="date"
                                                                class="form-control @error('birth_date') is-invalid @enderror"
                                                                id="birth_date" name="birth_date"
                                                                value="{{ old('birth_date', $user->profile->birth_date) }}">
                                                            @error('birth_date')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="regency_id">Kabupaten/kota <b
                                                                    class="text-danger">*</b></label>
                                                            <select
                                                                class="form-control select2bs4 @error('regency_id') is-invalid @enderror"
                                                                name="regency_id" style="width: 100%;">
                                                                @foreach ($regencies as $regency)
                                                                    <option value="{{ $regency->id }}"
                                                                        {{ old('regency_id', $user->regency_id ?? '') == $regency->id ? 'selected' : '' }}>
                                                                        {{ $regency->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                            @error('regency_id')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="nim">NIM <b class="text-danger">*</b></label>
                                                            <input type="text"
                                                                class="form-control @error('nim') is-invalid @enderror"
                                                                id="nim" name="nim"
                                                                value="{{ old('nim', $user->profile->nim) }}"
                                                                placeholder="NIM">
                                                            @error('nim')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="university">Universitas <b
                                                                    class="text-danger">*</b></label>
                                                            <input type="text"
                                                                class="form-control @error('university') is-invalid @enderror"
                                                                id="university" name="university"
                                                                value="{{ old('university', $user->profile->university) }}"
                                                                placeholder="Universitas">
                                                            @error('university')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="major">Jurusan <b
                                                                    class="text-danger">*</b></label>
                                                            <input type="text"
                                                                class="form-control @error('major') is-invalid @enderror"
                                                                id="major" name="major"
                                                                value="{{ old('major', $user->profile->major) }}"
                                                                placeholder="Jurusan">
                                                            @error('major')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="modal-footer justify-content-between">
                                                            <button type="submit" class="btn btn-primary">
                                                                Simpan
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                {{-- Berkas --}}
                                <div class="tab-pane" id="berkas">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">KTP</td>
                                                <td style="width: 70%;">{{ $user->nik }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">Kartu Keluarga</td>
                                                <td style="width: 70%;">{{ $user->profile->name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">Surat Aktif Kuliah</td>
                                                <td style="width: 70%;">
                                                    @if ($user->profile->gender == 'M')
                                                        Laki-laki
                                                    @else
                                                        Perempuan
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">Foto</td>
                                                <td style="width: 70%;">{{ $user->profile->major ?? 'Belum ada' }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Akun --}}
                                <div class="tab-pane" id="akun">
                                    <form class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" id="email"
                                                    placeholder="Email" value="{{ $user->email }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="current_password" class="col-sm-3 col-form-label">Password
                                                Lama</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="current_password"
                                                    placeholder="Password lama">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="password" class="col-sm-3 col-form-label">Password
                                                Baru</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="password"
                                                    placeholder="Password baru">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="confirmation_password" class="col-sm-3 col-form-label">Konfirmasi
                                                Password</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="confirmation_password"
                                                    placeholder="Konfirmasi password">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-3 col-sm-9">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
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
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
@endsection
@endsection
