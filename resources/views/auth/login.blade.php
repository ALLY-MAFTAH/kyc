<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KYC | Login</title>

    {{-- STYLES --}}
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

</head>

<body>

    <div class="container">
        <br>
        @if (session('info'))
            <div class="alert alert-info" role="alert">
                {{ session('info') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <div class="wrapper bg-white">
            <div class="h2 text-center">
                <img src="{{ asset('assets/images/logo.png') }}" height="140px" width="180px" alt="">
            </div>
            <div class="h4 text-muted text-center pt-2">KYC System</div>
            <form action="{{ route('login') }}" method="POST" class="pt-3">
                @csrf
                <div class="form-group py-2">
                    <div class="input-field">
                        <span class="far fa-user p-2"></span>
                        <input type="email" name="email" placeholder="Email Address" required
                            class="@error('email') is-invalid @enderror">
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group py-1 pb-2">
                    <div class="input-field">
                        <span class="fas fa-lock p-2"></span>
                        <input type="password" name="password" placeholder="Password" required
                            class="@error('password') is-invalid @enderror">
                        <a id="togglePassword" class="btn bg-white text-muted">
                            <span class="far fa-eye-slash"></span>
                        </a>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-flex align-items-start">
                    <div class="remember">
                        <label class="option text-muted"> Remember me
                            <input class="form-check-input" type="radio" name="radio" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-block text-center my-3">Login</button>
                @if (Route::has('password.request'))
                    <div class="text-center pt-3 text-muted">Forgot Password? <a
                            href="{{ route('password.request') }}">Reset</a></div>
                @endif
            </form>
        </div>

    </div>

    {{-- SCRIPTS --}}
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        document.getElementById("togglePassword").addEventListener("click", function() {
            var passwordInput = document.getElementsByName("password")[0];
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                this.innerHTML = '<span class="far fa-eye"></span>';
            } else {
                passwordInput.type = "password";
                this.innerHTML = '<span class="far fa-eye-slash"></span>';
            }
        });
    </script>
</body>

</html>
