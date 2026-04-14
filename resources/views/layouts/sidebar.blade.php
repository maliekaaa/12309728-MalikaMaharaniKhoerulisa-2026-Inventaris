<div id="sidebar">
    <div class="sidebar-header">
        <h5 class="m-0">
            Inventaris School
        </h5>
    </div>

    <ul class="list-unstyled components">
        <li class="section-title">Menu</li>
        <li class="{{ request()->routeIs('admin.dashboard', 'staff.dashboard') ? 'active' : '' }}">
            <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('staff.dashboard') }}">
                <i class="bi bi-grid"></i>
                Dashboard
            </a>
        </li>

        {{-- sidebar untuk admin --}}
        @if(auth()->user()->role === 'admin')

            <li class="section-title">Items Data</li>
            <li class="{{ request()->routeIs('category.*') ? 'active' : '' }}">
                <a href="{{ route('category.index') }}">
                    <i class="bi bi-tags"></i>
                    Category
                </a>
            </li>
            <li class="{{ request()->routeIs('items.*') ? 'active' : '' }}">
                <a href="{{ route('items.index') }}">
                    <i class="bi bi-box-seam"></i>
                    Items
                </a>
            </li>

            <li class="section-title">Account</li>
            <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                <a data-bs-toggle="collapse" href="#userMenu" role="button"
                   aria-expanded="{{ request()->routeIs('users.*') ? 'true' : 'false' }}">
                    <i class="bi bi-people"></i>
                    Users
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul class="collapse list-unstyled ps-4 {{ request()->routeIs('users.*') ? 'show' : '' }}" id="userMenu">
                    <li class="{{ request()->routeIs('users.admin') ? 'active' : '' }}">
                        <a href="{{ route('users.admin') }}">
                            Admin
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('users.staff') ? 'active' : '' }}">
                        <a href="{{ route('users.staff') }}">
                            Staff
                        </a>
                    </li>
                </ul>
            </li>

        {{-- -sidebar untuk staff --}}
        @else

            <li class="section-title">Data Inventaris</li>
            <li class="{{ request()->routeIs('staff.items.*') ? 'active' : '' }}">
                <a href="{{ route('staff.items.index') }}">
                    <i class="bi bi-box-seam"></i>
                    Items
                </a>
            </li>
            <li class="{{ request()->routeIs('lendings.*') ? 'active' : '' }}">
                <a href="{{ route('lendings.index') }}">
                    <i class="bi bi-arrow-left-right"></i>
                    Lendings
                </a>
            </li>

            <li class="section-title">Account</li>
            <li class="{{ request()->routeIs('staff.profile.*') ? 'active' : '' }}">
                <a href="{{ route('staff.profile.edit') }}">
                    <i class="bi bi-person-circle"></i>
                    Edit Profil
                </a>
            </li>

        @endif
    </ul>
</div>
