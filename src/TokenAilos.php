<?php

namespace Longinus\Apibanking;

use GuzzleHttp\Client;

abstract class TokenAilos extends Util
{
    public static function getTokenAilos($config){
        $listBaseUrl = [
            "1" => "https://apiendpoint.ailos.coop.br",
            "2" => "https://apiendpointhml.ailos.coop.br",
        ];
        $client = new Client([
            'base_uri' => $listBaseUrl[$config['tpAmbiente']],
        ]);
        $token = base64_encode($config['consumerKey'].':'.$config['consumerSecret']);
        $options = [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Basic ' . $token
            ],
            'verify' => false,
            'form_params' => [
                'grant_type' => 'client_credentials',
                'scope' => 'x-ailos-saquepix-administrador, x-pagination, x-ailos-saquepix, x-ailos-saquepix-operador, Content-Type, Authorization, x-ailos-authentication, x-ailos-consignada, x-fapi-auth-date, x-fapi-customer-ip-address, x-fapi-interaction-id, x-customer-user-agent, x-idempotency-key, consentid, x-ailos-operator,x-ailos-saquepix-administrador, x-pagination, x-ailos-saquepix, x-ailos-saquepix-operador, Content-Type, Authorization, x-ailos-authentication, x-ailos-consignada, x-fapi-auth-date, x-fapi-customer-ip-address, x-fapi-interaction-id, x-customer-user-agent, x-idempotency-key, consentid, x-ailos-operator'
            ]
        ];
        $token1 = $client->request(
            "POST",
            "/token",
            $options
        );
        $responseToken1 = json_decode($token1->getBody()->getContents());
        $token1 = $responseToken1->access_token;

        return 'Bearer ' . $token1;
    }
}
