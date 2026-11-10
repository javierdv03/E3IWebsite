<?php
namespace App\Utils;
class PasarelaBancaria 
{
    private static $binsAutorizados = [
        // --- BANCO SANTANDER ---
        '491850' => ['banco' => 'Banco Santander', 'red' => 'VISA', 'tipo' => 'Débito'],
        '542415' => ['banco' => 'Banco Santander', 'red' => 'MASTERCARD', 'tipo' => 'Crédito'],
        
        // --- BBVA ---
        '453201' => ['banco' => 'BBVA', 'red' => 'VISA', 'tipo' => 'Crédito'],
        '491672' => ['banco' => 'BBVA', 'red' => 'VISA', 'tipo' => 'Débito'],
        
        // --- CAIXABANK ---
        '454881' => ['banco' => 'CaixaBank', 'red' => 'VISA', 'tipo' => 'Crédito Classic'],
        '510023' => ['banco' => 'CaixaBank', 'red' => 'MASTERCARD', 'tipo' => 'Business'],
        
        // --- ING ---
        '546520' => ['banco' => 'ING Direct', 'red' => 'MASTERCARD', 'tipo' => 'Oro'],
        
        // --- AMERICAN EXPRESS (Emitida directamente) ---
        '375602' => ['banco' => 'American Express', 'red' => 'AMEX', 'tipo' => 'Platinum'],
        '371300' => ['banco' => 'American Express', 'red' => 'AMEX', 'tipo' => 'Green Card'],
    ];

    public static function procesarPago($numeroTarjeta) {
        // 1. Limpiar número
        $numero = preg_replace('/\D/', '', $numeroTarjeta);

        // 2. Validación mínima de longitud
        if (strlen($numero) < 6) {
            return self::respuesta(false, "Error: Número demasiado corto", null);
        }

        // 3. Extraer el BIN (Primeros 6 dígitos)
        $bin = substr($numero, 0, 6);

        // 4. LÓGICA PRINCIPAL: Buscar en nuestra "Base de Datos"
        if (array_key_exists($bin, self::$binsAutorizados)) {
            // ¡BIN ENCONTRADO! -> APROBAMOS
            $infoBanco = self::$binsAutorizados[$bin];
            
            $mensaje = "Pago autorizado por {$infoBanco['banco']} ({$infoBanco['red']} {$infoBanco['tipo']})";
            return self::respuesta(true, $mensaje, $infoBanco);
        } else {
            // BIN NO ENCONTRADO -> RECHAZAMOS
            return self::respuesta(false, "RECHAZADO: El banco emisor del BIN ($bin) no está autorizado en este comercio.", null);
        }
    }

    private static function respuesta($aprobado, $mensaje, $datos) {
        return [
            'estado'  => $aprobado ? 'APROBADO' : 'DENEGADO',
            'mensaje' => $mensaje,
            'detalles'=> $datos,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
}