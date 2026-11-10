<?php
session_start();
if(!isset($_SESSION['Val']) || $_SESSION['Val'] != "user")
{
    header("Location: ../../../Auth");
    exit();
}
$NS = explode(" ", $_SESSION["Name"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../GlobalAssets/img/favicon.ico" type="image/x-icon">
    <title>Modificar datos personales | Panel de control</title>
    <link rel="stylesheet" href="../../../GlobalAssets/css/Admin/baseAdminSheet.css"> <!-- Base Admin Style :P  -->
    <link rel="stylesheet" href="../../../GlobalAssets/css/Icons/iconSheet.css"> <!-- Icon Sheet!  -->
    <link rel="stylesheet" href="../../../GlobalAssets/css/Admin/recycleCssComponents.css"> <!-- Componentes reutilizables  -->

    <link rel="stylesheet" href="../assets/css/perfilModify.css">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.js"></script>     
        <script type="importmap">
        {
            "imports":
            {
                "ProfileController": "../../../GlobalAssets/js/Controllers/Profile/ProfileController.js"
            }
        }
    </script>    

    <script src="./assets/js/main.js" type="module"></script> <!--  Implementing default behaviour of dashboard :PP  -->

    <style>
        #loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.95); /* Fondo negro */
    z-index: 9999;
    display: none;
    justify-content: center;
    align-items: center;
    transition: opacity 0.5s ease-out, visibility 0.5s;
}

.loader-hidden {
    opacity: 0;
    visibility: hidden;
}

/* --- 2. El Loader (Contenedor) --- */
.loader {
    width: 96px;
    height: 96px;
    border-radius: 50%;
    position: relative;
    animation: rotate 1s linear infinite;
}

/* --- 3. Los Anillos con Degradado --- */
.loader::before, .loader::after {
    content: "";
    box-sizing: border-box;
    position: absolute;
    inset: 0px;
    border-radius: 50%;
    
    /* TRUCO: Usamos padding para definir el GROSOR del borde (8px) */
    padding: 8px;
    
    /* AQUI VA TU DEGRADADO */
    background: linear-gradient(
        90deg,
        rgba(3,172,40,0.65) 0%,      
        rgba(50,187,163,0.60) 60%,   
        rgba(0,169,212,0.68) 100%    
    );
    
    /* LA MAGIA: Esto recorta el centro para que parezca un borde */
    -webkit-mask: 
       linear-gradient(#fff 0 0) content-box, 
       linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    
    /* La animación original */
    animation: prixClipFix 2s linear infinite;
}

/* Ajustes para el segundo anillo (el interior) */
.loader::after {
    /* Hacemos que el degradado del anillo interior sea ligeramente distinto 
       invirtiendo la dirección o dejándolo igual. Aquí lo dejo igual. */
    inset: 16px;
    transform: rotate3d(90, 90, 0, 180deg);
}

/* --- Animaciones (Sin cambios) --- */
@keyframes rotate {
    0%   {transform: rotate(0deg)}
    100% {transform: rotate(360deg)}
}

@keyframes prixClipFix {
    0%   {clip-path:polygon(50% 50%,0 0,0 0,0 0,0 0,0 0)}
    50%  {clip-path:polygon(50% 50%,0 0,100% 0,100% 0,100% 0,100% 0)}
    75%, 100% {clip-path:polygon(50% 50%,0 0,100% 0,100% 100%,100% 100%,100% 100%)}
}
    </style>
    

    </head>
<body>
<div id="loader">
        <span class="loader"></span>
    </div>
   <div id="navTriggerer">
        <i class="hamburgerIcon" id="openMenu"></i>
        <i class="crossIcon" id="closeMenu"></i>
    </div>

    <div class="leftNav" id="leftNav"> 

     <div class="innerItems">

        <div class="logout">
            <i class="logoutIcon"></i>
            <a class="commonUrl" href="../logout"> Cerrar la sesión</a>
        </div>

        <div class="user">
            <div class="defaultImg">
                <i class="defaultUserIcon"></i>
            </div>
            <div class="currentSession">
                <span class="commonUrl"> <?= $_SESSION['Name']; ?></span>
                <span class="lowLetter block"> <?= $_SESSION['Email']; ?></span>
            </div>
        </div>     
        
        <div class="controlPanel relative">
            <span class="title absoluteCenterMe"> Panel de control </span>

            <div class="submenu management">
                <div class="alignItemWFlex">
                    <i class="certManagementIcon"></i>
                    <a class="commonUrl boldie itemUnderline" data-text="cert m" href="../">Gestionar pedidos</a>
                </div>
                 <div class="child">

                    <a class="block subitem itemUnderline" data-text="cert m" href="../">Ver pedidos</a>

                 </div>
            </div>
 
            <div class="submenu customer">
                <div class="alignItemWFlex">
                    <i class="defaultUserIcon whiteness"></i>
                    <a class="commonUrl boldie itemUnderline" data-text="customers l" href="./">Datos personales</a>
                </div>
                 <div class="child">

                    <a class="block subitem itemUnderline" data-text="customers l" href="./">Ver perfil</a>

                 </div>
            </div>            


        </div>


     </div>

    </div>
<div class="mainContent">
        <div class="main-container">
            
            <header class="page-header">
                <h1>Editar Perfil</h1>
                <p>Actualiza tus datos personales y contraseña</p>
            </header>

            <div class="card profile-card">
                
                <form action="#" method="POST">

                    <h3 class="section-subtitle">DATOS PERSONALES</h3>
                    
                    <div class="form-grid">
                        
                        <div class="input-group">
                            <label>NOMBRE</label>
                            <input type="text" class="input-shadow" id="nombre" name="nombre" value=<?= $NS[0]; ?> placeholder="Ingresa tu nombre" readonly>
                            <span id="error-nombre" style="display: none; color: red;" data-i18n="error_email">El nombre contiene errores.</span>
                        </div>

                        <div class="input-group">
                            <label>APELLIDOS</label>
                            <input type="text" class="input-shadow" id="apellidos" name="apellidos" value=<?= $NS[1]; ?> placeholder="Ingresa tus apellidos" readonly>
                            <span id="error-apellidos" style="display: none; color: red;" data-i18n="error_email">Los apellidos contienen errores.</span>
                        </div>

                        <div class="input-group">
                            <label>DNI / NIE (no editable) </label>
                            <input type="text" class="input-shadow read-only-style" value=<?= $_SESSION['NIF']; ?> disabled>
                        </div>


                    </div>

                    <h3 class="section-subtitle mt-large">SEGURIDAD</h3>
                    <p class="info-text">Edita los campos a cambiar</p>

                    <div class="form-grid">
                        
                        <div class="input-group full-width">
                            <label>CORREO ELECTRÓNICO (No editable)</label>
                            <input type="email" class="input-shadow read-only-style" value=<?= $_SESSION['Email']; ?> disabled>
                        </div>
                        
                        <div class="input-group">
                            <label>NUEVA CONTRASEÑA</label>
                            <input type="password" class="input-shadow" id="password" name="password" placeholder="••••••••" readonly>
                            <span id="error-password" style="display: none; color: red;" data-i18n="error_email">La contraseña contiene errores.</span>
                        </div>

                        <div class="input-group">
                            <label>REPETIR CONTRASEÑA</label>
                            <input type="password" class="input-shadow" id="r-password" name="r-password" placeholder="••••••••" readonly>
                            <span id="error-r-password" style="display: none; color: red;" data-i18n="error_email">La contraseña contiene errores.</span>
                        </div>
                        <b style="color: red; text-align: center;"> Cómo mínimo debe de tener: 8 caracteres, 2 mayúsculas y 2 caracteres especiales y 2 números.</b>

                    </div>

                    <div class="action-footer">
                        <a href= "./"> <button type="button" class="btn-cancel">CANCELAR</button> </a>
                        <button type="submit" class="btn-save" id="submit">GUARDAR CAMBIOS</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</body>
</html>    