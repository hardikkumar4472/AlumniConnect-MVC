<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GEC Alumni Association | Connect • Contribute • Grow</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=2">
    <style>
        .landing-nav { position: fixed !important; background: white !important; z-index: 1000 !important; border-bottom: 1px solid #f1f5f9; }
        .hero-btn { border-radius: 8px !important; }
        .feature-card h3 { font-size: 1.1rem; margin-bottom: 0.5rem; }
        .feature-card p { font-size: 0.85rem; color: #718096; line-height: 1.5; }
    </style>
</head>
<body class="landing-page" style="background: white;">
    <nav class="landing-nav">
        <div class="auth-brand" style="margin-bottom: 0;">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
            <div style="line-height: 1.1;">
                <h1 style="color: #061a3d; font-size: 1.1rem; margin: 0;">GEC ALUMNI</h1>
                <p style="font-size: 0.6rem; color: #718096; margin: 0; letter-spacing: 1px;">ASSOCIATION PLATFORM</p>
            </div>
        </div>
        <ul class="landing-nav-links">
            <li><a href="#" class="active">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Features</a></li>
            <li><a href="#">Benefits</a></li>
            <li><a href="#">Impact</a></li>
            <li><a href="#">FAQ</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
        <div style="display: flex; gap: 12px;">
            <a href="{{ url('/login') }}" style="padding: 0.6rem 1.8rem; border: 1.5px solid #0047ab; border-radius: 8px; color: #0047ab; text-decoration: none; font-weight: 600; font-size: 0.9rem;">Login</a>
            <a href="{{ url('/signup') }}" style="padding: 0.6rem 1.8rem; background: #0047ab; border-radius: 8px; color: white; text-decoration: none; font-weight: 600; font-size: 0.9rem;">Register</a>
        </div>
    </nav>

    <header class="landing-hero" style="background: linear-gradient(rgba(6, 26, 61, 0.8), rgba(6, 26, 61, 0.8)), url('{{ asset('images/campus.png') }}'); background-size: cover; background-position: center; padding: 160px 10% 100px;">
        <div style="display: flex; gap: 50px; align-items: center;">
            <div class="landing-hero-content" style="flex: 1.2;">
                <h1 style="font-size: 4rem; color: white; margin-bottom: 1.5rem;">Stay Connected.<br>Give Back.<br><span style="color: orange;">Create Impact.</span></h1>
                <p style="color: #cbd5e0; line-height: 1.7; margin-bottom: 2.5rem;">The GEC Alumni Association Platform connects graduates, empowers careers, and drives the growth of our alma mater.</p>
                <div style="display: flex; gap: 15px; margin-bottom: 4rem;">
                    <a href="{{ url('/signup') }}" class="hero-btn" style="background: #0047ab; padding: 1rem 2rem;">Register Now &nbsp; <i class="fa-solid fa-arrow-right"></i></a>
                    <a href="{{ url('/login') }}" style="padding: 1rem 2rem; border: 1.5px solid rgba(255,255,255,0.3); border-radius: 8px; color: white; text-decoration: none; font-weight: 600; background: rgba(255,255,255,0.05);">Login &nbsp; <i class="fa-solid fa-user"></i></a>
                </div>
                <div class="hero-stats-row">
                    <div class="hero-stat-item">
                        <i class="fa-solid fa-users"></i>
                        <div>
                            <h4 style="color: white;">12K+</h4>
                            <p style="color: #a0aec0;">Alumni Worldwide</p>
                        </div>
                    </div>
                    <div class="hero-stat-item">
                        <i class="fa-solid fa-globe"></i>
                        <div>
                            <h4 style="color: white;">32</h4>
                            <p style="color: #a0aec0;">Countries</p>
                        </div>
                    </div>
                    <div class="hero-stat-item">
                        <i class="fa-solid fa-calendar-check"></i>
                        <div>
                            <h4 style="color: white;">500+</h4>
                            <p style="color: #a0aec0;">Active Events</p>
                        </div>
                    </div>
                    <div class="hero-stat-item">
                        <i class="fa-solid fa-heart"></i>
                        <div>
                            <h4 style="color: white;">₹1.2 Cr+</h4>
                            <p style="color: #a0aec0;">Donations Raised</p>
                        </div>
                    </div>
                </div>
            </div>
            <div style="flex: 0.8;">
                <div class="quote-card">
                    <i class="fa-solid fa-quote-left" style="font-size: 2rem; color: #0047ab; margin-bottom: 1.5rem; display: block;"></i>
                    <p style="font-size: 1.2rem; line-height: 1.6; font-style: italic; margin-bottom: 2rem; color: #2d3748;">Uniting graduates, fostering meaningful connections, and empowering each other to build a better future together.</p>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <img src="{{ asset('images/logo.png') }}" style="width: 45px;">
                        <span style="font-weight: 700; color: #1a202c;">- GEC Alumni Association</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="section" style="padding: 100px 10%;">
        <div class="section-header" style="margin-bottom: 60px;">
            <p style="color: #0047ab; font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 2px; margin-bottom: 10px;">What we offer</p>
            <h2 style="font-size: 2.2rem; color: #061a3d;">Everything You Need, All in One Platform</h2>
            <div style="width: 60px; height: 3px; background: #0047ab; margin: 20px auto;"></div>
        </div>
        <div class="features-grid" style="gap: 1.5rem;">
            <div class="feature-card">
                <div class="feature-icon" style="background: #ebf8ff; color: #3182ce;"><i class="fa-solid fa-users"></i></div>
                <h3>Alumni Directory</h3>
                <p>Find and connect with alumni based on year, branch, location, industry and more.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background: #f0fff4; color: #38a169;"><i class="fa-solid fa-network-wired"></i></div>
                <h3>Networking Hub</h3>
                <p>Build meaningful professional relationships and grow your network.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background: #fffaf0; color: #dd6b20;"><i class="fa-solid fa-briefcase"></i></div>
                <h3>Job Portal</h3>
                <p>Discover job opportunities, post openings and advance your career.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background: #fff5f5; color: #e53e3e;"><i class="fa-solid fa-hand-holding-heart"></i></div>
                <h3>Donate & Contribute</h3>
                <p>Support initiatives and projects that shape the future of our college.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background: #faf5ff; color: #805ad5;"><i class="fa-solid fa-star"></i></div>
                <h3>Success Stories</h3>
                <p>Be inspired by achievements and share your journey with the community.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background: #ebf8ff; color: #2b6cb0;"><i class="fa-solid fa-calendar-days"></i></div>
                <h3>Events & Reunions</h3>
                <p>Stay updated on events, reunions, workshops and engage with alumni.</p>
            </div>
        </div>
    </section>

    <section class="section" style="background: white; padding: 100px 10%;">
        <div style="display: flex; gap: 80px; align-items: center;">
            <div style="flex: 1;">
                <p style="color: #0047ab; font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 2px; margin-bottom: 10px;">About Us</p>
                <h2 style="font-size: 2.5rem; color: #061a3d; margin-bottom: 2rem;">A Strong Community.<br>A Brighter Future.</h2>
                <p style="color: #718096; line-height: 1.8; margin-bottom: 2.5rem;">The GEC Alumni Association is a thriving community of graduates committed to the growth and excellence of our alma mater. Through collaboration, support and shared values, we continue to make a lasting impact.</p>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 1.2rem;">
                    <li style="display: flex; align-items: center; gap: 12px; color: #4a5568; font-size: 0.95rem;"><i class="fa-solid fa-check-circle" style="color: #0047ab;"></i> 12,000+ Alumni across 32 countries</li>
                    <li style="display: flex; align-items: center; gap: 12px; color: #4a5568; font-size: 0.95rem;"><i class="fa-solid fa-check-circle" style="color: #0047ab;"></i> Lifelong connections and mentorship</li>
                    <li style="display: flex; align-items: center; gap: 12px; color: #4a5568; font-size: 0.95rem;"><i class="fa-solid fa-check-circle" style="color: #0047ab;"></i> Empowering students and future generations</li>
                    <li style="display: flex; align-items: center; gap: 12px; color: #4a5568; font-size: 0.95rem;"><i class="fa-solid fa-check-circle" style="color: #0047ab;"></i> Building a legacy of excellence</li>
                </ul>
                <a href="{{ url('/signup') }}" class="hero-btn" style="margin-top: 3rem; background: #0047ab; padding: 1rem 2.5rem;">Learn More &nbsp; <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div style="flex: 1;">
                <div class="impact-stats-card">
                    <div>
                        <h3 style="font-size: 2.2rem; color: orange;">₹1.2 Cr+</h3>
                        <p style="color: #a0aec0; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Total Donations Raised</p>
                    </div>
                    <div>
                        <h3 style="font-size: 2.2rem; color: white;">500+</h3>
                        <p style="color: #a0aec0; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Scholarships Awarded</p>
                    </div>
                    <div>
                        <h3 style="font-size: 2.2rem; color: white;">100+</h3>
                        <p style="color: #a0aec0; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Projects Supported</p>
                    </div>
                    <div>
                        <h3 style="font-size: 2.2rem; color: white;">25+</h3>
                        <p style="color: #a0aec0; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Startups Mentored</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" style="padding: 100px 10%;">
        <div class="section-header" style="margin-bottom: 80px;">
            <p style="color: #0047ab; font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 2px; margin-bottom: 10px;">How it works</p>
            <h2 style="font-size: 2.2rem; color: #061a3d;">Simple Steps to Get Started</h2>
        </div>
        <div class="how-it-works" style="position: relative;">
            <div class="how-works-dashed"></div>
            <div class="step">
                <div class="step-number" style="background: #ebf4ff; color: #0047ab;"><i class="fa-solid fa-user-plus"></i></div>
                <h4 style="font-size: 1rem;">1. Register</h4>
                <p style="font-size: 0.8rem; color: #718096; margin-top: 10px;">Create your account in just a few minutes.</p>
            </div>
            <div class="step">
                <div class="step-number"><i class="fa-solid fa-id-card"></i></div>
                <h4 style="font-size: 1rem;">2. Complete Profile</h4>
                <p style="font-size: 0.8rem; color: #718096; margin-top: 10px;">Add your details and let others find you.</p>
            </div>
            <div class="step">
                <div class="step-number"><i class="fa-solid fa-people-group"></i></div>
                <h4 style="font-size: 1rem;">3. Connect</h4>
                <p style="font-size: 0.8rem; color: #718096; margin-top: 10px;">Network with alumni and grow together.</p>
            </div>
            <div class="step">
                <div class="step-number"><i class="fa-solid fa-magnifying-glass"></i></div>
                <h4 style="font-size: 1rem;">4. Explore Opportunities</h4>
                <p style="font-size: 0.8rem; color: #718096; margin-top: 10px;">Find jobs, events, and mentorship.</p>
            </div>
            <div class="step">
                <div class="step-number"><i class="fa-solid fa-gift"></i></div>
                <h4 style="font-size: 1rem;">5. Give Back</h4>
                <p style="font-size: 0.8rem; color: #718096; margin-top: 10px;">Contribute, support and create meaningful impact.</p>
            </div>
        </div>
    </section>

    <section class="section" style="background: #f8fafc; padding: 100px 10%;">
        <div style="display: flex; gap: 80px; align-items: center;">
            <div style="flex: 1; position: relative;">
                <div style="border-radius: 20px; overflow: hidden; position: relative; height: 400px; box-shadow: 0 30px 60px rgba(0,0,0,0.1);">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" style="width: 100%; height: 100%; object-fit: cover;">
                    <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.2); display: flex; align-items: center; justify-content: center;">
                        <div style="width: 70px; height: 70px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #0047ab; font-size: 1.5rem; cursor: pointer;">
                            <i class="fa-solid fa-play"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div style="flex: 1;">
                <p style="color: #0047ab; font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 2px; margin-bottom: 10px;">Why Join Us?</p>
                <h2 style="font-size: 2.5rem; color: #061a3d; margin-bottom: 1.5rem;">More Than a Network,<br>It's a Family.</h2>
                <p style="color: #718096; line-height: 1.8; margin-bottom: 2.5rem;">Join a supportive community that celebrates achievements, encourages growth and creates opportunities for all.</p>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 10px; font-size: 0.9rem; color: #4a5568;"><i class="fa-solid fa-user-shield" style="color: #0047ab;"></i> Exclusive Alumni Access</div>
                    <div style="display: flex; align-items: center; gap: 10px; font-size: 0.9rem; color: #4a5568;"><i class="fa-solid fa-shield-halved" style="color: #0047ab;"></i> Trusted & Verified Network</div>
                    <div style="display: flex; align-items: center; gap: 10px; font-size: 0.9rem; color: #4a5568;"><i class="fa-solid fa-bell" style="color: #0047ab;"></i> Regular Updates</div>
                    <div style="display: flex; align-items: center; gap: 10px; font-size: 0.9rem; color: #4a5568;"><i class="fa-solid fa-lock" style="color: #0047ab;"></i> Secure & Reliable Platform</div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" style="padding: 100px 10%;">
        <div style="background: linear-gradient(135deg, #6b46c1, #553c9a); border-radius: 24px; padding: 5rem; display: flex; justify-content: space-between; align-items: center; color: white;">
            <div>
                <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">Be a Part of Something Bigger</h2>
                <p style="opacity: 0.9; font-size: 1.1rem;">Reconnect. Contribute. Inspire. Together, let's build a stronger legacy for generations to come.</p>
            </div>
            <div style="display: flex; gap: 15px;">
                <a href="{{ url('/signup') }}" style="padding: 1rem 2.5rem; background: white; color: #553c9a; text-decoration: none; border-radius: 8px; font-weight: 700;">Register Now &nbsp; <i class="fa-solid fa-arrow-right"></i></a>
                <a href="{{ url('/login') }}" style="padding: 1rem 2.5rem; border: 1.5px solid white; color: white; text-decoration: none; border-radius: 8px; font-weight: 700;">Login &nbsp; <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <footer style="padding: 4rem 10%; background: white; border-top: 1px solid #f1f5f9;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
                <div class="logo-container" style="margin-bottom: 1.5rem;">
                    <img src="{{ asset('images/logo.png') }}" alt="GEC Logo" style="width: 40px;">
                    <div class="logo-text">
                        <h1 style="font-size: 1rem; color: #061a3d;">GEC ALUMNI</h1>
                        <p style="font-size: 0.6rem; color: #718096;">ASSOCIATION PLATFORM</p>
                    </div>
                </div>
            <p style="color: #a0aec0; font-size: 0.9rem;">© {{ date('Y') }} GEC Alumni Association. All rights reserved.</p>
            <div style="display: flex; gap: 20px;">
                <a href="#" style="color: #061a3d; font-size: 1.2rem;"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" style="color: #061a3d; font-size: 1.2rem;"><i class="fa-brands fa-linkedin"></i></a>
                <a href="#" style="color: #061a3d; font-size: 1.2rem;"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" style="color: #061a3d; font-size: 1.2rem;"><i class="fa-brands fa-twitter"></i></a>
                <a href="#" style="color: #061a3d; font-size: 1.2rem;"><i class="fa-brands fa-youtube"></i></a>
            </div>
        </div>
    </footer>
</body>
</html>
