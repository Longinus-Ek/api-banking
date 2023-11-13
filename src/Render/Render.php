<?php

namespace Longinus\Apibanking\Render;

use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use JetBrains\PhpStorm\NoReturn;
use Longinus\Apibanking\Traits\Arquivos;
use Mpdf\Mpdf;
use Mpdf\MpdfException;

class Render extends Mpdf
{
    use Arquivos;

    /**
     * @throws MpdfException
     */
    public function __construct(array $config = [], $container = null)
    {
        parent::__construct($config, $container);
    }

    /**
     * @throws MpdfException
     */
    #[NoReturn] public function generatePDF(array $boleto, string $path, string $banking, $urlQrCode = null): ?string
    {
        $dados = $boleto;
        $logo = __DIR__ . '../../logos/' . $banking . '.png';
        $logo = file_get_contents($logo);
        $logo64 = base64_encode($logo);
        if($urlQrCode !== null){
            $renderer = new ImageRenderer(
                new RendererStyle(400),
                new ImagickImageBackEnd()
            );
            $writer = new Writer($renderer);
            $qrCode = $writer->writeString($urlQrCode);
            $urlQrCode = base64_encode($qrCode);
        }

        $conteudo = '<!DOCTYPE  html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt" lang="pt">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>rel_renderBol_v2</title>
    <style type="text/css"> * {
        margin: 0;
        padding: 0;
        text-indent: 0;
    }
    .s1 {
        color: black;
        font-family: "Times New Roman", serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 8pt;
    }
    .s2 {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        font-size: 8pt;
    }
    .s3 {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        font-size: 7pt;
    }
    .s4 {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 15pt;
    }
    .s5 {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        font-size: 10pt;
    }
    .s6 {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 6pt;
    }
    .position1 {
        border-top-style: solid;
        border-top-width: 1pt;
        border-left-style: solid;
        border-left-width: 1pt;
        border-bottom-style: solid;
        border-bottom-width: 1pt;
        border-right-style: solid;
        border-right-width: 1pt
    }
    .position2 {
        border-top-style:solid;
        border-top-width:1pt;
        border-left-style:solid;
        border-left-width:1pt;
        border-bottom-style:solid;
        border-bottom-width:1pt
    }
    .position3 {
        border-top-style:solid;
        border-top-width:1pt;
        border-bottom-style:solid;
        border-bottom-width:1pt;
        border-right-style:solid;
        border-right-width:1pt
    }
    .position4 {
        border-left-style:solid;
        border-left-width:1pt;
        border-bottom-style:solid;
        border-bottom-width:1pt;
        border-right-style:solid;
        border-right-width:1pt
    }
    .position5 {
        border-top-style:solid;
        border-top-width:1pt;
        border-left-style:solid;
        border-left-width:1pt;
        border-bottom-style:solid;
        border-bottom-width:2pt;
        border-right-style:solid;
        border-right-width:1pt
    }
    .position6 {
        border-top-style:solid;
        border-top-width:1pt;
        border-bottom-style:solid;
        border-bottom-width:1pt
    }
    .position7 {
        border-bottom-style:solid;
        border-bottom-width:1pt;
        border-right-style:solid;
        border-right-width:1pt
    }
    .position8 {
        border-left-style:solid;
        border-left-width:1pt;
        border-bottom-style:solid;
        border-bottom-width:1pt
    }
    .position9 {
        border-bottom-style:solid;
        border-bottom-width:1pt
    }
    .position10 {
        border-top-style:solid;
        border-top-width:2pt
    }
    .position11 {
        border-top-style:solid;
        border-top-width:2pt;
        border-left-style:solid;
        border-left-width:1pt;
        border-right-style:solid;
        border-right-width:1pt
    }
    .position12 {
        border-top-style:solid;
        border-top-width:2pt;
        border-left-style:solid;
        border-left-width:1pt
    }
    .position13 {
        border-top-style:solid;
        border-top-width:1pt;
        border-left-style:solid;
        border-left-width:1pt;
        border-right-style:solid;
        border-right-width:1pt
    }
    .position14 {
        border-left-style:solid;
        border-left-width:1pt;
        border-right-style:solid;
        border-right-width:1pt
    }
    .position15 {
        border-left-style:solid;
        border-left-width:1pt
    }
    .position16 {
        border-right-style:solid;
        border-right-width:1pt
    }
    .position17 {
        border-top-style:solid;
        border-top-width:2pt;
        border-right-style:solid;
        border-right-width:1pt
    }
    table, tbody {
        vertical-align: top;
        overflow: visible;
    }
    </style>
</head>
<body>
<p style="text-align: left;">
    <img width="150" height="40" src="data:image/png;base64, '.$logo64.'"/>
    <br/>
</p>
<table style="border-collapse:collapse;margin-left:6pt" cellspacing="0">
    <tr style="height:18pt">
        <td style="width: 450px" class="position1" rowspan="3">
            <table>
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt;">Beneficiário</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left" width="80%">
                        <p class="s2" style="line-height: 9pt;text-align: left;">'.$dados['beneficiarioFinal']['nome'].'</p>
                    </td>
                    <td style="text-align: right" colspan="2">
                        <p class="s2">'.$dados['beneficiarioFinal']['numeroInscricao'].'</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: left">
                        <p class="s2" style="text-align: left;">'.$dados['resposta']['beneficiario']['logradouro'].'</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: left">
                        <p class="s2" style="text-align: left;"></p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left">
                        <p class="s2" style="text-align: left;">'.$dados['resposta']['beneficiario']['bairro'].'</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left" width="80%">
                        <p class="s2" style="text-align: left;">'.$dados['resposta']['beneficiario']['cidade'].' - ' . $dados['resposta']['beneficiario']['uf'] .'</p>
                    </td>
                    <td style="text-align: right" colspan="2">
                        <p class="s2">'.$dados['resposta']['beneficiario']['cep'].'</p>
                    </td>
                </tr>
            </table>
        </td>
        <td style="width: 130px" class="position1" bgcolor="#CCCCCC">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left;">
                        <p class="s1" style="line-height: 9pt">Vencimento</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2" style="line-height: 8pt">'.date('d/m/Y',strtotime($dados['dataVencimento'])).'</p>
                    </td>
                </tr>
            </table>
        </td>
        <td style="width: 120px" class="position1" bgcolor="#CCCCCC">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Valor do Documento</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2" style="line-height: 8pt;">'.number_format($dados['valorOriginal'], 2, ',','.').'</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:19pt">
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">(+) Outros acréscimos</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2" style="line-height: 8pt;"></p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">(+) Mora/Multa</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2" style="line-height: 8pt;"></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:20pt">
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">(-) Desconto/Abatimento</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2" style="line-height: 8pt;"></p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">(-) Outras deduções</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2" style="line-height: 8pt;"></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:18pt">
        <td class="position1" rowspan="3">
            <p class="s1" style="line-height: 8pt;text-align: left;">Instruções (texto de responsabilidade do beneficiário)</p>
            <p class="s3" style="text-align: left;">Boleto gerado 10/11/2023 08:19:30</p>
            <p class="s3" style="text-align: left;">Boleto gerado por Label System</p>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Data de Emissão</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2" style="line-height: 8pt;">'.date('d/m/Y',strtotime($dados['dataEmissao'])).'</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">(=) Valor cobrado</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2" style="line-height: 8pt;"></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:19pt">
        <td class="position1" colspan="2">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Agência / Conta</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2" style="line-height: 8pt;">'.$dados['resposta']['beneficiario']['agencia'] . ' - ' . $dados['resposta']['beneficiario']['contaCorrente'].'</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:19pt">
        <td class="position1" colspan="2">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Nosso Número</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2" style="line-height: 8pt;">'.$dados['resposta']['numero'].'</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<p style="line-height: 9pt;text-align: left;margin-left:6pt">
    <span style=" color: black; font-family:Arial, sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 8pt;">Dados do Pagador</span>
</p>
<table style="border-collapse:collapse;margin-left:6pt" cellspacing="0">
    <tr style="height:19pt">
        <td style="width: 500px" class="position1" colspan="2">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Nome do pagador</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;">
                        <p class="s2" style="line-height: 9pt;">'.$dados['pagador']['nome'].'</p>
                    </td>
                </tr>
            </table>
        </td>
        <td style="width: 200px;" class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Número do Documento</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2" style="line-height: 9pt;">'.$dados['pagador']['numeroInscricao'].'</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:19pt">
        <td class="position1" colspan="3">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Endereço</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;">
                        <p class="s2" style="line-height: 9pt;">'.$dados['pagador']['endereco'].'</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:19pt">
        <td class="position1" colspan="3">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Bairro / Distrito</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;">
                        <p class="s2" style="line-height: 9pt;">'.$dados['pagador']['bairro'].'</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:19pt">
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Munícipio</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;">
                        <p class="s2" style="line-height: 9pt;">'.$dados['pagador']['cidade'].'</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">UF</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2" style="line-height: 9pt;">'.$dados['pagador']['uf'].'</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">CEP</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2" style="line-height: 9pt;">'.$dados['pagador']['cep'].'</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<p style="text-align: left;"><br/></p>
<table style="border-collapse:collapse;margin-left:6pt" cellspacing="0">
    <tr style="height:20pt">
        <td class="position7" style="width: 150px">
            <p style="text-align: center;">
                <img width="150" height="40" src="data:image/png;base64,'.$logo64.'"/>
            </p>
        </td>
        <td style="width: 100px;text-align: center;; vertical-align: middle" class="position4">
            <p class="s4" style="">'.$banking.'</p>
        </td>
        <td style="width: 450px;text-align: center;; vertical-align: middle" colspan="7" class="position8">
            <p class="s5" style="text-align: left;">'.$dados['resposta']['linhaDigitavel'].'</p>
        </td>
    </tr>
    <tr style="height:28pt">
        <td colspan="3" class="position1" >
            <p class="s1" style="line-height: 9pt;text-align: left;">Local de pagamento</p>
            <p class="s2" style="text-align: left;">PAGAVEL EM QUALQUER BANCO</p>
        </td>
        <td colspan="3" class="position1" bgcolor="#CCCCCC" >
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Vencimento</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2">'.date('d/m/Y',strtotime($dados['dataVencimento'])).'</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:28pt">
        <td colspan="3" class="position2">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left;">
                        <p class="s1" style="line-height: 9pt;">Beneficiário</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">'.$dados['beneficiarioFinal']['nome'].'</p>
                    </td>
                    <td style="text-align: right;">
                        <p class="s2">'.$dados['beneficiarioFinal']['numeroInscricao'].'</p>
                    </td>
                </tr>
            </table>
        </td>
        <td colspan="3" class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Agência / Conta</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2">'.$dados['resposta']['beneficiario']['agencia'] . ' - ' . $dados['resposta']['beneficiario']['contaCorrente'].'</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:28pt">
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Data do documento</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2">'.date('d/m/Y',strtotime($dados['dataEmissao'])).'</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">N. documento</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2">'.$dados['resposta']['numero'].'</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Espécie</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2">DM</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Aceite</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2">'.$dados['codigoAceite'].'</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Data processamento</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2">'.date('d/m/Y',strtotime($dados['dataEmissao'])).'</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position3">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Nosso número</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2">'.$dados['resposta']['numero'].'</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:27pt">
        <td class="position1" bgcolor="#CCCCCC">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Uso do Banco</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2"></p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Carteira</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2">'.$dados['numeroCarteira'].'</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Espécie</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2">R$</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Quantidade</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2">1</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Valor</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2">1,00</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Valor documento</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2">'.number_format($dados['valorOriginal'], 2, ',','.').'</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:30pt">
        <td class="position1" colspan="4" rowspan="3">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt;text-align: left;">Fique atento à data de vencimento!</p>
                        <p></br></p>
                        <p class="s1" style="line-height: 9pt;text-align: left;">Pagável em qualquer banco!</p>
                        <p></br></p>
                        <p class="s3" style="line-height: 9pt;text-align: left;">Boleto gerado '.date('d/m/Y', strtotime($dados['dataEmissao'])).'</p>
                        <p></br></p>
                        <p class="s3" style="line-height: 9pt;text-align: left;">Boleto gerado por Label System</p>
                    </td>
                    <td style="text-align: right;">';
                        if(!is_null($urlQrCode)){
                            $conteudo .= '<img id="qr-base64" class="center" alt="" width="120" height="120" src="data:image/png;base64,'.$urlQrCode.'">';
                        }
        $conteudo .= '</td>
                </tr>
            </table>
        </td>
        <td class="position1" colspan="2">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">(-) Desconto / Abatimento</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2"></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:30pt">
        <td class="position1"  colspan="2">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">(-) Outras deduções</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2"></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:30pt">
        <td class="position1"  colspan="2">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">(+) Mora / Multa</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2"></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:30pt">
        <td class="position1" colspan="4" style="text-align: left;" rowspan="2">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt;">Pagador:</p>
                        <p class="s2">'.$dados['pagador']['nome'].'</p>
                        <p class="s2">'.$dados['pagador']['endereco'].'</p>
                        <p class="s2">'.$dados['pagador']['cidade'] .' - '.$dados['pagador']['uf'].'</p>
                        <p class="s2" style="line-height: 9pt;text-align: left;">'.$dados['pagador']['bairro'].'</p>
                        <p class="s1" style="line-height: 9pt;text-align: left;">Beneficiário Final <span class="s2">'.$dados['beneficiarioFinal']['nome'].'</span></p>
                    </td>
                    <td colspan="2" style="text-align: right;">
                        <p><br/></p>
                        <p class="s2">'.$dados['pagador']['numeroInscricao'].'</p>
                        <p><br/></p>
                        <p class="s2">'.$dados['pagador']['cep'].'</p>
                        <p class="s2">'.$dados['beneficiarioFinal']['numeroInscricao'].'</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position13" colspan="2">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">(+) Outros acréscimos</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2"></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:30pt">
        <td class="position1" colspan="2">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">(=) Valor cobrado</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2"></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" style="margin-left:6pt; padding-top: 10px">
    <tr>
        <td>
            <img width="420" height="50" src="data:image/jpg;base64,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"/>
        </td>
    </tr>
</table>
</body>
</html>';
        $this->WriteHTML($conteudo);

        return $this->Output($path, 'F');
    }
}
