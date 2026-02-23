<?php
session_start();
// Verificar si hay sesión activa
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? ($_SESSION['username'] ?? 'Usuario') : '';
$nombreCompleto = $isLoggedIn ? ($_SESSION['nombre_completo'] ?? $userName) : '';
$userId = $isLoggedIn ? $_SESSION['user_id'] : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Egresados COSFA - Comunidad de Semillas Franciscanas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2E7D32;
            --secondary: #FFC107;
            --accent: #F57C00;
            --light: #F5F5F5;
            --dark: #1B5E20;
            --neutral: #757575;
            --text-color: #333;
            --bg-color: #f9f9f9;
            --gradient-start: #2E7D32;
            --gradient-end: #FFC107;
            --transition-slow: 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            --transition-medium: 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            --transition-fast: 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            background-color: var(--bg-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }
        
        /* Barra de navegación mejorada */
        .navbar {
            background: linear-gradient(135deg, var(--primary) 0%, var(--dark) 100%);
            padding: 0.8rem 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            transition: all var(--transition-medium);
            backdrop-filter: blur(10px);
        }
        
        .navbar.scrolled {
            padding: 0.5rem 1rem;
            background: rgba(46, 125, 50, 0.95);
            backdrop-filter: blur(15px);
        }
        
        .navbar-brand {
            font-weight: bold;
            font-size: 1.8rem;
            color: white !important;
            display: flex;
            align-items: center;
            transition: all var(--transition-medium);
        }
        
        .navbar-brand img {
            transition: all var(--transition-medium);
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
        }
        
        .navbar-brand:hover img {
            transform: scale(1.05) rotate(-2deg);
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            margin: 0 5px;
            font-weight: 500;
            transition: all var(--transition-medium);
            border-radius: 8px;
            padding: 0.5rem 1rem !important;
            position: relative;
            overflow: hidden;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%) scaleX(0);
            width: 80%;
            height: 2px;
            background-color: var(--secondary);
            transition: transform var(--transition-medium);
        }
        
        .nav-link:hover::before, .nav-link.active::before {
            transform: translateX(-50%) scaleX(1);
        }
        
        .nav-link:hover, .nav-link:focus {
            color: white !important;
            transform: translateY(-2px);
        }
        
        .dropdown-menu {
            background-color: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            animation: fadeInDown 0.3s ease-out;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .dropdown-item {
            color: var(--dark);
            padding: 0.6rem 1.2rem;
            transition: all var(--transition-fast);
            border-radius: 6px;
            margin: 2px 5px;
            width: calc(100% - 10px);
        }
        
        .dropdown-item:hover {
            background-color: var(--secondary);
            color: var(--dark);
            padding-left: 1.5rem;
            transform: translateX(5px);
        }
        
        .navbar-toggler {
            border: none;
            color: white;
            transition: all var(--transition-fast);
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
        }
        
        /* Carrusel mejorado */
        .carousel {
            margin-top: 20px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            opacity: 0;
            animation: fadeIn 1.2s ease-out 0.3s forwards;
        }
        
        .carousel-item {
            height: 600px;
            overflow: hidden;
            position: relative;
        }
        
        .carousel-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.7) 100%);
            z-index: 1;
        }
        
        .carousel-item img {
            object-fit: cover;
            width: 100%;
            height: 100%;
            transition: transform 8s ease;
        }
        
        .carousel-item.active img {
            transform: scale(1.05);
        }
        
        .carousel-caption {
            background-color: rgba(27, 94, 32, 0.85);
            padding: 40px;
            border-radius: 16px;
            max-width: 700px;
            margin: 0 auto;
            z-index: 2;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transform: translateY(30px);
            opacity: 0;
            animation: slideUpFadeIn 1s ease-out 0.8s forwards;
        }
        
        @keyframes slideUpFadeIn {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .carousel-caption h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            background: linear-gradient(to right, #FFC107, #FF9800);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .carousel-caption p {
            font-size: 1.1rem;
            margin-bottom: 25px;
            color: rgba(255, 255, 255, 0.9);
        }
        
        .btn-cosfa {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--accent) 100%);
            color: white;
            border: none;
            padding: 14px 30px;
            border-radius: 10px;
            transition: all var(--transition-medium);
            font-weight: 600;
            box-shadow: 0 6px 15px rgba(255, 193, 7, 0.3);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .btn-cosfa::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.7s ease;
            z-index: -1;
        }
        
        .btn-cosfa:hover::before {
            left: 100%;
        }
        
        .btn-cosfa:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 10px 25px rgba(255, 193, 7, 0.4);
        }
        
        .btn-school {
            background: linear-gradient(135deg, var(--accent) 0%, #D84315 100%);
            color: white;
            border: none;
            padding: 14px 30px;
            border-radius: 10px;
            transition: all var(--transition-medium);
            font-weight: 600;
            box-shadow: 0 6px 15px rgba(245, 124, 0, 0.3);
        }
        
        .btn-school:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 10px 25px rgba(245, 124, 0, 0.4);
        }
        
        /* Sección de contenido mejorada */
        .content-section {
            padding: 100px 0;
            background-color: white;
            border-radius: 20px;
            margin: 50px 0;
            text-align: center;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
            opacity: 0;
            transform: translateY(40px);
            animation: fadeInUp 1s ease-out 1s forwards;
        }
        
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .content-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            z-index: 1;
        }
        
        .section-title {
            position: relative;
            margin-bottom: 60px;
            text-align: center;
            color: var(--primary);
            font-weight: 700;
            font-size: 2.8rem;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s ease-out 1.2s forwards;
        }
        
        .section-title::after {
            content: '';
            display: block;
            width: 120px;
            height: 5px;
            background: linear-gradient(90deg, var(--secondary) 0%, var(--primary) 100%);
            margin: 25px auto;
            border-radius: 3px;
            transform: scaleX(0);
            transform-origin: center;
            animation: expandLine 1s ease-out 1.5s forwards;
        }
        
        @keyframes expandLine {
            to {
                transform: scaleX(1);
            }
        }
        
        .welcome-text {
            font-size: 1.1rem;
            line-height: 1.8;
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
            color: var(--neutral);
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 1s ease-out 1.4s forwards;
        }
        
        .feature-box {
            background-color: white;
            padding: 50px 30px;
            border-radius: 16px;
            text-align: center;
            height: 100%;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
            transition: all var(--transition-medium);
            border-top: 4px solid var(--secondary);
            position: relative;
            overflow: hidden;
            opacity: 0;
            transform: translateY(40px);
        }
        
        .feature-box.animated {
            animation: fadeInUp 0.8s ease-out forwards;
        }
        
        .feature-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 0;
            background: linear-gradient(135deg, rgba(46, 125, 50, 0.05) 0%, rgba(255, 193, 7, 0.05) 100%);
            transition: all var(--transition-medium);
            z-index: 0;
        }
        
        .feature-box:hover {
            transform: translateY(-15px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.12);
        }
        
        .feature-box:hover::before {
            height: 100%;
        }
        
        .feature-icon {
            font-size: 3.5rem;
            margin-bottom: 30px;
            color: var(--primary);
            position: relative;
            z-index: 1;
            transition: all var(--transition-medium);
        }
        
        .feature-box:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
            color: var(--secondary);
        }
        
        .feature-box h3 {
            margin-bottom: 20px;
            color: var(--primary);
            font-weight: 700;
            position: relative;
            z-index: 1;
            transition: all var(--transition-fast);
        }
        
        .feature-box:hover h3 {
            color: var(--dark);
        }
        
        .feature-box p {
            color: var(--neutral);
            margin-bottom: 25px;
            position: relative;
            z-index: 1;
            transition: all var(--transition-fast);
        }
        
        .feature-box:hover p {
            color: #555;
        }
        
        .highlight {
            background: linear-gradient(120deg, var(--secondary) 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }
        
        /* Pie de página mejorado */
        footer {
            background: linear-gradient(135deg, var(--primary) 0%, var(--dark) 100%);
            color: white;
            padding: 80px 0 30px;
            margin-top: 80px;
            position: relative;
            overflow: hidden;
        }
        
        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--secondary), var(--accent));
        }
        
        footer h5 {
            font-weight: 700;
            margin-bottom: 30px;
            font-size: 1.4rem;
            position: relative;
            padding-bottom: 15px;
            color: var(--secondary);
        }
        
        footer h5::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--secondary);
            border-radius: 2px;
            transform-origin: left;
            animation: expandLine 1s ease-out 2s forwards;
        }
        
        .social-icons a {
            color: white;
            font-size: 1.5rem;
            margin-right: 15px;
            transition: all var(--transition-medium);
            display: inline-block;
            background: rgba(255, 255, 255, 0.1);
            width: 45px;
            height: 45px;
            border-radius: 50%;
            text-align: center;
            line-height: 45px;
        }
        
        .social-icons a:hover {
            color: var(--secondary);
            transform: translateY(-5px) scale(1.1);
            background: rgba(255, 255, 255, 0.2);
        }
        
        .footer-links {
            list-style: none;
            padding-left: 0;
        }
        
        .footer-links li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            transform: translateX(-10px);
            opacity: 0;
            animation: slideInRight 0.5s ease-out forwards;
        }
        
        @keyframes slideInRight {
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .footer-links li:nth-child(1) { animation-delay: 2.1s; }
        .footer-links li:nth-child(2) { animation-delay: 2.2s; }
        .footer-links li:nth-child(3) { animation-delay: 2.3s; }
        .footer-links li:nth-child(4) { animation-delay: 2.4s; }
        .footer-links li:nth-child(5) { animation-delay: 2.5s; }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            transition: all var(--transition-fast);
            display: flex;
            align-items: center;
        }
        
        .footer-links a:hover {
            color: white;
            padding-left: 8px;
        }
        
        .footer-links i {
            margin-right: 12px;
            font-size: 1rem;
            color: var(--secondary);
        }
        
        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            padding-top: 30px;
            margin-top: 60px;
            color: rgba(255, 255, 255, 0.7);
            text-align: center;
        }
        
        /* Efecto de partículas flotantes */
        .floating-element {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            z-index: 0;
        }
        
        /* Animaciones generales */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        
        .animate-fadeIn {
            animation: fadeIn 1s ease forwards;
        }
        
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
        
        /* Efecto de scroll suave */
        html {
            scroll-behavior: smooth;
        }
        
        /* Responsive mejorado */
        @media (max-width: 1200px) {
            .carousel-item {
                height: 550px;
            }
            
            .section-title {
                font-size: 2.5rem;
            }
        }
        
        @media (max-width: 992px) {
            .carousel-item {
                height: 500px;
            }
            
            .carousel-caption {
                padding: 30px;
                max-width: 90%;
            }
            
            .carousel-caption h2 {
                font-size: 2.2rem;
            }
            
            .content-section {
                padding: 80px 0;
            }
            
            .feature-box {
                padding: 40px 25px;
            }
        }
        
        @media (max-width: 768px) {
            .navbar-nav {
                text-align: center;
                padding-top: 15px;
            }
            
            .dropdown-menu {
                text-align: center;
                background-color: rgba(255, 255, 255, 0.98);
            }
            
            .carousel-item {
                height: 450px;
            }
            
            .carousel-caption {
                padding: 25px;
            }
            
            .carousel-caption h2 {
                font-size: 1.8rem;
            }
            
            .carousel-caption p {
                font-size: 1rem;
            }
            
            .section-title {
                font-size: 2.2rem;
            }
            
            .content-section {
                padding: 60px 0;
                margin: 30px 0;
            }
            
            .feature-box {
                padding: 35px 20px;
                margin-bottom: 25px;
            }
            
            footer {
                padding: 60px 0 25px;
            }
        }
        
        @media (max-width: 576px) {
            .carousel-item {
                height: 400px;
            }
            
            .carousel-caption h2 {
                font-size: 1.6rem;
            }
            
            .btn-cosfa, .btn-school {
                padding: 12px 25px;
                font-size: 0.95rem;
            }
            
            .section-title {
                font-size: 1.9rem;
            }
            
            .content-section {
                border-radius: 15px;
            }
        }
        
        /* Perfil de usuario */
        .user-profile {
            display: flex;
            align-items: center;
            margin-left: 15px;
            padding: 5px 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50px;
            transition: all var(--transition-medium);
        }
        
        .user-profile:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 10px;
            border: 2px solid var(--secondary);
            transition: all var(--transition-medium);
        }
        
        .user-profile:hover .user-avatar {
            transform: scale(1.1);
            border-color: white;
        }
        
        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        #userName {
            color: white;
            font-weight: 500;
        }
        .content-section {
    margin: 0 auto;
    padding-left: 15px;
    padding-right: 15px;
}
.content-section {
    margin-top: 60px;
    margin-bottom: 60px;
    padding-top: 40px;
    padding-bottom: 40px;
}

