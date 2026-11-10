<?php
session_start();
require_once dirname(__DIR__) . "/vendor/autoload.php";
require_once dirname(__DIR__) . "/src/Models/Visitor/VisitorModel.php";
require_once dirname(__DIR__) . "/src/Models/Param/ParamModel.php";
use App\Models\Visitor\VisitorModel;
use App\Models\Param\ParamModel;

$modelInstator = new VisitorModel();
$modelInstator->updateVisitors();

$paramModelInstator = new ParamModel();
$params = $paramModelInstator->getParams();

$paso1 = preg_replace('/(,\s\d+)\s/', '$1<br>', $params["ubicacion"]);


$direccion_final = preg_replace('/(\d{5})\s/', '$1<br>', $paso1);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E3i Ingeniería</title>
    
    <link rel="shortcut icon" href="GlobalAssets/img/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <link rel="stylesheet" href="./GlobalAssets/css/Accesibility/accessibility.css">
    <link rel="stylesheet" href="./GlobalAssets/css/landing.css">
    <link rel="stylesheet" href="./GlobalAssets/css/global.css">
    
    <script src="./GlobalAssets/js/Components/Translator/translator.js"></script>
    <script src="./GlobalAssets/js/Components/Accesibility/accessibility.js"></script>
    <script src="./GlobalAssets/js/menu.js"></script>

</head>
<body>

   <header>
    <a href="" class="logo">
        <img src="GlobalAssets/img/icons/logo-e3i.png" alt="Logo E3i Ingeniería">
    </a>
    
    <button class="hamburger" id="hamburgerBtn" aria-label="Menú">
        <span></span>
        <span></span>
        <span></span>
    </button>
    
    <nav class="main-nav" id="mainNav">
        <ul>
            <li><a href="quienes-somos" data-i18n="menu_home">¿Quiénes Somos?</a></li>
            <li><a href="ingenieria" data-i18n="menu_engineering">Ingeniería</a></li>
            <li><a href="innovacion" data-i18n="menu_innovation">Innovación</a></li>
            
            <li class="separator"><a href="./Auth/"> <?= isset($_SESSION['Name']) ? "<b><u> <span data-i18n='menu_bienvenido'></span>". $_SESSION['Name'] . "</b></u>": "<span data-i18n='menu_login'></span>"; ?> </a></li>
            
            <li><a href="#" class="lang-btn" data-lang="es" onclick="changeLanguage('es'); return false;">ES</a></li>
            <li><a href="#" class="lang-btn" data-lang="en" onclick="changeLanguage('en'); return false;">EN</a></li>
            <li><a href="#" class="lang-btn" data-lang="fr" onclick="changeLanguage('fr'); return false;">FR</a></li>

            <li><a href="./Tienda/index.html" class="btn-store" data-i18n="menu_store">Tienda</a></li>
        </ul>
    </nav>
