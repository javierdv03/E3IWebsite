<?php
session_start();

if(!isset($_SESSION['Val']) || !isset($_POST['items'])) 
{
    header("Location: ../Auth");
    exit();
}

require_once dirname(__DIR__) . "/../src/Models/Certificates/CertificateModel.php";
require_once dirname(__DIR__) . "/../src/Utils.php";
use App\Models\Certificate\CertificateModel;

$modelInstator = new CertificateModel();

$items = $_POST['items'];

$explodedItems = array_filter(explode(";", $items)); 

$assocArray = [];

$itemsToProcess = [];

foreach($explodedItems as $item) 
{
    $expItem = explode("x", $item);

    if(count($expItem) === 2) 
    {
        $val = $modelInstator->getSpecificCert($expItem[0] ?? -1);

        if(count($val) === 0)  die("No tienes pedidos para ordenar.");

        array_push($itemsToProcess, $expItem[0]);

        $assocArray[$val[0]["nombre"]] = [
            
            "precio" => $val[0]["precio"] * $expItem[1],
            "nombre" => $val[0]["nombre"],
            "tipo" => $val[0]["tipo"],
        ];
    }
}
$_SESSION['toBuy'] = $itemsToProcess;
$nombreUnstaged = explode(" ", $_SESSION['Name']);


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Seguro - E3i</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="shortcut icon" href="../GlobalAssets/img/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../GlobalAssets/css/pasarela.css"> 
        <script type="importmap">
        {
            "imports":
            {
                "PaymentController": "../GlobalAssets/js/Controllers/Payment/PaymentController.js"
            }
        }
    </script>
    
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.js"></script>    

    <script src="./assets/js/main.js" type="module"></script>

    <style>
        .error-msg{display: none;}
    </style>


    </head>
<body>


<div id="loader-overlay" class="loader-hidden">
    <div class="spinner"></div>
    <p>Procesando pago de forma segura...</p>
</div>

<div class="top-bar">
    <img src="../GlobalAssets/img/icons/logo-e3i.png" class="logo" alt="Logo E3i">
    <a href="./" class="volver">
        <span class="volver-texto">Volver a la tienda</span>
        <i class="fa-solid fa-arrow-left"></i>
    </a>
</div>

<div class="contenedor">
    
    <form class="formulario" id="mainForm">
        
        <div class="seccion-header">
            <h2>1. Detalles de Envío</h2>
        </div>

        <div class="fila">
            <div class="campo-grupo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="<?=$nombreUnstaged[0];?>" style="background-color:#ccc;" data-validate="texto" disabled required>
                <span class="error-msg" id="error-nombre"> El nombre contiene errores.</span>
            </div>
            <div class="campo-grupo">
                <label for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" value="<?=$nombreUnstaged[1];?>" style="background-color:#ccc;" data-validate="texto" disabled required>
                <span class="error-msg" id="error-apellidos">Los apellidos contienen errores.</span>
            </div>
        </div>


        <div class="fila">
            <div class="campo-grupo full-width">
                <label for="envioDireccion">Dirección Completa</label>
                <input type="text" id="envioDireccion" name="envioDireccion" placeholder="Calle, número, piso..." data-validate="direccion" required>
                <span class="error-msg" id="error-envioDireccion">La dirección contiene errores.</span>
            </div>
        </div>

        <div class="fila">
            <div class="campo-grupo">
                <label for="envioCiudad">Ciudad</label>
                <input type="text" id="envioCiudad" name="envioCiudad" data-validate="texto" required>
                <span class="error-msg" id="error-envioCiudad">La ciudad contiene errores.</span>
            </div>
            <div class="campo-grupo">
                <label for="envioProvincia">Provincia / Estado</label>
                <input type="text" id="envioProvincia" name="envioProvincia" data-validate="texto" required>
                <span class="error-msg" id="error-envioProvincia">La provincia contiene errores.</span>
            </div>
        </div>

        <div class="fila">
            <div class="campo-grupo">
                <label for="envioCP">Código Postal</label>
                <input type="text" id="envioCP" name="envioCP" inputmode="numeric" style="width: 30%" maxlength="5" data-validate="cp" required>
                <span class="error-msg" id="error-envioCP">El código postal contiene errores.</span>
            </div>

        </div>

   <div class="seccion-header pago-header">
    <h2>2. Método de Pago</h2>
    <div class="iconos-tarjetas">
    <i class="fa-brands fa-cc-visa" id="icon-visa"></i>
    <i class="fa-brands fa-cc-mastercard" id="icon-mastercard"></i>
    <i class="fa-brands fa-cc-amex" id="icon-amex"></i>
    <i class="fa-brands fa-cc-discover" id="icon-discover"></i>
