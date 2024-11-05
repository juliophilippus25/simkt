<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMKT | Pendaftaran</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminLTE/dist/css/adminlte.min.css?v=3.2.0') }}">
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/" class="h1"><b>SIMKT</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Pendaftaran akun di SIMKT</p>

                <form action="{{ route('register') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <!-- Nama Lengkap -->
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" id="name"
                                class="form-control @error('name') is-invalid @enderror @if (old('name') && !$errors->has('name')) is-valid @endif"
                                placeholder="Nama lengkap" name="name" value="{{ old('name') }}" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                        </div>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <div class="input-group">
                            <input type="email" id="email"
                                class="form-control @error('email') is-invalid @enderror @if (old('email') && !$errors->has('email')) is-valid @endif"
                                placeholder="Email" name="email" value="{{ old('email') }}" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                        </div>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Nomor HP -->
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" id="phone"
                                class="form-control @error('phone') is-invalid @enderror @if (old('phone') && !$errors->has('phone')) is-valid @endif"
                                placeholder="Nomor HP" name="phone" value="{{ old('phone') }}"
                                onkeypress="return isNumberKey(event)" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                        </div>
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="form-group">
                        <div class="input-group">
                            <select id="gender"
                                class="form-control @error('gender') is-invalid @enderror @if (old('gender') && !$errors->has('gender')) is-valid @endif"
                                name="gender" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                            </div>
                            @error('gender')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <!-- NIK -->
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" id="nik"
                                class="form-control @error('nik') is-invalid @enderror @if (old('nik') && !$errors->has('nik')) is-valid @endif"
                                placeholder="NIK" name="nik" value="{{ old('nik') }}"
                                onkeypress="return isNumberKey(event)" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                            </div>
                        </div>
                        @error('nik')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Upload KTP -->
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" id="ktp"
                                    class="custom-file-input @error('ktp') is-invalid @enderror @if (old('ktp') && !$errors->has('ktp')) is-valid @endif"
                                    name="ktp" required>
                                <label class="custom-file-label" for="ktp">Pilih file KTP</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-upload"></i></span>
                            </div>
                            @error('ktp')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <!-- Tombol Daftar -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                    </div>
                </form>

                <a href="{{ route('login') }}" class="text-center">Sudah punya akun?</a>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    @include('sweetalert::alert')

    <!-- jQuery -->
    <script src="{{ asset('adminLTE/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminLTE/dist/js/adminlte.min.js?v=3.2.0') }}"></script>
    <!-- bs-custom-file-input -->
    <script src="{{ asset('adminLTE/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <script>
        $(function() {
            bsCustomFileInput.init();
        });

        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }
    </script>
</body>

</html>
