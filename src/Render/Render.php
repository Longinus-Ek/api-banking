<?php

namespace Longinus\Apibanking\Render;

use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Exception;
use Longinus\Apibanking\Traits\Arquivos;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Picqer\Barcode\BarcodeGeneratorPNG;

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
     * @throws MpdfException|Exception
     */
    public function generatePDF(array $boleto, string $path, string $banking, $urlQrCode = null)
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
        $generatorPNG = new BarcodeGeneratorPNG();
        $barcodePNG = $generatorPNG->getBarcode($dados['resposta']['codigoBarraNumerico'], $generatorPNG::TYPE_CODE_128, 3, 50, [0, 0, 0]);
        $barcode64 = base64_encode($barcodePNG);

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
            <img width="420" height="50" src="data:image/png;base64,'.$barcode64.'"/>
        </td>
    </tr>
</table>
</body>
</html>';
        $this->WriteHTML($conteudo);

        return $this->Output($path, 'F');
    }

    private function formatDocument($value)
    {
        $CPF_LENGTH = 11;
        $cnpj_cpf = preg_replace("/\D/", '', $value);

        if (strlen($cnpj_cpf) === $CPF_LENGTH) {
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
        }

        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
    }
}
