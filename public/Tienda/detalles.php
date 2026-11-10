<?php
session_start();
require_once dirname(__DIR__) . "/../src/Models/Certificates/CertificateModel.php";
require_once dirname(__DIR__) . "/../src/Utils.php";
use App\Models\Certificate\CertificateModel;

$modelInstator = new CertificateModel();
$getCertificates = $modelInstator->getCert();
$getCertificate = $modelInstator->getSpecificCert($_GET['idProducto'] ?? -1);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E3i Ingeniería | Detalles</title>
    
    <link rel="shortcut icon" href="../GlobalAssets/img/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="../GlobalAssets/css/Accesibility/accessibility.css">
    <link rel="stylesheet" href="../GlobalAssets/css/global.css">
    <link rel="stylesheet" href="../GlobalAssets/css/detalles.css">
    <link rel="stylesheet" href="../GlobalAssets/css/tienda.css">

    <script src="../GlobalAssets/js/Components/Translator/translator.js"></script>
    <script src="../GlobalAssets/js/Components/Accesibility/accessibility.js"></script>
    <script src="../GlobalAssets/js/menu.js"></script>   
</head>

<body>  
    <header>
        <a href="../" class="logo">
            <img src="../GlobalAssets/img/icons/logo-e3i.png" alt="Logo E3i Ingeniería">
        </a>

        <nav class="main-nav">
            <ul>   
                 <li class="separator"><a href="../Auth/"> <?= isset($_SESSION['Name']) ? "<b><u> <span data-i18n='menu_bienvenido'></span>". $_SESSION['Name'] . "</b></u>": "<span data-i18n='menu_login'></span>"; ?> </a></li>
                <li><a href="./carrito" class="btn-store" id="cart-counter" data-i18n="cart_button">Cesta[0]</a></li>
            </ul>
        </nav>
    </header>

    <main>  
        <div>
            <div class="tn" style="text-align:center;margin-top:20px">
                <h1>Detalles del producto</h1>
                <p>¿Estás interesado?</p>
            </div>                   
            <section class="details-product">
                <?php
                    if(count($getCertificate) === 0) echo "<h1 style=color:red;text-align:center;> ¡El producto buscado no existe! </h1>";
                    else echo injectProducts(0, $getCertificate); 
                ?>
            </section>

            <h2 class="section-title">Productos relacionados</h2>

            <section class="products-grid main-products">
                 <?= injectProducts(1, $getCertificates); ?>
            </section>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Inicialización de Idioma y Accesibilidad
            const currentLang = getLanguage();
            loadLanguage(currentLang, "../GlobalAssets/");
            new AccessibilityWidget("../GlobalAssets/img/accessibility/");

            // Lógica del Carrito
            const botonPrincipal = document.querySelector('.btn-add-cart');
            const contadorCesta = document.getElementById('cart-counter');
            
            let carrito = JSON.parse(localStorage.getItem('carrito_e3i')) || [];

            function actualizarContador() {
                const totalProductos = carrito.reduce((total, item) => total + item.cantidad, 0);
                if (contadorCesta) {
                    contadorCesta.textContent = `Cesta[${totalProductos}]`;
                }
                localStorage.setItem('carrito_e3i', JSON.stringify(carrito));
            }

            if (botonPrincipal) {
                botonPrincipal.addEventListener('click', () => {
                    const id = botonPrincipal.dataset.id;
                    const nombre = botonPrincipal.dataset.name;
                    const precio = parseFloat(botonPrincipal.dataset.price);

                    const existe = carrito.find(p => p.id === id);
                    if (existe) {
                        existe.cantidad++;
                    } else {
                        carrito.push({ id, nombre, precio, cantidad: 1 });
                    }

                    actualizarContador();

                    // Feedback visual multilingüe
                    const textoOriginal = botonPrincipal.textContent;
                    const lang = document.documentElement.lang || 'es';
                    const mensajeExito = (lang === 'en') ? "Added!" : "¡Añadido!";

                    botonPrincipal.textContent = mensajeExito;
                    botonPrincipal.style.backgroundColor = "#28a745";

                    setTimeout(() => {
                        botonPrincipal.textContent = textoOriginal;
                        botonPrincipal.style.backgroundColor = ""; 
                    }, 800);
                });
            }

            actualizarContador();
        });
    </script>
</body>
</html>