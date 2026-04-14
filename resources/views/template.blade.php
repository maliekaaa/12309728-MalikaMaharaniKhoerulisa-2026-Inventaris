<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inventaris Sekolah')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
    :root {
        --blue-dark:  #1e3a8a;
        --blue-mid:   #2563eb;
        --blue-light: #3b82f6;
        --bg-light:   #f1f5f9;
        --sidebar-w:  260px;
    }

    * { box-sizing: border-box; }

    body {
        font-family: 'Inter', 'Segoe UI', sans-serif;
        background-color: var(--bg-light);
        overflow-x: hidden;
        font-size: 14px;
    }

    /* css sidebar */
    #sidebar {
        min-width: var(--sidebar-w);
        max-width: var(--sidebar-w);
        min-height: 100vh;
        background: linear-gradient(180deg, var(--blue-dark) 0%, #1e40af 100%);
        color: white;
        transition: all 0.3s ease;
        position: sticky;
        top: 0;
        height: 100vh;
        overflow-y: auto;
    }

    #sidebar .sidebar-header {
        padding: 20px 18px;
        font-size: 15px;
        font-weight: 700;
        background: rgba(0,0,0,0.15);
        border-bottom: 1px solid rgba(255,255,255,0.08);
        letter-spacing: 0.3px;
    }

    #sidebar ul { padding: 8px 0; margin: 0; }
    #sidebar ul li { list-style: none; }

    #sidebar ul li a,
    .sidebar-logout-btn {
        padding: 10px 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: rgba(255,255,255,0.82);
        text-decoration: none;
        font-size: 13.5px;
        font-weight: 500;
        transition: all 0.2s;
        border: none;
        background: transparent;
        width: 100%;
        cursor: pointer;
    }

    #sidebar ul li a:hover,
    .sidebar-logout-btn:hover {
        background: rgba(255,255,255,0.12);
        color: white;
    }

    #sidebar ul li.active > a {
        background: rgba(255,255,255,0.18);
        color: white;
        border-left: 3px solid #60a5fa;
    }

    #sidebar i { font-size: 16px; }

    .section-title {
        padding: 14px 18px 4px;
        font-size: 10px;
        font-weight: 700;
        opacity: 0.5;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* css dropdown sub menu */
    #sidebar ul ul { background: rgba(0,0,0,0.15); }
    #sidebar ul ul li a { padding: 9px 18px 9px 44px; font-size: 13px; }

    /* css navbar */
    .navbar {
        background-color: white !important;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        padding: 10px 20px;
        position: sticky;
        top: 0;
        z-index: 100;
    }

    /* css main content */
    .main-content { width: 100%; min-height: 100vh; display: flex; flex-direction: column; }
    main { flex: 1; }

    /* css card's */
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }

    .welcome-card {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-light) 100%);
        border-radius: 14px;
    }

    /* css stat cards */
    .stat-card {
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .stat-card .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    /* css tables */
    .table { margin: 0; }
    .table thead th {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background-color: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        color: #64748b;
        padding: 12px 16px;
    }

    .table tbody td {
        font-size: 13.5px;
        padding: 13px 16px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #374151;
    }

    .table-hover tbody tr:hover { background-color: #f8fafc; }

    /* css forms */
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 9px 13px;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--blue-light);
        box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
    }

    .form-label { font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 5px; }

    /* css button's */
    .btn { font-size: 13px; font-weight: 500; border-radius: 8px; }
    .btn-green  { background-color: #10b981; color: white; }
    .btn-green:hover { background-color: #059669; color: white; }
    .btn-purple { background-color: #7c3aed; color: white; }
    .btn-purple:hover { background-color: #6d28d9; color: white; }

    /* css alerts */
    .alert { border-radius: 10px; font-size: 13.5px; }

    /* css badges */
    .badge { font-size: 11px; font-weight: 600; padding: 4px 9px; border-radius: 6px; }

    /* css footer */
    footer {
        background-color: white;
        border-top: 1px solid #e2e8f0;
        padding: 14px 24px;
        font-size: 12px;
        color: #94a3b8;
    }

    /* css responsive */
    @media (max-width: 768px) {
        #sidebar {
            position: fixed;
            left: -var(--sidebar-w);
            z-index: 999;
        }
        #sidebar.active { left: 0; }
    }
    </style>
    @stack('styles')
</head>
<body>

<div class="d-flex">
    @include('layouts.sidebar')

    <div class="main-content">
        @include('layouts.navbar')

        <main class="p-4">
            <div class="container-fluid">
                {{-- Flash messages --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('failed'))
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('failed') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Terdapat kesalahan:</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        @include('layouts.footer')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle sidebar mobile
    const sidebarToggle = document.getElementById('sidebarCollapse');
    const sidebar = document.getElementById('sidebar');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => sidebar.classList.toggle('active'));
    }
</script>
@stack('scripts')
</body>
</html>
