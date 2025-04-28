<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Booking Lapangan Olahraga</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Toastify CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --primary-dark: #2e59d9;
            --secondary-color: #f8f9fa;
            --text-color: #5a5c69;
            --card-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            --hover-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            --success-color: #1cc88a;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --info-color: #36b9cc;
        }

        body {
            padding-top: 20px;
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
        }

        .navbar {
            margin-bottom: 25px;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
        }

        .navbar:hover {
            box-shadow: var(--hover-shadow);
        }

        .navbar-brand {
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .card {
            margin-bottom: 25px;
            border-radius: 15px;
            border: none;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: var(--hover-shadow);
            transform: translateY(-3px);
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 15px 20px;
            font-weight: 500;
        }

        .card-body {
            padding: 20px;
        }

        .btn {
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(78, 115, 223, 0.3);
        }

        .btn-secondary:hover,
        .btn-success:hover,
        .btn-info:hover,
        .btn-warning:hover,
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .form-control, .form-select {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }

        .table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }

        .table th {
            background-color: #f8f9fc;
            font-weight: 600;
            color: #4a5568;
        }

        .table td, .table th {
            padding: 12px 15px;
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(78, 115, 223, 0.05);
        }

        .pagination {
            justify-content: flex-end;
            margin-top: 20px;
        }

        .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .page-link {
            color: var(--primary-color);
            padding: 8px 16px;
        }

        .badge {
            padding: 6px 10px;
            font-weight: 500;
            border-radius: 6px;
        }

        .user-info {
            color: white;
            display: flex;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.1);
            padding: 6px 12px;
            border-radius: 8px;
            margin-right: 15px;
        }

        .user-info .badge {
            margin-left: 8px;
            font-size: 10px;
            padding: 4px 8px;
        }

        /* Status badges */
        .badge-pending {
            background-color: var(--warning-color);
            color: #212529;
        }

        .badge-confirmed {
            background-color: var(--success-color);
            color: white;
        }

        /* Custom Alert Styles */
        .alert {
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 25px;
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            animation: fadeInDown 0.5s;
        }

        .alert-success {
            background-color: rgba(28, 200, 138, 0.15);
            border-left: 4px solid var(--success-color);
            color: #0f6848;
        }

        .alert-danger {
            background-color: rgba(231, 74, 59, 0.15);
            border-left: 4px solid var(--danger-color);
            color: #a52a21;
        }

        .alert-warning {
            background-color: rgba(246, 194, 62, 0.15);
            border-left: 4px solid var(--warning-color);
            color: #8e6f10;
        }

        footer {
            padding: 20px 0;
            color: #6c757d;
            font-size: 14px;
        }

        /* Animation classes */
        .fade-in {
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Action Button Styling */
        .btn-sm {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: all 0.2s ease;
            margin: 0 1px;
        }

        .btn-info {
            background-color: var(--info-color);
            border-color: var(--info-color);
        }

        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
        }

        .btn-warning {
            background-color: var(--warning-color);
            border-color: var(--warning-color);
        }

        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }

        .btn-sm:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        /* Gap utility for spacing between flex items */
        .gap-1 {
            gap: 0.25rem;
        }

        .gap-2 {
            gap: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('booking.index') }}">
                    <i class="fas fa-calendar-check me-2"></i>Booking Lapangan
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('booking.index') ? 'active' : '' }}" href="{{ route('booking.index') }}">
                                <i class="fas fa-list me-1"></i>Daftar Booking
                            </a>
                        </li>
                        @if(Auth::user()->role !== 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('booking.create') ? 'active' : '' }}" href="{{ route('booking.create') }}">
                                <i class="fas fa-plus-circle me-1"></i>Tambah Booking
                            </a>
                        </li>
                        @endif
                        @if(Auth::user() && Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('booking.pending') ? 'active' : '' }}" href="{{ route('booking.pending') }}">
                                <i class="fas fa-clock me-1"></i>Menunggu Persetujuan
                                @php
                                    $pendingCount = \App\Models\Booking::where('status', 'pending')->count();
                                @endphp
                                @if($pendingCount > 0)
                                    <span class="badge bg-danger">{{ $pendingCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('booking.trash') ? 'active' : '' }}" href="{{ route('booking.trash') }}">
                                <i class="fas fa-trash me-1"></i>Riwayat Dihapus
                            </a>
                        </li>
                        @endif
                    </ul>
                    <div class="d-flex">
                        <div class="user-info me-3">
                            <i class="fas fa-user-circle me-1"></i>
                            {{ Auth::user()->name }}
                            <span class="badge {{ Auth::user()->role === 'admin' ? 'bg-danger' : 'bg-success' }}">
                                {{ Auth::user()->role === 'admin' ? 'Admin' : 'User' }}
                            </span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-light" id="logoutButton">
                                <i class="fas fa-sign-out-alt me-1"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <div id="notification-container">
            <!-- Alert notifications removed in favor of Toastify -->
        </div>

        <main class="py-3 fade-in">
            @yield('content')
        </main>

        <footer class="mt-4 text-center text-muted">
            <p>&copy; {{ date('Y') }} Aplikasi Booking Lapangan Olahraga</p>
        </footer>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Toastify JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Convert session flash messages to Toastify notifications
        @if(session('success'))
            Toastify({
                text: "{{ session('success') }}",
                duration: 4000,
                close: true,
                gravity: "top",
                position: "right",
                style: {
                    background: "linear-gradient(to right, #1cc88a, #20d997)",
                    borderRadius: "8px",
                    boxShadow: "0 4px 15px rgba(28, 200, 138, 0.3)",
                    fontFamily: "'Poppins', sans-serif",
                    fontSize: "14px"
                },
                stopOnFocus: true,
                onClick: function(){}
            }).showToast();
        @endif

        @if(session('error'))
            Toastify({
                text: "{{ session('error') }}",
                duration: 4000,
                close: true,
                gravity: "top",
                position: "right",
                style: {
                    background: "linear-gradient(to right, #e74a3b, #e95c4b)",
                    borderRadius: "8px",
                    boxShadow: "0 4px 15px rgba(231, 74, 59, 0.3)",
                    fontFamily: "'Poppins', sans-serif",
                    fontSize: "14px"
                },
                stopOnFocus: true,
                onClick: function(){}
            }).showToast();
        @endif

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Logout animation
        const logoutForm = document.getElementById('logoutForm');
        const logoutButton = document.getElementById('logoutButton');

        if (logoutForm && logoutButton) {
            logoutButton.addEventListener('click', function(e) {
                e.preventDefault();

                // Add rotation animation to the icon
                const icon = logoutButton.querySelector('.fas');
                icon.classList.add('animate__animated', 'animate__rotateOut');

                // Fade out the entire page
                document.body.style.transition = 'opacity 0.8s ease';

                setTimeout(() => {
                    document.body.style.opacity = 0;

                    // Submit the form immediately to prevent CSRF token expiration
                    logoutForm.submit();
                }, 600);
            });
        }
    });
    </script>

    @yield('scripts')
    @stack('scripts')
</body>
</html>
