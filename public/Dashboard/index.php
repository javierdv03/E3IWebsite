<?php
session_start();

if(!isset($_SESSION['Val'])) 
{
    header("Location: ../Auth");
    exit();
}


$ruta = ($_SESSION["Val"] === "user") ? "Usuario" : "Admin";


header("Location: ./" . $ruta);
exit();