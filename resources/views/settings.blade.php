@extends('layouts.app')

@section('title', 'Settings - Rainbow Direct Selling')

@section('content')
<div class="settings-container">
    <main class="container" role="main" aria-label="Application Settings">
        <h1>Application Setting</h1>
        <div class="cards">
            @auth
                @if(Auth::user()->role === 'admin')
                    <div tabindex="0" role="button" class="card stock-alerts" aria-label="Stock Alerts"
                         onclick="window.location.href='{{ route('stock_alert') }}';" 
                         onkeypress="if(event.key==='Enter' || event.key===' ') window.location.href='{{ route('stock_alert') }}';" 
                         style="cursor:pointer;">
                        <h2>Stock Alerts</h2>
                        <p>Configure minimum stock level notification</p>
                    </div>
                    <div tabindex="0" role="button" class="card user-activity-log" aria-label="User Activity Log"
                         onclick="window.location.href='{{ route('activity-logs.index') }}';" 
                         onkeypress="if(event.key==='Enter' || event.key===' ') window.location.href='{{ route('activity-logs.index') }}';" 
                         style="cursor:pointer;">
                        <h2>User Activity Log</h2>
                        <p>See the History of User Activity and Log</p>
                    </div>
                    <div tabindex="0" role="button" class="card data-backup" aria-label="Data Backup"
                         onclick="alert('Data backup feature coming soon!');" 
                         onkeypress="if(event.key==='Enter' || event.key===' ') alert('Data backup feature coming soon!');" 
                         style="cursor:pointer;">
                        <h2>Data Backup</h2>
                        <p>Manage export and import of inventory data</p>
                    </div>
                    <div tabindex="0" role="button" class="card add-category" aria-label="Add Category"
                         onclick="window.location.href='{{ route('add_category') }}';" 
                         onkeypress="if(event.key==='Enter' || event.key===' ') window.location.href='{{ route('add_category') }}';" 
                         style="cursor:pointer;">
                        <h2>Add Category</h2>
                        <p>Add/Manage category</p>
                    </div>
                @else
                    <div class="card" style="background: linear-gradient(135deg, #e8e8e888, #f0f0f088); color: #666; cursor: default;">
                        <h2>Limited Access</h2>
                        <p>Settings available for admin users only</p>
                    </div>
                @endif
            @endauth
        </div>

        <section class="user-info" aria-label="User Information">
            <div>
                @auth
                    <p>Your current User EMAIL: <span class="email" id="userEmail">{{ Auth::user()->email }}</span></p>
                    <p>Your Assigned Role: <span class="role" id="userRole">{{ ucfirst(Auth::user()->role) }}</span></p>
                    <p>Authentication Status: <span class="auth" id="userAuth">Authenticated</span></p>
                @else
                    <p>Your current User EMAIL: <span class="email" id="userEmail">Guest</span></p>
                    <p>Your Assigned Role: <span class="role" id="userRole">None</span></p>
                    <p>Authentication Status: <span class="auth" style="color: #e74c3c;">Not Authenticated</span></p>
                @endauth
            </div>
            @auth
                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                    @csrf
                    <button type="submit" class="sign-out-btn" aria-label="Sign Out">Sign Out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="sign-out-btn" style="text-decoration: none; display: inline-block; line-height: 1;">Sign In</a>
            @endauth
        </section>
    </main>
</div>

<style>
    body {
        background: url('{{ asset("img/rainbow.png") }}') no-repeat center;
        background-size: cover;
        background-attachment: fixed;
    }

    .settings-container {
        min-height: calc(100vh - 60px);
        padding: 0;
    }

    main.container {
        max-width: 900px;
        margin: 40px auto 60px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 25px;
        padding: 30px 40px 40px;
        box-shadow:
            0 0 20px rgba(255,0,0,0.1),
            0 0 40px rgba(255,127,0,0.1),
            0 0 60px rgba(255,255,0,0.15),
            0 0 80px rgba(0,255,0,0.1),
            0 0 100px rgba(0,0,255,0.1),
            0 0 120px rgba(75,0,130,0.1),
            0 0 140px rgba(139,0,255,0.1);
        user-select: none;
        box-sizing: border-box;
    }

    h1 {
        font-weight: 700;
        margin-bottom: 30px;
        border-bottom: 1.5px solid #444;
        padding-bottom: 8px;
        color: #111;
    }

    .cards {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px 24px;
        margin-bottom: 40px;
    }

    @media (max-width: 960px) {
        .cards {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 520px) {
        .cards {
            grid-template-columns: 1fr;
        }
    }

    .card {
        border-radius: 20px;
        padding: 25px 24px 18px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 8px 14px rgba(0, 0, 0, 0.05);
        user-select: none;
        color: black;
        background: linear-gradient(135deg, rgba(255,255,255,0.7), rgba(255,255,255,0.3));
        backdrop-filter: blur(6px);
        transition: box-shadow 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .card h2 {
        font-size: 1.2rem;
        margin-bottom: 8px;
    }

    .stock-alerts {
        background: linear-gradient(135deg, #f9bea899, #fae2b188);
        color: #755020;
    }

    .stock-alerts p {
        font-weight: 500;
        margin-top: 10px;
    }

    .user-activity-log {
        background: linear-gradient(135deg, #b6e19b88, #ddf7cc88);
        color: #4b6c22;
    }

    .user-activity-log p {
        font-weight: 500;
        margin-top: 10px;
    }

    .data-backup {
        background: linear-gradient(135deg, #c5b3f988, #d9d0fb88);
        color: #5741a1;
    }

    .data-backup p {
        font-weight: 500;
        margin-top: 10px;
    }

    .add-category {
        background: linear-gradient(135deg, #f9d1a988, #fde0b988);
        color: #7e5620;
    }

    .card p {
        margin-top: 10px;
        font-weight: 500;
    }

    .user-info {
        border-top: 1.5px solid #666;
        padding: 22px 30px;
        font-weight: 600;
        color: #222;
        user-select: text;
        background: rgba(179, 238, 252, 0.5);
        border-radius: 15px;
        box-sizing: border-box;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .user-info div {
        max-width: 65%;
    }

    .user-info p {
        margin: 6px 0;
        font-size: 1rem;
    }

    .user-info span.email {
        font-weight: 700;
        user-select: all;
    }

    .user-info span.role {
        font-weight: 700;
        color: #c0392b;
    }

    .user-info span.auth {
        font-weight: 700;
        color: #27ae60;
    }

    .sign-out-btn {
        background-color: #7fdd28;
        border: none;
        padding: 16px 36px;
        font-size: 1.1rem;
        font-weight: 700;
        color: white;
        border-radius: 30px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        white-space: nowrap;
        user-select: none;
    }

    .sign-out-btn:hover {
        background-color: #62ab1b;
    }

    @media (max-width: 768px) {
        main.container {
            margin: 20px auto 40px;
            padding: 20px 25px 30px;
        }

        .user-info {
            flex-direction: column;
            align-items: flex-start;
        }

        .user-info div {
            max-width: 100%;
        }

        .sign-out-btn {
            width: 100%;
        }
    }
</style>

<script>
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('keydown', e => {
            if(e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                card.click();
            }
        });
    });
</script>
@endsection
