<aside class="sidebar d-flex flex-column">

    {{-- Brand --}}
    <div class="sidebar-brand">
        <i class="bi bi-cart3 me-2"></i>
        Order System
    </div>

    {{-- Main Navigation --}}
    <nav class="sidebar-nav">

        <a href="{{ route('dashboard') }}"
            class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

            <i class="bi bi-grid me-2"></i>
            Dashboard
        </a>

        <a href="{{ route('items.index') }}"
            class="sidebar-link {{ request()->routeIs('items.*') ? 'active' : '' }}">

            <i class="bi bi-box-seam me-2"></i>
            Items
        </a>

        <a href="{{ route('orders.index') }}"
            class="sidebar-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
            <i class="bi bi-cart3"></i>
            <span>Orders</span>
        </a>

    </nav>

    {{-- Bottom Navigation --}}
    <div class="sidebar-bottom">

        <a href="#" class="sidebar-link">
            <i class="bi bi-person-circle me-2"></i>
            Profile
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="sidebar-link sidebar-logout w-100 border-0 text-start">
                <i class="bi bi-box-arrow-right me-2"></i>
                Logout
            </button>
        </form>

    </div>

</aside>