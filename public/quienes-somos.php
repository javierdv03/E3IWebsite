<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiénes Somos - E3i</title>
    
    <link rel="shortcut icon" href="GlobalAssets/img/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        
    <link rel="stylesheet" href="GlobalAssets/css/Accesibility/accessibility.css">
    <link rel="stylesheet" href="./GlobalAssets/css/global.css">
    <link rel="stylesheet" href="./GlobalAssets/css/quienes-somos.css">
    
    <script src="GlobalAssets/js/Components/Translator/translator.js"></script>
    <script src="GlobalAssets/js/Components/Accesibility/accessibility.js"></script>
    <script src="GlobalAssets/js/menu.js"></script>
</head>
<body>

    <header>
        <a href="./" class="logo">
            <img src="GlobalAssets/img/icons/logo-e3i.png" alt="Logo E3i Ingeniería">
        </a>
  <button class="hamburger" id="hamburgerBtn" aria-label="Menú">
        <span></span>
        <span></span>
        <span></span>
    </button>
        <nav class="main-nav" id="mainNav">
            <ul>
                <li><a href="#" class="active" style="color: var(--color-primary-green); font-weight: 700;" data-i18n="menu_who_we_are">¿Quiénes Somos?</a></li>
                <li><a href="ingenieria" data-i18n="menu_engineering">Ingeniería</a></li>
                <li><a href="innovacion" data-i18n="menu_innovation">Innovación</a></li>
                
            <li class="separator"><a href="./Auth/"> <?= isset($_SESSION['Name']) ? "<b><u> <span data-i18n='menu_bienvenido'></span>". $_SESSION['Name'] . "</b></u>": "<span data-i18n='menu_login'></span>"; ?> </a></li>
                
                <li><a href="#" class="lang-btn" data-lang="es" onclick="changeLanguage('es'); return false;">ES</a></li>
                <li><a href="#" class="lang-btn" data-lang="en" onclick="changeLanguage('en'); return false;">EN</a></li>
                <li><a href="#" class="lang-btn" data-lang="fr" onclick="changeLanguage('fr'); return false;">FR</a></li>
                
                <li><a href="Tienda/" class="btn-store" data-i18n="menu_store">Tienda</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="section-container history-block">
            <div class="history-content">
                <div class="history-text">
                    <h2 data-i18n="history_title">Todo comenzó...</h2>
                    <p data-i18n="history_text_1">Desde su constitución en 2004, E3i-procdos Sociedad Limitada estableció como base de su funcionamiento la integridad, el compromiso con la excelencia técnica y el desarrollo del talento humano que integra la compañía, en un entorno de respeto, colaboración y libertad profesional. Esta forma de actuar se refleja en todos sus proyectos: ingeniería, arquitectura, instalaciones y eficiencia energética, para edificación, industria y terciario.</p>
                </div>
                <div class="history-image">
                    <img src="GlobalAssets/img/quienes-somos/quienes-somos-historia-1.png" alt="Equipo de E3i">
                </div>
            </div>
        </section>

        <section class="section-container history-block reverse">
            <div class="history-content">
                <div class="history-image">
                    <img src="GlobalAssets/img/quienes-somos/quienes-somos-historia-2.png" alt="Mesa de reuniones">
                </div>
                <div class="history-text">
                    <p data-i18n="history_text_2">Los primeros lineamientos escritos sobre estilo y valores internos se gestaron cuando la empresa evolucionó de su denominación original ("PROCDOS SL") a la nueva identidad "E3i-Procdos SL". En ese momento se definieron los compromisos hacia clientes, proveedores, colaboradores y entidades con las que mantiene vínculos, incluyendo una política de tolerancia cero frente a cualquier conducta indebida o ilícita, y la exigencia de un comportamiento profesional ejemplar.</p>
                </div>
            </div>
        </section>

        <section class="section-container history-block">
            <div class="history-content">
                <div class="history-text">
                    <p data-i18n="history_text_3">Con su actividad centrada en la prestación de servicios energéticos, eficiencia energética en instalaciones comerciales, industriales y residenciales, además de la promoción y construcción de viviendas, edificios y naves industriales, E3i ha incorporado estos valores a su día a día empresarial.</p>
                </div>
                <div class="history-image">
                    <img src="GlobalAssets/img/quienes-somos/quienes-somos-historia-3.png" alt="Diagrama de servicios E3i">
                </div>
            </div>
        </section>

        <section class="section-container compliance-section">
            <h2 data-i18n="compliance_title">Sistema de Cumplimiento Normativo</h2>
            
            <div class="compliance-grid">
                <div class="compliance-item">
                    <img src="GlobalAssets/img/quienes-somos/compliance-confianza.png" alt="Icono Confianza">
                    <h3 data-i18n="compliance_trust_title">Confianza</h3>
                    <p data-i18n="compliance_trust_text">Confianza mutua entre la empresa y sus colaboradores</p>
                </div>
                
                <div class="compliance-item">
                    <img src="GlobalAssets/img/quienes-somos/compliance-transparencia.png" alt="Icono Transparencia">
                    <h3 data-i18n="compliance_transparency_title">Transparencia</h3>
                    <p data-i18n="compliance_transparency_text">Transparencia en sus relaciones con personas, clientes, proveedores e instituciones</p>
                </div>
                
                <div class="compliance-item">
                    <img src="GlobalAssets/img/quienes-somos/compliance-responsabilidad.png" alt="Icono Responsabilidad">
                    <h3 data-i18n="compliance_responsibility_title">Responsabilidad</h3>
                    <p data-i18n="compliance_responsibility_text">Responsabilidad social y ética profesional</p>
                </div>
                
                <div class="compliance-item">
                    <img src="GlobalAssets/img/quienes-somos/compliance-mejora.png" alt="Icono Mejora">
                    <h3 data-i18n="compliance_improvement_title">Mejora</h3>
                    <p data-i18n="compliance_improvement_text">Mejora continua del talento y de los procesos</p>
                </div>
            </div>
        </section>

        <section class="section-container works-section">
            <h2 data-i18n="works_title">Trabajos</h2>
            
            <div class="works-single-image-container">
                <img src="GlobalAssets/img/quienes-somos/collage.png" alt="Portafolio de trabajos E3i" class="collage-image">
            </div>
        </section>
    </main>

    <!-- Footer -->

    <!-- Footer -->

    <footer>
        <div class="section-container footer-wrapper">
            <div class="footer-col brand-info">
                <img src="GlobalAssets/img/icons/logo-e3i.png" alt="Logo E3i Ingeniería">
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
                     <h3>
                     <a href="./" data-i18n="footer_home" class="footer-title-link">Inicio</a>
                    </h3>
                 <ul>
                      <li><span class="footer-item" data-i18n="basic_data_title">Datos Básicos</span></li>
                      <li><span class="footer-item" data-i18n="values_title">Valores</span></li>
                      <li><span class="footer-item" data-i18n="areas_title">Áreas</span></li>
                 </ul>
            </div>

                <div class="footer-links">
                    <h3 data-i18n="footer_about">Sobre E3i</h3>
                    <ul>
                        <li><a href="quienes-somos" data-i18n="menu_home">¿Quiénes Somos?</a></li>
                        <li><a href="ingenieria" data-i18n="menu_engineering">Ingeniería</a></li>
                        <li><a href="innovacion" data-i18n="menu_innovation">Innovación</a></li>
                    </ul>
                </div>
               <div class="footer-links">
                        <h3>
                        <a href="./Tienda/" data-i18n="menu_store" class="footer-title-link">Tienda</a>
                        </h3>
                 <ul>
                        <li><a href="#" class="js-lang lang-btn" data-lang="es" onclick="changeLanguage('es'); return false;">ES</a></li>
                        <li><a href="#" class="js-lang lang-btn" data-lang="en" onclick="changeLanguage('en'); return false;">EN</a></li>
                        <li><a href="#" class="js-lang lang-btn" data-lang="fr" onclick="changeLanguage('fr'); return false;">FR</a></li>
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
        loadLanguage(currentLang);        

        // Accesibilidad :P
        new AccessibilityWidget();

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


</body>
</html>
