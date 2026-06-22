<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AgroGestor | Gestión Ganadera Inteligente</title>
    <meta name="description" content="Software ganadero para control de ganado, producción de leche y gestión de fincas. Tecnología moderna para el campo.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-primary: #0a0f0a;
            --bg-secondary: #111811;
            --bg-card: #1a211a;
            --accent-primary: #22c55e;
            --accent-secondary: #16a34a;
            --accent-glow: rgba(34, 197, 94, 0.3);
            --text-primary: #ffffff;
            --text-secondary: #a1a1aa;
            --text-muted: #71717a;
            --border: rgba(255, 255, 255, 0.1);
            --gradient-hero: linear-gradient(135deg, #0a0f0a 0%, #1a2e1a 100%);
            --gradient-accent: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            --gradient-glow: radial-gradient(circle at 50% 50%, rgba(34, 197, 94, 0.15) 0%, transparent 70%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            overflow-x: hidden;
        }

        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(10, 15, 10, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.25rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: var(--text-primary);
            font-weight: 700;
            font-size: 1.25rem;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: var(--gradient-accent);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.2rem;
            font-weight: 800;
            line-height: 1;
            box-shadow: 0 10px 24px rgba(34, 197, 94, 0.28);
        }

        .nav-links {
            display: flex;
            gap: 2.5rem;
            list-style: none;
        }

        .nav-links a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-links a:hover {
            color: var(--text-primary);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent-primary);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .nav-cta {
            padding: 0.6rem 1.25rem;
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-primary);
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-cta:hover {
            background: var(--bg-card);
            border-color: var(--accent-primary);
        }

        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 8rem 2rem 4rem;
            background: var(--gradient-hero);
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--gradient-glow);
            pointer-events: none;
        }

        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(34, 197, 94, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(34, 197, 94, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            pointer-events: none;
        }

        .hero-content {
            max-width: 900px;
            text-align: center;
            position: relative;
            z-index: 10;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.2);
            border-radius: 50px;
            font-size: 0.875rem;
            color: var(--accent-primary);
            margin-bottom: 2rem;
            font-weight: 500;
        }

        .hero h1 {
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
        }

        .hero h1 span {
            background: var(--gradient-accent);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-description {
            font-size: 1.25rem;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto 2.5rem;
            line-height: 1.7;
        }

        .hero-description strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-bottom: 4rem;
        }

        .btn-primary {
            padding: 1rem 2rem;
            background: var(--gradient-accent);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(34, 197, 94, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(34, 197, 94, 0.4);
        }

        .btn-secondary {
            padding: 1rem 2rem;
            background: var(--bg-card);
            color: var(--text-primary);
            border: 1px solid var(--border);
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .hero-visual {
            position: relative;
            max-width: 1000px;
            margin: 0 auto;
        }

        .dashboard-mockup {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 1.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(34, 197, 94, 0.1);
            position: relative;
            overflow: hidden;
        }

        .dashboard-mockup::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--accent-primary), transparent);
            opacity: 0.5;
        }

        .mockup-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }

        .mockup-title {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .mockup-dots {
            display: flex;
            gap: 0.5rem;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--bg-primary);
            border: 1px solid var(--border);
        }

        .dot.red { background: #ef4444; border-color: #ef4444; }
        .dot.yellow { background: #f59e0b; border-color: #f59e0b; }
        .dot.green { background: #22c55e; border-color: #22c55e; }

        .mockup-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }

        .mockup-card {
            background: var(--bg-primary);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.25rem;
            transition: all 0.3s ease;
        }

        .mockup-card:hover {
            border-color: rgba(34, 197, 94, 0.3);
            transform: translateY(-2px);
        }

        .mockup-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .mockup-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .mockup-trend {
            font-size: 0.875rem;
            color: var(--accent-primary);
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .mockup-trend.negative {
            color: #ef4444;
        }

        section {
            padding: 6rem 2rem;
            position: relative;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 4rem;
        }

        .section-tag {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.2);
            border-radius: 50px;
            color: var(--accent-primary);
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }

        .section-subtitle {
            color: var(--text-secondary);
            font-size: 1.125rem;
            line-height: 1.7;
        }

        .about {
            background: var(--bg-secondary);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .about-text h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .about-text p {
            color: var(--text-secondary);
            font-size: 1.125rem;
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }

        .about-text strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .about-features {
            list-style: none;
            margin-top: 2rem;
        }

        .about-features li {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            color: var(--text-secondary);
        }

        .about-features i {
            color: var(--accent-primary);
            font-size: 1.25rem;
        }

        .about-visual {
            position: relative;
        }

        .about-image {
            width: 100%;
            height: 400px;
            background: linear-gradient(135deg, #1a2e1a 0%, #0f1f0f 100%);
            border-radius: 24px;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .about-image::before {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: var(--gradient-glow);
            border-radius: 50%;
            filter: blur(60px);
        }

        .about-image i {
            font-size: 6rem;
            color: var(--accent-primary);
            opacity: 0.3;
            position: relative;
            z-index: 1;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .feature-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--gradient-accent);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            border-color: rgba(34, 197, 94, 0.3);
            transform: translateY(-4px);
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-icon {
            width: 56px;
            height: 56px;
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--accent-primary);
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            background: rgba(34, 197, 94, 0.2);
            transform: scale(1.1);
        }

        .feature-card h3 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .feature-card p {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .stats {
            background: var(--bg-secondary);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            text-align: center;
        }

        .stat-item {
            padding: 2rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            background: var(--gradient-accent);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: block;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .stat-desc {
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .pricing {
            background: var(--bg-secondary);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .pricing-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 2rem;
            position: relative;
            transition: all 0.3s ease;
        }

        .pricing-card:hover {
            transform: translateY(-4px);
            border-color: rgba(34, 197, 94, 0.28);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.25);
        }

        .pricing-card.featured {
            border-color: rgba(34, 197, 94, 0.35);
            box-shadow: 0 18px 45px rgba(34, 197, 94, 0.12);
        }

        .plan-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.45rem 0.85rem;
            border-radius: 999px;
            font-size: 0.82rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
        }

        .plan-badge.basic {
            background: rgba(34, 197, 94, 0.12);
            color: #4ade80;
            border: 1px solid rgba(74, 222, 128, 0.18);
        }

        .plan-badge.pro {
            background: rgba(59, 130, 246, 0.12);
            color: #60a5fa;
            border: 1px solid rgba(96, 165, 250, 0.18);
        }

        .plan-badge.premium {
            background: rgba(168, 85, 247, 0.12);
            color: #c084fc;
            border: 1px solid rgba(192, 132, 252, 0.18);
        }

        .plan-name {
            font-size: 1.6rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .plan-subtitle {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }

        .plan-price {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 0.25rem;
        }

        .plan-price span {
            font-size: 1rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .plan-section-title {
            margin-top: 1.6rem;
            margin-bottom: 0.9rem;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .plan-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }

        .plan-list li {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            color: var(--text-secondary);
            font-size: 0.94rem;
            line-height: 1.6;
        }

        .plan-list i {
            color: var(--accent-primary);
            margin-top: 0.15rem;
        }

        .plan-action {
            margin-top: 1.75rem;
        }

        .plan-button {
            width: 100%;
            justify-content: center;
        }

        .testimonial-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2rem;
            position: relative;
        }

        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: 1rem;
            right: 1.5rem;
            font-size: 4rem;
            color: var(--accent-primary);
            opacity: 0.2;
            font-family: Georgia, serif;
            line-height: 1;
        }

        .testimonial-text {
            color: var(--text-secondary);
            line-height: 1.7;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            position: relative;
            z-index: 1;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .author-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--gradient-accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 1.1rem;
        }

        .author-info h4 {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .author-info p {
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        .cta {
            text-align: center;
            background: var(--gradient-hero);
            position: relative;
        }

        .cta::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--gradient-glow);
        }

        .cta-content {
            position: relative;
            z-index: 1;
            max-width: 700px;
            margin: 0 auto;
        }

        .cta h2 {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .cta p {
            color: var(--text-secondary);
            font-size: 1.125rem;
            margin-bottom: 2rem;
        }

        footer {
            background: var(--bg-primary);
            border-top: 1px solid var(--border);
            padding: 3rem 2rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--text-primary);
            font-weight: 700;
            text-decoration: none;
        }

        .footer-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--text-primary);
        }

        .footer-copy {
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @media (max-width: 968px) {
            .nav-links {
                display: none;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .about-grid {
                grid-template-columns: 1fr;
            }

            .mockup-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .testimonials-grid {
                grid-template-columns: 1fr;
            }

            .pricing-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .hero-buttons {
                flex-direction: column;
                width: 100%;
            }

            .btn-primary, .btn-secondary {
                width: 100%;
                justify-content: center;
            }

            .mockup-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .footer-content {
                flex-direction: column;
                gap: 1.5rem;
                text-align: center;
            }
        }

        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-primary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--bg-card);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent-secondary);
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-container">
            <a href="{{ url('/') }}" class="logo">
                <div class="logo-icon">A</div>
                AgroGestor
            </a>

            <ul class="nav-links">
                <li><a href="#sobre">Sobre Nosotros</a></li>
                <li><a href="#funcionalidades">Funcionalidades</a></li>
                <li><a href="#opiniones">Opiniones</a></li>
                <li><a href="#membresias">Membresías</a></li>
                <li><a href="#faq">FAQ</a></li>
            </ul>

            <a href="{{ route('login') }}" class="nav-cta">Iniciar Sesión</a>
        </div>
    </nav>

    <section class="hero">
        <div>
            <div class="hero-content">
                <div class="hero-badge">
                    <i class="fa-solid fa-bolt"></i>
                    Plataforma moderna para fincas productivas
                </div>

                <h1>
                    Controla y automatiza tu<br>
                    <span>finca ganadera</span>
                </h1>

                <p class="hero-description">
                    Gestiona ganado, producción de leche y ventas con inteligencia.
                    <strong>AgroGestor</strong> es la plataforma integral diseñada para revolucionar
                    la gestión ganadera con tecnología moderna y accesible.
                </p>

                <div class="hero-buttons">
                    <a href="{{ route('login') }}" class="btn-primary">
                        <i class="fa-solid fa-rocket"></i>
                        Comenzar ahora
                    </a>
                    <a href="#funcionalidades" class="btn-secondary">
                        <i class="fa-solid fa-play"></i>
                        Ver demo
                    </a>
                </div>
            </div>

            <div class="hero-visual animate-float" style="margin-top: 3rem; width: 100%; max-width: 900px;">
                <div class="dashboard-mockup">
                    <div class="mockup-header">
                        <span class="mockup-title">Dashboard Principal</span>
                        <div class="mockup-dots">
                            <span class="dot red"></span>
                            <span class="dot yellow"></span>
                            <span class="dot green"></span>
                        </div>
                    </div>

                    <div class="mockup-grid">
                        <div class="mockup-card">
                            <div class="mockup-label">Ganado Activo</div>
                            <div class="mockup-value">247</div>
                            <div class="mockup-trend">
                                <i class="fa-solid fa-arrow-up"></i> +12 este mes
                            </div>
                        </div>

                        <div class="mockup-card">
                            <div class="mockup-label">Producción Hoy</div>
                            <div class="mockup-value">1,248 L</div>
                            <div class="mockup-trend">
                                <i class="fa-solid fa-arrow-up"></i> +5.3%
                            </div>
                        </div>

                        <div class="mockup-card">
                            <div class="mockup-label">Clientes</div>
                            <div class="mockup-value">45</div>
                            <div class="mockup-trend">
                                <i class="fa-solid fa-arrow-up"></i> +3 nuevos
                            </div>
                        </div>

                        <div class="mockup-card">
                            <div class="mockup-label">Ventas Mes</div>
                            <div class="mockup-value">$12.4M</div>
                            <div class="mockup-trend negative">
                                <i class="fa-solid fa-arrow-down"></i> -2.1%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="sobre" class="about">
        <div class="container">
            <div class="about-grid">
                <div class="about-text">
                    <span class="section-tag">Sobre Nosotros</span>
                    <h2>Tecnología que nace del campo</h2>
                    <p>
                        <strong>AgroGestor</strong> es una plataforma integral diseñada para revolucionar
                        la gestión ganadera mediante tecnología moderna y accesible. Simplificamos
                        la administración de ganado, producción de leche y operaciones diarias.
                    </p>
                    <p>
                        Nuestra solución integra automatización inteligente, análisis de datos en
                        tiempo real y gestión centralizada para optimizar cada aspecto de tu operación.
                    </p>

                    <ul class="about-features">
                        <li>
                            <i class="fa-solid fa-check-circle"></i>
                            <span>Acceso multiplataforma: web, tablet y móvil</span>
                        </li>
                        <li>
                            <i class="fa-solid fa-check-circle"></i>
                            <span>Reportes detallados exportables a Excel/PDF</span>
                        </li>
                        <li>
                            <i class="fa-solid fa-check-circle"></i>
                            <span>Soporte técnico especializado 24/7</span>
                        </li>
                        <li>
                            <i class="fa-solid fa-check-circle"></i>
                            <span>Respaldo automático en la nube</span>
                        </li>
                    </ul>
                </div>

                <div class="about-visual">
                    <div class="about-image">
                        <i class="fa-solid fa-cow"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="funcionalidades">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Funcionalidades</span>
                <h2 class="section-title">Herramientas potentes para tu finca</h2>
                <p class="section-subtitle">
                    Descubre cómo AgroGestor está transformando la gestión ganadera
                    de miles de productores.
                </p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-cow"></i>
                    </div>
                    <h3>Control de Ganado</h3>
                    <p>Registro completo de animales: aretes, raza, edad, estado reproductivo y historial de salud. Trazabilidad total.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-glass-water"></i>
                    </div>
                    <h3>Producción de Leche</h3>
                    <p>Control diario por turno, análisis de calidad, temperatura y seguimiento de producción por vaca.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-syringe"></i>
                    </div>
                    <h3>Salud y Sanidad</h3>
                    <p>Calendario de vacunación, tratamientos, registros veterinarios y alertas de eventos sanitarios.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h3>Gestión de Clientes</h3>
                    <p>Base de datos de compradores, historial de ventas, pagos pendientes y comunicaciones integradas.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                    <h3>Reportes Inteligentes</h3>
                    <p>Análisis de rentabilidad, proyecciones de producción y comparativas por períodos personalizables.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-mobile-screen"></i>
                    </div>
                    <h3>App Móvil</h3>
                    <p>Registra datos desde el campo sin conexión. Sincronización automática cuando hay wifi o datos.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="ventajas" class="stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-number">-40%</span>
                    <span class="stat-label">Tiempo admin</span>
                    <p class="stat-desc">Automatización de tareas repetitivas</p>
                </div>
                <div class="stat-item">
                    <span class="stat-number">+35%</span>
                    <span class="stat-label">Eficiencia</span>
                    <p class="stat-desc">Mejor control = más producción</p>
                </div>
                <div class="stat-item">
                    <span class="stat-number">24/7</span>
                    <span class="stat-label">Disponible</span>
                    <p class="stat-desc">Acceso desde cualquier lugar</p>
                </div>
                <div class="stat-item">
                    <span class="stat-number">100%</span>
                    <span class="stat-label">Trazable</span>
                    <p class="stat-desc">Cumplimiento normativo total</p>
                </div>
            </div>
        </div>
    </section>

    <section id="opiniones">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Opiniones</span>
                <h2 class="section-title">Lo que dicen los ganaderos</h2>
            </div>

            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <p class="testimonial-text">
                        "Con AgroGestor dejamos de improvisar. Ahora el control de ganado y la
                        producción de leche se sienten mucho más organizados. La interfaz es
                        tan intuitiva que hasta mi padre la usa sin problemas."
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar">CM</div>
                        <div class="author-info">
                            <h4>Carlos Muñoz</h4>
                            <p>Administrador de finca, Antioquia</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <p class="testimonial-text">
                        "Lo mejor es que todo se ve claro. Clientes, ventas y registros están
                        conectados. Antes usábamos 3 apps diferentes, ahora todo está aquí.
                        El soporte técnico responde rápido."
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar">AP</div>
                        <div class="author-info">
                            <h4>Andrea Pardo</h4>
                            <p>Administrador de finca, Valle</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <p class="testimonial-text">
                        "Se siente moderno, pero sigue siendo práctico. Eso ayuda mucho cuando
                        uno necesita un software útil y no solo bonito. Los reportes me han
                        ayudado a tomar mejores decisiones."
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar">JS</div>
                        <div class="author-info">
                            <h4>Jhon Sierra</h4>
                            <p>Administrador de finca, Magdalena</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="membresias" class="pricing">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Membresías</span>
                <h2 class="section-title">Planes de Suscripción AgroGestor</h2>
                <p class="section-subtitle">
                    Elige el plan que mejor se adapte al tamaño de tu finca y al nivel de control
                    que necesitas para tu operación ganadera.
                </p>
            </div>

            <div class="pricing-grid">
                <article class="pricing-card">
                    <div class="plan-badge basic">
                        <i class="fa-solid fa-leaf"></i>
                        Plan Básico
                    </div>
                    <h3 class="plan-name">Productor</h3>
                    <p class="plan-subtitle">Para fincas pequeñas que empiezan a digitalizarse.</p>
                    <div class="plan-price">$19.900 COP <span>/ mes</span></div>

                    <p class="plan-section-title">Incluye</p>
                    <ul class="plan-list">
                        <li><i class="fa-solid fa-check"></i><span>Registro de animales</span></li>
                        <li><i class="fa-solid fa-check"></i><span>Control de razas y tipos de ganado</span></li>
                        <li><i class="fa-solid fa-check"></i><span>Registro de producción de leche</span></li>
                        <li><i class="fa-solid fa-check"></i><span>Gestión básica de clientes</span></li>
                        <li><i class="fa-solid fa-check"></i><span>Historial de ventas</span></li>
                        <li><i class="fa-solid fa-check"></i><span>Panel con estadísticas simples</span></li>
                        <li><i class="fa-solid fa-check"></i><span>Soporte por email</span></li>
                    </ul>

                    <p class="plan-section-title">Límites</p>
                    <ul class="plan-list">
                        <li><i class="fa-solid fa-minus"></i><span>Hasta 50 animales</span></li>
                        <li><i class="fa-solid fa-minus"></i><span>1 usuario</span></li>
                        <li><i class="fa-solid fa-minus"></i><span>Reportes básicos</span></li>
                    </ul>

                    <div class="plan-action">
                        <a href="{{ route('login') }}" class="btn-primary plan-button">
                            Obtener
                        </a>
                    </div>
                </article>

                <article class="pricing-card featured">
                    <div class="plan-badge pro">
                        <i class="fa-solid fa-chart-line"></i>
                        Plan Profesional
                    </div>
                    <h3 class="plan-name">Ganadero</h3>
                    <p class="plan-subtitle">Para fincas medianas con control más completo.</p>
                    <div class="plan-price">$39.900 COP <span>/ mes</span></div>

                    <p class="plan-section-title">Incluye todo lo del Básico +</p>
                    <ul class="plan-list">
                        <li><i class="fa-solid fa-check"></i><span>Animales ilimitados</span></li>
                        <li><i class="fa-solid fa-check"></i><span>Control de ventas avanzado de leche y ganado</span></li>
                        <li><i class="fa-solid fa-check"></i><span>Reportes descargables en PDF y Excel</span></li>
                        <li><i class="fa-solid fa-check"></i><span>Gestión completa de clientes</span></li>
                        <li><i class="fa-solid fa-check"></i><span>Registro de partos y estado del ganado</span></li>
                        <li><i class="fa-solid fa-check"></i><span>Historial de producción por animal</span></li>
                        <li><i class="fa-solid fa-check"></i><span>Dashboard con gráficas</span></li>
                        <li><i class="fa-solid fa-check"></i><span>Soporte prioritario</span></li>
                    </ul>

                    <p class="plan-section-title">Límites</p>
                    <ul class="plan-list">
                        <li><i class="fa-solid fa-minus"></i><span>Hasta 3 usuarios</span></li>
                        <li><i class="fa-solid fa-minus"></i><span>Reportes avanzados</span></li>
                    </ul>

                    <div class="plan-action">
                        <a href="{{ route('login') }}" class="btn-primary plan-button">
                            Obtener
                        </a>
                    </div>
                </article>

                <article class="pricing-card">
                    <div class="plan-badge premium">
                        <i class="fa-solid fa-crown"></i>
                        Plan Premium
                    </div>
                    <h3 class="plan-name">Empresarial</h3>
                    <p class="plan-subtitle">Para fincas grandes o empresas ganaderas.</p>
                    <div class="plan-price">$69.900 COP <span>/ mes</span></div>

                    <p class="plan-section-title">Incluye todo lo del Profesional +</p>
                    <ul class="plan-list">
                        <li><i class="fa-solid fa-check"></i><span>Usuarios ilimitados</span></li>
                        <li><i class="fa-solid fa-check"></i><span>Módulo financiero con ingresos y gastos</span></li>
                        <li><i class="fa-solid fa-check"></i><span>Alertas automáticas de parto, producción baja y más</span></li>
                        <li><i class="fa-solid fa-check"></i><span>Backup automático</span></li>
                        <li><i class="fa-solid fa-check"></i><span>Acceso desde múltiples dispositivos</span></li>
                        <li><i class="fa-solid fa-check"></i><span>Reportes inteligentes sobre rendimiento del ganado</span></li>
                        <li><i class="fa-solid fa-check"></i><span>Soporte prioritario por WhatsApp</span></li>
                    </ul>

                    <div class="plan-action">
                        <a href="{{ route('login') }}" class="btn-primary plan-button">
                            Obtener
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="cta">
        <div class="container">
            <div class="cta-content">
                <h2>¿Listo para llevar tu finca al siguiente nivel?</h2>
                <p>
                    Únete a miles de ganaderos que ya están transformando su gestión.
                    Empieza hoy gratis y descubre cómo la tecnología puede maximizar tu productividad.
                </p>
                <div class="hero-buttons" style="justify-content: center;">
                    <a href="{{ route('login') }}" class="btn-primary">
                        <i class="fa-solid fa-user-plus"></i>
                        Crear cuenta gratis
                    </a>
                    <a href="{{ route('login') }}" class="btn-secondary">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        Iniciar sesión
                    </a>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <a href="{{ url('/') }}" class="footer-brand">
                <div class="logo-icon" style="width: 32px; height: 32px; border-radius: 8px; font-size: 1rem;">A</div>
                AgroGestor
            </a>

            <ul class="footer-links">
                <li><a href="#sobre">Sobre Nosotros</a></li>
                <li><a href="#funcionalidades">Funcionalidades</a></li>
                <li><a href="#membresias">Membresías</a></li>
                <li><a href="#faq">FAQ</a></li>
            </ul>

            <span class="footer-copy">© 2026 AgroGestor. Todos los derechos reservados.</span>
        </div>
    </footer>

    <script>
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.style.background = 'rgba(10, 15, 10, 0.95)';
            } else {
                nav.style.background = 'rgba(10, 15, 10, 0.8)';
            }
        });

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
