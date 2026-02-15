<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rainbow Direct Selling - Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-image: url('{{ asset("img/rainbow.png") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow-x: hidden;
        }

        /* Rainbow arc logo background pattern */
        body::before {
            content: '';
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 150vmax;
            height: 150vmax;
            background-image: url('{{ asset("img/rainbow.png") }}');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            pointer-events: none;
            z-index: 1;
            opacity: 0.15;
        }

        header {
            position: relative;
            z-index: 20;
        }

        .login-container {
            position: relative;
            z-index: 20;
        }

        /* Rainbow Header */
        header {
            background: linear-gradient(to right, red, orange, yellow, green, blue, indigo, violet);
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 1.3rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        header img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 15px;
        }

        /* ===== MAIN CONTAINER ===== */
        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            gap: 20px;
        }

        /* ===== LOGIN BOX ===== */
        .login-box {
            background-color: rgba(255, 255, 255, 0.95);
            width: 100%;
            max-width: 400px;
            padding: 40px 35px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== FORM ELEMENTS ===== */
        .form-group {
            margin-bottom: 18px;
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
        }

        input[type="email"],
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1.5px solid #ddd;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: "Poppins", sans-serif;
            caret-color: #e74c3c;
            box-sizing: border-box;
            background-color: #fafafa;
        }

        input[type="email"]:focus,
        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #e74c3c;
            box-shadow: 0 0 8px rgba(231, 76, 60, 0.2);
            background-color: #ffffff;
        }

        /* ===== ROLE SELECTION ===== */
        .role-group {
            margin-top: 25px;
            margin-bottom: 25px;
        }

        .role-group > label {
            margin-bottom: 12px;
        }

        .roles {
            display: flex;
            gap: 25px;
            padding: 15px;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border-radius: 8px;
            border: 1px solid #e8e8e8;
        }

        .role-option {
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 1;
        }

        .role-option input[type="radio"] {
            width: 18px;
            height: 18px;
            accent-color: #e74c3c;
            cursor: pointer;
            flex-shrink: 0;
        }

        .role-option label {
            margin: 0;
            font-weight: 500;
            cursor: pointer;
            color: #555;
            font-size: 0.95rem;
        }

        /* ===== SUBMIT BUTTON ===== */
        button[type="submit"] {
            margin-top: 25px;
            width: 100%;
            padding: 12px 16px;
            border: none;
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            color: white;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
            letter-spacing: 0.3px;
        }

        button[type="submit"]:hover {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 58, 138, 0.4);
        }

        button[type="submit"]:active {
            transform: translateY(0);
        }

        /* ===== ALERTS & ERRORS ===== */
        .alert {
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            border-left: 4px solid;
            font-size: 0.95rem;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-left-color: #f5c6cb;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left-color: #c3e6cb;
        }

        /* Validation Errors */
        .form-group .error {
            color: #e74c3c;
            font-size: 0.85rem;
            margin-top: 5px;
            display: block;
            font-weight: 500;
        }

        /* Footer Text */
        .login-footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .login-footer a {
            color: #1e3a8a;
            text-decoration: none;
            font-weight: 600;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        /* Toggle Styles */
        .form-toggle {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
        }

        .form-toggle button {
            background: none;
            border: none;
            color: #1e3a8a;
            font-weight: 600;
            cursor: pointer;
            margin: 0 10px;
            padding: 5px 10px;
            font-size: 0.95rem;
            transition: all 0.3s;
            position: relative;
        }

        .form-toggle button.active {
            color: #2563eb;
        }

        .form-toggle button.active::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        }

        .form-toggle button:hover {
            color: #2563eb;
        }

        /* Form Visibility */
        .form-content {
            display: none;
        }

        .form-content.active {
            display: block;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .form-toggle button {
                font-size: 0.85rem;
                margin: 0 5px;
            }
        }
            .login-box {
                padding: 30px 20px;
            }

            .login-box h2 {
                font-size: 1.3rem;
            }

            header {
                font-size: 1.1rem;
                padding: 15px;
            }

            header img {
                width: 50px;
                height: 50px;
            }

            
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header style="background: linear-gradient(90deg, #ff0000, #ff7f00, #ffff00, #00ff00, #0000ff, #4b0082, #9400d3); padding: 20px; text-align: center; color: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div style="margin-bottom: 10px;">
            <img src="{{ asset('img/rainbow.png') }}" alt="Rainbow Direct Selling" style="height: 40px; width: auto;">
        </div>
        <h1 style="margin: 0; font-size: 28px; font-weight: 700; letter-spacing: 1px;">Welcome To Rainbow</h1>
        <p style="margin: 5px 0 0 0; font-size: 14px; font-weight: 300; letter-spacing: 0.5px;">DIRECT SELLING INVENTORY SYSTEM</p>
    </header>

    <!-- Login Container -->
    <div class="login-container">
        <div class="login-box">
            <!-- Form Toggle -->
            <div class="form-toggle">
                <button type="button" class="toggle-btn active" data-form="login">Sign In</button>
                <button type="button" class="toggle-btn" data-form="register">Register</button>
            </div>

            <!-- Display Session Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Display Success Message -->
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <!-- LOGIN FORM -->
            <div class="form-content active" id="login-form">
                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf

                    <!-- Email Input -->
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            required 
                            autofocus
                            placeholder="Enter your email"
                        >
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            placeholder="Enter your password"
                        >
                        @error('password')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit">Sign In</button>
                </form>
            </div>

            <!-- REGISTER FORM -->
            <div class="form-content" id="register-form">
                <form method="POST" action="{{ route('register.submit') }}">
                    @csrf

                    <!-- Name Input -->
                    <div class="form-group">
                        <label for="name">Full Name:</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}"
                            required
                            placeholder="Enter your full name"
                        >
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email Input -->
                    <div class="form-group">
                        <label for="register-email">Email:</label>
                        <input 
                            type="email" 
                            id="register-email" 
                            name="email" 
                            value="{{ old('email') }}"
                            required
                            placeholder="Enter your email"
                        >
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="form-group">
                        <label for="register-password">Password:</label>
                        <input 
                            type="password" 
                            id="register-password" 
                            name="password" 
                            required
                            placeholder="Enter your password"
                        >
                        @error('password')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm Password Input -->
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password:</label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            required
                            placeholder="Confirm your password"
                        >
                    </div>

                    <!-- Submit Button -->
                    <button type="submit">Create Account</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Form toggle functionality
        document.querySelectorAll('.toggle-btn').forEach(button => {
            button.addEventListener('click', function() {
                const formType = this.getAttribute('data-form');
                
                // Update active button
                document.querySelectorAll('.toggle-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');
                
                // Update visible form
                document.querySelectorAll('.form-content').forEach(form => {
                    form.classList.remove('active');
                });
                document.getElementById(formType + '-form').classList.add('active');
            });
        });
    </script>
</body>
</html>
