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
            "000" => []
        ];
        $retorno = array_diff(array_keys($listEstrutura[$this->banking]), array_keys($this->boleto));

        if(!empty($retorno)){
            throw new Exception('Os seguintes campos não foram preenchidos no boleto: ' . implode(', ', $retorno));
        }else{
            return $this->boleto;
        }
    }
}
