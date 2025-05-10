<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#39A900',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                    },
                },
            },
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            position: relative;
            background-color: white;
            overflow-x: hidden;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .text-gradient {
            background: linear-gradient(45deg, #39A900, #2d7a00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .nav-link {
            position: relative;
            overflow: hidden;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: currentColor;
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s ease;
        }

        .nav-link:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }

        .animate-on-scroll {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .animate-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        .background-logo {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('../pictures/logosena.png') no-repeat center center;
            background-size: 30%;
            opacity: 0.1;
            z-index: -1;
        }
        .team-container {
            display: flex;
            justify-content: center;
            gap: 60px;
            margin-top: 20px;
        }
        .team-member {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .team-member img {
            width: 170px;
            height: 170px;
            border-radius: 50%;
            object-fit: cover;
        }
        .team-member p {
            margin-top: 10px;
            font-size: 1.1rem;
            font-weight: bold;
            color: #39A900;
        }
        .fondo-derecha {
    width: 1500px; /* Ajusta el tamaño según lo necesites */
    max-width: 940px; /* Evita que sea demasiado grande en pantallas grandes */
    height: 900px; /* Mantiene la proporción */
    
    display: block;
    left: 128px; /* Empuja la imagen hacia la derecha */
    
    position: relative;
    bottom: -50px; /* Baja la imagen, ajusta según lo necesites */
    
}

.inve{
    position: absolute;
    right: 400px;
    width: 650px;
    top: 320px;
}

    </style>
</head>