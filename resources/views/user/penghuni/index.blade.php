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
                @if (!$dataLengkap)
                    <!-- Jika data profil belum lengkap -->
                    <div class="d-flex justify-content-center">
                        <div class="alert alert-warning text-center" style="width: 100%;">
                            <p><strong>Perhatian!</strong> Lengkapi data Anda terlebih dahulu.</p>
                            <a href="{{ route('user.profile') }}" class="btn btn-primary"
                                style="text-decoration: none;">Klik disini</a>
                        </div>
                    </div>
                @else
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="text-center">
                            <p>Data sudah lengkap, Anda dapat mengajukan sebagai penghuni.</p>
                            <a href="{{ route('user.profile') }}" class="btn btn-primary"
                                style="text-decoration: none;">Ajukan</a>
                        </div>
                    </div>
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
