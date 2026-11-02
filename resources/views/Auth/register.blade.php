<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container min-vh-100 d-flex justify-content-center align-items-center">

        <div class="card shadow-sm border-0" style="width: 100%; max-width: 450px;">

            <div class="card-body p-4">

                <h3 class="text-center mb-4">Create Account</h3>

                @if (session('success'))
                <div id="success-message" class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('register.store') }}" method="POST">
                    @csrf

                    {{-- Name --}}
                    <div class="mb-3">

                        <label class="form-label">Name</label>

                        <input
                            type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Enter your name">

                        @error('name')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>

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
                            placeholder="Enter password">

                        @error('password')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>

                    {{-- Confirm Password --}}
                    <div class="mb-3">

                        <label class="form-label">Confirm Password</label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            placeholder="Confirm password">

                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="btn btn-success w-100">
                        Register
                    </button>

                </form>

                <div class="text-center mt-3">
                    <small>
                        Already have an account?
                        <a href="{{ route('login') }}"
                            class="login-link fw-semibold text-success">
                            Sign In
                        </a>
                    </small>
                </div>

            </div>

        </div>

    </div>

    <script>
        const successMessage = document.getElementById('success-message');

        if (successMessage) {
            setTimeout(() => {
                successMessage.style.transition = 'opacity 0.5s ease';
                successMessage.style.opacity = '0';

                setTimeout(() => {
                    successMessage.remove();
                }, 500);

            }, 3000);
        }
    </script>

</body>

</html>