.welcome-text {
    line-height: 1.8;
    margin-bottom: 20px;
}

.feature-box {
    margin-bottom: 30px;
}
    </style>
</head>
<body>
    <!-- Barra de navegación -->
 <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
               <img src="images/logo.png" alt="Semillas Franciscanas" class="me-2" style="width:90px; height:80px;">
               <span>Semillas Franciscanas</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Inicio -->
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php" id="inicioLink">
                            <i class="fas fa-home me-1"></i> Inicio
                        </a>
                    </li>
                    <!-- Egresados -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="egresados.html" id="egresadosDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-users me-1"></i> Egresados
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="egresadosDropdown">
                            <li><a class="dropdown-item" href="historias.php">Historias de Éxito</a></li>
                            <li><a class="dropdown-item" href="promociones.php">Promociones</a></li>
                            <li><a class="dropdown-item" href="actualizar.php">Actualizar Datos</a></li>
                        </ul>
                    </li>
                    <!-- Eventos -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="eventos.html" id="eventosDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-calendar-alt me-1"></i> Eventos
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="eventosDropdown">
                            <li><a class="dropdown-item" href="proximos-eventos.php">Próximos Eventos</a></li>
                            <li><a class="dropdown-item" href="eventos-pasados.php">Eventos Pasados</a></li>
                            <li><a class="dropdown-item" href="galeria.php">Galería de Fotos</a></li>
                            <li><a class="dropdown-item" href="eventos.html">Inscribirse a Eventos</a></li>
                        </ul>
                    </li>
                    
                    <!-- Cuenta - Mostrar opciones según estado de sesión -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i> 
                            <?php echo $isLoggedIn ? htmlspecialchars($userName) : 'Cuenta'; ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="loginDropdown">
                            <?php if ($isLoggedIn): ?>
                                <!-- Opciones cuando el usuario está logueado -->
                                <li>
                                    <a class="dropdown-item" href="cuenta.php">
                                        <i class="fas fa-user-circle me-2"></i>
                                        <?php echo htmlspecialchars($nombreCompleto); ?>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item logout-link" href="logout.php">
                                        <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                                    </a>
                                </li>
                            <?php else: ?>
                                <!-- Opciones cuando NO hay sesión activa -->
                                <li><a class="dropdown-item" href="inicioSesion.php">Iniciar Sesión</a></li>
                                <li><a class="dropdown-item" href="registro.html">Registrarse</a></li>
                                <li><a class="dropdown-item" href="OlvidePswd.html">¿Olvidaste tu contraseña?</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <!-- Sobre Nosotros -->
                    <li class="nav-item">
                        <a class="nav-link" href="sobrenosotros.php">
                            <i class="fas fa-envelope me-1"></i> Sobre Nosotros
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Contenido principal - Página de Inicio -->
    <div class="main-content" id="inicioContent">
        <!-- Carrusel -->
        <div class="container">
            <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="foto1.jpg" class="d-block w-100" alt="Graduación COSFA">
                        <div class="carousel-caption d-none d-md-block">
                            <h2>Bienvenidos Egresados COSFA</h2>
                            <p>Reunimos a todos los graduados de nuestro querido colegio para mantener vivas las tradiciones y recuerdos.</p>
                            <button class="btn btn-cosfa animate-float">Únete a nosotros</button>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="foto2.jpg" class="d-block w-100" alt="Reunión de egresados">
                        <div class="carousel-caption d-none d-md-block">
                            <h2>Reencuentro Anual 2023</h2>
                            <p>No te pierdas nuestro próximo reencuentro de egresados. ¡Revive los mejores momentos!</p>
                            <button class="btn btn-cosfa animate-float">Más información</button>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="foto3.png" class="d-block w-100" alt="Historia del colegio">
                        <div class="carousel-caption d-none d-md-block">
                            <h2>Nuestra Historia</h2>
                            <p>Más de 60 años formando profesionales exitosos y personas de bien para la sociedad.</p>
                            <button class="btn btn-cosfa animate-float">Conoce más</button>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
        </div>
        
        <!-- Contenido principal -->
         <!-- Contenido principal -->
