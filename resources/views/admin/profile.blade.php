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
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
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
                                @if ($admin->avatar)
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ asset('storage/admins/avatar/' . $admin->avatar) }}"
                                        alt="User profile picture" style="width: 120px; height: 120px; object-fit: cover;">
                                @else
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ asset('images/default.png') }}" alt="User profile picture"
                                        style="width: 120px; height: 120px; object-fit: cover;">
                                @endif
                            </div>

                            <h3 class="profile-username text-center">{{ $admin->name }}</h3>

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
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">

                                {{-- Biodata --}}
                                <div class="active tab-pane" id="biodata">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">Nama</td>
                                                <td style="width: 70%;">{{ $admin->name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">NIP</td>
                                                <td style="width: 70%;">{{ $admin->nip }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 30%;">Role</td>
                                                <td style="width: 70%;">
                                                    @if ($admin->role == 'admin')
                                                        Admin
                                                    @else
                                                        Super Admin
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                        data-target="#updateBiodata{{ $admin->id }}">
                                        Ubah Biodata
                                    </button>

                                    {{-- Modal Biodata --}}
                                    <div class="modal fade" id="updateBiodata{{ $admin->id }}">
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
                                                    <form action="{{ route('admin.biodata.update', $admin->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('POST')

                                                        {{-- <div class="form-group">
                                                            <label for="name">Nama <b class="text-danger">*</b></label>
                                                            <input type="date"
                                                                class="form-control @error('name') is-invalid @enderror"
                                                                id="name" name="name"
                                                                value="{{ old('name', $admin->name) }}">
                                                            @error('name')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="nip">NIP <b class="text-danger">*</b></label>
                                                            <input type="date"
                                                                class="form-control @error('nip') is-invalid @enderror"
                                                                id="nip" name="nip"
                                                                value="{{ old('nip', $admin->nip) }}">
                                                            @error('nip')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div> --}}

                                                        <div class="form-group">
                                                            <label for="avatar">Foto <b class="text-danger">*</b></label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" id="avatar"
                                                                        class="custom-file-input @error('avatar') is-invalid @enderror"
                                                                        name="avatar" value="{{ $admin->avatar }}">
                                                                    <label class="custom-file-label" for="avatar">Pilih
                                                                        file foto</label>
                                                                </div>
                                                            </div>
                                                            @error('avatar')
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
            bsCustomFileInput.init();
        });
    </script>
@endsection
@endsection
