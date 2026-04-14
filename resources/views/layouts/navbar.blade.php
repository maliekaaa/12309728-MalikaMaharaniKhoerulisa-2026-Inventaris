<nav class="navbar navbar-expand-lg navbar-light px-4">
    <div class="container-fluid">
        <button class="btn btn-outline-secondary d-lg-none me-2" id="sidebarCollapse">
            <i class="bi bi-list"></i>
        </button>

        <div class="ms-auto d-flex align-items-center gap-3">
            <span class="text-secondary small d-none d-sm-block">
                {{ auth()->user()->name }}
                <span class="badge bg-{{ auth()->user()->role === 'admin' ? 'primary' : 'success' }} ms-1">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
            </span>

            <div class="dropdown">
                <button class="btn btn-light rounded-circle" data-bs-toggle="dropdown" type="button">
                    <i class="bi bi-person-circle fs-5"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li>
                        <span class="dropdown-item-text fw-semibold text-dark">
                            {{ auth()->user()->name }}
                        </span>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
