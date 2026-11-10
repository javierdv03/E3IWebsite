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
    <title>Perfil | Panel de control</title>
    <link rel="stylesheet" href="../../../GlobalAssets/css/Admin/baseAdminSheet.css"> <!-- Base Admin Style :P  -->
    <link rel="stylesheet" href="../../../GlobalAssets/css/Icons/iconSheet.css"> <!-- Icon Sheet!  -->
    <link rel="stylesheet" href="../../../GlobalAssets/css/Admin/recycleCssComponents.css"> <!-- Componentes reutilizables  -->

    <link rel="stylesheet" href="../assets/css/perfilRead.css">

    <script src="../assets/js/main.js" type="module"></script> <!--  Implementing default behaviour of dashboard :PP  -->

    
</head>

<body>
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
                <h1>Mi Perfil</h1>
                <p>Consulta tu información personal registrada</p>
            </header>

            <div class="card profile-card">

                <div class="profile-data">
                    
                    <h3 class="section-subtitle">INFORMACIÓN PERSONAL</h3>
                    
                    <div class="form-grid">
                        
                        <div class="input-group">
                            <label>NOMBRE</label>
                            <input type="text" class="input-shadow" value=<?= $NS[0]; ?> readonly>
                        </div>

                        <div class="input-group">
                            <label>APELLIDOS</label>
                            <input type="text" class="input-shadow" value=<?= $NS[1]; ?> readonly>
                        </div>

                        <div class="input-group">
                            <label>DNI / NIE</label>
                            <input type="text" class="input-shadow" value=<?= $_SESSION['NIF']; ?> readonly>
                        </div>


                    </div>

                    <h3 class="section-subtitle mt-large">SEGURIDAD DE LA CUENTA</h3>

                    <div class="form-grid">
                        
                        <div class="input-group full-width">
                            <label>CORREO ELECTRÓNICO</label>
                            <input type="email" class="input-shadow" value=<?= $_SESSION['Email']; ?> readonly>
                        </div>

                    </div>

                    <div class="action-bar">
                        <a href="./modificar"> <button class="btn-edit-profile">MODIFICAR DATOS</button> </a>
                    </div>

                </div>

            </div>
        </div>
    </div>

</body>
</html>        