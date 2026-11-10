<?php

function validarDniNie(string $documento): bool
{
    // 1. Limpieza: Pasamos a mayúsculas y quitamos guiones o espacios
    $documento = strtoupper(trim($documento));
    $documento = str_replace(['-', ' '], '', $documento);

    // 2. Validación de formato básico con Regex
    // Grupo 1 ($matches[1]): Los 8 primeros caracteres (Números o X/Y/Z + 7 números)
    // Grupo 2 ($matches[2]): La letra final
    if (!preg_match('/^([XYZ0-9]\d{7})([A-Z])$/', $documento, $matches)) {
        return false; // El formato no es válido
    }

    $numero = $matches[1];
    $letraProporcionada = $matches[2];

    // 3. Tratamiento especial para NIE (extranjeros)
    // Si empieza por X, Y o Z, se sustituye por 0, 1 o 2 respectivamente para el cálculo
    $numero = str_replace(['X', 'Y', 'Z'], ['0', '1', '2'], $numero);

    // 4. Cálculo de la letra correcta (Algoritmo Módulo 23)
    $mapaLetras = 'TRWAGMYFPDXBNJZSQVHLCKE';
    
    // Obtenemos el resto de la división por 23
    $indice = (int)$numero % 23;
    
    // Buscamos qué letra corresponde a ese índice
    $letraCorrecta = $mapaLetras[$indice];

    // 5. Comparación final
    return $letraCorrecta === $letraProporcionada;
}

function calcularPorcentaje($actual, $anterior): float {
    // 1. Evitar división por cero
    if ($anterior == 0) {
        // Si antes era 0 y ahora tienes ventas, es un aumento del 100% (o infinito)
        // Si ambos son 0, el cambio es 0%
        return ($actual > 0) ? 100 : 0;
    }

    // 2. Aplicar fórmula
    $diferencia = $actual - $anterior;
    $porcentaje = ($diferencia / $anterior) * 100;

    return $porcentaje;
}


function injectProducts(int $Option, array $products): String
{
    $html = '';

    switch ($Option) 
    {
        case 0:
                foreach ($products as $product) {
                    // Concatenamos el HTML usando sintaxis Heredoc
                    $html .= <<<HTML
                    <div class="product-item">
                        <a href="detalles?idProducto={$product['idProducto']}">
                            <img src="../GlobalAssets/img/tienda/certificado.png" alt="Certificado Energético A" class="cert-image">
                        </a>
                        
                        <h2 class="product-title" data-i18n="product-title1">{$product['nombre']}</h2>

                        <h3 data-i18n="product-title1">{$product['tipo']}</h3>
                        
                        <p class="product-description" data-i18n="product-desc1">{$product['descripcion']}</p>

                        <p class="highlight-price">{$product['precio']} €</p>
                        
                        <div class="product-actions">
                            <a href="detalles?idProducto={$product['idProducto']}">
                                <button class="btn-buy-add" data-i18n="buy-product">Comprar</button>
                            </a>
                            
                            <button class="btn-buy-add btn-add-cart" 
                                data-i18n="add-product-cart"
                                data-id="cert-{$product['nombre']}" 
                                data-name="{$product['nombre']}"
                                data-price="{$product['precio']}"
                                data-idP="{$product['idProducto']}">
                                Añadir a la cesta
                            </button>
                        </div>
                    </div>
            HTML;
                }
                return $html;
            
        case 1:
                foreach ($products as $product) {
                    // Concatenamos el HTML usando sintaxis Heredoc
                    $html .= <<<HTML
                    
                        <div class="product-item">
                            <a href="detalles?idProducto={$product['idProducto']}" style="text-decoration:none;color:black;">
                                <img src="../GlobalAssets/img/tienda/certificado.png" alt="Certificado Energético A" class="cert-image">
                                <h2 class="product-title" data-i18n="product-title1">{$product['nombre']}</h2>
                                <h3 data-i18n="product-title1">{$product['tipo']}</h3>
                                <p class="product-description" data-i18n="product-desc1">{$product['descripcion']}</p>
                                <p class="product-price">{$product['precio']} €</p>
                            </a>                                
                        </div>
                   
                    HTML;
                }
                return $html; 
        case 2:
                foreach ($products as $product) {
                    
                    $html .= <<<HTML
                                    <div class="item">
                                        <div class="item-img"></div> <div class="item-info">
                                            <p class="item-nombre">{$product['nombre']}</p>
                                            <p class="item-meta">{$product['tipo']}</p>
                                        </div>
                                        <p class="item-precio">{$product['precio']}€</p>
                                    </div>
                    HTML;                                    
                }                
            return $html;

        case 3:
            $priceUpdated = 0;
            foreach ($products as $product) $priceUpdated += $product['precio'];

            $ivaTeorico = $priceUpdated * 0.21; 

            // Truncamos el IVA también (misma lógica)
            $ivaStr = (string)$ivaTeorico;
            if (($pos = strpos($ivaStr, '.')) !== false) {
                $ivaTruncado = (float)substr($ivaStr, 0, $pos + 3);
            } else {
                $ivaTruncado = (float)$ivaTeorico;
            }

            // PASO 3: Sumar
            $total = $priceUpdated + $ivaTruncado;
        

            // PASO 4: Formatear solo para VISUALIZAR (Aquí sí ponemos la coma)
            $precioDisplay = number_format($priceUpdated, 2, ",", ".");
            $ivaDisplay    = number_format($ivaTruncado, 2, ",", ".");
            $totalDisplay  = number_format($total, 2, ",", "."); 

            $html = <<<HTML
                            <div class="desglose">
                                <div class="fila-precio">
                                    <span>Subtotal</span>
                                    <span>{$precioDisplay}€</span>
                                </div>
                                <div class="fila-precio">
                                    <span>Impuestos (21%)</span>
                                    <span>{$ivaDisplay}€</span>
                                </div>
                            </div>

                            <hr>

                            <div class="total-row">
                                <span>Total a pagar</span>
                                <span class="total-grande">{$totalDisplay}€</span>
                            </div>

                            <button id="submit" class="continuar">
                                <i class="fa-solid fa-lock"></i> Pagar {$totalDisplay}€
                            </button>            
                    HTML;
            return $html;

        default:
           return $html;
    }


}

