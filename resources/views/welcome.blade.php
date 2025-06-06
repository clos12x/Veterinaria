<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veterinaria Huellitas</title>
    <style>
        /* Reset and base */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        :root {
            --primary: #ff6b35;
            --secondary: #f7c59f;
            --accent: #ef476f;
            --dark: #292f36;
            --light: #f8f9fa;
            --success: #06d6a0;
            --warning: #ffd166;
            
            /* Dark mode variables */
            --bg-dark: #1a1a2e;
            --text-dark: #f8f9fa;
            --card-dark: #16213e;
            --header-dark: #0f3460;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
            scroll-behavior: smooth;
            transition: background-color 0.5s ease, color 0.5s ease;
        }
        
        body.dark-mode {
            background-color: var(--bg-dark);
            color: var(--text-dark);
        }
        
        a {
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        /* Premium Navbar */
        header {
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            color: white;
            padding: 1.25rem 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1100;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        body.dark-mode header {
            background: linear-gradient(135deg, var(--header-dark) 0%, var(--primary) 100%);
        }
        
        header.scrolled {
            padding: 0.75rem 3rem;
            background: rgba(41, 47, 54, 0.95);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }
        
        body.dark-mode header.scrolled {
            background: rgba(15, 52, 96, 0.95);
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        header h1 {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            background: linear-gradient(to right, white 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            user-select: none;
        }
        
        .logo-icon {
            font-size: 2rem;
            color: var(--secondary);
        }
        
        /* Dark mode toggle */
        .dark-mode-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            margin-left: 1rem;
            transition: transform 0.3s ease;
        }
        
        .dark-mode-toggle:hover {
            transform: scale(1.1);
        }
        
        /* Premium Search Bar */
        .search-container {
            position: relative;
            margin: 0 2rem;
            flex-grow: 1;
            max-width: 500px;
        }
        
        .search-container input {
            width: 100%;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            border: none;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(5px);
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
            padding-left: 3rem;
        }
        
        .search-container input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .search-container input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 0 0 2px var(--secondary);
        }
        
        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: white;
        }
        
        /* Premium Navigation - Manteniendo los botones ORIGINALES */
        nav {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            font-weight: 500;
            font-size: 1rem;
            user-select: none;
        }
        
        nav a {
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        nav a:not(.button-login):not(.button-register):hover,
        nav a:not(.button-login):not(.button-register):focus-visible {
            color: var(--secondary);
        }
        
        nav a:not(.button-login):not(.button-register)::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--secondary);
            transition: width 0.3s ease;
        }
        
        nav a:not(.button-login):not(.button-register):hover::after,
        nav a:not(.button-login):not(.button-register):focus-visible::after {
            width: 100%;
        }
        
        /* Botones ORIGINALES (exactamente como en el código que me pasaste) */
        .button-login {
            background-color: #f59e0b;
            color: black;
            font-weight: 700;
            padding: 0.75rem 1.75rem;
            border-radius: 30px;
            text-transform: uppercase;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.5);
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
            user-select: none;
        }
        
        .button-login:hover,
        .button-login:focus-visible {
            background-color: #f97316;
            transform: scale(1.1);
            box-shadow: 0 8px 20px rgba(249, 115, 22, 0.7);
            outline-offset: 4px;
            outline: 2px solid #f97316;
            color: black;
            z-index: 10;
        }
        
        .button-register {
            background-color: #ff7f47;
            color: white;
            font-weight: 700;
            padding: 0.75rem 1.75rem;
            border-radius: 30px;
            text-transform: uppercase;
            box-shadow: 0 4px 12px rgba(255, 127, 71, 0.5);
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
            user-select: none;
        }
        
        .button-register:hover,
        .button-register:focus-visible {
            background-color: #f59e0b;
            transform: scale(1.1);
            box-shadow: 0 8px 20px rgba(245, 158, 11, 0.7);
            outline-offset: 4px;
            outline: 2px solid #f59e0b;
            color: black;
            z-index: 10;
        }
        
        /* Premium Hero Section */
        .hero-section {
            height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url('https://storage.googleapis.com/a1aa/image/cca971e9-c0f8-4654-801a-679ea2e9f18d.jpg') no-repeat center center/cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
            padding: 0 1rem;
            user-select: none;
            animation: fadeIn 1.5s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .hero-content {
            max-width: 900px;
            padding: 2rem;
            background: rgba(41, 47, 54, 0.7);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            transform-style: preserve-3d;
            transform: perspective(1000px);
        }
        
        body.dark-mode .hero-content {
            background: rgba(22, 33, 62, 0.7);
        }
        
        .hero-section h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            background: linear-gradient(to right, var(--secondary) 0%, white 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .hero-section p {
            font-size: clamp(1.25rem, 2vw, 1.5rem);
            margin-bottom: 2.5rem;
            max-width: 700px;
            font-weight: 400;
            opacity: 0.9;
        }
        
        .cta-button {
            background-color: var(--primary);
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 8px;
            color: white;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.4);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: 2px solid transparent;
        }
        
        .cta-button:hover,
        .cta-button:focus-visible {
            background-color: transparent;
            color: var(--primary);
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.6);
            border-color: var(--primary);
            transform: translateY(-3px);
        }
        
        .cta-button i {
            font-size: 1.2rem;
        }
        
        /* Premium Services Section */
        .services-section {
            max-width: 1400px;
            margin: 6rem auto;
            padding: 0 2rem;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }
        
        .section-header h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }
        
        body.dark-mode .section-header h2 {
            color: var(--text-dark);
        }
        
        .section-header h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--primary);
            border-radius: 2px;
        }
        
        .section-header p {
            font-size: 1.1rem;
            color: #6c757d;
            max-width: 700px;
            margin: 0 auto;
        }
        
        body.dark-mode .section-header p {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .service-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            z-index: 1;
        }
        
        body.dark-mode .service-card {
            background: var(--card-dark);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }
        
        body.dark-mode .service-card:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }
        
        .service-card:hover::before {
            opacity: 0.1;
        }
        
        .service-card:hover .service-img {
            transform: scale(1.05);
        }
        
        .service-img-container {
            height: 220px;
            overflow: hidden;
        }
        
        .service-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .service-content {
            padding: 1.5rem;
        }
        
        .service-content h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: var(--dark);
        }
        
        body.dark-mode .service-content h3 {
            color: var(--text-dark);
        }
        
        .service-content p {
            color: #6c757d;
            margin-bottom: 1.5rem;
        }
        
        body.dark-mode .service-content p {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .service-link {
            display: inline-flex;
            align-items: center;
            color: var(--primary);
            font-weight: 500;
            gap: 0.5rem;
        }
        
        .service-link i {
            transition: transform 0.3s ease;
        }
        
        .service-card:hover .service-link i {
            transform: translateX(5px);
        }
        
        /* Premium Contact Section */
        .contact-section {
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            padding: 6rem 2rem;
            text-align: center;
            color: white;
            margin: 6rem 0;
            position: relative;
            overflow: hidden;
        }
        
        body.dark-mode .contact-section {
            background: linear-gradient(135deg, var(--header-dark) 0%, var(--primary) 100%);
        }
        
        .contact-section::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }
        
        .contact-section::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }
        
        .contact-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        
        .contact-content h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .contact-content p {
            font-size: 1.25rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
        }
        
        .contact-button {
            background-color: white;
            color: var(--primary);
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: 2px solid transparent;
        }
        
        .contact-button:hover,
        .contact-button:focus-visible {
            background-color: transparent;
            color: white;
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.2);
            border-color: white;
            transform: translateY(-3px);
        }
        
        /* Premium Features Section */
        .features-section {
            max-width: 1200px;
            margin: 6rem auto;
            padding: 0 2rem;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        
        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: all 0.3s ease;
        }
        
        body.dark-mode .feature-card {
            background: var(--card-dark);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }
        
        body.dark-mode .feature-card:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }
        
        .feature-icon {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }
        
        .feature-card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark);
        }
        
        body.dark-mode .feature-card h3 {
            color: var(--text-dark);
        }
        
        .feature-card p {
            color: #6c757d;
        }
        
        body.dark-mode .feature-card p {
            color: rgba(255, 255, 255, 0.7);
        }
        
        /* Premium Counter Section */
        .counter-section {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--warning) 100%);
            padding: 3rem 2rem;
            margin: 6rem 0;
            text-align: center;
            color: var(--dark);
        }
        
        .counter-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        body.dark-mode .counter-container {
            background: var(--card-dark);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .counter-container h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        body.dark-mode .counter-container h3 {
            color: var(--text-dark);
        }
        
        .counter-value {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary);
            margin: 1rem 0;
        }
        
        .counter-description {
            color: #6c757d;
        }
        
        body.dark-mode .counter-description {
            color: rgba(255, 255, 255, 0.7);
        }
        
        /* Premium Footer */
        footer {
            background-color: var(--dark);
            color: white;
            padding: 4rem 2rem 2rem;
        }
        
        body.dark-mode footer {
            background-color: var(--header-dark);
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
        }
        
        .footer-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .footer-logo h3 {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(to right, var(--secondary) 0%, white 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .footer-about p {
            opacity: 0.8;
            margin-bottom: 1.5rem;
            line-height: 1.7;
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
        }
        
        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }
        
        .footer-links h4 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }
        
        .footer-links h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--primary);
        }
        
        .footer-links ul {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 0.75rem;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .footer-links a:hover {
            color: var(--secondary);
            padding-left: 5px;
        }
        
        .footer-links i {
            font-size: 0.8rem;
        }
        
        .footer-contact p {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            opacity: 0.8;
        }
        
        .footer-contact i {
            color: var(--secondary);
            font-size: 1.2rem;
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 3rem;
            margin-top: 3rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0.8;
            font-size: 0.9rem;
        }
        
        /* Premium Visit Counter */
        .visit-counter {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.4);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        /* Responsive Design */
        @media (max-width: 1024px) {
            header {
                padding: 1rem 2rem;
            }
            .search-container {
                margin: 0 1rem;
            }
            nav {
                gap: 1rem;
            }
        }
        
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                padding: 1rem;
                position: relative;
            }
            .logo-container {
                margin-bottom: 1rem;
            }
            .search-container {
                margin: 1rem 0;
                width: 100%;
                max-width: 100%;
            }
            nav {
                flex-wrap: wrap;
                justify-content: center;
                width: 100%;
            }
            .hero-content {
                padding: 1.5rem;
            }
            .services-grid {
                grid-template-columns: 1fr;
            }
            .footer-container {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 480px) {
            .hero-section h1 {
                font-size: 2rem;
            }
            .hero-section p {
                font-size: 1.1rem;
            }
            .cta-button,
            .contact-button {
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
            }
            .section-header h2 {
                font-size: 2rem;
            }
            .feature-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Premium Navbar -->
    <header>
        <div class="logo-container">
            <span class="logo-icon">🐾</span>
            <h1>Veterinaria Huellitas</h1>
        </div>
        
        <!-- Search Bar -->
        <div class="search-container">
            <i class="search-icon">🔍</i>
            <input type="text" placeholder="Buscar servicios, información..." aria-label="Buscar en el sitio web">
        </div>
        
        <nav>
            <a aria-label="Inicio" href="#">Inicio</a>
            <a aria-label="Servicios" href="#servicios">Servicios</a>
            <a aria-label="Contacto" href="#contacto">Contacto</a>
             <a aria-label="Tienda" href="{{ route('tienda.index') }}">Ir a tienda</a>
            <a aria-label="Iniciar sesión" class="button-login" href="{{ route('login') }}">
                Iniciar sesión
            </a>
            <a aria-label="Registrarse" class="button-register" href="{{ route('register') }}">
                Registrarse
            </a>
        </nav>
        
        <button class="dark-mode-toggle" id="darkModeToggle">🌓</button>
    </header>
    
    <!-- Premium Hero Section -->
    <section aria-label="Sección principal" class="hero-section" role="banner">
        <div class="hero-content">
            <h1>Cuidamos a tu mascota con amor y tecnología</h1>
            <p>Expertos en salud animal, comprometidos con el bienestar de tu compañero</p>
            <a aria-label="Ver nuestros servicios" class="cta-button" href="#servicios">
                <i>🐶</i> Ver nuestros servicios
            </a>
        </div>
    </section>
    
    <!-- Premium Services Section -->
    <section aria-label="Nuestros servicios" class="services-section" id="servicios">
        <div class="section-header">
            <h2>Nuestros Servicios</h2>
            <p>Ofrecemos una amplia gama de servicios veterinarios para garantizar la salud y felicidad de tu mascota</p>
        </div>
        
        <div class="services-grid">
            <article aria-labelledby="servicio1-titulo" class="service-card">
                <div class="service-img-container">
                    <img src="https://storage.googleapis.com/a1aa/image/cca971e9-c0f8-4654-801a-679ea2e9f18d.jpg" alt="Veterinario examinando un perro" class="service-img">
                </div>
                <div class="service-content">
                    <h3 id="servicio1-titulo">Consulta Veterinaria</h3>
                    <p>Atención personalizada para la salud de tu mascota con profesionales certificados.</p>
                    <a href="#" class="service-link">
                        Más información <i>→</i>
                    </a>
                </div>
            </article>
            
            <article aria-labelledby="servicio2-titulo" class="service-card">
                <div class="service-img-container">
                    <img src="https://storage.googleapis.com/a1aa/image/d60598ca-156b-49ae-af0b-14b63a44ef47.jpg" alt="Veterinario aplicando vacuna a un gato" class="service-img">
                </div>
                <div class="service-content">
                    <h3 id="servicio2-titulo">Vacunación</h3>
                    <p>Protege a tu mascota con nuestro completo plan de vacunación anual.</p>
                    <a href="#" class="service-link">
                        Más información <i>→</i>
                    </a>
                </div>
            </article>
            
            <article aria-labelledby="servicio3-titulo" class="service-card">
                <div class="service-img-container">
                    <img src="https://storage.googleapis.com/a1aa/image/1cb2acf4-9fed-4f9e-0e07-bbbaba1aad1a.jpg" alt="Veterinario realizando cirugía" class="service-img">
                </div>
                <div class="service-content">
                    <h3 id="servicio3-titulo">Cirugía Veterinaria</h3>
                    <p>Procedimientos quirúrgicos seguros y con tecnología avanzada.</p>
                    <a href="#" class="service-link">
                        Más información <i>→</i>
                    </a>
                </div>
            </article>
            
            <article aria-labelledby="servicio4-titulo" class="service-card">
                <div class="service-img-container">
                    <img src="https://storage.googleapis.com/a1aa/image/7aeae270-add4-43c7-042a-fdd9b0ef0da8.jpg" alt="Ambulancia veterinaria" class="service-img">
                </div>
                <div class="service-content">
                    <h3 id="servicio4-titulo">Urgencias 24/7</h3>
                    <p>Atención inmediata para emergencias veterinarias en cualquier momento.</p>
                    <a href="#" class="service-link">
                        Más información <i>→</i>
                    </a>
                </div>
            </article>
        </div>
    </section>
    
    <!-- Premium Features Section -->
    <section class="features-section">
        <div class="section-header">
            <h2>¿Por qué elegirnos?</h2>
            <p>Nos destacamos por nuestra calidad de servicio y atención personalizada</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🎓</div>
                <h3>Profesionales Certificados</h3>
                <p>Nuestro equipo cuenta con certificaciones internacionales y años de experiencia.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">❤️</div>
                <h3>Amor por los animales</h3>
                <p>Tratamos a cada mascota como si fuera nuestra, con cariño y dedicación.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">⚙️</div>
                <h3>Instalaciones modernas</h3>
                <p>Contamos con equipos de última generación para el mejor diagnóstico y tratamiento.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">🚑</div>
                <h3>Emergencias 24/7</h3>
                <p>Servicio de urgencias disponible en cualquier momento del día o noche.</p>
            </div>
        </div>
    </section>
    
    <!-- Premium Contact Section -->
    <section aria-label="Contacto" class="contact-section" id="contacto">
        <div class="contact-content">
            <h2>¡Ponte en contacto con nosotros!</h2>
            <p>Estamos aquí para ayudarte con cualquier pregunta o necesidad que tengas sobre la salud de tu mascota.</p>
            <a aria-label="Llamar ahora" href="tel:+591 67893245" class="contact-button">
                <i>📞</i> Llamar ahora
            </a>
        </div>
    </section>
    
    <!-- Premium Counter Section -->
    <section class="counter-section">
        <div class="counter-container">
            <h3>Nuestro compromiso con la excelencia</h3>
            <div class="counter-value" id="contador-visitas">0</div>
            <p class="counter-description">Visitas y contando - Cada visita nos motiva a seguir mejorando</p>
        </div>
    </section>
    
    <!-- Premium Footer -->
    <footer role="contentinfo">
        <div class="footer-container">
            <div class="footer-about">
                <div class="footer-logo">
                    <span>🐾</span>
                    <h3>Veterinaria Huellitas</h3>
                </div>
                <p>Somos una clínica veterinaria comprometida con el bienestar animal, ofreciendo servicios de alta calidad con un equipo de profesionales altamente capacitados.</p>
                <div class="social-links">
                    <a aria-label="Facebook" href="#"><i>👍</i></a>
                    <a aria-label="Instagram" href="#"><i>📷</i></a>
                    <a aria-label="Twitter" href="#"><i>🐦</i></a>
                    <a aria-label="WhatsApp" href="#"><i>💬</i></a>
                </div>
            </div>
            
            <div class="footer-links">
                <h4>Enlaces rápidos</h4>
                <ul>
                    <li><a href="#"><i>→</i> Inicio</a></li>
                    <li><a href="#servicios"><i>→</i> Servicios</a></li>
                    <li><a href="#"><i>→</i> Sobre nosotros</a></li>
                    <li><a href="#contacto"><i>→</i> Contacto</a></li>
                    <li><a href="{{ route('login') }}"><i>→</i> Iniciar sesión</a></li>
                    <li><a href="{{ route('register') }}"><i>→</i> Registrarse</a></li>
                </ul>
            </div>
            
            <div class="footer-links">
                <h4>Nuestros servicios</h4>
                <ul>
                    <li><a href="#"><i>→</i> Consultas</a></li>
                    <li><a href="#"><i>→</i> Vacunación</a></li>
                    <li><a href="#"><i>→</i> Cirugías</a></li>
                    <li><a href="#"><i>→</i> Hospitalización</a></li>
                    <li><a href="#"><i>→</i> Emergencias</a></li>
                    <li><a href="#"><i>→</i> Estética</a></li>
                </ul>
            </div>
            
            <div class="footer-contact">
                <h4>Contacto</h4>
                <p><i>📍</i> Av. Principal 123, Ciudad</p>
                <p><i>📞</i> +591 67893245</p>
                <p><i>📧</i> info@veterinariahuellitas.com</p>
                <p><i>⏰</i> Lunes a Viernes: 8am - 8pm</p>
                <p><i>⏰</i> Sábados: 9am - 4pm</p>
                <p><i>🚑</i> Emergencias: 24/7</p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>© <span id="current-year">2025</span> Veterinaria Huellitas - Todos los derechos reservados</p>
        </div>
    </footer>
    
    <!-- Floating Visit Counter -->
    <div class="visit-counter" aria-live="polite">
        <span>👋</span>
        <span id="contador-visitas-flotante">0</span> visitas
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Set current year in footer
            document.getElementById('current-year').textContent = new Date().getFullYear();
            
            // Visit counter - using localStorage for persistent count
            let visitas = localStorage.getItem('visitas') || 0;
            visitas = parseInt(visitas) + 1;
            localStorage.setItem('visitas', visitas);
            document.getElementById('contador-visitas').textContent = visitas;
            document.getElementById('contador-visitas-flotante').textContent = visitas;
            
            // Dark mode functionality
            const darkModeToggle = document.getElementById('darkModeToggle');
            const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
            
            // Check local storage or system preference
            const currentTheme = localStorage.getItem('theme');
            if (currentTheme === 'dark' || (!currentTheme && prefersDarkScheme.matches)) {
                document.body.classList.add('dark-mode');
                darkModeToggle.textContent = '🌞';
            } else {
                darkModeToggle.textContent = '🌙';
            }
            
            // Toggle dark mode
            darkModeToggle.addEventListener('click', () => {
                document.body.classList.toggle('dark-mode');
                const theme = document.body.classList.contains('dark-mode') ? 'dark' : 'light';
                localStorage.setItem('theme', theme);
                darkModeToggle.textContent = theme === 'dark' ? '🌞' : '🌙';
            });
            
            // Navbar scroll effect
            const header = document.querySelector('header');
            if (header) {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 50) {
                        header.classList.add('scrolled');
                    } else {
                        header.classList.remove('scrolled');
                    }
                });
            }
            
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
            
            // Animation on scroll
            const animateOnScroll = () => {
                const elements = document.querySelectorAll('.service-card, .feature-card');
                elements.forEach(element => {
                    const elementPosition = element.getBoundingClientRect().top;
                    const screenPosition = window.innerHeight / 1.3;
                    
                    if (elementPosition < screenPosition) {
                        element.style.opacity = '1';
                        element.style.transform = 'translateY(0)';
                    }
                });
            };
            
            // Set initial state for animated elements
            document.querySelectorAll('.service-card, .feature-card').forEach(element => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            });
            
            // Run once on load
            animateOnScroll();
            
            // Then on scroll
            window.addEventListener('scroll', animateOnScroll);
        });
    </script>
</body>
</html>















