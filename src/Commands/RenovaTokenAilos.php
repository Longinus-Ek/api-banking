<?php

namespace Longinus\Apibanking\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RenovaTokenAilos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'renova:token {ambiente} {consumerKey} {consumerSecret} {UUID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando utilizado para renovar o bearer token da ailos';

    /**
     * Execute the console command.
     * @return array
     * @throws GuzzleException
     */
    public function handle()
    {
        $ambiente = $this->argument('ambiente');
        $consumerKey = $this->argument('consumerKey');
        $consumerSecret = $this->argument('consumerSecret');
        $token = base64_encode($consumerKey.':'.$consumerSecret);
        $UUID = $this->argument('UUID');
        $listBaseUrl = [
            "1" => "https://apiendpoint.ailos.coop.br",
            "2" => "https://apiendpointhml.ailos.coop.br",
        ];

        $client1 = new Client([
            'base_uri' => $listBaseUrl[$ambiente],
        ]);

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

        try {
            $response = $client1->request(
                "POST",
                "/token",
                $options
            );

            $responseData = json_decode($response->getBody()->getContents(), true);

            Log::info('Resposta do comando: ' . print_r($responseData, true));


            $client2 = new Client([
                'base_uri' => 'https://apiendpointhml.ailos.coop.br',
            ]);

            $options2 = [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'text/plain',
                    'Authorization' => 'Bearer ' . $responseData['access_token']
                ],
                'json' => [
                    'urlCallback' => route('renova_ailos'),
                    'ailosApiKeyDeveloper' => $UUID,
                    'state' => '123456789'
                ]
            ];

            $response2 = $client2->request(
                "POST",
                "/ailos/identity/api/v1/autenticacao/login/obter/id",
                $options2
            );

            $responseData2 = $response2->getBody()->getContents();

            Log::info('Resposta do comando: ' . print_r('https://apiendpointhml.ailos.coop.br/ailos/identity/api/v1/login/index?id=' . urlencode($responseData2), true));

            return $responseData;
        } catch (\Exception $e) {
            Log::error('Erro no comando: ' . $e->getMessage());
            throw $e;
        }
    }
}
