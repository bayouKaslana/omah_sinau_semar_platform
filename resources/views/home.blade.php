@extends('layouts.app')

@push('styles')
<style>
/* GLOBAL */
:root {
    --primary: #16a34a;
    --primary-dark: #15803d;
    --primary-light: #f0fdf4;
    --accent: #f59e0b;
    --accent-dark: #d97706;
    --text: #1e293b;
    --text-muted: #64748b;
    --border: #e2e8f0;
    --white: #ffffff;
    --bg-light: #f8fafc;
    --success: #16a34a;
    --radius: 12px;
    --shadow: 0 4px 24px rgba(22,163,74,0.10);
    --shadow-lg: 0 8px 40px rgba(22,163,74,0.18);
}
* { box-sizing: border-box; }
body { font-family: 'Outfit', 'Segoe UI', sans-serif; color: var(--text); }
section { padding: 80px 0; }

.section-subtitle {
    display: inline-block;
    background: var(--primary-light);
    color: var(--primary);
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    padding: 6px 16px;
    border-radius: 50px;
    margin-bottom: 12px;
    border: 1px solid #bbf7d0;
}
.section-title {
    font-size: 2rem;
    font-weight: 900;
    color: var(--text);
    margin-bottom: 12px;
}
.section-description {
    color: var(--text-muted);
    font-size: 1rem;
    max-width: 560px;
    margin: 0 auto;
}
.section-header { margin-bottom: 48px; }

/* HERO */
.hero-section {
    background: linear-gradient(135deg, #f0fdf4 0%, #fefce8 60%, #f0fdf4 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    padding: 100px 0 60px;
    overflow: hidden;
    position: relative;
}
.hero-bg-orbs { position: absolute; inset: 0; pointer-events: none; overflow: hidden; }
.orb { position: absolute; border-radius: 50%; filter: blur(60px); opacity: 0.2; }
.orb-1 { width: 400px; height: 400px; background: #16a34a; top: -100px; left: -100px; }
.orb-2 { width: 300px; height: 300px; background: #f59e0b; bottom: 50px; right: 100px; }
.orb-3 { width: 200px; height: 200px; background: #16a34a; top: 50%; left: 40%; }

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--white);
    border: 1.5px solid #bbf7d0;
    border-radius: 50px;
    padding: 8px 18px;
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 20px;
    box-shadow: var(--shadow);
}
.hero-title {
    font-size: 3rem;
    font-weight: 900;
    line-height: 1.15;
    margin-bottom: 18px;
    color: var(--text);
}
.text-gradient {
    background: linear-gradient(135deg, #16a34a, #f59e0b);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.hero-description {
    font-size: 1.05rem;
    color: var(--text-muted);
    margin-bottom: 24px;
    line-height: 1.7;
}
.hero-quote-box {
    background: var(--white);
    border-left: 4px solid var(--accent);
    border-radius: 0 var(--radius) var(--radius) 0;
    padding: 16px 20px;
    margin-bottom: 32px;
    box-shadow: var(--shadow);
    display: flex;
    align-items: center;
    gap: 12px;
}
.quote-icon {
    font-size: 2.5rem;
    color: var(--accent);
    line-height: 1;
    font-family: Georgia, serif;
}
.hero-quote {
    font-style: italic;
    color: var(--text);
    font-weight: 600;
    margin: 0;
    font-size: 1rem;
}
.hero-cta { display: flex; gap: 14px; flex-wrap: wrap; margin-bottom: 40px; }
.hero-button {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--primary); color: var(--white) !important;
    padding: 14px 28px; border-radius: 50px;
    font-weight: 700; text-decoration: none; font-size: 0.95rem;
    transition: all 0.2s;
    box-shadow: 0 4px 16px rgba(22,163,74,0.4);
    border: none;
}
.hero-button:hover { background: var(--primary-dark); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(22,163,74,0.4); }

.hero-button-accent {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--accent); color: var(--white) !important;
    padding: 14px 28px; border-radius: 50px;
    font-weight: 700; text-decoration: none; font-size: 0.95rem;
    transition: all 0.2s;
    box-shadow: 0 4px 16px rgba(245,158,11,0.4);
    border: none;
}
.hero-button-accent:hover { background: var(--accent-dark); transform: translateY(-2px); }

.hero-stats { display: flex; gap: 16px; flex-wrap: wrap; }
.stat-item {
    background: var(--white);
    border-radius: var(--radius);
    padding: 16px 24px;
    box-shadow: var(--shadow);
    text-align: center;
    min-width: 100px;
    border: 1.5px solid #bbf7d0;
}
.stat-number {
    font-size: 1.6rem; font-weight: 900;
    color: var(--primary); line-height: 1; display: block;
}
.stat-label {
    font-size: 0.75rem; color: var(--text-muted);
    margin-top: 4px; font-weight: 600; display: block;
}

.mascot-container { position: relative; display: inline-block; }
.mascot-glow {
    position: absolute; inset: -20px;
    background: radial-gradient(circle, rgba(22,163,74,0.15) 0%, transparent 70%);
    border-radius: 50%;
}
.hero-image {
    width: 100%; max-width: 420px;
    position: relative; z-index: 1;
    filter: drop-shadow(0 20px 40px rgba(22,163,74,0.25));
}
.floating-elements { position: absolute; inset: 0; pointer-events: none; }
.float-item {
    position: absolute; width: 50px; height: 50px;
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; box-shadow: var(--shadow-lg);
    animation: floatAnim 3s ease-in-out infinite;
}
.float-item.trophy { background: #fef3c7; color: #f59e0b; top: 10%; right: 5%; animation-delay: 0s; }
.float-item.star   { background: #dcfce7; color: #16a34a; bottom: 30%; left: 5%; animation-delay: 1s; }
.float-item.medal  { background: #fef3c7; color: #d97706; bottom: 10%; right: 15%; animation-delay: 2s; }
@keyframes floatAnim {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-12px); }
}
.scroll-indicator { position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); }
.mouse { width: 26px; height: 40px; border: 2px solid var(--primary); border-radius: 13px; display: flex; justify-content: center; padding-top: 6px; }
.wheel { width: 4px; height: 8px; background: var(--primary); border-radius: 2px; animation: scrollAnim 1.5s ease-in-out infinite; }
@keyframes scrollAnim { 0%, 100% { opacity: 1; transform: translateY(0); } 50% { opacity: 0; transform: translateY(8px); } }

/* GALLERY */
.gallery-section { background: var(--bg-light); }
.gallery-item {
    position: relative; border-radius: var(--radius); overflow: hidden;
    aspect-ratio: 4/3; cursor: pointer; box-shadow: var(--shadow);
}
.gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s; }
.gallery-item:hover img { transform: scale(1.07); }
.gallery-item-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(22,163,74,0.85), transparent);
    opacity: 0; transition: opacity 0.3s;
    display: flex; align-items: flex-end; padding: 20px;
}
.gallery-item:hover .gallery-item-overlay { opacity: 1; }
.gallery-item-info { color: white; }
.gallery-item-icon { font-size: 1.5rem; margin-bottom: 6px; }
.gallery-item-info h5 { margin: 0; font-weight: 700; font-size: 0.95rem; }
.gallery-item-info p { margin: 4px 0 0; font-size: 0.8rem; opacity: 0.85; }

