<?php

namespace Longinus\Apibanking;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Token extends Util
{
    private mixed $config;
    private WebServices $webServiceToken;
    private Client $client;
    private array $optionsRequest;

    function __construct($config)
    {
        $this->config = $config;
        $this->webServiceToken = new WebServices($config);
        $baseUri = $this->webServiceToken->getBaseTokenUri();
        $this->client = new Client([
            'base_uri' => $baseUri,
        ]);
        $this->optionsRequest = $this->getOptionTokenRequest($config);
    }

    /**
     * @return array|mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getToken(): mixed
    {
        $options = $this->optionsRequest;
        $this->webServiceToken->setMethod('TOKEN');
        $uriToken = $this->webServiceToken->getUriApi();
        try {
            $response = $this->client->request(
                'POST',
                $uriToken,
                $options
            );

            return (array) json_decode($response->getBody()->getContents());
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => $response];
        }
    }
}
