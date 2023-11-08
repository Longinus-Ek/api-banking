<?php

namespace Longinus\Apibanking;

class Util
{

    public function getApiUri($option): string
    {
        $banking = $option['banking'];
        $listUri = [
            "756" => [
                'registrarBoleto' => '/cobranca-bancaria/v2/boletos'
            ]
        ];
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
