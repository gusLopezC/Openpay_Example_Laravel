<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Openpay;

require_once '../vendor/autoload.php';

class PaymentController extends Controller
{
    public function store(Request $request){
         $openpay = Openpay::getInstance('mdrhnprmsmxkgxtegzhk', 'sk_c71babd865fd420b94bc588a8585c122');
        
         $customer = array(
            'name' => $request->name,
            'email' => "prueba@correo.com"
        );
    
        $chargeData = array(
            'method' => 'card',
            'source_id' => $request->token_id,
            'amount' => 110.00, // formato númerico con hasta dos dígitos decimales. 
            'device_session_id' => $request->deviceIdHiddenFieldName,
            'customer' => $customer
        );
    
        $charge = $openpay->charges->create($chargeData);

        $responseJson = new \stdClass();
		$responseJson->status = true;
		$responseJson->msg = "Pago con exito";
		$responseJson->id = $charge->id;
		$responseJson->status = $charge->status;
        
        return json_encode($responseJson);
    }
}
