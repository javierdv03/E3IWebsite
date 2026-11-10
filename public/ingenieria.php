<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingeniería - E3i</title>
    
    <link rel="shortcut icon" href="GlobalAssets/img/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        
    <link rel="stylesheet" href="GlobalAssets/css/Accesibility/accessibility.css">
    <link rel="stylesheet" href="./GlobalAssets/css/global.css">
    <link rel="stylesheet" href="./GlobalAssets/css/ingenieria.css">
    
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
                <li><a href="quienes-somos.html" data-i18n="menu_who_we_are">¿Quiénes Somos?</a></li>
                <li><a href="#" class="active" style="color: var(--color-primary-green); font-weight: 700;" data-i18n="menu_engineering">Ingeniería</a></li>
                <li><a href="innovacion.html" data-i18n="menu_innovation">Innovación</a></li>
                
            <li class="separator"><a href="./Auth/"> <?= isset($_SESSION['Name']) ? "<b><u> <span data-i18n='menu_bienvenido'></span>". $_SESSION['Name'] . "</b></u>": "<span data-i18n='menu_login'></span>"; ?> </a></li>
                
                <li><a href="#" class="lang-btn" data-lang="es" onclick="changeLanguage('es'); return false;">ES</a></li>
                <li><a href="#" class="lang-btn" data-lang="en" onclick="changeLanguage('en'); return false;">EN</a></li>
                <li><a href="#" class="lang-btn" data-lang="fr" onclick="changeLanguage('fr'); return false;">FR</a></li>
                
                <li><a href="Tienda" class="btn-store" data-i18n="menu_store">Tienda</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="engineering-hero">
            <img src="GlobalAssets/img/ingenieria/hero-ingenieria.png" alt="Equipo de ingenieros trabajando">
        </section>

        <section class="section-container areas-intro">
            <h2 data-i18n="engineering_areas_title">Áreas</h2>
        </section>

        <section class="section-container area-block">
            <div class="area-content">
                <div class="area-text left-line">
                    <h3 data-i18n="area_industry_title">Área de Industria</h3>
                    <p data-i18n="area_industry_text">Se abarca la ingeniería y adecuación de instalaciones industriales, agroalimentarias, mineras y de almacenamiento de productos químicos. Incluye también el diseño y legalización de estaciones de servicio, locales de pública concurrencia y naves industriales, así como estudios de protección contra incendios y cálculo de estructuras metálicas.</p>
                </div>
                <div class="area-image">
                    <img src="GlobalAssets/img/ingenieria/industria-detalle.png" alt="Planta industrial">
                </div>
            </div>
        </section>

        <section class="section-container area-block reverse">
            <div class="area-content">
                <div class="area-text left-line">
                    <h3 data-i18n="area_oilgas_title">Área de Oil & Gas</h3>
                    <p data-i18n="area_oilgas_text">Se abarca el desarrollo, legalización y control técnico de instalaciones relacionadas con combustibles líquidos y gaseosos, tanto en entornos industriales como de suministro. Incluye proyectos de almacenamiento, distribución, estaciones de servicio y sistemas de seguridad asociados, garantizando el cumplimiento normativo y la eficiencia operativa.</p>
                </div>
                <div class="area-image">
                    <img src="GlobalAssets/img/ingenieria/oil-gas-detalle.png" alt="Instalaciones de gas">
                </div>
            </div>
        </section>

        <section class="section-container area-block">
            <div class="area-content">
                <div class="area-image">
                    <img src="GlobalAssets/img/ingenieria/edificacion-detalle.png" alt="Edificios modernos">
                </div>
                <div class="area-text right-line-align">
                    <h3 data-i18n="area_building_title">Área de Edificación</h3>
                    <p data-i18n="area_building_text">Se integra servicios de ingeniería y consultoría técnica para todo tipo de edificios, desde obra nueva hasta reformas y rehabilitación. Abarca el diseño de instalaciones, la eficiencia energética, la adaptación a normativa y la gestión integral del proyecto, aportando soluciones completas para arquitectura residencial, terciaria e industrial.</p>
                </div>
            </div>
        </section>

        <section class="section-container area-block reverse-text-right">
            <div class="area-content">
                <div class="area-image">
                    <img src="GlobalAssets/img/ingenieria/energia-detalle.png" alt="Planta de energía">
                </div>
                <div class="area-text right-line-align">
                    <h3 data-i18n="area_energy_title">Área de Energía</h3>
                    <p data-i18n="area_energy_text">Se centra en el diseño, ingeniería y legalización de instalaciones eléctricas en baja y alta tensión, tanto en edificios como en entornos industriales. Integra también proyectos de líneas y centros de transformación, sistemas fotovoltaicos y soluciones especiales de comunicación, voz, datos y megafonía.</p>
                </div>
            </div>
        </section>

        <section class="section-container area-block">
            <div class="area-content">
                <div class="area-text left-line">
                    <h3 data-i18n="area_renewables_title">Área de Renovables</h3>
                    <p data-i18n="area_renewables_text">Se especializa en el diseño, implantación y legalización de sistemas de energía limpia como solar fotovoltaica, solar térmica, biomasa o aerotermia. Su actividad se orienta a la transición energética, la reducción de emisiones y la optimización del consumo, tanto en proyectos industriales como residenciales y de servicios.</p>
                </div>
                <div class="area-image">
                    <img src="GlobalAssets/img/ingenieria/renovables-detalle.png" alt="Energía eólica y solar">
                </div>
            </div>
        </section>

        <section class="section-container area-block reverse">
            <div class="area-content">
                <div class="area-text left-line">
                    <h3 data-i18n="area_security_title">Área de Seguridad</h3>
                    <p data-i18n="area_security_text">Se ofrece servicios orientados a la prevención de riesgos laborales y a la implantación de medidas de protección para trabajadores, instalaciones y entornos productivos. Además, desarrolla actuaciones de control y gestión medioambiental, garantizando el cumplimiento de la normativa vigente y la sostenibilidad de los proyectos.</p>
                </div>
                <div class="area-image">
                    <img src="GlobalAssets/img/ingenieria/seguridad-detalle.png" alt="Centro de control">
                </div>
            </div>
        </section>

        <section class="section-container savings-section">
            <h2 data-i18n="savings_title">Ahorro Energético</h2>
            
            <div class="savings-content">
                <div class="savings-text">
                    <h3 data-i18n="savings_subtitle">Eficiencia que se transforma en resultados reales</h3>
                    <p data-i18n="savings_text_1">En E3i entendemos el ahorro energético no como un objetivo aislado, sino como una estrategia integral de mejora técnica, económica y ambiental. Nuestro trabajo se centra en analizar, optimizar y rediseñar instalaciones y procesos para reducir el consumo, minimizar costes operativos y mejorar el rendimiento global de los sistemas energéticos en edificios, industrias y espacios urbanos.</p>
                    <p data-i18n="savings_text_2">Aplicamos ingeniería avanzada, digitalización y metodologías de control inteligente para que nuestros clientes consuman menos, produzcan mejor y operen con mayor fiabilidad, alineándose con los nuevos estándares de sostenibilidad y competitividad.</p>
                    
                    <h3 class="sub-title" data-i18n="savings_how_title">¿Cómo logramos el ahorro energético?</h3>
                    <ul class="savings-list">
                        <li data-i18n="savings_item_1">Auditorías y diagnósticos energéticos avanzados</li>
                        <li data-i18n="savings_item_2">Optimización de instalaciones térmicas, eléctricas y de climatización</li>
                        <li data-i18n="savings_item_3">Integración de energías renovables y sistemas híbridos</li>
                        <li data-i18n="savings_item_4">Automatización y monitorización en tiempo real de consumos</li>
                        <li data-i18n="savings_item_5">Rediseño de procesos industriales con enfoque de eficiencia global</li>
                        <li data-i18n="savings_item_6">Sustitución tecnológica</li>
                        <li data-i18n="savings_item_7">Implantación de sistemas de control y regulación inteligente</li>
                        <li data-i18n="savings_item_8">Modelos predictivos de consumo con análisis de datos</li>
                    </ul>
                </div>
                
                <div class="savings-image">
                    <img src="GlobalAssets/img/ingenieria/ahorro-energetico.png" alt="Gráfico de ahorro energético E3i">
                </div>
            </div>
        </section>
    </main>

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
