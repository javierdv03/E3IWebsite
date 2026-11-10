<?php
session_start();
if(isset($_SESSION['Val']))
{
    header("Location: ../Dashboard/");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title data-i18n="login_page_title">Iniciar sesión - E3i</title>    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Global (variables, tipografía, reset) -->
    <link rel="stylesheet" href="../GlobalAssets/css/global.css">
    <!-- Estilos específicos de esta vista -->
    <link rel="stylesheet" href="assets/css/inicio-sesion.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="shortcut icon" href="../GlobalAssets/img/favicon.ico" type="image/x-icon">
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

<div id="loader">
        <span class="loader"></span>
    </div>
<div class="login-wrapper">

    <!-- Botón volver -->
    <a href="../" class="login-back-btn" aria-label="Volver a inicio">
        <img src="./assets/img/boton.png" alt="Volver">
    </a>

    <!-- Columna izquierda: logo + formulario -->
    <section class="login-left">
        <div class="login-logo">
            <img src="../GlobalAssets/img/icons/logo-e3i.png" alt="Logo E3i">
        </div>

        <div class="login-form-container">
            <h1 class="login-title" id="title" data-i18n="login_title">INICIA SESIÓN</h1>
            <form class="login-form" id="formEx" context="login">
                <!-- EMAIL -->
                <label for="email" class="login-label" data-i18n="login_email_label">EMAIL</label>
                <input type="email"
                       id="email"
                       name="email"
                       class="login-input login"
                       required
                       data-i18n="login_email_placeholder"
                       placeholder="Email"
                       autocomplete="new-password">
                <span id="error-email" style="display: none; color: red;" data-i18n="error_email">El email contiene errores.</span>
                <!-- CONTRASEÑA -->

                <label for="password" class="login-label" data-i18n="login_password_label">CONTRASEÑA</label>
                <div class="input-wrapper" id="wrap">

                <span class="toggle-icon" id="btnToggle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                </span>
                
                <input type="password"
                       id="password"
                       name="password"
                       class="login-input login"
                       required
                       data-i18n="login_password_placeholder"
                       placeholder="Contraseña">
                </div>
               <div id="pwDetail" class="passwordProtection" style="display: none;">
                    <span data-i18n="password_req_title">La contraseña debe de tener</span>
                    <ul>
                        <li id="longitud" data-i18n="password_req_length">Al menos 8 caracteres</li>
                        <li id="numeros" data-i18n="password_req_numbers">Al menos 2 números (0-9)</li>
                        <li id="mayusculas" data-i18n="password_req_uppercase">Al menos 2 caracteres en mayúscula (A-Z)</li>
                        <li id="especiales" data-i18n="password_req_special">Al menos 1 caracter especial (!,#,@)</li>
                    </ul>
                </div>
                <span id="error-password" style="display: none; color: red;" data-i18n="error_password">La contraseña no parece correcta</span> 
                <div id="registerFields" style="display: none;">

                      <label for="rPassword" class="login-label" data-i18n="login_rpassword_label">Repetir contraseña</label>

                      <div class="input-wrapper" id="fp">

                        <span class="toggle-icon" id="btnToggle2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                        </span>

                        
                        <input type="password"
                            id="rPassword"
                            name="rPassword"
                            class="login-input"
                            data-i18n="login_password_placeholder"
                            placeholder="Contraseña">

                       
                        </div> 
                         <span id="error-rPassword" style="display: none; color: red;" data-i18n="error_rpassword">Las contraseñas no coinciden</span> 
                        <br>
                         <label for="name" class="login-label" data-i18n="login_name_label">Nombre</label>

                         <input type="text"
                            id="name"
                            name="name"
                            class="login-input register"
                            data-i18n="login_name_placeholder"
                            placeholder="Nombre"
                            >  

                         <span id="error-name" style="display: none; color: red;" data-i18n="error_name">El formato del nombre no es válido</span>   
                        <br><br>
                         <label for="surname" class="login-label" data-i18n="login_surname_label">Apellidos</label>

                         <input type="text"
                            id="surname"
                            name="surname"
                            class="login-input register"
                            data-i18n="login_surname_placeholder"
                            placeholder="Apellidos"
                            > 
                        <span id="error-surname" style="display: none; color: red;" data-i18n="error_surname">El formato de los apellidos no es válido</span> 
                        <br><br>
                        <label for="NIF" class="login-label" data-i18n="login_nif_label">Documento de identidad</label>

                         <input type="text"
                            id="NIF"
                            name="NIF"
                            class="login-input register"
                            data-i18n="login_nif_placeholder"
                            placeholder="Documento de identidad"
                            maxlength="9"> 
                        <span id="error-NIF" style="display: none; color: red;" data-i18n="error_nif">El formato del documento no es válido</span>   
                        <br><br>
                        <label for="phone" class="login-label" data-i18n="login_phone_label">Número de teléfono</label>                        
                         <input type="text"
                            id="phone"
                            name="phone"
                            class="login-input register"
                            data-i18n="login_phone_placeholder"
                            placeholder="+34XXXXXXXXX"
                            value="+34 "
                            maxlength="15"> 
                        <span id="error-phone" style="display: none; color: red;" data-i18n="error_phone">El formato del número de teléfono no es válido</span>                                             
                </div>

                <div class="g-recaptcha" data-sitekey="6LfigzosAAAAAF0Y2EZIc5GS9gVHOLXgU5NXbjci"></div>

                 <span id="error-g-recaptcha-response" class="error" style="display: none; color: red;">Debes de completar el reCaptcha.</span> 

                <!-- Olvidar contraseña -->
                <a href="./ForgotPass.html"
                   id = "forgot"
                   class="login-forgot"
                   data-i18n="login_forgot">
                    ¿Has olvidado tu contraseña?
                </a>

                <!-- Botones -->
                <button type="submit"
                        id="loginBtn"
                        class="login-btn primary"
                        data-i18n="login_signin">
                    INICIAR SESIÓN
                </button>

                <button type="button"
                        class="login-btn secondary"
                        id="registerBtn"
                        data-i18n="login_signup">
                    REGÍSTRATE
                </button>
            </form>
        </div>
    </section>

    <!-- Columna derecha: imagen grande -->
    <section class="login-right">
        <img src="./assets/img/obreros.png"
             alt="Obra de construcción" class="login-side-image">
    </section>

</div>

<script src="./assets/js/main.js" type="module"></script> 
<script src="./assets/js/translator.js" type="module"></script> 

</body>
</html>
