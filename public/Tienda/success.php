<?php
session_start();

if(!isset($_SESSION['Val'])) 
{
    header("Location: ../Auth");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../GlobalAssets/img/favicon.ico" type="image/x-icon">
    <title>Pedido Exitoso | E3i Ingeniería</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:wght@400;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../GlobalAssets/css/global.css"> 

    <style>
        /* =========================================
           ESTILOS ESPECÍFICOS PÁGINA DE ÉXITO
           ========================================= */
        
        .success-page-wrapper {
            min-height: 80vh; /* Ocupa casi toda la pantalla */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 0;
            background-color: #f9f9f9; /* Un gris muy suave de fondo */
        }

        .success-card {
            background: var(--color-background-white);
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            text-align: center;
            max-width: 600px;
            width: 100%;
            border-top: 5px solid var(--color-primary-green);
        }

        /* ANIMACIÓN DEL CHECK */
        .success-icon-container {
            width: 80px;
            height: 80px;
            background-color: rgba(0, 166, 81, 0.1); /* Verde con transparencia */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px auto;
            animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .success-icon {
            font-size: 40px;
            color: var(--color-primary-green);
        }

        @keyframes popIn {
            0% { transform: scale(0); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .success-title {
            color: var(--color-primary-green);
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .success-message {
            color: var(--color-text-light);
            font-size: 16px;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        /* RESUMEN DEL PEDIDO */
        .order-summary {
            background-color: #f4f4f4;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 40px;
            text-align: left;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 14px;
            color: var(--color-text-body);
        }

        .summary-row:last-child {
            margin-bottom: 0;
            border-top: 1px solid #ddd;
            padding-top: 12px;
            font-weight: 700;
            font-size: 16px;
        }

        .summary-row span:last-child {
            font-weight: 700;
        }
        
        /* BOTONES */
        .actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
            font-size: 15px;
        }

        .btn-primary {
            background-color: var(--color-primary-green);
            color: white;
            border: 2px solid var(--color-primary-green);
        }

        .btn-primary:hover {
            background-color: #008c44;
            border-color: #008c44;
        }

        .btn-outline {
            background-color: transparent;
            color: var(--color-text-body);
            border: 2px solid #ddd;
        }

        .btn-outline:hover {
            border-color: var(--color-primary-green);
            color: var(--color-primary-green);
        }

        /* MOBILE */
        @media (max-width: 600px) {
            .success-card { padding: 30px 20px; }
            .success-title { font-size: 26px; }
            .actions { flex-direction: column; }
            .btn { width: 100%; text-align: center; }
        }
    </style>
</head>
<body>

    <header style="border-bottom: 1px solid #eee; padding: 20px 0;">
        <div class="section-container">
            <img src="../GlobalAssets/img/icons/logo-e3i.png" alt="E3i Ingeniería" height="40">
        </div>
    </header>

    <main class="success-page-wrapper">
        <div class="section-container" style="display:flex; justify-content:center;">
            
            <div class="success-card">
                <div class="success-icon-container">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 6L9 17L4 12" stroke="#00A651" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>

                <h1 class="success-title">¡Pago Realizado!</h1>
                
                <p class="success-message">
                    Gracias por confiar en <strong>E3i Ingeniería</strong>. Hemos recibido tu pedido correctamente. 
                    Hemos enviado un correo de confirmación a <strong><?= $_SESSION['Email']; ?></strong>.
                </p>

                <div class="order-summary">
                    <div class="summary-row">
                        <span>Nº de Pedido:</span>
                        <span style="font-family: monospace; letter-spacing: 1px;">#<?= strtoupper($_SESSION['UUID']); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Fecha:</span>
                        <span><?= $_SESSION['NOW']; ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Método de pago:</span>
                        <span>Tarjeta Crédito/Débito</span>
                    </div>
                    <div class="summary-row" style="color: var(--color-primary-green);">
                        <span>Total Pagado:</span>
                        <span><?= $_SESSION['TOTAL']; ?></span>
                    </div>
                </div>

                <div class="actions">
                    <a href="/" class="btn btn-outline">Volver al Inicio</a>
                </div>
            </div>

        </div>
    </main>

    <footer>
        <div class="section-container">
            <p style="text-align: center; color: var(--color-text-light); font-size: 14px;">
                &copy; 2026 E3i Ingeniería. Todos los derechos reservados.
            </p>
        </div>
    </footer>

</body>
</html>