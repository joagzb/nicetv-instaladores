<?php


namespace App\repository;


use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;

class PlataformaCobradoresAPI {

    /*
     * pedirle los usuarios a la API de la plataforma de cobradores
     * */
    public static function getUsersCobradores(){
        $endpoint = "https://cobradores.nicetv.com.ar/api/users/cobrador";
        $client = new \GuzzleHttp\Client();
        $access_token = env('PLAT_COBRADORES_KEY_ACCESS');
    
        try {
            $response = $client->request('GET', $endpoint, ['query' => [
                'access_token' => $access_token,
            ]]);
            $statusCode = $response->getStatusCode();
            $json = json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return null;
        }
    
    
        return $json;

//        $response = Http::get('https://cobradores.nicetv.com.ar/api/users/cobrador?access_token=' . env('PLAT_COBRADORES_KEY_ACCESS'));
//        $json = $response->json();
//        $successful = $response->successful();
//        $serverError = $response->serverError();
//        $clientError = $response->clientError();
//        if (!$clientError && !$serverError && $successful) {
//            return $json;
//        } else {
//            return null;
//        }
    }

    /*
     * obtener un usuario en particular
     * */
  public static function getUsersCobradorByID($userCobrador){
      $response = Http::get('https://cobradores.nicetv.com.ar/api/users/cobrador/'. $userCobrador .'?access_token=' . env('PLAT_COBRADORES_KEY_ACCESS'));
      $json = $response->json();
      $successful = $response->successful();
      $serverError = $response->serverError();
      $clientError = $response->clientError();
      if (!$clientError && !$serverError && $successful) {
          return $json;
      } else {
          return null;
      }
  }

}
