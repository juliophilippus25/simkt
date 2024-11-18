@extends('layouts.app')

@section('title', 'Keluar Asrama')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Keluar Asrama</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Keluar Asrama</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        @if ($userRoom)
            @if ($outResidency)
                <div class="alert alert-info text-center">
                    Pengajuan keluar Asrama telah diajukan
                </div>
            @else
                <div class="alert alert-info text-center">
                    Anda dapat melakukan Pengajuan keluar dari Asrama
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal">
                        Ajukan
                    </button>
                </div>

                <div class="modal fade" id="detailModal">
                    <form action="{{ route('user.penghuni.out.apply') }}" method="POST" id="outResidencyForm">
                        @csrf
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title text-dark">Pengajuan Keluar Asrama -
                                        {{ $userRoom->user->profile->name }}</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="text-dark">Alasan :</label>
                                        <textarea id="reason" name="reason" class="form-control" rows="3" cols="3" placeholder="Alasan"
                                            required>
                                    </textarea>
                                    </div>
                                </div>

                                <div class="modal-footer justify-content-end">
                                    <button type="submit" class="btn btn-primary">Ajukan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        @else
            <div class="alert alert-danger text-center">
                Perhatian! Anda tidak dapat mengajukan keluar asrama karena Anda belum terdaftar di kamar asrama.
            </div>
        @endif

    </section>
    <!-- /.content -->

@endsection
