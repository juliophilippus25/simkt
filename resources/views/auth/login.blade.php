<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMKT | Login</title>

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

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/" class="h1"><b>SIMKT</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Silakan login ke akun Anda</p>

                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <!-- NIK/NIP -->
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" id="nik"
                                class="form-control @error('identifier') is-invalid @enderror" placeholder="NIK/NIP"
                                name="identifier" value="{{ old('identifier') }}" onkeypress="return isNumberKey(event)"
                                required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                            </div>
                        </div>
                        @error('identifier')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <div class="input-group">
                            <input type="password" id="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                name="password" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                        </div>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Tombol Login -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </div>
                </form>

                <a href="{{ route('register') }}" class="text-center">Belum punya akun?</a>
            </div>
            <!-- /.form-body -->
        </div><!-- /.card -->
    </div>
    <!-- /.login-box -->

    @include('sweetalert::alert')

    <!-- jQuery -->
    <script src="{{ asset('adminLTE/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminLTE/dist/js/adminlte.min.js?v=3.2.0') }}"></script>

    <script>
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            // Hanya izinkan angka
            if (charCode != 46 && charCode != 45 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
    </script>
</body>


</html>
