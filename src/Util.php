<?php

namespace Longinus\Apibanking;

class Util
{
    public function getBaseUri($option): string
    {
        $tpAmbiente = $option['tpAmbiente'];
        $banking = $option['banking'];
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

        return $listaUri[$banking][$tpAmbiente];
    }
    public function getOptionRequest($option): array
    {
        $banking = $option['banking'];
        $listOption = [
            "756" => [
                        'headers' => [
                            'Accept' => 'application/json',
                            'Content-Type' => 'application/json',
                            'x-sicoob-clientid' => $option['client_id']
                        ],
                        'cert' => $option['certificate'],
                        'verify' => false,
                        'ssl_key' => $option['certificateKey'],
                    ]
        ];
        return $listOption[$banking];
    }
}
