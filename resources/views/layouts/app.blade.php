<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Rainbow Direct Selling - Inventory System')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            color: #333;
        }

        /* Rainbow Header */
        header {
            background: linear-gradient(to right, red, orange, yellow, green, blue, indigo, violet);
            color: white;
            padding: 15px 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
            flex: 1;
        }

        header h1 {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        header a, header button {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.3s;
        }

        header a:hover, header button:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Main Layout */
        .layout-container {
            display: flex;
            min-height: calc(100vh - 60px);
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: white;
            border-right: 1px solid #e0e0e0;
            padding: 20px 0;
            box-shadow: 2px 0 4px rgba(0, 0, 0, 0.05);
        }

        .nav-menu {
            list-style: none;
        }

        .nav-menu li {
            margin: 0;
        }

        .nav-menu a {
            display: block;
            padding: 12px 20px;
            color: #333;
            text-decoration: none;
            font-weight: 500;
            border-left: 4px solid transparent;
            transition: all 0.3s;
        }

        .nav-menu a:hover, .nav-menu a.active {
            background: #f0f0f0;
            border-left-color: #ff7f00;
            color: #ff7f00;
        }

        .nav-divider {
            padding: 15px 20px 10px;
            font-size: 0.75rem;
            font-weight: 700;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Main Content */
        main {
            flex: 1;
            padding: 30px 40px;
            overflow-y: auto;
            background: linear-gradient(135deg, #f5f5f5 0%, #fafafa 100%);
        }

        /* Content Container */
        .content-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #333;
            padding-bottom: 15px;
            border-bottom: 2px solid #ff7f00;
        }

        .page-subtitle {
            font-size: 0.95rem;
            color: #666;
            margin-bottom: 30px;
        }

        /* Cards */
        .card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: #333;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #e0e0e0;
        }

        table td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        table tr:hover {
            background: #f9f9f9;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .badge-success {
            background: #2ecc71;
            color: white;
        }

        .badge-warning {
            background: #f39c12;
            color: white;
        }

        .badge-danger {
            background: #e74c3c;
            color: white;
        }

        .badge-info {
            background: #3498db;
            color: white;
        }

        /* Forms */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            transition: border 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #ff7f00;
            box-shadow: 0 0 0 3px rgba(255, 127, 0, 0.1);
        }

        /* Buttons */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background: #2980b9;
        }

        .btn-success {
            background: #2ecc71;
            color: white;
        }

        .btn-success:hover {
            background: #27ae60;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .btn-secondary {
            background: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
        }

        /* Alerts */
        .alert {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        /* Stat Boxes */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border-top: 4px solid;
            text-align: center;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #666;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
                padding: 10px 0;
            }

            .nav-menu a {
                padding: 10px 15px;
                font-size: 0.9rem;
            }

            main {
                padding: 20px;
            }

            header {
                flex-direction: column;
                gap: 10px;
            }

            .header-left, .header-right {
                width: 100%;
                justify-content: space-between;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-left">
            <img src="{{ asset('img/rainbow.png') }}" alt="Rainbow Direct Selling" style="height: 40px; width: auto;">
        </div>
        <nav class="header-nav">
            <ul class="nav-menu" style="display: flex; gap: 20px; list-style: none; margin: 0; padding: 0;">
                <li><a href="{{ route('dashboard') }}" class="@if(request()->routeIs('dashboard')) active @endif" style="text-decoration: none; color: black; font-weight: 600;">📊 Dashboard</a></li>
                <li><a href="{{ route('products.index') }}" class="@if(request()->routeIs('products.*')) active @endif" style="text-decoration: none; color: black; font-weight: 600;">📦 Products Listing</a></li>
                <li><a href="{{ route('daily_sales_report') }}" class="@if(request()->routeIs('daily_sales_report')) active @endif" style="text-decoration: none; color: black; font-weight: 600;">📅 Daily Sales Report</a></li>

                @auth
                    @if(Auth::user()->role === 'admin')
                        <li><a href="{{ route('categories.index') }}" class="@if(request()->routeIs('categories.*')) active @endif" style="text-decoration: none; color: black; font-weight: 600;">🏷️ Categories</a></li>
                        <li><a href="{{ route('activity-logs.index') }}" class="@if(request()->routeIs('activity-logs.*')) active @endif" style="text-decoration: none; color: black; font-weight: 600;">📋 Activity Logs</a></li>
                    @endif
                @endauth

                <li><a href="{{ route('settings') }}" class="@if(request()->routeIs('settings')) active @endif" style="text-decoration: none; color: black; font-weight: 600;">⚙️ Settings</a></li>
            </ul>
        </nav>
        <div class="header-right">
           
        </div>
    </header>

    <!-- Main Layout -->
    <div class="layout-container">
        <!-- Main Content -->
        <main>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
