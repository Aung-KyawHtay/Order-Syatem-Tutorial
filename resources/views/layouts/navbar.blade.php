<nav class="navbar bg-white border-bottom px-4 py-3">

    {{-- Page Title --}}
    <div>
        <h5 class="mb-0 fw-semibold">
            @yield('page-title', 'Dashboard')
        </h5>
    </div>

    {{-- User Information --}}
    <div class="d-flex align-items-center gap-2">

        <i class="bi bi-person-circle fs-4 text-success"></i>

        <span class="fw-semibold">
            {{ auth()->user()->name }}
        </span>

    </div>

</nav>