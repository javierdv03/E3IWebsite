<?php
session_start();
if(!isset($_SESSION['Val']) || $_SESSION['Val'] != "admin")
{
    header("Location: ../../../Auth");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../GlobalAssets/img/favicon.ico" type="image/x-icon">
    <title>Registrar certificado | Panel de control</title>
    <link rel="stylesheet" href="../../../GlobalAssets/css/Admin/baseAdminSheet.css"> <!-- Base Admin Style :P  -->
    <link rel="stylesheet" href="../../../GlobalAssets/css/Icons/iconSheet.css"> <!-- Icon Sheet!  -->
    <link rel="stylesheet" href="../../../GlobalAssets/css/Admin/recycleCssComponents.css"> <!-- Componentes reutilizables  -->
    <link rel="stylesheet" href="../assets/css/certs.css">

    <script src="../../../GlobalAssets/js/dashMain.js" type="module"></script> 
        <script type="importmap">
        {
            "imports":
            {
                "CertificateController": "../../../GlobalAssets/js/Controllers/Certificate/CertificateController.js"
            }
        }
    </script>
    
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.js"></script>    

    <script src="./assets/js/main.js" type="module"></script>

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
            <a class="commonUrl" href="../../logout"> Cerrar la sesión</a>
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
            <a class="title absoluteCenterMe" href="../"> Panel de control </a>

            <div class="submenu management">
                <div class="alignItemWFlex">
                    <i class="certManagementIcon"></i>
                    <a class="commonUrl boldie itemUnderline" data-text="cert m" href="./">Gestionar certificados</a>
                </div>
                 <div class="child">

                    <a class="block subitem itemUnderline" data-text="cert m" href="./modificar">Modificar certificado</a>
                    <a class="block subitem itemUnderline" data-text="cert r" href="./">Registrar certificado</a>

                 </div>
            </div>
 
            <div class="submenu customer">
                <div class="alignItemWFlex">
                    <i class="defaultUserIcon whiteness"></i>
                    <a class="commonUrl boldie itemUnderline" data-text="customers l" href="../Cliente/">Gestionar clientes</a>
                </div>
                 <div class="child">

                    <a class="block subitem itemUnderline" data-text="customers l" href="../Cliente/">Listado de clientes</a>

                 </div>
            </div>            

            <div class="submenu sells ">
                <div class="alignItemWFlex">
                    <i class="cartIcon"></i>
                    <a class="commonUrl boldie itemUnderline" data-text="sales l" href="../Venta">Gestionar ventas</a>
                </div>
                 <div class="child">

                    <a class="block subitem itemUnderline" data-text="sales l" href="../Venta">Listado de ventas</a>

                 </div>
            </div>  

        </div>

        <div class="internalOperations relative">
            <a class="title absoluteCenterMe" data-text="admin a" href="../Ajustes/"> Ajustes de página </a>
    
            <div class="submenu admin">
                <div class="alignItemWFlex">
                    <i class="adminSettingsIcon"></i>
                    <a class="commonUrl boldie itemUnderline" href="../Ajustes/">Ajustes de administración</a>
                </div>
            </div> 

            <div class="submenu internal">
                <div class="alignItemWFlex">
                    <i class="settingsIcon"></i>
                    <a class="commonUrl boldie itemUnderline" data-text="innerOptions m" href="../Parametros/">Parámetros internos</a>
                </div>
            </div>      


        </div>

     </div>

    </div>

<div class="main-container">
        <header class="page-header">
            <h1>Registrar certificado</h1>
            <p>¿Quieres registrar un nuevo producto? Sin problema, rellena el siguiente formulario.</p>
        </header>

        <div class="card">
            
            <div class="form-section">
                <h3 class="section-instruction">Introduzca los datos del tipo de certificado a crear</h3>
                
                <div class="section-title-row">
                    <span class="info-icon">i</span>
                    <h2>DATOS TIENDA</h2>
                </div>
                <p class="section-desc">Estos son los datos que se mostrarán en la tienda</p>

                <div class="inputs-grid">
                    <div class="col-left">
                        <div class="input-group">
                            <label>NOMBRE</label>
                            <input type="text" id="nombre" name="nombre" placeholder="Un nombre" required>
                            <span id="error-nombre" style="display: none; color: red;" data-i18n="error_email">El nombre contiene errores.</span>
                        </div>
                        <div class="input-group">
                            <label>TIPO</label>
                            <input type="text" id="tipo" name="tipo" placeholder="A" required>
                            <span id="error-tipo" style="display: none; color: red;" data-i18n="error_email">El tipo contiene errores.</span>
                        </div>                        
                        <div class="input-group">
                            <label>PRECIO</label>
                            <input type="number" id="precio" name="precio" placeholder="xx.xx" required>
                            <span id="error-precio" style="display: none; color: red;" data-i18n="error_email">El precio contiene errores.</span>
                        </div>
                    </div>

                    <div class="col-right">
                        <div class="input-group full-height">
                            <label>DESCRIPCIÓN</label>
                            <textarea placeholder="" id="descripcion" name="descripcion" placeholder="Una descripción" required></textarea>
                            <span id="error-descripcion" style="display: none; color: red;" data-i18n="error_email">La descripción contiene errores.</span>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="separator">

            <div class="preview-section">
                <div class="section-title-row">
                    <span class="info-icon">i</span>
                    <h2>VISTA PREVIA</h2>
                </div>

                <div class="preview-grid">
                    <div class="preview-image">
                        <img src="../../../GlobalAssets/img/tienda/certificado.png" alt="Calificación Energética">
                    </div>

                    <div class="preview-details">
                        <h3 id="nombre-mirror">Certificado Energético A</h3>
                        <p class="subtitle" id="tipo-mirror">Certificado Energético</p>
                        <p class="price" id="precio-mirror">?? €</p>
                        <p class="description-text" id="descripcion-mirror">
                            Cuerpo del texto para describir qué es este producto y por qué es una compra imprescindible.
                        </p>

                        <button class="btn-save" id="submit">
                            GUARDAR<br>PRODUCTO
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
</body>
</html>