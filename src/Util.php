<?php

namespace Longinus\Apibanking;

class Util
{
    public function getOptionRequest($option): array
    {
        $banking = $option['banking'];
        $listOption = [
            "756" => [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'client_id' => $option['client_id'],
                    'Authorization' => "Bearer {$option['token']}"
                ],
                'cert' => $option['certificate'],
                'verify' => false,
                'ssl_key' => $option['certificateKey'],
            ],
            "001" => [
                'headers' => [
                    'Authorization' => "Bearer {$option['token']}",
                    'Content-Type' => 'application/json',
                ],
                'verify' => false,
                'query' => [
                    'gw-dev-app-key' => $option['client_id']
                ],
            ],
            "085" => [
                'headers' => [
                    'x-ailos-authentication' => "Bearer {$option['token']}",
                    'Authorization' => $option['authorization'],
                    'Content-Type' => 'application/json',
                ],
                'verify' => false,
            ],
            "033" => [
                'headers' => [
                    'Authorization' => "Bearer {$option['token']}",
                    'Content-Type' => 'application/json',
                    'X-Application-Key' => $option['client_id'],
                ],
                'cert' => $option['certificate'],
                'verify' => false,
                'ssl_key' => $option['certificateKey'],
            ],
        ];
        return $listOption[$banking];
    }

    public function getOptionTokenRequest($option): array
    {
        $banking = $option['banking'];
        $listOption = [
            "756" => [
                'headers' => [
                    'Accept' => 'application/x-www-form-urlencoded'
                ],
                'cert' => $option['certificate'] ?? '',
                'verify' => false,
                'ssl_key' => $option['certificateKey'] ?? '',
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => $option['client_id'] ?? '',
                    'scope' => $this->getScope($option) ?? '',
                ]
            ],
            "001" => [
                'headers' => [
                    'Authorization' => $option['authorization'] ?? '',
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                'verify' => false,
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'scope' => $this->getScope($option) ?? ''
                ]
            ],
            "085" => [
                'headers' => [
                    'Authorization' => $option['authorization'] ?? '',
                    'Content-Type' => 'application/json',
                ],
                'verify' => false,
                'query' => [
                    'code' => $option['client_id'] ?? ''
                ]
            ],
            "033" => [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'cert' => $option['certificate'] ?? '',
                'verify' => false,
                'ssl_key' => $option['certificateKey'] ?? '',
                'form_params' => [
                    'client_id' => $option['client_id'],
                    'grant_type' => 'client_credentials',
                    'client_secret' => $option['client_secret'],
                ]
            ],

        ];
        return $listOption[$banking];
    }

    public function getScope($option): string
    {
        $banking = $option['banking'];
        $api = $option['api'];
        $listScope = [
            '756' => [
                'boleto' => 'cobranca_boletos_consultar cobranca_boletos_incluir cobranca_boletos_pagador cobranca_boletos_segunda_via cobranca_boletos_descontos cobranca_boletos_abatimentos cobranca_boletos_valor_nominal cobranca_boletos_seu_numero cobranca_boletos_especie_documento cobranca_boletos_baixa cobranca_boletos_rateio_credito cobranca_pagadores cobranca_boletos_negativacoes_incluir cobranca_boletos_negativacoes_alterar cobranca_boletos_negativacoes_baixar cobranca_boletos_protestos_incluir cobranca_boletos_protestos_alterar cobranca_boletos_protestos_desistir cobranca_boletos_solicitacao_movimentacao_incluir cobranca_boletos_solicitacao_movimentacao_consultar cobranca_boletos_solicitacao_movimentacao_download cobranca_boletos_prorrogacoes_data_vencimento cobranca_boletos_prorrogacoes_data_limite_pagamento cobranca_boletos_encargos_multas cobranca_boletos_encargos_juros_mora',
                'pix' => 'cob.write cob.read cobv.write cobv.read lotecobv.write lotecobv.read pix.write pix.read webhook.read webhook.write payloadlocation.write payloadlocation.read'
            ],
            '001' => [
                'boleto' => 'cobrancas.boletos-info cobrancas.boletos-requisicao',
                'pix' => '',
            ],
            '085' => [
                'boleto' => 'x-ailos-saquepix-administrador, x-pagination, x-ailos-saquepix, x-ailos-saquepix-operador, Content-Type, Authorization, x-ailos-authentication, x-ailos-consignada, x-fapi-auth-date, x-fapi-customer-ip-address, x-fapi-interaction-id, x-customer-user-agent, x-idempotency-key, consentid, x-ailos-operator,x-ailos-saquepix-administrador, x-pagination, x-ailos-saquepix, x-ailos-saquepix-operador, Content-Type, Authorization, x-ailos-authentication, x-ailos-consignada, x-fapi-auth-date, x-fapi-customer-ip-address, x-fapi-interaction-id, x-customer-user-agent, x-idempotency-key, consentid, x-ailos-operator',
                'pix' => '',
            ],
            '033' => [
                'boleto' => '',
                'pix' => ''
            ]
        ];
        return $listScope[$banking][$api];
    }
}
