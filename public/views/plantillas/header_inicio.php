<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - GEDAC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <style>
        html {
            scroll-behavior: smooth;
        }
        body {
            position: relative;
            background-color: white;
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