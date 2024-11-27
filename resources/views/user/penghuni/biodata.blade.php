@extends('layouts.app')

@section('title', 'Ubah Biodata')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ubah Biodata</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{-- <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li> --}}
                        <li class="breadcrumb-item active">Ubah Biodata</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="alert alert-info text-center">
            Anda dapat melakukan pengajuan ubah biodata
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal">
                Ajukan
            </button>
        </div>

        <div class="modal fade" id="detailModal">
            <form action="{{ route('user.biodata.store') }}" method="POST" id="biodataForm">
                @csrf
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title text-dark">Pengajuan Ubah Biodata - {{ $user->profile->name }}
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <!-- Kolom Email Lama -->
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="text-dark">Email lama</label>
                                        <input id="email_lama" name="email_lama" type="email" class="form-control"
                                            value="{{ $user->email }}" disabled>
                                    </div>
                                </div>

                                <!-- Tanda "->" di Tengah -->
                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <i class="fas fa-arrow-right"></i>
                                </div>

                                <!-- Kolom Email Baru -->
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="text-dark">Email baru</label>
                                        <input id="email" name="email" type="email" class="form-control"
                                            placeholder="Email baru" value="{{ old('email') }}">
                                    </div>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <!-- Kolom Nama Lengkap Lama -->
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="text-dark">Nama lengkap lama</label>
                                        <input id="name_lama" name="name_lama" type="text" class="form-control"
                                            value="{{ $user->profile->name }}" disabled>
                                    </div>
                                </div>

                                <!-- Tanda "->" di Tengah -->
                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <i class="fas fa-arrow-right"></i>
                                </div>

                                <!-- Kolom Nama Lengkap Baru -->
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="text-dark">Nama lengkap baru</label>
                                        <input id="name" name="name" type="text" class="form-control"
                                            value="{{ old('name') }}" placeholder="Nama baru">
                                    </div>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer justify-content-end">
                            <button type="submit" class="btn btn-primary">Ajukan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </section>
    <!-- /.content -->

@section('script')
    <script>
        document.getElementById('reason').value = '';
    </script>
@endsection

@endsection
