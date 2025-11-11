<?php

declare(strict_types=1);

namespace App\Core;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Nette\Utils\ArrayHash;


/**
 * responseApi classe che si occupa di uniformare le risposte delle chiamate
 */
class responseApi {
	public readonly int $code;
	public readonly string $description;
	public readonly array $response;

    public function __construct(Response|Exception $response){
        $classType = "GuzzleHttp\Psr7\Response";
        $this->code = (is_a($response,$classType))?$response->getStatusCode():$response->getCode(); // ESEMPIO 200
        $this->description = (is_a($response,$classType))?$response->getReasonPhrase():$response->getMessage(); // ESEMPIO OK
        $body = (is_a($response,$classType))?(string)$response->getBody():$response->getHandlerContext();
        $array = (is_a($response,$classType))?json_decode($body,true):$body;
        $this->response = $array; // BODY DELLA RESPONSE
    }
}

/**
 * JhellyAPI
 * Wrapper GuzzleHttp per le chiamate API verso gli SHELLY
 */

class JhellyAPI {

    private $client;
    
    /**
     * __construct
     *
     * @param  mixed $parameters
     * @return void
     */
    public function __construct(private array $parameters) {
        /** INIZIALIZZAZIONE CLASSE E PARAMETRI */
        $base_uri = "{$parameters['base_uri']}";
        $timeout = $parameters['timeout']??10;
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $base_uri,
            // You can set any number of default request options.
            'timeout'  => $timeout,
        ]);
    }

    /**
     * shelly
     *
     * @return responseApi
     */
    public function shelly():responseApi {
        return $this->request(path:'/shelly');
    }

    
    /**
     * request
     *
     * @param  mixed $path
     * @param  mixed $type
     * @return responseApi
     */
    private function request(string $path, string|null $type = 'GET'):responseApi {
        try {
            $response = $this->client->request($type, $path);
        }
        catch(Exception $e) {
            $response = $e;
        }
        
        return new responseApi($response);
    }

}
