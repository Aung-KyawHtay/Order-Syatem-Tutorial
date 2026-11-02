<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container min-vh-100 d-flex justify-content-center align-items-center">

        <div class="card shadow-sm border-0" style="width: 100%; max-width: 450px;">

            <div class="card-body p-4">

                <h3 class="text-center mb-4">Welcome Back</h3>

                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show"
                    id="success-alert"
                    role="alert">

                    {{ session('success') }}

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                    </button>

                </div>
                @endif

                <form action="{{ route('login.store') }}" method="POST">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-3">

                        <label class="form-label">Email</label>

                        <input
                            type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            placeholder="Enter your email">

                        @error('email')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>

                    {{-- Password --}}
                    <div class="mb-3">

                        <label class="form-label">Password</label>

                        <input
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Enter your password">

                        @error('password')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>

                    {{-- Remember Me --}}
                    <div class="form-check mb-3">

                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                            class="form-check-input"
                            id="remember"
                            {{ old('remember') ? 'checked' : '' }}

                            <label class="form-check-label" for="remember">
                        Remember Me
                        </label>

                    </div>

                    {{-- Login Button --}}
                    <button type="submit" class="btn btn-success w-100">
                        Login
                    </button>

                </form>

                <div class="text-center mt-3">
                    <small>
                        Don't have an account?
                        <a href="{{ route('register') }}" class="register-link fw-semibold text-success">
                            Register
                        </a>
                    </small>
                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const successAlert = document.getElementById('success-alert');

            if (successAlert) {

                setTimeout(function() {

                    const alert = bootstrap.Alert.getOrCreateInstance(successAlert);

                    alert.close();

                }, 3000);

            }

        });
    </script>

</body>

</html>