function validarTarjetaCompleta($numero, $fechaMMAA): array {
    // --- PASO 1: LIMPIEZA Y VALIDACIÓN BÁSICA ---
    
    // Eliminamos espacios y guiones del número
    $numeroLimpio = preg_replace('/\D/', '', $numero);
    
    // Eliminamos espacios de la fecha
    $fechaLimpia = trim($fechaMMAA);

    // Verificamos que quede algo en el número
    if (empty($numeroLimpio)) {
        return ['valido' => false, 'error' => 'El número de tarjeta está vacío o es inválido.'];
    }

    // --- PASO 2: ALGORITMO DE LUHN (Integridad del número) ---
    
    $suma = 0;
    $longitud = strlen($numeroLimpio);
    $paridad = $longitud % 2;

    for ($i = 0; $i < $longitud; $i++) {
        $digito = (int) $numeroLimpio[$i];

        if (($i % 2) == $paridad) {
            $digito *= 2;
            if ($digito > 9) {
                $digito -= 9;
            }
        }
        $suma += $digito;
    }

    if (($suma % 10) !== 0) {
        return ['valido' => false, 'error' => 'Número de tarjeta incorrecto (Fallo Luhn).'];
    }

    // --- PASO 3: VALIDACIÓN DE FECHA (Formato y Caducidad) ---

    // Regex estricta para MM/AA
    if (!preg_match('/^([1-9]|1[0-2])\/\d{2}$/', $fechaLimpia)) {
        return ['valido' => false, 'error' => 'Formato de fecha inválido. Use MM/AA (ej: 05/26).'];
    }

    list($mes, $anio) = explode('/', $fechaLimpia);
    
    $mesInput = (int)$mes;
    $anioInput = (int)$anio; // Será 25, 26, etc.

    $anioActual = (int)date('y'); // Devuelve 2 dígitos (ej: 25)
    $mesActual  = (int)date('n'); // Devuelve 1-12 sin ceros

    // Comprobación temporal
    if ($anioInput < $anioActual) {
        return ['valido' => false, 'error' => 'La tarjeta está caducada (Año vencido).'];
    }

    if ($anioInput === $anioActual && $mesInput < $mesActual) {
        // Ejemplo: Si estamos en Mayo (5) y la tarjeta es 04/25
        return ['valido' => false, 'error' => 'La tarjeta está caducada (Mes vencido).'];
    }

    // --- SI LLEGA AQUÍ, TODO ESTÁ CORRECTO ---
    return ['valido' => true, 'mensaje' => 'Tarjeta válida y vigente.'];
}