</header>


    <main>
        <section class="hero-section">
            <img src="GlobalAssets/img/landing/molinos-viento.png" alt="Molinos de viento">
        </section>

        <section class="section-container about-us">
            <div class="about-us-wrapper">
                <div class="about-us-text">
                    <blockquote class="quote">
                        <strong data-i18n="hero_quote_bold">E3i transformamos la ingeniería en soluciones eficientes y de calidad</strong> 
                        <span data-i18n="hero_quote_text">para los sectores de edificación, industria y servicios, con más de 15 años de experiencia y un firme compromiso con la satisfacción del cliente.</span>
                    </blockquote>
                </div>
                <div class="about-us-image">
                    <img src="GlobalAssets/img/landing/apreton-manos.png" alt="Apretón de manos">
                </div>
            </div>
        </section>

        <section class="section-container basic-data">
            <h2 data-i18n="basic_data_title">Datos básicos</h2>

            <div class="data-items-container">
                <div class="data-block with-separator">
                    <p class="number">+150</p>
                    <p class="label" data-i18n="data_clients">Clientes</p>
                </div>

                <div class="data-block">
                    <p class="number">32</p>
                    <p class="label" data-i18n="data_years">Años de experiencia</p>
                </div>
            </div>
        </section>

        <section class="section-container our-values">
            <h2 data-i18n="values_title">Valores</h2>
            <div class="values-grid">
                <div class="value-item with-horizontal-line">
                    <img src="GlobalAssets/img/landing/icono1.png" alt="Icono El cliente" class="value-icon-img">
                    <h3 data-i18n="value_client_title">El cliente</h3>
                    <p data-i18n="value_client_text">Es el centro de nuestra actividad</p>
                </div>
                
                <div class="value-item with-horizontal-line">
                    <img src="GlobalAssets/img/landing/icono2.png" alt="Icono Las personas" class="value-icon-img">
                    <h3 data-i18n="value_people_title">Las personas</h3>
                    <p data-i18n="value_people_text">Son la base y el fundamento de E3i</p>
                </div>
                
                <div class="value-item"> 
                    <img src="GlobalAssets/img/landing/icono3.png" alt="Icono El desarrollo personal" class="value-icon-img">
                    <h3 data-i18n="value_dev_title">El desarrollo personal</h3>
                    <p data-i18n="value_dev_text">E3i es una empresa de personas altamente cualificadas que buscan la excelencia</p>
                </div>
            </div>
        </section>

        <section class="areas-section">
            <div class="section-container">
                <h2 data-i18n="areas_title">Áreas</h2>
                <div class="areas-grid">
                    <div class="area-item">
                        <img src="GlobalAssets/img/landing/industria.png" alt="Industria">
                        <p data-i18n="area_industry">Industria</p>
                    </div>
                    <div class="area-item">
                        <img src="GlobalAssets/img/landing/oil-gas.png" alt="Oil & Gas">
                        <p>Oil & Gas</p>
                    </div>
                    <div class="area-item">
                        <img src="GlobalAssets/img/landing/seguridad.png" alt="Seguridad">
                        <p data-i18n="area_security">Seguridad</p>
                    </div>
                    <div class="area-item">
                        <img src="GlobalAssets/img/landing/edificacion.png" alt="Edificación">
                        <p data-i18n="area_building">Edificación</p>
                    </div>
                    <div class="area-item">
                        <img src="GlobalAssets/img/landing/energia.png" alt="Energía">
                        <p data-i18n="area_energy">Energía</p>
                    </div>
                    <div class="area-item">
                        <img src="GlobalAssets/img/landing/renovables.png" alt="Renovables">
                        <p data-i18n="area_renewables">Renovables</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-container social-contribution">
            <div class="contribution-wrapper">
                <div class="contribution-text">
                    <h2 data-i18n="social_title">Aportación a la sociedad</h2>
                    <p data-i18n="social_text_1">En <strong>E3i</strong> aplicamos la ingeniería con un propósito claro: <strong>mejorar la vida de las personas y proteger el entorno</strong>.</p>
                    <p data-i18n="social_text_2">Desde la energía y la industria hasta la seguridad y el medio ambiente, desarrollamos soluciones que impulsan la eficiencia, la sostenibilidad y el bienestar colectivo.</p>
                </div>
                <div class="contribution-image">
                    <img src="GlobalAssets/img/landing/solucion-energetica.png" alt="Solución energética">
                </div>
            </div>
        </section>

        <section class="section-container location-section">
            <h2 data-i18n="location_title">Dónde nos encontramos</h2>
            
            <div class="location-wrapper">
                <div class="location-info">
                    
                    <div class="location-item">
                        <div class="location-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="location-text">
                            <h3 data-i18n="location_address_title">Nuestra oficina</h3>
                            <p data-i18n="location_address_text">
                                <?= $direccion_final; ?>
                            </p>
                        </div>
                    </div>

                    <div class="location-item">
                        <div class="location-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="location-text">
                            <h3 data-i18n="location_email_title">Correo electrónico</h3>
                            <a href="mailto:<?=$params["email"];?>"><?=$params["email"];?></a>
                        </div>
                    </div>

                    <div class="location-item">
                        <div class="location-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="location-text">
                            <h3 data-i18n="location_phone_title">Teléfono</h3>
                            <a href="tel:<?=$params["telefono"];?>"><?=$params["telefono"];?></a>
                        </div>
                    </div>

                </div>
                <div class="location-map">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3193.212111363855!2d-2.4569448!3d36.837395799999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd7a9dc608b17c03%3A0x282b6c8530345d3e!2sE3i%20Ingenier%C3%ADa!5e0!3m2!1ses!2ses!4v1768081543637!5m2!1ses!2ses" 
                        width="600" 
                        height="450" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
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
                        <a href="./Tienda/index.html" data-i18n="menu_store" class="footer-title-link">Tienda</a>
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
        // Cookies :P
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
                window.location = location.pathname;
            });
        }

        
    </script>


</body>
</html>
