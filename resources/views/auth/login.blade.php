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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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

        /* Main Container */
        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Login Box */
        .login-box {
            background-color: rgba(255, 255, 255, 0.95);
            width: 100%;
            max-width: 380px;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-size: 1.5rem;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-size: 0.95rem;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1.5px solid #ddd;
            font-size: 1rem;
            transition: all 0.3s;
            font-family: "Poppins", sans-serif;
            caret-color: #e74c3c;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #e74c3c;
            box-shadow: 0 0 8px rgba(231, 76, 60, 0.2);
            background-color: #fafafa;
        }

        /* Role Selection */
        .role-group {
            margin-top: 20px;
        }

        .roles {
            display: flex;
            gap: 25px;
            margin-top: 12px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .role-option {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .role-option input[type="radio"] {
            width: 18px;
            height: 18px;
            accent-color: #e74c3c;
            cursor: pointer;
        }

        .role-option label {
            margin: 0;
            margin-bottom: 0;
            font-weight: 500;
            cursor: pointer;
            color: #555;
        }

        /* Submit Button */
        button {
            margin-top: 25px;
            width: 100%;
            padding: 12px;
            border: none;
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            color: white;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
        }

        button:hover {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 58, 138, 0.4);
        }

        button:active {
            transform: translateY(0);
        }

        /* Error Messages */
        .alert {
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            border-left: 4px solid;
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
        }

        /* Footer Text */
        .login-footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 0.9rem;
        }

        .login-footer a {
            color: #1e3a8a;
            text-decoration: none;
            font-weight: 600;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 480px) {
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

            .roles {
                flex-direction: column;
                gap: 12px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <span style="font-size: 2rem;">🌈</span>
        Welcome To Rainbow Direct Selling INVENTORY SYSTEM
    </header>

    <!-- Login Container -->
    <div class="login-container">
        <div class="login-box">
            <h2>Sign In</h2>

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

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
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

                <!-- Role Selection -->
                <div class="form-group role-group">
                    <label>Role:</label>
                    <div class="roles">
                        <div class="role-option">
                            <input 
                                type="radio" 
                                id="admin" 
                                name="role" 
                                value="admin" 
                                required
                                {{ old('role') === 'admin' ? 'checked' : '' }}
                            >
                            <label for="admin">Admin</label>
                        </div>
                        <div class="role-option">
                            <input 
                                type="radio" 
                                id="staff" 
                                name="role" 
                                value="staff"
                                {{ old('role') === 'staff' ? 'checked' : '' }}
                            >
                            <label for="staff">Staff</label>
                        </div>
                    </div>
                    @error('role')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit">Sign In</button>
            </form>

            <!-- Footer Text -->
            <div class="login-footer">
                Demo credentials:<br>
                Admin: admin@rainbow.com / password<br>
                Staff: staff@rainbow.com / password
            </div>
        </div>
    </div>
</body>
</html>
