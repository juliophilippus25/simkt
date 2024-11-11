@extends('layouts.app')

@section('title', 'Profil')

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
                        <li class="breadcrumb-item active">Profil</li>
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
                                                        : 'Tanggal lahir belum diisi' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">Kabupaten/kota Asal</td>
                                                <td style="width: 70%;">
                                                    {{ $user->profile->regency->name ?? 'Kabupaten/kota asal belum diisi' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">NIM</td>
                                                <td style="width: 70%;">{{ $user->profile->nim ?? 'NIM belum diisi' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">Universitas</td>
                                                <td style="width: 70%;">
                                                    {{ $user->profile->university ?? 'Universitas belum diisi' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">Jurusan</td>
                                                <td style="width: 70%;">
                                                    {{ $user->profile->major ?? 'Jurusan belum diisi' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                        data-target="#updateBiodata{{ $user->id }}">
                                        Ubah Biodata
                                    </button>

                                    {{-- Modal Biodata --}}
                                    <div class="modal fade" id="updateBiodata{{ $user->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Ubah Biodata</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('user.biodata.update', $user->id) }}"
                                                        method="POST">
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

                                                        <div class="modal-footer">
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
                                                <td style="width: 70%;">
                                                    @if ($user->profile->ktp)
                                                        <a href="{{ asset('storage/users/ktp/' . $user->profile->ktp) }}"
                                                            target="_blank">Lihat KTP
                                                        </a>
                                                    @else
                                                        KTP belum diunggah.
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
                                                        Kartu keluarga belum diunggah.
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
                                                        Surat aktif kuliah belum diunggah.
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
                                                        Foto belum diunggah.
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                        data-target="#updateBerkas{{ $user->id }}">
                                        Ubah Berkas
                                    </button>

                                    {{-- Modal Berkas --}}
                                    <div class="modal fade" id="updateBerkas{{ $user->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Ubah Berkas</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('user.berkas.update', $user->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('POST')

                                                        <div class="form-group">
                                                            <label for="ktp">KTP <b class="text-danger">*</b></label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" id="ktp"
                                                                        class="custom-file-input @error('ktp') is-invalid @enderror"
                                                                        name="ktp" value="{{ $user->profile->ktp }}">
                                                                    <label class="custom-file-label" for="ktp">Pilih
                                                                        file KTP</label>
                                                                </div>
                                                            </div>
                                                            @error('ktp')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>


                                                        <div class="form-group">
                                                            <label for="family_card">Kartu Keluarga <b
                                                                    class="text-danger">*</b></label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" id="family_card"
                                                                        class="custom-file-input @error('family_card') is-invalid @enderror"
                                                                        name="family_card">
                                                                    <label class="custom-file-label"
                                                                        for="family_card">Pilih
                                                                        file kartu keluarga</label>
                                                                </div>
                                                            </div>
                                                            @error('family_card')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="active_student">Surat Aktif Kuliah <b
                                                                    class="text-danger">*</b></label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" id="active_student"
                                                                        class="custom-file-input @error('active_student') is-invalid @enderror"
                                                                        name="active_student">
                                                                    <label class="custom-file-label"
                                                                        for="active_student">Pilih
                                                                        file surat aktif kuliah</label>
                                                                </div>
                                                            </div>
                                                            @error('active_student')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="photo">Foto <b
                                                                    class="text-danger">*</b></label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" id="photo"
                                                                        class="custom-file-input @error('photo') is-invalid @enderror"
                                                                        name="photo">
                                                                    <label class="custom-file-label" for="photo">Pilih
                                                                        file foto</label>
                                                                </div>
                                                            </div>
                                                            @error('photo')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="modal-footer">
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

                                {{-- Akun --}}
                                <div class="tab-pane" id="akun">
                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('user.password.update') }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" id="email"
                                                    placeholder="Email" value="{{ $user->email }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="current_password" class="col-sm-3 col-form-label">Password
                                                Lama</label>
                                            <div class="col-sm-9">
                                                <input type="password"
                                                    class="form-control @error('current_password') is-invalid @enderror"
                                                    id="current_password" name="current_password"
                                                    placeholder="Password lama">
                                                @error('current_password')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="new_password" class="col-sm-3 col-form-label">Password Baru
                                                Baru</label>
                                            <div class="col-sm-9">
                                                <input type="password"
                                                    class="form-control @error('new_password') is-invalid @enderror"
                                                    id="new_password" name="new_password" placeholder="Password baru">
                                                @error('new_password')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="confirm_password" class="col-sm-3 col-form-label">Konfirmasi
                                                Password</label>
                                            <div class="col-sm-9">
                                                <input type="password"
                                                    class="form-control @error('confirm_password') is-invalid @enderror"
                                                    id="confirm_password" name="confirm_password"
                                                    placeholder="Konfirmasi password">
                                                @error('confirm_password')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
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
