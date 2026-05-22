<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | GEC Alumni</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=4">
    <style>
        .role-selector { display: flex; gap: 15px; margin-bottom: 2rem; }
        .role-option { flex: 1; position: relative; }
        .role-option input { position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0; }
        .role-card { 
            padding: 1rem; border: 1.5px solid #e2e8f0; border-radius: 12px; text-align: center; cursor: pointer; transition: all 0.2s; 
            display: flex; flex-direction: column; align-items: center; gap: 8px;
        }
        .role-card i { font-size: 1.2rem; color: #a0aec0; }
        .role-card span { font-size: 0.85rem; font-weight: 600; color: #4a5568; }
        .role-option input:checked ~ .role-card { border-color: #0047ab; background: rgba(0, 71, 171, 0.04); }
        .role-option input:checked ~ .role-card i { color: #0047ab; }
        .role-option input:checked ~ .role-card span { color: #0047ab; }
    </style>
</head>
<body style="margin:0;">
    <div class="auth-page">
        <!-- Split Panel Layout -->
        <div class="auth-side-panel">
            <div class="auth-side-content">
                <div class="auth-brand" style="margin-bottom: 3rem;">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                    <div style="line-height: 1.1;">
                        <h1 style="color: white; font-size: 1.1rem; margin: 0;">GEC ALUMNI</h1>
                        <p style="font-size: 0.6rem; color: var(--accent); margin: 0; letter-spacing: 1px;">ASSOCIATION PLATFORM</p>
                    </div>
                </div>

                <div class="benefit-item">
                    <div class="benefit-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                    <div>
                        <h4 style="margin:0;">Lifelong Network</h4>
                        <p style="font-size:0.8rem; opacity:0.7; margin:5px 0 0;">Stay connected with your peers forever.</p>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon"><i class="fa-solid fa-briefcase"></i></div>
                    <div>
                        <h4 style="margin:0;">Career Growth</h4>
                        <p style="font-size:0.8rem; opacity:0.7; margin:5px 0 0;">Access exclusive job portals and mentorship.</p>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon"><i class="fa-solid fa-heart"></i></div>
                    <div>
                        <h4 style="margin:0;">Give Back</h4>
                        <p style="font-size:0.8rem; opacity:0.7; margin:5px 0 0;">Contribute to your alma mater's future.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="auth-form-panel">
            <div style="max-width: 480px; width: 100%; margin: 0 auto;">
                <h2 style="font-size: 2rem; margin-bottom: 0.5rem;">Join the Community</h2>
                <p style="color: #718096; margin-bottom: 2.5rem;">Create your account to start connecting.</p>

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    
                    @if ($errors->any())
                        <div style="background-color: #fee2e2; border: 1px solid #f87171; color: #b91c1c; padding: 10px; border-radius: 8px; margin-bottom: 15px;">
                            <ul style="margin: 0; padding-left: 20px;">
                                @foreach ($errors->all() as $error)
                                    <li style="font-size: 0.85rem;">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <p style="font-size: 0.85rem; font-weight: 600; margin-bottom: 10px; color: #4a5568;">Select your role:</p>
                    <div class="role-selector">
                        <label class="role-option">
                            <input type="radio" name="role" value="alumni" checked>
                            <div class="role-card">
                                <i class="fa-solid fa-user-graduate"></i>
                                <span>Alumni</span>
                            </div>
                        </label>
                        <label class="role-option">
                            <input type="radio" name="role" value="student">
                            <div class="role-card">
                                <i class="fa-solid fa-user-clock"></i>
                                <span>Student</span>
                            </div>
                        </label>
                    </div>

                    <div class="form-group">
                        <label>Full Name</label>
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="name" placeholder="John Doe" required>
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="email" placeholder="john@example.com" required>
                    </div>

                    <div style="display: flex; gap: 15px;">
                        <div class="form-group" style="flex: 1;">
                            <label>Graduation/Passing Year</label>
                            <i class="fa-solid fa-calendar"></i>
                            <input type="number" name="graduation_year" placeholder="2024" required>
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label>Department</label>
                            <i class="fa-solid fa-microchip"></i>
                            <select name="department" style="width: 100%; padding: 0.8rem 1rem 0.8rem 3rem; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; appearance: none; background: white;">
                                <option value="Computer Science">Computer Science</option>
                                <option value="Information Technology">Information Technology</option>
                                <option value="Mechanical">Mechanical</option>
                                <option value="Electrical">Electrical</option>
                                <option value="Civil">Civil</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="auth-btn">Create Account</button>
                </form>

                <p style="text-align: center; margin-top: 2rem; color: #718096; font-size: 0.9rem;">
                    Already have an account? <a href="{{ url('/login') }}" style="color: #0047ab; font-weight: 700; text-decoration: none;">Login here</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
