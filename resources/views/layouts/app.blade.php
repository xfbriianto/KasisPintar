<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Aplikasi Inventory') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    
    <style>
        /* General Styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }

        /* Sidebar Styles */
        #sidebar {
            min-height: 100vh;
            width: 270px;
            background: #2c3e50;
            color: white;
            position: fixed;
            transition: all 0.3s ease;
            z-index: 999;
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background: #1a252f;
            text-align: center;
            border-bottom: 1px solid #444;
        }

        #sidebar ul.components {
            padding: 0;
            list-style: none;
            margin: 0;
        }

        #sidebar ul li {
            border-bottom: 1px solid #444;
        }

        #sidebar ul li a {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            color: #bdc3c7;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        #sidebar ul li a:hover {
            background: #34495e;
            color: #ecf0f1;
        }

        #sidebar ul li a.active {
            background: #2980b9;
            color: white;
            font-weight: bold;
        }

        #sidebar ul li a i {
            margin-right: 15px;
            font-size: 18px;
        }

        #content {
            margin-left: 270px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        @media (max-width: 768px) {
            #sidebar {
                margin-left: -270px;
            }
            #sidebar.active {
                margin-left: 0;
            }
            #content {
                margin-left: 0;
            }
        }

        /* Sidebar Toggle Button */
        #sidebarCollapse {
            background: #2c3e50;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        #sidebarCollapse:hover {
            background: #34495e;
        }

        /* Responsive Header for Mobile */
        .navbar-light {
            background-color: #ffffff;
            border-bottom: 1px solid #ddd;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <div class="wrapper d-flex">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h5>{{ config('app.name', 'Aplikasi Inventory') }}</h5>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('barang.index') }}" class="{{ request()->routeIs('barang.*') ? 'active' : '' }}">
                        <i class="fas fa-box"></i> Barang
                    </a>
                </li>
                <li>
                    <a href="{{ route('transaksi.index') }}" class="{{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart"></i> Transaksi
                    </a>
                </li>
                <li>
                    <a href="{{ route('pembeli.index') }}" class="{{ request()->routeIs('pembeli.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Pembeli
                    </a>
                </li>
                <li>
                    <a href="{{ route('supplier.index') }}" class="{{ request()->routeIs('supplier.*') ? 'active' : '' }}">
                        <i class="fas fa-truck"></i> Supplier
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Toggle Button for Mobile -->
            <nav class="navbar navbar-expand-lg navbar-light d-lg-none">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-dark">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </nav>

            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Sidebar Toggle Script -->
    <script>
        document.getElementById('sidebarCollapse').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
    
    @yield('scripts')
    @stack('scripts')
</body>
</html>
