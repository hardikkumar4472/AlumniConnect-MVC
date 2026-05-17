<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GEC Alumni Association | Connect • Contribute • Grow</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=4">
    <style>
        .landing-nav { position: fixed !important; background: white !important; z-index: 1000 !important; border-bottom: 1px solid #f1f5f9; width: 100%; top: 0; }
        .hero-btn { border-radius: 8px !important; }
        .feature-card h3 { font-size: 1.1rem; margin-bottom: 0.5rem; }
        .feature-card p { font-size: 0.85rem; color: #718096; line-height: 1.5; }
    </style>
</head>
<body class="landing-page" style="background: white;">
    <nav class="landing-nav">
        <div class="auth-brand" style="margin-bottom: 0; display: flex; align-items: center; gap: 10px;">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 35px; margin-bottom: 0;">
            <div style="line-height: 1;">
                <h1 style="color: #061a3d; font-size: 1rem; margin: 0;">GEC ALUMNI</h1>
                <p style="font-size: 0.5rem; color: #718096; margin: 0; letter-spacing: 1px;">ASSOCIATION PLATFORM</p>
            </div>
        </div>
        <ul class="landing-nav-links">
            <li><a href="#" class="active">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Features</a></li>
            <li><a href="#">Impact</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
        <div style="display: flex; gap: 12px;">
            <a href="{{ url('/login') }}" style="padding: 0.6rem 1.5rem; border: 1.5px solid #0047ab; border-radius: 8px; color: #0047ab; text-decoration: none; font-weight: 600; font-size: 0.85rem;">Login</a>
            <a href="{{ url('/signup') }}" style="padding: 0.6rem 1.5rem; background: #0047ab; border-radius: 8px; color: white; text-decoration: none; font-weight: 600; font-size: 0.85rem;">Register</a>
        </div>
    </nav>

    <header class="landing-hero" style="background: linear-gradient(rgba(6, 26, 61, 0.85), rgba(6, 26, 61, 0.85)), url('{{ asset('images/campus.png') }}'); background-size: cover; background-position: center; padding: 160px 10% 100px;">
        <div style="display: flex; gap: 50px; align-items: center;">
            <div class="landing-hero-content" style="flex: 1.2;">
                <h1 style="font-size: 3.5rem; color: white; margin-bottom: 1.5rem; line-height: 1.2;">Stay Connected.<br>Give Back.<br><span style="color: #ffd700;">Create Impact.</span></h1>
                <p style="color: #cbd5e0; line-height: 1.7; margin-bottom: 2.5rem; font-size: 1.1rem;">The GEC Alumni Association Platform connects thousands of graduates, empowers careers, and drives the legacy of our alma mater.</p>
                
                <div style="display: flex; gap: 15px; margin-bottom: 4rem;">
                    <a href="{{ url('/signup') }}" class="hero-btn" style="background: #0047ab; padding: 1rem 2.5rem; font-size: 1rem;">Join the Community &nbsp; <i class="fa-solid fa-arrow-right"></i></a>
                    <a href="{{ url('/login') }}" style="padding: 1rem 2.5rem; border: 1.5px solid rgba(255,255,255,0.3); border-radius: 8px; color: white; text-decoration: none; font-weight: 600; background: rgba(255,255,255,0.05);">Portal Login</a>
                </div>

                <div class="hero-stats-row">
                    <div class="hero-stat-item">
                        <i class="fa-solid fa-users"></i>
                        <div>
                            <h4 style="color: white; font-size: 1.5rem; margin: 0;">{{ number_format($stats['alumni_count'] ?? 0) }}+</h4>
                            <p style="color: #a0aec0; margin: 0; font-size: 0.8rem;">Global Alumni</p>
                        </div>
                    </div>
                    <div class="hero-stat-item">
                        <i class="fa-solid fa-briefcase"></i>
                        <div>
                            <h4 style="color: white; font-size: 1.5rem; margin: 0;">{{ $stats['jobs_count'] ?? 0 }}+</h4>
                            <p style="color: #a0aec0; margin: 0; font-size: 0.8rem;">Career Openings</p>
                        </div>
                    </div>
                    <div class="hero-stat-item">
                        <i class="fa-solid fa-calendar-check"></i>
                        <div>
                            <h4 style="color: white; font-size: 1.5rem; margin: 0;">{{ $stats['events_count'] ?? 0 }}+</h4>
                            <p style="color: #a0aec0; margin: 0; font-size: 0.8rem;">Active Events</p>
                        </div>
                    </div>
                    <div class="hero-stat-item">
                        <i class="fa-solid fa-heart"></i>
                        <div>
                            <h4 style="color: white; font-size: 1.5rem; margin: 0;">₹{{ number_format(($stats['donations_total'] ?? 0) / 10000000, 1) }} Cr+</h4>
                            <p style="color: #a0aec0; margin: 0; font-size: 0.8rem;">Impact Funds</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div style="flex: 0.8;">
                <div class="quote-card" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); padding: 3rem; border-radius: 24px; border: 1px solid rgba(255,255,255,0.1);">
                    <i class="fa-solid fa-quote-left" style="font-size: 2.5rem; color: #0047ab; margin-bottom: 2rem; display: block;"></i>
                    <p style="font-size: 1.3rem; line-height: 1.6; font-style: italic; margin-bottom: 2.5rem; color: white;">"Our graduates are our greatest legacy. This platform is the bridge that keeps that legacy alive and thriving across generations."</p>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <img src="{{ asset('images/logo.png') }}" style="width: 45px; filter: brightness(0) invert(1);">
                        <span style="font-weight: 700; color: white;">- GEC Alumni Council</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="section" style="padding: 100px 10%; text-align: center;">
        <p style="color: #0047ab; font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 2px; margin-bottom: 1rem;">Platform Features</p>
        <h2 style="font-size: 2.5rem; color: #061a3d; margin-bottom: 4rem;">Empowering Your Post-Grad Journey</h2>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon" style="background: #ebf8ff; color: #3182ce;"><i class="fa-solid fa-users"></i></div>
                <h3>Global Directory</h3>
                <p>Connect with peers across batches, departments, and industries globally.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background: #f0fff4; color: #38a169;"><i class="fa-solid fa-network-wired"></i></div>
                <h3>Mentorship Hub</h3>
                <p>Guide students or receive career advice from experienced industry veterans.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background: #fffaf0; color: #dd6b20;"><i class="fa-solid fa-briefcase"></i></div>
                <h3>Job Portal</h3>
                <p>Access exclusive job postings from within the alumni network.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background: #fff5f5; color: #e53e3e;"><i class="fa-solid fa-hand-holding-heart"></i></div>
                <h3>Giving Back</h3>
                <p>Support college infrastructure and scholarship funds with ease.</p>
            </div>
        </div>
    </section>

    @if($featured_story)
    <section class="section" style="background: #f8fafc; padding: 100px 10%;">
        <div style="display: flex; gap: 80px; align-items: center;">
            <div style="flex: 1;">
                <img src="{{ asset('images/' . ($featured_story->image ?? 'alumni1.png')) }}" style="width: 100%; border-radius: 24px; box-shadow: 0 30px 60px rgba(0,0,0,0.1);">
            </div>
            <div style="flex: 1.2;">
                <p style="color: #0047ab; font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 2px; margin-bottom: 1rem;">Success Story</p>
                <h2 style="font-size: 2.5rem; color: #061a3d; margin-bottom: 2rem;">Inspiration Across Batches</h2>
                <p style="font-size: 1.4rem; line-height: 1.6; font-style: italic; color: #4a5568; margin-bottom: 2.5rem;">"{{ $featured_story->story }}"</p>
                <div style="display: flex; align-items: center; gap: 20px;">
                    <div style="width: 60px; height: 60px; background: #0047ab; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <div>
                        <h4 style="font-size: 1.2rem; margin: 0;">{{ $featured_story->name }}</h4>
                        <p style="color: #718096; margin: 0;">{{ $featured_story->designation }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <section class="section" style="padding: 100px 10%;">
        <div style="text-align: center; margin-bottom: 5rem;">
            <p style="color: #0047ab; font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 2px; margin-bottom: 1rem;">Upcoming Reunions</p>
            <h2 style="font-size: 2.5rem; color: #061a3d;">Save the Dates</h2>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
            @forelse($upcoming_events as $event)
            <div class="card" style="padding: 2.5rem; border: 1px solid #f1f5f9; transition: all 0.3s ease;">
                <div style="width: 60px; height: 60px; background: #ebf8ff; color: #0047ab; border-radius: 15px; display: flex; flex-direction: column; align-items: center; justify-content: center; font-weight: 800; margin-bottom: 2rem;">
                    <span style="font-size: 0.7rem; opacity: 0.7;">{{ strtoupper($event->month) }}</span>
                    <span style="font-size: 1.2rem;">{{ $event->date }}</span>
                </div>
                <h4 style="font-size: 1.3rem; margin-bottom: 1rem; color: #061a3d;">{{ $event->title }}</h4>
                <p style="font-size: 0.9rem; color: #718096; margin-bottom: 2rem;"><i class="fa-solid fa-location-dot" style="color: #0047ab;"></i> {{ $event->location }}</p>
                <a href="{{ url('/login') }}" style="color: #0047ab; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 8px;">Register to Attend <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            @empty
            <p style="grid-column: 1 / -1; text-align: center; color: #a0aec0; padding: 4rem;">No upcoming reunions scheduled at the moment.</p>
            @endforelse
        </div>
    </section>

    <section class="section" style="padding: 0 10% 100px;">
        <div style="background: #061a3d; border-radius: 32px; padding: 6rem; text-align: center; color: white;">
            <h2 style="font-size: 3rem; margin-bottom: 1.5rem;">Join the GEC Legacy Today</h2>
            <p style="font-size: 1.2rem; opacity: 0.8; max-width: 700px; margin: 0 auto 3.5rem;">Reconnect with your roots and contribute to the future of engineering excellence.</p>
            <div style="display: flex; gap: 20px;">
                <a href="{{ url('/signup') }}" style="padding: 1.2rem 3rem; background: white; color: #553c9a; text-decoration: none; border-radius: 12px; font-weight: 700; font-size: 1.1rem; display: inline-flex; align-items: center; gap: 10px;">
                    Register Now <i class="fa-solid fa-arrow-right"></i>
                </a>
                <a href="{{ url('/login') }}" style="padding: 1.2rem 3rem; border: 1.5px solid rgba(255,255,255,0.4); color: white; text-decoration: none; border-radius: 12px; font-weight: 700; font-size: 1.1rem; background: rgba(255,255,255,0.1); display: inline-flex; align-items: center; gap: 10px;">
                    Portal Access <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </a>
            </div>
        </div>
    </section>

    <footer style="padding: 5rem 10% 3rem; background: #f8fafc; border-top: 1px solid #f1f5f9;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 4rem;">
            <div style="max-width: 350px;">
                <div class="auth-brand" style="margin-bottom: 2rem; display: flex; align-items: center; gap: 12px;">
                    <img src="{{ asset('images/logo.png') }}" style="width: 45px;">
                    <div style="line-height: 1.1;">
                        <h2 style="font-size: 1.2rem; color: #061a3d; margin: 0;">GEC ALUMNI</h2>
                        <p style="font-size: 0.7rem; color: #718096; margin: 0; letter-spacing: 1px;">ASSOCIATION PLATFORM</p>
                    </div>
                </div>
                <p style="color: #718096; line-height: 1.8; font-size: 0.95rem;">Uniting graduates, fostering meaningful connections, and empowering each other to build a better future together.</p>
            </div>
            <div>
                <h4 style="margin-bottom: 1.5rem; font-size: 1.1rem;">Platform</h4>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 1rem;">
                    <li><a href="#" style="color: #718096; text-decoration: none; font-size: 0.9rem;">Directory</a></li>
                    <li><a href="#" style="color: #718096; text-decoration: none; font-size: 0.9rem;">Jobs</a></li>
                    <li><a href="#" style="color: #718096; text-decoration: none; font-size: 0.9rem;">Donations</a></li>
                    <li><a href="#" style="color: #718096; text-decoration: none; font-size: 0.9rem;">Events</a></li>
                </ul>
            </div>
            <div>
                <h4 style="margin-bottom: 1.5rem; font-size: 1.1rem;">Support</h4>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 1rem;">
                    <li><a href="#" style="color: #718096; text-decoration: none; font-size: 0.9rem;">Help Center</a></li>
                    <li><a href="#" style="color: #718096; text-decoration: none; font-size: 0.9rem;">Privacy Policy</a></li>
                    <li><a href="#" style="color: #718096; text-decoration: none; font-size: 0.9rem;">Terms of Service</a></li>
                </ul>
            </div>
            <div>
                <h4 style="margin-bottom: 1.5rem; font-size: 1.1rem;">Connect</h4>
                <div style="display: flex; gap: 15px;">
                    <a href="#" style="width: 40px; height: 40px; border-radius: 50%; background: white; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; color: #061a3d;"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="#" style="width: 40px; height: 40px; border-radius: 50%; background: white; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; color: #061a3d;"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" style="width: 40px; height: 40px; border-radius: 50%; background: white; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; color: #061a3d;"><i class="fa-brands fa-facebook-f"></i></a>
                </div>
            </div>
        </div>
        <div style="border-top: 1px solid #e2e8f0; padding-top: 2rem; display: flex; justify-content: space-between; align-items: center;">
            <p style="color: #a0aec0; font-size: 0.85rem;">© {{ date('Y') }} GEC Alumni Association. All rights reserved.</p>
            <p style="color: #a0aec0; font-size: 0.85rem;">Designed with excellence for the GEC Community.</p>
        </div>
    </footer>
</body>
</html>
