<?php

namespace Longinus\Apibanking;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Matrix\Exception;

class Banking extends Util
{
    private $config;
    private $tokens;
    private $token;
    private $webService;

    function __construct($config)
    {
        $this->config = $config;
        $this->tokens = new Token($config);
        $this->retornoTtoken = $this->tokens->getToken();
        $this->token = $this->retornoTtoken['access_token'] ?? throw new Exception('Servidor banco código: ' . $config['banking'] . ' indisponível no momento' );
        $this->webService = new WebServices($config);
        $baseUri = $this->webService->getBaseUri();
        $this->client = new Client([
            'base_uri' => $baseUri,
        ]);
        $config['token'] = $this->token;

        $this->optionsRequest = $this->getOptionRequest($config);
    }

    public function gerarToken(){
        return $this->token;
    }

    public function setToken($token){
        $this->token = $token;
    }

    /**
     * Cobranças
     * @param $fields
     * @return array|mixed|\Psr\Http\Message\ResponseInterface|string[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function registrarBoleto($fields): mixed
    {
        $options = $this->optionsRequest;
        $options['body'] = json_encode($fields);
        $this->webService->setMethod('REGISTRAR_BOLETO');
        $uri = $this->webService->getUriApi();
        try {
            $response = $this->client->request(
                $uri[0],
                $uri[1],
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao incluir Boleto Cobranca: {$response}"];
        }
    }

    public function consultarBoleto($filters){
        $options = $this->optionsRequest;
        $options['query'] = $filters;
        try {
            $response = $this->client->request(
                'GET',
                "/cobranca-bancaria/v2/boletos",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    public function boletoPorPagador($filters, String $numeroCpfCnpj){
        $options = $this->optionsRequest;
        $options['query'] = $filters;
        try {
            $response = $this->client->request(
                'GET',
                "/cobranca-bancaria/v2/boletos/pagadores/{$numeroCpfCnpj}",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    public function segundaViaBoleto($filters){
        $options = $this->optionsRequest;
        $options['query'] = $filters;
        try {
            $response = $this->client->request(
                'GET',
                "/cobranca-bancaria/v2/boletos/segunda-via",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    public function faixasNossoNumeroDisponivel($filters){
        $options = $this->optionsRequest;
        $options['query'] = $filters;
        try {
            $response = $this->client->request(
                'GET',
                "/cobranca-bancaria/v2/boletos/faixas-nosso-numero-disponiveis",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    public function prorrogarDataVencimento($boletos){
        $options = $this->optionsRequest;
        $options['body'] = json_encode($boletos);
        try {
            $response = $this->client->request(
                'PATCH',
                "/cobranca-bancaria/v2/boletos/prorrogacoes/data-vencimento",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    public function prorrogarDataLimite($boletos){
        $options = $this->optionsRequest;
        $options['body'] = json_encode($boletos);
        try {
            $response = $this->client->request(
                'PATCH',
                "/cobranca-bancaria/v2/boletos/prorrogacoes/data-limite-pagamento",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    public function descontosBoleto($boletos){
        $options = $this->optionsRequest;
        $options['body'] = json_encode($boletos);
        try {
            $response = $this->client->request(
                'PATCH',
                "/cobranca-bancaria/v2/boletos/descontos",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    public function abatimentosBoleto($boletos){
        $options = $this->optionsRequest;
        $options['body'] = json_encode($boletos);
        try {
            $response = $this->client->request(
                'PATCH',
                "/cobranca-bancaria/v2/boletos/abatimentos",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    public function multaBoleto($boletos){
        $options = $this->optionsRequest;
        $options['body'] = json_encode($boletos);
        try {
            $response = $this->client->request(
                'PATCH',
                "/cobranca-bancaria/v2/boletos/encargos/multa",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    public function jurosMoraBoleto($boletos){
        $options = $this->optionsRequest;
        $options['body'] = json_encode($boletos);
        try {
            $response = $this->client->request(
                'PATCH',
                "/cobranca-bancaria/v2/boletos/encargos/juros-mora",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    public function valorNominalBoleto($boletos){
        $options = $this->optionsRequest;
        $options['body'] = json_encode($boletos);
        try {
            $response = $this->client->request(
                'PATCH',
                "/cobranca-bancaria/v2/boletos/valor-nominal",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    public function alterarSeuNumeroBoleto($boletos){
        $options = $this->optionsRequest;
        $options['body'] = json_encode($boletos);
        try {
            $response = $this->client->request(
                'PATCH',
                "/cobranca-bancaria/v2/boletos/seu-numero",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    public function especieDocumentoBoleto($boletos){
        $options = $this->optionsRequest;
        $options['body'] = json_encode($boletos);
        try {
            $response = $this->client->request(
                'PATCH',
                "/cobranca-bancaria/v2/boletos/especie-documento",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    public function baixaBoleto($boletos){
        $options = $this->optionsRequest;
        $options['body'] = json_encode($boletos);
        $this->webService->setMethod('BAIXAR');
        $uri = $this->webService->getUriApi();
        try {
            $response = $this->client->request(
                $uri[0],
                $uri[1],
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    public function rateioCreditos($boletos){
        $options = $this->optionsRequest;
        $options['body'] = json_encode($boletos);
        try {
            $response = $this->client->request(
                'PATCH',
                "/cobranca-bancaria/v2/boletos/rateiro-creditos",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    public function pixBoleto($boletos){
        $options = $this->optionsRequest;
        $options['body'] = json_encode($boletos);
        try {
            $response = $this->client->request(
                'PATCH',
                "/cobranca-bancaria/v2/boletos/pix",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    /**
     * Pagadores
     * @param $boletos
     * @return array|mixed|\Psr\Http\Message\ResponseInterface|string[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function alterarPagadores($boletos){
        $options = $this->optionsRequest;
        $options['body'] = json_encode($boletos);
        try {
            $response = $this->client->request(
                'PUT',
                "/cobranca-bancaria/v2/pagadores",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    /**
     * Negativação
     * @param $boletos
     * @return array|mixed|\Psr\Http\Message\ResponseInterface|string[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function negativarBoleto($boletos){
        $options = $this->optionsRequest;
        $options['body'] = json_encode($boletos);
        try {
            $response = $this->client->request(
                'POST',
                "/cobranca-bancaria/v2/boletos/negativacoes",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    public function cancelarNegativarBoleto($boletos){
        $options = $this->optionsRequest;
        $options['body'] = json_encode($boletos);
        try {
            $response = $this->client->request(
                'PATCH',
                "/cobranca-bancaria/v2/boletos/negativacoes",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    public function baixarNegativarBoleto($boletos){
        $options = $this->optionsRequest;
        $options['body'] = json_encode($boletos);
        try {
            $response = $this->client->request(
                'DELETE',
                "/cobranca-bancaria/v2/boletos/negativacoes",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }


    /**
     * Protestos
     * @param $boletos
     * @return array|mixed|\Psr\Http\Message\ResponseInterface|string[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function protestarBoleto($boletos){
        $options = $this->optionsRequest;
        $options['body'] = json_encode($boletos);
        try {
            $response = $this->client->request(
                'POST',
                "/cobranca-bancaria/v2/boletos/protestos",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    public function cancelarProtestoBoleto($boletos){
        $options = $this->optionsRequest;
        $options['body'] = json_encode($boletos);
        try {
            $response = $this->client->request(
                'PATCH',
                "/cobranca-bancaria/v2/boletos/protestos",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    public function desistirProtestoBoleto($boletos){
        $options = $this->optionsRequest;
        $options['body'] = json_encode($boletos);
        try {
            $response = $this->client->request(
                'DELETE',
                "/cobranca-bancaria/v2/boletos/protestos",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    /**
     * Movimentações Boleto
     * @param array $filters
     * @return array|mixed|\Psr\Http\Message\ResponseInterface|string[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function solicitarMovimentacao(Array $filters){
        $options = $this->optionsRequest;
        $options['body'] = json_encode($filters);
        // print_r($options);die;
        try {
            $response = $this->client->request(
                'POST',
                "/cobranca-bancaria/v2/boletos/solicitacoes/movimentacao",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    public function consultarMovimentacao(Array $filters){
        $options = $this->optionsRequest;
        $options['query'] = $filters;
        // print_r($options);die;
        try {
            $response = $this->client->request(
                'GET',
                "/cobranca-bancaria/v2/boletos/solicitacoes/movimentacao",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    public function downloadMovimentacao(Array $filters){
        $options = $this->optionsRequest;
        $options['query'] = $filters;
        // print_r($options);die;
        try {
            $response = $this->client->request(
                'GET',
                "/cobranca-bancaria/v2/boletos/solicitacoes/movimentacao-download",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

    public function saldo($filters){
        $options = $this->optionsRequest;
        $options['query'] = $filters;
        try {
            $response = $this->client->request(
                'GET',
                "/conta-corrente/v2/saldo",
                $options,
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {//return $e;
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao consultar Boleto Cobranca: {$response}"];
        }
    }

}