<!-- Contenido principal -->
<div class="container content-section my-5 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-11 col-sm-12 mx-auto text-center">
            <h2 class="section-title animate-fadeIn mb-4">Bienvenidos a la comunidad de <span class="highlight">Egresados COSFA</span></h2>
            <p class="welcome-text mb-4">
                Nos alegra recibirlos en este espacio creado para los egresados COSAFA, una familia que sigue creciendo más allá de las aulas. Aquí queremos mantener viva la esencia franciscana que nos formó, compartiendo recuerdos, experiencias y proyectos que reflejan los valores que llevamos en el corazón: fraternidad, servicio y esperanza.
            </p>
            <p class="welcome-text mb-4">
                Nuestro colegio ha formado a miles de profesionales que hoy en día se desempeñan con éxito en diversas
                áreas del conocimiento. Esta red nos permite mantenernos unidos sin importar la distancia o los años
                que hayan pasado desde nuestra graduación.
            </p>
            <p class="welcome-text mb-4">
                La página nace con la idea de ser un punto de encuentro, donde cada uno de nosotros pueda sentirse parte de una comunidad que nunca se rompe. Más que un sitio web, es un lugar para seguir sembrando y cosechando juntos, recordando que somos y siempre seremos Semillas Franciscanas.
            </p>
        </div>
    </div>
    <div class="row mt-5 mb-4 justify-content-center">
        <div class="col-md-5 mb-4 d-flex justify-content-center">
            <div class="feature-box text-center p-4" data-delay="0.1">
                <div class="feature-icon mb-3">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h3 class="mb-3">Eventos y Reuniones</h3>
                <p class="mb-3">Mantente informado sobre los próximos eventos, reuniones y actividades para egresados.</p>
                <a href="proximos-eventos.html" class="btn btn-cosfa mt-3">Ver eventos</a>
            </div>
        </div>
        <div class="col-md-5 mb-4 d-flex justify-content-center">
            <div class="feature-box text-center p-4" data-delay="0.3">
                <div class="feature-icon mb-3">
                    <i class="fas fa-school"></i>
                </div>
                <h3 class="mb-3">Sitio Oficial COSFA</h3>
                <p class="mb-3">Visita la página oficial del Colegio COSFA para conocer las últimas noticias y actividades actuales.</p>
                <a href="https://cosfacali.edu.co/" target="_blank" class="btn btn-school mt-3">Ir al sitio oficial</a>
            </div>
        </div>
    </div>
