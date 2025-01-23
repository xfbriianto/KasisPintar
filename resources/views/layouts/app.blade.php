<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Aplikasi Inventory') }}</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 5 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #6200ea;
            --secondary-color: #03dac6;
            --background-color: #f4f6f9;
            --sidebar-bg: #2c3e50;
            --sidebar-text: #bdc3c7;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--background-color);
            overflow-x: hidden;
        }

        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }

        /* Sidebar */
        #sidebar {
            min-width: 270px;
            max-width: 270px;
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
            transition: all 0.3s ease;
            position: fixed;
            height: 100vh;
            z-index: 1000;
            top: 0;
            left: 0;
            overflow-y: auto;
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background: #1a252f;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        #sidebar .sidebar-header h5 {
            color: white;
            margin-bottom: 0;
        }

        #sidebar ul.components {
            padding: 20px 0;
        }

        #sidebar ul li a {
            padding: 15px 20px;
            display: block;
            color: var(--sidebar-text);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        #sidebar ul li a:hover {
            color: white;
            background: rgba(255,255,255,0.1);
        }

        #sidebar ul li a.active {
            color: white;
            background: var(--primary-color);
        }

        #sidebar ul li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Content Area */
        #content {
            width: calc(100% - 270px);
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s ease;
            margin-left: 270px;
            background: var(--background-color);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -270px;
            }
            #content {
                width: 100%;
                margin-left: 0;
            }
            #sidebar.active {
                margin-left: 0;
            }
        }

        /* Profile Section */
        .profile-section {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .profile-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        /* Scrollbar */
        #sidebar::-webkit-scrollbar {
            width: 5px;
        }

        #sidebar::-webkit-scrollbar-track {
            background: #1a252f;
        }

        #sidebar::-webkit-scrollbar-thumb {
            background: var(--primary-color);
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <div class="wrapper">
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
                <li>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Mobile Sidebar Toggle -->
            <nav class="navbar navbar-expand-lg navbar-light d-lg-none mb-3">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-outline-dark">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </nav>

            <main>
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5 .3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery 3.6 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
    
    @yield('scripts')
    @stack('scripts')
</body>
</html>