/* LIGHTBOX */
.lightbox-overlay {
    position: fixed; inset: 0; background: rgba(0,0,0,0.92);
    z-index: 9999; display: flex; align-items: center; justify-content: center;
    opacity: 0; visibility: hidden; transition: 0.3s;
}
.lightbox-overlay.active { opacity: 1; visibility: visible; }
.lightbox-content { max-width: 85vw; max-height: 85vh; text-align: center; }
.lightbox-content img { max-width: 100%; max-height: 75vh; border-radius: var(--radius); box-shadow: 0 20px 60px rgba(0,0,0,0.5); transition: opacity 0.3s; }
.lightbox-caption { color: white; margin-top: 14px; }
.lightbox-caption h5 { font-size: 1rem; font-weight: 700; margin: 0; }
.lightbox-caption p { font-size: 0.85rem; opacity: 0.7; margin: 4px 0 0; }
.lightbox-close, .lightbox-prev, .lightbox-next {
    position: fixed; background: rgba(255,255,255,0.15); border: none;
    color: white; border-radius: 50%; cursor: pointer; transition: background 0.2s;
    display: flex; align-items: center; justify-content: center;
    width: 46px; height: 46px; font-size: 1.1rem;
}
.lightbox-close { top: 20px; right: 20px; }
.lightbox-close:hover, .lightbox-prev:hover, .lightbox-next:hover { background: var(--primary); }
.lightbox-prev { left: 20px; top: 50%; transform: translateY(-50%); }
.lightbox-next { right: 20px; top: 50%; transform: translateY(-50%); }
.lightbox-counter {
    position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%);
    color: white; font-size: 0.85rem; background: rgba(0,0,0,0.5); padding: 6px 16px; border-radius: 50px;
}

/* COMPETITION */
.competition-section { background: var(--white); }
.competition-filters { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 8px; }
.filter-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 10px 20px; border: 2px solid var(--border); border-radius: 50px;
    background: var(--white); color: var(--text-muted);
    font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: all 0.2s;
}
.filter-btn:hover { border-color: var(--primary); color: var(--primary); }
.filter-btn.active { background: var(--primary); border-color: var(--primary); color: white; }

