<?php
namespace App\Models\Payment;
session_start();

require_once dirname(__DIR__) . "/../Utils.php";
require_once dirname(__DIR__) . "/../PasarelaBancaria.php";
require_once dirname(__DIR__) . "/../Models/Order/OrderModel.php";
require_once dirname(__DIR__) . "/../Models/EmailVerification/EmailVerificationModel.php";
require_once dirname(__DIR__) . "/../Models/Certificates/CertificateModel.php";

use App\Models\Order\OrderModel;
use App\Models\EmailVerification\EmailVerificationModel;
use App\Models\Certificate\CertificateModel;
use App\Utils\PasarelaBancaria;

class PaymentModel
{

    private OrderModel $oModel;

    private EmailVerificationModel $eModel;

    private CertificateModel $cModel;

    public function __construct()
    {
        $this->oModel = new OrderModel();
        $this->eModel = new EmailVerificationModel();
        $this->cModel = new CertificateModel();
    }

    private function obtenerFechaFactura() {
        $mesesCortos = [
            1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun',
            7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'
        ];

        $dia = date('d');             // 11
        $numMes = (int) date('n');    // 1 (para buscar en el array)
        $anio = date('Y');            // 2026

        return "$dia " . $mesesCortos[$numMes] . ", $anio";
    }    

    private function generarUUID() {
        // Generamos 16 bytes (128 bits) de aleatoriedad criptográfica
        $data = random_bytes(16);

        // Ajustamos los bits para cumplir con la versión 4 (UUID aleatorio)
        // El byte 6 debe empezar por 0100 (hex 4)
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        
        // El byte 8 debe empezar por 10 (variante DCE 1.1)
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Convertimos a hexadecimal y formateamos con guiones
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }    

    public function doPayment(String $address, String $city, String $region, String $zipcode, String $card, String $m, String $y, String $cvv, String $cName) : array
    {
        $fm = $m . "/".$y;

        $cardValidity = validarTarjetaCompleta($card, $fm );

        if(!$cardValidity["valido"]) return ["error" => "true", "reason" => $cardValidity["error"]];

        $paymentResult = PasarelaBancaria::procesarPago($card);

        if(!hash_equals("APROBADO", $paymentResult["estado"])) return ["error" => "medium", "reason" => $paymentResult["mensaje"]];

        $itemsToProcess = $_SESSION['toBuy'];
        $NIF = $_SESSION['NIF'];
        $_SESSION['UUID'] = $this->generarUUID();
        $_SESSION['NOW'] = $this->obtenerFechaFactura();

        $totalPrice = .0;

        foreach($itemsToProcess as $idProducto) 
        {
            $this->oModel->insertOrder($address, $region, $zipcode, $NIF, $idProducto);
            $totalPrice += (float) $this->cModel->getPrice($idProducto);
        }

        $_SESSION['TOTAL'] = $totalPrice + ($totalPrice * 0.21);

        $this->eModel->sendBill($_SESSION['Email'], $_SESSION['Name'], $_SESSION['UUID'] ,$this->obtenerFechaFactura(), $totalPrice);

        return ["error" => "false", "reason" => ""];


    }

}