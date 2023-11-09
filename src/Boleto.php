<?php

namespace Longinus\Apibanking;

use Matrix\Exception;

class Boleto
{
    private array $boleto;
    private string $banking;

    public function __construct(string $banking, array $arrayBoleto = null)
    {
        if (!is_null($arrayBoleto)) {
            $this->boleto = $arrayBoleto;
        }
        $this->banking = $banking;
    }

    /**
     * @throws Exception
     */
    public function obterBoleto(): array
    {
        return $this->verificaBoleto();
    }

    public function appendValueBoleto(string $name, $value): void
    {
        $this->boleto[$name] = $value;
    }

    /**
     * @throws Exception
     */
    private function verificaBoleto(): array|Exception
    {
        $listEstrutura = [
            '756' => [
                "numeroContrato" => '',
                "modalidade" => '',
                "numeroContaCorrente" => '',
                "especieDocumento" => "DM",
                "dataEmissao" => "",
                "nossoNumero" => '',
                "seuNumero" => '',
                "identificacaoBoletoEmpresa" => '',
                "identificacaoEmissaoBoleto" => '',
                "identificacaoDistribuicaoBoleto" => '',
                "valor" => '',
                "dataVencimento" => '',
                "dataLimitePagamento" => '',
                "valorAbatimento" => '',
                "tipoDesconto" => '',
                "tipoMulta" => '',
                "tipoJurosMora" => '',
                "numeroParcela" => '',
                "aceite" => '',
                "codigoNegativacao" => '',
                "codigoProtesto" => '',
                "pagador" => [
                    "numeroCpfCnpj" => '',
                    "nome" => '',
                    "endereco" => '',
                    "bairro" => '',
                    "cidade" => '',
                    "cep" => '',
                    "uf" => '',
                ],
                "beneficiarioFinal" => [
                    "numeroCpfCnpj" => "",
                    "nome" => "",
                ],
                "mensagensInstrucao" => [
                    "tipoInstrucao" => '',
                    "mensagens" => [
                        '',
                        ''
                    ]
                ],
                "gerarPdf" => '',
            ],
            '001' => [

            ]
        ];
        $retorno = array_diff(array_keys($listEstrutura[$this->banking]), array_keys($this->boleto));

        if(!empty($retorno)){
            throw new Exception('Os seguintes campos não foram preenchidos no boleto: ' . implode(', ', $retorno));
        }else{
            return $this->boleto;
        }
    }
}
