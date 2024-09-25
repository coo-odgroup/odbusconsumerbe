<?php
use DB;

// Added By Banashri Mohanty :: 25-jun-2024 (for security audit weak encryption fixes)
function encryptResponse($data){

    $jsonData = json_encode($data);
    
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($jsonData, 'aes-256-cbc', '252e80b4e5d9cfc8b369ad98dcc87b5f', 0, $iv);
    return base64_encode($encrypted . '::' . base64_encode($iv));
}

// Added By Banashri Mohanty :: 25-jun-2024 (for security audit weak encryption fixes)
function decryptRequest($encryptedData){   
    $decodedData = base64_decode($encryptedData);

    $iv = substr($decodedData, 0, 16);
    $ciphertext = substr($decodedData, 16);

    return openssl_decrypt($ciphertext, 'AES-256-CBC', '252e80b4e5d9cfc8b369ad98dcc87b5f', OPENSSL_RAW_DATA, $iv);

}

function getTicketFareslab($busId,$jrdate){
    $bus_dt=DB::table('bus')->where('id',$busId)->first();
    $opId=$bus_dt->bus_operator_id;
    
    $ticketFareRecord = DB::table('ticket_fare_slab')->where('bus_operator_id', $opId)->where('from_date','<=',$jrdate)->where('to_date','>=',$jrdate)->where('from_date','!=',null)->where('to_date','!=',null)->get();

    if(count($ticketFareRecord)==0){

        $defUserId = Config::get('constants.USER_ID'); 
        $ticketFareRecord= DB::table('ticket_fare_slab')->where('user_id', $defUserId)->get();
       
    }

    return $ticketFareRecord;
}

?>