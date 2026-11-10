<?php
session_start();
if(!isset($_SESSION["NIF"]))
{
    header("Location: ./");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificación en dos pasos - E3i</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Global (variables, tipografía, reset) -->
    <link rel="stylesheet" href="../GlobalAssets/css/global.css">
    <!-- Estilos específicos de esta vista -->
    <link rel="stylesheet" href="assets/css/inicio-sesion.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="shortcut icon" href="../GlobalAssets/img/favicon.ico" type="image/x-icon">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" integrity="sha512-CNgIRecGo7nphbeZ04Sc13ka07paqdeTu0WR1IM4kNcpmBAUSHSQX0FslNhTDadL4O5SAGapGt4FodqL8My0mA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="importmap">
        {
            "imports":
            {
                "AuthController": "../GlobalAssets/js/Controllers/Auth/AuthController.js"
            }
        }
    </script>
    <style>
        /* Contenedor principal para centrar todo */
.login-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #f4f7f9;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    padding: 20px;
}

.login-left {
    background: #ffffff;
    max-width: 450px;
    width: 100%;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    text-align: center;
}

.login-logo img {
    max-width: 120px;
    margin-bottom: 30px;
}

/* Sección 2FA */
.two-factor-section h2 {
    color: #333;
    font-size: 1.4rem;
    margin-bottom: 25px;
    line-height: 1.3;
}

.qrContainer {
    background: #f8fafc;
    padding: 30px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
}

/* El cuadro donde irá el QR */
#qrToScan {
    background: white;
    padding: 15px;
    display: inline-block;
    border: 1px solid #ddd;
    border-radius: 8px;
    margin-bottom: 20px;
}

#qrToScan svg, #qrToScan img {
    display: block;
    width: 200px;
    height: 200px;
}

/* Texto del código secreto */
.qrContainer p {
    font-size: 0.9rem;
    color: #64748b;
    margin-top: 15px;
}

#secret {
    display: block;
    margin-top: 10px;
    font-family: 'Courier New', Courier, monospace;
    font-size: 1.2rem;
    letter-spacing: 2px;
    color: #1e293b;
    background: #e2e8f0;
    padding: 8px;
    border-radius: 4px;
    word-break: break-all;
}
    </style>
</head>
<body>
<div id="loader">
        <span class="loader"></span>
    </div>    
<div class="login-wrapper">
    <section class="login-left">
        <div class="login-logo">
            <img src="../GlobalAssets/img/icons/logo-e3i.png" alt="Logo E3i">
        </div>

        <div class="two-factor-section">
                <h2>Verificación en dos pasos</h2>
                <p style="color: #666; margin-bottom: 20px;">Escanee  o introduzca el código con Google Authenticator o su app de confianza.</p>

            <div class="qrContainer" style="display: none;">
                <div id="qrToScan">
                    </div>
                
                <p>¿No puedes escanear el QR? <br> Introduce este código manualmente:</p>
                <b id="secret">VNHU C6WN UFWY AUEB</b>
            </div>
            
            <div style="margin-top: 25px; ">
                <input type="text" 
                       placeholder="Introduce el código de 6 dígitos" 
                       id="2FA"
                       class="login-input login"
                       required
                       pattern="[0-9]{6}"
                       title="El código debe tener exactamente 6 números"
                       maxlength="6"
                       inputmode="numeric"
                       autocomplete="one-time-code"
                       name="2FA">

                <span id="error-2FA" style="display: none; color: red;">El código 2FA no es válido.</span> 

               <div class="captcha" style="margin-top: 20px;">
                     <div class="g-recaptcha" data-sitekey="6LfigzosAAAAAF0Y2EZIc5GS9gVHOLXgU5NXbjci"></div>
                    <span id="error-h-captcha-response" style="display: none; color: red;">Debes de completar el reCaptcha.</span>  
                 </div>    

                <button class="login-btn primary" id="getInto">
                    Acceder
                </button>
            </div>
        </div>
    </section>
</div>

<script type="module">
    import {AuthFrontEnd} from "AuthController";

    function markAsError(...ids)
    {
        ids = ids[0].split(",");

        for(let id of ids)
        {
            let getItem = document.getElementById(id);

            if(!getItem) getItem = document.getElementsByName(id)[0];

            getItem.classList.add("error");

            document.getElementById(`error-${id}`).style.display = "block";
        }

    }

    const getQrCode = localStorage.getItem("qrCode");
    const qrContainer = document.getElementsByClassName("qrContainer")[0];
    const QRCodeId = document.getElementById("qrToScan");
    const secretId = document.getElementById("secret");

    if(getQrCode && getQrCode.match(/^otpauth:\/\/totp\/[a-zA-Z0-9.%:_ \-]+(\?|&)(?:[a-zA-Z0-9.%:_ \-]+=[a-zA-Z0-9.%:_ \-]+&?)*secret=[A-Z2-7]+(?:&[a-zA-Z0-9.%:_ \-]+=[a-zA-Z0-9.%:_ \-]+)*$/i)) 
    {
            qrContainer.style.display = "block";
            new QRCode(QRCodeId, getQrCode);
            secretId.innerText = getQrCode.split("secret=")[1].split("&")[0];
    } 


    const sendBtn = document.getElementById("getInto");

    sendBtn.addEventListener("click", async (event) => 
    {
        event.preventDefault();
        let loader = document.getElementById("loader");
        loader.style.display = "flex";        

        try 
        {
             const inputsInvolved = {"2FA": document.getElementById("2FA").value, "g-recaptcha-response": document.getElementsByName("g-recaptcha-response")[0].value };
             const authMe = new AuthFrontEnd( inputsInvolved );
            
             const result = await authMe.executeVerify2Fa(localStorage.getItem("X-Authenticator"));

             switch (result.statusCode) 
             {
                case 200:
                    localStorage.setItem("X-Authenticator", result.response);
                    top.location.href = "../Dashboard";
                return;

                case 301:
                    top.location.href = "./VerifyMail";
                    return;

                case 401:
                    document.getElementById("error-2FA").style.display = "block";
                    window.grecaptcha.reset();
                return;

                    
             
                default:
                    alert("SOMETHING IS NOT WORKING AS EXPECTED");
                    debugger;
                break;
             }

             if(window.grecaptcha) window.grecaptcha.reset();

             throw new Error(Array.from(inputsInvolved, el => el.id));   

        } catch (SyntaxError) 
        {
             markAsError(SyntaxError.message);
             return;

        } finally
        {
            loader.style.display = "none";
        }   
       
    });
</script>
    
</body>
</html>