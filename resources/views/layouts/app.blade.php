<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Ghana Hospital Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1e40af;
            --secondary-color: #059669;
            --danger-color: #dc2626;
        }

        body {
            background-color: #f9fafb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background-color: var(--primary-color);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
        }

        .sidebar {
            background-color: #1f2937;
            min-height: 100vh;
            padding-top: 2rem;
            position: fixed;
            left: 0;
            top: 60px;
            width: 280px;
            overflow-y: auto;
        }

        .sidebar a {
            color: #e5e7eb;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: #374151;
            border-left-color: var(--secondary-color);
            color: white;
        }

        .sidebar a i {
            margin-right: 0.75rem;
            width: 20px;
        }

        .main-content {
            margin-left: 280px;
            margin-top: 60px;
            padding: 2rem;
        }

        .card {
            border: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-radius: 0.5rem;
        }

        .stat-card {
            background: linear-gradient(135deg, var(--primary-color) 0%, #3b82f6 100%);
            color: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-card p {
            font-size: 0.875rem;
            opacity: 0.9;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #1e3a8a;
            border-color: #1e3a8a;
        }

        .btn-success {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .badge-success {
            background-color: var(--secondary-color);
        }

        table {
            margin-bottom: 0;
        }

        .table-hover tbody tr:hover {
            background-color: #f3f4f6;
        }

        .alert {
            border-radius: 0.5rem;
            border: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
        }
    </style>
    @yield('css')
</head>
<body>
    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-hospital"></i> GHMS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ Auth::user()->full_name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('settings.profile') }}">Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('change-password') }}">Change Password</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar">
            <ul class="list-unstyled">
                <li>
                    <a href="{{ route('dashboard') }}" class="@if(request()->routeIs('dashboard')) active @endif">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>

                <li><hr class="my-2" style="border-color: #374151; margin-left: 1.5rem; margin-right: 1.5rem;"></li>

                <li style="padding: 0.75rem 1.5rem; color: #9ca3af; font-size: 0.875rem; font-weight: 600;">MANAGEMENT</li>

                <li>
                    <a href="{{ route('patients.index') }}" class="@if(request()->routeIs('patients.*')) active @endif">
                        <i class="bi bi-people"></i> Patients
                    </a>
                </li>

                <li>
                    <a href="{{ route('appointments.index') }}" class="@if(request()->routeIs('appointments.*')) active @endif">
                        <i class="bi bi-calendar-event"></i> Appointments
                    </a>
                </li>

                <li><hr class="my-2" style="border-color: #374151; margin-left: 1.5rem; margin-right: 1.5rem;"></li>

                <li style="padding: 0.75rem 1.5rem; color: #9ca3af; font-size: 0.875rem; font-weight: 600;">HEALTHCARE & INSURANCE</li>

                <li>
                    <a href="{{ route('nhis.index') }}" class="@if(request()->routeIs('nhis.*')) active @endif">
                        <i class="bi bi-shield-check"></i> NHIS Members
                    </a>
                </li>

                <li>
                    <a href="{{ route('claims.index') }}" class="@if(request()->routeIs('claims.*')) active @endif">
                        <i class="bi bi-file-earmark-text"></i> Insurance Claims
                    </a>
                </li>

                <li><hr class="my-2" style="border-color: #374151; margin-left: 1.5rem; margin-right: 1.5rem;"></li>

                <li style="padding: 0.75rem 1.5rem; color: #9ca3af; font-size: 0.875rem; font-weight: 600;">SETTINGS</li>

                <li>
                    <a href="{{ route('settings.profile') }}" class="@if(request()->routeIs('settings.*')) active @endif">
                        <i class="bi bi-gear"></i> Settings
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content flex-grow-1">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('js')
</body>
</html>
