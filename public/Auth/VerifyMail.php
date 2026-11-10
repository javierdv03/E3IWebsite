<?php
session_start();
if(!isset($_SESSION["NIF"]))
{
    header("Location: ./");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    
    <link rel="shortcut icon" href="../GlobalAssets/img/favicon.ico" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Verifica tu correo electrónico</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.js"></script>
    <style>
        /* --- Variables de Color (Basadas en tu paleta EGi) --- */
        :root {
            --color-primary: #00a0b0;    /* Cian corporativo */
            --color-text-dark: #1E2329;  /* Negro suave para títulos */
            --color-text-gray: #707a8a;  /* Gris para texto secundario */
            --color-bg: #F7F9FA;         /* Fondo gris muy claro */
            --color-white: #ffffff;
        }

        /* --- Reset Básico Moderno --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--color-bg);
            color: var(--color-text-dark);
            line-height: 1.6;
            /* Centrado vertical y horizontal */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* --- Contenedor Principal (Tarjeta) --- */
        .verify-container {
            background-color: var(--color-white);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 480px; /* Ancho máximo elegante en escritorio */
            text-align: center;
            animation: fadeIn 0.5s ease-out;
        }

        /* --- Logo --- */
        .logo-header {
            margin-bottom: 30px;
        }
        .logo-header img {
            max-height: 40px; /* Ajusta esto según el tamaño de tu logo */
            width: auto;
        }

        /* --- Icono del Email --- */
        .icon-container {
            margin-bottom: 25px;
        }
        .email-icon-svg {
            width: 80px;
            height: 80px;
            /* El color del icono se define en el SVG abajo usando currentColor */
            color: var(--color-primary);
            opacity: 0.9;
        }

        /* --- Tipografía --- */
        h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--color-text-dark);
            letter-spacing: -0.5px;
        }

        p {
            color: var(--color-text-gray);
            margin-bottom: 20px;
            font-size: 16px;
        }

        .email-highlight {
            color: var(--color-text-dark);
            font-weight: 600;
        }

        /* --- Enlaces y Footer --- */
        .footer-actions {
            margin-top: 35px;
            padding-top: 25px;
            border-top: 1px solid #eee;
            font-size: 14px;
            color: var(--color-text-gray);
        }

        .link-primary {
            color: var(--color-primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
            cursor: pointer;
        }
        .link-primary:hover {
            color: #007a87; /* Un tono más oscuro al pasar el mouse */
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: var(--color-text-gray);
            text-decoration: none;
            font-size: 14px;
        }
        .back-link:hover {
            text-decoration: underline;
        }

        /* --- Animación suave de entrada --- */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* --- Adaptación Móvil (Responsive) --- */
        @media (max-width: 480px) {
            .verify-container {
                padding: 30px 20px; /* Menos padding en móviles */
                box-shadow: none; /* Opcional: quitar sombra en móviles para look más plano */
                background-color: transparent; /* Fondo transparente en móviles muy pequeños para que parezca nativo */
            }
            body {
                 background-color: var(--color-white); /* Si la tarjeta es transparente, el body debe ser blanco */
            }
             h1 { font-size: 22px; }
        }
    </style>
    <script type="importmap">
        {
            "imports":
            {
                "AuthController": "../GlobalAssets/js/Controllers/Auth/AuthController.js"
            }
        }
    </script>    
</head>
<body>

    <main class="verify-container">
        <div class="logo-header">
            <img src="../GlobalAssets/img/icons/logo-e3i.png" alt="E3i Logo">
        </div>

        <div class="icon-container">
            <svg class="email-icon-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21.2 8.4c.5.38.8.97.8 1.6v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V10a2 2 0 0 1 .8-1.6l8-6a2 2 0 0 1 2.4 0l8 6Z"/>
                <path d="m22 10-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 10"/>
            </svg>
        </div>

        <h1>Revisa tu bandeja de entrada</h1>
        
        <p>
            Hemos enviado un enlace de confirmación a: <br>
            <span class="email-highlight"><?= $_SESSION['Email'] ?></span>
        </p>
        
        <p>
            Haz clic en el enlace del correo para activar tu cuenta y empezar. Si no lo ves, revisa la carpeta de spam.
        </p>

        <div class="footer-actions">
            
            <a href="/" class="back-link">← Volver al inicio</a>
        </div>
    </main>

    <script type="module">
     import {AuthFrontEnd} from "AuthController";
     
     ( async ()=> {
       
        const getParams = new URLSearchParams(window.location.search);
        let verifyToken = getParams.get("token");

        if(!verifyToken || !verifyToken.match(/^[\w-]+\.[\w-]+\.[\w-]+$/)) return;

        const mailVerifyInstance = new AuthFrontEnd({"token": verifyToken});

        var result = await mailVerifyInstance.executeVerifyMail();

        switch (result.statusCode) 
        {
            case 200:
                Toastify({
                    text: "Éxito: Tu cuenta ha sido verificada con éxito",
                    duration: 3000,
                    gravity: "top", 
                    position: "right", 
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    }
                    }).showToast();                
                
                localStorage.setItem("X-Authenticator", result.response);

                setTimeout(() => {
                        top.location.href = "../Dashboard";
                }, 2500);

                break;
            
            case 400:    
            case 401:
                Toastify({
                    text: "Error: "+ result.response,
                    duration: 3000,
                    gravity: "top", 
                    position: "right", 
                    style: {
                        background: "linear-gradient(to right, #ff5f6d, #ffc371)",
                    }
                    }).showToast();
                break;


            default:
                alert("Something wrong have happened. Check the console.log ASAP");
                debugger
                return;
        }

     
    })();
     
     

    </script>

</body>
</html>