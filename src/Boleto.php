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
                "codigoCadastrarPIX" => '',
            ],
            '001' => [
                "numeroConvenio" => 0,
                "numeroCarteira" => 0,
                "numeroVariacaoCarteira" => 0,
                "codigoModalidade" => 1,
                "dataEmissao" => "string",
                "dataVencimento" => "string",
                "valorOriginal" => 0,
                "valorAbatimento" => 0,
                "quantidadeDiasProtesto" => 0,
                "quantidadeDiasNegativacao" => 0,
                "orgaoNegativador" => 0,
                "codigoAceite" => "string",
                "codigoTipoTitulo" => 0,
                "descricaoTipoTitulo" => "string",
                "indicadorPermissaoRecebimentoParcial" => "string",
                "numeroTituloBeneficiario" => "string",
                "campoUtilizacaoBeneficiario" => "string",
                "numeroTituloCliente" => "string",
                "mensagemBloquetoOcorrencia" => "string",
                "desconto" => [
                    "tipo" => 0,
                    "dataExpiracao" => "string",
                    "porcentagem" => 0,
                    "valor" => 0
                ],
                "segundoDesconto" => [
                    "dataExpiracao" => "string",
                    "porcentagem" => 0,
                    "valor" => 0
                ],
                "terceiroDesconto" => [
                    "dataExpiracao" => "string",
                    "porcentagem" => 0,
                    "valor" => 0
                ],
                "jurosMora" => [
                    "tipo" => 0,
                    "porcentagem" => 0,
                    "valor" => 0
                ],
                "multa" => [
                    "tipo" => 0,
                    "data" => "string",
                    "porcentagem" => 0,
                    "valor" => 0
                ],
                "pagador" => [
                    "tipoInscricao" => 0,
                    "numeroInscricao" => 0,
                    "nome" => "string",
                    "endereco" => "string",
                    "cep" => 0,
                    "cidade" => "string",
                    "bairro" => "string",
                    "uf" => "string",
                    "telefone" => "string"
                ],
                "beneficiarioFinal" => [
                    "tipoInscricao" => 0,
                    "numeroInscricao" => 0,
                    "nome" => "string"
                ],
                "indicadorPix" => "string"
            ],
            "085" => [
                "convenioCobranca" => [
                    "numeroConvenioCobranca" => 0,
                    "codigoCarteiraCobranca" => 0
                ],
                "documento" => [
                    "numeroDocumento" => 0,
                    "descricaoDocumento" => "string",
                    "especieDocumento" => 1
                ],
                "emissao" => [
                    "formaEmissao" => 1,
                    "dataEmissaoDocumento" => "2019-05-11T18:04:50.791Z"
                ],
                "pagador" => [
                    "entidadeLegal" => [
                        "identificadorReceitaFederal" => "string",
                        "tipoPessoa" => 1,
                        "nome" => "string"
                    ],
                    "telefone" => [
                        "ddi" => "string",
                        "ddd" => "string",
                        "numero" => "string"
                    ],
                    "emails" => [
                        [
                            "endereco" => "string"
                        ]
                    ],
                    "endereco" => [
                        "cep" => "string",
                        "logradouro" => "string",
                        "numero" => "string",
                        "complemento" => "string",
                        "bairro" => "string",
                        "cidade" => "string",
                        "uf" => "string"
                    ],
                    "mensagemPagador" => [
                        "string"
                    ],
                    "dda" => true
                ],
                "numeroParcelas" => 0,
                "vencimento" => [
                    "dataVencimento" => "2019-05-11T18 =>04 =>50.791Z"
                ],
                "instrucoes" => [
                    "tipoDesconto" => 1,
                    "valorDesconto" => 0,
                    "percentualDesconto" => 0,
                    "tipoMulta" => 1,
                    "valorMulta" => 0,
                    "percentualMulta" => 0,
                    "tipoJurosMora" => 1,
                    "valorJurosMora" => 0,
                    "percentualJurosMora" => 0,
                ],
                "valorBoleto" => [
                    "valorTitulo" => 0
                ],
            ],
            "033" => [
                "environment" => "PROCUCAO",
                "nsuCode" => 12345678901234567000,
                "nsuDate" => "2022-12-12",
                "covenantCode" => "1234567",
                "bankNumber" => "123",
                "clientNumber" => "fd119Dc4d48F460",
                "dueDate" => "2022-12-12",
                "issueDate" => "2022-12-12",
                "nominalValue" => "10.15",
                "payer" => [
                    "name" => "João da Silva",
                    "documentType" => "CPF",
                    "documentNumber" => 9615865832,
                    "address" => "Rua XV de Maio",
                    "neighborhood" => "Vila Industrial",
                    "city" => "São Paulo",
                    "state" => "SP",
                    "zipCode" => "09761-233"
                ],
                "beneficiary" => [
                    "name" => "João da Silva",
                    "documentType" => "CPF",
                    "documentNumber" => 9615865832
                ],
                "documentKind" => "DUPLICATA_MERCANTIL",
                "discount" => [
                    "type" => "VALOR_DATA_FIXA",
                    "discountOne" => [
                        "value" => 5.5,
                        "limitDate" => "2022-12-12"
                    ],
                    "discountTwo" => [
                        "value" => 5.5,
                        "limitDate" => "2022-12-12"
                    ],
                    "discountThree" => [
                        "value" => 5.5,
                        "limitDate" => "2022-12-12"
                    ]
                ],
                "finePercentage" => "97.80",
                "fineQuantityDays" => "5",
                "interestPercentage" => "5.00",
                "protestType" => "SEM_PROTESTO",
                "paymentType" => "REGISTRO",
                "key" => [
                    "type" => "CPF",
                    "dictKey" => "09463589723"
                ],
            ]
        ];
        $retorno = array_diff(array_keys($listEstrutura[$this->banking]), array_keys($this->boleto));

        if (!empty($retorno)) {
            throw new Exception('Os seguintes campos não foram preenchidos no boleto: ' . implode(', ', $retorno));
        } else {
            return $this->boleto;
        }
    }
}
