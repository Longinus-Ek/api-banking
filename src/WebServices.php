<?php

namespace Longinus\Apibanking;

use Longinus\Apibanking\interfaces\Metodo;

class WebServices implements Metodo
{
    private $metodo;
    private $ambiente;
    private $banking;

    public function __construct(array $options)
    {
        $this->setAmbiente($options['tpAmbiente']);
        $this->setBanking($options['banking']);
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
        ];

        return $listaUri[$this->banking][$this->ambiente];
    }

    public function getUriApi(): string
    {
        $listUri = [
            "756" => [
                'REGISTRAR_BOLETO' => "/cobranca-bancaria/v2/boletos",
                'TOKEN' => "/auth/realms/cooperado/protocol/openid-connect/token",
            ],
            "001" => [
                'REGISTRAR_BOLETO' => "/cobrancas/v2/boletos",
                'TOKEN' => "/oauth/token",
            ],
        ];
        return $listUri[$this->banking][$this->metodo];
    }

    public function getBaseTokenUri(): string
    {
        $listaUri = [
            "756" => [
                "1" => "https://auth.sicoob.com.br",
                "2" => "https://auth.sicoob.com.br" //token homologação informado no site da api sicoob
            ],
            "001" => [
                "1" => 'https://oauth.hm.bb.com.br',
                "2" => 'https://oauth.sandbox.bb.com.br'
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
