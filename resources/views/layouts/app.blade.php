<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Order System')</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        rel="stylesheet">

    <style>
        /* Global Styles */
        body {
            background-color: #f1f5f9;
            color: #1e293b;
        }

        /* Main Content */
        main {
            min-height: calc(100vh - 70px);
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            min-width: 260px;
            flex: 0 0 260px;
            min-height: 100vh;
            background-color: #059669;
            color: #ffffff;
        }

        /* Brand */
        .sidebar-brand {
            padding: 24px 20px;
            font-size: 22px;
            font-weight: 700;
        }

        /* Navigation */
        .sidebar-nav {
            padding: 10px 12px;
        }

        /* Sidebar Links */
        .sidebar-link {
            display: block;
            padding: 12px 16px;
            margin-bottom: 6px;
            color: #d1fae5;
            text-decoration: none;
            border-radius: 8px;
            transition: 0.2s;
        }

        /* Hover */
        .sidebar-link:hover {
            background-color: #047857;
            color: #ffffff;
        }

        /* Active Link */
        .sidebar-link.active {
            background-color: #047857;
            color: #ffffff;
        }

        /* Bottom Navigation */
        .sidebar-bottom {
            margin-top: auto;
            padding: 12px;
        }

        /* Logout Button */
        .sidebar-logout {
            background: transparent;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <!-- @yield('content') -->
    <div class="d-flex min-vh-100">

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content Area --}}
        <div class="flex-grow-1">

            {{-- Navbar --}}
            @include('layouts.navbar')

            {{-- Page Content --}}
            <main class="p-4">
                @yield('content')
            </main>

        </div>

    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>