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
                "1" => '',
                "2" => ''
            ],
        ];

        return $listaUri[$this->banking][$this->ambiente];
    }

    public function getUriApi(): string
    {
        $listUri = [
            "756" => [
                'REGISTRAR_BOLETO' => "/cobranca-bancaria/v2/boletos",
            ],
            "001" => [
                'REGISTRAR_BOLETO' => "/cobranca-bancaria/v2/boletos",
            ],
        ];
        return $listUri[$this->banking][$this->metodo];
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