.competition-card {
    background: var(--white); border: 1.5px solid var(--border); border-radius: 16px;
    overflow: hidden; transition: all 0.3s; height: 100%;
    display: flex; flex-direction: column;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
}
.competition-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); border-color: var(--primary); }
.competition-header {
    background: linear-gradient(135deg, var(--primary), #15803d);
    padding: 24px 20px 20px; position: relative; overflow: hidden;
}
.competition-pattern {
    position: absolute; inset: 0;
    background-image: radial-gradient(circle at 80% 20%, rgba(255,255,255,0.15) 0%, transparent 50%);
}
.competition-brand { color: white; font-size: 0.75rem; font-weight: 700; letter-spacing: 2px; margin: 0; opacity: 0.9; }
.competition-body { padding: 20px; flex: 1; display: flex; flex-direction: column; }
.competition-title { font-size: 1rem; font-weight: 800; color: var(--text); margin-bottom: 8px; line-height: 1.3; }
.competition-category { color: var(--text-muted); font-size: 0.82rem; margin-bottom: 14px; display: flex; align-items: center; gap: 6px; }
.competition-meta { margin-bottom: 16px; display: flex; flex-direction: column; gap: 6px; }
.meta-item { display: flex; align-items: center; gap: 8px; font-size: 0.82rem; color: var(--text-muted); }
.competition-footer { display: flex; align-items: center; justify-content: space-between; margin-top: auto; padding-top: 14px; border-top: 1px solid var(--border); }
.status-badge { display: inline-flex; align-items: center; gap: 4px; padding: 5px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; }
.status-open   { background: #dcfce7; color: #15803d; }
.status-closed { background: #fee2e2; color: #dc2626; }
.status-coming { background: #fef9c3; color: #a16207; }
.btn-detail { display: inline-flex; align-items: center; gap: 4px; color: var(--primary); font-size: 0.82rem; font-weight: 700; text-decoration: none; transition: gap 0.2s; }
.btn-detail:hover { gap: 8px; }

/* BLOG */
.blog-section { background: var(--bg-light); }
.blog-card {
    background: var(--white); border-radius: 16px; overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06); border: 1.5px solid var(--border);
    transition: all 0.3s; height: 100%; display: flex; flex-direction: column;
}
.blog-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: var(--primary); }
.blog-card.featured-post { border-color: var(--accent); }
.blog-image { position: relative; height: 200px; overflow: hidden; background: var(--bg-light); }
.blog-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s; display: block; }
.blog-card:hover .blog-image img { transform: scale(1.05); }
.blog-category {
    position: absolute; top: 14px; left: 14px;
    background: var(--primary); color: white;
    padding: 4px 12px; border-radius: 50px; font-size: 0.72rem; font-weight: 700;
}
.featured-badge {
    position: absolute; top: 14px; right: 14px;
    background: var(--accent); color: white;
    padding: 4px 12px; border-radius: 50px; font-size: 0.72rem; font-weight: 700;
}
.blog-content { padding: 20px; flex: 1; display: flex; flex-direction: column; }
.blog-meta { display: flex; gap: 14px; font-size: 0.78rem; color: var(--text-muted); margin-bottom: 10px; flex-wrap: wrap; }
.blog-title { font-size: 1rem; font-weight: 800; line-height: 1.4; margin-bottom: 10px; }
.blog-title a { color: var(--text); text-decoration: none; }
.blog-title a:hover { color: var(--primary); }
.blog-excerpt { color: var(--text-muted); font-size: 0.88rem; line-height: 1.6; margin-bottom: 16px; flex: 1; }
.blog-read-more { display: inline-flex; align-items: center; gap: 6px; color: var(--primary); font-size: 0.85rem; font-weight: 700; text-decoration: none; margin-top: auto; transition: gap 0.2s; }
.blog-read-more:hover { gap: 10px; }

/* PROFIL */
.profil-section { background: var(--white); }
.profil-image-wrapper { position: relative; max-width: 460px; margin: 0 auto; }
.profil-image-bg {
    position: absolute; width: 90%; height: 90%;
    background: linear-gradient(135deg, #dcfce7, #fef9c3);
    border-radius: 24px; bottom: -16px; right: -16px; z-index: 0;
}
.profil-image { width: 100%; border-radius: 20px; position: relative; z-index: 1; box-shadow: var(--shadow-lg); display: block; max-height: 460px; object-fit: cover; }
.profil-text { color: var(--text-muted); line-height: 1.75; margin-bottom: 16px; font-size: 0.97rem; }
.legal-card {
    display: flex; align-items: center; gap: 16px;
    background: #f0fdf4; border: 1.5px solid #bbf7d0;
    border-radius: var(--radius); padding: 16px 20px; margin-bottom: 24px;
}
.legal-icon-wrapper {
    width: 44px; height: 44px; background: var(--primary); border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 1.2rem; flex-shrink: 0;
}
.legal-content { flex: 1; }
.legal-label { font-size: 0.75rem; color: var(--text-muted); font-weight: 600; letter-spacing: 0.5px; }
.legal-number { font-size: 0.9rem; font-weight: 800; color: var(--primary); }
.verified-badge { color: var(--accent); font-size: 1.5rem; flex-shrink: 0; }
.profil-mission h4 { font-weight: 800; margin-bottom: 12px; }
.profil-mission ul { list-style: none; padding: 0; margin: 0; }
.profil-mission ul li { display: flex; align-items: flex-start; gap: 10px; padding: 8px 0; font-size: 0.92rem; color: var(--text); border-bottom: 1px dashed var(--border); }
.profil-mission ul li:last-child { border-bottom: none; }
.profil-mission ul li i { color: var(--primary); flex-shrink: 0; margin-top: 2px; }

/* KONTAK */
.kontak-section { background: #f0fdf4; }
.kontak-description { color: var(--text-muted); margin-bottom: 28px; line-height: 1.7; }
.contact-info { display: flex; flex-direction: column; gap: 16px; margin-bottom: 28px; }
.contact-item {
    display: flex; align-items: flex-start; gap: 16px;
    background: var(--white); border: 1.5px solid #bbf7d0;
    border-radius: var(--radius); padding: 16px 20px; transition: border-color 0.2s;
}
.contact-item:hover { border-color: var(--primary); box-shadow: var(--shadow); }
.contact-icon {
    width: 44px; height: 44px; background: #f0fdf4; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: var(--primary); font-size: 1.1rem; flex-shrink: 0;
}
.contact-label { font-size: 0.75rem; color: var(--text-muted); font-weight: 600; letter-spacing: 0.5px; }
.contact-value { font-size: 0.92rem; font-weight: 700; color: var(--text); margin-top: 2px; line-height: 1.6; }
.social-links { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 4px; }
.social-link {
    width: 42px; height: 42px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; text-decoration: none; transition: all 0.2s; color: white;
}
.social-link.whatsapp  { background: #25d366; }
.social-link.instagram { background: linear-gradient(135deg, #f58529, #dd2a7b, #8134af); }
.social-link.youtube   { background: #ff0000; }
.social-link.email     { background: var(--primary); }
.social-link:hover { transform: translateY(-3px); box-shadow: 0 6px 16px rgba(0,0,0,0.2); }

.contact-form-wrapper {
    background: var(--white); border-radius: 20px;
    padding: 36px; box-shadow: var(--shadow-lg); border: 1.5px solid #bbf7d0;
}
.form-group { margin-bottom: 18px; }
.form-group label { display: block; font-size: 0.85rem; font-weight: 700; color: var(--text); margin-bottom: 6px; }
.form-control {
    width: 100%; border: 1.5px solid var(--border); border-radius: 10px;
    padding: 12px 16px; font-size: 0.9rem; color: var(--text);
    transition: border-color 0.2s; outline: none; background: var(--white);
}
.form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(22,163,74,0.12); }
textarea.form-control { resize: vertical; min-height: 120px; }
.btn-primary-full {
    width: 100%; background: var(--primary); color: white; border: none;
    border-radius: 50px; padding: 14px; font-size: 0.97rem; font-weight: 700;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    gap: 8px; transition: all 0.2s; box-shadow: 0 4px 16px rgba(22,163,74,0.35);
}
.btn-primary-full:hover { background: var(--primary-dark); transform: translateY(-2px); }

/* FOOTER */
.footer-section { background: #052e16; color: #bbf7d0; padding: 60px 0 0; }
.footer-brand { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
.footer-brand h3 { color: white; font-weight: 800; margin: 0; font-size: 1.3rem; }
.footer-brand i { color: var(--accent); font-size: 1.8rem; }
.footer-description { font-size: 0.88rem; line-height: 1.7; color: #86efac; max-width: 280px; }
.footer-title { color: white; font-weight: 800; font-size: 0.95rem; margin-bottom: 16px; }
.footer-links { list-style: none; padding: 0; margin: 0; }
.footer-links li { margin-bottom: 10px; }
.footer-links li a { color: #86efac; text-decoration: none; font-size: 0.88rem; transition: color 0.2s; }
.footer-links li a:hover { color: var(--accent); }
.footer-divider { border-color: #14532d; margin: 40px 0 0; }
.footer-bottom { padding: 20px 0; text-align: center; }
.copyright { color: #4ade80; font-size: 0.82rem; margin: 0; }

/* BUTTONS */
.btn { display: inline-flex; align-items: center; gap: 8px; text-decoration: none; border-radius: 50px; font-weight: 700; transition: all 0.2s; border: none; cursor: pointer; }
.btn-primary { background: var(--primary); color: white !important; padding: 13px 28px; box-shadow: 0 4px 16px rgba(22,163,74,0.3); }
.btn-primary:hover { background: var(--primary-dark); transform: translateY(-2px); }
.btn-lg { padding: 14px 32px; font-size: 1rem; }

.alert-success-custom {
    background: #dcfce7; color: #15803d; border: 1.5px solid #86efac;
    border-radius: 10px; padding: 14px 18px; margin-bottom: 16px;
    font-weight: 600; font-size: 0.9rem; display: flex; align-items: center; gap: 8px;
}

/* VISI MISI */
.profil-mission { margin-top: 8px; }
.visi-box {
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    border: 1.5px solid #bbf7d0;
    border-radius: var(--radius);
    padding: 18px 20px;
    margin-bottom: 16px;
}
.visi-box h5 {
    color: var(--primary);
    font-weight: 800;
    font-size: 0.95rem;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
}
.visi-box p {
    color: var(--text);
    font-size: 0.92rem;
    line-height: 1.7;
    margin: 0;
    font-style: italic;
}
.misi-box {
    background: linear-gradient(135deg, #fefce8, #fef9c3);
    border: 1.5px solid #fde68a;
    border-radius: var(--radius);
    padding: 18px 20px;
}
.misi-box h5 {
    color: var(--accent-dark);
    font-weight: 800;
    font-size: 0.95rem;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
}
.misi-box ul { list-style: none; padding: 0; margin: 0; }
.misi-box ul li {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 7px 0;
    font-size: 0.88rem;
    color: var(--text);
    border-bottom: 1px dashed #fde68a;
    line-height: 1.5;
}
.misi-box ul li:last-child { border-bottom: none; }
.misi-box ul li i { color: var(--accent-dark); flex-shrink: 0; margin-top: 3px; }

/* RESPONSIVE */
@media (max-width: 768px) {
    .hero-title { font-size: 2rem; }
    section { padding: 60px 0; }
    .hero-stats { gap: 10px; }
    .stat-item { padding: 12px 16px; }
    .contact-form-wrapper { padding: 24px; }
    .profil-image-wrapper { margin-bottom: 40px; }
}
</style>
@endpush

@section('content')

<!-- HERO -->
<section class="hero-section">
    <div class="hero-bg-orbs">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>
    <div class="container">
        <div class="row align-items-center position-relative">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="hero-badge">
                    <i class="bi bi-stars"></i><span>Selamat Datang</span>
                </div>
                <h1 class="hero-title">Halo, Sahabat <span class="text-gradient">Juara!</span></h1>
                <p class="hero-description">
                    Platform resmi <strong>Omah Sinau Semar</strong>. Temukan informasi lomba
                    terbaru, panduan lengkap, dan raih prestasimu bersama kami.
                </p>
                <div class="hero-quote-box">
                    <div class="quote-icon">"</div>
                    <p class="hero-quote">Berjuang dalam Belajar Tanpa Batas Waktu!</p>
                </div>
                <div class="hero-cta">
                    <a href="#lomba" class="hero-button">
                        <span>Lihat Lomba</span><i class="bi bi-arrow-down-circle"></i>
                    </a>
                    <a href="#profil" class="hero-button-accent">
                        <span>Tentang Kami</span>
                    </a>
                </div>
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $stats['peserta'] ?? '500' }}+</span>
                        <span class="stat-label">Peserta Aktif</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $stats['lomba'] ?? '100' }}+</span>
                        <span class="stat-label">Lomba Tersedia</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $stats['pemenang'] ?? '50' }}+</span>
                        <span class="stat-label">Pemenang</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="mascot-container">
                    <div class="mascot-glow"></div>
                    <img src="{{ asset('image/favlogo.png') }}"
                         alt="Mitra Prestasi Mascot" class="hero-image">
                    <div class="floating-elements">
                        <div class="float-item trophy"><i class="bi bi-trophy-fill"></i></div>
                        <div class="float-item star"><i class="bi bi-star-fill"></i></div>
                        <div class="float-item medal"><i class="bi bi-award-fill"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="scroll-indicator">
        <div class="mouse"><div class="wheel"></div></div>
    </div>
</section>

<!-- GALERI -->
<section class="gallery-section">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-subtitle">Dokumentasi</span>
            <h2 class="section-title">Galeri Kegiatan Kami</h2>
            <p class="section-description">Momen-momen berharga dari berbagai kompetisi dan kegiatan</p>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px;">
            @forelse($galeri as $foto)
                <div class="gallery-item" onclick="openLightbox({{ $loop->index }})">
                    <img src="{{ $foto->foto_url }}" alt="{{ $foto->judul }}" loading="lazy">
                    <div class="gallery-item-overlay">
                        <div class="gallery-item-info">
                            <div class="gallery-item-icon"><i class="bi bi-zoom-in"></i></div>
                            <h5>{{ $foto->judul }}</h5>
                            @if($foto->tanggal)
                                <p><i class="bi bi-calendar3"></i> {{ $foto->tanggal->format('d M Y') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column:1/-1;text-align:center;padding:60px 0;color:#94a3b8;">
                    <i class="bi bi-images" style="font-size:3rem;"></i>
                    <p style="margin-top:12px;">Belum ada foto.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- LIGHTBOX -->
<div id="lightbox" class="lightbox-overlay" onclick="closeLightbox()">
    <button class="lightbox-close" onclick="closeLightbox()"><i class="bi bi-x-lg"></i></button>
    <button class="lightbox-prev" onclick="event.stopPropagation();prevPhoto()"><i class="bi bi-chevron-left"></i></button>
    <button class="lightbox-next" onclick="event.stopPropagation();nextPhoto()"><i class="bi bi-chevron-right"></i></button>
    <div class="lightbox-content" onclick="event.stopPropagation()">
        <img id="lightboxImg" src="" alt="">
        <div class="lightbox-caption">
            <h5 id="lightboxTitle"></h5>
            <p id="lightboxDate"></p>
        </div>
    </div>
    <div class="lightbox-counter"><span id="lightboxCurrent">1</span> / <span id="lightboxTotal">1</span></div>
</div>

@php
$galeriJson = $galeri->map(fn($f) => [
    'src'   => $f->foto_url,
    'judul' => $f->judul,
    'tgl'   => $f->tanggal ? $f->tanggal->format('d M Y') : '',
])->values()->toJson();
@endphp

<!-- KOMPETISI -->
<section class="competition-section" id="lomba">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-subtitle">Lomba Terbaru</span>
            <h2 class="section-title">Daftar Kompetisi</h2>
            <p class="section-description">Pilih kompetisi yang sesuai dengan minat dan bakatmu.</p>
        </div>
        <div class="competition-filters">
            <button class="filter-btn active" data-filter="all"><i class="bi bi-grid-3x3-gap-fill"></i> Semua</button>
            <button class="filter-btn" data-filter="open"><i class="bi bi-unlock-fill"></i> Terbuka</button>
            <button class="filter-btn" data-filter="closed"><i class="bi bi-lock-fill"></i> Ditutup</button>
            <button class="filter-btn" data-filter="coming"><i class="bi bi-clock-fill"></i> Segera</button>
        </div>
        <div class="row g-4 mt-2" id="competitionGrid">
            @forelse($lomba as $item)
                <div class="col-lg-4 col-md-6 competition-item" data-status="{{ $item->status_filter ?? 'open' }}">
                    <div class="competition-card">
                        <div class="competition-header">
                            <div class="competition-pattern"></div>
                            <p class="competition-brand">{{ Str::upper($item->penyelenggara) }}</p>
                        </div>
                        <div class="competition-body">
                            <h4 class="competition-title">{{ $item->nama }}</h4>
                            <p class="competition-category">
                                <i class="bi bi-tag-fill"></i>{{ ucfirst($item->kategori ?? 'Umum') }}
                            </p>
                            <div class="competition-meta">
                                <div class="meta-item"><i class="bi bi-calendar-event"></i><span>{{ $item->tanggal_format }}</span></div>
                                <div class="meta-item"><i class="bi bi-geo-alt-fill"></i><span>{{ $item->lokasi ?? 'Online' }}</span></div>
                            </div>
                            <div class="competition-footer">
                                <div class="status-badge {{ $item->status_class }}">
                                    <i class="bi bi-check-circle-fill"></i>{{ $item->status_label }}
                                </div>
                                <a href="{{ route('lomba.show', $item) }}" class="btn-detail">
                                    Detail <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-trophy" style="font-size:3rem;color:#bbf7d0;"></i>
                    <p class="mt-3" style="color:#94a3b8;">Belum ada lomba yang tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- BLOG -->
<section class="blog-section">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-subtitle">Tips & Artikel</span>
            <h2 class="section-title">Blog Omah Sinau Semar</h2>
            <p class="section-description">Tips, trik, dan panduan untuk membantu kamu sukses dalam kompetisi</p>
        </div>
        <div class="row g-4 mt-2">
            @foreach($blog as $artikel)
                <div class="col-lg-4 col-md-6">
                    <article class="blog-card {{ $artikel->is_featured ? 'featured-post' : '' }}">
                        <div class="blog-image">
                            <img src="{{ $artikel->thumbnail_url }}" alt="{{ $artikel->judul }}"
                                 onerror="this.src='https://placehold.co/400x200/f0fdf4/16a34a?text=Omah+Sinau+Semar'">
                            <div class="blog-category">{{ $artikel->kategori }}</div>
                            @if($artikel->is_featured)
                                <div class="featured-badge"><i class="bi bi-star-fill"></i> Featured</div>
                            @endif
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span><i class="bi bi-calendar3"></i> {{ $artikel->created_at->format('d M Y') }}</span>
                                <span><i class="bi bi-eye"></i> {{ number_format($artikel->views) }} views</span>
                            </div>
                            <h3 class="blog-title">
                                <a href="{{ route('blog.show', $artikel->slug) }}">{{ $artikel->judul }}</a>
                            </h3>
                            <p class="blog-excerpt">{{ $artikel->excerpt }}</p>
                            <a href="{{ route('blog.show', $artikel->slug) }}" class="blog-read-more">
                                Baca Selengkapnya <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('blog.index') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-journal-text"></i> Lihat Semua Artikel
            </a>
        </div>
    </div>
</section>

<!-- PROFIL -->
<section class="profil-section" id="profil">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="profil-image-wrapper">
                    <div class="profil-image-bg"></div>
                    <img src="{{ asset('image/favlogo.png') }}"
                         alt="Founder" class="profil-image">
                </div>
            </div>
            <div class="col-lg-6">
                <span class="section-subtitle">Tentang Kami</span>
                <h2 class="section-title mb-4">Profil Omah Sinau Semar</h2>
                <p class="profil-text">Omah Sinau Semar merupakan platform penyelenggara kompetisi edukatif yang berkomitmen untuk mendukung generasi muda Indonesia dalam mengembangkan potensi dan meraih prestasi terbaiknya.</p>
                <p class="profil-text">Kami percaya bahwa setiap individu memiliki bakat unik yang perlu diasah melalui kompetisi yang berkualitas dan berstandar tinggi.</p>
                <div class="legal-card">
                    <div class="legal-icon-wrapper"><i class="bi bi-file-earmark-text-fill"></i></div>
                    <div class="legal-content">
                        <div class="legal-label">Nomor Legalitas</div>
                        <div class="legal-number">AHU-009094.AH.01.30. Tahun 2025</div>
                    </div>
                    <div class="verified-badge"><i class="bi bi-patch-check-fill"></i></div>
                </div>
                <div class="profil-mission">
                    <div class="visi-box">
                        <h5><i class="bi bi-eye-fill me-2"></i>Visi</h5>
                        <p>Menjadi wadah olimpiade terpercaya yang melahirkan generasi cerdas, berprestasi, dan berkarakter untuk kemajuan bangsa Indonesia.</p>
                    </div>
                    <div class="misi-box">
                        <h5><i class="bi bi-rocket-takeoff-fill me-2"></i>Misi</h5>
                        <ul>
                            <li><i class="bi bi-check-circle-fill"></i>Menyelenggarakan olimpiade berkualitas tinggi di bidang akademik dan seni untuk jenjang TK, SD, dan SMP</li>
                            <li><i class="bi bi-check-circle-fill"></i>Memfasilitasi setiap peserta untuk mengembangkan potensi terbaik mereka melalui kompetisi yang adil dan transparan</li>
                            <li><i class="bi bi-check-circle-fill"></i>Membangun ekosistem pendidikan kompetitif yang mendorong semangat belajar sejak dini</li>
                            <li><i class="bi bi-check-circle-fill"></i>Memberikan pengakuan dan apresiasi nyata kepada generasi muda berprestasi di seluruh Indonesia</li>
                            <li><i class="bi bi-check-circle-fill"></i>Bersinergi dengan sekolah dan guru pembimbing dalam mencetak juara masa depan bangsa</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- KONTAK -->
<section class="kontak-section" id="kontak">
    <div class="container">
        <div class="row align-items-start g-5">
            <div class="col-lg-6">
                <span class="section-subtitle">Get In Touch</span>
                <h2 class="section-title mb-3">Kontak Kami</h2>
                <p class="kontak-description">Punya pertanyaan atau ingin berkolaborasi? Jangan ragu untuk menghubungi kami.</p>
                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-icon"><i class="bi bi-geo-alt-fill"></i></div>
                        <div>
                            <div class="contact-label">Alamat</div>
                            <div class="contact-value">Jl. Kalisetail Genteng Banyuwangi</div>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon"><i class="bi bi-envelope-fill"></i></div>
                        <div>
                            <div class="contact-label">Email</div>
                            <div class="contact-value">omahsinausemar@gmail.com</div>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon"><i class="bi bi-telephone-fill"></i></div>
                        <div>
                            <div class="contact-label">Telepon - Timotius Purno Ribowo</div>
                            <div class="contact-value">
                                +62 812-4658-8802<br>
                                +62 812-4658-8801<br>
                                +62 857-9105-8802
                            </div>
                        </div>
                    </div>
                </div>
                <div class="social-links">
                    <a href="https://wa.me/6281246588802" class="social-link whatsapp" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    <a href="#" class="social-link instagram" title="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-link youtube" title="YouTube"><i class="bi bi-youtube"></i></a>
                    <a href="mailto:omahsinausemar@gmail.com" class="social-link email" title="Email"><i class="bi bi-envelope-fill"></i></a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="contact-form-wrapper">
                    @if(session('success'))
                        <div class="alert-success-custom">
                            <i class="bi bi-check-circle-fill"></i>{{ session('success') }}
                        </div>
                    @endif
                    <form action="#" method="POST" onsubmit="return false;">
                        @csrf
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama Anda" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
                        </div>
                        <div class="form-group">
                            <label>Subjek</label>
                            <input type="text" name="subjek" class="form-control" placeholder="Topik pesan Anda" required>
                        </div>
                        <div class="form-group">
                            <label>Pesan</label>
                            <textarea class="form-control" name="pesan" rows="5" placeholder="Tulis pesan Anda di sini..." required></textarea>
                        </div>
                        <button type="submit" class="btn-primary-full">
                            <i class="bi bi-send-fill"></i> Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="footer-brand">
                    <i class="bi bi-trophy-fill"></i>
                    <h3>Omah Sinau Semar</h3>
                </div>
                <p class="footer-description">Platform kompetisi edukatif terpercaya untuk generasi muda Indonesia.</p>
            </div>
            <div class="col-lg-2 col-md-4">
                <h4 class="footer-title">Menu</h4>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="#lomba">Lomba</a></li>
                    <li><a href="{{ route('blog.index') }}">Blog</a></li>
                    <li><a href="#profil">Profil</a></li>
                    <li><a href="#kontak">Kontak</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4">
                <h4 class="footer-title">Kategori Lomba</h4>
                <ul class="footer-links">
                    <li><a href="#">Akademik</a></li>
                    <li><a href="#">Seni & Budaya</a></li>
                    <li><a href="#">Olahraga</a></li>
                    <li><a href="#">Teknologi</a></li>
                </ul>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="footer-bottom">
            <p class="copyright">2026 Omah Sinau Semar. All Rights Reserved.</p>
        </div>
    </div>
</footer>

@endsection

@push('scripts')
<script>
const photos = {!! $galeriJson !!};
let current = 0;
function openLightbox(index) {
    current = index; updateLightbox();
    document.getElementById('lightbox').classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    document.getElementById('lightbox').classList.remove('active');
    document.body.style.overflow = '';
}
function prevPhoto() { current = (current - 1 + photos.length) % photos.length; updateLightbox(); }
function nextPhoto() { current = (current + 1) % photos.length; updateLightbox(); }
function updateLightbox() {
    const p = photos[current];
    const img = document.getElementById('lightboxImg');
    img.style.opacity = 0;
    setTimeout(() => { img.src = p.src; img.onload = () => { img.style.opacity = 1; }; }, 150);
    document.getElementById('lightboxTitle').textContent = p.judul;
    document.getElementById('lightboxDate').textContent  = p.tgl;
    document.getElementById('lightboxCurrent').textContent = current + 1;
    document.getElementById('lightboxTotal').textContent   = photos.length;
}
document.addEventListener('keydown', e => {
    if (!document.getElementById('lightbox').classList.contains('active')) return;
    if (e.key === 'ArrowLeft')  prevPhoto();
    if (e.key === 'ArrowRight') nextPhoto();
    if (e.key === 'Escape')     closeLightbox();
});
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const filter = this.getAttribute('data-filter');
        document.querySelectorAll('.competition-item').forEach(item => {
            item.style.display = (filter === 'all' || item.getAttribute('data-status') === filter) ? 'block' : 'none';
        });
    });
});
</script>
@endpush