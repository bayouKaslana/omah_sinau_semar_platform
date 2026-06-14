<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Mitra Prestasi - Platform kompetisi edukatif untuk generasi muda Indonesia">
    <meta name="keywords" content="lomba, kompetisi, prestasi, mahasiswa, pelajar">
    <meta name="author" content="Mitra Prestasi">
    
    <title>@yield('title', 'Mitra Prestasi - Platform Kompetisi Edukatif')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    
    <!-- Google Fonts - Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- AOS Animation Library -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    
    <!-- Custom CSS - PENTING INI! -->
    <link rel="stylesheet" href="{{ asset('css/home-styles.css') }}?v={{ time() }}">
    
    @stack('styles')
    
    <style>
        /* Loading Screen */
        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.5s, visibility 0.5s;
        }
        
        .loading-screen.hidden {
            opacity: 0;
            visibility: hidden;
        }
        
        .loader {
            width: 60px;
            height: 60px;
            border: 5px solid rgba(255, 255, 255, 0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 12px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 6px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }

    /* ── GALLERY LIGHTBOX ───────────────────────────── */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 2rem;
    }
    @media (max-width: 768px) {
        .gallery-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; }
    }
    @media (max-width: 480px) {
        .gallery-grid { grid-template-columns: 1fr; }
    }

    /* Make some items span 2 cols for masonry-like effect */
    .gallery-item:nth-child(3n+1) { grid-column: span 1; grid-row: span 2; }

    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 14px;
        cursor: pointer;
        background: #e2e8f0;
        aspect-ratio: 1;
    }
    .gallery-item:nth-child(3n+1) { aspect-ratio: auto; min-height: 280px; }

    .gallery-item img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform .4s ease;
        display: block;
    }
    .gallery-item:hover img { transform: scale(1.08); }

    .gallery-item-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,.75) 0%, rgba(0,0,0,.1) 60%, transparent 100%);
        opacity: 0;
        transition: opacity .3s ease;
        display: flex; align-items: flex-end;
    }
    .gallery-item:hover .gallery-item-overlay { opacity: 1; }

    .gallery-item-info {
        padding: 1.2rem;
        color: #fff;
        width: 100%;
    }
    .gallery-item-icon {
        font-size: 1.6rem;
        margin-bottom: .4rem;
        opacity: .9;
    }
    .gallery-item-info h5 {
        font-size: .95rem;
        font-weight: 700;
        margin-bottom: .2rem;
        line-height: 1.3;
    }
    .gallery-item-info p {
        font-size: .78rem;
        opacity: .8;
        margin: 0;
    }

    /* Lightbox */
    .lightbox-overlay {
        position: fixed; inset: 0;
        background: rgba(0,0,0,.92);
        z-index: 9999;
        display: flex; align-items: center; justify-content: center;
        opacity: 0; visibility: hidden;
        transition: .3s ease;
    }
    .lightbox-overlay.active { opacity: 1; visibility: visible; }

    .lightbox-content {
        max-width: 90vw; max-height: 90vh;
        display: flex; flex-direction: column;
        align-items: center;
        animation: lbZoom .3s ease;
    }
    @keyframes lbZoom {
        from { transform: scale(.85); opacity: 0; }
        to   { transform: scale(1); opacity: 1; }
    }
    .lightbox-content img {
        max-width: 90vw; max-height: 75vh;
        object-fit: contain;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0,0,0,.5);
        transition: opacity .2s ease;
    }
    .lightbox-caption {
        text-align: center; margin-top: 1rem; color: #fff;
    }
    .lightbox-caption h5 { font-size: 1.1rem; font-weight: 700; margin-bottom: .25rem; }
    .lightbox-caption p  { font-size: .85rem; opacity: .7; margin: 0; }

    .lightbox-close {
        position: fixed; top: 1.2rem; right: 1.5rem;
        background: rgba(255,255,255,.15); border: none;
        color: #fff; width: 44px; height: 44px;
        border-radius: 50%; font-size: 1.1rem;
        cursor: pointer; transition: .2s; z-index: 10;
        display: flex; align-items: center; justify-content: center;
    }
    .lightbox-close:hover { background: rgba(255,255,255,.3); transform: rotate(90deg); }

    .lightbox-prev, .lightbox-next {
        position: fixed; top: 50%; transform: translateY(-50%);
        background: rgba(255,255,255,.15); border: none;
        color: #fff; width: 50px; height: 50px;
        border-radius: 50%; font-size: 1.3rem;
        cursor: pointer; transition: .2s; z-index: 10;
        display: flex; align-items: center; justify-content: center;
    }
    .lightbox-prev { left: 1.2rem; }
    .lightbox-next { right: 1.2rem; }
    .lightbox-prev:hover, .lightbox-next:hover { background: rgba(255,255,255,.3); }

    .lightbox-counter {
        position: fixed; bottom: 1.5rem; left: 50%; transform: translateX(-50%);
        color: rgba(255,255,255,.7); font-size: .85rem;
        background: rgba(0,0,0,.4); padding: .3rem .8rem;
        border-radius: 20px;
    }

    /* ── SCROLL ANIMATION ENHANCEMENTS ─────────────── */
    /* Pastikan elemen yang belum di-scroll tidak keliatan */
    [data-aos] {
        pointer-events: none;
    }
    [data-aos].aos-animate {
        pointer-events: auto;
    }

    /* Tambahan animasi custom untuk section titles */
    .section-subtitle {
        display: inline-block;
    }

    /* Smooth transition untuk competition cards */
    .competition-card {
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .competition-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(0,0,0,.12) !important;
    }

    /* Blog card hover */
    .blog-card {
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .blog-card:hover {
        transform: translateY(-5px);
    }

    /* Stat items di hero muncul dengan bounce */
    .stat-item {
        animation: none;
    }
    .hero-stats.aos-animate .stat-item:nth-child(1) { animation: countUp .6s ease .1s both; }
    .hero-stats.aos-animate .stat-item:nth-child(2) { animation: countUp .6s ease .2s both; }
    .hero-stats.aos-animate .stat-item:nth-child(3) { animation: countUp .6s ease .3s both; }
    @keyframes countUp {
        from { opacity: 0; transform: translateY(20px) scale(.9); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* Contact items stagger */
    .contact-item[data-aos] {
        transition-property: transform, opacity;
    }
    .contact-item:nth-child(1) { transition-delay: 0ms !important; }
    .contact-item:nth-child(2) { transition-delay: 100ms !important; }
    .contact-item:nth-child(3) { transition-delay: 200ms !important; }


    /* ── DARK MODE ──────────────────────────────────── */
    :root {
        --bg-primary:   #ffffff;
        --bg-secondary: #f8fafc;
        --bg-card:      #ffffff;
        --text-primary: #1e293b;
        --text-muted:   #64748b;
        --border-color: #e2e8f0;
        --navbar-bg:    rgba(255,255,255,0.95);
        --section-alt:  #f8fafc;
        --footer-bg:    #1e293b;
    }
    [data-theme="dark"] {
        --bg-primary:   #0f172a;
        --bg-secondary: #1e293b;
        --bg-card:      #1e293b;
        --text-primary: #f1f5f9;
        --text-muted:   #94a3b8;
        --border-color: #334155;
        --navbar-bg:    rgba(15,23,42,0.97);
        --section-alt:  #1e293b;
        --footer-bg:    #020617;
    }
    [data-theme="dark"] body          { background: var(--bg-primary); color: var(--text-primary); }
    [data-theme="dark"] .competition-card,
    [data-theme="dark"] .blog-card,
    [data-theme="dark"] .contact-form-wrapper,
    [data-theme="dark"] .legal-card   { background: var(--bg-card) !important; border-color: var(--border-color) !important; color: var(--text-primary); }
    [data-theme="dark"] .form-control { background: #0f172a; border-color: var(--border-color); color: var(--text-primary); }
    [data-theme="dark"] .form-control:focus { background: #0f172a; color: #fff; }
    [data-theme="dark"] .form-control::placeholder { color: #475569; }
    [data-theme="dark"] .gallery-section,
    [data-theme="dark"] .profil-section,
    [data-theme="dark"] .kontak-section  { background: var(--bg-primary); }
    [data-theme="dark"] .competition-section,
    [data-theme="dark"] .blog-section    { background: var(--bg-secondary); }
    [data-theme="dark"] .section-title   { color: var(--text-primary); }
    [data-theme="dark"] .section-description,
    [data-theme="dark"] .profil-text,
    [data-theme="dark"] .kontak-description { color: var(--text-muted); }
    [data-theme="dark"] .blog-title a    { color: var(--text-primary); }
    [data-theme="dark"] .blog-excerpt    { color: var(--text-muted); }
    [data-theme="dark"] .competition-title { color: var(--text-primary); }
    [data-theme="dark"] #mainNav        { background: var(--navbar-bg) !important; border-bottom: 1px solid var(--border-color); }
    [data-theme="dark"] .nav-link        { color: var(--text-primary) !important; }
    [data-theme="dark"] .footer-section  { background: var(--footer-bg); }
    [data-theme="dark"] .contact-item .contact-label,
    [data-theme="dark"] .contact-item .contact-value { color: var(--text-primary); }
    [data-theme="dark"] .legal-number   { color: var(--text-primary); }
    [data-theme="dark"] .profil-mission ul li { color: var(--text-muted); }
    [data-theme="dark"] .hero-section   { background: linear-gradient(135deg, #020617 0%, #0f172a 50%, #1e3a5f 100%); }

    /* Toggle Button */
    .dark-toggle {
        background: none;
        border: 1.5px solid rgba(255,255,255,.3);
        color: inherit;
        width: 38px; height: 38px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        font-size: 1.1rem;
        transition: .2s;
        margin-left: .5rem;
    }
    .dark-toggle:hover { background: rgba(255,255,255,.15); }
    [data-theme="dark"] .dark-toggle { border-color: rgba(255,255,255,.2); }

    </style>
</head>
<body>
    <!-- Loading Screen -->
    <div class="loading-screen" id="loadingScreen">
        <div class="loader"></div>
    </div>
    
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('img/logo.png') }}" alt="Mitra Prestasi" class="nav-logo">
                <span class="nav-brand-text">Mitra Prestasi</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/') }}">
                            <i class="bi bi-house-door-fill me-2"></i>
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#lomba">
                            <i class="bi bi-trophy-fill me-2"></i>
                            Lomba
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/publikasi') }}">
                            <i class="bi bi-newspaper me-2"></i>
                            Publikasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#profil">
                            <i class="bi bi-person-circle me-2"></i>
                            Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">
                            <i class="bi bi-envelope-fill me-2"></i>
                            Kontak
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop">
        <i class="bi bi-arrow-up"></i>
    </button>
    
    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Initialize AOS
        AOS.init({
            duration: 700,
            easing: 'ease-out-cubic',
            once: true,
            offset: 80,
            delay: 0,
            anchorPlacement: 'top-bottom',
        });
        
        // Loading Screen
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.getElementById('loadingScreen').classList.add('hidden');
            }, 500);
        });
        
        // Navbar Scroll Effect
        const navbar = document.getElementById('mainNav');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Smooth Scroll for Anchor Links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    const navbarHeight = navbar.offsetHeight;
                    const targetPosition = target.offsetTop - navbarHeight;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    const navbarCollapse = document.getElementById('navbarNav');
                    if (navbarCollapse.classList.contains('show')) {
                        const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                        if (bsCollapse) {
                            bsCollapse.hide();
                        }
                    }
                }
            });
        });
        
        // Back to Top Button
        const backToTopBtn = document.getElementById('backToTop');
        
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTopBtn.classList.add('show');
            } else {
                backToTopBtn.classList.remove('show');
            }
        });
        
        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Parallax Effect for Hero Mascot
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const mascot = document.querySelector('.hero-mascot');
            if (mascot && scrolled < window.innerHeight) {
                mascot.style.transform = `translateY(${scrolled * 0.3}px)`;
            }
        });
        
        // Active Nav Link Highlighting
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-link');
        
        function highlightNavLink() {
            const scrollY = window.pageYOffset;
            
            sections.forEach(section => {
                const sectionHeight = section.offsetHeight;
                const sectionTop = section.offsetTop - 100;
                const sectionId = section.getAttribute('id');
                
                if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                    navLinks.forEach(link => {
                        link.classList.remove('active');
                        if (link.getAttribute('href') === `#${sectionId}`) {
                            link.classList.add('active');
                        }
                    });
                }
            });
        }
        
        window.addEventListener('scroll', highlightNavLink);
        
        // Contact Form Submission
        const contactForm = document.querySelector('.contact-form');
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const name = document.getElementById('name').value;
                const email = document.getElementById('email').value;
                const subject = document.getElementById('subject').value;
                const message = document.getElementById('message').value;
                
                if (!name || !email || !subject || !message) {
                    alert('Mohon lengkapi semua field!');
                    return;
                }
                
                alert('Terima kasih! Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.');
                contactForm.reset();
            });
        }
        
        // Newsletter Form Submission
        const newsletterForm = document.querySelector('.newsletter-form');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const email = this.querySelector('input[type="email"]').value;
                
                if (!email) {
                    alert('Mohon masukkan email Anda!');
                    return;
                }
                
                alert('Terima kasih telah berlangganan newsletter kami!');
                this.reset();
            });
        }
        
        // Competition Filter
        const filterBtns = document.querySelectorAll('.filter-btn');
        const competitionItems = document.querySelectorAll('.competition-item');
        
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const filterValue = this.getAttribute('data-filter');
                
                competitionItems.forEach(item => {
                    const itemStatus = item.getAttribute('data-status');
                    
                    if (filterValue === 'all') {
                        item.style.display = 'block';
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'translateY(0)';
                        }, 10);
                    } else if (itemStatus === filterValue) {
                        item.style.display = 'block';
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'translateY(0)';
                        }, 10);
                    } else {
                        item.style.opacity = '0';
                        item.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            item.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });
    </script>
    
    @stack('scripts')

    <script>
    // ── DARK MODE ──────────────────────────────────────
    const html      = document.documentElement;
    const toggleBtn = document.getElementById('darkToggle');
    const icon      = document.getElementById('darkIcon');

    // Load saved preference
    const saved = localStorage.getItem('theme') || 'light';
    setTheme(saved);

    toggleBtn.addEventListener('click', () => {
        const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        setTheme(next);
        localStorage.setItem('theme', next);
    });

    function setTheme(theme) {
        html.setAttribute('data-theme', theme);
        if (theme === 'dark') {
            icon.className = 'bi bi-sun-fill';
            toggleBtn.style.color = '#fbbf24';
        } else {
            icon.className = 'bi bi-moon-fill';
            toggleBtn.style.color = '';
        }
    }
    </script>

</body>
</html>