<?php

namespace Longinus\Apibanking;

use Longinus\Apibanking\interfaces\Metodo;

class WebServices implements Metodo
{
    private $metodo;
    private $ambiente;
    private $banking;
    private $numRef;

    public function __construct(array $options)
    {
        $this->setAmbiente($options['tpAmbiente']);
        $this->setBanking($options['banking']);
        $this->numRef = $options['numRef'] ?? '';
    }

    public function getBaseUri(): string
    {
        $listaUri = [
            "756" => [
                "1" => "https://api.sicoob.com.br",
                "2" => "https://sandbox.sicoob.com.br/sicoob/sandbox"
            ],
            "001" => [
                "1" => 'https://api.bb.com.br',
                "2" => 'https://api.sandbox.bb.com.br'
            ],
            "085" => [
                "1" => "https://apiendpoint.ailos.coop.br",
                "2" => "https://apiendpointhml.ailos.coop.br",
            ],
            "033" => [
                "1" => "https://trust-open.api.santander.com.br",
                "2" => "https://trust-sandbox.api.santander.com.br",
            ],
        ];

        return $listaUri[$this->banking][$this->ambiente];
    }

    public function getUriApi(): array
    {
        $listUri = [
            "756" => [
                'REGISTRAR_BOLETO' => [
                    "POST",
                    "/cobranca-bancaria/v2/boletos"
                ],
                'BAIXAR' => [
                    "PATCH",
                    "/cobranca-bancaria/v2/boletos/baixa"
                ],
                'TOKEN' => [
                    "POST",
                    "/auth/realms/cooperado/protocol/openid-connect/token"
                ],
            ],
            "001" => [
                'REGISTRAR_BOLETO' => [
                    "POST",
                    "/cobrancas/v2/boletos"
                ],
                'BAIXAR' => [
                    "POST",
                    "/cobranca-bancaria/v2/boletos/numRef/baixar"
                ],
                'TOKEN' => [
                    "POST",
                    "/oauth/token"
                ],
            ],
            "085" => [
                'REGISTRAR_BOLETO' => [
                    "POST",
                    "/ailos/cobranca/api/v1/boletos/gerar/boleto/convenios/numRef"
                ],
                'BAIXAR' => [
                    "POST",
                    "BOLETO GERADO NO RENDER DA API"
                ],
                'TOKEN' => [
                    "GET",
                    "/ailos/identity/api/v1/autenticacao/token/refresh"
                ],
            ],
            "033" => [
                'REGISTRAR_WORKSPACE' => [
                    "POST",
                    "/collection_bill_management/v2/workspaces"
                ],
                'REGISTRAR_BOLETO' => [
                    "POST",
                    "/collection_bill_management/v2/workspaces/numRef/bank_slips"
                ],
                'BAIXAR' => [
                    "POST",
                    "/collection_bill_management/v2/workspaces/numRef/bank_slips"
                ],
                'TOKEN' => [
                    "POST",
                    "/auth/oauth/v2/token"
                ],
            ],

        ];
        $retorno = $listUri[$this->banking][$this->metodo];
        $retorno[1] = str_replace('numRef', $this->numRef, $retorno[1]);
        return $retorno;
    }

    public function getBaseTokenUri(): string
    {
        $listaUri = [
            "756" => [
                "1" => "https://auth.sicoob.com.br",
                "2" => "https://sandbox.sicoob.com.br/sicoob/sandbox" //token homologação informado no site da api sicoob
            ],
            "001" => [
                "1" => 'https://oauth.hm.bb.com.br',
                "2" => 'https://oauth.sandbox.bb.com.br'
            ],
            "085" => [
                "1" => "https://apiendpoint.ailos.coop.br",
                "2" => "https://apiendpointhml.ailos.coop.br",
            ],
            "033" => [
                "1" => "https://trust-open.api.santander.com.br",
                "2" => "https://trust-sandbox.api.santander.com.br",
            ],
        ];

        return $listaUri[$this->banking][$this->ambiente];
    }

    function setMethod($method)
    {
        // TODO: Implement setMethod() method.
        $this->metodo = $method;
    }


    function setAmbiente($ambiente)
    {
        // TODO: Implement setAmbiente() method.
        $this->ambiente = $ambiente;
    }

    function setBanking($banking)
    {
        // TODO: Implement setBanking() method.
        $this->banking = $banking;
    }
}
