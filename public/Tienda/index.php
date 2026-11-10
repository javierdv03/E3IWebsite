<?php
session_start();
require_once dirname(__DIR__) . "/../src/Models/Certificates/CertificateModel.php";
require_once dirname(__DIR__) . "/../src/Utils.php";
use App\Models\Certificate\CertificateModel;

$modelInstator = new CertificateModel();
$getCertificates = $modelInstator->getCert();

?>

<!DOCTYPE html>
<html lang="es">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>E3i Ingeniería | Tienda</title>
      <link rel="shortcut icon" href="../GlobalAssets/img/favicon.ico" type="image/x-icon">
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:wght@400;500;700&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
      <link rel="stylesheet" href="../GlobalAssets/css/Accesibility/accessibility.css">
      <link rel="stylesheet" href="../GlobalAssets/css/global.css">
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
               <li><a href="./carrito" class="btn-store" data-i18n="cart_button">Cesta[0]</a></li>
            </ul>
         </nav>
      </header>
      <main>
         <div>
            <div class="tn" style="text-align:center;margin-top:20px">
                <h1>Solicita aquí de forma automática tu certificado</h1>
                <p>A través de un proceso de compra sencilla, obtén tu certificado.</p>
            </div>    
            <section class="products-grid main-products">
               <?= injectProducts(0, $getCertificates); ?>
            </section>
            <h2 class="section-title" data-i18n="why-choose-us">¿Por qué elegirnos?</h2>
            <section class="benefits-grid">
               <div class="benefit-item">
                  <img src="../GlobalAssets/img/tienda/reloj.png" alt="Reloj">
                  <h3 class="benefit-title" data-i18n="benefits-title1">Certificados en menos de 24h</h3>
                  <p class="benefit-text" data-i18n="benefits-desc1">Tramitamos tus certificados con la máxima agilidad, garantizando precisión técnica y cumplimiento normativo en tiempo récord.</p>
               </div>
               <div class="benefit-item">
                  <img src="../GlobalAssets/img/tienda/obrero.png" alt="Obrero">
                  <h3 class="benefit-title" data-i18n="benefits-title2">Ingenieros certificados y expertos</h3>
                  <p class="benefit-text" data-i18n="benefits-desc2">Contamos con un equipo técnico altamente cualificado, con amplia experiencia en diversas áreas.</p>
               </div>
               <div class="benefit-item">
                  <img src="../GlobalAssets/img/tienda/mano.png" alt="Mano">
                  <h3 class="benefit-title" data-i18n="benefits-title3">Precios competitivos</h3>
                  <p class="benefit-text" data-i18n="benefits-desc3">Ofrecemos soluciones técnicas eficientes y rentables, ajustadas a las necesidades reales de cada proyecto y sin costes innecesarios.</p>
               </div>
               <div class="benefit-item">
                  <img src="../GlobalAssets/img/tienda/apretonmanos.png" alt="Apreton de Manos">
                  <h3 class="benefit-title" data-i18n="benefits-title4">Atención personalizada</h3>
                  <p class="benefit-text" data-i18n="benefits-desc4">Cada cliente es único, tenemos un trato directo y cercano asegurando respuestas rápidas y soluciones adaptadas a cada caso.</p>
               </div>
            </section>
         </div>
      </main>
      <footer>
         <div class="section-container footer-wrapper">
            <div class="footer-col brand-info">
               <img src="../GlobalAssets/img/icons/logo-e3i.png" alt="Logo E3i Ingeniería">
               <div class="social-links">
                  <a href="#"><i class="fab fa-facebook-f"></i></a>
                  <a href="#"><i class="fab fa-linkedin-in"></i></a>
                  <a href="#"><i class="fab fa-youtube"></i></a>
                  <a href="#"><i class="fab fa-instagram"></i></a>
               </div>
               <a href="mailto:e3i@e3i.es" class="email-link">e3i@e3i.es</a>
            </div>
            <nav class="footer-nav">
               <div class="footer-links">
                  <h3 data-i18n="footer_home">Inicio</h3>
                  <ul>
                     <li><a href="#" data-i18n="basic_data_title">Datos Básicos</a></li>
                     <li><a href="#" data-i18n="values_title">Valores</a></li>
                     <li><a href="#" data-i18n="areas_title">Áreas</a></li>
                  </ul>
               </div>
               <div class="footer-links">
                  <h3 data-i18n="footer_about">Sobre E3i</h3>
                  <ul>
                     <li><a href="../quienes-somos" data-i18n="menu_home">¿Quiénes Somos?</a></li>
                     <li><a href="../ingenieria" data-i18n="menu_engineering">Ingeniería</a></li>
                     <li><a href="../innovacion" data-i18n="menu_innovation">Innovación</a></li>
                  </ul>
               </div>
               <div class="footer-links">
                  <h3 data-i18n="menu_store">Tienda</h3>
                  <ul>
                     <li><a href="#">ES</a></li>
                     <li><a href="#">EN</a></li>
                     <li><a href="#">FR</a></li>
                  </ul>
               </div>
            </nav>
         </div>
         <div class="copyright" style="text-align: center; padding: 20px 0; background-color: #f0f0f0; margin-top: 20px;">
            <p>© 2025 E3i Ingeniería. Todos los derechos reservados.</p>
         </div>
      </footer>
      <!-- Modal de cookies -->
      <div class="cookies-overlay" id="overlayC" style="display: none;"></div>
      <div class="cookies-modal" id="cookieModal" style="display: none;">
         <div class="logoCookie"></div>
         <div class="explanation">
            <h3 data-i18n="cookies_notification_title">NOTIFICACIÓN DE USO DE COOKIES</h3>
            <div class="internalExp">
               <p data-i18n="cookies_intro_text">Para mejorar tu experiencia en la web, usamos cookies.</p>
               <h4 class="h4Cookie" data-i18n="cookies_data_collected_title">Recolectamos los siguientes datos:</h4>
               <ul class="cookieList">
                  <li data-i18n="cookies_data_1">Día y hora de la visita a la web</li>
                  <li data-i18n="cookies_data_2">Búsquedas internas</li>
                  <li data-i18n="cookies_data_3">Información <u>NO PRIVADA</u> de tu dispositivo como tu Dirección IP</li>
               </ul>
               <h4 class="h4Cookie" data-i18n="cookies_purpose_title">Con el objetivo de:</h4>
               <ul class="cookieList">
                  <li data-i18n="cookies_purpose_1">Mejorar nuestros modelos estadísticos</li>
                  <li data-i18n="cookies_purpose_2">Entender mejor tus necesidades</li>
                  <li data-i18n="cookies_purpose_3">Proteger tus datos</li>
               </ul>
            </div>
            <div class="buttonCookieSet">
               <button class="cookieBtn" id="cookieReject" data-i18n="cookies_reject_btn">Rechazar</button>
               <button class="cookieBtn" id="cookieAccept" data-i18n="cookies_accept_btn">Aceptar</button>
            </div>
         </div>
      </div>
      <script defer>
         // Inicialización de página multilingüe :P
         const currentLang = getLanguage();
         loadLanguage(currentLang, "../GlobalAssets/");        
         
         // Accesibilidad :P
         new AccessibilityWidget("../GlobalAssets/img/accessibility/");
         
      </script>
      <script>
         // Lógica de Cookies
         function setCookie(cname, cvalue, exdays) {
             const d = new Date();
             d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
             let expires = "expires=" + d.toUTCString();
             document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
         }
         
         const cookiePerm = document.cookie.includes("cookie-accepted");
         let cookieNoticement = document.getElementById("cookieModal");
         let hider = document.getElementById("overlayC");
         let cookieBtns = document.getElementsByClassName("cookieBtn");
         let result;
         
         if (!cookiePerm) {   
             hider.style.display = "block"; 
             cookieNoticement.style.display = "block";
         } 
         
         for (let btn of cookieBtns) {
             btn.addEventListener("click", () => {
                 result = btn.getAttribute("id");
                 setCookie("cookie-accepted", result === "cookieAccept" ? "OK" : "KO", 7);
                 window.location = "";
             });
         }
         
      </script>
      <script>
         document.addEventListener('DOMContentLoaded', () => {
             const botonesAgregar = document.querySelectorAll('.btn-add-cart');
             const contadorCesta = document.querySelector('.btn-store');
         
             let carrito = JSON.parse(localStorage.getItem('carrito_e3i')) || [];
         
             function actualizarContador() {
                 const totalProductos = carrito.reduce((total, item) => total + item.cantidad, 0);
                 if (contadorCesta) {
                     contadorCesta.textContent = `Cesta[${totalProductos}]`;
                 }
                 localStorage.setItem('carrito_e3i', JSON.stringify(carrito));
             }
         
             function añadirProducto(e) {
                 const boton = e.target;
                 const id = boton.dataset.id;
                 const productId = boton.dataset.idp;
                 const nombre = boton.dataset.name;
                 const precio = boton.dataset.price;
         
                 const existe = carrito.find(producto => producto.id === id);
                 if (existe) {
                     existe.cantidad++;
                 } else {
                     carrito.push({ id, productId, nombre, precio, cantidad: 1 });
                 }
         
                 actualizarContador();
         
                 // --- CAMBIO PARA TRADUCCIÓN ---
                 const textoOriginal = boton.textContent; // Guarda "Añadir a la cesta" o "Add to cart"
                 
                 // Detectamos el idioma que tiene la página en ese momento
                 const lang = document.documentElement.lang || 'es'; 
                 const mensajeAñadido = (lang === 'en') ? "Added!" : "¡Añadido!";
         
                 boton.textContent = mensajeAñadido;
                 boton.style.backgroundColor = "#28a745"; // Color verde de éxito
         
                 setTimeout(() => {
                     boton.textContent = textoOriginal; // Vuelve al texto que tenía (ya traducido)
                     boton.style.backgroundColor = ""; 
                 }, 800);
             }
         
             botonesAgregar.forEach(boton => {
                 boton.addEventListener('click', añadirProducto);
             });
         
             actualizarContador();
         });
      </script>
   </body>
</html>