</div>
</div>

        <div class="card-box">

            <div class="fila">
                <div class="campo-grupo full-width">
                    <label for="pagoNombre">Nombre en la tarjeta</label>
                    <input type="text" id="pagoNombre" name="pagoNombre" placeholder="Como aparece en la tarjeta" data-validate="texto">
                    <span class="error-msg" id="error-pagoNombre">El nombre de titular contiene errores.</span>
                </div>
            </div>

            <div class="fila">
                <div class="campo-grupo full-width input-icon-container">
                    <label for="pagoTarjeta">Número de tarjeta</label>
                    <input type="text" id="pagoTarjeta" name="pagoTarjeta" placeholder="0000 0000 0000 0000" maxlength="19" inputmode="numeric">
                    <i class="fa-solid fa-credit-card input-icon" id="card-type-indicator"></i>
                    <span class="error-msg" id="error-pagoTarjeta">El número de tarjeta contiene errores.</span>
                </div>
            </div>

            <div class="fila multipes-datos">
                <div class="campo-grupo">
                    <label>Caducidad (MM / AA)</label>
                    <div class="fecha-group">
                        <input type="text" id="pagoMes" name="pagoMes" placeholder="MM" maxlength="2" inputmode="numeric">
                       
                        <span class="slash">/</span>
                        <input type="text" id="pagoAnio" name="pagoAnio" placeholder="AA" maxlength="2" inputmode="numeric">
                        
                    </div>
                    <span class="error-msg" id="error-pagoMes">El mes de vencimiento contiene errores.</span>
                    <span class="error-msg" id="error-pagoAnio">El año de vencimiento contiene errores.</span>
                    <span class="error-msg" id="error-fecha"></span>
                </div>

                <div class="campo-grupo">
                    <label>CVV <i class="fa-solid fa-circle-question tooltip" title="3 dígitos al reverso"></i></label>
                    <div class="input-icon-container">
                        <input type="text" id="pagoCvv" name="pagoCvv" placeholder="123" maxlength="4" inputmode="numeric" style="width: 80px;">
                        <i class="fa-solid fa-lock input-icon"></i>
                    </div>
                    <span class="error-msg" id="error-pagoCvv">El CVV contiene errores.</span>
                </div>
            </div>
        </div>

    </form>

    <div class="resumen-wrapper">
        <div class="resumen">
            <h3>Resumen del pedido</h3>
            
            <div class="item-lista">
                <?= injectProducts(2, $assocArray); ?>
            </div>

            <hr>

            <?= injectProducts(3, $assocArray); ?>
            
            <p class="seguridad-footer">
                <i class="fa-solid fa-shield-halved"></i> Pagos encriptados con SSL 256-bit
            </p>
        </div>
    </div>

</div>

<div id="modalErrorBin" class="modal-overlay" aria-hidden="true">
    <div class="modal-wrapper">
        <div class="modal-card">
            
            <button class="modal-close-btn" onclick="cerrarModalError()">&times;</button>
            
            <div class="modal-icon-box error">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </div>

            <h3 class="modal-title">Pago Rechazado</h3>
            <p class="modal-message">
                Lo sentimos, la tarjeta proporcionada no es válida para esta operación. 
                <br><br>
                <strong style="color: #d32f2f;">Motivo: BIN no registrado o no autorizado.</strong>
                <br>
                Por favor, revisa los datos o intenta con otra tarjeta bancaria.
            </p>

            <div class="modal-actions">
                <button class="e3i-popup-btn e3i-popup-btn-cancel" onclick="cerrarModalError()">Cancelar</button>
                <button class="e3i-popup-btn e3i-popup-btn-action" onclick="intentarOtraTarjeta()">Probar otra tarjeta</button>
            </div>

        </div>
    </div>
</div>

<script>
    function mostrarErrorBIN() {
    const modal = document.getElementById('modalErrorBin');
    modal.classList.add('is-visible');
    // Bloquear scroll del body para que no se mueva el fondo
    document.body.style.overflow = 'hidden';
}

// Función para CERRAR el modal
function cerrarModalError() {
    const modal = document.getElementById('modalErrorBin');
    modal.classList.remove('is-visible');
    // Restaurar scroll
    document.body.style.overflow = '';
}

// Función para reiniciar el campo de tarjeta (Acción del botón rojo)
function intentarOtraTarjeta() {
    cerrarModalError();
    
    // Aquí pon la lógica para limpiar el input de la tarjeta y poner el foco
    const inputTarjeta = document.querySelector('input[name="pagoTarjeta"]');
    if(inputTarjeta) {
        inputTarjeta.value = ''; 
        inputTarjeta.focus();
        // Opcional: resaltar el borde en rojo
        inputTarjeta.style.borderColor = 'red';
    }
}
document.getElementById('modalErrorBin').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalError();
    }
});
</script>

<script src="../GlobalAssets/js/validacion.js"></script>
</body>
</html>