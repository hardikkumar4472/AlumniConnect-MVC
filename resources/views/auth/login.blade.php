<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | GEC Alumni</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=4">
</head>
<body style="margin:0;">
    <div class="auth-page">
        <div class="auth-side-panel">
            <div class="auth-side-content">
                <div class="auth-brand">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                    <h1>GEC ALUMNI</h1>
                    <p style="color: var(--accent); font-weight: 600; letter-spacing: 1px;">ASSOCIATION PLATFORM</p>
                </div>
                
                <div style="margin-top: 4rem;">
                    <h3 style="font-size: 1.5rem; margin-bottom: 1rem;">Reconnect with Excellence</h3>
                    <p style="opacity: 0.8; line-height: 1.6;">Access your personalized portal to connect with mentors, explore opportunities, and contribute to the GEC legacy.</p>
                </div>
            </div>
        </div>

        <div class="auth-form-panel">
            <div style="max-width: 400px; width: 100%; margin: 0 auto;">
                <h2 style="font-size: 2.2rem; margin-bottom: 0.5rem; color: #061a3d;">Welcome Back</h2>
                <p style="color: #718096; margin-bottom: 3rem;">Please enter your details to sign in.</p>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    @if (session('message'))
                        <div style="background-color: #eff6ff; border: 1px solid #bfdbfe; color: #1e3a8a; padding: 12px; border-radius: 8px; margin-bottom: 15px; font-size: 0.85rem; display: flex; align-items: center; gap: 8px; font-family: 'Outfit', sans-serif;">
                            <i class="fa-solid fa-circle-info" style="color: #3b82f6;"></i>
                            <span>{{ session('message') }}</span>
                        </div>
                    @endif
                    
                    @if ($errors->any())
                        <div style="background-color: #fee2e2; border: 1px solid #f87171; color: #b91c1c; padding: 10px; border-radius: 8px; margin-bottom: 15px;">
                            <ul style="margin: 0; padding-left: 20px;">
                                @foreach ($errors->all() as $error)
                                    <li style="font-size: 0.85rem;">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group" style="position: relative; margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 8px; color: #4a5568;">Email Address</label>
                        <i class="fa-solid fa-envelope" style="position: absolute; left: 1.2rem; top: 2.8rem; color: #a0aec0;"></i>
                        <input type="email" name="email" placeholder="name@example.com" required style="width: 100%; padding: 1rem 1rem 1rem 3.5rem; border-radius: 12px; border: 1px solid #e2e8f0; outline: none;">
                    </div>

                    <div class="form-group" style="position: relative; margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 8px; color: #4a5568;">Password</label>
                        <i class="fa-solid fa-lock" style="position: absolute; left: 1.2rem; top: 2.8rem; color: #a0aec0;"></i>
                        <input type="password" name="password" placeholder="••••••••" required style="width: 100%; padding: 1rem 1rem 1rem 3.5rem; border-radius: 12px; border: 1px solid #e2e8f0; outline: none;">
                    </div>

                    <div style="text-align: right; margin-bottom: 2rem;">
                        <a href="#" style="color: #0047ab; font-size: 0.85rem; font-weight: 700; text-decoration: none;">Forgot Password?</a>
                    </div>

                    <button type="submit" class="auth-btn">Sign In &nbsp; <i class="fa-solid fa-arrow-right"></i></button>
                </form>

                <p style="text-align: center; margin-top: 3rem; color: #718096; font-size: 0.9rem;">
                    Don't have an account? <a href="{{ url('/signup') }}" style="color: #0047ab; font-weight: 700; text-decoration: none;">Register Now</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
