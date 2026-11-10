<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Innovación - E3i</title>
    
    <link rel="shortcut icon" href="GlobalAssets/img/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        
    <link rel="stylesheet" href="GlobalAssets/css/Accesibility/accessibility.css">
    <link rel="stylesheet" href="./GlobalAssets/css/global.css">
    <link rel="stylesheet" href="./GlobalAssets/css/innovacion.css">
    
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
                <li><a href="quienes-somos" data-i18n="menu_who_we_are">¿Quiénes Somos?</a></li>
                <li><a href="ingenieria" data-i18n="menu_engineering">Ingeniería</a></li>
                <li><a href="#" class="active" style="color: var(--color-primary-green); font-weight: 700;" data-i18n="menu_innovation">Innovación</a></li>
                
            <li class="separator"><a href="./Auth/"> <?= isset($_SESSION['Name']) ? "<b><u> <span data-i18n='menu_bienvenido'></span>". $_SESSION['Name'] . "</b></u>": "<span data-i18n='menu_login'></span>"; ?> </a></li>
                
                <li><a href="#" class="lang-btn" data-lang="es" onclick="changeLanguage('es'); return false;">ES</a></li>
                <li><a href="#" class="lang-btn" data-lang="en" onclick="changeLanguage('en'); return false;">EN</a></li>
                <li><a href="#" class="lang-btn" data-lang="fr" onclick="changeLanguage('fr'); return false;">FR</a></li>
                
                <li><a href="Tienda/" class="btn-store" data-i18n="menu_store">Tienda</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="idi-section">
            <div class="idi-wrapper">
                <div class="idi-side-img">
                    <img src="GlobalAssets/img/innovacion/id-semilla.png" alt="Manos sosteniendo planta">
                </div>

                <div class="idi-text-content">
                    <h2 data-i18n="idi_title">I+D+i</h2>
                    
                    <p data-i18n="idi_text_1">En <strong>E3i</strong> concebimos la <strong>innovación</strong> como el motor que impulsa nuestra actividad desde la <strong>ingeniería</strong> hacia la generación de <strong>soluciones reales, eficientes y sostenibles</strong>. No entendemos la <strong>I+D+i</strong> como un departamento aislado, sino como una <strong>forma de trabajar</strong> que atraviesa cada proyecto, cada análisis técnico y cada decisión estratégica. Nuestra misión no es solo <strong>aplicar lo que ya existe</strong>, sino <strong>desarrollar lo que todavía no está disponible</strong> para nuestros clientes, anticipándonos a las <strong>nuevas necesidades energéticas, tecnológicas y de mercado</strong>.</p>
                    
                    <p data-i18n="idi_text_2">Vivimos en un contexto empresarial y social donde la <strong>transición energética</strong>, la <strong>digitalización avanzada</strong> y la <strong>descarbonización</strong> ya no son tendencias futuras, sino <strong>prioridades presentes</strong>. Por ello, en E3i apostamos por una <strong>innovación aplicada</strong>, con impacto directo sobre la <strong>eficiencia energética</strong>, la <strong>optimización de instalaciones</strong> y la creación de <strong>productos y metodologías propias</strong> que aportan <strong>valor añadido</strong> y diferencian a nuestros clientes en términos de <strong>competitividad, sostenibilidad y seguridad técnica</strong>.</p>
                    
                    <p data-i18n="idi_point_1"><strong>Experiencia técnica sólida</strong>, fruto de años de trabajo en ingeniería e instalaciones.</p>
                    <p data-i18n="idi_point_2"><strong>Capacidad de análisis y diseño avanzado</strong>, apoyada en datos, simulación y tecnología digital.</p>
                    <p data-i18n="idi_point_3"><strong>Visión estratégica del sector energético y de la industria</strong>, que nos permite anticipar normativas, modelos de gestión y necesidades futuras.</p>
                    <p data-i18n="idi_point_4"><strong>Cultura interna orientada a la mejora continua</strong>, donde cada proyecto es también un laboratorio de aprendizaje y evolución.</p>
                </div>

                <div class="idi-side-img">
                    <img src="GlobalAssets/img/innovacion/id-bombilla.png" alt="Bombilla innovación">
                </div>
            </div>
        </section>

        <section class="section-container vision-section">
            <h2 data-i18n="vision_title">Nuestra visión de la innovación</h2>
            
            <div class="vision-text">
                <p data-i18n="vision_text">En E3i entendemos la <strong>innovación como un proceso continuo</strong>, que va más allá de incorporar tecnología: consiste en transformar la forma en que se diseña, gestiona y optimiza la energía en <strong>edificios, industria y ciudades</strong>.</p>
            </div>

            <div class="vision-image">
                <img src="GlobalAssets/img/innovacion/vision-proyectos.png" alt="Tablero de ideas">
            </div>
        </section>

        <section class="section-container lines-section">
            <h2 data-i18n="lines_title">Líneas de trabajo</h2>
            
            <div class="lines-grid">
                <div class="lines-text-col">
                    <div class="line-item">
                        <p data-i18n="line_1">Sistemas inteligentes de monitorización y control energético</p>
                    </div>
                    <div class="line-item">
                        <p data-i18n="line_2">Modelos predictivos de consumo en industria y edificación</p>
                    </div>
                    <div class="line-item">
                        <p data-i18n="line_3">Soluciones modulares y escalables para gestión energética en tiempo real</p>
                    </div>
                </div>
                
                <div class="lines-img-col">
                    <img src="GlobalAssets/img/innovacion/lines-diagrama.png" alt="Diagrama E3i Global">
                </div>

                <div class="lines-text-col">
                    <div class="line-item">
                        <p data-i18n="line_4">Optimización de instalaciones térmicas, eléctricas y de climatización</p>
                    </div>
                    <div class="line-item">
                        <p data-i18n="line_5">Automatización y digitalización de infraestructuras técnicas</p>
                    </div>
                    <div class="line-item">
                        <p data-i18n="line_6">Integración de energías renovables y almacenamiento con gestión digital</p>
                    </div>
                </div>
                
                <div class="lines-img-col">
                    <img src="GlobalAssets/img/innovacion/lines-servicios.png" alt="Diagrama Conectividad">
                </div>
            </div>
        </section>

        <section class="section-container compliance-section">
            <h2 data-i18n="compliance_quality_title">Compromiso con la calidad y el cumplimiento</h2>
            
            <div class="compliance-text-wrapper">
                <p data-i18n="compliance_quality_text">
                    Nuestra <span class="highlight">actividad innovadora</span> se desarrolla bajo un marco sólido de cumplimiento 
                    <span class="highlight">normativo, responsabilidad técnica y cultura ética</span>, alineada con nuestras 
                    políticas de <span class="highlight">calidad y sostenibilidad.</span>
                </p>
            </div>
        </section>

        <section class="section-container results-section">
            <h2 data-i18n="results_title">Innovación que se transforma en resultados</h2>
            
            <div class="results-wrapper">
                <div class="results-table-container">
                    <div class="results-table">
                        <div class="table-header">
                            <span data-i18n="results_table_header_benefit">BENEFICIO</span>
                            <span data-i18n="results_table_header_application">APLICACIÓN</span>
                        </div>
                        
                        <div class="table-row">
                            <span data-i18n="results_benefit_1">Reducción del consumo energético</span>
                            <span data-i18n="results_application_1">Industria, edificios, comercios</span>
                        </div>
                        <div class="table-row">
                            <span data-i18n="results_benefit_2">Disminución de emisiones</span>
                            <span data-i18n="results_application_2">Procesos y redes de climatización</span>
                        </div>
                        <div class="table-row">
                            <span data-i18n="results_benefit_3">Mayor fiabilidad de las instalaciones</span>
                            <span data-i18n="results_application_3">Mantenimiento predictivo</span>
                        </div>
                        <div class="table-row">
                            <span data-i18n="results_benefit_4">Ahorro económico medible</span>
                            <span data-i18n="results_application_4">Contratos de eficiencia y ESE</span>
                        </div>
                    </div>
                </div>

                <div class="plant-image">
                    <img src="GlobalAssets/img/innovacion/id-planta.png" alt="Planta creciendo en tierra">
                </div>
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