</div>

    <!-- Pie de página -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>Egresados COSFA</h5>
                    <p>Manteniendo viva la tradición y los lazos de amistad formados en nuestras aulas.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Enlaces rápidos</h5>
                    <ul class="footer-links">
                        <li><a href="index.html"><i class="fas fa-home"></i> Inicio</a></li>
                        <li><a href="historias.html"><i class="fas fa-star"></i> Historias de Éxito</a></li>
                        <li><a href="galeria.html"><i class="fas fa-images"></i> Galería de Fotos</a></li>
                        <li><a href="proximos-eventos.html"><i class="fas fa-calendar"></i> Próximos Eventos</a></li>
                        <li><a href="sobrenosotros.html"><i class="fas fa-envelope"></i> Sobre Nosotros</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Contacto</h5>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt me-2"></i> Av. Principal #123, Ciudad</li>
                        <li><i class="fas fa-phone me-2"></i> (123) 456-7890</li>
                        <li><i class="fas fa-envelope me-2"></i> info@egresadoscosfa.edu</li>
                    </ul>
                </div>
            </div>
            <div class="text-center copyright">
                <p>&copy; 2023 Egresados COSFA. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elementos del DOM
            const inicioContent = document.getElementById('inicioContent');
            const inicioLink = document.getElementById('inicioLink');
            const navbar = document.querySelector('.navbar');
            
            // Efecto de navbar al hacer scroll
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
            
            // Inicializar animaciones para elementos al cargar
            setTimeout(() => {
                const featureBoxes = document.querySelectorAll('.feature-box');
                featureBoxes.forEach((box, index) => {
                    const delay = box.getAttribute('data-delay') || 0;
                    setTimeout(() => {
                        box.classList.add('animated');
                    }, delay * 1000);
                });
            }, 1500);
            
            // Función para desplazarse al principio de la página
            function scrollToTop() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
            
            // Navegación
            inicioLink.addEventListener('click', function(e) {
                e.preventDefault();
                scrollToTop();
            });
            
            // Animación de elementos al hacer scroll
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fadeIn');
                    }
                });
            }, observerOptions);
            
            // Observar elementos para animación
            document.querySelectorAll('.feature-box, .section-title, .welcome-text').forEach(el => {
                observer.observe(el);
            });
            
            // Efecto hover en botones del carrusel
            document.querySelectorAll('.btn-cosfa').forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px) scale(1.05)';
                });
                
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
            
            // Efecto de animación al cargar la página
            document.body.style.opacity = '0';
            setTimeout(() => {
                document.body.style.transition = 'opacity 0.8s ease';
                document.body.style.opacity = '1';
            }, 100);
            
            // Crear elementos flotantes decorativos
            function createFloatingElements() {
                const container = document.querySelector('.content-section');
                if (!container) return;
                
                for (let i = 0; i < 8; i++) {
                    const element = document.createElement('div');
                    element.classList.add('floating-element');
                    
                    const size = Math.random() * 30 + 10;
                    const posX = Math.random() * 100;
                    const posY = Math.random() * 100;
                    const delay = Math.random() * 5;
                    
                    element.style.width = `${size}px`;
                    element.style.height = `${size}px`;
                    element.style.left = `${posX}%`;
                    element.style.top = `${posY}%`;
                    element.style.animation = `float ${6 + Math.random() * 4}s ease-in-out ${delay}s infinite`;
                    element.style.opacity = Math.random() * 0.2 + 0.05;
                    
                    container.appendChild(element);
                }
            }
            
            // Llamar a la función para crear elementos flotantes
            createFloatingElements();
        });
    </script>
</body>
</html>