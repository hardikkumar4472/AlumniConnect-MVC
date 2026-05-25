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

        /* Success Stories Carousel/Slider Styles */
        .story-slider-wrapper {
            position: relative;
            overflow: hidden;
            width: 100%;
        }
        .story-slides-container {
            display: flex;
            width: 100%;
        }
        .story-slide {
            min-width: 100%;
            display: flex;
            align-items: center;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }
        .story-slide.active {
            opacity: 1;
        }
        .slider-controls {
            display: flex;
            gap: 15px;
        }
        .slider-btn {
            background: white;
            border: 1px solid #e2e8f0;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: #0047ab;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }
        .slider-btn:hover {
            background: #0047ab;
            color: white;
            border-color: #0047ab;
            transform: scale(1.08);
        }
        .slider-dots {
            display: flex;
            gap: 8px;
        }
        .slider-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #cbd5e0;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .slider-dot.active {
            background: #0047ab;
            width: 24px;
            border-radius: 4px;
        }

        /* Responsive Layout Overrides */
        .landing-hero {
            background: linear-gradient(rgba(6, 26, 61, 0.85), rgba(6, 26, 61, 0.85)), url('{{ asset('images/campus.png') }}') !important;
            background-size: cover !important;
            background-position: center !important;
            padding: 160px 10% 100px !important;
        }
        .hero-container {
            display: flex;
            gap: 50px;
            align-items: center;
        }
        .landing-hero-content {
            flex: 1.2;
        }
        .hero-title {
            font-size: 3.5rem;
            color: white;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        .hero-subtitle {
            color: #cbd5e0;
            line-height: 1.7;
            margin-bottom: 2.5rem;
            font-size: 1.1rem;
        }
        .hero-btns {
            display: flex;
            gap: 15px;
            margin-bottom: 4rem;
        }
        .hero-quote-wrapper {
            flex: 0.8;
            width: 100%;
        }
        .quote-card {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
            padding: 3rem;
            border-radius: 24px;
            border: 1px solid rgba(255,255,255,0.1);
        }

        /* Success Story Section */
        .story-section {
            background: #f8fafc;
            padding: 100px 10%;
        }
        .story-container {
            display: flex;
            gap: 80px;
            align-items: center;
        }
        .story-img-wrapper {
            flex: 1;
            width: 100%;
        }
        .story-content-wrapper {
            flex: 1.2;
            width: 100%;
        }

        /* Upcoming Reunions Section */
        .reunions-section {
            padding: 100px 10%;
        }
        .reunions-header {
            text-align: center;
            margin-bottom: 5rem;
        }
        .reunions-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        /* CTA Section */
        .cta-section {
            padding: 0 10% 100px;
        }
        .cta-card {
            background: #061a3d;
            border-radius: 32px;
            padding: 6rem;
            text-align: center;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .cta-title {
            font-size: 3rem;
            margin-bottom: 1.5rem;
        }
        .cta-text {
            font-size: 1.2rem;
            opacity: 0.8;
            max-width: 700px;
            margin: 0 auto 3.5rem;
        }
        .cta-btns {
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        /* Footer Section */
        .footer-main-section {
            padding: 5rem 10% 3rem;
            background: #f8fafc;
            border-top: 1px solid #f1f5f9;
        }
        .footer-grid {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4rem;
            gap: 2rem;
        }
        .footer-logo-col {
            max-width: 350px;
        }
        .footer-bottom {
            border-top: 1px solid #e2e8f0;
            padding-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Media Queries for Perfect Mobile Adaptability */
        @media (max-width: 992px) {
            .landing-hero {
                padding: 120px 5% 60px !important;
            }
            .hero-container {
                flex-direction: column;
                gap: 40px;
                text-align: center;
            }
            .landing-hero-content, .hero-quote-wrapper {
                flex: none;
                width: 100%;
            }
            .hero-title {
                font-size: 2.75rem;
            }
            .hero-btns {
                justify-content: center;
            }
            .quote-card {
                padding: 2rem;
            }

            .story-section {
                padding: 60px 5% !important;
            }
            .story-container {
                flex-direction: column;
                gap: 40px;
                text-align: center;
            }
            .story-container img {
                max-width: 480px;
                margin: 0 auto;
            }
            .story-img-wrapper, .story-content-wrapper {
                flex: none;
                width: 100%;
            }

            .reunions-section {
                padding: 60px 5% !important;
            }
            .reunions-header {
                margin-bottom: 3rem;
            }
            .reunions-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .cta-section {
                padding: 0 5% 60px !important;
            }
            .cta-card {
                padding: 4rem 2rem;
                border-radius: 24px;
            }
            .cta-title {
                font-size: 2.25rem;
            }
            .cta-text {
                font-size: 1.1rem;
                margin-bottom: 2.5rem;
            }

            .footer-main-section {
                padding: 4rem 5% 2rem !important;
            }
            .footer-grid {
                flex-direction: column;
                gap: 3rem;
            }
            .footer-logo-col {
                max-width: 100%;
            }
        }

        @media (max-width: 768px) {
            .landing-nav {
                padding: 0.5rem 1.5rem !important;
            }
            .hero-title {
                font-size: 2.25rem;
            }
            .reunions-grid {
                grid-template-columns: 1fr;
            }
            .footer-bottom {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .hero-btns {
                flex-direction: column;
                gap: 12px;
                width: 100%;
            }
            .hero-btns a {
                width: 100%;
                text-align: center;
                box-sizing: border-box;
                display: block !important;
                padding: 0.8rem 1.5rem !important;
            }
            .cta-btns {
                flex-direction: column;
                width: 100%;
                gap: 12px;
            }
            .cta-btns a {
                width: 100%;
                text-align: center;
                box-sizing: border-box;
                display: inline-flex !important;
                justify-content: center;
                padding: 1rem 2rem !important;
            }
        }
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

        <div style="display: flex; gap: 12px;">
            <a href="{{ url('/login') }}" style="padding: 0.6rem 1.5rem; border: 1.5px solid #0047ab; border-radius: 8px; color: #0047ab; text-decoration: none; font-weight: 600; font-size: 0.85rem;">Login</a>
            <a href="{{ url('/signup') }}" style="padding: 0.6rem 1.5rem; background: #0047ab; border-radius: 8px; color: white; text-decoration: none; font-weight: 600; font-size: 0.85rem;">Register</a>
        </div>
    </nav>

    <header class="landing-hero">
        <div class="hero-container">
            <div class="landing-hero-content">
                <h1 class="hero-title">Stay Connected.<br>Give Back.<br><span style="color: #ffd700;">Create Impact.</span></h1>
                <p class="hero-subtitle">The GEC Alumni Association Platform connects thousands of graduates, empowers careers, and drives the legacy of our alma mater.</p>
                
                <div class="hero-btns">
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
            
            <div class="hero-quote-wrapper">
                <div class="quote-card">
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

    @if($featured_stories && $featured_stories->count() > 0)
    <section class="story-section" style="position: relative; overflow: hidden; padding: 100px 10%;">
        <div class="story-slider-wrapper">
            <div class="story-slides-container" id="storySlides">
                @foreach($featured_stories as $index => $story)
                <div class="story-slide @if($index === 0) active @endif" style="display: @if($index === 0) flex @else none @endif; gap: 80px; align-items: center;" data-index="{{ $index }}">
                    <div class="story-img-wrapper" style="flex: 1; width: 100%;">
                        <img src="{{ \Illuminate\Support\Str::startsWith($story->image, 'http') ? $story->image : asset('images/' . ($story->image ?? 'alumni1.png')) }}" style="width: 100%; border-radius: 24px; box-shadow: 0 30px 60px rgba(0,0,0,0.1); height: 400px; object-fit: cover;">
                    </div>
                    <div class="story-content-wrapper" style="flex: 1.2; width: 100%; text-align: left;">
                        <p style="color: #0047ab; font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 2px; margin-bottom: 1rem;">Success Story</p>
                        <h2 style="font-size: 2.5rem; color: #061a3d; margin-bottom: 2rem;">Inspiration Across Batches</h2>
                        <p style="font-size: 1.3rem; line-height: 1.6; font-style: italic; color: #4a5568; margin-bottom: 2.5rem; min-height: 120px;">"{{ $story->content ?? $story->story }}"</p>
                        
                        <div style="display: flex; align-items: center; gap: 20px;">
                            <div style="width: 60px; height: 60px; background: #0047ab; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                                <i class="fa-solid fa-user-graduate"></i>
                            </div>
                            <div>
                                <h4 style="font-size: 1.2rem; margin: 0; color: #0f172a;">{{ $story->author ?? $story->name }}</h4>
                                <p style="color: #718096; margin: 0; font-size: 0.9rem;">{{ $story->title ?? $story->designation }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            @if($featured_stories->count() > 1)
            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 3rem; border-top: 1px solid #e2e8f0; padding-top: 1.5rem;">
                <div class="slider-dots" style="margin-top: 0;">
                    @foreach($featured_stories as $index => $story)
                    <div class="slider-dot @if($index === 0) active @endif" data-slide="{{ $index }}" onclick="goToSlide({{ $index }})"></div>
                    @endforeach
                </div>
                
                <div class="slider-controls" style="margin-top: 0;">
                    <button class="slider-btn" onclick="prevSlide()" aria-label="Previous story"><i class="fa-solid fa-arrow-left"></i></button>
                    <button class="slider-btn" onclick="nextSlide()" aria-label="Next story"><i class="fa-solid fa-arrow-right"></i></button>
                </div>
            </div>
            @endif
        </div>
    </section>
    @endif

    <section class="reunions-section">
        <div class="reunions-header">
            <p style="color: #0047ab; font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 2px; margin-bottom: 1rem;">Upcoming Reunions</p>
            <h2 style="font-size: 2.5rem; color: #061a3d;">Save the Dates</h2>
        </div>
        
        <div class="reunions-grid">
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

    <section class="cta-section">
        <div class="cta-card">
            <h2 class="cta-title">Join the GEC Legacy Today</h2>
            <p class="cta-text">Reconnect with your roots and contribute to the future of engineering excellence.</p>
            <div class="cta-btns">
                <a href="{{ url('/signup') }}" style="padding: 1.2rem 3rem; background: white; color: #553c9a; text-decoration: none; border-radius: 12px; font-weight: 700; font-size: 1.1rem; display: inline-flex; align-items: center; gap: 10px;">
                    Register Now <i class="fa-solid fa-arrow-right"></i>
                </a>
                <a href="{{ url('/login') }}" style="padding: 1.2rem 3rem; border: 1.5px solid rgba(255,255,255,0.4); color: white; text-decoration: none; border-radius: 12px; font-weight: 700; font-size: 1.1rem; background: rgba(255,255,255,0.1); display: inline-flex; align-items: center; gap: 10px;">
                    Portal Access <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </a>
            </div>
        </div>
    </section>

    <footer class="footer-main-section">
        <div class="footer-grid">
            <div class="footer-logo-col">
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
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 1rem; padding-left: 0;">
                    <li><a href="#" style="color: #718096; text-decoration: none; font-size: 0.9rem;">Directory</a></li>
                    <li><a href="#" style="color: #718096; text-decoration: none; font-size: 0.9rem;">Jobs</a></li>
                    <li><a href="#" style="color: #718096; text-decoration: none; font-size: 0.9rem;">Donations</a></li>
                    <li><a href="#" style="color: #718096; text-decoration: none; font-size: 0.9rem;">Events</a></li>
                </ul>
            </div>
            <div>
                <h4 style="margin-bottom: 1.5rem; font-size: 1.1rem;">Support</h4>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 1rem; padding-left: 0;">
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
        <div class="footer-bottom">
            <p style="color: #a0aec0; font-size: 0.85rem; margin: 0;">© {{ date('Y') }} GEC Alumni Association. All rights reserved.</p>
            <p style="color: #a0aec0; font-size: 0.85rem; margin: 0;">Designed with excellence for the GEC Community.</p>
        </div>
    </footer>

    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.story-slide');
        const dots = document.querySelectorAll('.slider-dot');
        const totalSlides = slides.length;
        let slideInterval = null;

        function showSlide(index) {
            if (totalSlides === 0) return;
            
            // Loop indices
            if (index >= totalSlides) currentSlide = 0;
            else if (index < 0) currentSlide = totalSlides - 1;
            else currentSlide = index;

            // Update DOM display & opacity transitions
            slides.forEach((slide, i) => {
                if (i === currentSlide) {
                    slide.style.display = 'flex';
                    // Delay slightly to trigger the CSS opacity transition nicely
                    setTimeout(() => {
                        slide.classList.add('active');
                    }, 50);
                } else {
                    slide.classList.remove('active');
                    slide.style.display = 'none';
                }
            });

            // Update dot indicators
            dots.forEach((dot, i) => {
                if (i === currentSlide) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }

        function nextSlide() {
            showSlide(currentSlide + 1);
            resetInterval();
        }

        function prevSlide() {
            showSlide(currentSlide - 1);
            resetInterval();
        }

        function goToSlide(index) {
            showSlide(index);
            resetInterval();
        }

        function startInterval() {
            if (totalSlides > 1) {
                slideInterval = setInterval(nextSlide, 3000); // Change story every 3 seconds
            }
        }

        function resetInterval() {
            if (slideInterval) {
                clearInterval(slideInterval);
                startInterval();
            }
        }

        // Initialize Slider on DOM ready
        document.addEventListener('DOMContentLoaded', () => {
            if (totalSlides > 0) {
                showSlide(0);
                startInterval();
            }
        });
    </script>
</body>
</html>
